<?php include( "contentsConAdm.php" );
  if($dt_nilai['mean_nilai']==0) { echo "0"." ";} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['lt'] && $dt_nilai['mean_nilai'] >= $dt_grade['lb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (Lanjut)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['lrt'] && $dt_nilai['mean_nilai'] >= $dt_grade['lrb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (Lanjut-Revisi)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['sut']  && $dt_nilai['mean_nilai'] >= $dt_grade['sub']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (Seminar Ulang)'.' ';}?>