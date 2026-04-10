<?php
   include("contentsConAdm.php");
   
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $nilai=mysqli_real_escape_string($con, $_POST['nilai']);
   $id_dpl=mysqli_real_escape_string($con, $_POST['id_dpl']);
   $dpl=mysqli_real_escape_string($con, $_POST['dpl']);
   $id_pkl=mysqli_real_escape_string($con, $_POST['id_pkl']);
   $page=mysqli_real_escape_string($con, $_POST['page']);

   $qpp = "SELECT * FROM peserta_pkl WHERE id_dpl='" . $_POST['id_dpl'] . "'";
   $h = mysqli_query($con, $qpp);
   $count = mysqli_num_rows($h);

   for($i=0;$i<$count;$i++) {
         
   $qry="UPDATE peserta_pkl SET nilai='" . $_POST['nilai'][$i] . "' WHERE id='" . $_POST['id'][$i] . "'";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   header ("location:inputNilaiPesertaPklAdm.php?id=$id_dpl&id_pkl=$id_pkl&page=$page&message=notifUpdate");
   }
   mysqli_close();
   ?>