<?php
  include( "koneksiUser.php" );
  $qry_moment = "SELECT * FROM mag_periode_pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  
  $qta = "select * from mag_dt_ta WHERE status='1'";
  $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dta = mysqli_fetch_assoc($rta);   
   
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
      <li>Form ini adalah pilihan Dosen Pembimbing Tesis.</li>
      <li>Silahkan pilih Dosen Pembimbing Tesis yang Anda minati. Lebih ideal bila linier dengan tema dan judul tesis.</li>
      <li>Pilihan Dosen Pembimbing Tesis I dan II tidak boleh sama.</li>
      <li>Dosen Pembimbing Tesis tidak dapat dipilih apabila kuota darinya telah penuh.</li>
      <li>Profil Dosen Pembimbing Tesis dapat dilihat di bawah kolom Form. Untuk melihat lebih detail, tekan button Detail.</li>
      <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan pilihan Anda.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pengajuan Pembimbing Tesis
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_ppt";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <form action="sformPpt.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul_tesis">Judul tesis:</label>
        <textarea name="judul_tesis" class="form-control textinput" id="judul_tesis" required></textarea>
      </div>
      <div class="form-group">
        <label for="outline_tesis">Outline tesis:</label>
        <textarea name="outline_tesis" class="form-control textinput" id="outline_tesis" required></textarea>
      </div>
      <div class="form-group">
        <label for="dospem_tesis1">Dosen pembimbing tesis I yang dipilih:</label>
        <select name="dospem_tesis1" class="form-control" id="dospem_tesis1" required>
          <option value="">-Pilih-</option>
          <?php
            $query = "SELECT * FROM mag_dospem_tesis WHERE id_periode='$data[id]'";
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
        <label for="dospem_tesis2">Dosen pembimbing tesis II yang dipilih:</label>
        <select name="dospem_tesis2" class="form-control" id="dospem_tesis2" required>
          <option value="">-Pilih-</option>
          <?php
            $query = "SELECT * FROM mag_dospem_tesis WHERE id_periode='$data[id]'";
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
  <input type="text" name="cek1" class="sr-only" value="1" required readonly>
  <input type="text" name="cek2" class="sr-only" value="1" required readonly>
  <input type="text" name="cekjudul" class="sr-only" value="1" required readonly>
  <input type="text" name="status" class="sr-only" value="1" required readonly>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </div>
  </form>
</div>
<div class="panel panel-info">
  <div class="panel-heading text-center">
    <span class="lead">Opsi dan Profil Dosen Pembimbing Tesis</span>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered table-hover custom" style="margin-bottom:0px;">
        <thead>
          <tr>
            <th width="4%" class="text-center">No.</th>
            <th width="36%">Nama</th>
            <th width="20%">Kepakaran Mayor</th>
            <th width="15%">Kuota Dospem I</th>
            <th width="15%">Kuota Dospem II</th>
            <th width="12%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            $qdpt = "SELECT * FROM mag_dospem_tesis WHERE id_periode='$data[id]'";
            $rdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            while($ddpt = mysqli_fetch_assoc($rdpt)) {
            $no++;
            
            $qp = "SELECT * FROM dt_pegawai WHERE id='$ddpt[nip]'";
            $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dp = mysqli_fetch_assoc($rp);
            
            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
            $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dr = mysqli_fetch_assoc($rr);         
            
            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddpt[id]' AND id_periode='$data[id]' AND status='1'";
            $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData1 = $dataku1['jumData'];
            $sisa1 = $ddpt['kuota1'] - $jumlahData1;
            
            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddpt[id]' AND id_periode='$data[id]' AND status='1'";
            $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData2 = $dataku2['jumData'];
            $sisa2 = $ddpt['kuota2'] - $jumlahData2;
            ?>
          <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td><?php echo $dp['nama'];?></td>
            <td><?php echo $dr['nm'];?></td>
            <td><?php if($ddpt['kuota1'] - $jumlahData1==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota1'].' (tersisa '.$sisa1.')';}?></td>
            <td><?php if($ddpt['kuota2'] - $jumlahData2==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota2'].' (tersisa '.$sisa2.')';}?></td>
            <td class="text-center">
              <button class="btn btn-sm btn-block btn-success" title="Lebih detail" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $ddpt['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
              </button>
            </td>
          </tr>
          <?php };?>
        </tbody>
      </table>
    </div>
  </div>
</div>