<?php include( "contentsConAdm.php" );
  if($dt_nilai['mean_nilai']==0) { echo "0"." ";} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['at'] && $dt_nilai['mean_nilai'] >= $dt_grade['ab']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['bplust'] && $dt_nilai['mean_nilai'] >= $dt_grade['bplusb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['bt']  && $dt_nilai['mean_nilai'] >= $dt_grade['bb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['cplust'] && $dt_nilai['mean_nilai'] >= $dt_grade['cplusb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['ct'] && $dt_nilai['mean_nilai'] >= $dt_grade['cb']) { echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dt_nilai['mean_nilai'] <= $dt_grade['dt'] && $dt_nilai['mean_nilai'] >= $dt_grade['db']) {echo number_format((float)$dt_nilai['mean_nilai'], 2, '.', ''). ' (D)'.' ';}?>