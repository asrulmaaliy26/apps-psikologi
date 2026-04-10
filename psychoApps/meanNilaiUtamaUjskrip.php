<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.$dutama['nama'].'">';
  if($dnilai['nilai_utama']==0) { echo "0"." ";} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['at'] && $dnilai['nilai_utama'] >= $dt_grade['ab']) { echo  number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['bplust'] && $dnilai['nilai_utama'] >= $dt_grade['bplusb']) { echo number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['bt']  && $dnilai['nilai_utama'] >= $dt_grade['bb']) { echo number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['cplust'] && $dnilai['nilai_utama'] >= $dt_grade['cplusb']) { echo number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['ct'] && $dnilai['nilai_utama'] >= $dt_grade['cb']) { echo number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dnilai['nilai_utama'] <= $dt_grade['dt'] && $dnilai['nilai_utama'] >= $dt_grade['db']) {echo number_format((float)$dnilai['nilai_utama'], 2, '.', ''). ' (D)'.' ';}
echo '</span>';?>
