<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$dsekretaris['nama'].'">';
  if($dnilai['nilai_sekretaris']==0) { echo "0"." ";} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['at'] && $dnilai['nilai_sekretaris'] >= $dt_grade['ab']) { echo  number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['bplust'] && $dnilai['nilai_sekretaris'] >= $dt_grade['bplusb']) { echo number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['bt']  && $dnilai['nilai_sekretaris'] >= $dt_grade['bb']) { echo number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['cplust'] && $dnilai['nilai_sekretaris'] >= $dt_grade['cplusb']) { echo number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['ct'] && $dnilai['nilai_sekretaris'] >= $dt_grade['cb']) { echo number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dnilai['nilai_sekretaris'] <= $dt_grade['dt'] && $dnilai['nilai_sekretaris'] >= $dt_grade['db']) {echo number_format((float)$dnilai['nilai_sekretaris'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
