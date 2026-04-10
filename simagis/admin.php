<?php
  include( "koneksiExt.php" );
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "headExt.php";?>
  </head>
  <body>
    <div class="container">
      <div class="col-md-6 col-sm-12 col-xs-12" style="float:none; margin:auto; margin-top:20px;">
        <h3 class="page-header text-center">LOGIN ADMIN SIMAGIS</h3>
        <div class="panel panel-default">
          <div class="panel-body">
            <form class="form" role="form" method="post" action="logAdm.php?op=in" name="signIn">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
              </div>
              <hr>
              <button type="submit" class="btn btn-primary">Login</button>
              <a class="btn btn-success" href="index.php">Home
              </a>
            </form>
          </div>
        </div>
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifLogin') {
          echo '<div class="alert alert-danger custom-alert text-center" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Username atau password salah!</div>';}
          ?>
      </div>
    </div>
    <?php include("footerExt.php");?>
    <?php include "jsSourceExt.php";?>
    <script>
      window.setTimeout(function() {  
      $(".custom-alert").fadeOut(500, function() {
      $(this).remove();
      });
      }, 3000);
    </script>
  </body>
</html>