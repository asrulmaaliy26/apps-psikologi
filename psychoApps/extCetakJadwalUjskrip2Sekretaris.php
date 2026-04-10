<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<div>
   <table class="jadwal">
      <thead>
         <tr>
            <th class="text-center pl-1" width="3%">No.</th>
            <th width="9%" class="text-center">Pukul</th>
            <th width="18%" class="text-center">Nama/NIM</th>
            <th width="28%" class="text-center">Judul Skripsi</th>
            <th width="14%" class="text-center">Sekretaris Penguji</th>
            <th width="14%" class="text-center">Ketua Penguji</th>            
            <th width="14%" class="text-center pr-1">Penguji Utama</th>
         </tr>
      </thead>
      <tbody style="font-size:13px;">
         <?php				           	  
            $no=0;
            $q =  "SELECT * FROM jadwal_ujskrip WHERE sekretaris_penguji='$id' AND id_ujskrip='$djdwl[id_ujskrip]' AND tgl_ujian='$djdwl[tgl_ujian]' ORDER BY jam_mulai ASC";
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
            <td class="text-center"><?php echo $no;?></td>
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