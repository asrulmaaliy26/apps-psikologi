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
      $qry = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_rumpun";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
         	  
          include 'pagination.php';                 
       	  $reload = "rekapPrpAdm.php?pagination=true";
       	  $sql =  "SELECT * FROM mag_pengelompokan_rumpun ORDER BY id DESC";
       	  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
           $rpp = 40;
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
        <h3 class="text-center text-warning">Pengajuan Rumpun Psikologi</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pengajuan Rumpun Psikologi.</li>
              <li>Silahkan tekan button Edit untuk merubah pengajuan.</li>
              <li>Silahkan tekan button Hapus untuk menghapus pengajuan.</li>
              <li>Silahkan Pilih Verifikasi untuk memverifikasi pengajuan.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" style="margin-bottom:0px;">
                    <thead>
                      <tr class="danger">
                        <th class="text-center" width="4%">No.</th>
                        <th class="text-center" width="36%">Nama | NIM</th>
                        <th class="text-center" width="14%">Tgl. Pengajuan</th>
                        <th class="text-center" width="16%">Pilihan Rumpun</th>
                        <th class="text-center" width="10%">Opsi</th>
                        <th class="text-center" width="20%">Verifikasi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        
                        $id = $data['id'];
                        
                        $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm =mysqli_fetch_assoc($res);
                        
                        $qrumpun = "SELECT * FROM mag_opsi_rumpun WHERE id='$data[rumpun]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qrumpun);
                        $drumpun = mysqli_fetch_assoc($res);						
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                        <td class="text-center"><?php echo $drumpun['nm'];?></td>
                        <td class="text-center">
                          <button class="btn btn-sm btn-warning" title="Edit periode pendaftaran" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>&page=<?php echo "$page";?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>						   
                          <a class='btn btn-sm btn-default' href='deletePprp.php?<?php echo $data['id'];?>&page=<?php echo "$page";?>' onclick='return confirm("Yakin data ini dihapus?")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>
                        </td>
						<td class="text-center"><?php echo $drumpun['nm'];?></td>
                      </tr>
                      <?php
                        $i++; 
                        $count++;
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
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
              <h4 class="modal-title" id="modalEdit">Edit Pengajuan Rumpun Psikologi</h4>
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
      url: "editPprpAdm.php",
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