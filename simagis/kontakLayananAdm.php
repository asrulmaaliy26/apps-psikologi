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
    <?php include "navMasterDataAdm.php";
      $qry = "SELECT COUNT(*) AS jumData FROM mag_kontak_layanan";
         $result =  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $dataku = mysqli_fetch_assoc($result) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
         $jumlahData = $dataku['jumData'];
            
          include 'pagination.php';                 
          $reload = "kontakLayananAdm.php?pagination=true";
          $sql =  "SELECT * FROM mag_kontak_layanan ORDER BY id ASC";
          $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diinput</div>';}  
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';} 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}     
                 ?>
        <h3 class="text-center text-warning">Kontak Layanan</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Kontak Layanan.</li>
              <li>Silahkan tekan button yang dimaksud untuk konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Daftar Kontak Layanan</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input periode baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Input Periode Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table-condensed table table-bordered table-striped custom" style="margin-bottom:0px; font-size:12px;">
                    <thead>
                      <tr class="">
                        <th rowspan="2" class="text-center" width="3%">No.</th>
                        <th rowspan="2" class="text-center" width="14%">Nama</th>
                        <th colspan="2" class="text-center">Kontak</th>
                        <th rowspan="2" class="text-center" width="45%">Spesifikasi Layanan</th>
                        <th rowspan="2" class="text-center" width="8%">Opsi</th>
                      </tr>
                      <tr>
                        <th class="text-center" width="12%">HP</th>
                        <th class="text-center" width="18%">Email</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id = $data['id'];            
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no_urut;?></td>
                        <td><?php echo $data['nm'];?></td>
                        <td class="text-center"><?php echo $data['hp'];?></td>
                        <td class="text-center"><?php echo $data['email'];?></td>
                        <td><?php echo nl2br($data['deskripsi_layanan']);?></td>
                        <td class="text-center">
                          <button class="btn btn-warning" title="Edit periode" data-toggle="modal" data-target="#modalEdit" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                          <a class="btn btn-default" href="deleteKontakLayananAdm.php?id=<?php echo $data['id'];?>" onclick="return confirm('Yakin data ini dihapus?')" title="Hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalInput" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Input Kontak Layanan Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputKontakLayananAdm.php" method="post">
                    <div class="form-group">
                      <label for="nm">Nama</label>
                      <input type="text" name="nm" class="form-control" id="nm" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                      <label for="hp">Kontak HP</label>
                      <input type="text" name="hp" class="form-control" id="hp" placeholder="Kontak HP">
                    </div>
                    <div class="form-group">
                      <label for="email">Kontak Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Kontak Email">
                    </div>
                    <div class="form-group">
                      <label for="deskripsi_layanan">Spesifikasi Layanan</label>
                      <textarea name="deskripsi_layanan" class="form-control" id="deskripsi_layanan" placeholder="Spesifikasi Layanan" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
                </div>
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
              <h4 class="modal-title" id="modalEdit">Edit Kontak Layanan</h4>
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
      url: "editKontakLayananAdm.php",
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