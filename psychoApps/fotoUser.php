<?php include( "contentsConAdm.php" );
$username = $_SESSION['username'];?>
<img class="profile-user-img img-fluid img-thumbnail" src="./<?php echo $dataku['photo'];?>" onError="this.onerror=null;this.src='<?php if($dataku['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">