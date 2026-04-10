<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($dfn['nilai_utama']==0) { echo "0"." ";} 
  elseif($dfn['nilai_utama'] <= $dt_grade['at'] && $dfn['nilai_utama'] >= $dt_grade['ab']) { echo  number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dfn['nilai_utama'] <= $dt_grade['bplust'] && $dfn['nilai_utama'] >= $dt_grade['bplusb']) { echo number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dfn['nilai_utama'] <= $dt_grade['bt']  && $dfn['nilai_utama'] >= $dt_grade['bb']) { echo number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dfn['nilai_utama'] <= $dt_grade['cplust'] && $dfn['nilai_utama'] >= $dt_grade['cplusb']) { echo number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dfn['nilai_utama'] <= $dt_grade['ct'] && $dfn['nilai_utama'] >= $dt_grade['cb']) { echo number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dfn['nilai_utama'] <= $dt_grade['dt'] && $dfn['nilai_utama'] >= $dt_grade['db']) {echo number_format((float)$dfn['nilai_utama'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
