<?php
  include( "contentsConAdm.php" );
  $id_periode = mysqli_real_escape_string($con, $_GET['id']);
  $page = mysqli_real_escape_string($con, $_GET['page']);

  // Get all peminatan that have reviewers in this period
  $q_pem = mysqli_query($con, "SELECT DISTINCT id_kepakaran FROM bimtek_reviewer WHERE id_periode='$id_periode'");
  
  while($d_pem = mysqli_fetch_assoc($q_pem)){
      $id_kep = $d_pem['id_kepakaran'];
      
      // Calculate kuota dasar for this kepakaran
      $q_pend = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_peserta WHERE id_bimtek='$id_periode' AND peminatan='$id_kep'");
      $tot_pendaftar = mysqli_fetch_assoc($q_pend)['tot'];
      
      $q_jml_rev = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_reviewer WHERE id_periode='$id_periode' AND id_kepakaran='$id_kep'");
      $jml_rev = mysqli_fetch_assoc($q_jml_rev)['tot'];
      
      $kuota_dasar = ($jml_rev > 0) ? floor($tot_pendaftar / $jml_rev) : 0;
      $sisa_kuota = ($jml_rev > 0) ? ($tot_pendaftar % $jml_rev) : 0;
      
      // Get all reviewers for this kepakaran
      $reviewers = [];
      $q_rev = mysqli_query($con, "SELECT r.nip, r.kuota_tambahan FROM bimtek_reviewer r JOIN dt_pegawai p ON r.nip = p.id WHERE r.id_periode='$id_periode' AND r.id_kepakaran='$id_kep' ORDER BY p.nama ASC");
      while($dr = mysqli_fetch_assoc($q_rev)){
          $nip = $dr['nip'];
          
          $my_kuota_dasar = $kuota_dasar;
          if($sisa_kuota > 0) {
              $my_kuota_dasar++;
              $sisa_kuota--;
          }
          
          $total_kuota = $my_kuota_dasar + $dr['kuota_tambahan'];
          
          // Get current plot count
          $q_plot = mysqli_query($con, "SELECT COUNT(*) as tot FROM bimtek_peserta WHERE id_bimtek='$id_periode' AND id_reviewer='$nip'");
          $telah_plot = mysqli_fetch_assoc($q_plot)['tot'];
          
          $reviewers[] = [
              'nip' => $nip,
              'total_kuota' => $total_kuota,
              'telah_plot' => $telah_plot
          ];
      }
      
      // If no reviewers, skip to next peminatan
      if(empty($reviewers)) continue;
      
      // Pre-step: clear assignments where reviewer no longer has a matching kepakaran
      // This handles cases where a reviewer changed their kepakaran after being assigned
      $q_invalid = mysqli_query($con, "SELECT bp.id, bp.id_reviewer 
                                       FROM bimtek_peserta bp
                                       WHERE bp.id_bimtek='$id_periode' 
                                         AND bp.peminatan='$id_kep'
                                         AND bp.id_reviewer != ''
                                         AND bp.id_reviewer IS NOT NULL
                                         AND bp.id_reviewer NOT IN (
                                             SELECT nip FROM bimtek_reviewer 
                                             WHERE id_periode='$id_periode' AND id_kepakaran='$id_kep'
                                         )");
      while($d_inv = mysqli_fetch_assoc($q_invalid)){
          mysqli_query($con, "UPDATE bimtek_peserta SET id_reviewer='' WHERE id='".$d_inv['id']."'");
      }
      
      // Get all unassigned students for this kepakaran
      $q_mhs = mysqli_query($con, "SELECT id FROM bimtek_peserta WHERE id_bimtek='$id_periode' AND peminatan='$id_kep' AND (id_reviewer='' OR id_reviewer IS NULL)");
      
      while($d_mhs = mysqli_fetch_assoc($q_mhs)){
          $id_peserta = $d_mhs['id'];
          
          // Find the reviewer with the lowest current load relative to their quota, or just the lowest load
          // To be fair with quota_tambahan, we sort by (telah_plot - total_kuota)
          // i.e., whoever is furthest from reaching their quota gets the student first.
          usort($reviewers, function($a, $b) {
              $load_a = $a['telah_plot'] - $a['total_kuota'];
              $load_b = $b['telah_plot'] - $b['total_kuota'];
              if ($load_a == $load_b) {
                  return $a['telah_plot'] - $b['telah_plot'];
              }
              return $load_a - $load_b;
          });
          
          $selected_rev = $reviewers[0]['nip'];
          
          // Update database
          mysqli_query($con, "UPDATE bimtek_peserta SET id_reviewer='$selected_rev' WHERE id='$id_peserta'");
          
          // Update our local array count so next iteration is accurate
          $reviewers[0]['telah_plot']++;
      }
  }

  header("location:plotReviewerBimtekAdm.php?id=$id_periode&page=$page&message=notifPlot");
?>
