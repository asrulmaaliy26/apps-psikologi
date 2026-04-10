<?php include( "contentsConAdm.php" );
  function antiinjection($data){
   
  $filter_sql = mysqli_real_escape_string($con, stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
   
  return $filter_sql;
   
  }
  
  $username=mysqli_real_escape_string($con, antiinjection($_POST['username']));
  $password=mysqli_real_escape_string($con, antiinjection($_POST['password']));
  $password=antiinjection(md5($password));
  
  $op = mysqli_real_escape_string($con, $_GET['op']);
  if($op=="in"){
      $cek = mysqli_query($con, "SELECT * FROM dt_admin_bak WHERE username='$username' AND password='$password' LIMIT 1");
      if(mysqli_num_rows($cek)==1){
          $c = mysqli_fetch_array($cek);
          $_SESSION['username'] = $c['username'];
          $_SESSION['password'] = $c['password'];
          $_SESSION['nama'] = $c['nama'];
          $_SESSION['status'] = $c['status'];
      if($_SESSION['username']=="$username" && $_SESSION['password']=="$password" && $_SESSION['status']=="1"){
              header("location:dashboardAdm.php");
          }
      }else{
           header("location:../admin.php?message=notifLogin");
      }
  }
  ?>