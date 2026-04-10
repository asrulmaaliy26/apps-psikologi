<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   ?>
<div class="table-responsive"style="margin-bottom:0px;">
   <table class="table table-striped table-condensed table-bordered custom">
      <thead>
         <tr>
            <th class="text-center" width="3%">No.</th>
            <th class="text-center" width="8%">Pukul</th>
            <th class="text-center" width="16%">Nama/NIM</th>
            <th class="text-center" width="18%">Judul Proposal Tesis</th>
            <th class="text-center" width="12%">Penguji Utama</th>
            <th class="text-center" width="12%">Ketua Penguji</th>
			   <th class="text-center" width="12%">Pembimbing I</th>
            <th class="text-center" width="12%">Pembimbing II</th>
            <th class="text-center" colspan="2">Opsi</th>
         </tr>
      </thead>
      <tbody class="text-muted" style="font-size:13px;">
         <?php				           	  
            $no=0;
            $q =  "SELECT * FROM mag_jadwal_sempro WHERE id_sempro='$data[id_sempro]' AND tgl_seminar='$data[tgl_seminar]' ORDER BY jam_mulai ASC";
            $r = mysqli_query($GLOBALS["___mysqli_ston"], $q);
            while($d = mysqli_fetch_array($r)) { 
            $no++;
            
            $query =  "SELECT * FROM mag_peserta_sempro WHERE id='$d[id_pendaftaran]'";
            $row = mysqli_query($GLOBALS["___mysqli_ston"], $query);
            $mydata = mysqli_fetch_array($row);
            
            $myquery = "select * from mag_dt_mhssw_pasca WHERE nim ='$mydata[nim]'";
            $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku = mysqli_fetch_assoc($dmhssw);
            
            $qp1 = "select * from dt_pegawai WHERE id='$d[penguji1]'";
            $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $dp1 = mysqli_fetch_assoc( $resp );
            
            $qp2 = "select * from dt_pegawai WHERE id='$d[penguji2]'";
            $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $dp2 = mysqli_fetch_assoc( $resp );
			
			   $qp3 = "select * from dt_pegawai WHERE id='$d[penguji3]'";
            $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $dp3 = mysqli_fetch_assoc( $resp );
			
			   $qp4 = "select * from dt_pegawai WHERE id='$d[penguji4]'";
            $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $dp4 = mysqli_fetch_assoc( $resp );
            
            ?>  						
         <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td class="text-center"><?php echo $d['jam_mulai'].' - '.$d['jam_selesai'];?></td>
            <td><?php echo $dataku['nama'].'<br />'.$dataku['nim'];?></td>
            <td><?php echo $mydata['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $mydata['judul_prop']);?></td>
			   <td><?php echo $dp3['nama'];?></td>			
			   <td><?php echo $dp4['nama'];?></td>
            <td><?php echo $dp1['nama'];?></td>
            <td><?php echo $dp2['nama'];?></td>
            <td class="text-center" width="4%">
               <?php if(empty($d['jam_mulai']) && empty($d['jam_selesai']) && empty($d['penguji2']) && empty($d['penguji3']) && empty($d['penguji4'])) { echo "<a role='button' class='btn btn-default btn-block disabled' title='Berita acara belum bisa dicetak'><span class='glyphicon glyphicon-print'></span></a>";} else { echo "<a role='button' href='cetakBaSempro.php?id=$d[id]' class='btn btn-default btn-block' title='Cetak berita acara' target='_blank'><span class='glyphicon glyphicon-print'></span></a>";}?>
            </td>
            <td class="text-center" width="4%">
               <?php if(empty($d['jam_mulai']) && empty($d['jam_selesai']) && empty($d['penguji2']) && empty($d['penguji3']) && empty($d['penguji4'])) { echo "<a role='button' class='btn btn-default btn-block disabled' title='Penguji belum bisa dicek kehadirannya'><span class='glyphicon glyphicon-check'></span></a>";} else { echo "<a role='button' href='cekKehadiranPengujiSempro.php?id=$d[id]' class='btn btn-default btn-block' title='Cek kehadiran penguji'><span class='glyphicon glyphicon-check'></span></a>";}?>
            </td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>