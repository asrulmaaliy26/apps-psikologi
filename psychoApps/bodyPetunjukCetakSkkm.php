<?php include( "contentsConAdm.php" );
  $nim = mysqli_real_escape_string($con,  $_GET[ 'nim' ] );
  
  $sql = "SELECT * FROM skkm WHERE nim='$nim'";
  $result = mysqli_query($con, $sql);
  $data = mysqli_fetch_array($result);
  include ("bodyPetunjukCetakIsianSkkm.php");
  ?>
<div class="modal-footer justify-content-between">
  <a type="button" class="btn btn-outline-warning btn-sm" target="_blank" href="cetakSkkmUser.php?nim=<?php echo $data['nim'];?>">Iya, saya mengerti dan lanjutkan cetak!</a>
  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
</div>