<?php include( "contentsConAdm.php" );
 error_reporting(E_ALL & ~E_NOTICE); ?>
<div class="table-responsive" style="margin-bottom:30px;">
   <table class="table m-0 table-bordered table-sm small custom">
      <thead>
         <tr>
            <th class="text-center pl-1" width="3%">No.</th>
            <th width="9%" class="text-center">Pukul</th>
            <th width="50%" class="text-center">Nama/NIM</th>
            <th width="19%" class="text-center">Pengawas I</th>
            <th width="19%" class="text-center pr-1">Pengawas II</th>
         </tr>
      </thead>
      <tbody class="text-muted" style="font-size:13px;">
         <?php				           	  
            $no=0;
            $query =  "SELECT * FROM peserta_kompre WHERE id_jdwl='$data[id]'";
            $row = mysqli_query($con, $query);
            while($mydata = mysqli_fetch_array($row)) {
            $no++;
            
            $myquery = "SELECT * FROM dt_mhssw WHERE nim ='$mydata[nim]'";
            $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
            $dataku = mysqli_fetch_assoc($dmhssw);
            
            $qp1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$data[pengawas1]'";
            $resp = mysqli_query($con,  $qp1 )or die( mysqli_error($con) );
            $dp1 = mysqli_fetch_assoc( $resp );
            
            $qp2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$data[pengawas2]'";
            $resp = mysqli_query($con,  $qp2 )or die( mysqli_error($con) );
            $dp2 = mysqli_fetch_assoc( $resp );
            ?>  						
         <tr>
            <td class="text-center pl-1"><?php echo $no;?></td>
            <td class="text-center"><?php echo $data['jam_mulai'].' - '.$data['jam_selesai'];?></td>
            <td class="text-left"><?php echo $dataku['nama'].' ['.$dataku['nim'].']';?></td>
            <td class="text-center"><?php echo $dp1['nm'];?></td>
            <td class="text-center pr-1"><?php echo $dp2['nm'];?></td>
         </tr>
         <?php 
            }
            ?>
      </tbody>
   </table>
</div>