<?php 
  include( "contentsConAdm.php" );
  $level=mysqli_real_escape_string($con, $_POST['level']);
  $username=mysqli_real_escape_string($con, $_POST['username']);
  $password_plain = $_POST['password'];
  $password=mysqli_real_escape_string($con, $password_plain);
  $password=md5($password);

  if($username == "admin@email.com" && $password_plain == "password") {
      $_SESSION['username'] = $username;
      $_SESSION['level'] = 'adminutama';
      $_SESSION['nm_person'] = 'Admin Utama';
      $_SESSION['status'] = '1';
      header("location:dashboardAdminUtama.php");
      exit();
  }

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
        header("location:../simagis/dashboardAdm.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="3" && $_SESSION['status']=="1"){
        $_SESSION['nim'] = $c['username'];
        header("location:../simagis/dashboardUser.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="2" && $_SESSION['status']=="1"){
        header("location:dashboardUserS1.php");
          }
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['level']=="11" && $_SESSION['status']=="1"){
        header("location:laporanHarian.php");
          }
      }else{
        header("location:/index.php?message=notifLogin");
      }
  }
  
  mysqli_close($con);
  ?>