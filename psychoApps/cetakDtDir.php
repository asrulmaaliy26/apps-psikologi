<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM dt_ruang WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qry_kat = "SELECT * FROM opsi_kat_ruang WHERE id='$dt[kategori]'";
  $r_kat = mysqli_query($con, $qry_kat);
  $d_kat = mysqli_fetch_assoc($r_kat);
                           
  $qry_model = "SELECT * FROM opsi_model_ruang WHERE id='$dt[model]'";
  $r_model = mysqli_query($con, $qry_model);
  $d_model = mysqli_fetch_assoc($r_model);
  
  $qry_dir = "SELECT * FROM dt_inventaris_barang WHERE letak='$dt[id]'";
  $r_dir = mysqli_query($con, $qry_dir);
  $d_dir = mysqli_fetch_assoc($r_dir);
  
  $qry_jum_inv = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang WHERE letak='$dt[id]'";
  $r_jum_inv = mysqli_query($con,  $qry_jum_inv )or DIE( mysqli_error($con) );
  $d_jum_inv = mysqli_fetch_assoc( $r_jum_inv );
  
  $qnl = "SELECT * FROM nama_lembaga";
  $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
  $dnl = mysqli_fetch_assoc( $resnl );
  $nm_lembaga = $dnl['nm'];
  
  $qnli = "SELECT * FROM nama_lembaga_induk";
  $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
  $dnli = mysqli_fetch_assoc( $resnli );
  $nm_lembaga_induk = $dnli['nm'];
  
  $q_pejabat="SELECT * FROM dt_pegawai WHERE jabatan_instansi='28'";
  $r_pejabat=mysqli_query($con, $q_pejabat) or die (mysqli_error($con));
  $d_pejabat=mysqli_fetch_assoc($r_pejabat);
  
  $q_nm_jbtn="SELECT * FROM opsi_jabatan_instansi WHERE id='$d_pejabat[jabatan_instansi]'";
  $r_nm_jbtn=mysqli_query($con, $q_nm_jbtn) or die (mysqli_error($con));
  $d_nm_jbtn=mysqli_fetch_assoc($r_nm_jbtn);
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Daftar Barang Ruangan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      @media print {
      body {
        margin-top: 10mm;
        margin-bottom: 20mm;
        margin-right: 20mm;
        margin-left: 30mm;
        }
      }
      .table_ruang {
         width: 100%;
         vertical-align: middle;
         text-align: left;
         font-family:Arial, Helvetica, sans-serif; font-size:1em;
      }
      .table_ruang th,td {
         border: 0;
      }
      .table_dbr {
         width: 100%;
         border-collapse:collapse;
         vertical-align: middle;
         text-align: left;
         font-family:Arial, Helvetica, sans-serif; font-size:0.9em;
      }
      .table_dbr th {
         text-align: center;
      }
      .table_dbr th,td {
         padding: 4px;
         border: 1px solid;
         border-collapse: collapse;
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
    <br />
    <strong>
      <center>DAFTAR BARANG RUANGAN</center>
    </strong>
    <br />
    <br />
    <table class="table_ruang">
      <thead>
        <tr>
          <th width="20%">Nama Ruang</th>
          <th width="2%">:</th>
          <th width="78%"><?php echo $dt['nm']?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Kategori</th>
          <th>:</th>
          <th><?php echo $d_kat['nm']?></th>
        </tr>
        <tr>
          <th>Jenis</th>
          <th>:</th>
          <th><?php echo $d_model['nm']?></th>
        </tr>
        <tr>
          <th>Jumlah DBR</th>
          <th>:</th>
          <th><?php echo $d_jum_inv['jumData']?></th>
        </tr>
      </tbody>
    </table>
    <br/>
    <table class="table_dbr">
      <thead>
        <tr>
          <th width="3%">No.</th>
          <th width="14%">Kode Barang</th>
          <th width="40%">Nama Barang</th>
          <th width="16%">Kategori</th>
          <th width="16%">Merk</th>
          <th width="11%">Kondisi</th>
        </tr>
      </thead>
      <?php
        $no=0;
        $qry_dbr = "SELECT * FROM dt_inventaris_barang WHERE letak='$dt[id]'";
        $r_dbr = mysqli_query($con, $qry_dbr);
        WHILE($d_dbr = mysqli_fetch_assoc($r_dbr)) {
        
        $no++;
        $qry_kat = "SELECT * FROM opsi_kat_barang WHERE id='$d_dbr[kategori]'";
        $r_kat = mysqli_query($con, $qry_kat);
        $d_kat = mysqli_fetch_assoc($r_kat);
        
        $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$d_dbr[merk]'";
        $r_merk = mysqli_query($con, $qry_merk);
        $d_merk = mysqli_fetch_assoc($r_merk);
                           
        $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$d_dbr[kondisi]'";
        $r_kondisi = mysqli_query($con, $qry_kondisi);
        $d_kondisi = mysqli_fetch_assoc($r_kondisi);
        ?>
      <tbody>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td style="text-align: center;"><?php echo $d_dbr['id_inventaris'];?></td>
          <td><?php echo $d_dbr['nm'];?></td>
          <td><?php echo $d_kat['nm'];?></td>
          <td><?php echo $d_merk['nm'];?></td>
          <td style="text-align: center;"><?php echo $d_kondisi['nm'];?></td>
        </tr>
      </tbody>
      <?php
        }
        ?>
    </table>
    <br/>
    <div class="right">
      a.n. Dekan, <br />
      <?php echo $d_nm_jbtn['nm'];?>,
      <br />
      <br />
      <br />
      <span>&nbsp;&nbsp;&nbsp;&nbsp;*</span>
      <br />
      <br />
      <?php echo $d_pejabat['nama_tg'];?>
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