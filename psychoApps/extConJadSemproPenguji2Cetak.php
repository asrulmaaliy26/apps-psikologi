<?php include( "contentsConAdm.php" );
 error_reporting(E_ALL & ~E_NOTICE); ?>
<div class="table-responsive" style="margin-bottom:30px;">
   <table class="table m-0 table-bordered table-sm small custom">
      <thead>
         <tr>
            <th class="text-center pl-1" width="3%">No.</th>
            <th width="9%" class="text-center">Pukul</th>
            <th width="18%" class="text-center">Nama/NIM</th>
            <th width="32%" class="text-center">Judul Proposal Skripsi</th>
            <th width="19%" class="text-center">Narasumber I</th>
            <th width="19%" class="text-center pr-1">Narasumber II</th>
         </tr>
      </thead>
      <tbody class="text-muted" style="font-size:13px;">
         <?php				           	  
            $no=0;
            $q =  "SELECT * FROM jadwal_sempro WHERE penguji2='$data[penguji2]' AND id_sempro='$data[id_sempro]' AND tgl_seminar='$data[tgl_seminar]' ORDER BY jam_mulai ASC";
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
            <td class="text-center pl-1"><?php echo $no;?></td>
            <td class="text-center"><?php echo $d['jam_mulai'].' - '.$d['jam_selesai'];?></td>
            <td class="text-left"><?php echo $dataku['nama'].'<br />'.$dataku['nim'];?></td>
            <td class="text-left"><?php echo $mydata['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $mydata['judul_prop']);?></td>
            <td class="text-left"><?php echo $dp1['nama'];?></td>
            <td class="text-left bg-secondary pr-1"><?php echo $dp2['nama'];?></td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>