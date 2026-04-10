<?php include( "contentsConAdm.php" );?>
<tr valign="top" align="justify">
  <td>5.</td>
  <td>Tugas tersebut berlaku pada tanggal</td>
  <td>:</td>
  <td><?php if($dataku['awal_berlaku']==$dataku['akhir_berlaku']) { echo "".bulanIndo($dataku['awal_berlaku']);} elseif($thn1 == $thn2 && $bln1 == $bln2 && $tgl1 != $tgl2) { echo "".thnSamaBlnSamaTglTidak($dataku['awal_berlaku']).' sd. '.bulanIndo($dataku['akhir_berlaku']);} elseif($thn1 == $thn2 && $bln1 != $bln2) { echo "".thnSamaBlnTidak($dataku['awal_berlaku']).' - '.bulanIndo($dataku['akhir_berlaku']);} else { echo bulanIndo($dataku['awal_berlaku']).' sd. '.bulanIndo($dataku['akhir_berlaku']);}?></td>
</tr>
<tr valign="top" align="justify">
  <td>6.</td>
  <td>Keterangan lain-lain</td>
  <td>:</td>
  <td>
    <ol type="a">
      <li>Harap dilaksanakan dengan penuh tanggungjawab.</li>
      <li>Harap membuat laporan setelah pelaksanaan kegiatan.</li>
    </ol>
  </td>
</tr>