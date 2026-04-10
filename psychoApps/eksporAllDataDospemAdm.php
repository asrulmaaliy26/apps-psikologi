<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  
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
    <title>Rekap Dospem Skripsi Semua Periode sd. Tanggal <?php echo date('d-m-Y');?></title>
    <meta charset="utf-8">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid black;
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
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Rekap Dospem Skripsi Semua Periode sd. Tanggal '.date('d-m-Y').'.xls');
      ?> 
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="11">Rekap Dospem Skripsi Semua Periode sd. Tanggal <?php echo date('d-m-Y');?></th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="11"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
          <tr style="text-align:center;">
          <th width="4%" rowspan="2">No.</th>
          <th width="31%" rowspan="2">Nama</th>
          <th colspan="2">Pengajuan</th>
          <th colspan="2">Proses</th>
          <th colspan="2">Selesai</th>
          <th colspan="2">Total</th>
          <th rowspan="2" width="9%">Total<br> Dospem I & II</th>
        </tr>
        <tr style="text-align:center;">
          <td width="7%">Dospem I</td>
          <td width="7%">Dospem II</td>
          <td width="7%">Dospem I</td>
          <td width="7%">Dospem II</td>
          <td width="7%">Dospem I</td>
          <td width="7%">Dospem II</td>
          <td width="7%">Dospem I</td>
          <td width="7%">Dospem II</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sqlall = "SELECT * FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id GROUP BY dospem_skripsi.nip ORDER BY dt_pegawai.nama_tg ASC";
          $resultall = mysqli_query($con, $sqlall);
          while($dataall = mysqli_fetch_array($resultall)) {
          $nip=$dataall['nip'];
                            
          $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$nip'";
          $hdt_dospem = mysqli_query($con, $qdt_dospem);
          $ddospem = mysqli_fetch_array($hdt_dospem);
                            
          $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddospem[kepakaran_mayor]'";
          $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
          $dr = mysqli_fetch_assoc($rr);
                            
          $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND cek1 = '1' AND status='1'";
          $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
          $data1 = mysqli_fetch_array( $has1 );
                              
          $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND cek2 = '1' AND status='1'";
          $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
          $data2 = mysqli_fetch_array( $has2 );
                              
          $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3') AND status='2'";
          $has3 = mysqli_query($con,  $qry3 )or DIE( mysqli_error($con) );
          $data3 = mysqli_fetch_array( $has3 );
                              
          $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3') AND status='2'";
          $has4 = mysqli_query($con,  $qry4 )or DIE( mysqli_error($con) );
          $data4 = mysqli_fetch_array( $has4 );
                              
          $qry5 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3') AND status='3'";
          $has5 = mysqli_query($con,  $qry5 )or DIE( mysqli_error($con) );
          $data5 = mysqli_fetch_array( $has5 );
                              
          $qry6 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3') AND status='3'";
          $has6 = mysqli_query($con,  $qry6 )or DIE( mysqli_error($con) );
          $data6 = mysqli_fetch_array( $has6 );
                              
          $qry7 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$dataall[nip]' AND (cek1='2' OR cek1='3')";
          $has7 = mysqli_query($con,  $qry7 )or DIE( mysqli_error($con) );
          $data7 = mysqli_fetch_array( $has7 );
                            
          $qry8 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$dataall[nip]' AND (cek2='2' OR cek2='3')";
          $has8 = mysqli_query($con,  $qry8 )or DIE( mysqli_error($con) );
          $data8 = mysqli_fetch_array( $has8 );
                            
          $totalsatudua = ($data7['jumData'] + $data8['jumData']);
          $no++;
          ?> 
        <tr>
          <td style="text-align:center;"> <?php echo $no;?> </td>
          <td style="text-align:left;"> <?php echo $ddospem['nama_tg'];?> </td>
          <td style="text-align:center;"> <?php echo $data1['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data2['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data3['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data4['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data5['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data6['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data7['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $data8['jumData'];?> </td>
          <td style="text-align:center;"> <?php echo $totalsatudua;?> </td>
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
         window.close(); 
      });
    </script>
  </body>
</html>