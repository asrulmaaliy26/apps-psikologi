<?php include( "contentsConAdm.php" );
  $mean_nilai = $dt_nilai['mean_nilai'] ?? 0;
  if($mean_nilai==0) { echo "0"." ";} 
  elseif(is_array($dt_grade) && $mean_nilai <= $dt_grade['lt'] && $mean_nilai >= $dt_grade['lb']) { echo number_format((float)$mean_nilai, 2, '.', ''). ' (Lanjut)'.' ';} 
  elseif(is_array($dt_grade) && $mean_nilai <= $dt_grade['lrt'] && $mean_nilai >= $dt_grade['lrb']) { echo number_format((float)$mean_nilai, 2, '.', ''). ' (Lanjut-Revisi)'.' ';} 
  elseif(is_array($dt_grade) && $mean_nilai <= $dt_grade['sut']  && $mean_nilai >= $dt_grade['sub']) { echo number_format((float)$mean_nilai, 2, '.', ''). ' (Seminar Ulang)'.' ';}
  elseif(!empty($mean_nilai)) { echo number_format((float)$mean_nilai, 2, '.', '');}
?>