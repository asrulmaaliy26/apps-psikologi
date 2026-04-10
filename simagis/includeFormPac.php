<?php
  include( "koneksiUser.php" );
   
  $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
  $rkaprodi = mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);   
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Form ini adalah pilihan Academic Coach.</li>
      <li>Silahkan pilih Academic Coach yang Anda minati. Lebih ideal bila linier dengan peminatan rumpun psikologi yang dipilih.</li>
      <li>Academic Coach tidak dapat dipilih apabila kuota darinya telah penuh.</li>
      <li>Profil Academic Coach dapat dilihat di bawah kolom Form. Untuk melihat lebih detail, tekan button Detail.</li>
      <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan pilihan Anda.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pengajuan Academic Coach
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_pac";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <form action="sformPac.php" method="post">
      <div class="form-group">
        <label for="dosen_wali">Academic coach yang dipilih:</label>
        <select name="dosen_wali" class="form-control" required>
          <option value="">-Pilih-</option>
          <?php
            $query = "SELECT * FROM mag_dosen_wali WHERE id_periode='$data[id]'";
            $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            while($dt = mysqli_fetch_array($r)) {
                 
            $mqry = "SELECT * FROM dt_pegawai WHERE id='$dt[nip]' ORDER BY nama ASC";
            $rq = mysqli_query($GLOBALS["___mysqli_ston"], $mqry)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dq = mysqli_fetch_array($rq);
            
            echo "<option value='$dt[id]'>$dq[nama]</option>";
            }
            ?>
        </select>
      </div>
      <div class="form-group">
        <label for="tgl_pengajuan">Tanggal pengajuan:</label>
        <input type="text" class="form-control" id="tgl_pengajuan" value="<?php echo date("d-m-Y");?>" disabled>
		<input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
		<input type="text" name="id_periode" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
        <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar dan sesuai dengan pilihan saya.
        </label>
      </div>
  </div>
  <div class="panel-footer">
  <input type="text" name="cek" class="sr-only" value="1" required readonly>
  <input type="text" name="status" class="sr-only" value="1" required readonly>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </div>
  </form>
</div>
<div class="panel panel-info">
  <div class="panel-heading text-center">
    <span class="lead">Opsi dan Profil Academic Coach</span>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped custom" style="margin-bottom:0px;">
        <thead>
          <tr>
            <th width="4%" class="text-center">No.</th>
            <th width="36%">Nama</th>
            <th width="18%">NIP</th>
            <th width="20%">Kepakaran Mayor</th>
            <th width="12%">Kuota</th>
            <th width="12%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php            
            $no=0;
            $qdw = "SELECT * FROM mag_dosen_wali WHERE id_periode='$data[id]'";
            $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            while($ddw = mysqli_fetch_assoc($rdw)) {
            $no++;
            
            $qp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
            $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dp = mysqli_fetch_assoc($rp);
            
            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
            $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dr = mysqli_fetch_assoc($rr);
            
            $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND id_periode='$data[id]' AND status='1'";
            $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData0 = $dataku0['jumData'];
            $sisa = $ddw['kuota'] - $jumlahData0;
                     ?>
          <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td><?php echo $dp['nama'];?></td>
            <td><?php echo $dp['id'];?></td>
            <td><?php echo $dr['nm'];?></td>
            <td><?php echo $ddw['kuota'].' (tersisa '.$sisa.')';?></td>
            <td class="text-center">
              <button class="btn btn-sm btn-block btn-success" title="Lebih detail" data-toggle="modal" data-target="#modalDetailOpsi" data-whatever="<?php echo $ddw['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
              </button>
            </td>
          </tr>
          <?php };?>
        </tbody>
      </table>
    </div>
  </div>
</div>