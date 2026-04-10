<?php include( "contentsConAdm.php" );
  if($dt_nilai['nilai_sekretaris']==0) { echo "0"." ";} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['at'] && $dt_nilai['nilai_sekretaris'] >= $dt_grade['ab']) { echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (A)'.' ';} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['bplust'] && $dt_nilai['nilai_sekretaris'] >= $dt_grade['bplusb']) { echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['bt']  && $dt_nilai['nilai_sekretaris'] >= $dt_grade['bb']) { echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (B)'.' ';} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['cplust'] && $dt_nilai['nilai_sekretaris'] >= $dt_grade['cplusb']) { echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (C+)'.' ';} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['ct'] && $dt_nilai['nilai_sekretaris'] >= $dt_grade['cb']) { echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (C)'.' ';} 
  elseif($dt_nilai['nilai_sekretaris'] <= $dt_grade['dt'] && $dt_nilai['nilai_sekretaris'] >= $dt_grade['db']) {echo number_format((float)$dt_nilai['nilai_sekretaris'], 2, '.', ''). ' (D)'.' ';}?>