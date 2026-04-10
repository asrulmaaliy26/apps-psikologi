<?php include( "contentsConAdm.php" );
  if($dt_nilai['nilai_utama']==0) { echo "0"." ";} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['at'] && $dt_nilai['nilai_utama'] >= $dt_grade['ab']) { echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['bplust'] && $dt_nilai['nilai_utama'] >= $dt_grade['bplusb']) { echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['bt']  && $dt_nilai['nilai_utama'] >= $dt_grade['bb']) { echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['cplust'] && $dt_nilai['nilai_utama'] >= $dt_grade['cplusb']) { echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['ct'] && $dt_nilai['nilai_utama'] >= $dt_grade['cb']) { echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dt_nilai['nilai_utama'] <= $dt_grade['dt'] && $dt_nilai['nilai_utama'] >= $dt_grade['db']) {echo number_format((float)$dt_nilai['nilai_utama'], 2, '.', ''). ' (D)'.' ';}?>