<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  if($nilaiakhir=='0') { echo "0"." ";} 
  elseif($nilaiakhir <= $dt_grade['at'] && $nilaiakhir >= $dt_grade['ab']) { echo number_format((float)$nilaiakhir, 2, '.', ''). ' (A)'.' ';} 
  elseif($nilaiakhir <= $dt_grade['bplust'] && $nilaiakhir >= $dt_grade['bplusb']) { echo number_format((float)$nilaiakhir, 2, '.', ''). ' (B+)'.' ';} 
  elseif($nilaiakhir <= $dt_grade['bt']  && $nilaiakhir >= $dt_grade['bb']) { echo number_format((float)$nilaiakhir, 2, '.', ''). ' (B)'.' ';} 
  elseif($nilaiakhir <= $dt_grade['cplust'] && $nilaiakhir >= $dt_grade['cplusb']) { echo number_format((float)$nilaiakhir, 2, '.', ''). ' (C+)'.' ';} 
  elseif($nilaiakhir <= $dt_grade['ct'] && $nilaiakhir >= $dt_grade['cb']) { echo number_format((float)$nilaiakhir, 2, '.', ''). ' (C)'.' ';} 
  elseif($nilaiakhir <= $dt_grade['dt'] && $nilaiakhir >= $dt_grade['db']) {echo number_format((float)$nilaiakhir, 2, '.', ''). ' (D)'.' ';}
?>