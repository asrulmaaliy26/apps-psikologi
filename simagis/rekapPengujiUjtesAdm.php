<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  ?>
<div class="table-responsive">
  <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
    <thead>
      <tr>
        <th rowspan="2" width="5%" class="text-center">No.</th>
        <th rowspan="2" width="60%" class="text-center">Nama | NIP | NIPT</th>
        <th colspan="4" class="text-center">Sebagai Penguji</th>
        <th rowspan="2"width="7%" class="text-center">Total</th>
      </tr>
      <tr>
        <th width="7%" class="text-center">Ketua</th>
        <th width="7%" class="text-center">I</th>
        <th width="7%" class="text-center">II</th>
        <th width="7%" class="text-center">III</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no=0;
        $qdw = "SELECT * FROM dt_pegawai WHERE menguji_ujian_tesis = '2' ORDER BY nama ASC";
        $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        while($ddw = mysqli_fetch_assoc($rdw)) {
        $no++;
        
        $qry1 = "SELECT COUNT(*) AS jumData FROM mag_jadwal_ujtes WHERE penguji3='$ddw[id]' AND id_ujtes='$id'";
        $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $jumKetua = $dataku1['jumData'];
        
        $qry2 = "SELECT COUNT(*) AS jumData FROM mag_jadwal_ujtes WHERE penguji4='$ddw[id]' AND id_ujtes='$id'";
        $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $jumPenguji1 = $dataku2['jumData'];
        
        $qry3 = "SELECT COUNT(*) AS jumData FROM mag_jadwal_ujtes WHERE penguji1='$ddw[id]' AND id_ujtes='$id'";
        $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $jumPenguji2 = $dataku3['jumData'];
        
        $qry4 = "SELECT COUNT(*) AS jumData FROM mag_jadwal_ujtes WHERE penguji2='$ddw[id]' AND id_ujtes='$id'";
        $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $jumPenguji3 = $dataku4['jumData'];
        
        $jumTotal = $jumKetua + $jumPenguji1 + $jumPenguji2 + $jumPenguji3;
        ?>
      <tr>
        <td class="text-center"><?php echo $no;?></td>
        <td class="text-left"><?php echo $ddw['nama'].' | '.$ddw['id'];?></td>
        <?php if($jumKetua==0) { echo '<td class="text-center">'.$jumKetua.'</td>';} else { echo '<td class="text-center bg-primary">'.$jumKetua.'</td>';} ?>
        <?php if($jumPenguji1==0) { echo '<td class="text-center">'.$jumPenguji1.'</td>';} else { echo '<td class="text-center bg-primary">'.$jumPenguji1.'</td>';} ?>
        <?php if($jumPenguji2==0) { echo '<td class="text-center">'.$jumPenguji2.'</td>';} else { echo '<td class="text-center bg-primary">'.$jumPenguji2.'</td>';} ?>
        <?php if($jumPenguji3==0) { echo '<td class="text-center">'.$jumPenguji3.'</td>';} else { echo '<td class="text-center bg-primary">'.$jumPenguji3.'</td>';} ?>
        <?php if($jumKetua==0 && $jumPenguji1==0 && $jumPenguji2==0 && $jumPenguji3==0) { echo '<td class="text-center">'.$jumTotal.'</td>';} else { echo '<td class="text-center"><b>'.$jumTotal.'</b></td>';} ?>
      </tr>
      <?php };?>
    </tbody>
  </table>
</div>