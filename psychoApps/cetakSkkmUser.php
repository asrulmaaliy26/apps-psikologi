<?php include( "contentsConAdm.php" );
  $nim = mysqli_real_escape_string($con,  $_GET[ 'nim' ] );
  
  $username = $_SESSION[ 'username' ];
  $query = "SELECT * FROM dt_mhssw WHERE nim='$nim'";
  $dmhssw = mysqli_query($con, $query)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry1 = "SELECT * FROM skkm_unsur WHERE id='1'";
  $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
  $isi1 = mysqli_fetch_assoc( $res1 );
  $idUnsur1=$isi1['id'];
  $nmUnsur1=$isi1['unsur'];
   
  $qry2 = "SELECT * FROM skkm_unsur WHERE id='2'";
  $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
  $isi2 = mysqli_fetch_assoc( $res2 );
  $idUnsur2=$isi2['id'];
  $nmUnsur2=$isi2['unsur'];
   
  $qry3 = "SELECT * FROM skkm_unsur WHERE id='3'";
  $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
  $isi3 = mysqli_fetch_assoc( $res3 );
  $idUnsur3=$isi3['id'];
  $nmUnsur3=$isi3['unsur'];
   
  $qry4 = "SELECT * FROM skkm_unsur WHERE id='4'";
  $res4 = mysqli_query($con,  $qry4 )or die( 'Error' );
  $isi4 = mysqli_fetch_assoc( $res4 );
  $idUnsur4=$isi4['id'];
  $nmUnsur4=$isi4['unsur'];
  
  $myquery="SELECT * FROM dekanat WHERE id='3'";
  $has=mysqli_query($con, $myquery) or die (mysqli_error($con));
  $data=mysqli_fetch_assoc($has);
  
  $qdekanat3="SELECT * FROM dt_pegawai WHERE jabatan_instansi='4'";
  $resdekanat3=mysqli_query($con, $qdekanat3) or die (mysqli_error($con));
  $ddekanat3=mysqli_fetch_assoc($resdekanat3);
  
  $qpdekanat3="SELECT * FROM opsi_pangkat WHERE id='$ddekanat3[pangkat]'";
  $respdekanat3=mysqli_query($con, $qpdekanat3) or die (mysqli_error($con));
  $dpdekanat3=mysqli_fetch_assoc($respdekanat3);
  
  $qjdekanat3="SELECT * FROM opsi_jabatan WHERE id='$ddekanat3[jabatan]'";
  $resjdekanat3=mysqli_query($con, $qjdekanat3) or die (mysqli_error($con));
  $djdekanat3=mysqli_fetch_assoc($resjdekanat3);
  
  $qjidekanat3="SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat3[jabatan_instansi]'";
  $resjidekanat3=mysqli_query($con, $qjidekanat3) or die (mysqli_error($con));
  $djidekanat3=mysqli_fetch_assoc($resjidekanat3);
   
  $namabulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pengisian SKKM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.table_lp {
      border-collapse: collapse;
      height: 100%;
      width: 100%;
      }
      table.table_lp tr, td {
      vertical-align: top;
      }
      table.table_lp td {
      border:none;
      padding: 2px;
      }
      table.table_lhkm_lrp {
      border-collapse: collapse;
      height: 100%;
      width: 100%;
      }
      table.table_lhkm_lrp tr, td {
      vertical-align: top;
      }
      table.table_lhkm_lrp th, td {
      border: 1px solid;
      padding: 6px;
      }
      h4 {
      margin-bottom:4px;
      }
      .right {
      float: right;
      width: 280px;
      }
      @media print {
      body {margin-top: 10mm; margin-bottom: 20mm;
      margin-left: 10mm; margin-right: 10mm}
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:1em;">
    <div class="page">
      <?php
        include( "kopPotretAUser.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>LEMBAR PENGAJUAN <br />
        PELAKSANAAN SKKM (SATUAN KREDIT KEGIATAN MAHASISWA)</strong>
      </p>
      <br />
      <span>Yang bertandatangan di bawah ini:</span>
      <div style="padding-top:1rem; padding-bottom:1rem; padding-left:3rem;">
        <table class="table_lp">
          <tbody>
            <tr>
              <td width="18%">Nama</td>
              <td width="2%">:</td>
              <td width="80%"><?php echo($ddekanat3['nama']);?></td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td><?php echo($ddekanat3['id']);?></td>
            </tr>
            <tr>
              <td>Pangkat</td>
              <td>:</td>
              <td><?php echo($dpdekanat3['nm_pangkat']);?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td><?php echo($djdekanat3['nm']."/".$djidekanat3['nm']);?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <span>Menerangkan bahwa:</span>
      <div style="padding-top:1rem; padding-bottom:1rem; padding-left:3rem;">
        <table class="table_lp">
          <tbody>
            <tr>
              <td width="18%">Nama</td>
              <td width="2%">:</td>
              <td width="80%"><?php echo($dataku['nama']);?></td>
            </tr>
            <tr>
              <td>NIM</td>
              <td>:</td>
              <td><?php echo($nim);?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <span>Telah melaksanakan SKKM (Satuan Kredit Kegiatan Mahasiswa) sebagaimana terlampir.</span>
      <br />
      <br />
      <br />
      <div class="right">
        Malang, <?php echo"".date("j")." ".$namabulan[date("n")]." ".date("Y");?>
        <br>
        <?php echo($djidekanat3['nm']);?>,
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo($ddekanat3['nama_tg']);?>
      </div>
    </div>
    <div class="page" style="padding-top: 10mm;">
      <?php
        include( "kopPotretAUser.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>LEMBAR HASIL KEGIATAN MAHASISWA (LHKM) <br />
        SKKM (PELAKSANAAN SATUAN KREDIT KEGIATAN MAHASISWA)</strong>
      </p>
      <br />
      <table class="table_lp">
        <tbody>
          <tr>
            <td width="16%">Nama</td>
            <td width="2%" align="center">:</td>
            <td width="82%"><?php echo($dataku['nama']);?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo($dataku['nim']);?></td>
          </tr>
        </tbody>
      </table>
      <h4>A. Rekap Jumlah Kredit</h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="4%" align="center">No.</th>
            <th width="60%" align="left">Unsur</th>
            <th width="20%" align="center">Kredit</th>
            <th width="16%" align="center">Validasi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $qry = "SELECT * FROM skkm_unsur";
            $res = mysqli_query($con,  $qry );
            while ( $mydata = mysqli_fetch_assoc( $res ) ) {
               $idUnsur = $mydata[ 'id' ];
               $unsur = $mydata[ 'unsur' ];
               $no++;
            
               $qry2 = "SELECT SUM(krdt) AS jumKredit FROM skkm WHERE nim='$nim' AND unsur = '$idUnsur'";
               $result = mysqli_query($con,  $qry2 );
               $dt = mysqli_fetch_array( $result );
               $jumKredit = $dt[ 'jumKredit' ];
            
               $query = "SELECT SUM(krdt) AS totalKredit FROM skkm WHERE nim='$nim'";
               $hasil = mysqli_query($con,  $query );
               $data = mysqli_fetch_array( $hasil );
               $totalKredit = $data[ 'totalKredit' ];
            
               $persenKredit = ( $totalKredit != 0 ) ? ( $jumKredit / $totalKredit ) * 100 : 0;
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td><?php echo($unsur);?></td>
            <td align="center"><?php echo($jumKredit);?></td>
            <td>&nbsp;</td>
          </tr>
          <?php }; ?>
        </tbody>
      </table>
      <h4>B. Rekap Prosentase Kredit</h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="4%" align="center">No.</th>
            <th width="36%" align="left">Unsur</th>
            <th width="17%" align="center">Prosentase</th>
            <th width="27%" align="left">Status Prosentase</th>
            <th width="16%" align="center">Validasi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $qry = "SELECT * FROM skkm_unsur";
            $res = mysqli_query($con,  $qry );
            while ( $mydata = mysqli_fetch_assoc( $res ) ) {
               $idUnsur = $mydata[ 'id' ];
               $unsur = $mydata[ 'unsur' ];
               $no++;
            
               $qry2 = "SELECT SUM(krdt) AS jumKredit FROM skkm WHERE nim='$nim' AND unsur = '$idUnsur'";
               $result = mysqli_query($con,  $qry2 );
               $dt = mysqli_fetch_array( $result );
               $jumKredit = $dt[ 'jumKredit' ];
            
               $query1 = "SELECT * FROM persentase_skkm WHERE id='$idUnsur'";
               $hasil1 = mysqli_query($con,  $query1 );
               $data1 = mysqli_fetch_assoc( $hasil1 );
               $prsn1 = $data1[ 'jumlah_1' ];
               $prsn2 = $data1[ 'jumlah_2' ];
            
               $query = "SELECT SUM(krdt) AS totalKredit FROM skkm WHERE nim='$nim'";
               $hasil = mysqli_query($con,  $query );
               $data = mysqli_fetch_array( $hasil );
               $totalKredit = $data[ 'totalKredit' ];
            
               $persenKredit = ( $totalKredit != 0 ) ? ( $jumKredit / $totalKredit ) * 100 : 0;
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td align="left"><?php echo($unsur);?></td>
            <td align="center"><?php printf("%1.0f",$persenKredit); print("%");?></td>
            <td align="left">
              <?php 
                if ($persenKredit >= $prsn1 && $persenKredit <= $prsn2){
                echo "
                <font class=''>Sesuai standar</font>";
                }
                else if ($persenKredit < $prsn1){
                echo "
                <font class=''>Kurang dari standar</font>";
                }
                else if ($persenKredit > $prsn2 ){
                echo "
                <font class=''>Lebih dari standar</font>";
                }
                ?>
            </td>
            <td>&nbsp;</td>
          </tr>
          <?php }; ?>
        </tbody>
      </table>
      <h4>C. Predikat SKKM</h4>
      <table class="table_lhkm_lrp">
        <tbody>
          <tr>
            <td width="28%">Jumlah Kredit SKKM</td>
            <td width="2%" align="center">:</td>
            <td width="70%"><?php echo($totalKredit);?></td>
          </tr>
          <tr>
            <td>Predikat</td>
            <td align="center">:</td>
            <td>
              <?php 
                $myqry = "SELECT * FROM predikat_total_kredit";
                $hsl = mysqli_query($con, $myqry);
                $opsi = mysqli_fetch_assoc($hsl);
                $jum1 = $opsi['jumlah_1'];
                $jum2 = $opsi['jumlah_2'];
                $jum3 = $opsi['jumlah_3'];
                
                if ($totalKredit > $jum3){
                echo "PRESTISIUS";
                }
                else if ($totalKredit >= $jum2){
                echo "SANGAT AKTIF";
                }
                else if ($totalKredit >= $jum1){
                echo "AKTIF";
                }
                else{
                echo "KURANG";
                }
                ?>
            </td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <br />
      <div class="right">
        Malang, <?php echo"".date("j")." ".$namabulan[date("n")]." ".date("Y");?>
        <br>
        <?php echo($djidekanat3['nm']);?>,
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo($ddekanat3['nama_tg']);?>
      </div>
    </div>
    <div class="page" style="padding-top: 10mm;">
      <?php
        include( "kopPotretAUser.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>LEMBAR RINCIAN <br />
        PELAKSANAAN SKKM (SATUAN KREDIT KEGIATAN MAHASISWA)</strong>
      </p>
      <table class="table_lp">
        <tbody>
          <tr>
            <td width="16%">Nama</td>
            <td width="2%" align="center">:</td>
            <td width="82%"><?php echo($dataku['nama']);?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo($dataku['nim']);?></td>
          </tr>
        </tbody>
      </table>
      <h4>A. Unsur <?php echo($nmUnsur1);?></h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="2%" align="center">No.</th>
            <th width="24%" align="left">Sub Unsur</th>
            <th width="26%" align="left">Uraian Unsur</th>
            <th width="10%" align="left">Tempat</th>
            <th width="14%" align="left">Jenis Aitem</th>
            <th width="12%" align="center">Waktu</th>
            <th width="8%" align="left">Bukti Fisik</th>
            <th width="4%" align="left">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $query = "SELECT * FROM skkm WHERE nim=$nim and unsur='$idUnsur1'";
            $has = mysqli_query($con,  $query )or die( 'Error' );
            while ( $data = mysqli_fetch_assoc( $has ) ) {
               $no++;
               $id=$data['id'];
               $idSubUnsur=$data['sub_unsur'];
               $idJenisAitem=$data['jenis_aitem'];
             $idBuktiFisik=$data['bukti_fisik'];
            
               $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
               $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
               $data1 = mysqli_fetch_assoc( $res1 );
               
               $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
               $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
               $data2 = mysqli_fetch_assoc( $res2 );
            
            $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$idBuktiFisik'";
               $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
               $data3 = mysqli_fetch_assoc( $res3 );
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td align="left"><?php echo($data1['nmSubUnsur']);?></td>
            <td align="left"><?php echo($data['deskrip_unsur']);?></td>
            <td align="left"><?php echo($data['tmpt']);?></td>
            <td align="left"><?php echo($data2['nmJenisAitem']);?></td>
            <td align="center"><?php echo($data['start_keg'].'<br>s.d<br>'.$data['end_keg']);?></td>
            <td align="left"><?php echo($data3['nmBuktiFisik']);?></td>
            <td align="center"><?php echo($data['krdt']);?></td>
          </tr>
          <?php };?>
        </tbody>
      </table>
      <h4>B. Unsur <?php echo($nmUnsur2);?></h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="2%" align="center">No.</th>
            <th width="24%" align="left">Sub Unsur</th>
            <th width="26%" align="left">Uraian Unsur</th>
            <th width="10%" align="left">Tempat</th>
            <th width="14%" align="left">Jenis Aitem</th>
            <th width="12%" align="center">Waktu</th>
            <th width="8%" align="left">Bukti Fisik</th>
            <th width="4%" align="left">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $query = "SELECT * FROM skkm WHERE nim=$nim and unsur='$idUnsur2'";
            $has = mysqli_query($con,  $query )or die( 'Error' );
            while ( $data = mysqli_fetch_assoc( $has ) ) {
               $no++;
               $id=$data['id'];
               $idSubUnsur=$data['sub_unsur'];
               $idJenisAitem=$data['jenis_aitem'];
             $idBuktiFisik=$data['bukti_fisik'];
            
               $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
               $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
               $data1 = mysqli_fetch_assoc( $res1 );
               
               $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
               $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
               $data2 = mysqli_fetch_assoc( $res2 );
            
            $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$idBuktiFisik'";
               $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
               $data3 = mysqli_fetch_assoc( $res3 );
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td align="left"><?php echo($data1['nmSubUnsur']);?></td>
            <td align="left"><?php echo($data['deskrip_unsur']);?></td>
            <td align="left"><?php echo($data['tmpt']);?></td>
            <td align="left"><?php echo($data2['nmJenisAitem']);?></td>
            <td align="center"><?php echo($data['start_keg'].'<br>s.d<br>'.$data['end_keg']);?></td>
            <td align="left"><?php echo($data3['nmBuktiFisik']);?></td>
            <td align="center"><?php echo($data['krdt']);?></td>
          </tr>
          <?php };?>
        </tbody>
      </table>
      <h4>C. Unsur <?php echo($nmUnsur3);?></h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="2%" align="center">No.</th>
            <th width="24%" align="left">Sub Unsur</th>
            <th width="26%" align="left">Uraian Unsur</th>
            <th width="10%" align="left">Tempat</th>
            <th width="14%" align="left">Jenis Aitem</th>
            <th width="12%" align="center">Waktu</th>
            <th width="8%" align="left">Bukti Fisik</th>
            <th width="4%" align="left">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $query = "SELECT * FROM skkm WHERE nim=$nim and unsur='$idUnsur3'";
            $has = mysqli_query($con,  $query )or die( 'Error' );
            while ( $data = mysqli_fetch_assoc( $has ) ) {
               $no++;
               $id=$data['id'];
               $idSubUnsur=$data['sub_unsur'];
               $idJenisAitem=$data['jenis_aitem'];
            $idBuktiFisik=$data['bukti_fisik'];
            
               $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
               $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
               $data1 = mysqli_fetch_assoc( $res1 );
               
               $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
               $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
               $data2 = mysqli_fetch_assoc( $res2 );
            
             $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$idBuktiFisik'";
               $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
               $data3 = mysqli_fetch_assoc( $res3 );
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td align="left"><?php echo($data1['nmSubUnsur']);?></td>
            <td align="left"><?php echo($data['deskrip_unsur']);?></td>
            <td align="left"><?php echo($data['tmpt']);?></td>
            <td align="left"><?php echo($data2['nmJenisAitem']);?></td>
            <td align="center"><?php echo($data['start_keg'].'<br>s.d<br>'.$data['end_keg']);?></td>
            <td align="left"><?php echo($data3['nmBuktiFisik']);?></td>
            <td align="center"><?php echo($data['krdt']);?></td>
          </tr>
          <?php };?>
        </tbody>
      </table>
      <h4>D. Unsur <?php echo($nmUnsur4);?></h4>
      <table class="table_lhkm_lrp">
        <thead>
          <tr>
            <th width="2%" align="center">No.</th>
            <th width="24%" align="left">Sub Unsur</th>
            <th width="26%" align="left">Uraian Unsur</th>
            <th width="10%" align="left">Tempat</th>
            <th width="14%" align="left">Jenis Aitem</th>
            <th width="12%" align="center">Waktu</th>
            <th width="8%" align="left">Bukti Fisik</th>
            <th width="4%" align="left">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            $query = "SELECT * FROM skkm WHERE nim=$nim and unsur='$idUnsur4'";
            $has = mysqli_query($con,  $query )or die( 'Error' );
            while ( $data = mysqli_fetch_assoc( $has ) ) {
               $no++;
               $id=$data['id'];
               $idSubUnsur=$data['sub_unsur'];
               $idJenisAitem=$data['jenis_aitem'];
             $idBuktiFisik=$data['bukti_fisik'];
            
               $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
               $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
               $data1 = mysqli_fetch_assoc( $res1 );
               
               $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
               $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
               $data2 = mysqli_fetch_assoc( $res2 );
            
             $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$idBuktiFisik'";
               $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
               $data3 = mysqli_fetch_assoc( $res3 );
               ?>
          <tr>
            <td align="center"><?php echo($no);?></td>
            <td align="left"><?php echo($data1['nmSubUnsur']);?></td>
            <td align="left"><?php echo($data['deskrip_unsur']);?></td>
            <td align="left"><?php echo($data['tmpt']);?></td>
            <td align="left"><?php echo($data2['nmJenisAitem']);?></td>
            <td align="center"><?php echo($data['start_keg'].'<br>s.d<br>'.$data['end_keg']);?></td>
            <td align="left"><?php echo($data3['nmBuktiFisik']);?></td>
            <td align="center"><?php echo($data['krdt']);?></td>
          </tr>
          <?php };?>
        </tbody>
      </table>
      <br />
      <br />
      <br />
      <div class="right">
        Malang, <?php echo"".date("j")." ".$namabulan[date("n")]." ".date("Y");?>
        <br>
        <?php echo($djidekanat3['nm']);?>,
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo($ddekanat3['nama_tg']);?>
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