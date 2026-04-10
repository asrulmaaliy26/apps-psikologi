<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  ?>
<div class="table-responsive">
  <table class="table table-condensed table-bordered table-striped custom" style="margin-bottom:0px; font-size:13px;">
    <thead>
      <tr>
        <th width="3%" class="text-center">No.</th>
        <th width="31%" class="text-center">Nama | NIM</th>
        <th width="34%" class="text-center">Academic Coach</th>
        <th width="9%" class="text-center">Status</th>
        <th width="12%" class="text-center">Tgl. Verifikasi</th>
        <th width="11%" class="text-center">Tgl. Selesai</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no=0;
        $qdw = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE id_periode='$id' AND cek='2' ORDER BY id ASC";
        $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        while($ddw = mysqli_fetch_assoc($rdw)) {
        $no++;
        
		$qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddw[nim]'";
        $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dm = mysqli_fetch_assoc($rm);
		
		$qac = "SELECT * FROM mag_dosen_wali WHERE id='$ddw[dosen_wali]'";
        $rac = mysqli_query($GLOBALS["___mysqli_ston"], $qac)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dac = mysqli_fetch_assoc($rac);
		
		$qnac = "SELECT * FROM dt_pegawai WHERE id='$dac[nip]'";
        $rnac = mysqli_query($GLOBALS["___mysqli_ston"], $qnac)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dnac = mysqli_fetch_assoc($rnac);
        ?>
      <tr>
        <td class="text-center"><?php echo $no;?></td>
        <td class="text-left"><?php echo $dm['nama'].' | '.$dm['nim'];?></td>
        <td><?php echo $dnac['nama'];?></td>
        <td class="text-center"><?php if($ddw['cek']==2 && $ddw['status']==1) { echo "Proses";} if($ddw['cek']==2 && $ddw['status']==2) { echo "Selesai";}?></td>
        <td class="text-center"><?php echo $ddw['tgl_cek'];?></td>
		<td class="text-center"><?php echo $ddw['tgl_selesai'];?></td>
      </tr>
      <?php };?>
    </tbody>
  </table>
</div>