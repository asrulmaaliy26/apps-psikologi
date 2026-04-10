<?php
   include("koneksiAdm.php");
   $username = $_SESSION['username'];
   ?>
<div class="table-responsive">
   <strong>
      <table width="100%" class="table table-condensed table-bordered custom">
         <tr>
            <td width="10%">Hari, Tanggal</td>
            <td width="2%" class="text-center">:</td>
            <td width="68%"><?php if(empty($data['tgl_seminar']))  { echo "";} else { echo $dayList[$day].', '.bulanIndo($data['tgl_seminar']);}?></td>
            <td width="20%" class="text-center">Opsi</td>
         </tr>
         <tr>
            <td>Ruang</td>
            <td class="text-center">:</td>
            <td><?php if(empty($data['ruang']))  { echo "";} else { echo $druang['nm'];}?></td>
            <td class="text-center">
               <?php if(empty($data['tgl_seminar']) && empty($data['ruang'])) { echo "<a role='button' class='btn btn-default btn-sm btn-block disabled' title='Jadwal seminar belum bisa dicetak'><span class='glyphicon glyphicon-print'></span></a>";} else { echo '<a role="button" href="cetakJadwalSempro.php?id='.$data['id'].'" class="btn btn-default btn-sm btn-block" title="Cetak jadwal seminar" target="_blank"><span class="glyphicon glyphicon-print"></span></a>';}?>
            </td>
         </tr>
      </table>
   </strong>
</div>