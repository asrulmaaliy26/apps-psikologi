<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.(isset($dnarsum2['nama']) ? $dnarsum2['nama'] : '').'">';
  if(empty($dnilai) || $dnilai['nilai_narsum2']=='0') { echo "0"." ";}
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum2'] <= $dt_grade['lt'] && $dnilai['nilai_narsum2'] >= $dt_grade['lb']) {
  echo number_format((float)$dnilai['nilai_narsum2'], 2, '.', '').' '.'Lanjut';}
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum2'] <= $dt_grade['lrt'] && $dnilai['nilai_narsum2'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_narsum2'], 2, '.', '').' '.'Lanjut (Revisi)';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum2'] <= $dt_grade['sut'] && $dnilai['nilai_narsum2'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_narsum2'], 2, '.', '').' '.'Seminar Ulang';}
  elseif(!empty($dnilai['nilai_narsum2'])) { echo number_format((float)$dnilai['nilai_narsum2'], 2, '.', '');}
echo '</span>';?>