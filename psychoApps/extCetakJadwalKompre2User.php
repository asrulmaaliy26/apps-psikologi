<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<div>
   <table class="jadwal">
      <thead>
         <tr>
            <th width="3%" style="text-align:center;">No.</th>
            <th width="12%" style="text-align:center;">Pukul</th>
            <th width="43%">Nama/NIM</th>
            <th width="21%" style="text-align:center;">Pengawas I</th>
            <th width="21%" style="text-align:center;">Pengawas II</th>
         </tr>
      </thead>
      <tbody style="font-size:13px;">
         <?php				           	  
            $no=0;
            $query =  "SELECT * FROM peserta_kompre WHERE id_jdwl='$djdwl[id]'";
            $row = mysqli_query($con, $query);
            while($mydata = mysqli_fetch_array($row)) {
            $no++;

            $myquery = "SELECT * FROM dt_mhssw WHERE nim ='$mydata[nim]'";
            $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
            $dataku = mysqli_fetch_assoc($dmhssw);
            
            $qp1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas1]'";
            $resp = mysqli_query($con,  $qp1 )or die( mysqli_error($con) );
            $dp1 = mysqli_fetch_assoc( $resp );
            
            $qp2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas2]'";
            $resp = mysqli_query($con,  $qp2 )or die( mysqli_error($con) );
            $dp2 = mysqli_fetch_assoc( $resp );
            
            ?>  						
         <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:center;"><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?></td>
            <td><?php echo $dataku['nama'].' ['.$dataku['nim'].']';?></td>
            <td style="text-align:center;"><?php echo $dp1['nm'];?></td>
            <td style="text-align:center;"><?php echo $dp2['nm'];?></td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>