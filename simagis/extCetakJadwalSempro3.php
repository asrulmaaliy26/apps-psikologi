<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   ?>
      <br />
      <div class="right">
         Malang, <?php echo bulanIndo(date('d-m-Y'));?> <br />
         a.n. Dekan, <br />
         <?php echo $djikaprodi['nm'];?>,
         <br />
         <br />
         <br />
         <br />
         <?php echo $dkaprodi['nama_tg'];?>
      </div>