<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );

  $qry_periode = "SELECT * FROM mag_periode_pengajuan_ac WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
   if(isset($_POST['new']) && $_POST['new']==1)
   {
    $page = mysqli_real_escape_string($con, $_REQUEST['page']);
    $page1 = mysqli_real_escape_string($con, $_REQUEST['page1']);
    $id_periode = mysqli_real_escape_string($con, $_REQUEST['id']);
    $nip = mysqli_real_escape_string($con, $_REQUEST['nip']);
    $kuota = mysqli_real_escape_string($con, $_REQUEST['kuota']);
  
    $cekdata="SELECT nip FROM mag_dosen_wali WHERE nip='$nip' AND id_periode='$id_periode'";
    $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
    if(mysqli_num_rows($ada)>0)
     { header("location:magPersonalAcPerPeriodeAdm.php?id=$id_periode&page=$page&page1=$page1&message=notifSamaAc"); }
    else {
     $myqry=mysqli_query($con, "INSERT INTO mag_dosen_wali(id_periode,nip,kuota) VALUES ('$id_periode','$nip','$kuota')");
     header("location:magPersonalAcPerPeriodeAdm.php?id=$id_periode&page=$page&page1=$page1&message=notifInput");}
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
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalAcAdm.php?page=<?php echo $page;?>">Personal Academic Coach</a></li>
                  <li class="breadcrumb-item"><a href="magPersonalAcPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></a></li>
                  <li class="breadcrumb-item active">Input</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <form action="magInputPersonalAcPerPeriodeAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <h3 class="card-title">Input</h3>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="page1" class="sr-only" value="<?php echo $page1;?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="nip">Academic Coach <span class="text-danger">*</span></label>
                          <?php echo "<select name='nip' class='form-control form-control-sm' required/>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM dt_pegawai WHERE mengajar_pasca='2' ORDER BY nama_tg");
                            while($w=mysqli_fetch_array($tampil)){
                              echo "<option value='$w[id]'>$w[nama_tg]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                        <div class="form-group col-6">
                          <label for="kuota">Kuota <span class="text-danger">*</span></label>
                          <input type="number" min="0" max="20" name="kuota" class="form-control form-control-sm" required/>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm float-left">Submit</button>
                      <a href="magPersonalAcPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo "$page";?>&page1=<?php echo "$page1";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
                    </div>
                  </form>
                </div>
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