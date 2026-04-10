<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE); ?>
<div class="table-responsive" style="margin-bottom:10px;">
  <table class="table m-0 table-bordered table-sm small custom">
    <thead>
      <tr>
        <th class="text-left pl-1" width="10%">Hari, Tanggal</th>
        <th width="2%" class="text-center">:</th>
        <th width="64%"class="text-left"><?php if(empty($data['tgl_ujian']))  { echo "";} else { echo $dayList[$day].', '.bulanIndo($data['tgl_ujian']);}?></th>
        <th width="24%" class="text-center pr-1">Opsi</th>
      </tr>
      <tr>
        <th class="text-left pl-1">Ruang</th>
        <th class="text-center">:</th>
        <th class="text-left"><?php if(empty($data['ruang']))  { echo "";} else { echo $dt_ruang['nm'];}?></th>
        <th class="text-center pr-1">
          <?php if(empty($data['tgl_ujian']) && empty($data['ruang'])) { echo "<a type='button' class='btn btn-outline-secondary btn-flat btn-xs btn-block' title='Jadwal belum bisa dicetak' onclick='return confirm(\"Jadwal belum bisa dicetak\")'><i class='fas fa-print'></i> Jadwal Belum Bisa Dicetak</a>";} else { echo '<a type="button" href="cetakJadwalUjskripPerPeriodeUser.php?id='.$data['id'].'" class="btn btn-success btn-flat btn-xs btn-block" title="Cetak jadwal" target="_blank"><i class="fas fa-print"></i> Cetak Jadwal</a>';}?>
        </th>
      </tr>
    </thead>
  </table>
</div>