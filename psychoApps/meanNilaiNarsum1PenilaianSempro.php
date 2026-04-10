<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  if($dfn['nilai_narsum1']=='0') { echo "0"." ";}
  elseif($dfn['nilai_narsum1'] <= $dt_grade['lt'] && $dfn['nilai_narsum1'] >= $dt_grade['lb']) {
  echo number_format((float)$dfn['nilai_narsum1'], 2, '.', '').' '.'Lanjut';}
  elseif($dfn['nilai_narsum1'] <= $dt_grade['lrt'] && $dfn['nilai_narsum1'] >= $dt_grade['lrb']) { echo number_format((float)$dfn['nilai_narsum1'], 2, '.', '').' '.'Lanjut (Revisi)';} 
  elseif($dfn['nilai_narsum1'] <= $dt_grade['sut'] && $dfn['nilai_narsum1'] >= $dt_grade['sub']) { echo number_format((float)$dfn['nilai_narsum1'], 2, '.', '').' '.'Seminar Ulang';}
echo '</span>';?>