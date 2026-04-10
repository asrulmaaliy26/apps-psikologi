<?php include( "contentsConAdm.php" );
  $id=abs((int)mysqli_real_escape_string($con, $_GET['id']));
  $myquery="SELECT * FROM surat_keluar WHERE id='$id'";
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
      .table, tr, td {
      padding-top:3px;
      padding-bottom:3px;
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
      margin-top:14px;
      }   
      .kepada {
      float: right !important;
      position:relative;
      width: 460px;
      margin-top:80px;
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
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px; margin-left:55px;">
    <div class="page">
      <?php include ("kopSurat.php");?>
      <div class="kepada">
        <table width="100%">
          <tr>
            <td colspan="3">Kepada:</td>
          </tr>
          <tr valign="top">
            <td width="6%">Yth.</td>
            <td colspan="2"><?php echo $dataku['tujuan'];?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="3%">di</td>
            <td width="84%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Tempat</td>
          </tr>
        </table>
      </div>
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