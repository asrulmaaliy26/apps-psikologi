<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<div>
   <table>
      <thead>
         <th>No.</th>
         <th>Pukul</th>
         <th>Nama/NIM</th>
         <th>Judul Skripsi</th>
         <th>Sekretaris Penguji</th>
         <th>Ketua Penguji</th>            
         <th>Penguji Utama</th>
      </thead>
      <tbody style="font-size:13px;">
         <?php				           	  
            $no=0;
            $q =  "SELECT * FROM jadwal_ujskrip WHERE penguji_utama='$id' AND id_ujskrip='$djdwl[id_ujskrip]' AND tgl_ujian='$djdwl[tgl_ujian]' ORDER BY jam_mulai ASC";
            $r = mysqli_query($con, $q);
            while($d = mysqli_fetch_array($r)) { 
            $no++;
            
            $query =  "SELECT * FROM peserta_ujskrip WHERE id='$d[id_pendaftaran]'";
            $row = mysqli_query($con, $query);
            $mydata = mysqli_fetch_array($row);
            
            $myquery = "SELECT * FROM dt_mhssw WHERE nim ='$mydata[nim]'";
            $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
            $dataku = mysqli_fetch_assoc($dmhssw);
            
            $qp1 = "SELECT * FROM dt_pegawai WHERE id='$d[sekretaris_penguji]'";
            $resp = mysqli_query($con,  $qp1 )or die( mysqli_error($con) );
            $dp1 = mysqli_fetch_assoc( $resp );
            
            $qp2 = "SELECT * FROM dt_pegawai WHERE id='$d[ketua_penguji]'";
            $resp = mysqli_query($con,  $qp2 )or die( mysqli_error($con) );
            $dp2 = mysqli_fetch_assoc( $resp );

            $qp3 = "SELECT * FROM dt_pegawai WHERE id='$d[penguji_utama]'";
            $resp = mysqli_query($con,  $qp3 )or die( mysqli_error($con) );
            $dp3 = mysqli_fetch_assoc( $resp );
            ?>  						
         <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $d['jam_mulai'].' - '.$d['jam_selesai'];?></td>
            <td><?php echo $dataku['nama'].'<br />'.$dataku['nim'];?></td>
            <td><?php echo $mydata['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $mydata['judul_skripsi']);?></td>
            <td><?php echo $dp1['nama'];?></td>
            <td><?php echo $dp2['nama'];?></td>
            <td><?php echo $dp3['nama'];?></td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>