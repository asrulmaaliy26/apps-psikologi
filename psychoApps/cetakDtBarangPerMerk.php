<?php include( "contentsConAdm.php" );  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

  $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$id'";
  $r_merk = mysqli_query($con, $qry_merk);
  $d_merk = mysqli_fetch_assoc($r_merk);
  
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
    <title>Data Barang Merk <?php echo $d_merk['nm'];?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .table_dbr {
      width: 100%;
      border-collapse:collapse;
      vertical-align: middle;
      text-align: left;
      font-family:Arial, Helvetica, sans-serif; font-size:0.9em;
      }
      .table_dbr th {
      text-align: left;
      }
      .table_dbr th,td {
      text-align: left;
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
    <style type="text/css" media="print">
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <strong>
        <center>DATA BARANG MERK <?php echo strtoupper($d_merk['nm']);?></center>
      </strong>
      <br />
      <table class="table_dbr">
        <thead>
          <tr>
            <th width="4%">No.</th>
            <th width="12%">Kode Barang (U)</th>
            <th width="12%">Kode Barang (F)</th>
            <th width="20%">Nama Barang</th>
            <th width="8%">Merk</th>
            <th width="10%">Tgl. Perolehan</th>
            <th width="10%">Sumber Dana</th>
            <th width="16%">Letak</th>
            <th width="10%">Kondisi</th>
          </tr>
        </thead>
        <?php
          $no=0;
          $qry_dbr = "SELECT * FROM dt_inventaris_barang WHERE merk='$id' ORDER BY DATE(tgl_perolehan) DESC";
          $r_dbr = mysqli_query($con, $qry_dbr);
          WHILE($d_dbr = mysqli_fetch_assoc($r_dbr)) {
          
          $no++;        
          $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$d_dbr[merk]'";
          $r_merk = mysqli_query($con, $qry_merk);
          $d_merk = mysqli_fetch_assoc($r_merk);
                             
          $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$d_dbr[kondisi]'";
          $r_kondisi = mysqli_query($con, $qry_kondisi);
          $d_kondisi = mysqli_fetch_assoc($r_kondisi);
          
          $qry_sumber_dn = "SELECT * FROM opsi_sumber_dana_perolehan_barang WHERE id='$d_dbr[sumber_dana]'";
          $r_sumber_dn = mysqli_query($con, $qry_sumber_dn);
          $d_sumber_dn = mysqli_fetch_assoc($r_sumber_dn);
          
          $qry_dir = "SELECT * FROM dt_ruang WHERE id='$d_dbr[letak]'";
          $r_dir = mysqli_query($con, $qry_dir);
          $d_dir = mysqli_fetch_assoc($r_dir);
          ?>
        <tbody>
          <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $d_dbr['id_inventaris_pusat'];?></td>
            <td><?php echo $d_dbr['id_inventaris'];?></td>
            <td><?php echo $d_dbr['nm'];?></td>
            <td><?php echo $d_merk['nm'];?></td>
            <td><?php echo $d_dbr['tgl_perolehan'];?></td>
            <td><?php echo $d_sumber_dn['nm'];?></td>
            <td><?php echo $d_dir['nm'];?></td>
            <td><?php echo $d_kondisi['nm'];?></td>
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