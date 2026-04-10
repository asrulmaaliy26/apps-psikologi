<?php

/**
 * docs.php
 * Markdown Documentation Viewer
 */
$files = glob("*.md");
// Pindahkan user.md, alurtugasakhir.md, alurpengajuandospem.md, alurpengajuansurat.md, dokumentasi_fitur_per_role.md dll.
$requested = isset($_GET['file']) ? $_GET['file'] : (isset($files[0]) ? $files[0] : '');

$mdContent = "";
if (in_array($requested, $files) && file_exists($requested)) {
    $mdContent = file_get_contents($requested);
} else {
    $mdContent = "# File tidak ditenukan\n\nSilakan pilih dokumen dari menu di sebelah kiri.";
}

// Untuk judul tab
$title = "Dokumentasi - " . htmlspecialchars($requested);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Menggunakan CDN Github Markdown CSS agar tampilannya rapi seperti di Github -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown-light.min.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 300px;
            background-color: #343a40;
            color: #fff;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #4f5962;
            text-align: center;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: #c2c7d0;
            text-decoration: none;
            border-bottom: 1px solid #4f5962;
            transition: 0.2s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: #4f5962;
            color: #fff;
        }

        .back-btn {
            display: block;
            padding: 15px;
            background: #007bff;
            color: white !important;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            background: #0056b3;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
        }

        .markdown-body {
            box-sizing: border-box;
            min-width: 200px;
            max-width: 980px;
            margin: 0 auto;
            padding: 45px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 767px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                max-height: 50vh;
            }

            .content {
                padding: 15px;
            }

            .markdown-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>📚 Dokumentasi Sistem</h3>
        </div>
        <ul class="sidebar-menu">
            <?php foreach ($files as $file): ?>
                <?php
                $active = ($file === $requested) ? 'class="active"' : '';
                $name = str_replace('.md', '', $file);
                $name = ucwords(str_replace('_', ' ', $name));
                ?>
                <li><a href="?file=<?= urlencode($file) ?>" <?= $active ?>><?= htmlspecialchars($name) ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div style="flex-grow: 1;"></div>
        <a href="index.php" class="back-btn">← Kembali ke Login</a>
    </div>

    <div class="content">
        <div class="markdown-body" id="md-content">
            <!-- Markdown content rendered here -->
        </div>
    </div>

    <script>
        // Ambil isi raw markdown dari variabel php dan render
        const rawMd = <?= json_encode($mdContent) ?>;
        document.getElementById('md-content').innerHTML = marked.parse(rawMd);

        // Buka semua link di tab baru, kecuali link anchort (id)
        document.querySelectorAll('.markdown-body a').forEach(a => {
            if (!a.getAttribute('href').startsWith('#')) {
                a.setAttribute('target', '_blank');
            }
        });
    </script>

</body>

</html>