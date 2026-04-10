  <?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_GET['id']);
   
   $myquery="SELECT * FROM spd WHERE id='$id'";
   $res=mysqli_query($con, $myquery) or die (mysqli_error($con));
   $dataku=mysqli_fetch_assoc($res);
   
   $qbln = "SELECT MONTH(tgl_ditetapkan) AS bulan FROM spd WHERE id='$id'";
   $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
   $dbln = mysqli_fetch_assoc( $resbln );
   $ambilbln=$dbln['bulan'];
   
   $qthn = "SELECT YEAR(tgl_ditetapkan) AS tahun FROM spd WHERE id='$id'";
   $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
   $dthn = mysqli_fetch_assoc( $resthn );
   $ambilthn=$dthn['tahun'];
   
   $qkodesrt="SELECT * FROM dekanat WHERE id='1'";
   $reskodesrt=mysqli_query($con, $qkodesrt) or die (mysqli_error($con));
   $dkodesrt=mysqli_fetch_assoc($reskodesrt);
   
   $qdekanat="SELECT * FROM dt_pegawai WHERE id='$dataku[dekan]'";
   $resdekanat=mysqli_query($con, $qdekanat) or die (mysqli_error($con));
   $ddekanat=mysqli_fetch_assoc($resdekanat);
          
   $qnmppk="SELECT * FROM dt_pegawai WHERE id='$dataku[ppk]'";
   $resnmppk=mysqli_query($con, $qnmppk) or die (mysqli_error($con));
   $dnmppk=mysqli_fetch_assoc($resnmppk);
   
   $qjabataninstppk="SELECT * FROM opsi_jabatan_instansi WHERE id='$dataku[jabatan_ppk]'";
   $resjabataninstppk=mysqli_query($con, $qjabataninstppk) or die (mysqli_error($con));
   $djabataninstppk=mysqli_fetch_assoc($resjabataninstppk);
   
   $qnmpenerima="SELECT * FROM dt_pegawai WHERE id='$dataku[penerima]'";
   $resnmpenerima=mysqli_query($con, $qnmpenerima) or die (mysqli_error($con));
   $dnmpenerima=mysqli_fetch_assoc($resnmpenerima);
   
   $qpangkat="SELECT * FROM opsi_pangkat WHERE id='$dataku[pangkat]'";
   $respangkat=mysqli_query($con, $qpangkat) or die (mysqli_error($con));
   $dpangkat=mysqli_fetch_assoc($respangkat);
   
   $qjabataninstpnrm="SELECT * FROM opsi_jabatan_instansi WHERE id='$dataku[jabatan_instansi_penerima]'";
   $resjabataninstpnrm=mysqli_query($con, $qjabataninstpnrm) or die (mysqli_error($con));
   $djabataninstpnrm=mysqli_fetch_assoc($resjabataninstpnrm);
   
   $qtberangkat="SELECT * FROM dt_kota WHERE id='$dataku[tempat_berangkat]'";
   $restberangkat=mysqli_query($con, $qtberangkat) or die (mysqli_error($con));
   $dtberangkat=mysqli_fetch_assoc($restberangkat);
   
   $qttujuan="SELECT * FROM dt_kota WHERE id='$dataku[tempat_tujuan]'";
   $resttujuan=mysqli_query($con, $qttujuan) or die (mysqli_error($con));
   $dttujuan=mysqli_fetch_assoc($resttujuan);

   $qttujuan2="SELECT * FROM dt_kota WHERE id='$dataku[tempat_tujuan2]'";
   $resttujuan2=mysqli_query($con, $qttujuan2) or die (mysqli_error($con));
   $dttujuan2=mysqli_fetch_assoc($resttujuan2);

   $qttujuan3="SELECT * FROM dt_kota WHERE id='$dataku[tempat_tujuan3]'";
   $resttujuan3=mysqli_query($con, $qttujuan3) or die (mysqli_error($con));
   $dttujuan3=mysqli_fetch_assoc($resttujuan3);
   
   function bulanIndo($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
   }
   
   function tanggalDitetapkan($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
   }
   
   function tanggalBerangkat($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
   }
   
   function tanggalKembali($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
   }
   
   $str1 = $dataku['tanggal_berangkat'];
   $res1 = explode("-",$str1);
   $thn1 = $res1[2];
   $bln1 = $res1[1];
   $tgl1 = $res1[0];
   
   $str2 = $dataku['tanggal_kembali'];
   $res2 = explode("-",$str2);
   $thn2 = $res2[2];
   $bln2 = $res2[1];
   $tgl2 = $res2[0];
   
   $sql1 =  "SELECT * FROM nama_lembaga";
   $result1 = mysqli_query($con, $sql1);
   $data1 = mysqli_fetch_array($result1);
   
   $sql2 =  "SELECT * FROM nama_lembaga_induk";
   $result2 = mysqli_query($con, $sql2);
   $data2 = mysqli_fetch_array($result2);
   
   function my_ucwords($str, $is_name=false) {
      // exceptions to standard case conversion
      if ($is_name) {
          $all_uppercase = '';
          $all_lowercase = 'De La|De Las|Der|Van De|Van Der|Vit De|Von|Or|And';
      } else {
          // addresses, essay titles ... and anything else
          $all_uppercase = 'Po|Rr|Se|Sw|Ne|Nw|Ii|Iii|Iv|Vi|Vii|Viii|Ix|Xi|Xii|Xiii|Ixx';
          $all_lowercase = 'A|Dan|Sebagai|Dengan|Pada|Dalam|Dari|Atau|Untuk|And|As|By|In|On|At|From|Or|To';
      }
      $prefixes = 'Mc';
      $suffixes = "'S";
   
      // captialize all first letters
      $str = preg_replace('/\\b(\\w)/e', 'strtoupper("$1")', strtolower(trim($str)));
   
      if ($all_uppercase) {
          // capitalize acronymns and initialisms e.g. PHP
          $str = preg_replace("/\\b($all_uppercase)\\b/e", 'strtoupper("$1")', $str);
      }
      if ($all_lowercase) {
          // decapitalize short words e.g. and
          if ($is_name) {
              // all occurences will be changed to lowercase
              $str = preg_replace("/\\b($all_lowercase)\\b/e", 'strtolower("$1")', $str);
          } else {
              // first and last word will not be changed to lower case (i.e. titles)
              $str = preg_replace("/(?<=\\W)($all_lowercase)(?=\\W)/e", 'strtolower("$1")', $str);
          }
      }
      if ($prefixes) {
          // capitalize letter after certain name prefixes e.g 'Mc'
          $str = preg_replace("/\\b($prefixes)(\\w)/e", '"$1".strtoupper("$2")', $str);
      }
      if ($suffixes) {
          // decapitalize certain word suffixes e.g. 's
          $str = preg_replace("/(\\w)($suffixes)\\b/e", '"$1".strtolower("$2")', $str);
      }
      return $str;
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>SitaperOnline</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
         .table-kop { 
         margin-bottom:28px;
         font-size:10px;    
         }
         .kanan_bawah {
         float: right;
         width: 300px;
         font-size:13px;
         }
         table.table-ket {
         border: 1px solid black;
         border-collapse: collapse;
         width:100%;
         font-size:10px;
         }
         table.table-ket td, table.table-ket th {
         border: 1px solid black;
         text-align:justify;
         padding:2px 2px 2px 2px;
         vertical-align:top;
         }

         @media print {
         div.page
         {
         page-break-after: always;
         page-break-inside: avoid;
         }
         }
         /*css kop surat */       
         .img-kiri {
         float: left;
         margin-right: 8px !important;
         margin-top: -2px !important;
         }
         .tulisan-kanan {
         margin-left: 8px !important;
         }
         .baris-satu-dua-tiga {
         font-size:12px;
         text-transform:uppercase;
         }   
         .baris-empat {
         font-size:10px;
         }   
      </style>
   </head>
   <body style="font-family:Arial, Helvetica, sans-serif;">
      <table width="100%" style="font-size:8px;">
<tbody>
  <tr style="vertical-align:bottom;">
    <td rowspan="6" width="62%" style="padding-right:6px;"><?php include ("kopspdbaru.php");?></td>
    <td colspan="3">PERATURAN MENTERI KEUANGAN REPUBLIK INDONESIA</td>
  </tr>
  <tr style="vertical-align:top;">
    <td width="8%">NOMOR</td>
    <td width="1%">:</td>
    <td width="29%">113/PMK.05/2012</td>
  </tr>
  <tr style="vertical-align:top;">
    <td>TENTANG</td>
    <td>:</td>
    <td>PERJALANAN DINAS JABATAN DALAM NEGERI BAGI PEJABAT NEGARA, PEGAWAI DAN PEGAWAI TIDAK TETAP</td>
  </tr>
  <tr style="vertical-align:top;">
    <td>Lembar</td>
    <td>:</td>
    <td></td>
  </tr>
  <tr style="vertical-align:top;">
    <td>Kode No.</td>
    <td>:</td>
    <td></td>
  </tr>
  <tr style="vertical-align:top;">
    <td>Nomor</td>
    <td>:</td>
    <td><?php if($dataku['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dataku['no_agenda_surat'];}?>/<?php echo $dkodesrt['kd_nmr_srt'];?>/KP.01.4/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
  </tr>
</tbody>
</table>
<br/>
      <center><strong>SURAT PERJALANAN DINAS ( SPD )</strong></center><br/>

<table class="table-ket">
 <tr style="visibility:collapse;">
            <td width="1%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="34%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="19%">&nbsp;</td>
            <td width="19%">&nbsp;</td>
         </tr>
   <tr>
      <td>1.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;">Pejabat Pembuat Komitmen</td>
      <td style="border-right:none;">:</td>
      <td colspan="5" style="border-left:none;"><?php echo "$data1[nm]";?> <?php echo "$data2[nm]";?></td>
   </tr>
   <tr>
      <td>2.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;">Nama/NIP Pegawai yang Melaksanakan Perjalanan Dinas</td>
      <td style="border-right:none;">:</td>
      <td colspan="5" style="border-left:none;"><?php echo "$dnmpenerima[nama]".'/'."$dnmpenerima[id]";?></td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">3.</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">a.</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">Pangkat dan Golongan</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">a.</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;"><?php echo "$dpangkat[nm_pangkat]";?></td>
   </tr>
   <tr>
      <td style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-left:none; border-top:none; border-bottom:none;">b.</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">Jabatan/Instansi</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">b.</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;"><?php echo $djabataninstpnrm['nm_panjang'];?></td>
   </tr>
   <tr>
      <td style="border-left:none; border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">c.</td>
      <td colspan="3" style="border-left:none; border-top:none;">Tingkat Biaya Perjalanan Dinas</td>
      <td style="border-right:none; border-top:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none;">c.</td>
      <td colspan="4" style="border-left:none; border-top:none;">&nbsp;</td>
   </tr>
   <tr>
      <td>4.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;" valign="top">Maksud Perjalanan Dinas</td>
      <td style="border-right:none;" valign="top">:</td>
      <td colspan="5" style="border-left:none;" valign="top"><?php echo $dataku['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['maksud_spd']);?></td>      
   </tr>
   <tr>
      <td>5.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;">Alat Angkutan yang Dipergunakan</td>
      <td style="border-right:none;">:</td>
      <td colspan="5" style="border-left:none;">Pesawat/Bus/Kereta Api/Taxi/Kendaraan Dinas/Kendaraan Umum dll.*</td>     
   </tr>
   <tr>
      <td style="border-bottom:none;">6.</td>
      <td style="border-right:none; border-bottom:none;">a.</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">Tempat Berangkat</td>
      <td style="border-right:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">a.</td>
      <td colspan="4" style="border-left:none; border-bottom:none;"><?php echo "$dtberangkat[nm_kota]";?></td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">b.</td>
      <td colspan="3" style="border-left:none; border-top:none;">Tempat Tujuan</td>
      <td style="border-right:none; border-top:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none;">b.</td>
      <td colspan="4" style="border-left:none; border-top:none;"><?php if(empty($dataku['tempat_tujuan2']) && empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]";} else if(!empty($dataku['tempat_tujuan2']) && empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]".", ". "$dttujuan2[nm_kota]";} else if(!empty($dataku['tempat_tujuan2']) && !empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]".", "."$dttujuan2[nm_kota]".", ". "$dttujuan3[nm_kota]";}?></td>
   </tr>
   <tr>
      <td style="border-bottom:none;">7.</td>
      <td style="border-right:none; border-bottom:none;">a.</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">Lamanya Perjalanan Dinas</td>
      <td style="border-right:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">a.</td>
      <td colspan="4" style="border-left:none; border-bottom:none;"><?php echo "$dataku[durasi_spd]";
               if ($dataku['durasi_spd'] == 1) echo " (Satu)"; if ($dataku['durasi_spd'] == 2) echo " (Dua)"; if ($dataku['durasi_spd'] == 3) echo " (Tiga)"; if ($dataku['durasi_spd'] == 4) echo " (Empat)"; if ($dataku['durasi_spd'] == 5) echo " (Lima)"; if ($dataku['durasi_spd'] == 6) echo " (Enam)"; if ($dataku['durasi_spd'] == 7) echo " (Tujuh)"; if ($dataku['durasi_spd'] == 8) echo " (Delapan)"; if ($dataku['durasi_spd'] == 9) echo " (Sembilan)"; if ($dataku['durasi_spd'] == 10) echo " (Sepuluh)";?> Hari</td>
   </tr>
    <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">b.</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">Tanggal Berangkat</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">b.</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;"><?php echo tanggalBerangkat($dataku['tanggal_berangkat']);?></td>     
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">c.</td>
      <td colspan="3" style="border-left:none; border-top:none;">Tanggal Harus Kembali/Tiba di Tempat Baru</td>
      <td style="border-right:none; border-top:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none;">c.</td>
      <td colspan="4" style="border-left:none; border-top:none;"><?php echo tanggalBerangkat($dataku['tanggal_kembali']);?></td>
   </tr>
   <tr>
      <td style="border-bottom:none;">8.</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">Pengikut : Nama</td>
      <td style="border-right:none; border-bottom:none;">:</td>
      <td colspan="3" style="border-left:none; border-bottom:none; text-align: center;">Tanggal Lahir</td>
      <td colspan="2" style="border-bottom:none; text-align: center;">Keterangan</td>
   </tr>
   <tr>
      <td style="border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-bottom:1px dotted;">1.</td>
      <td colspan="3" style="border-left:none; border-bottom:1px dotted;">&nbsp;</td>
      <td style="border-right:none; border-bottom:1px dotted;">:</td>
      <td colspan="3" style="border-left:none; border-bottom:1px dotted; text-align: center;">&nbsp;</td>
      <td colspan="2" style="border-bottom:1px dotted; text-align: center;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">2.</td>
      <td colspan="3" style="border-left:none; border-top:none;;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">:</t d>
      <td colspan="3" style="border-left:none; border-top:none; text-align: center;">&nbsp;</td>
      <td colspan="2" style="border-top:none; text-align: center;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-bottom:none;">9.</td>
      <td colspan="4" style="border-right:none; border-bottom:none;">Pembebanan Anggaran</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none; text-align: center;" colspan="2">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-bottom:none; text-align: center;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">a.</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">Instansi</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">a.</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;"><?php echo "$data2[nm]";?></td>     
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">b.</td>
      <td colspan="3" style="border-left:none; border-top:none;">Akun</td>
      <td style="border-right:none; border-top:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none;">b.</td>
      <td colspan="4" style="border-left:none; border-top:none;">&nbsp;</td>     
   </tr>
   <tr>
      <td style="border-bottom:none;">10.</td>
      <td colspan="4" style="border-left:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-bottom:none;"></td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">Dikeluarkan di</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">:</td>
      <td colspan="2" style="border-left:none; border-right:none; border-bottom:none;">Malang</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">:</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;"><?php echo tanggalDitetapkan($dataku['tgl_ditetapkan']);?></td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Berangkat dari</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">:</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;"><?php echo $data2['nm'];?></td>
   </tr>
  <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">(Tempat Kedudukan)</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Ke</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">:</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;"><?php if(empty($dataku['tempat_tujuan2']) && empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]";} else if(!empty($dataku['tempat_tujuan2']) && empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]".", ". "$dttujuan2[nm_kota]";} else if(!empty($dataku['tempat_tujuan2']) && !empty($dataku['tempat_tujuan3'])) { echo "$dttujuan[nm_kota]".", "."$dttujuan2[nm_kota]".", ". "$dttujuan3[nm_kota]";}?></td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">:</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;"><?php echo tanggalBerangkat($dataku['tanggal_berangkat']);?></td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pejabat Pembuat Komitmen</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-right:none; border-top:none;"><u><?php echo $dnmppk['nama'];?></u><br/>NIP. <?php echo $dnmppk['id'];?></td>      
   </tr>
   <tr>
      <td style="border-bottom:none;">11.</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-bottom:none;">Tiba di</td>
      <td colspan="2" style="border-left:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">Berangkat dari</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Ke</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none;">______________________________ <br/>NIP.</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none;">______________________________ <br/>NIP.</td>    
   </tr>
   <tr>
      <td style="border-bottom:none;">12.</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-bottom:none;">Tiba di</td>
      <td colspan="2" style="border-left:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">Berangkat dari</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Ke</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none;">______________________________ <br/>NIP.</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none;">______________________________ <br/>NIP.</td>    
   </tr>
   <tr>
      <td style="border-bottom:none;">13.</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-bottom:none;">Tiba di</td>
      <td colspan="2" style="border-left:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">Berangkat dari</td>
      <td colspan="3" style="border-left:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Ke</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">:</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Kepala</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;  border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none;">______________________________ <br/>NIP.</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none;">______________________________ <br/>NIP.</td>    
   </tr>
   <tr>
      <td style="border-bottom:none;">14.</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">Tiba di</td>
      <td colspan="2" style="border-left:none; border-bottom:none;">:</td>
      <td style="border-right:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-bottom:none;">&nbsp;</td>
      <td  colspan="4" style="border-left:none; border-right:none; border-bottom:none;">Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.</td>  
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pada Tanggal</td>
      <td colspan="2" style="border-left:none; border-top:none; border-bottom:none;">:</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="5" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
    <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">Pejabat yang memberi perintah<br/>Pejabat Pembuat Komitmen</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">Pejabat yang memberi perintah<br/>Pejabat Pembuat Komitmen</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none; border-bottom:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-top:none;">&nbsp;</td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none; border-top:none;"><u><?php echo $dnmppk['nama'];?></u><br/>NIP. <?php echo $dnmppk['id'];?></td>
      <td style="border-right:none; border-top:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none; border-top:none;">&nbsp;</td>
      <td colspan="4" style="border-left:none; border-right:none; border-top:none;"><u><?php echo $dnmppk['nama'];?></u><br/>NIP. <?php echo $dnmppk['id'];?></td>
   </tr>
   <tr>
      <td>15.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;">Catatan Lain-lain</td>
      <td style="border-right:none;">:</td>
      <td colspan="5" style="border-left:none; border-right:none;">&nbsp;</td>
   </tr>
   <tr>
      <td>16.</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="3" style="border-left:none;">PERHATIAN :</td>
      <td style="border-right:none;">&nbsp;</td>
      <td colspan="5" style="border-left:none; border-right:none;">&nbsp;</td>
   </tr>
   <tr>
      <td style="border-right:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;">&nbsp;</td>
      <td colspan="9" style="border-left:none;">Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta Bendaharawan bertanggungjawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.</td>
   </tr>
   <tr>
      <td style="border-right:none;">&nbsp;</td>
      <td style="border-left:none; border-right:none;">&nbsp;</td>
      <td colspan="9" style="border-left:none;">* Coret yang tidak perlu</td>
   </tr>
</table>
      <?php include( "jsAdm.php" );?>
      <script>
        $(document).ready(function() {
        window.print();
        window.close(); 
        });
      </script>
   </body>
</html>