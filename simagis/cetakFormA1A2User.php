<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id_ujtes' ] );
  $id_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id_pendaftaran' ] );
  
  $myquery = "SELECT * FROM mag_peserta_ujtes WHERE id_ujtes='$id_ujtes' AND id='$id_pendaftaran'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $res );
  
  $myquery = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $dmhssw );
  
  $qjl = "SELECT * FROM nama_jurusan_lembaga";
  $resjl = mysqli_query($GLOBALS["___mysqli_ston"],  $qjl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djl = mysqli_fetch_assoc( $resjl );
  $nm_jurusan_lembaga = $djl['nm'];
  
  $qnl = "SELECT * FROM nama_lembaga";
  $resnl = mysqli_query($GLOBALS["___mysqli_ston"],  $qnl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dnl = mysqli_fetch_assoc( $resnl );
  $nm_lembaga = $dnl['nm'];
  
  $qnli = "SELECT * FROM nama_lembaga_induk";
  $resnli = mysqli_query($GLOBALS["___mysqli_ston"],  $qnli )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dnli = mysqli_fetch_assoc( $resnli );
  $nm_lembaga_induk = $dnli['nm'];
  
  $q = "SELECT * FROM mag_pengelompokan_dosen_wali AS mpdw JOIN mag_dosen_wali AS mdw ON mdw.id = mpdw.dosen_wali JOIN dt_pegawai AS dp ON dp.id = mdw.nip WHERE nim='$dt[nim]'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dtdw = mysqli_fetch_assoc($r);
     
  $qry = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$dataku[nim]'";
  $has = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data = mysqli_fetch_assoc($has);
               
  $qdw1 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis1]'";
  $rdw1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddw1 = mysqli_fetch_assoc($rdw1);
               
  $qdp1 = "SELECT * FROM dt_pegawai WHERE id='$ddw1[nip]'";
  $rdp1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddp1 = mysqli_fetch_assoc($rdp1);
               
  $qdw2 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis2]'";
  $rdw2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddw2 = mysqli_fetch_assoc($rdw2);
               
  $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$ddw2[nip]'";
  $rdp2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddp2 = mysqli_fetch_assoc($rdp2);   
  
  $qdk= "SELECT * FROM dt_kota WHERE id='$dataku[tempat_lahir]'";
  $resdk = mysqli_query($GLOBALS["___mysqli_ston"],  $qdk )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $ddk = mysqli_fetch_assoc( $resdk );
  
  $qjk= "SELECT * FROM jns_kelamin WHERE id='$dataku[jenis_kelamin]'";
  $resjk = mysqli_query($GLOBALS["___mysqli_ston"],  $qjk )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djk = mysqli_fetch_assoc( $resjk );
  
  $qpa= "select * from jns_pkrjn WHERE id='$dataku[pekerjaan_ayah]'";
  $respa = mysqli_query($GLOBALS["___mysqli_ston"],  $qpa )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dpa = mysqli_fetch_assoc( $respa );
  
  $qpi= "select * from jns_pkrjn WHERE id='$dataku[pekerjaan_ibu]'";
  $respi = mysqli_query($GLOBALS["___mysqli_ston"],  $qpi )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dpi = mysqli_fetch_assoc( $respi );
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$id_ujtes'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_ujtes=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
                   
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                   
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                   
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $jdwl = "SELECT * FROM mag_jadwal_ujtes WHERE id='$dt[id_jdwl]'";
  $rjdwl = mysqli_query($GLOBALS["___mysqli_ston"],  $jdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djdwl = mysqli_fetch_assoc( $rjdwl );
  
  $qruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qruang )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $druang = mysqli_fetch_assoc( $resp );
  
  $qpl = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qpl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp1 = mysqli_fetch_assoc($row);
             
  $qp2 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji2]'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp2 = mysqli_fetch_assoc($row);
    
  $qp3 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji3]'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp3 = mysqli_fetch_assoc($row);
    
  $qp4 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji4]'";
  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp4 = mysqli_fetch_assoc($row);
  
  $qnilai = "SELECT * FROM mag_nilai_ujtes WHERE id_pendaftaran='$id_pendaftaran'";
  $rnilai = mysqli_query($GLOBALS["___mysqli_ston"],  $qnilai )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dnilai = mysqli_fetch_assoc($rnilai);
  
  $nilaiakhir = ($dnilai['mean_nilai_penguji1'] + $dnilai['mean_nilai_penguji2'] + $dnilai['mean_nilai_penguji3'] + $dnilai['mean_nilai_penguji4']) / 4;
  $nilaibulat = round($nilaiakhir);
  
  $qrevisi= "SELECT * FROM mag_revisi_tesis WHERE id_ujtes='$id_ujtes' AND id_peserta='$id_pendaftaran'";
  $resrevisi = mysqli_query($GLOBALS["___mysqli_ston"],  $qrevisi )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $drevisi = mysqli_fetch_assoc( $resrevisi );
  
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
  
  function bulanIndo($tanggal)
  {
  $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
  'September','Oktober','Nopember','Desember');
  $split = explode('-', $tanggal);
  return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
  }   
  
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Simagis Form A1 dan A2_<?php echo $dataku['nama'];?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.biodata {
      border-collapse: collapse;
      text-transform:uppercase;
      }
      table.biodata tr, td {
      vertical-align: top;
      }
      table.biodata td {
      border:none;
      padding: 2px;
      }
      table.a {
      border-collapse: collapse;
      text-transform:uppercase;
      }
      table.a tr, td {
      vertical-align: top;
      }
      table.a td {
      border:none;
      padding: 4px;
      }
      table.a-1 {
      border-collapse: collapse;
      text-transform:uppercase;
      }
      table.a-1 tr, td {
      vertical-align: top;
      }
      table.a-1 td {
      border:none;
      padding: 3px;
      }
      table.a-2 {
      border-collapse: collapse;
      text-transform:uppercase;
      font-size: 0.9em;
      }
      table.a-2 tr, td {
      vertical-align: top;
      }
      table.a-2 td {
      border:none;
      padding: 3px;
      }
      table.a-2-1 {
      border: 1px solid #000000;
      border-collapse: collapse;
      }
      table.a-2-1 tr, td {
      vertical-align: top;
      }
      table.a-2-1 td {
      border:none;
      padding: 3px;
      }
      table.a-2-2 {
      border-collapse: collapse;
      }
      table.a-2-2 tr, td {
      vertical-align: top;
      }
      table.a-2-2 td {
      border:none;
      padding: 3px;
      }
      table.foto {
      border: 1px solid #000000;
      width: 100%;
      height: 170px;
      text-align: left;
      border-collapse: collapse;
      }
      table.foto td, table.foto th {
      border: 1px solid #000000;
      padding: 2px 2px 2px 2px;
      }
      table.ket {
      width: 100%;
      text-align: left;
      border-collapse: collapse;
      }
      .right-photo {
      float: right;
      position: absolute;
      top: 130px;
      right: 9.5px;
      }
      .right-ttd {
      float: right;
      width: 280px;
      text-transform:uppercase;
      }      
      .border-format {
      border: 1px solid rgba(0,0,0,0.5);
      border-radius: 4px;
      padding:4px;
      width:22%;
      float:left;
      }
      .border-reg {
      border: 1px solid rgba(0,0,0,0.5);
      border-radius: 4px;
      padding:4px;
      width:26%;
      float:right;
      }
      @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }      
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:15px;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
      <br />     
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>BUKTI KEIKUTSERTAAN UJIAN TESIS</strong></p>
      <div class="right-photo">
        <?php if(empty($dataku['photo'])) { if($dataku['jenis_kelamin']=="1") { echo '<img src="images/cewek.png"  width="84rem" height="94rem" />';} else { echo '<img src="images/cowok.png" width="84rem" height="94rem" />';}} else { echo '<img src="'.$dataku['photo'].'" width="84rem" height="94rem" />';}?>
      </div>
      <div>
        <p style="margin-bottom:2px;"><strong>DATA UMUM</strong></p>
        <table width="100%" class="biodata">
          <tr>
            <td width="36%">NIM</td>
            <td width="2%" align="center">:</td>
            <td width="62%"><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
          </tr>
          <tr>
            <td>Nama Lengkap</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
          </tr>
          <tr>
            <td valign="top">Judul Tesis</td>
            <td align="center" valign="top">:</td>
            <td valign="top"><?php echo $dt['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']);?></td>
          </tr>
          <tr>
            <td>Dosen Pembimbing Tesis I</td>
            <td align="center">:</td>
            <td><?php echo "$ddp1[nama]";?></td>
          </tr>
          <tr>
            <td>Dosen Pembimbing Tesis II</td>
            <td align="center">:</td>
            <td><?php echo "$ddp2[nama]";?></td>
          </tr>
        </table>
        <p style="margin-bottom:2px;"><strong>DATA UJIAN</strong></p>
        <table width="100%" class="biodata">
          <tr>
            <td width="36%">Periode Ujian</td>
            <td width="2%" align="center">:</td>
            <td width="62%"><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></td>
          </tr>
          <tr>
            <td>Tanggal Mendaftar Ujian</td>
            <td align="center">:</td>
            <td><?php echo bulanIndo($dt['tgl_pendaftaran']);?></td>
          </tr>
          <tr>
            <td>Tanggal Pelaksanaan Ujian</td>
            <td align="center">:</td>
            <td><?php echo bulanIndo($djdwl['tgl_ujian']);?></td>
          </tr>
          <tr>
            <td>Waktu Pelaksanaan Ujian</td>
            <td align="center">:</td>
            <td><?php echo $djdwl['jam_mulai'].' s.d '.$djdwl['jam_selesai'];?> WIB.</td>
          </tr>
          <tr>
            <td>Ruang Pelaksanaan Ujian</td>
            <td align="center">:</td>
            <td><?php echo $druang['nm'];?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td align="center">:</td>
            <td><?php echo $dp3['nama'];?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td align="center">:</td>
            <td><?php echo $dp4['nama'];?></td>
          </tr>
          <tr>
            <td>Pembimbing I</td>
            <td align="center">:</td>
            <td><?php echo $dp1['nama'];?></td>
          </tr>
          <tr>
            <td>Pembimbing II</td>
            <td align="center">:</td>
            <td><?php echo $dp2['nama'];?></td>
          </tr>
          <tr>
            <td>Nilai Ujian</td>
            <td align="center">:</td>
            <td><?php echo $nilaibulat;?> (<?php if($nilaibulat >=85 && $nilaibulat <= 100) { echo 'A';} if($nilaibulat >=75 && $nilaibulat <= 84) { echo 'B+';} if($nilaibulat >=70 && $nilaibulat <= 74) { echo 'B';} if($nilaibulat >=65 && $nilaibulat <= 69) { echo 'C+';} if($nilaibulat >=60 && $nilaibulat <= 64) { echo 'C';} if($nilaibulat < 60) { echo 'D';}?>)</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right-ttd" style="margin-bottom:20px;">
        Malang, _____ - _____ - ________<br />
        Admin,
        <br />
        <br />
        <br />
        <br />
        <br />
        ______________________________
      </div>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
      <div class="border-format"><code>FORMAT MODEL: A-1</code></div>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>IDENTITAS PESERTA UJIAN TESIS <br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
      </p>
      <div>
        <table width="100%" class="a-1">
          <tr>
            <td width="36%">Nama Lengkap *)</td>
            <td width="2%" align="center">:</td>
            <td width="62%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
          </tr>
          <tr>
            <td >NIM</td>
            <td>:</td>
            <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
          </tr>
          <tr>
            <td>Angkatan</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
          </tr>
          <tr>
            <td>Program Studi</td>
            <td align="center">:</td>
            <td>Magister Psikologi</td>
          </tr>
          <tr>
            <td>Judul Tesis Setelah Revisi</td>
            <td align="center">:</td>
            <td><?php echo $drevisi['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $drevisi['judul_tesis']);?></td>
          </tr>
          <tr>
            <td>Dosen Pembimbing Tesis I</td>
            <td align="center">:</td>
            <td><?php echo "$ddp1[nama]";?></td>
          </tr>
          <tr>
            <td>Dosen Pembimbing Tesis II</td>
            <td align="center">:</td>
            <td><?php echo "$ddp2[nama]";?></td>
          </tr>
          <tr>
            <td>Riwayat Pendidikan Terakhir</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['jenis_kelamin'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djk[nm]";}?></td>
          </tr>
          <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
          </tr>
          <tr>
            <td>Alamat di Malang</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['alamat_malang'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_malang]";}?></td>
          </tr>
          <tr>
            <td>No.Telp/HP</td>
            <td align="center">:</td>
            <td><?php echo "$dataku[kntk]";?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td align="center">:</td>
            <td style="text-transform:lowercase"><?php if(empty($dataku['email'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[email]";}?></td>
          </tr>
          <tr>
            <td>Nama Ayah</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
          </tr>
          <tr>
            <td>Alamat Ayah</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
          </tr>
          <tr>
            <td>Nama Ibu</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
          </tr>
          <tr>
            <td>Alamat Ibu</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right-ttd" style="margin-bottom:20px;">
        Malang, _____ - _____ - ________<br />
        Admin,
        <br />
        <br />
        <br />
        <br />
        <br />
        ______________________________
      </div>
      <div>
        <table class="foto">
          <tbody>
            <tr>
              <td style="vertical-align:middle; text-align: center;"><small>6 lembar foto, nama dan NIM ditulis dibaliknya dan ditempel di sini dengan sedikit perekat dibaliknya.</small></td>
            </tr>
          </tbody>
        </table>
      </div>
      <span><small> *) Nama lengkap harus sama dengan KTP, Kartu Keluarga dan ijazah-ijazah dari sekolah/perguruan tinggi sebelumnya.</small></span>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
      <div class="border-format"><code>FORMAT MODEL: A-2</code></div>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>BLANGKO ISIAN UNTUK PENULISAN IJAZAH</strong></p>
      <div>
        <table width="100%" class="a-2">
          <tr>
            <td width="36%">Nama Lengkap *)</td>
            <td width="2%" align="center">:</td>
            <td width="62%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
          </tr>
          <tr>
            <td >NIM</td>
            <td>:</td>
            <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
          </tr>
          <tr>
            <td>Angkatan</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
          </tr>
          <tr>
            <td>Program Studi</td>
            <td align="center">:</td>
            <td>Magister Psikologi</td>
          </tr>
          <tr>
            <td>Judul Tesis Setelah Revisi</td>
            <td align="center">:</td>
            <td><?php echo $drevisi['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $drevisi['judul_tesis']);?></td>
          </tr>
          <tr>
            <td>Nilai Ujian</td>
            <td align="center">:</td>
            <td><?php echo $nilaibulat;?> (<?php if($nilaibulat >=85 && $nilaibulat <= 100) { echo 'A';} if($nilaibulat >=75 && $nilaibulat <= 84) { echo 'B+';} if($nilaibulat >=70 && $nilaibulat <= 74) { echo 'B';} if($nilaibulat >=65 && $nilaibulat <= 69) { echo 'C+';} if($nilaibulat >=60 && $nilaibulat <= 64) { echo 'C';} if($nilaibulat < 60) { echo 'D';}?>)</td>
          </tr>
          <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
          </tr>
          <tr>
            <td>Riwayat Pendidikan Terakhir</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
          </tr>
          <tr>
            <td>Nama Ayah</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
          </tr>
          <tr>
            <td>Alamat Ayah</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
          </tr>
          <tr>
            <td>Nama Ibu</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
          </tr>
          <tr>
            <td>Alamat Ibu</td>
            <td align="center">:</td>
            <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right-ttd" style="margin-bottom:20px;">
        Malang, <?php echo bulanIndo($drevisi['tgl_upload']);?>
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dataku[nama]";?>
        <br />
        NIM. <?php echo "$dataku[nim]";?>
      </div>
      <br />
      <div style="margin:0 auto; width:76%;">
        <table width="100%" class="a-2-1">
          <tr>
            <td width="4%">1.</td>
            <td width="96%">Data di atas telah diteliti, selanjutnya form di bawah diisi oleh admin.</td>
          </tr>
          <tr>
            <td>2.</td>
            <td>Admin bertanggungjawab atas kebenaran data yang tertera pada ijazah.</td>
          </tr>
        </table>
      </div>
      <br />   
      <div>
        <table width="100%" class="a-2-2">
          <tr>
            <td width="30%">Nomor Ijazah</td>
            <td width="2%" align="center">:</td>
            <td colspan="4" style="border-bottom:1px solid #666666;"><?php if(empty($dataku['no_ijazah'])) { echo "";} else { echo $dataku['no_ijazah'];}?></td>
          </tr>
          <tr>
            <td>Jumlah SKS/SKS*N</td>
            <td align="center">:</td>
            <td colspan="4" style="border-bottom:1px solid #666666; text-align:center;">/</td>
          </tr>
          <tr>
            <td>IPK/Yudisium</td>
            <td align="center">:</td>
            <td colspan="4" style="border-bottom:1px solid #666666;"></td>
          </tr>
          <tr>
            <td>Wisuda ke/Semester</td>
            <td align="center">:</td>
            <td colspan="3" style="border-bottom:1px solid #666666; text-align:center;">/</td>
            <td width="14%" style="border-bottom:1px solid #666666;">20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/20</td>
          </tr>
          <tr>
            <td>Persyaratan Administrasi</td>
            <td align="center">:</td>
            <td width="12%">&#9744; Lengkap</td>
            <td width="12%">&#9744; Kurang:</td>
            <td colspan="2" style="border-bottom:1px solid #666666;">&nbsp;</td>
          </tr>
          <tr style="display:none;">
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="30%">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right-ttd" style="margin-bottom:20px;">
        Malang, _____ - _____ - ________<br />
        Admin,
        <br />
        <br />
        <br />
        <br />
        <br />
        ______________________________
      </div>
      <div>
        <table class="foto">
          <tbody>
            <tr>
              <td style="vertical-align:middle; text-align: center;"><small>5 lembar foto, nama dan NIM ditulis dibaliknya dan ditempel di sini dengan sedikit perekat dibaliknya.</small></td>
            </tr>
          </tbody>
        </table>
      </div>
      <span><small> *) Nama lengkap harus sama dengan KTP, Kartu Keluarga dan ijazah-ijazah dari sekolah/perguruan tinggi sebelumnya.</small></span>
    </div>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
      <br />     
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>PETUNJUK TENTANG PENYERAHAN BERKAS SETELAH UPLOAD REVISI TESIS</strong></p>
      <p>Berkas-berkas yang wajib diserahkan ke Kantor Bagian Administrasi Akademik Magister Psikologi Universitas Islam Negeri Maulana Malik Ibrahim Malang:</p>
      <ol type="A">
        <li>
          FOTO
          <ol type="1">
            <li>Foto <b>berwarna</b> terbaru dengan <b>background putih</b> ukuran 3 X 4 cm sebanyak 11 lembar.</li>
            <li>Foto dengan <b>kertas dof</b> (tidak mengkilap).</li>
            <li>Bagi pria: memakai kemeja putih, jas almamater, berdasi dan tanpa tutup kepala, tidak berkacamata, daun telinga harus kelihatan, rambut rapi dan tidak memakai aksesoris berlebihan.</li>
            <li>Bagi wanita: memakai  kemeja putih, jas almamater, dan memakai jilbab warna hitam, tidak diperkenankan bercadar, tidak berkacamata, tidak bersanggul, dan tidak memakai aksesoris berlebihan.</li>
            <li>
              Penempatan foto diatur sebagai berikut:
              <ol type="a">
                <li>6 lembar foto, dituliskan nama dan NIM dibalik foto, diberi sedikit perekat dibalik foto, ditempelkan pada kolom yang tersedia pada format A-1.</li>
                <li>5 lembar foto, dituliskan nama dan NIM dibalik foto, diberi sedikit perekat dibalik foto, ditempelkan pada kolom yang tersedia pada format A-1.</li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          BUKTI KEIKUTSERTAAN UJIAN TESIS, FORMAT A1 DAN A2
          <ol type="1">
            <li>Bukti Keikutsertaan Ujian Tesis, Format A1 dan A2 didownload/dicetak setelah melakukan upload revisi tesis di Simagis dan telah diverifikasi oleh admin.</li>
            <li>Format A1 telah ditempelkan foto (6 lembar) pada kolom yang tersedia.</li>
            <li>Format A2 telah ditempelkan foto (5 lembar) pada kolom yang tersedia, dan telah ditandatangani oleh mahasiswa yang bersangkutan.</li>
          </ol>
        </li>
        <li>
          BERKAS LAIN
          <ol type="1">
            <li>1 Lembar fotokopi ijazah SLTA yang diligalisir.</li>
            <li>1 Lembar fotokopi ijazah S1 yang dilegalisir.</li>
          </ol>
        </li>
      </ol>
      <p>Semua berkas dimasukkan ke dalam map kertas berwarna biru yang bertuliskan nama dan NIM di bagian depan map (kolom bergaris), dengan urutan sebagai berikut:</p>
      <ol type="A">
        <li>Bukti Keikutsertaan Ujian Tesis</li>
        <li>Format A1</li>
        <li>Format A2</li>
        <li>Fotokopi ijazah SLTA</li>
        <li>Fotokopi ijazah S1.</li>
      </ol>
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>