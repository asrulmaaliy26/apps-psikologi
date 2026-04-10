<?php
  include( "koneksiAdm.php" );
  $nim = $_SESSION[ 'nim' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
    
  $myquery = "select * from mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qdw = "SELECT * FROM mag_dospem_tesis WHERE id='$dataku[dospem_tesis2]'";
  $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddw = mysqli_fetch_assoc($rdw);
  
  $qdp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
  $rdp = mysqli_query($GLOBALS["___mysqli_ston"], $qdp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddp = mysqli_fetch_assoc($rdp);
            
  $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp[kepakaran_mayor]'";
  $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dr = mysqli_fetch_assoc($rr);
  ?>
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="box_1 pull-left hidden-sm hidden-xs">
          <label>
          <img src="<?php echo '/sikep/'.$ddp['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddp['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
        <div class="box_1 center-block hidden-lg hidden-md">
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
          <div class="panel-heading text-center">Tentang pembimbingan</div>
          <ul class="list-group">
            <?php           		
              $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddw[id]' AND cek1='1'";
              $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData1 = $dataku1['jumData'];
              
              $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddw[id]' AND cek2='1'";
              $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData2 = $dataku2['jumData'];
              $jumPengajuan = ($jumlahData1 + $jumlahData2);
              ?>
            <button type="button" class="list-group-item" title="Daftar pengajuan" data-toggle="modal" data-target="#modalListPengajuanPilihanDua" data-whatever="<?php echo $ddw['id'];?>" style="padding-bottom:9px;">
            <span class="badge"><?php echo "$jumPengajuan";?> mhs</span>
            Pengajuan
            </button>
            <?php
              $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddw[id]' AND cek1='2' AND status='1'";
              $result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData3 = $dataku3['jumData'];
              
              $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddw[id]' AND cek2='2' AND status='1'";
              $result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData4 = $dataku4['jumData'];
              $jumProses = ($jumlahData3 + $jumlahData4);
              ?>
            <button type="button" class="list-group-item" title="Daftar proses" data-toggle="modal" data-target="#modalListProsesPilihanDua" data-whatever="<?php echo $ddw['id'];?>" style="padding-bottom:9px;">
            <span class="badge"><?php echo "$jumProses";?> mhs</span>
            Proses
            </button>
            <?php
              $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddw[id]' AND cek1='2' AND cekjudul='2' AND status='2'";
              $result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData5 = $dataku5['jumData'];
              
              $qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddw[id]' AND cek2='2' AND cekjudul='2' AND status='2'";
              $result6 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData6 = $dataku6['jumData'];
              $jumSelesai = ($jumlahData5 + $jumlahData6);
              ?>
            <li class="list-group-item" style="padding-bottom:9px;">
              <span class="badge"><?php echo "$jumSelesai";?> mhs</span>
              Selesai
            </li>
            <?php
              $qry7 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddw[id]' AND cek1='2' AND cekjudul='2'";
              $result7 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData7 = $dataku7['jumData'];
              
              $qry8 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddw[id]' AND cek2='2' AND cekjudul='2'";
              $result8 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dataku8 = mysqli_fetch_assoc($result8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $jumlahData8 = $dataku8['jumData'];
              $jumTotal = ($jumlahData7 + $jumlahData8);
              ?>
            <li class="list-group-item" style="padding-bottom:9px;">
              <span class="badge"><?php echo "$jumTotal";?> mhs</span>
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