<?php include( "contentsConAdm.php" );
  $id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
  $page = mysqli_real_escape_string($con, $_POST['page']);
  
  $nips = $_POST['nip'];
  $id_kepakarans = $_POST['id_kepakaran'];
  $kuota_tambahans = $_POST['kuota_tambahan'];

  // Delete existing reviewers for this period to replace with new ones
  // Optional: We might lose plotting if we just delete and re-insert?
  // Actually, plotting is saved in `bimtek_peserta.id_reviewer` (which stores nip). 
  // If a reviewer is removed, we might want to un-plot them.
  // But let's just clear the bimtek_reviewer table for this period, and insert the submitted ones.
  
  // First, get old reviewers
  $old_rev = [];
  $q_old = mysqli_query($con, "SELECT nip FROM bimtek_reviewer WHERE id_periode='$id_periode'");
  while($d = mysqli_fetch_assoc($q_old)) $old_rev[] = $d['nip'];

  mysqli_query($con, "DELETE FROM bimtek_reviewer WHERE id_periode='$id_periode'");

  $new_rev = [];
  for($i = 0; $i < count($nips); $i++){
      $nip = mysqli_real_escape_string($con, $nips[$i]);
      $id_kep = mysqli_real_escape_string($con, $id_kepakarans[$i]);
      $kuota = mysqli_real_escape_string($con, $kuota_tambahans[$i]);
      
      if(!empty($id_kep)){
          $new_rev[] = $nip;
          $sql = "INSERT INTO bimtek_reviewer (id_periode, nip, id_kepakaran, kuota_tambahan) VALUES ('$id_periode', '$nip', '$id_kep', '$kuota')";
          mysqli_query($con, $sql);
      }
  }

  // Check if any old reviewer was removed, and un-plot their students
  $removed_rev = array_diff($old_rev, $new_rev);
  foreach($removed_rev as $rm_nip){
      mysqli_query($con, "UPDATE bimtek_peserta SET id_reviewer='' WHERE id_bimtek='$id_periode' AND id_reviewer='$rm_nip'");
  }

  header("location:plotReviewerBimtekAdm.php?id=$id_periode&page=$page&message=notifAdd");
?>
