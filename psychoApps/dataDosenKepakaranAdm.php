<?php include("contentsConAdm.php");
  $qry_jumAktif = "SELECT COUNT(id) AS jumData FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1'";
  $r_jumAktif = mysqli_query($con, $qry_jumAktif);
  $d_jumAktif = mysqli_fetch_assoc($r_jumAktif);
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
      ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Kepakaran Dosen</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Kepakaran</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $filter_kepakaran = isset($_REQUEST['filter_kepakaran']) ? mysqli_real_escape_string($con, $_REQUEST['filter_kepakaran']) : "";
          $keyword = isset($_REQUEST['keyword']) ? mysqli_real_escape_string($con, $_REQUEST['keyword']) : "";

          $where = "WHERE d.jenis_pegawai='1'";
          $params = "";

          if($filter_kepakaran != ""){
            $where .= " AND d.kepakaran_mayor = '$filter_kepakaran'";
            $params .= "&filter_kepakaran=$filter_kepakaran";
          }
          if($keyword != ""){
            $where .= " AND (d.nama LIKE '%$keyword%' OR d.id LIKE '%$keyword%' OR d.kepakaran_minor LIKE '%$keyword%')";
            $params .= "&keyword=$keyword";
          }

          $reload = "dataDosenKepakaranAdm.php?pagination=true" . $params;
          $sql = "SELECT d.*, k.nm as nm_kepakaran 
                  FROM dt_pegawai d 
                  LEFT JOIN opsi_kepakaran_mayor k ON d.kepakaran_mayor = k.id 
                  $where 
                  ORDER BY k.nm ASC, d.nama ASC";

          $result = mysqli_query($con, $sql);
          $rpp = 50;
          $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
          $tcount = mysqli_num_rows($result);
          $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
          $count = 0;
          $i = ($page-1)*$rpp;
          $no_urut = ($page-1)*$rpp;
        ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm mb-2">
                <form method="post" action="dataDosenKepakaranAdm.php">
                  <div class="form-row">
                    <div class="form-group col-md-4 mb-0">
                      <select name="filter_kepakaran" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">- Semua Kepakaran -</option>
                        <?php
                          $q_opt = mysqli_query($con, "SELECT * FROM opsi_kepakaran_mayor ORDER BY nm ASC");
                          while($d_opt = mysqli_fetch_array($q_opt)){
                            $sel = ($filter_kepakaran == $d_opt['id']) ? "selected" : "";
                            echo "<option value='$d_opt[id]' $sel>$d_opt[nm]</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-8 mb-0">
                      <div class="input-group input-group-sm">
                        <input type="search" name="keyword" class="form-control" placeholder="Cari dosen atau kepakaran minor..." value="<?php echo $keyword;?>">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                          <?php if($keyword <> "" || $filter_kepakaran <> ""){ ?>
                            <a class="btn btn-warning" href="dataDosenKepakaranAdm.php"><i class="fas fa-sync"></i> Reset</a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">List Kepakaran Dosen (Total: <?php echo $d_jumAktif['jumData'];?> Dosen Aktif)</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm table-bordered">
                        <thead class="bg-light">
                          <tr>
                            <th width="5%" class="text-center">No.</th>
                            <th width="25%">Nama Dosen</th>
                            <th width="15%">NIP</th>
                            <th width="20%">Kepakaran Mayor</th>
                            <th width="25%">Kepakaran Minor / Trend Riset</th>
                            <th width="10%" class="text-center">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                              mysqli_data_seek($result, $i);
                              $data = mysqli_fetch_array($result);
                          ?>
                          <tr>
                            <td class="text-center"><?php echo ++$no_urut;?></td>
                            <td><strong><?php echo $data['nama'];?></strong></td>
                            <td><?php echo $data['id'];?></td>
                            <td><span class="badge badge-info"><?php echo $data['nm_kepakaran'] ? $data['nm_kepakaran'] : '-';?></span></td>
                            <td class="small">
                              <strong>Minor:</strong> <?php echo strip_tags($data['kepakaran_minor']);?><br>
                              <strong>Trend:</strong> <?php echo strip_tags($data['trend_riset']);?>
                            </td>
                            <td class="text-center">
                              <button type="button" class="btn btn-xs btn-outline-primary" data-toggle="modal" data-target="#editModal" 
                                data-id="<?php echo $data['id'];?>" 
                                data-nama="<?php echo $data['nama'];?>" 
                                data-mayor="<?php echo $data['kepakaran_mayor'];?>" 
                                data-minor="<?php echo htmlspecialchars(strip_tags($data['kepakaran_minor']));?>"
                                data-trend="<?php echo htmlspecialchars(strip_tags($data['trend_riset']));?>">
                                <i class="fas fa-edit"></i> Edit
                              </button>
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
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form action="updateKepakaranDosenAdm.php" method="post">
            <div class="modal-header bg-primary">
              <h5 class="modal-title" id="editModalLabel">Edit Kepakaran Dosen</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-id">
              <div class="form-group">
                <label>Nama Dosen</label>
                <input type="text" class="form-control" id="edit-nama" readonly>
              </div>
              <div class="form-group">
                <label>Kepakaran Mayor</label>
                <select name="kepakaran_mayor" id="edit-mayor" class="form-control" required>
                  <option value="">- Pilih Kepakaran -</option>
                  <?php
                    $q_opt2 = mysqli_query($con, "SELECT * FROM opsi_kepakaran_mayor ORDER BY nm ASC");
                    while($d_opt2 = mysqli_fetch_array($q_opt2)){
                      echo "<option value='$d_opt2[id]'>$d_opt2[nm]</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Kepakaran Minor</label>
                <textarea name="kepakaran_minor" id="edit-minor" class="form-control" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label>Trend Riset</label>
                <textarea name="trend_riset" id="edit-trend" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nama = button.data('nama');
        var mayor = button.data('mayor');
        var minor = button.data('minor');
        var trend = button.data('trend');

        var modal = $(this);
        modal.find('#edit-id').val(id);
        modal.find('#edit-nama').val(nama);
        modal.find('#edit-mayor').val(mayor);
        modal.find('#edit-minor').val(minor);
        modal.find('#edit-trend').val(trend);
      });
    </script>
  </body>
</html>
