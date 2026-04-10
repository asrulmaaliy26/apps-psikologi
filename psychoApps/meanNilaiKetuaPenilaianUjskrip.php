<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($dfn['nilai_ketua']==0) { echo "0"." ";} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['at'] && $dfn['nilai_ketua'] >= $dt_grade['ab']) { echo  number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['bplust'] && $dfn['nilai_ketua'] >= $dt_grade['bplusb']) { echo number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['bt']  && $dfn['nilai_ketua'] >= $dt_grade['bb']) { echo number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['cplust'] && $dfn['nilai_ketua'] >= $dt_grade['cplusb']) { echo number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['ct'] && $dfn['nilai_ketua'] >= $dt_grade['cb']) { echo number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dfn['nilai_ketua'] <= $dt_grade['dt'] && $dfn['nilai_ketua'] >= $dt_grade['db']) {echo number_format((float)$dfn['nilai_ketua'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
