<?php
include("contentsConAdm.php"); // Ensure user is logged in
header('Content-Type: application/json');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$response = ['status' => 'error', 'message' => 'Invalid action'];

// Check if user is Admin Utama
$isAdminUtama = (isset($_SESSION['level']) && ($_SESSION['level'] === 'adminutama' || $_SESSION['level'] == 10));

if ($action == 'fetch') {
    // FullCalendar passes start and end as GET parameters (ISO8601)
    $start = isset($_GET['start']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_GET['start']))) : '1970-01-01';
    $end = isset($_GET['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_GET['end']))) : '2099-12-31';

    // Overlap query: event overlaps with view if it starts before view ends AND ends after view starts
    $query = "SELECT id, title, description, start_date as start, end_date as end, color, created_by 
              FROM kalender_kegiatan 
              WHERE start_date <= '$end' AND end_date >= '$start'";
              
    $result = mysqli_query($con, $query);
    
    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $startDate = strtotime($row['start']);
        $endDate = strtotime($row['end']);
        
        $startDay = date('Y-m-d', $startDate);
        $endDay = date('Y-m-d', $endDate);
        
        // For all-day events rendering in FullCalendar, the end date must be exclusive (+1 day).
        $endExclusive = date('Y-m-d', strtotime($endDay . ' +1 day'));
        
        $events[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
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

} elseif ($action == 'add') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, isset($_POST['description']) ? $_POST['description'] : '');
    $start_date = mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['start'])));
    $end_date = !empty($_POST['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['end']))) : $start_date;
    $color = mysqli_real_escape_string($con, isset($_POST['color']) ? $_POST['color'] : '#3c8dbc');
    
    $created_by_name = isset($_SESSION['nm_person']) ? $_SESSION['nm_person'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin');
    $created_by = mysqli_real_escape_string($con, $created_by_name);
    
    $query = "INSERT INTO kalender_kegiatan (title, description, start_date, end_date, color, created_by) 
              VALUES ('$title', '$description', '$start_date', '$end_date', '$color', '$created_by')";
              
    if (mysqli_query($con, $query)) {
        $response = ['status' => 'success', 'message' => 'Kegiatan ditambahkan', 'id' => mysqli_insert_id($con)];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }
    
    echo json_encode($response);
    exit();

} elseif ($action == 'update') {
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
        $start_date = mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['start'])));
        $end_date = !empty($_POST['end']) ? mysqli_real_escape_string($con, date('Y-m-d H:i:s', strtotime($_POST['end']))) : $start_date;
        $color = mysqli_real_escape_string($con, isset($_POST['color']) ? $_POST['color'] : '#3c8dbc');
        $query = "UPDATE kalender_kegiatan SET title='$title', description='$description', start_date='$start_date', end_date='$end_date', color='$color' WHERE id=$id";
    }
    
    if (mysqli_query($con, $query)) {
        $response = ['status' => 'success', 'message' => 'Kegiatan diperbarui'];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }
    
    echo json_encode($response);
    exit();

} elseif ($action == 'delete') {
    // Only Admin Utama can delete events
    if (!$isAdminUtama) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only Admin Utama can delete activities.']);
        exit();
    }

    $id = intval($_POST['id']);
    $query = "DELETE FROM kalender_kegiatan WHERE id=$id";
    
    if (mysqli_query($con, $query)) {
        $response = ['status' => 'success', 'message' => 'Kegiatan dihapus'];
    } else {
        $response = ['status' => 'error', 'message' => mysqli_error($con)];
    }
    
    echo json_encode($response);
    exit();
}

echo json_encode($response);
?>

