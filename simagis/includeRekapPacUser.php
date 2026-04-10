<?php
  include( "koneksiUser.php" );
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Berikut adalah Academic coach yang Anda pilih.</li>
      <li>Academic coach yang telah Anda pilih dapat diedit sebelum diverifikasi oleh admin.</li>
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
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-condensed table-bordered custom">
            <thead>
              <tr class="success">
                <th width="44%" class="text-center">Academic coach</th>
                <th width="20%" class="text-center">Tgl. pengajuan</th>
                <th width="24%" class="text-center">Status pengajuan</th>
                <th width="12%" class="text-center">Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $qry = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE nim='$dataku[nim]'";
                $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $data = mysqli_fetch_assoc($has);
                
                $qdw = "SELECT * FROM mag_dosen_wali WHERE id='$data[dosen_wali]'";
                $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddw = mysqli_fetch_assoc($rdw);
                
                $qdp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
                $rdp = mysqli_query($GLOBALS["___mysqli_ston"], $qdp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddp = mysqli_fetch_assoc($rdp);
                
                $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp[kepakaran_mayor]'";
                $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                $dr = mysqli_fetch_assoc($rr);      
                ?>
              <tr>
                <td class="text-center"><?php echo $ddp['nama'];?></td>
                <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                <td class="text-center"><?php if($data['cek']==1) { echo "Belum diverifikasi"; } else if($data['cek']==2) { echo "Telah diverifikasi"; } else { echo "<code>Belum mengajukan</code>"; }?></td>
                <td class="text-center">
                  <?php 
                    if($data['cek']==1) { echo
                             "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                             </button>";}
                    else if($data['cek']==2) { echo
                             "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                             </button>";}
                             else { echo 
                             "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                             </button>";}?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="panel panel-danger" style="margin-bottom:0px;">
          <div class="panel-heading text-center">Catatan Pengajuan</div>
          <div class="panel-body">
            <?php echo $data['catatan'];?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-info">
  <div class="panel-heading text-center">
    <span class="lead">Profil Academic Coach</span>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="box pull-left hidden-sm hidden-xs">
          <label>
          <img src="<?php echo '/sikep/'.$ddp['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddp['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
        <div class="box center-block hidden-lg hidden-md">
          <label>
          <img src="<?php echo '/sikep/'.$ddp['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddp['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-danger">
          <div class="panel-heading text-center">Identitas</div>
          <div class="table-responsive">
            <table class="table custom">
              <tbody>
                <tr>
                  <td width="22%" class="text-left">Nama</td>
                  <td width="6%" class="text-center">:</td>
                  <td width="72%" class="text-left"><?php echo $ddp['nama'];?></td>
                </tr>
                <tr>
                  <td class="text-left">NIP</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddp['id'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Kontak</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddp['kntk1'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Email</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddp['email1'];?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-danger">
          <div class="panel-heading text-center">Tentang coaching</div>
          <ul class="list-group">
            <?php
              $qkwt = "SELECT * FROM mag_dosen_wali WHERE id='$data[dosen_wali]'";
              $rkwt = mysqli_query($GLOBALS["___mysqli_ston"],  $qkwt)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dkwt = mysqli_fetch_assoc($rkwt);
                  
              $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[dosen_wali]' AND cek='1'";
              $result0 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData0 = $dataku0['jumData'];
              ?>
            <button type="button" class="list-group-item" title="Daftar pengajuan" data-toggle="modal" data-target="#modalListPengajuan" data-whatever="<?php echo $dkwt['id'];?>" style="padding-bottom:9px;">
            <span class="badge"><?php echo "$jumlahData0";?> mhs</span>
            Pengajuan
            </button>
            <?php
              $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[dosen_wali]' AND cek='2' AND status='1'";
              $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData1 = $dataku1['jumData'];
              ?>
            <button type="button" class="list-group-item" title="Daftar proses" data-toggle="modal" data-target="#modalListProses" data-whatever="<?php echo $dkwt['id'];?>" style="padding-bottom:9px;">
            <span class="badge"><?php echo "$jumlahData1";?> mhs</span>
            Proses
            </button>
            <?php
              $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[dosen_wali]' AND cek='2' AND status='2'";
              $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData2 = $dataku2['jumData'];
              ?>
            <li class="list-group-item" style="padding-bottom:9px;">
              <span class="badge"><?php echo "$jumlahData2";?> mhs</span>
              Selesai
            </li>
            <?php
              $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[dosen_wali]' AND cek='2'";
              $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData3 = $dataku3['jumData'];
              ?>
            <li class="list-group-item" style="padding-bottom:9px;">
              <span class="badge"><?php echo "$jumlahData3";?> mhs</span>
              Total
            </li>
          </ul>
        </div>
      </div>
    </div>
    <br/>
    <div class="list-group">
      <li class="list-group-item">
        <h4 class="list-group-item-heading text-info">Kepakaran Mayor</h4>
        <p class="list-group-item-text"><?php echo "$dr[nm]";?></p>
      </li>
      <li class="list-group-item">
        <h4 class="list-group-item-heading text-info">Kepakaran Minor</h4>
        <p class="list-group-item-text"><?php echo "$ddp[kepakaran_minor]";?></p>
      </li>
      <li class="list-group-item">
        <h4 class="list-group-item-heading text-info">Tren Riset</h4>
        <p class="list-group-item-text"><?php echo "$ddp[trend_riset]";?></p>
      </li>
      <li class="list-group-item">
        <h4 class="list-group-item-heading text-info">Riset Terkini</h4>
        <p class="list-group-item-text"><?php echo "$ddp[profil_riset_terkini]";?></p>
      </li>
    </div>
  </div>
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
            <th width="20%">Rumpun Keilmuan Psi.</th>
            <th width="12%">Kuota</th>
            <th width="12%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            $qdw = "SELECT * FROM mag_dosen_wali WHERE id_periode='$data[id_periode]'";
                     $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                     while($ddw = mysqli_fetch_assoc($rdw)) {
            $no++;
            
            $qp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
                     $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dp = mysqli_fetch_assoc($rp);
            
            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
                     $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                     $dr = mysqli_fetch_assoc($rr);
            
            $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND id_periode='$data[id_periode]' AND status='1'";
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