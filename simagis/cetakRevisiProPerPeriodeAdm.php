<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION['username'];
  
  $id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id_sempro' ] );
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Simagis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
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
   $myquery = "SELECT * FROM mag_revisi_sempro WHERE id_sempro='$id_sempro'";
   $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   while ($dataku = mysqli_fetch_assoc( $res )) 
   {

   $qryperiod = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$dataku[id_sempro]'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $tahap = $dperiod['tahap'];
   $ta = $dperiod['ta'];
                         
   $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
   $dthp = mysqli_fetch_assoc($hasil);
                         
   $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
                         
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h);
  
  $qnm =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim = '$dataku[nim]'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
  $dnm = mysqli_fetch_assoc($r);
  
  $qdpes = "SELECT * FROM mag_peserta_sempro WHERE id='$dataku[id_peserta]'";
  $rpes = mysqli_query($GLOBALS["___mysqli_ston"], $qdpes)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpes = mysqli_fetch_assoc($rpes);
  
  $qjad = "SELECT * FROM mag_jadwal_sempro WHERE id_pendaftaran='$dpes[id]'";
  $rjad = mysqli_query($GLOBALS["___mysqli_ston"], $qjad)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $djad = mysqli_fetch_assoc($rjad);
  
  $qruang = "SELECT * FROM dt_ruang WHERE id='$djad[ruang]'";
  $rruang = mysqli_query($GLOBALS["___mysqli_ston"], $qruang)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $druang = mysqli_fetch_assoc($rruang);
  
  $qid1 = "SELECT * FROM dt_pegawai WHERE id='$dpes[dospem_tesis1]'";
  $rid1 = mysqli_query($GLOBALS["___mysqli_ston"], $qid1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $did1 = mysqli_fetch_assoc($rid1);
  
  $qid2 = "SELECT * FROM dt_pegawai WHERE id='$dpes[dospem_tesis2]'";
  $rid2 = mysqli_query($GLOBALS["___mysqli_ston"], $qid2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $did2 = mysqli_fetch_assoc($rid2);
  
  $qpgj1 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji1]'";
  $rpgj1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj1 = mysqli_fetch_assoc($rpgj1);
  
  $qpgj2 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji2]'";
  $rpgj2 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj2 = mysqli_fetch_assoc($rpgj2);
  
  $qpgj3 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji3]'";
  $rpgj3 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj3)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj3 = mysqli_fetch_assoc($rpgj3);
  
  $qpgj4 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji4]'";
  $rpgj4 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj4)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj4 = mysqli_fetch_assoc($rpgj4);
  
  $qn = "SELECT * FROM mag_nilai_sempro WHERE id_pendaftaran='$dpes[id]'";
  $rn = mysqli_query($GLOBALS["___mysqli_ston"], $qn)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dn = mysqli_fetch_assoc($rn);
  
  $nilaiakhir = ($dn['nilai_penguji1'] + $dn['nilai_penguji2'] + $dn['nilai_penguji3'] + $dn['nilai_penguji4']) / 4;
  $nilaibulat = round($nilaiakhir);
  ?>

      <div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="box_1 pull-left hidden-sm hidden-xs">
          <label>
          <img src="<?php echo '/simagis/'.$dnm['photo'];?>" onError="this.onerror=null;this.src='<?php if($dnm['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
        <div class="box_1 center-block hidden-lg hidden-md">
          <label>
          <img src="<?php echo '/simagis/'.$dnm['photo'];?>" onError="this.onerror=null;this.src='<?php if($dnm['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
      </div>
      <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="panel panel-danger">
          <div class="panel-heading text-center">Detail Data</div>
          <div class="table-responsive">
            <table class="table" style="font-size: 13px;">
              <tbody>
                <tr>
                  <td width="26%" class="text-left">Nama</td>
                  <td width="2%" class="text-center">:</td>
                  <td width="62%" class="text-left"><?php echo $dnm['nama'].' / '.$dnm['nim'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Dospem</td>
                  <td class="text-center">:</td>
                  <td class="text-left">[1]. <?php echo $did1['nama'];?> [2]. <?php echo $did2['nama'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Periode Sempro</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Daftar</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dpes['tgl_pendaftaran'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Sempro</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $djad['tgl_seminar'].', '."Pukul:".' '.$djad['jam_mulai'].'-'.$djad['jam_selesai'].', '."Tempat: ".$druang['nm'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Judul Proposal</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dpes['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dpes['judul_prop']);?></td>
                </tr>
                <tr>
                  <td class="text-left">Penguji [Nilai]</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo "[Penguji Utama]".' '.$dpgj3['nama'].' ['.$dn['nilai_penguji3'].']';?>
                    <br/>
                    <?php echo "[Ketua Penguji]".' '.$dpgj4['nama'].' ['.$dn['nilai_penguji4'].']';?>
                    <br/>
                    <?php echo "[Pembimbing I]".' '.$dpgj1['nama'].' ['.$dn['nilai_penguji1'].']';?>
                    <br/>
                    <?php echo "[Pembimbing II]".' '.$dpgj2['nama'].' ['.$dn['nilai_penguji2'].']';?>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Nilai Akhir</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php if($nilaibulat >=80 && $nilaibulat <= 100) { echo 'Lanjut';} if($nilaibulat >=60 && $nilaibulat <= 79) { echo 'Lanjut (Revisi)';} if($nilaibulat < 60) { echo 'Seminar Ulang';}?> (<?php echo $nilaibulat;?>)</td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Upload Revisi</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dataku['tgl_upload'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Judul Proposal Pasca Revisi</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dataku['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['judul_prop']);?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php 
}
  ?>
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
 
</html>