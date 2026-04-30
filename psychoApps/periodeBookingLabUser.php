<?php 
include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$nim = $dataku['nim'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarUserS1.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Periode Booking Lab</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Informasi Periode Booking</h3>
                </div>
                <div class="card-body">
                  <p>Halaman ini sedang dalam pengembangan. Anda melihat halaman ini karena Anda terdaftar sebagai personil di <strong>Lab. Psikodiagnostik</strong>.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
  </div>
</body>

</html>
