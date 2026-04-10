<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_peserta_sempro WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $resp );
  
  $qpemb1 = "select * from dt_pegawai WHERE id='$dt[dospem_tesis1]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qpemb1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dpemb1 = mysqli_fetch_assoc( $resp );
     
  $qpemb2 = "select * from dt_pegawai WHERE id='$dt[dospem_tesis2]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qpemb2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dpemb2 = mysqli_fetch_assoc( $resp );
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$dt[id_sempro]'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_sempro=$data['id'];
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
    <title>Simagis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid #ddd;
      }
      th, td {
      padding: 10px;
      }
      .border-reg {
      border: 1px solid rgba(0,0,0,0.5);
      border-radius: 4px;
      padding:4px;
      width:30%;
      float:right;
      }
      .left {
      float: left;
      width: 260px;
      }
      .right {
      float: right;
      width: 260px;
      }
    </style>
    <?php include("headUser.php");?>
  </head>
  <body>
    <?php
      include( "kopPotret.php" );
      ?>
    <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
    <br />
    <br />
    <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>FORMULIR PENDAFTARAN SEMINAR PROPOSAL TESIS<br />
      <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta'];?></strong>
    </p>
    <div>
      <table class="table custom">
        <tr>
          <td width="33%">Nama Lengkap</td>
          <td width="3%" align="center">:</td>
          <td width="64%"><?php echo "$dataku[nama]";?></td>
        </tr>
        <tr>
          <td>NIM</td>
          <td align="center">:</td>
          <td><?php echo "$dataku[nim]";?></td>
        </tr>
        <tr>
          <td valign="top">Judul Proposal Tesis</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
        </tr>
        <tr>
          <td>Dosen Pembimbing Tesis I</td>
          <td align="center">:</td>
          <td><?php echo "$dpemb1[nama]";?></td>
        </tr>
        <tr>
          <td>Dosen Pembimbing Tesis II</td>
          <td align="center">:</td>
          <td><?php echo "$dpemb2[nama]";?></td>
        </tr>
        <tr>
          <td>Kontak HP</td>
          <td align="center">:</td>
          <td><?php echo "$dataku[kntk]";?></td>
        </tr>
      </table>
    </div>
    <br />
    <br />
    <br />
    <div class="left">
      <label>
      <img src="<?php echo $dataku['photo'];?>" onError="this.onerror=null;this.src='<?php if($dataku['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="">
      </label>
    </div>
    <div class="right">
      Malang, <?php echo bulanIndo($dt['tgl_pendaftaran']);?>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <?php echo "$dataku[nama]";?>
      <br />
      NIM. <?php echo "$dataku[nim]";?>
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