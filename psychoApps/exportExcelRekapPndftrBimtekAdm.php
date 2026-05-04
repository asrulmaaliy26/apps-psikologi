<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
  $id_bimtek = isset($_GET['id_bimtek']) ? mysqli_real_escape_string($con, $_GET['id_bimtek']) : "";
  $peminatan_filter = isset($_GET['peminatan']) ? mysqli_real_escape_string($con, $_GET['peminatan']) : "";
  $sort = isset($_GET['sort']) ? $_GET['sort'] : "tgl_daftar";
  
  if(!$id_bimtek) {
      die("ID Bimtek tidak valid.");
  }
  
  require 'vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  
  $q_bim = mysqli_query($con, "SELECT nama_bimtek FROM bimtek_pendaftaran WHERE id='$id_bimtek'");
  $d_bim = mysqli_fetch_assoc($q_bim);
  $nama_periode = $d_bim['nama_bimtek'];
  
  $sheet->setCellValue('A1', 'No');
  $sheet->setCellValue('B1', 'NIM');
  $sheet->setCellValue('C1', 'Nama Mahasiswa');
  $sheet->setCellValue('D1', 'Peminatan');
  $sheet->setCellValue('E1', 'Tgl Daftar');
  
  $filter_sql = " WHERE pb.id_bimtek = '$id_bimtek' ";
  if($peminatan_filter != ""){
      $filter_sql .= " AND pb.peminatan = '$peminatan_filter' ";
  }

  $order_sql = "ORDER BY pb.tgl_daftar DESC";
  if($sort == "nim"){
      $order_sql = "ORDER BY pb.nim ASC";
  } else if($sort == "nama"){
      $order_sql = "ORDER BY m.nama ASC";
  }

  $query = "SELECT pb.*, m.nama, b.nama_bimtek, ops.nm as nm_peminatan 
            FROM bimtek_peserta pb 
            JOIN (SELECT MAX(id) as max_id FROM bimtek_peserta GROUP BY nim, id_bimtek) latest ON pb.id = latest.max_id
            JOIN dt_mhssw m ON pb.nim = m.nim 
            JOIN bimtek_pendaftaran b ON pb.id_bimtek = b.id
            JOIN opsi_bidang_skripsi ops ON pb.peminatan = ops.id
            $filter_sql
            $order_sql";
            
  $result = mysqli_query($con, $query);
  $i = 2;
  $no = 1;
  while($row = mysqli_fetch_array($result)){
      $sheet->setCellValue('A'.$i, $no++);
      $sheet->setCellValueExplicit('B'.$i, $row['nim'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValue('C'.$i, $row['nama']);
      $sheet->setCellValue('D'.$i, $row['nm_peminatan']);
      $sheet->setCellValue('E'.$i, $row['tgl_daftar']);
      $i++;
  }
  
  foreach(range('A','E') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
  }
  
  $sheet->getStyle('A1:E1')->getFont()->setBold(true);
  
  $writer = new Xlsx($spreadsheet);
  ob_end_clean();
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Rekap Pendaftar Bimtek - '.$nama_periode.'.xlsx"'); 
  header('Cache-Control: max-age=0');
  $writer->save('php://output');
?>
