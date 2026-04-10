<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$dpenguji1['nama'].'">';
  if($dnilai['nilai_penguji1']=='0') { echo "0"." ";}
  elseif($dnilai['nilai_penguji1'] <= $dt_grade['lt'] && $dnilai['nilai_penguji1'] >= $dt_grade['lb']) {
  echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'<small>Lanjut</small>';}
  elseif($dnilai['nilai_penguji1'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji1'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'<small>Lanjut (Revisi)</small>';} 
  elseif($dnilai['nilai_penguji1'] <= $dt_grade['sut'] && $dnilai['nilai_penguji1'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'<small>Seminar Ulang</small>';}
echo '</span>';?>