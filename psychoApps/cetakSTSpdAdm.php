<?php include( "contentsConAdm.php" );
   
   $id=mysqli_real_escape_string($con, $_GET['id']);
   
if ($id == 'dummy') {
    // DATA DUMMY UNTUK PREVIEW LAYOUT SURAT TUGAS
    $dataku = [
        'id' => 'dummy',
        'no_agenda_surat' => '201',
        'tgl_ditetapkan' => date('Y-m-d'),
        'awal_berlaku' => date('d-m-Y'),
        'akhir_berlaku' => date('d-m-Y', strtotime('+7 days')),
        'perihal' => 'Menghadiri Rapat Koordinasi Nasional di Jakarta',
        'dekan' => '1',
        'dasar' => "1. Kalender Akademik Universitas Contoh\n2. Surat Undangan Rektor Nomor: 123/UN/2026"
    ];
    $jumPersonil = 1;
    $data1 = ['nm' => 'Fakultas Psikologi'];
    $data2 = ['nm' => 'Universitas Contoh'];
    $ambilbln = date('n');
    $ambilthn = date('Y');
    
    // Ambil data pejabat dari tabel dekanat (ID 1 = Dekan)
    $qset = mysqli_query($con, "SELECT * FROM dekanat WHERE id='1'");
    $dset = mysqli_fetch_assoc($qset);
    $nip_pejabat = ($dset && !empty($dset['nm_jabatan'])) ? $dset['nm_jabatan'] : '196811242000031001';

    $qdekanat = "SELECT * FROM dt_pegawai WHERE id='$nip_pejabat'";
    $resdekanat = mysqli_query($con, $qdekanat);
    $ddekanat = mysqli_fetch_assoc($resdekanat);
    
    if (!$ddekanat) {
        $ddekanat = [
            'nama_tg' => 'Nama Dekan Belum Diatur',
            'jabatan' => '1',
            'jabatan_instansi' => '1'
        ];
    }
} else {
    // LOGIKA ASLI
    $sql1 =  "SELECT * FROM nama_lembaga";
    $result1 = mysqli_query($con, $sql1);
    $data1 = mysqli_fetch_array($result1);
    
    $sql2 =  "SELECT * FROM nama_lembaga_induk";
    $result2 = mysqli_query($con, $sql2);
    $data2 = mysqli_fetch_array($result2);
    
    $myquery="SELECT * FROM st WHERE id='$id'";
    $res=mysqli_query($con, $myquery) or die (mysqli_error($con));
    $dataku=mysqli_fetch_assoc($res);
    
    $qry="SELECT COUNT(id_st) AS jumPersonil FROM personil_st WHERE id_st='$id' AND nama <>''";
    $r=mysqli_query($con, $qry) or die (mysqli_error($con));
    $dt=mysqli_fetch_assoc($r);
    $jumPersonil=$dt['jumPersonil'] ?? 0;
    
    $qbln = "SELECT MONTH(tgl_ditetapkan) AS bulan FROM st WHERE id='$id'";
    $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
    $dbln = mysqli_fetch_assoc( $resbln );
    $ambilbln = $dbln['bulan'] ?? date('n');
    
    $qthn = "SELECT YEAR(tgl_ditetapkan) AS tahun FROM st WHERE id='$id'";
    $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
    $dthn = mysqli_fetch_assoc( $resthn );
    $ambilthn = $dthn['tahun'] ?? date('Y');
    
    $qdekanat="SELECT * FROM dt_pegawai WHERE id='$dataku[dekan]'";
    $resdekanat=mysqli_query($con, $qdekanat) or die (mysqli_error($con));
    $ddekanat=mysqli_fetch_assoc($resdekanat);
}
      
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
   
   function thnSamaBlnSamaTglTidak($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[0];
   }
   
   function thnSamaBlnTidak($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[ (int)$split[1] ];
   }
   
   $str1 = $dataku['awal_berlaku'];
   $res1 = explode("-",$str1);
   $thn1 = $res1[2];
   $bln1 = $res1[1];
   $tgl1 = $res1[0];
   
   $str2 = $dataku['akhir_berlaku'];
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
         .table, tr, td {
         padding-top:6px;
         padding-bottom:6px;
         }
         .kanan_atas_lampiran {
         float: right !important;
         position:relative;
         width: 280px;
         margin-bottom:50px;
         }
         .kanan_bawah {
         float: right;
         position:relative;
         width: 280px;
         }
         .tengah {
         text-align:center;
         }
         ol { margin-left:0; padding-left:20px; margin-top:0; margin-bottom:0;}
         ol li { padding-left:8px;}
         table.table-lampiran {
         border: 1px solid black;
         border-collapse: collapse;
         width:84%;
         }
         table.table-lampiran td, table.table-lampiran th {
         border: 1px solid black;
         padding: 3px;
         text-align:justify;
         }
         table.table-kepada {
         border: 1px solid black;
         border-collapse: collapse;
         width:100%;
         margin:0;
         }
         table.table-kepada td, table.table-kepada th {
         border: 1px solid black;
         padding: 2px;
         text-align:justify;
         }
         @media print {
         div.page
         {
         page-break-after: always;
         page-break-inside: avoid;
         }
         }
         .img-kiri {
         float: left;
         margin-right: 8px !important;
         margin-top: -5px !important;
         }
         .tulisan-kanan {
         margin-left: 8px !important;
         }
         hr {
         border: 5px; 
         border-top: 3px double;
         }   
         .baris-empat {
         font-size:12px;
         }   
      </style>
   </head>
   <body style="font-family:Arial, Helvetica, sans-serif; font-size:15px;">
      <?php include ("kopSurat.php");?>
      <div class="tengah" style="margin-top:26px;">
         <strong>
         <u><font style="font-size:1.2em;">SURAT TUGAS</font></u>
         </strong>               
         <br />
         Nomor :<?php if($dataku['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dataku['no_agenda_surat'];}?>/<?php echo $dkodesrt['kd_nmr_srt'];?>/KP.01.1/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?>
      </div>
      <br />
      <br />
      <table width="100%">
         <tr valign="top" align="justify">
            <td width="3%">1.</td>
            <td width="36%">Instansi Pemerintah RI yang memberi tugas</td>
            <td width="2%">:</td>
            <td width="59%"><?php echo "$data1[nm]".' '."$data2[nm]"?></td>
         </tr>
         <tr valign="top" align="justify">
            <td>2.</td>
            <td>Nama yang diberi tugas</td>
            <td>:</td>
            <td>
               <?php
                  $qry="SELECT COUNT(id_st) AS jumPersonil FROM personil_st WHERE id_st='$id' AND nama <>''";
                     $r=mysqli_query($con, $qry) or die (mysqli_error($con));
                     $dt=mysqli_fetch_assoc($r);
                     $jumPersonil=$dt['jumPersonil'];
                     

                  if($jumPersonil ==1) {
                     $qambilpersonil="SELECT * FROM personil_st WHERE id_st='$dataku[id]' AND nama<>'' ORDER BY id";
                     $resambilpersonil=mysqli_query($con, $qambilpersonil) or die (mysqli_error($con));
                     $dambilpersonil=mysqli_fetch_assoc($resambilpersonil);
                  				  
                  	$qpersonil="SELECT * FROM dt_pegawai WHERE id='$dambilpersonil[nama]'";
                     $respersonil=mysqli_query($con, $qpersonil) or die (mysqli_error($con));
                     $dtpersonil=mysqli_fetch_assoc($respersonil);
                  
                  if($dambilpersonil['nama'] == $dtpersonil['id']) { echo $dtpersonil['nama'];} if ($dambilpersonil['nama'] != $dtpersonil['id']) { echo $dambilpersonil['nama'];}}
                  else {?>
               <ol type="a">
                  <?php 
                     $qambilpersonil="SELECT * FROM personil_st WHERE id_st='$dataku[id]' AND nama<>'' ORDER BY id";
                     $resambilpersonil=mysqli_query($con, $qambilpersonil) or die (mysqli_error($con));
                     while ($dambilpersonil=mysqli_fetch_assoc($resambilpersonil)) { 
                                 
                     $qpersonil="SELECT * FROM dt_pegawai WHERE id='$dambilpersonil[nama]'";
                     $respersonil=mysqli_query($con, $qpersonil) or die (mysqli_error($con));
                     $dtpersonil=mysqli_fetch_assoc($respersonil);                  
                                 ?>    
                  <li><?php if($dambilpersonil['nama'] == $dtpersonil['id']) { echo $dtpersonil['nama'];} else { echo $dambilpersonil['nama'];}?></li>
                  <?php } ?>
               </ol>
               <?php } ?>
            </td>
         </tr>
         <tr valign="top" align="justify">
            <td>3.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>
               <?php
                  $qry="SELECT COUNT(id_st) AS jumPersonil FROM personil_st WHERE id_st='$id' AND nama <>''";
                     $r=mysqli_query($con, $qry) or die (mysqli_error($con));
                     $dt=mysqli_fetch_assoc($r);
                     $jumPersonil=$dt['jumPersonil'];
                     
                  if($jumPersonil ==1) {
                     $qambilpersonil="SELECT * FROM personil_st WHERE id_st='$dataku[id]' AND nama<>'' ORDER BY id";
                     $resambilpersonil=mysqli_query($con, $qambilpersonil) or die (mysqli_error($con));
                     $dambilpersonil=mysqli_fetch_assoc($resambilpersonil);
                  
                     $qjab="SELECT * FROM opsi_jabatan_instansi WHERE id='$dambilpersonil[jabatan_st]'";
                     $resjab=mysqli_query($con, $qjab) or die (mysqli_error($con));
                     $dtjab=mysqli_fetch_assoc($resjab);
                  
                  if($dambilpersonil['jabatan_st'] == $dtjab['id']) { echo $dtjab['nm'].' '.$data1['nm'];} if ($dambilpersonil['jabatan_st'] != $dtjab['id']) { echo $dambilpersonil['jabatan_st'];}}
                  else {?>
               <ol type="a">
                  <?php 
                     $qambilpersonil="SELECT * FROM personil_st WHERE id_st='$dataku[id]' AND nama<>'' ORDER BY id";
                     $resambilpersonil=mysqli_query($con, $qambilpersonil) or die (mysqli_error($con));
                     while ($dambilpersonil=mysqli_fetch_assoc($resambilpersonil)) { 
                     
                     $qjab="SELECT * FROM opsi_jabatan_instansi WHERE id='$dambilpersonil[jabatan_st]'";
                     $resjab=mysqli_query($con, $qjab) or die (mysqli_error($con));
                     $dtjab=mysqli_fetch_assoc($resjab);
                     ?>    
                  <li><?php if ($dambilpersonil['jabatan_st'] == $dtjab['id']) { echo $dtjab['nm'].' '.$data1['nm'];} else { echo $dambilpersonil['jabatan_st'];}?></li>
                  <?php } ?>
               </ol>
               <?php } ?>
            </td>
         </tr>
         <tr valign="top" align="justify">
            <td>4.</td>
            <td>Yang bersangkutan diberi tugas untuk</td>
            <td>:</td>
            <td><?php echo $dataku['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['perihal']);?></td>
         </tr>
         <?php if(empty($dataku['dasar'])) {include "nonDasarStSpd.php";}
            else {include "dasarStSpd.php";}?>
      </table>
      <br />
      <br />
      <div class="kanan_bawah">
         <span>Ditetapkan di</span><span style="text-indent: -30px; margin-left: 30px;">:</span><span style="text-indent: -8px; margin-left: 8px;">Malang</span>
         <br />
         <span>Pada Tanggal</span><span style="text-indent: -26px; margin-left: 26px;">:</span><span style="text-indent: -8px; margin-left: 8px;"><?php echo tanggalDitetapkan($dataku['tgl_ditetapkan']);?></span>
         <br />
         <br />
         Dekan,
         <div class="ttd">
            <img src="images/<?php echo $dkodesrt['ttd'];?>" width="200" />
         </div>
         <?php echo $ddekanat['nama_tg'];?>
      </div>
      <br />
      <table width="100%">
         <tr>
            <td>Tembusan:<br />
               <?php 
                  $qtemb="SELECT * FROM tembusan_st";
                  $restemb=mysqli_query($con, $qtemb) or die (mysqli_error($con));
                  $dtemb=mysqli_fetch_assoc($restemb);
                  echo nl2br($dtemb['isi']);
                  ?>         
            </td>
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