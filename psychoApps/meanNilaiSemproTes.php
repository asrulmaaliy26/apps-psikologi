<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($nilaiakhir=='0') { echo "0"." ";} 
  elseif($nilaiakhir <= $dt_grade['lt'] && $nilaiakhir >= $dt_grade['lb']) {
  echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Lanjut</small>';}
  elseif($nilaiakhir <= $dt_grade['lrt'] && $nilaiakhir >= $dt_grade['lrb']) { echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Lanjut (Revisi)</small>';} 
  elseif($nilaiakhir <= $dt_grade['sut'] && $nilaiakhir >= $dt_grade['sub']) { echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Seminar Ulang</small>';}
?>