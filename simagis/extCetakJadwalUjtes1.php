<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   ?>
<p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>JADWAL UJIAN TESIS <br /> 
   <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama']." TA. ".$dnta['ta'];?></strong>
</p>
<div>
<?php          
   $tanggal=date("d-m-Y", strtotime($djdwl['tgl_ujian']));
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
   					   
      $qruang = "select * from dt_ruang WHERE id='$djdwl[ruang]'";
      $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qruang )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
      $druang = mysqli_fetch_assoc( $resp );
   
   ?>
<div>
   <strong>
      <table width="100%" class="tgl">
         <tr>
            <td width="15%">Hari, Tanggal</td>
            <td width="2%" class="text-center">:</td>
            <td width="73%"><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
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