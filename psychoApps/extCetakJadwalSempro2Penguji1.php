<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<div>
   <table class="jadwal">
      <thead>
         <tr>
            <th width="3%">No.</th>
            <th width="8%">Pukul</th>
            <th width="18%">Nama/NIM</th>
            <th width="29%">Judul Proposal Skripsi</th>
            <th width="21%">Narasumber I</th>
            <th width="21%">Narasumber II</th>
         </tr>
      </thead>
      <tbody style="font-size:13px;">
         <?php				           	  
            $no=0;
            $q =  "SELECT * FROM jadwal_sempro WHERE penguji1='$id' AND id_sempro='$djdwl[id_sempro]' AND tgl_seminar='$djdwl[tgl_seminar]' ORDER BY jam_mulai ASC";
            $r = mysqli_query($con, $q);
            while($d = mysqli_fetch_array($r)) { 
            $no++;
            
            $query =  "SELECT * FROM peserta_sempro WHERE id='$d[id_pendaftaran]'";
            $row = mysqli_query($con, $query);
            $mydata = mysqli_fetch_array($row);
            
            $myquery = "SELECT * FROM dt_mhssw WHERE nim ='$mydata[nim]'";
            $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
            $dataku = mysqli_fetch_assoc($dmhssw);
            
            $qp1 = "SELECT * FROM dt_pegawai WHERE id='$d[penguji1]'";
            $resp = mysqli_query($con,  $qp1 )or die( mysqli_error($con) );
            $dp1 = mysqli_fetch_assoc( $resp );
            
            $qp2 = "SELECT * FROM dt_pegawai WHERE id='$d[penguji2]'";
            $resp = mysqli_query($con,  $qp2 )or die( mysqli_error($con) );
            $dp2 = mysqli_fetch_assoc( $resp );
            
            ?>  						
         <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td><?php echo $d['jam_mulai'].' - '.$d['jam_selesai'];?></td>
            <td><?php echo $dataku['nama'].'<br />'.$dataku['nim'];?></td>
            <td><?php echo $mydata['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $mydata['judul_prop']);?></td>
            <td><?php echo $dp1['nama'];?></td>
            <td><?php echo $dp2['nama'];?></td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>