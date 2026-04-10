<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_berkas = mysqli_real_escape_string($con,  $_GET[ 'id_berkas' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $data = mysqli_fetch_assoc($r);
  
  $q_kbp = "SELECT * FROM kategori_berkas_pegawai WHERE id='$id_berkas'";
  $r_kbp = mysqli_query($con, $q_kbp);
  $data_kbp = mysqli_fetch_assoc($r_kbp);
  
  $q_bp = "SELECT * FROM berkas_pegawai WHERE id_pegawai='$id'";
  $r_bp = mysqli_query($con, $q_bp);
  $data_bp = mysqli_fetch_assoc($r_bp);
  
  if(isset($_POST['new']) && $_POST['new']==1)
  {
    $id_pegawai =mysqli_real_escape_string($con, $_REQUEST['id_pegawai']);
    $kat_berkas =mysqli_real_escape_string($con, $_REQUEST['kat_berkas']);
    $berkas =mysqli_real_escape_string($con, $_REQUEST['berkas']);
    $nm_berkas =mysqli_real_escape_string($con, $_REQUEST['nm_berkas']);
  
    $jenis_image = $_FILES['berkas']['type'];
    if ($jenis_image == "application/pdf") 
    {
      $myquery = "SELECT * FROM dt_pegawai WHERE id='$id_pegawai'";
      $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
      $dt = mysqli_fetch_assoc( $r );
      $id_image=$dt['id'];
      
      $foldername = "berkas_pegawai/";
      $temp = explode(".", $_FILES["berkas"]["name"]);
      $newname = ''.$nm_berkas.'' .'_' . $id_image . '.' . end($temp);
      $berkas = $foldername . $newname;
      move_uploaded_file($_FILES['berkas']['tmp_name'], $foldername . '/' . $newname);
  
      $qry = mysqli_query($con, "INSERT INTO berkas_pegawai (id_pegawai,kat_berkas,berkas) VALUES ('$id_pegawai','$kat_berkas','$berkas')");
      header("location:dtBerkasPerPegawai.php?id=$id&page=$page&message=notifInput");
    } 
    else 
    {
      header("location:dtBerkasPerPegawai.php?id=$id&page=$page&message=notifGagalImage");
    }
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
        include( "navSideBarAdmBmn.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Direktori</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="dtBerkasPegawai.php?page=<?php echo $page;?>">Berkas Pegawai</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="dtBerkasPerPegawai.php?id=<?php echo $id;?>&page=<?php echo $page;?>"><?php echo $data['nama_tg'];?></a></li>
                  <li class="breadcrumb-item active small">Input Berkas Pegawai</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="inputDtBerkasPegawai.php?id=<?php echo $id;?>&page=<?php echo $page;?>" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Input Berkas Pegawai [<?php echo '<span class="text-muted small">'.$data_kbp['nm'].'</span>';?>]</h4>
                        <span class="float-right"><strong><?php echo $data['nama_tg'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id_pegawai" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                      <input type="text" name="kat_berkas" class="sr-only" value="<?php echo $id_berkas;?>" required readonly>
                      <input type="text" name="nm_berkas" class="sr-only" value="<?php echo $data_kbp['nm'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="form-group">
                        <label for="">Berkas <?php echo $data_kbp['nm'];?> <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-sm" name="berkas" required>
                        <small id="" class="form-text">Ekstensi file: .pdf.</small>
                      </div>
                    </div>
                    <div class="card-footer justify-content-between">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Update</button>
                      <a href="dtBerkasPerPegawai.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-secondary btn-sm">Batal</a>
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