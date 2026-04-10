<?php
  include( "koneksiAdm.php" );
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_kontak_layanan WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateKontakLayananAdm.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <div class="form-group">
        <label for="nm">Nama</label>
        <input type="text" name="nm" class="form-control" id="nm" placeholder="Nama" value="<?php echo $dataku['nm'];?>" required>
      </div>
      <div class="form-group">
        <label for="hp">Kontak HP</label>
        <input type="text" name="hp" class="form-control" id="hp" placeholder="Kontak HP" value="<?php echo $dataku['hp'];?>">
      </div>
      <div class="form-group">
        <label for="email">Kontak Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Kontak Email" value="<?php echo $dataku['email'];?>">
      </div>
      <div class="form-group">
        <label for="deskripsi_layanan">Spesifikasi Layanan</label>
        <textarea name="deskripsi_layanan" class="form-control" id="deskripsi_layanan" placeholder="Spesifikasi Layanan" rows="3" required><?php echo $dataku['deskripsi_layanan'];?></textarea>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
        </label>
      </div>
      <button type="submit" class="btn btn-success" name="update">Update</button>
      <button type="reset" class="btn btn-info">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>