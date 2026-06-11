<?php
require 'db_env.php';
list($h, $u, $p, $d) = psycho_db_config();
$c = new mysqli($h, $u, $p, $d);
$tables = ['pengajuan_dospem', 'pengelompokan_dospem_skripsi', 'dospem_skripsi'];
foreach($tables as $t) {
    echo "TABLE: $t\n";
    $r = $c->query("DESCRIBE $t");
    while($row = $r->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    echo "\n";
}
?>
