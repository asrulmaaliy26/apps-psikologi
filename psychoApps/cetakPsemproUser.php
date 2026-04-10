<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $username = $_SESSION[ 'username' ];
  $myquery = "SELECT * FROM peserta_sempro WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qry = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $resp );
  
  $qpemb1 = "SELECT * FROM dt_pegawai WHERE id='$dt[pembimbing1]'";
  $resp = mysqli_query($con,  $qpemb1 )or die( mysqli_error($con) );
  $dpemb1 = mysqli_fetch_assoc( $resp );
     
  $qpemb2 = "SELECT * FROM dt_pegawai WHERE id='$dt[pembimbing2]'";
  $resp = mysqli_query($con,  $qpemb2 )or die( mysqli_error($con) );
  $dpemb2 = mysqli_fetch_assoc( $resp );
  
  $qry_moment = "SELECT * FROM pendaftaran_sempro WHERE id='$dt[id_sempro]'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_sempro=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
  
  $qry_nm_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
  $hasil = mysqli_query($con, $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
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
    <title>Pendaftaran Seminar Proposal Skripsi</title>
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
    <p style="text-align:center; text-transform:uppercase;"><strong>FORMULIR PENDAFTARAN SEMINAR PROPOSAL SKRIPSI <br />
      Semester <?php echo $dsemester['nama'].' '.$dnta['ta'];?></strong>
    </p>
    <table width="100%" style="padding-left:0px;">
      <tr>
        <td width="38%">Nama Lengkap</td>
        <td width="2%" align="center">:</td>
        <td width="60%"><?php echo "$dataku[nama]";?></td>
      </tr>
      <tr>
        <td>NIM</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[nim]";?></td>
      </tr>
      <tr>
        <td valign="top">Judul Proposal Skripsi</td>
        <td align="center" valign="top">:</td>
        <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
      </tr>
      <tr>
        <td>Dosen Pembimbing Skripsi I</td>
        <td align="center">:</td>
        <td><?php echo "$dpemb1[nama]";?></td>
      </tr>
      <tr>
        <td>Dosen Pembimbing Skripsi II</td>
        <td align="center">:</td>
        <td><?php echo "$dpemb2[nama]";?></td>
      </tr>
      <tr>
        <td>Kontak HP</td>
        <td align="center">:</td>
        <td><?php echo "$dataku[kntk]";?></td>
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