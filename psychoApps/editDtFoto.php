<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $data = mysqli_fetch_assoc($r);
  
  if(isset($_POST['new']) && $_POST['new']==1)
  {
    $photo =mysqli_real_escape_string($con, $_REQUEST['photo']);
    $jenis_image = $_FILES['photo']['type'];
    if ($jenis_image == "image/jpeg" || $jenis_image=="image/jpg" || $jenis_image=="image/png") 
    {
      $myquery = "SELECT * FROM dt_pegawai WHERE id='$id'";
      $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
      $dt = mysqli_fetch_assoc( $r );
      $id_image=$dt['id'];
      $foldername = "photo_pegawai/";
      $temp = explode(".", $_FILES["photo"]["name"]);
      $newname = "image_".$id_image .uniqid(). '.' . end($temp);
      $photo = $foldername . $newname;
      move_uploaded_file($_FILES['photo']['tmp_name'], $foldername . '/' . $newname);
  
      $res = mysqli_query($con, "SELECT photo FROM dt_pegawai WHERE id='$id' LIMIT 1");
      $d=mysqli_fetch_assoc($res);
      if (strlen($d['photo'])>3)
      {
        if (file_exists($d['photo'])) unlink($d['photo']);
      }
      mysqli_query($con, "UPDATE dt_pegawai SET photo='$photo' WHERE id='$id' LIMIT 1");
      header("location:dtFoto.php?page=$page&message=notifEdit");
    } else 
    {
      header("location:dtFoto.php?page=$page&message=notifGagalImage");
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
        include( "navSideBarAdmKepeg.php" );
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
                  <li class="breadcrumb-item small"><a class="text-info" href="dtFoto.php?page=<?php echo $page;?>">Foto Pegawai</a></li>
                  <li class="breadcrumb-item active small">Edit Foto Pegawai</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="editDtFoto.php?id=<?php echo $id;?>&page=<?php echo $page;?>" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Foto Pegawai</h4>
                        <span class="float-right"><strong><?php echo $data['nama_tg'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="">File Foto Pegawai <span class="text-danger">*</span></label>
                          <input value="<?php echo $data['photo'];?>" type="file" class="form-control form-control-sm" name="photo" required>
                          <small id="" class="form-text">Ekstensi file: .jpeg, .jpg, .png. Dimensi file : 499 x 498 (pixels).</small>
                        </div>
                        <div class="form-group col-6">
                          <img class="profile-user-img img-fluid rounded mx-auto d-block" src="<?php echo $data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer justify-content-between">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Update</button>
                      <a href="dtFoto.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm">Batal</a>
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