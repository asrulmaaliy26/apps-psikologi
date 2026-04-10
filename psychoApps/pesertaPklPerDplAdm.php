<?php
  include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id_dpl' ] );
  ?>
<div class="table-responsive">
  <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
    <thead>
      <tr class="text-center bg-secondary">
        <td width="4%" class="pl-1">No.</td>
        <td width="86%">Nama</td>
        <td width="10%" class="pr-1">Nilai</td>
      </tr>
    </thead>
    <tbody>
      <?php
        $no=0;
        $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.id_dpl='$id' ORDER BY dt_mhssw.nama ASC";
        $result = mysqli_query($con, $sql);
        while($data = mysqli_fetch_array($result)) {
        
        $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
        $res_grade = mysqli_query($con, $qry_grade);
        $dt_grade = mysqli_fetch_array($res_grade);
        $no++;
        ?> 
      <tr>
        <td class="text-center pl-1"> <?php echo $no;?> </td>
        <td class="text-left"> <?php echo $data['nama'].' / '.$data['nim'];?> </td>
        <td class="text-center pr-1"> <?php include "nilaiPesPklAdm.php";?> </td>
      </tr>
      <?php
        }
        ?>                        
    </tbody>
  </table>
</div>