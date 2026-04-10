<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q = "SELECT * FROM opsi_jabatan_instansi WHERE id='$id'";
  $r = mysqli_query($con, $q);
  $data = mysqli_fetch_assoc($r);

  if(isset($_POST['new']) && $_POST['new']==1)
   {
   $nm =mysqli_real_escape_string($con, $_REQUEST['nm']);
   
   $myqry=mysqli_query($con, "UPDATE opsi_jabatan_instansi SET nm='$nm' WHERE id='$id'");
   header("location:dtJabsi.php?message=notifEdit&page=$page");
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
                  <li class="breadcrumb-item small"><a class="text-info" href="dtJabsi.php?page=<?php echo $page;?>">Jabatan Instansi</a></li>
                  <li class="breadcrumb-item active small">Edit Jabatan Instansi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="editDtJabsi.php?id=<?php echo $id;?>&page=<?php echo $page;?>" method="post" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Jabatan Instansi</h4>
                        <span class="float-right"><strong><?php echo $data['nm'];?></strong></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="form-group">
                        <label for="nm">Jabatan Instansi <span class="text-danger">*</span></label>
                        <input value="<?php echo $data['nm'];?>" type="text" name="nm" class="form-control form-control-sm" required>
                      </div>
                    </div>
                    <div class="card-footer justify-content-between">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm">Update</button>
                      <a href="dtJabsi.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm">Batal</a>
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