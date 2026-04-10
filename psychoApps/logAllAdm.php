<?php 
  include( "contentsConAdm.php" );
  $level=mysqli_real_escape_string($con, $_POST['level']);
  $username=mysqli_real_escape_string($con, $_POST['username']);
  $password=mysqli_real_escape_string($con, $_POST['password']);
  $password=md5($password);

  $op = mysqli_real_escape_string($con, $_GET['op']);
  if($op=="in"){
      $cek = mysqli_query($con, "SELECT * FROM dt_all_adm WHERE username='$username' AND password='$password' AND level='$level' AND status='1' LIMIT 1");
      if(mysqli_num_rows($cek)==1){
          $c = mysqli_fetch_array($cek);
          $_SESSION['username'] = $c['username'];
          $_SESSION['password'] = $c['password'];
          $_SESSION['level'] = $c['level'];
          $_SESSION['nm_person'] = $c['nm_person'];
          $_SESSION['status'] = $c['status'];
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="4" && $_SESSION['status']=="1"){
        header("location:dashboardAdmKepeg.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="5" && $_SESSION['status']=="1"){
        header("location:dashboardAdmBmn.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="1" && $_SESSION['status']=="1"){
        header("location:dashboardBeritaAcaraSempro.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="6" && $_SESSION['status']=="1"){
        header("location:agendaSuratKeluarAdm.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="7" && $_SESSION['status']=="1"){
        header("location:dashboardAdmBakS1.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="8" && $_SESSION['status']=="1"){
        header("location:dashboardAdmBakS2.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="2" && $_SESSION['status']=="1"){
        header("location:dashboardUserS1.php");
          }
      }else{
        header("location:/index.php?message=notifLogin");
      }
  }
  
  mysqli_close($con);
  ?>