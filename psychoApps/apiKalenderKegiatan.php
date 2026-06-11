<?php
include("conAdm.php"); // Load session and db connection without blocking

header('Content-Type: application/json');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$response = ['status' => 'error', 'message' => 'Invalid action'];

$isLoggedIn = !empty($_SESSION['username']);
$isAdminUtama = false;
if ($isLoggedIn) {
    $isAdminUtama = (isset($_SESSION['level']) && ($_SESSION['level'] === 'adminutama' || $_SESSION['level'] == 10));
    if (!$isAdminUtama && isset($_SESSION['username'])) {
        $username_esc = mysqli_real_escape_string($con, $_SESSION['username']);
        $q_auth = mysqli_query($con, "SELECT jabatan_instansi FROM dt_pegawai WHERE id='$username_esc' LIMIT 1");
        if ($q_auth && mysqli_num_rows($q_auth) > 0) {
            $d_auth = mysqli_fetch_assoc($q_auth);
            $jab = $d_auth['jabatan_instansi'];
            if ($jab === '1' || $jab === '3' || $jab === '28') {
                $isAdminUtama = true;
            }
        }
    }
}

// Modifying actions require login
$modifying_actions = ['add', 'update', 'delete', 'save_files'];
if (in_array($action, $modifying_actions) && !$isLoggedIn) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired, silakan login kembali.']);
    exit();
}

// Helper: current user identity (used for created_by check)
function kalenderCurrentUserCreatedByName()
{
    if (isset($_SESSION['nm_person']) && $_SESSION['nm_person'] !== '') return $_SESSION['nm_person'];
    if (isset($_SESSION['username']) && $_SESSION['username'] !== '') return $_SESSION['username'];
    return 'Admin';
}

// Helper: ensure directory exists
function ensureDir($dir)
{
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0775, true)) {
            return false;
        }
    }
    return true;
}

// Helper: sanitize filename
function sanitizeFileName($name)
{
    $name = preg_replace('~[^A-Za-z0-9._-]+~', '_', (string)$name);
    $name = trim($name, '._-');
    return $name !== '' ? $name : 'file';
}

// Helper: get kegiatan by id (for permission)
function getKegiatanRow($con, $kegiatanId)
{
    $kegiatanId = intval($kegiatanId);
    $kegiatanId = mysqli_real_escape_string($con, (string)$kegiatanId);
    $q = mysqli_query($con, "SELECT id, created_by FROM kalender_kegiatan WHERE id = $kegiatanId LIMIT 1");
    return $q ? mysqli_fetch_assoc($q) : null;
}

// ==========================
// fetch calendar events
// ==========================
if ($action == 'fetch') {
    // FullCalendar passes start and end as GET parameters (ISO8601)
    $start = isset($_GET['start']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_GET['start']))) : '1970-01-01';
    $end = isset($_GET['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_GET['end']))) : '2099-12-31';

    // Overlap query: event overlaps with view if it starts before view ends AND ends after view starts
    $query = "SELECT id, title, description, tempat, penanggung_jawab, start_date as start, end_date as end, color, created_by 
              FROM kalender_kegiatan 
              WHERE start_date <= '$end' AND end_date >= '$start'";

    $result = mysqli_query($con, $query);

    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $startDate = strtotime($row['start']);
        $endDate = strtotime($row['end']);

        $startDay = date('Y-m-d', $startDate);
        $endDay = date('Y-m-d', $endDate);

        // FullCalendar all-day end must be exclusive (+1 day)
        $endExclusive = date('Y-m-d', strtotime($endDay . ' +1 day'));

        $events[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'tempat' => $row['tempat'],
            'penanggung_jawab' => $row['penanggung_jawab'],
            'start' => $startDay,
            'end' => $endExclusive,
            'color' => $row['color'],
            'created_by' => $row['created_by'],
            'allDay' => true,
            'realStart' => $row['start'],
            'realEnd' => $row['end']
        ];
    }

    echo json_encode($events);
    exit();
}

// ==========================
// fetch uploaded files for one kegiatan
// ==========================
if ($action == 'fetch_files') {
    $kegiatan_id = isset($_REQUEST['kegiatan_id']) ? intval($_REQUEST['kegiatan_id']) : 0;
    if ($kegiatan_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'kegiatan_id wajib diisi']);
        exit();
    }

    $kegiatanRow = getKegiatanRow($con, $kegiatan_id);
    if (!$kegiatanRow) {
        echo json_encode(['status' => 'error', 'message' => 'Kegiatan tidak ditemukan']);
        exit();
    }

    $kegiatan_id_esc = mysqli_real_escape_string($con, (string)$kegiatan_id);
    // Pastikan permission juga berlaku untuk setiap file
    // (backend akan mengembalikan file hanya jika kegiatan boleh diakses)
    $qFiles = mysqli_query(
        $con,
        "SELECT id, file_name, file_path, file_desc, created_at, created_by 
         FROM kalender_kegiatan_files 
         WHERE kegiatan_id = $kegiatan_id_esc 
         ORDER BY id DESC"
    );


    $files = [];
    if ($qFiles) {
        while ($row = mysqli_fetch_assoc($qFiles)) {
            $files[] = [
                'id' => $row['id'],
                'file_name' => $row['file_name'],
                'file_path' => $row['file_path'],
                'file_desc' => $row['file_desc'],
                'created_at' => $row['created_at'],
                'created_by' => $row['created_by']
            ];
        }
    }

    echo json_encode(['status' => 'success', 'files' => $files]);
    exit();
}

// ==========================
// save uploaded files for one kegiatan (multi upload)
// ==========================
if ($action == 'save_files') {
    $kegiatan_id = isset($_POST['kegiatan_id']) ? intval($_POST['kegiatan_id']) : 0;

    // requirement: 1 file = 1 deskripsi
    // UI mengirim arrays: file_descs[] dan files[] (1 file per input)
    $file_descs = isset($_POST['file_descs']) ? (array)$_POST['file_descs'] : [];

    if ($kegiatan_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'kegiatan_id wajib diisi']);
        exit();
    }

    if (!isset($_FILES['files']) || empty($_FILES['files']['name'])) {
        echo json_encode(['status' => 'error', 'message' => 'Tidak ada file yang diupload']);
        exit();
    }

    $kegiatanRow = getKegiatanRow($con, $kegiatan_id);
    if (!$kegiatanRow) {
        echo json_encode(['status' => 'error', 'message' => 'Kegiatan tidak ditemukan']);
        exit();
    }

    $canUpload = $isAdminUtama;
    if (!$canUpload) {
        $userName = kalenderCurrentUserCreatedByName();
        $canUpload = ($kegiatanRow['created_by'] === $userName);
    }

    if (!$canUpload) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: tidak punya akses upload']);
        exit();
    }

    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'kalender_kegiatan_files' . DIRECTORY_SEPARATOR . $kegiatan_id;
    if (!ensureDir($baseDir)) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal membuat folder upload']);
        exit();
    }

    $savedCount = 0;
    $count = count($_FILES['files']['name']);

    $created_by_db = mysqli_real_escape_string($con, kalenderCurrentUserCreatedByName());


    for ($i = 0; $i < $count; $i++) {
        if (empty($_FILES['files']['name'][$i])) continue;

        $origName = $_FILES['files']['name'][$i];
        $tmpPath = $_FILES['files']['tmp_name'][$i];
        $error = $_FILES['files']['error'][$i];

        if ($error !== UPLOAD_ERR_OK) continue;

        // $safeName = sanitizeFileName($origName);
        // $uniquePrefix = uniqid('k' . $kegiatan_id . '_', true);
        // $finalName = $safeName . '_' . $uniquePrefix;
        $pathInfo = pathinfo($origName);

        $fileNameOnly = sanitizeFileName($pathInfo['filename']);
        $fileExt = isset($pathInfo['extension']) ? '.' . strtolower($pathInfo['extension']) : '';

        $uniquePrefix = uniqid('k' . $kegiatan_id . '_', true);

        $finalName = $fileNameOnly . '_' . $uniquePrefix . $fileExt;

        $destPath = $baseDir . DIRECTORY_SEPARATOR . $finalName;
        if (!move_uploaded_file($tmpPath, $destPath)) {
            continue;
        }

        $file_path_relative = 'psychoApps/kalender_kegiatan_files/' . $kegiatan_id . '/' . $finalName;

        $file_name_db = mysqli_real_escape_string($con, $finalName);
        $file_path_db = mysqli_real_escape_string($con, $file_path_relative);

        $descForThisFile = isset($file_descs[$i]) ? $file_descs[$i] : '';
        $file_desc_db = mysqli_real_escape_string($con, (string)$descForThisFile);

        $ins = mysqli_query(
            $con,
            "INSERT INTO kalender_kegiatan_files (kegiatan_id, file_name, file_path, file_desc, created_by) VALUES (
                $kegiatan_id,
                '$file_name_db',
                '$file_path_db',
                '$file_desc_db',
                '$created_by_db'
            )"
        );

        if ($ins) {
            $savedCount++;
        }
    }

    if ($savedCount === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Upload gagal atau file tidak valid']);
        exit();
    }

    echo json_encode(['status' => 'success', 'message' => 'Lampiran berhasil disimpan', 'count' => $savedCount]);
    exit();
}

// ==========================
// add kegiatan
// ==========================
if ($action == 'add') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, isset($_POST['description']) ? $_POST['description'] : '');
    $tempat = mysqli_real_escape_string($con, isset($_POST['tempat']) ? $_POST['tempat'] : '');
    $penanggung_jawab = mysqli_real_escape_string($con, isset($_POST['penanggung_jawab']) ? $_POST['penanggung_jawab'] : '');
    $start_date = mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['start'])));
    $end_date = !empty($_POST['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['end']))) : $start_date;
    $color = mysqli_real_escape_string($con, isset($_POST['color']) ? $_POST['color'] : '#3c8dbc');

    $created_by_name = isset($_SESSION['nm_person']) ? $_SESSION['nm_person'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin');
    $created_by = mysqli_real_escape_string($con, $created_by_name);

    $query = "INSERT INTO kalender_kegiatan (title, description, tempat, penanggung_jawab, start_date, end_date, color, created_by) 
              VALUES ('$title', '$description', '$tempat', '$penanggung_jawab', '$start_date', '$end_date', '$color', '$created_by')";

    if (mysqli_query($con, $query)) {
        $response = ['status' => 'success', 'message' => 'Kegiatan ditambahkan', 'id' => mysqli_insert_id($con)];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }

    echo json_encode($response);
    exit();
}

// ==========================
// update kegiatan
// ==========================
if ($action == 'update') {
    // Only Admin Utama can update events
    if (!$isAdminUtama) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only Admin Utama can edit activities.']);
        exit();
    }

    $id = intval($_POST['id']);

    // Check if this is just a drag-and-drop time update or full update
    if (isset($_POST['is_drag'])) {
        $start_date = mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['start'])));
        $end_date = !empty($_POST['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['end']))) : $start_date;
        $query = "UPDATE kalender_kegiatan SET start_date='$start_date', end_date='$end_date' WHERE id=$id";
    } else {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $description = mysqli_real_escape_string($con, isset($_POST['description']) ? $_POST['description'] : '');
        $tempat = mysqli_real_escape_string($con, isset($_POST['tempat']) ? $_POST['tempat'] : '');
        $penanggung_jawab = mysqli_real_escape_string($con, isset($_POST['penanggung_jawab']) ? $_POST['penanggung_jawab'] : '');
        $start_date = mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['start'])));
        $end_date = !empty($_POST['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['end']))) : $start_date;
        $color = mysqli_real_escape_string($con, isset($_POST['color']) ? $_POST['color'] : '#3c8dbc');
        $query = "UPDATE kalender_kegiatan SET title='$title', description='$description', tempat='$tempat', penanggung_jawab='$penanggung_jawab', start_date='$start_date', end_date='$end_date', color='$color' WHERE id=$id";
    }

    if (mysqli_query($con, $query)) {
        $response = ['status' => 'success', 'message' => 'Kegiatan diperbarui'];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }

    echo json_encode($response);
    exit();
}

// ==========================
// delete kegiatan (also best-effort cleanup folder)
// ==========================
if ($action == 'delete') {
    // Only Admin Utama can delete events
    if (!$isAdminUtama) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only Admin Utama can delete activities.']);
        exit();
    }

    $id = intval($_POST['id']);
    $query = "DELETE FROM kalender_kegiatan WHERE id=$id";

    if (mysqli_query($con, $query)) {
        // Best effort: remove physical uploaded files folder (db FK will handle records)
        $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'kalender_kegiatan_files' . DIRECTORY_SEPARATOR . $id;
        if (is_dir($baseDir)) {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($it as $fileinfo) {
                $todoPath = $fileinfo->getRealPath();
                if (is_file($todoPath) || is_link($todoPath)) {
                    @unlink($todoPath);
                } elseif (is_dir($todoPath)) {
                    @rmdir($todoPath);
                }
            }
            @rmdir($baseDir);
        }

        $response = ['status' => 'success', 'message' => 'Kegiatan dihapus'];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }

    echo json_encode($response);
    exit();
}

// fallback
echo json_encode($response);
