<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$dnarsum1['nama'].'">';
  if($dnilai['nilai_narsum1']=='0') { echo "0"." ";}
  elseif($dnilai['nilai_narsum1'] <= $dt_grade['lt'] && $dnilai['nilai_narsum1'] >= $dt_grade['lb']) {
  echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Lanjut';}
  elseif($dnilai['nilai_narsum1'] <= $dt_grade['lrt'] && $dnilai['nilai_narsum1'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Lanjut (Revisi)';} 
  elseif($dnilai['nilai_narsum1'] <= $dt_grade['sut'] && $dnilai['nilai_narsum1'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Seminar Ulang';}
echo '</span>';?>