<?php include( "contentsConAdm.php" );
  if($dt_nilai['nilai_narsum1']==0) { echo "0"." ";} 
  elseif($dt_nilai['nilai_narsum1'] <= $dt_grade['lt'] && $dt_nilai['nilai_narsum1'] >= $dt_grade['lb']) { echo number_format((float)$dt_nilai['nilai_narsum1'], 2, '.', ''). ' (Lanjut)'.' ';} 
  elseif($dt_nilai['nilai_narsum1'] <= $dt_grade['lrt'] && $dt_nilai['nilai_narsum1'] >= $dt_grade['lrb']) { echo number_format((float)$dt_nilai['nilai_narsum1'], 2, '.', ''). ' (Lanjut-Revisi)'.' ';} 
  elseif($dt_nilai['nilai_narsum1'] <= $dt_grade['sut']  && $dt_nilai['nilai_narsum1'] >= $dt_grade['sub']) { echo number_format((float)$dt_nilai['nilai_narsum1'], 2, '.', ''). ' (Seminar Ulang)'.' ';}?>