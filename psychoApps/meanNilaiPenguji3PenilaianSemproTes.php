<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  if($dfn['nilai_penguji3']=='0') { echo "0"." ";}
  elseif(is_array($dt_grade) && $dfn['nilai_penguji3'] <= $dt_grade['lt'] && $dfn['nilai_penguji3'] >= $dt_grade['lb']) {
  echo number_format((float)$dfn['nilai_penguji3'], 2, '.', '').' '.'Lanjut';}
  elseif(is_array($dt_grade) && $dfn['nilai_penguji3'] <= $dt_grade['lrt'] && $dfn['nilai_penguji3'] >= $dt_grade['lrb']) { echo number_format((float)$dfn['nilai_penguji3'], 2, '.', '').' '.'Lanjut (Revisi)';} 
  elseif(is_array($dt_grade) && $dfn['nilai_penguji3'] <= $dt_grade['sut'] && $dfn['nilai_penguji3'] >= $dt_grade['sub']) { echo number_format((float)$dfn['nilai_penguji3'], 2, '.', '').' '.'Seminar Ulang';}
  elseif(!empty($dfn['nilai_penguji3'])) { echo number_format((float)$dfn['nilai_penguji3'], 2, '.', '');}
echo '</span>';?>