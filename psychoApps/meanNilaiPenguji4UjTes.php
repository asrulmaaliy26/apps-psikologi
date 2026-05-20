<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.(isset($dpenguji4['nama']) ? $dpenguji4['nama'] : '').'">';
  if(empty($dnilai) || $dnilai['mean_nilai_penguji4']==0) { echo "0"." ";} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['at'] && $dnilai['mean_nilai_penguji4'] >= $dt_grade['ab']) { echo  number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (A)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['bplust'] && $dnilai['mean_nilai_penguji4'] >= $dt_grade['bplusb']) { echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (B+)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['bt']  && $dnilai['mean_nilai_penguji4'] >= $dt_grade['bb']) { echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (B)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['cplust'] && $dnilai['mean_nilai_penguji4'] >= $dt_grade['cplusb']) { echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (C+)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['ct'] && $dnilai['mean_nilai_penguji4'] >= $dt_grade['cb']) { echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (C)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['mean_nilai_penguji4'] <= $dt_grade['dt'] && $dnilai['mean_nilai_penguji4'] >= $dt_grade['db']) {echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''). ' (D)'.' ';}
  elseif(!empty($dnilai['mean_nilai_penguji4'])) { echo number_format((float)$dnilai['mean_nilai_penguji4'], 2, '.', ''); }
echo '</span>';?>
