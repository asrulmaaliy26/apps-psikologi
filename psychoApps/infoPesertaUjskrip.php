<?php include( "contentsConAdm.php" );?>
<table class="info">
  <tbody>
    <tr>
      <td width="22%">Nama Mahasiswa</td>
      <td width="2%">:</td>
      <td width="76%"><?php echo strtoupper($dataku['nama']);?></td>
    </tr>
    <tr>
      <td>NIM</td>
      <td>:</td>
      <td><?php echo $dataku['nim'];?></td>
    </tr>
    <tr>
      <td>Jurusan</td>
      <td>:</td>
      <td>PSIKOLOGI</td>
    </tr>
    <tr>
      <td>Hari Tanggal Ujian</td>
      <td>:</td>
      <td><?php echo strtoupper($dayList[$day]).' '.strtoupper(bulanIndo($djdwl['tgl_ujian']));?></td>
    </tr>
    <tr>
      <td>Ruang Ujian</td>
      <td>:</td>
      <td><?php echo strtoupper($druang['nm']);?></td>
    </tr>
    <tr>
      <td>Judul Skripsi</td>
      <td>:</td>
      <td><?php echo strtoupper($dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']));?></td>
    </tr>
    <tr>
      <td>Pembimbing</td>
      <td>:</td>
      <td><?php if(empty($dp2['dospem_skripsi2'])) { echo strtoupper($dp1['nama']);} else { echo '1. ' .strtoupper($dp1['nama']). '<br/>'.'2. ' .strtoupper($dp2['nama']);}?></td>
    </tr>
    <tr>
      <td>Penguji Utama</td>
      <td>:</td>
      <td><?php echo strtoupper($dPengUtama['nama']);?></td>
    </tr>
    <tr>
      <td>Ketua Penguji</td>
      <td>:</td>
      <td><?php echo strtoupper($dPengKetua['nama']);?></td>
    </tr>
    <tr>
      <td>Sekretaris Penguji</td>
      <td>:</td>
      <td><?php echo strtoupper($dPengSekretaris['nama']);?></td>
    </tr>
  </tbody>
</table>