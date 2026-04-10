<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($dfn['nilai_sekretaris']==0) { echo "0"." ";} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['at'] && $dfn['nilai_sekretaris'] >= $dt_grade['ab']) { echo  number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['bplust'] && $dfn['nilai_sekretaris'] >= $dt_grade['bplusb']) { echo number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['bt']  && $dfn['nilai_sekretaris'] >= $dt_grade['bb']) { echo number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['cplust'] && $dfn['nilai_sekretaris'] >= $dt_grade['cplusb']) { echo number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['ct'] && $dfn['nilai_sekretaris'] >= $dt_grade['cb']) { echo number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dfn['nilai_sekretaris'] <= $dt_grade['dt'] && $dfn['nilai_sekretaris'] >= $dt_grade['db']) {echo number_format((float)$dfn['nilai_sekretaris'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
