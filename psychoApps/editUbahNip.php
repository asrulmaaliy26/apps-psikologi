<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $data = mysqli_fetch_assoc($r);

  if(isset($_POST['new']) && $_POST['new']==1)
   {
   $newId =mysqli_real_escape_string($con, $_REQUEST['newId']);
   
   $myqry1=mysqli_query($con, "UPDATE dt_pegawai SET id='$newId' WHERE id='$id'");
   $myqry2=mysqli_query($con, "UPDATE dospem_skripsi SET nip='$newId' WHERE nip='$id'");
   $myqry3=mysqli_query($con, "UPDATE dt_mhssw SET dosen_wali='$newId' WHERE dosen_wali='$id'");
   $myqry4=mysqli_query($con, "UPDATE jadwal_sempro SET penguji1='$newId' WHERE penguji1='$id'");
   $myqry5=mysqli_query($con, "UPDATE jadwal_sempro SET penguji2='$newId' WHERE penguji2='$id'");
   $myqry6=mysqli_query($con, "UPDATE jadwal_ujskrip SET ketua_penguji='$newId' WHERE ketua_penguji='$id'");
   $myqry7=mysqli_query($con, "UPDATE jadwal_ujskrip SET sekretaris_penguji='$newId' WHERE sekretaris_penguji='$id'");
   $myqry8=mysqli_query($con, "UPDATE jadwal_ujskrip SET penguji_utama='$newId' WHERE penguji_utama='$id'");
   $myqry9=mysqli_query($con, "UPDATE mag_dosen_wali SET nip='$newId' WHERE nip='$id'");
   $myqry10=mysqli_query($con, "UPDATE mag_dospem_tesis SET nip='$newId' WHERE nip='$id'");
   $myqry11=mysqli_query($con, "UPDATE mag_jadwal_sempro SET penguji1='$newId' WHERE penguji1='$id'");
   $myqry12=mysqli_query($con, "UPDATE mag_jadwal_sempro SET penguji2='$newId' WHERE penguji2='$id'");
   $myqry13=mysqli_query($con, "UPDATE mag_jadwal_sempro SET penguji3='$newId' WHERE penguji3='$id'");
   $myqry14=mysqli_query($con, "UPDATE mag_jadwal_sempro SET penguji4='$newId' WHERE penguji4='$id'");
   $myqry15=mysqli_query($con, "UPDATE mag_jadwal_ujtes SET penguji1='$newId' WHERE penguji1='$id'");
   $myqry16=mysqli_query($con, "UPDATE mag_jadwal_ujtes SET penguji2='$newId' WHERE penguji2='$id'");
   $myqry17=mysqli_query($con, "UPDATE mag_jadwal_ujtes SET penguji3='$newId' WHERE penguji3='$id'");
   $myqry18=mysqli_query($con, "UPDATE mag_jadwal_ujtes SET penguji4='$newId' WHERE penguji4='$id'");
   $myqry19=mysqli_query($con, "UPDATE mag_pengelompokan_dospem_tesis SET nip_dospem_tesis1='$newId' WHERE nip_dospem_tesis1='$id'");
   $myqry20=mysqli_query($con, "UPDATE mag_pengelompokan_dospem_tesis SET nip_dospem_tesis2='$newId' WHERE nip_dospem_tesis2='$id'");
   $myqry21=mysqli_query($con, "UPDATE mag_peserta_sempro SET dospem_tesis1='$newId' WHERE dospem_tesis1='$id'");
   $myqry22=mysqli_query($con, "UPDATE mag_peserta_sempro SET dospem_tesis2='$newId' WHERE dospem_tesis2='$id'");
   $myqry23=mysqli_query($con, "UPDATE mag_peserta_ujtes SET dospem_tesis1='$newId' WHERE dospem_tesis1='$id'");
   $myqry24=mysqli_query($con, "UPDATE mag_peserta_ujtes SET dospem_tesis2='$newId' WHERE dospem_tesis2='$id'");
   $myqry25=mysqli_query($con, "UPDATE mag_siowi SET dosen_pembimbing='$newId' WHERE dosen_pembimbing='$id'");
   $myqry26=mysqli_query($con, "UPDATE penerima_surat SET penerima='$newId' WHERE penerima='$id'");
   $myqry27=mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$newId' WHERE dospem_skripsi1='$id'");
   $myqry28=mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi2='$newId' WHERE dospem_skripsi2='$id'");
   $myqry29=mysqli_query($con, "UPDATE personil_sk SET nama='$newId' WHERE nama='$id'");
   $myqry30=mysqli_query($con, "UPDATE personil_st SET nama='$newId' WHERE nama='$id'");
   $myqry31=mysqli_query($con, "UPDATE peserta_sempro SET pembimbing1='$newId' WHERE pembimbing1='$id'");
   $myqry32=mysqli_query($con, "UPDATE peserta_sempro SET pembimbing2='$newId' WHERE pembimbing2='$id'");
   $myqry33=mysqli_query($con, "UPDATE peserta_ujskrip SET pembimbing1='$newId' WHERE pembimbing1='$id'");
   $myqry34=mysqli_query($con, "UPDATE peserta_ujskrip SET pembimbing2='$newId' WHERE pembimbing2='$id'");
   $myqry35=mysqli_query($con, "UPDATE prasips SET dosen_pembimbing1='$newId' WHERE dosen_pembimbing1='$id'");
   $myqry36=mysqli_query($con, "UPDATE prasips SET dosen_pembimbing2='$newId' WHERE dosen_pembimbing2='$id'");
   $myqry37=mysqli_query($con, "UPDATE siow_individu SET dosen_pembimbing='$newId' WHERE dosen_pembimbing='$id'");
   $myqry38=mysqli_query($con, "UPDATE sips SET dosen_pembimbing1='$newId' WHERE dosen_pembimbing1='$id'");
   $myqry39=mysqli_query($con, "UPDATE sips SET dosen_pembimbing2='$newId' WHERE dosen_pembimbing2='$id'");
   $myqry40=mysqli_query($con, "UPDATE sk SET dekan='$newId' WHERE dekan='$id'");
   $myqry41=mysqli_query($con, "UPDATE spd SET penerima='$newId' WHERE penerima='$id'");
   $myqry42=mysqli_query($con, "UPDATE spd SET ppk='$newId' WHERE ppk='$id'");
   $myqry43=mysqli_query($con, "UPDATE spd SET dekan='$newId' WHERE dekan='$id'");
   $myqry44=mysqli_query($con, "UPDATE st SET dekan='$newId' WHERE dekan='$id'");
   $myqry45=mysqli_query($con, "UPDATE ppk SET nm='$newId' WHERE nm='$id'");
   $myqry46=mysqli_query($con, "UPDATE mag_pengelompokan_dosen_wali SET nip_dosen_wali='$newId' WHERE nip_dosen_wali='$id'");
   $myqry47=mysqli_query($con, "UPDATE dt_all_adm SET username='$newId' WHERE username='$id'");
   header("location:ubahNip.php?message=notifEdit&page=$page");
   }
   mysqli_close($con);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Konfigurasi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="ubahNip.php?page=<?php echo $page;?>">Ubah NIP/Id Lainnya</a></li>
                  <li class="breadcrumb-item active small">Edit Ubah NIP/Id Lainnya</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="editUbahNip.php?id=<?php echo $id;?>&page=<?php echo $page;?>" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Ubah NIP/Id Lainnya</h4>
                        <span class="float-right"><strong><?php echo $data['id'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="form-group">
                        <label for="">NIP/Id Lainnya <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['id'];?>" type="text" class="form-control form-control-sm" name="newId" required>
                      </div>
                      <div class="form-group">
                        <label for="">Nama</label>
                          <input value="<?php echo $data['nama_tg'];?>" type="text" class="form-control form-control-sm" readonly disabled>
                      </div>
                    </div>
                    <div class="card-footer justify-content-between">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Update</button>
                      <a href="ubahNip.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm">Batal</a>
                    </div>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>