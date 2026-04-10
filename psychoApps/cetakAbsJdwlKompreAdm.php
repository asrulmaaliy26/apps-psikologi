<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM jadwal_kompre WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $formatTgl=date("d-m-Y", strtotime($dt['tgl_kompre']));
  $day = date('D', strtotime($formatTgl));
  $dayList = array(
  'Sun' => 'Minggu',
  'Mon' => 'Senin',
  'Tue' => 'Selasa',
  'Wed' => 'Rabu',
  'Thu' => 'Kamis',
  'Fri' => "Jum'at",
  'Sat' => 'Sabtu'
  );
  
  $qryperiod = "SELECT * FROM pendaftaran_kompre WHERE id='$dt[id_kompre]'";
  $rperiod = mysqli_query($con, $qryperiod)or die( mysqli_error($con));
  $dperiod = mysqli_fetch_assoc($rperiod);
  $thp = $dperiod['tahap'];
  $ta = $dperiod['ta'];
  
  $qry_nm_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
  $hasil = mysqli_query($con, $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);   
     
  $qrypgws1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$dt[pengawas1]'";
  $respgws1 = mysqli_query($con,  $qrypgws1 )or die( mysqli_error($con) );
  $dpgws1 = mysqli_fetch_assoc( $respgws1 );          
  
  $qrypgws2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$dt[pengawas2]'";
  $respgws2 = mysqli_query($con,  $qrypgws2 )or die( mysqli_error($con) );
  $dpgws2 = mysqli_fetch_assoc( $respgws2 );          
  
  $qryruang = "SELECT * FROM opsi_ruang_ujian_kompre WHERE id='$dt[ruang]'";
  $resruang = mysqli_query($con,  $qryruang )or die( mysqli_error($con) );
  $druang = mysqli_fetch_assoc( $resruang );
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Presensi Kompre [<?php echo $dayList[$day].', '.$formatTgl;?>] [<?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?>]</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.periode_jadwal {
      width: 100%;
      }
      table.periode_jadwal td, table.periode_jadwal th {}
      table.identitas {
      border: 1px solid #333333;
      width: 100%;
      text-align: left;
      border-collapse: collapse;
      }
      table.identitas td, table.identitas th {
      border: 1px solid #AAAAAA;
      padding: 4px 4px;
      }
      table.identitas thead {
      border-bottom: 2px solid #333333;
      }
      table.identitas thead th {
      font-weight: bold;
      text-align: center;
      }
      div.tabel_identitas {
      width: 100%;
      text-align: left;
      }
      .divTable.tabel_identitas .divTableCell, .divTable.tabel_identitas .divTableHead {
      padding: 3px 3px;
      }
      /* DivTable.com */
      .divTable{ display: table; }
      .divTableRow { display: table-row; }
      .divTableHeading { display: table-header-group;}
      .divTableCell, .divTableHead { display: table-cell;}
      .divTableHeading { display: table-header-group;}
      .divTableFoot { display: table-footer-group;}
      .divTableBody { display: table-row-group;}
      @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>presensi ujian komprehensif</b>
      </p>
      <table class="periode_jadwal">
        <tbody>
          <tr>
            <td style="width:26%;">Periode Ujian</td>
            <td style="width:2%;">:</td>
            <td style="width:72%;"><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></td>
          </tr>
          <tr>
            <td>Hari/Tanggal Ujian</td>
            <td>:</td>
            <td><?php echo $dayList[$day].', '.$formatTgl;?></td>
          </tr>
          <tr>
            <td>Jam Ujian</td>
            <td>:</td>
            <td><?php echo $dt['jam_mulai'].' s.d '.$dt['jam_selesai'];?></td>
          </tr>
          <tr>
            <td>Pengawas 1</td>
            <td>:</td>
            <td><?php echo $dpgws1['nm'];?></td>
          </tr>
          <td>Pengawas 2</td>
          <td>:</td>
          <td><?php echo $dpgws2['nm'];?></td>
          </tr>
        </tbody>
        </tr>
      </table>
      <br />
      <table class="identitas">
        <thead>
          <tr>
            <th width="4%">No.</th>
            <th width="12%">Foto</th>
            <th width="60%">Identitas</th>
            <th width="24%">Tandatangan</th>
          </tr>
        </thead>
        <tbody>
          <?php              
            $no=0;
            $sql = "SELECT * FROM peserta_kompre INNER JOIN dt_mhssw ON peserta_kompre.nim=dt_mhssw.nim WHERE peserta_kompre.id_jdwl='$id' ORDER BY dt_mhssw.nama ASC";
            $result = mysqli_query($con, $sql);
            WHILE($data = mysqli_fetch_array($result)) { 
            
            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
            $rmhssw = mysqli_query($con, $qry_mhssw);
            $dmhssw = mysqli_fetch_assoc($rmhssw);
            $no++;
            ?>
          <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:center;"><img style="width: 80px; height: 117px; object-fit: fill;" src="<?php echo $dmhssw['photo'];?>" onError="this.onerror=null;this.src='<?php if($dmhssw['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt=""></td>
            <td>
              <div class="divTable tabel_identitas">
                <div class="divTableBody">
                  <div class="divTableRow">
                    <div class="divTableCell" style="width:23%;">No. Reg.</div>
                    <div class="divTableCell" style="width:2%;">:</div>
                    <div class="divTableCell" style="width:75%;"><?php echo $data['id_reg'];?></div>
                  </div>
                  <div class="divTableRow">
                    <div class="divTableCell">Nama</div>
                    <div class="divTableCell">:</div>
                    <div class="divTableCell"><?php echo $dmhssw['nama'];?></div>
                  </div>
                  <div class="divTableRow">
                    <div class="divTableCell">NIM</div>
                    <div class="divTableCell">:</div>
                    <div class="divTableCell"><?php echo $dmhssw['nim'];?></div>
                  </div>
                </div>
              </div>
            </td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
        </tr>
        <?php
          }
          ?>
      </table>
    </div>
  </body>
  <?php include( "jsAdm.php" );?>
  <script type="text/javascript">
    $(document).ready(function() {
       window.print();
       window.close(); 
    });
  </script>