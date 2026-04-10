<?php include( "contentsConAdm.php" );
  if($data['hasil_ujian']==0) { echo "0"." ";} 
  elseif($data['hasil_ujian'] <= $dt_grade['at'] && $data['hasil_ujian'] >= $dt_grade['ab']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (A)'.' ';} 
  elseif($data['hasil_ujian'] <= $dt_grade['bplust'] && $data['hasil_ujian'] >= $dt_grade['bplusb']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (B+)'.' ';} 
  elseif($data['hasil_ujian'] <= $dt_grade['bt']  && $data['hasil_ujian'] >= $dt_grade['bb']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (B)'.' ';}
  elseif($data['hasil_ujian'] <= $dt_grade['cplust']  && $data['hasil_ujian'] >= $dt_grade['cplusb']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (C+)'.' ';}
  elseif($data['hasil_ujian'] <= $dt_grade['ct']  && $data['hasil_ujian'] >= $dt_grade['cb']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (C)'.' ';}
  elseif($data['hasil_ujian'] <= $dt_grade['dt']  && $data['hasil_ujian'] >= $dt_grade['db']) { echo number_format((float)$data['hasil_ujian'], 2, '.', ''). ' (D)'.' ';}
  ?>
