<?php
  if($data['nilai']=="") { echo "Belum ada";} 
  elseif($data['nilai']==0) { echo "0";} 
  elseif($data['nilai'] <= $dt_grade['at'] && $data['nilai'] >= $dt_grade['ab']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (A)';} 
  elseif($data['nilai'] <= $dt_grade['bplust'] && $data['nilai'] >= $dt_grade['bplusb']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (B+)';} 
  elseif($data['nilai'] <= $dt_grade['bt']  && $data['nilai'] >= $dt_grade['bb']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (B)';} 
  elseif($data['nilai'] <= $dt_grade['cplust'] && $data['nilai'] >= $dt_grade['cplusb']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (C+)';} 
  elseif($data['nilai'] <= $dt_grade['ct'] && $data['nilai'] >= $dt_grade['cb']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (C)';} 
  elseif($data['nilai'] <= $dt_grade['dt'] && $data['nilai'] >= $dt_grade['db']) { echo number_format((float)$data['nilai'], 2, '.', ''). ' (D)';}
?>
