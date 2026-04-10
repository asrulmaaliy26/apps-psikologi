<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
   $qta = "select * from mag_dt_ta WHERE status='1'";
   $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dta = mysqli_fetch_assoc($rta);  
   
   $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
   $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dwd1 = mysqli_fetch_assoc($rwd1);  
   
   $qkaprodi = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
   $rkaprodi = mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dkaprodi = mysqli_fetch_assoc($rkaprodi); 
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPngjnAdm.php";
      include 'pagination.php';     
       if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
       $keyword=$_REQUEST['keyword'];
       $reload = "rekapPsiptAdm.php?pagination=true&keyword=$keyword";
       
       $sql = "SELECT ms.id
       , ms.nim
       , ms.lembaga_tujuan_surat
       , ms.sebutan_pimpinan
       , ms.kota_penelitian
       , ms.nama_obyek
       , ms.tujuan_surat
       , ms.judul_tesis
       , ms.tgl_pengajuan
      FROM mag_sipt ms
      INNER JOIN mag_dt_mhssw_pasca mdmp
       on ms.nim = mdmp.nim
      INNER JOIN opsi_sebutan_pimpinan osp
       on ms.sebutan_pimpinan = osp.id
      INNER JOIN dt_kota dk
       on ms.kota_penelitian = dk.id
      INNER JOIN mag_pengelompokan_dospem_tesis mpdt1
       on ms.nim = mpdt1.nim
      INNER JOIN mag_pengelompokan_dospem_tesis mpdt2
       on ms.nim = mpdt2.nim
      INNER JOIN mag_dospem_tesis mdt1
       on mpdt1.dospem_tesis1 = mdt1.id
      INNER JOIN mag_dospem_tesis mdt2
       on mpdt2.dospem_tesis2 = mdt2.id
      INNER JOIN dt_pegawai dp1
       on mdt1.nip = dp1.id
      INNER JOIN dt_pegawai dp2
       on mdt2.nip = dp2.id
      
      WHERE ms.nim LIKE '%$keyword%' OR mdmp.nama LIKE '%$keyword%' OR ms.lembaga_tujuan_surat LIKE '%$keyword%' OR osp.nm LIKE '%$keyword%' OR dk.nm_kota LIKE '%$keyword%' OR ms.nama_obyek LIKE '%$keyword%' OR ms.tujuan_surat LIKE '%$keyword%' OR ms.judul_tesis LIKE '%$keyword%' OR dp1.nama LIKE '%$keyword%' OR dp2.nama LIKE '%$keyword%'";
       
       $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       }else{
       $reload = "rekapPsiptAdm.php?pagination=true";
       $sql = "SELECT * FROM mag_sipt ORDER BY statusform ASC";
       $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       }
       
       $rpp = 20;
       $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
       $tcount = mysqli_num_rows($result);
       $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
       $count = 0;
       $i = ($page-1)*$rpp;
       $no_urut = ($page-1)*$rpp;
       ?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
             echo '<div class="alert alert-success custom-alert" role="alert">
             <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}
           ?>
        <h3 class="text-center text-warning">Surat Izin Penelitian Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah rekap Surat Izin Penelitian Tesis.</li>
              <li>Silahkan tekan button yang dimaksud untuk eksekusi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Rekap Pengajuan</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <form method="post" action="rekapPsiptAdm.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="rekapPsiptAdm.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-condensed table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th width="3%" class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
                        <th width="10%" class="text-center">Tgl. Pengajuan</th>
                        <th width="24%">Pengaju</th>
                        <th width="48%">Tujuan Surat</th>
                        <th width="12%" class="text-center">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        
                        $id = $data['id'];
                        $qrymhs = "select * from mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                        $resmhs = mysqli_query($GLOBALS["___mysqli_ston"], $qrymhs )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dtmhs = mysqli_fetch_assoc( $resmhs );
                        
                        $qrysp = "select * from opsi_sebutan_pimpinan WHERE id='$data[sebutan_pimpinan]'";
                        $ressp = mysqli_query($GLOBALS["___mysqli_ston"], $qrysp )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dtsp = mysqli_fetch_assoc( $ressp );
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td class="text-center"><?php if($data['statusform']==1) {echo '<span class="glyphicon glyphicon-edit text-danger"></span>';} else {echo '<span class="glyphicon glyphicon-check text-success"></span>';}?></td>
                        <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                        <td><?php echo $dtmhs['nama'].' / '.$dtmhs['nim'];?></td>
                        <td><?php echo $dtsp['nm'].' '.$data['lembaga_tujuan_surat'];?></td>
                        <td class="text-center">
                          <button class='btn btn-warning' title='Edit dan validasi pengajuan surat' data-toggle='modal' data-target='#modalEdit' data-whatever='<?php echo $id;?>'><span class="glyphicon glyphicon-edit"></span></button>
                          <?php if($data['statusform']==1) {echo '<a role="button" class="btn btn-primary" title="Edit dan validasi pengajuan surat terlebih dahulu sebelum dicetak" disabled><span class="glyphicon glyphicon-print"></span></a>';} else { echo '<a role="button" href="cetakPsipt.php?id='."$id".'" class="btn btn-primary" title="Cetak pengajuan surat" target="_blank"><span class="glyphicon glyphicon-print"></span></a>';}?>         
                          <?php if($data['statusform']==2) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Pengajuan surat telah divalidasi' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePsiptAdm.php?id=".$id."' onclick='return confirm(\"Yakin pengajuan surat ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}?>              
                        </td>
                      </tr>
                      <?php
                        $i++; 
                        $count++;
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages);?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Edit dan Validasi Pengajuan Surat</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $(document).ready(function () {
      $("#myModal").modal({
       backdrop: false
      });
      $("#myModal").modal("show");
      });
      
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editPsiptAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEdit').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>