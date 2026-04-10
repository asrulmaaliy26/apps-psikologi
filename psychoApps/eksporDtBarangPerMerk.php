<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  require 'vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  
  $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$id'";
  $r_merk = mysqli_query($con, $qry_merk);
  $d_merk = mysqli_fetch_assoc($r_merk);
  
  $qnl = "SELECT * FROM nama_lembaga";
  $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
  $dnl = mysqli_fetch_assoc( $resnl );
  $nm_lembaga = $dnl['nm'];
  
  $qnli = "SELECT * FROM nama_lembaga_induk";
  $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
  $dnli = mysqli_fetch_assoc( $resnli );
  $nm_lembaga_induk = $dnli['nm'];
  
  $q_pejabat="SELECT * FROM dt_pegawai WHERE jabatan_instansi='28'";
  $r_pejabat=mysqli_query($con, $q_pejabat) or die (mysqli_error($con));
  $d_pejabat=mysqli_fetch_assoc($r_pejabat);
  
  $q_nm_jbtn="SELECT * FROM opsi_jabatan_instansi WHERE id='$d_pejabat[jabatan_instansi]'";
  $r_nm_jbtn=mysqli_query($con, $q_nm_jbtn) or die (mysqli_error($con));
  $d_nm_jbtn=mysqli_fetch_assoc($r_nm_jbtn);
  
  $sheet->setCellValue('A1', 'No');
  $sheet->setCellValue('B1', 'Kode Barang (U)');
  $sheet->setCellValue('C1', 'Kode Barang (F)');
  $sheet->setCellValue('D1', 'Nama Barang');
  $sheet->setCellValue('E1', 'Merk');
  $sheet->setCellValue('F1', 'Tgl. Perolehan');
  $sheet->setCellValue('G1', 'Sumber Dana');
  $sheet->setCellValue('H1', 'Letak');
  $sheet->setCellValue('I1', 'Kondisi');
  
  $qry_dbr = "SELECT * FROM dt_inventaris_barang WHERE merk='$id' ORDER BY DATE(tgl_perolehan) DESC";
  $r_dbr = mysqli_query($con, $qry_dbr);
  $i = 2;
  $no = 1;
  WHILE($d_dbr = mysqli_fetch_array($r_dbr)) {
  
  $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$d_dbr[merk]'";
  $r_merk = mysqli_query($con, $qry_merk);
  $d_merk = mysqli_fetch_assoc($r_merk);
                             
  $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$d_dbr[kondisi]'";
  $r_kondisi = mysqli_query($con, $qry_kondisi);
  $d_kondisi = mysqli_fetch_assoc($r_kondisi);
          
  $qry_sumber_dn = "SELECT * FROM opsi_sumber_dana_perolehan_barang WHERE id='$d_dbr[sumber_dana]'";
  $r_sumber_dn = mysqli_query($con, $qry_sumber_dn);
  $d_sumber_dn = mysqli_fetch_assoc($r_sumber_dn);
          
  $qry_dir = "SELECT * FROM dt_ruang WHERE id='$d_dbr[letak]'";
  $r_dir = mysqli_query($con, $qry_dir);
  $d_dir = mysqli_fetch_assoc($r_dir);
  
  $sheet->setCellValue('A'.$i, $no++);
  $sheet->setCellValue('B'.$i, $d_dbr['id_inventaris_pusat']);
  $sheet->setCellValue('C'.$i, $d_dbr['id_inventaris']);
  $sheet->setCellValue('D'.$i, $d_dbr['nm']);
  $sheet->setCellValue('E'.$i, $d_merk['nm']);    
  $sheet->setCellValue('F'.$i, $d_dbr['tgl_perolehan']);
  $sheet->setCellValue('G'.$i, $d_sumber_dn['nm']);
  $sheet->setCellValue('H'.$i, $d_dir['nm']);
  $sheet->setCellValue('I'.$i, $d_kondisi['nm']);      
  $i++;
  }
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Data Barang Merk '.$d_merk['nm'].'.xlsx"'); 
  header('Cache-Control: max-age=0');
  $writer->save('php://output');
  ?>