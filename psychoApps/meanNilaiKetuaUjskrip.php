<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  echo '<span data-toggle="tooltip" data-placement="bottom" title="'.(isset($dketua['nama']) ? $dketua['nama'] : '').'">';
  if(empty($dnilai) || $dnilai['nilai_ketua']==0) { echo "0"." ";} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['at'] && $dnilai['nilai_ketua'] >= $dt_grade['ab']) { echo  number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (A)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['bplust'] && $dnilai['nilai_ketua'] >= $dt_grade['bplusb']) { echo number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (B+)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['bt']  && $dnilai['nilai_ketua'] >= $dt_grade['bb']) { echo number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (B)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['cplust'] && $dnilai['nilai_ketua'] >= $dt_grade['cplusb']) { echo number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (C+)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['ct'] && $dnilai['nilai_ketua'] >= $dt_grade['cb']) { echo number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (C)'.' ';} 
  elseif(is_array($dt_grade) && $dnilai['nilai_ketua'] <= $dt_grade['dt'] && $dnilai['nilai_ketua'] >= $dt_grade['db']) {echo number_format((float)$dnilai['nilai_ketua'], 2, '.', ''). ' (D)'.' ';}
  elseif(!empty($dnilai['nilai_ketua'])) { echo number_format((float)$dnilai['nilai_ketua'], 2, '.', '');}
echo '</span>';?>
