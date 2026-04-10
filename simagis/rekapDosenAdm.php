<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
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
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navMasterDataAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
            ?>
        <h3 class="text-center text-warning">Master Data Dosen</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah master data Dosen.</li>
              <li>Untuk edit data, silahkan hubungi Bagian Kepegawaian Fakultas Psikologi.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-striped custom">
                    <tbody>
                      <?php
                        $qdp = "SELECT * FROM dt_pegawai WHERE mengajar_pasca='2'";
                        $rdp = mysqli_query($GLOBALS["___mysqli_ston"], $qdp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($ddp = mysqli_fetch_assoc($rdp)) {
                        
                        $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp[kepakaran_mayor]'";
                        $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dr = mysqli_fetch_assoc($rr);
                        ?>			  
                      <tr>
                        <td width="12%" class="text-left" style="vertical-align:top;">
                          <img src="<?php echo '/sikep/'.$ddp['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddp['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
                        </td>
                        <td width="88%" class="text-left" style="vertical-align:top; padding-right:0px;">
                          <div class="table-responsive">
                            <table class="table table-condensed custom" style="font-size:13px; background:none;">
                              <tbody>
                                <tr>
                                  <td width="12%" class="text-left" style="border-top:0px;">Nama</td>
                                  <td width="2%" class="text-center" style="border-top:0px;">:</td>
                                  <td width="86%" class="text-left" style="border-top:0px;"><?php echo $ddp['nama'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left"><?php if($ddp['kat_pegawai']=='1') {echo "NIP";} else if($ddp['kat_pegawai']=='2') {echo "NIPT";}?></td>
                                  <td class="text-center">:</td>
                                  <td class="text-left"><?php echo $ddp['id'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Kontak</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left">Kontak (1): <?php echo $ddp['kntk1'].' | '. 'Kontak (2): '.$ddp['kntk2'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Email</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left">Email (1): <?php echo $ddp['email1'].' | '. 'Email (2): '.$ddp['email2'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Alamat</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left"><?php echo $ddp['alamat_rumah'];?></td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <button class="btn btn-sm btn-success" type="button" data-toggle="collapse" data-target="#<?php echo $ddp['id'];?>" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail</button>
                                    <div class="collapse" id="<?php echo $ddp['id'];?>" style="margin-top:10px;">
                                      <div class="table-responsive">
                                        <table class="table table-condensed custom" style="font-size:13px; background:none;">
                                          <tbody>
                                            <tr>
                                              <td width="20%" class="text-left">Kepakaran Mayor</td>
                                              <td width="2%" class="text-center">:</td>
                                              <td width="78%" class="text-left"><?php echo $dr['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Kepakaran Minor</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $ddp['kepakaran_minor'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Tren Riset</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $ddp['trend_riset'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Riset Terkini</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $ddp['profil_riset_terkini'];?></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $(document).ready(function () {
      $("#myModal").modal({
       backdrop: false
      });
      $("#myModal").modal("show");
      });
    </script>
  </body>
</html>