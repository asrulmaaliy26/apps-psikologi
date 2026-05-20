<?php include( "contentsConAdm.php" );
  if($dt_nilai['nilai_narsum2']==0) { echo "0"." ";} 
  elseif(is_array($dt_grade) && $dt_nilai['nilai_narsum2'] <= $dt_grade['lt'] && $dt_nilai['nilai_narsum2'] >= $dt_grade['lb']) { echo number_format((float)$dt_nilai['nilai_narsum2'], 2, '.', ''). ' (Lanjut)'.' ';} 
  elseif(is_array($dt_grade) && $dt_nilai['nilai_narsum2'] <= $dt_grade['lrt'] && $dt_nilai['nilai_narsum2'] >= $dt_grade['lrb']) { echo number_format((float)$dt_nilai['nilai_narsum2'], 2, '.', ''). ' (Lanjut-Revisi)'.' ';} 
  elseif(is_array($dt_grade) && $dt_nilai['nilai_narsum2'] <= $dt_grade['sut']  && $dt_nilai['nilai_narsum2'] >= $dt_grade['sub']) { echo number_format((float)$dt_nilai['nilai_narsum2'], 2, '.', ''). ' (Seminar Ulang)'.' ';}
  elseif(!empty($dt_nilai['nilai_narsum2'])) { echo number_format((float)$dt_nilai['nilai_narsum2'], 2, '.', '');}
?>