<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>JADWAL UJIAN KOMPREHENSIF <br /> 
   <?php echo "Tahap ".$dthp['tahap']." ".$djp['nm']." Semester ".$dsemester['nama']." ".$dnta['ta'];?></strong>
</p>
<div>
<?php          
   $tanggal=date("Y-m-d", strtotime($djdwl['tgl_kompre']));
   $day = date('D', strtotime($tanggal));
   $dayList = array(
   'Sun' => 'Minggu',
   'Mon' => 'Senin',
   'Tue' => 'Selasa',
   'Wed' => 'Rabu',
   'Thu' => 'Kamis',
   'Fri' => "Jum'at",
   'Sat' => 'Sabtu'
   );
   					   
      $qruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
      $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
      $druang = mysqli_fetch_assoc( $resp );
   
   ?>
<div>
   <strong>
      <table width="100%" class="tgl">
         <tr>
            <td width="16%">Hari, Tanggal</td>
            <td width="2%" class="text-center">:</td>
            <td width="82%"><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_kompre']);?></td>
         </tr>
         <tr>
            <td>Ruang</td>
            <td class="text-center">:</td>
            <td><?php echo "$druang[nm]";?></td>
         </tr>
      </table>
   </strong>
</div>
<br />