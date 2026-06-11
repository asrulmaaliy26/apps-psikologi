<?php
  if($data['nilai']=="") { echo "Belum ada";} 
  elseif($data['nilai']==0) { echo "0";} 
  elseif($data['nilai'] <= $dt_grade['at'] && $data['nilai'] >= $dt_grade['ab']) { echo 'A';} 
  elseif($data['nilai'] <= $dt_grade['bplust'] && $data['nilai'] >= $dt_grade['bplusb']) { echo 'B+';} 
  elseif($data['nilai'] <= $dt_grade['bt']  && $data['nilai'] >= $dt_grade['bb']) { echo 'B';} 
  elseif($data['nilai'] <= $dt_grade['cplust'] && $data['nilai'] >= $dt_grade['cplusb']) { echo 'C+';} 
  elseif($data['nilai'] <= $dt_grade['ct'] && $data['nilai'] >= $dt_grade['cb']) { echo 'C';} 
  elseif($data['nilai'] <= $dt_grade['dt'] && $data['nilai'] >= $dt_grade['db']) { echo 'D';}
?>
