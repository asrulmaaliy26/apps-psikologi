<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPngjnUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '<div class="alert alert-warning custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
            
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '<div class="alert alert-success custom-alert" role="alert">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
                  ?>
        <h3 class="text-center text-info">Peminatan Rumpun Psikologi</h3>
        <?php
          $q = "SELECT nim FROM mag_pengelompokan_rumpun WHERE nim='$dataku[nim]'";
                $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                $d = mysqli_num_rows($r);
          if($d==0) {include 'includeFormPprp.php';}
          elseif($d==1) {include 'includeRekapPprpUser.php';}
          ?>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Form Edit Peminatan Rumpun Psikologi</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script>
      $('#modalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this);
        var dataString = 'id=' + recipient;
      
        $.ajax({
      	type: "GET",
      	url: "editPprpUser.php",
      	data: dataString,
      	cache: false,
      	success: function (data) {
      	  console.log(data);
      	  modal.find('.isiModalEdit').html(data);
      	},
      	error: function (err) {
      	  console.log(err);
      	}
        });
      });        
    </script>
  </body>
</html>