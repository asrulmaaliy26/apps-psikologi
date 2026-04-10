<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($dfn['mean_nilai_penguji3']==0) { echo "0"." ";} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['at'] && $dfn['mean_nilai_penguji3'] >= $dt_grade['ab']) { echo  number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['bplust'] && $dfn['mean_nilai_penguji3'] >= $dt_grade['bplusb']) { echo number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['bt']  && $dfn['mean_nilai_penguji3'] >= $dt_grade['bb']) { echo number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['cplust'] && $dfn['mean_nilai_penguji3'] >= $dt_grade['cplusb']) { echo number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['ct'] && $dfn['mean_nilai_penguji3'] >= $dt_grade['cb']) { echo number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dfn['mean_nilai_penguji3'] <= $dt_grade['dt'] && $dfn['mean_nilai_penguji3'] >= $dt_grade['db']) {echo number_format((float)$dfn['mean_nilai_penguji3'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>