<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qry_peminjam = "SELECT * FROM dt_peminjam_barang WHERE id='$id'";
  $r_peminjam = mysqli_query($con, $qry_peminjam);
  $d_peminjam = mysqli_fetch_assoc($r_peminjam);
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Submit data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Data Peminjaman Barang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dtPinjamBarang.php?page=<?php echo $page;?>">Data Peminjam Barang</a></li>
                  <li class="breadcrumb-item active small">Input Data Peminjaman Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination0.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload0 = "inputPeminjamanDtBarang.php?pagination0=true&keyword=$keyword&id=$id&page=$page";
          
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
          
          WHERE (r.id LIKE '%$keyword%' OR r.id_inventaris LIKE '%$keyword%' OR r.nm LIKE '%$keyword%' OR r.merk LIKE '%$keyword%' OR r.tgl_perolehan LIKE '%$keyword%' OR r.thn_perolehan LIKE '%$keyword%' OR r.kategori LIKE '%$keyword%' OR r.letak LIKE '%$keyword%' OR r.kondisi LIKE '%$keyword%' OR okb.nm LIKE '%$keyword%' OR omb.nm LIKE '%$keyword%' OR okob.nm LIKE '%$keyword%' OR ospb.nm LIKE '%$keyword%') AND (r.status_peminjaman='1') ORDER BY r.nm ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload0 = "inputPeminjamanDtBarang.php?pagination=true&id=$id&page=$page";
          $sql = "SELECT * FROM dt_inventaris_barang WHERE status_peminjaman='1' ORDER BY nm ASC";
          $result = mysqli_query($con, $sql);
          }
          
          $rpp0 = 20;
          $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
          $tcount0 = mysqli_num_rows($result);
          $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
          $count0 = 0;
          $i = ($page0-1)*$rpp0;
          $no_urut = ($page0-1)*$rpp0;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm mb-2">
                <form method="post" action="inputPeminjamanDtBarang.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>">
                  <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a class="btn btn-sm btn-warning" title="Kembali" href="inputPeminjamanDtBarang.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title float-left">Input Data Peminjaman Barang</h4>
                      <span class="float-right"><strong><?php echo $d_peminjam['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body pt-2 pb-2 pl-0 pr-0">
                    <form name="update" method="post" action="updatePeminjamanDtBarang.php" onSubmit="return confirm('Pinjamkan data terpilih?')">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="peminjam" class="sr-only" value="<?php echo $d_peminjam['id'];?>" required readonly>
                      <input type="text" name="tgl_awal_pinjam" class="sr-only" value="<?php echo $d_peminjam['tgl_awal_pinjam'];?>" required readonly>
                      <input type="text" name="tgl_akhir_pinjam" class="sr-only" value="<?php echo $d_peminjam['tgl_akhir_pinjam'];?>" required readonly>
                      <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-outline-primary btn-xs float-right mr-3" id="submit1"> <i class="fas fa-caret-square-right"></i> Pinjamkan Data Terpilih </button>
                        <div class="table-responsive pt-2 pb-2">
                          <table class="table table-hover table-bordered m-0 table-sm custom">
                            <thead class="thead-light">
                              <th width="4%" class="pl-1 text-center">No.</th>
                              <th width="12%" class="text-center">Kode Barang</th>
                              <th width="36%">Nama Barang</th>
                              <th width="16%">Kategori</th>
                              <th width="10%">Merk</th>
                              <th width="12%">Kondisi</th>
                              <th width="10%" class="text-center pr-1"><input type="checkbox" id="checkAll"> Select All</th>
                            </thead>
                            <tbody>
                              <?php
                                while(($count0<$rpp0) && ($i<$tcount0)) {
                                mysqli_data_seek($result, $i);
                                $data = mysqli_fetch_array($result);
                                
                                $qry_kat = "SELECT * FROM opsi_kat_barang WHERE id='$data[kategori]'";
                                $r_kat = mysqli_query($con, $qry_kat);
                                $d_kat = mysqli_fetch_assoc($r_kat);
                                
                                $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$data[merk]'";
                                $r_merk = mysqli_query($con, $qry_merk);
                                $d_merk = mysqli_fetch_assoc($r_merk);
                                
                                $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$data[kondisi]'";
                                $r_kondisi = mysqli_query($con, $qry_kondisi);
                                $d_kondisi = mysqli_fetch_assoc($r_kondisi);
                                ?>
                              <tr>
                                <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                                <td class="text-center"> <?php echo $data['id_inventaris'];?> </td>
                                <td class="text-left"> <?php echo $data['nm'];?> </td>
                                <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                                <td class="text-left"> <?php echo $d_merk['nm'];?> </td>
                                <td class="text-left"> <?php echo $d_kondisi['nm'];?> </td>
                                <td class="text-center pr-1"> <?php echo '<input class="chk" type="checkbox" name="item[]" id="myCheckbox" value="'.$data['id'].'" />';?> </td>
                              </tr>
                              <?php
                                $i++; 
                                $count0++;
                                }
                                ?>                        
                            </tbody>
                          </table>
                        </div>
                        <button name="submit" type="submit" class="btn btn-outline-primary btn-xs float-right mr-3" id="submit2"> <i class="fas fa-caret-square-right"></i> Pinjamkan Data Terpilih </button>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one0($reload0, $page0, $tpages0);?></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>