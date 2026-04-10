<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang";
  $r_jum = mysqli_query($con,  $qry_jum )or DIE( mysqli_error($con) );
  $d_jum = mysqli_fetch_assoc( $r_jum );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBmn.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Input data gagal! Kode inventaris barang sudah terdaftar!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalImage') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Update gambar gagal! Pastikan file yang diupload adalah file jpeg, jpg, atau png!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Submit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Edit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Delete data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}              
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Barang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dtBarang.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT r.id
          , r.id_inventaris
          , r.nm
          , r.merk
          , r.tgl_perolehan
          , r.thn_perolehan
          , r.kategori
          , r.letak
          , r.kondisi
          , r.status_peminjaman
          
          FROM dt_inventaris_barang r
          LEFT JOIN opsi_kat_barang okb
          on r.kategori = okb.id
          LEFT JOIN opsi_merk_barang omb
          on r.merk = omb.id
          LEFT JOIN opsi_kondisi_barang okob
          on r.kondisi = okob.id
          LEFT JOIN opsi_status_peminjaman_barang ospb
          on r.status_peminjaman = ospb.id
          
          WHERE r.id LIKE '%$keyword%' OR r.id_inventaris LIKE '%$keyword%' OR r.nm LIKE '%$keyword%' OR r.merk LIKE '%$keyword%' OR r.tgl_perolehan LIKE '%$keyword%' OR r.thn_perolehan LIKE '%$keyword%' OR r.kategori LIKE '%$keyword%' OR r.letak LIKE '%$keyword%' OR r.kondisi LIKE '%$keyword%' OR okb.nm LIKE '%$keyword%' OR omb.nm LIKE '%$keyword%' OR okob.nm LIKE '%$keyword%' OR ospb.nm LIKE '%$keyword%' ORDER BY r.nm ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dtBarang.php?pagination=true";
          $sql = "SELECT * FROM dt_inventaris_barang ORDER BY nm ASC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp = 20;
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
                <form method="post" action="dtBarang.php">
                  <?php error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dtBarang.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Data Barang (<?php echo $d_jum['jumData'];?>)</h4>
                      <button type="button" class="btn btn-outline-primary btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="far fa-plus-square"></i> Input Data Barang</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="12%">Kode Barang</th>
                          <th width="24%">Nama Barang</th>
                          <th width="16%">Kategori</th>
                          <th width="10%">Merk</th>
                          <th width="12%">Kondisi</th>
                          <th width="10%">Status</th>
                          <th class="pr-1 text-center" colspan="3">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_sumber_dn = "SELECT * FROM opsi_sumber_dana_perolehan_barang WHERE id='$data[sumber_dana]'";
                            $r_sumber_dn = mysqli_query($con, $qry_sumber_dn);
                            $d_sumber_dn = mysqli_fetch_assoc($r_sumber_dn);

                            $qry_kat = "SELECT * FROM opsi_kat_barang WHERE id='$data[kategori]'";
                            $r_kat = mysqli_query($con, $qry_kat);
                            $d_kat = mysqli_fetch_assoc($r_kat);
                            
                            $qry_sub_kat = "SELECT * FROM opsi_sub_kat_barang WHERE id='$data[sub_kategori]'";
                            $r_sub_kat = mysqli_query($con, $qry_sub_kat);
                            $d_sub_kat = mysqli_fetch_assoc($r_sub_kat);

                            $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$data[merk]'";
                            $r_merk = mysqli_query($con, $qry_merk);
                            $d_merk = mysqli_fetch_assoc($r_merk);
                            
                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$data[letak]'";
                            $r_ruang = mysqli_query($con, $qry_ruang);
                            $d_ruang = mysqli_fetch_assoc($r_ruang);

                            $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$data[kondisi]'";
                            $r_kondisi = mysqli_query($con, $qry_kondisi);
                            $d_kondisi = mysqli_fetch_assoc($r_kondisi);

                            $qry_ospb = "SELECT * FROM opsi_status_peminjaman_barang WHERE id='$data[status_peminjaman]'";
                            $r_ospb = mysqli_query($con, $qry_ospb);
                            $d_ospb = mysqli_fetch_assoc($r_ospb);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-center"> <?php echo $data['id_inventaris'];?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_merk['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_kondisi['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_ospb['nm'];?> </td>
                            <td class="text-center" width="4%"> <a href="editImageBarang.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-xs btn-block" title="Edit gambar"><i class="far fa-image"></i></a> </td>
                            <td class="text-center" width="4%"> <?php if($data['status_peminjaman']==2) { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit! Data masih dalam peminjaman\")' title='Tidak bisa diedit! Data masih dalam peminjaman' disabled><i class='far far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-primary btn-xs btn-block' href='editDtBarang.php?id=".$data['id']."&page=".$page."' title='Edit data'><i class='far fa-edit'></i></a>";}?> </td>
                            <td class="text-center pr-1" width="4%"> <?php if($data['status_peminjaman']==2) { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Data masih dalam peminjaman\")' title='Tidak bisa dihapus! Data masih dalam peminjaman' disabled><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-xs btn-block' href='deleteDtBarang.php?id=".$data['id']."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus data'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="10">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="22%">Kode Inventaris Barang</th>
                                        <td width="4%">:</td>
                                        <td width="74%"><?php echo $data['id_inventaris'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Nama Barang</th>
                                        <td>:</td>
                                        <td><?php echo $data['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Merk Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_merk['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Tanggal dan Tahun Perolehan</th>
                                        <td>:</td>
                                        <td><?php echo $data['thn_perolehan'].' ['.$data['tgl_perolehan'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th>Sumber Dana Perolehan</th>
                                        <td>:</td>
                                        <td><?php echo $d_sumber_dn['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kategori Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_kat['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Sub Kategori Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_sub_kat['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Letak Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_ruang['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kondisi Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_kondisi['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Status Barang</th>
                                        <td>:</td>
                                        <td><?php echo $d_ospb['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th>Kode Barang Universitas</th>
                                        <td>:</td>
                                        <td><?php echo $data['id_inventaris_pusat'];?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
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
    <form action="sDtBarang.php" method="post">
      <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="inputModalLabel">Input Data Barang</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="nm">Nama Barang</label>
              <div class="form-group">
                <input name="nm" class="form-control form-control-sm" required>
              </div>
              <div class="form-group">
                <label for="merk">Merk Barang</label>
                <select name="merk" class="form-control form-control-sm">
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_merk_barang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tgl_perolehan">Tanggal dan Tahun Perolehan Barang</label>
                <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                  <input type="text" name="tgl_perolehan" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" required/>
                  <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="sumber_dana">Sumber Dana Perolehan Barang</label>
                <select name="sumber_dana" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_sumber_dana_perolehan_barang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kategori">Kategori Barang</label>
                <select name="kategori" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_kat_barang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="sub_kategori">Sub Kategori Barang</label>
                <select name="sub_kategori" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_sub_kat_barang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kondisi">Kondisi Barang</label>
                <select name="kondisi" class="form-control form-control-sm" required>
                  <option value="">-Pilih-</option>
                  <?php
                    $q = mysqli_query($con, "SELECT * FROM opsi_kondisi_barang ORDER BY nm ASC");
                    while ($c = mysqli_fetch_array($q)){
                      echo "<option value='$c[id]'>$c[nm]</option>";
                    }
                    ?>
                </select>
              </div>
              <label for="id_inventaris_pusat">Kode Barang Universitas</label>
              <div class="form-group">
                <input name="id_inventaris_pusat" class="form-control form-control-sm">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>