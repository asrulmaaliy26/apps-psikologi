<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
  $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $resp );
  
  $qtl = "SELECT * FROM dt_kota WHERE id='$dataku[tempat_lahir]'";
  $resp = mysqli_query($con,  $qtl )or die( mysqli_error($con) );
  $dttl = mysqli_fetch_assoc( $resp );
  
  $qjk = "SELECT * FROM jns_kelamin WHERE id='$dataku[jenis_kelamin]'";
  $resp = mysqli_query($con,  $qjk )or die( mysqli_error($con) );
  $djk = mysqli_fetch_assoc( $resp );
  
  $qdw = "SELECT * FROM dt_pegawai WHERE id='$dataku[dosen_wali]'";
  $resp = mysqli_query($con,  $qdw )or die( mysqli_error($con) );
  $ddw = mysqli_fetch_assoc( $resp );
  
  $qidpkl = "SELECT * FROM pendaftaran_pkl WHERE id='$dt[id_pkl]'";
  $resp = mysqli_query($con,  $qidpkl )or die( mysqli_error($con) );
  $dipkl = mysqli_fetch_assoc( $resp );
  $ta = $dipkl['ta'];
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
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
    <title>Pendaftaran PKL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 0px solid #ddd;
      }
      th, td {
      padding: 6px;
      vertical-align: top;
      }
      .border-reg {
      border: 1px solid rgba(0,0,0,0.5);
      border-radius: 4px;
      padding:4px;
      width:26%;
      float:right;
      }
      .right {
      float: right;
      width: 260px;
      }
      @media print {
      body {margin-top: 10mm; margin-bottom: 20mm;
      margin-left: 16mm; margin-right: 16mm}
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:1.1em;">
    <?php
      include( "kopPotretUser.php" );
      ?>
    <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
    <br/>
    <br/>
    <p style="text-align:center; text-transform:uppercase;"><strong>FORMULIR PENDAFTARAN PKL <br />
      Semester <?php echo $dsemester['nama'].' '.$dnta['ta'];?></strong>
    </p>
    <table width="100%" style="padding-left:0px;">
      <tr>
        <td width="34%">Nama Lengkap</td>
        <td width="2%" align="center">:</td>
        <td width="64%"><?php echo "$dataku[nama]";?></td>
      </tr>
      <tr>
        <td>NIM</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[nim]";?></td>
      </tr>
      <tr>
        <td>Tempat/Tanggal Lahir</td>
        <td align="center">:</td>
        <td><?php echo "$dttl[nm_kota]"."/"."$dataku[tanggal_lahir]";?></td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td align="center">:</td>
        <td><?php echo "$djk[nm]";?></td>
      </tr>
      <tr>
        <td>Alamat Asal</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[alamat_ktp]";?></td>
      </tr>
      <tr>
        <td>Alamat di Malang</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[alamat_malang]";?></td>
      </tr>
      <tr>
        <td>Nomor Handphone</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[kntk]";?></td>
      </tr>
      <tr>
        <td>Kontak Orang Terdekat</td>
        <td align="center">:</td>
        <td><?php echo "$dt[kontak_lain]";?></td>
      </tr>
      <tr>
        <td>Dosen Wali</td>
        <td align="center">:</td>
        <td><?php echo "$ddw[nama]";?></td>
      </tr>
      <tr>
        <td>Riwayat Penyakit</td>
        <td align="center">:</td>
        <td><?php echo "$dt[riwayat_penyakit]";?></td>
      </tr>
    </table>
    <br/>
    <br/>
    <br/>
    <div class="right">
      Malang, <?php echo bulanIndo($dt['tgl_pengajuan']);?>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <?php echo "$dataku[nama]";?>
      <br/>
      NIM. <?php echo "$dataku[nim]";?>
    </div>
    <div>
      <img src="<?php echo $dataku['photo'];?>" onError="this.onerror=null;this.src='<?php if($dataku['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" width="128" height="144">
    </div>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>