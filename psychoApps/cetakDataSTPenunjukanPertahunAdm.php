<?php include( "contentsConAdm.php" );
   
   $id=mysqli_real_escape_string($con, $_GET['id']);
   
   $myquery="SELECT * FROM st WHERE id='$id'";
   $res=mysqli_query($con, $myquery) or die (mysqli_error($con));
   $dataku=mysqli_fetch_assoc($res);
   
   $qry="SELECT COUNT(id_st) AS jumPersonil FROM personil_st WHERE id_st='$id' AND nama <>''";
   $r=mysqli_query($con, $qry) or die (mysqli_error($con));
   $dt=mysqli_fetch_assoc($r);
   $jumPersonil=$dt['jumPersonil'];
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
         /*css kop surat */
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
      <?php 
         if($jumPersonil <= 5) { include "eksCetakStPenunjukan_1.php";}
         else { include "eksCetakStPenunjukan_2.php";}
         ?>
      <?php include( "jsAdm.php" );?>
      <script>
        $(document).ready(function() {
        window.print();
        window.close(); 
        });
      </script>
   </body>
</html>