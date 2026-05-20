<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.(isset($dpenguji3['nama']) ? $dpenguji3['nama'] : '').'">';
  if(empty($dnilai) || $dnilai['nilai_penguji3']=='0') { echo "0"." ";}
  elseif(is_array($dt_grade) && $dnilai['nilai_penguji3'] <= $dt_grade['lt'] && $dnilai['nilai_penguji3'] >= $dt_grade['lb']) {
  echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'<small>Lanjut</small>';}
  elseif(is_array($dt_grade) && $dnilai['nilai_penguji3'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji3'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'<small>Lanjut (Revisi)</small>';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_penguji3'] <= $dt_grade['sut'] && $dnilai['nilai_penguji3'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'<small>Seminar Ulang</small>';}
  elseif(!empty($dnilai['nilai_penguji3'])) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '');}
echo '</span>';?>