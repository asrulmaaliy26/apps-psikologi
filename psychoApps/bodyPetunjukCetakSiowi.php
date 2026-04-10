<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $sql = "SELECT * FROM siow_individu WHERE id='$id'";
  $result = mysqli_query($con, $sql);
  $data = mysqli_fetch_array($result);
  include ("bodyPetunjukCetak.php");
  ?>
<div class="modal-footer justify-content-between">
  <a type="button" class="btn btn-outline-warning btn-sm" target="_blank" href="cetakSiowiUser.php?id=<?php echo $data['id'];?>">Iya, saya mengerti dan lanjutkan cetak!</a>
  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
</div>