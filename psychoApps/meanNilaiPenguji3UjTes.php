<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$dpenguji3['nama'].'">';
  if($dnilai['mean_nilai_penguji3']==0) { echo "0"." ";} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['at'] && $dnilai['mean_nilai_penguji3'] >= $dt_grade['ab']) { echo  number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['bplust'] && $dnilai['mean_nilai_penguji3'] >= $dt_grade['bplusb']) { echo number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['bt']  && $dnilai['mean_nilai_penguji3'] >= $dt_grade['bb']) { echo number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['cplust'] && $dnilai['mean_nilai_penguji3'] >= $dt_grade['cplusb']) { echo number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['ct'] && $dnilai['mean_nilai_penguji3'] >= $dt_grade['cb']) { echo number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dnilai['mean_nilai_penguji3'] <= $dt_grade['dt'] && $dnilai['mean_nilai_penguji3'] >= $dt_grade['db']) {echo number_format((float)$dnilai['mean_nilai_penguji3'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
