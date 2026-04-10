<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  
  $qnl = "SELECT * FROM nama_lembaga";
  $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
  $dnl = mysqli_fetch_assoc( $resnl );
  $nm_lembaga = $dnl['nm'];
      
  $qnli = "SELECT * FROM nama_lembaga_induk";
  $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
  $dnli = mysqli_fetch_assoc( $resnli );
  $nm_lembaga_induk = $dnli['nm'];
   
  $qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
  $ressp = mysqli_query($con,  $qsp )or die( mysqli_error($con) );
  $dsp = mysqli_fetch_assoc( $ressp );
  
  $qdekanat1="SELECT * FROM dt_pegawai WHERE jabatan_instansi='2'";
  $resdekanat1=mysqli_query($con, $qdekanat1) or die (mysqli_error($con));
  $ddekanat1=mysqli_fetch_assoc($resdekanat1);
   
  $qjdekanat1="SELECT * FROM opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
  $resjdekanat1=mysqli_query($con, $qjdekanat1) or die (mysqli_error($con));
  $djdekanat1=mysqli_fetch_assoc($resjdekanat1);
   
  $qjidekanat1="SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
  $resjidekanat1=mysqli_query($con, $qjidekanat1) or die (mysqli_error($con));
  $djidekanat1=mysqli_fetch_assoc($resjidekanat1);
   
  $qkddekanat1="SELECT * FROM dekanat WHERE id='2'";
  $reskddekanat1=mysqli_query($con, $qkddekanat1) or die (mysqli_error($con));
  $dkddekanat1=mysqli_fetch_assoc($reskddekanat1);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Data Belum Mendaftar Seminar Proposal Angkatan <?php echo "$angkatan";?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid #264653;
      }
      th, td {
      padding: 10px;
      }
      .right {
      float: right;
      position:relative;
      width: 260px;
      margin-bottom:20px;
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <?php
      include( "kopPotret.php" );
      ?>
    <br>
    <span style="text-transform:uppercase;"><b>Data Belum Mendaftar Seminar Proposal Angkatan <?php echo "$angkatan";?></b>
    <br>
    <br>
    <table width="100%" style="font-size:10px;">
      <thead>
        <tr style="text-align:center;">
          <td width="4%">No.</td>
          <td width="58%">Nama</td>
          <td width="26%">Dosen Wali</td>
          <td width="12%">No. HP</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qNim = "SELECT nim FROM dt_mhssw WHERE status='1' AND angkatan='$angkatan'";
          $dNim = mysqli_query($con, $qNim)or die( mysqli_error($con));
          $dtNim = mysqli_fetch_assoc($dNim);
                            
          $sql = "SELECT * FROM dt_mhssw WHERE status='1' AND angkatan='$angkatan' AND nim NOT IN(SELECT nim FROM peserta_sempro WHERE angkatan='$angkatan') ORDER BY nama ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
                            
          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
          $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$data[dosen_wali]'";
          $res_p1 = mysqli_query($con, $qry_p1);
          $dt_p1 = mysqli_fetch_assoc($res_p1);
          $no++;
        ?>  
        <tr>
          <td> <?php echo $no;?> </td>
          <td> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
          <td> <?php echo $dt_p1['nama'];?> </td>
          <td> <?php echo $data['kntk'];?> </td>
        </tr>
        <?php
          }
          ?>
      </tbody>
    </table>
    <br />
    <br />
    <br />
    <div class="right">
      a.n. Dekan, <br />
      <?php echo $djidekanat1['nm'];?>,
      <br />
      <br />
      <br />
      <br />
      <br />
      <?php echo $ddekanat1['nama_tg'];?>
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