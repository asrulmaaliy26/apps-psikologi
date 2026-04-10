<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
   $id=abs((int)mysqli_real_escape_string($con, $_GET['id']));
   $myquery="SELECT * FROM surat_masuk WHERE id='$id'";
   $data=mysqli_query($con, $myquery) or die (mysqli_error($con));
   $dataku=mysqli_fetch_assoc($data);
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>SitaperOnline</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
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
         table,td {
         border: 1px solid #000;
         border-collapse:collapse;
         padding:6px;
         }
         @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }
      </style>
   </head>
   <body style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
      <div class="page">
      <?php include ("kopSurat.php");?>
      <p style="font-size:16" align="center"><strong>LEMBAR DISPOSISI</strong></p>
      <table width="100%" style="margin-bottom:8px;">
         <tr>
            <td width="12%">Indeks</td>
            <td width="2%" align="center">:</td>
            <td width="86%"><?php echo $dataku['no_berkas'];?></td>
         </tr>
         <tr>
            <td>Berkas</td>
            <td align="center">:</td>
            <td><?php echo $dataku['jml_berkas'];?> Lembar</td>
         </tr>
      </table>
      <table width="100%" style="margin-bottom:8px;">
         <tr>
            <td width="24%">Tanggal/Nomor</td>
            <td width="2%" align="center">:</td>
            <td width="74%"><?php echo $dataku['no_surat'];?></td>
         </tr>
         <tr>
            <td>Asal</td>
            <td align="center">:</td>
            <td><?php echo $dataku['pengirim'];?></td>
         </tr>
         <tr>
            <td>Isi</td>
            <td align="center">:</td>
            <td><?php echo $dataku['perihal'];?></td>
         </tr>
         <tr>
            <td>Diterima Tanggal</td>
            <td align="center">:</td>
            <td><?php echo $dataku['tgl_terima'];?></td>
         </tr>
      </table>
      <table width="100%" style="margin-bottom:8px;">
         <tr>
            <td>Tanggal Penyelesaian:</td>
         </tr>
      </table>
      <table width="100%" style="margin-bottom:8px;">
         <tr>
            <td width="276" valign="top">Isi Disposisi:</td>
            <td width="280">
               Diteruskan kepada: <br/>
               <table width="100%">
                  <tr>
                     <td>1.</td>
                  </tr>
                  <tr>
                     <td>2.</td>
                  </tr>
                  <tr>
                     <td>3.</td>
                  </tr>
                  <tr>
                     <td>4.</td>
                  </tr>
                  <tr>
                     <td>5.</td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <table width="100%">
         <tr>
            <td align="justify">Setelah digunakan, surat ini mohon dikembalikan kepada Staf Sub Bagian Administrasi Umum Fakultas Psikologi untuk diarsipkan.</td>
         </tr>
      </table>
   </div>
      <?php include( "jsAdm.php" );?>
      <script>
        $(document).ready(function() {
        window.print();
        window.close(); 
        });
      </script>
   </body>
</html>