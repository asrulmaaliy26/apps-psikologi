<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  ?>
<div class="table-responsive">
  <table class="table table-hover table-bordered m-0 text-center table-sm custom">
    <thead>
      <tr>
        <th class="text-center pl-1" width="8%">No</th>
        <th class="text-center pr-1" width="92%">Nama</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $no=0;
        $q = "SELECT * FROM anggota_siowk WHERE id_siowk='$id' AND nim_anggota<>'' ORDER BY urutan ASC";
        $hsl = mysqli_query($con,  $q )or die( mysqli_error($con));
        WHILE($mydata = mysqli_fetch_assoc( $hsl )) {
        $nimAnggota=$mydata['nim_anggota'];
        $no++;
        $myqry = "SELECT * FROM dt_mhssw WHERE nim='$nimAnggota'";
        $res = mysqli_query($con,  $myqry )or die( mysqli_error($con) );
        $dt = mysqli_fetch_assoc( $res );
        ?>
      <tr>
        <td class="text-center pl-1"><?php echo $no;?></td>
        <td class="text-left pr-1"><?php echo $dt['nama'].' ['.$dt['nim'].']';?></td>
      </tr>
      <?php
        }
        ?>
    </tbody>
  </table>
</div>