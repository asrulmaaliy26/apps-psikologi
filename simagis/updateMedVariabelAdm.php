<?php
  include( "koneksiAdm.php" );
  
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $nm=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nm']);
  
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_mediatorvariable SET nm='$nm' WHERE id='$id' LIMIT 1")  or die(mysqli_error($GLOBALS["___mysqli_ston"])); {  
  header("location:variabelmediatorAdm.php?message=notifEdit");
  }
  ?>