<?php
  include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  ?>
<div class="table-responsive">
  <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
    <thead>
      <tr class="text-center bg-secondary">
        <td width="4%" class="pl-1">No.</td>
        <td width="60%">Nama</td>
        <td width="36%" class="pr-1">Nilai</td>        
      </tr>
    </thead>
    <tbody>
      <?php
        $no=0;
        $sql = "SELECT * FROM peserta_kompre INNER JOIN dt_mhssw ON peserta_kompre.nim=dt_mhssw.nim WHERE peserta_kompre.id_jdwl='$id' ORDER BY dt_mhssw.nama ASC";
        $result = mysqli_query($con, $sql);
        while($data = mysqli_fetch_array($result)) {

        $qry_grade = "SELECT * FROM grade_kompre WHERE id_kompre='$data[id_kompre]'";
        $res_grade = mysqli_query($con, $qry_grade);
        $dt_grade = mysqli_fetch_assoc($res_grade);
        
        $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$data[id_kompre]'";
        $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
        $didper = mysqli_fetch_assoc($ridper);
        $no++;
        ?> 
      <tr>
        <td class="text-center pl-1"> <?php echo $no;?> </td>
        <td class="text-left"> <?php echo $data['nama'].' / '.$data['nim'];?> </td>
        <td class="text-center pr-1"> <?php if(empty($data['hasil_ujian'])) { echo "Belum ada"." ";} 
        elseif($data['hasil_ujian'] <= $dt_grade['at'] && $data['hasil_ujian'] >= $dt_grade['ab']) { echo $data['hasil_ujian']. ' (A)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['bplust'] && $data['hasil_ujian'] >= $dt_grade['bplusb']) { echo $data['hasil_ujian']. ' (B+)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['bt']  && $data['hasil_ujian'] >= $dt_grade['bb']) { echo $data['hasil_ujian']. ' (B)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['cplust'] && $data['hasil_ujian'] >= $dt_grade['cplusb']) { echo $data['hasil_ujian']. ' (C+)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['ct'] && $data['hasil_ujian'] >= $dt_grade['cb']) { echo $data['hasil_ujian']. ' (C)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['dt'] && $data['hasil_ujian'] >= $dt_grade['db']) {echo $data['hasil_ujian']. ' (D)'.' ';}?>
        <?php if($data['hasil_ujian'] <= $dt_grade['at'] && $data['hasil_ujian'] >= $didper['passing_grade']) { echo "<span class='bg-primary'>Lulus</span> dengan Passing Grade: ".$didper['passing_grade']."";} 
        elseif($data['hasil_ujian'] < $didper['passing_grade'] && $data['hasil_ujian'] >= $dt_grade['db']) { echo "<span class='bg-danger'>Gagal</span> dengan Passing Grade: ".$didper['passing_grade']."";} elseif(empty($data['hasil_ujian'])) { echo "";}?> </td>
      </tr>
      <?php
        }
        ?>                        
    </tbody>
  </table>
</div>