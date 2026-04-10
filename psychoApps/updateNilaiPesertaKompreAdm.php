<?php
   include("contentsConAdm.php");
   
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $hasil_ujian=mysqli_real_escape_string($con, $_POST['hasil_ujian']);
   $id_jdwl=mysqli_real_escape_string($con, $_POST['id_jdwl']);
   $id_kompre=mysqli_real_escape_string($con, $_POST['id_kompre']);
   $page=mysqli_real_escape_string($con, $_POST['page']);

   $qpk = "SELECT * FROM peserta_kompre WHERE id_jdwl='" . $_POST['id_jdwl'] . "'";
   $h = mysqli_query($con, $qpk);
   $count = mysqli_num_rows($h);

   for($i=0;$i<$count;$i++) {
         
   $qry="UPDATE peserta_kompre SET hasil_ujian='" . $_POST['hasil_ujian'][$i] . "' WHERE id='" . $_POST['id'][$i] . "'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   header ("location:inputNilaiPesertaKompreAdm.php?id=$id_jdwl&id_kompre=$id_kompre&page=$page&message=notifUpdate");
   }
   mysqli_close();
   ?>