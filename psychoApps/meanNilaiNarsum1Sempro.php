<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.(isset($dnarsum1['nama']) ? $dnarsum1['nama'] : '').'">';
  if(empty($dnilai) || $dnilai['nilai_narsum1']=='0') { echo "0"." ";}
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum1'] <= $dt_grade['lt'] && $dnilai['nilai_narsum1'] >= $dt_grade['lb']) {
  echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Lanjut';}
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum1'] <= $dt_grade['lrt'] && $dnilai['nilai_narsum1'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Lanjut (Revisi)';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_narsum1'] <= $dt_grade['sut'] && $dnilai['nilai_narsum1'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '').' '.'Seminar Ulang';}
  elseif(!empty($dnilai['nilai_narsum1'])) { echo number_format((float)$dnilai['nilai_narsum1'], 2, '.', '');}
echo '</span>';?>