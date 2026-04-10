<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<p style="text-align:center; font-size:12px; text-transform:uppercase;"><strong>Jadwal Ketua Penguji (<?php echo $dqpenguji['nama'];?>)<br />
   Ujian Skripsi <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama']." ".$dnta['ta'];?></strong>
</p>
<div>
<?php          
   $tanggal1=date("d-m-Y", strtotime($djdwl['tgl_ujian']));
   $day1 = date('D', strtotime($tanggal1));
   $dayList1 = array(
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
      <table>
         <tr>
            <td>Hari, Tanggal</td>
            <td>:</td>
            <td><?php echo $dayList1[$day1].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
         </tr>
         <tr>
            <td>Ruang</td>
            <td>:</td>
            <td><?php echo "$druang[nm]";?></td>
         </tr>
      </table>
   </strong>
</div>
<br />