<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$id'";
  $r_ruang = mysqli_query($con, $qry_ruang);
  $d_ruang = mysqli_fetch_assoc($r_ruang);
  
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang WHERE letak='$d_ruang[id]'";
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
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Daftar Inventaris Ruangan</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dtDir.php?page=<?php echo $page;?>">Daftar Inventaris Ruangan</a></li>
                  <li class="breadcrumb-item active small">Hapus DIR</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination0.php';
          $reload0 = "deleteDtDir.php?id=$id&page=$page&pagination0=true";
          $sql0 = "SELECT * FROM dt_inventaris_barang WHERE letak='$d_ruang[id]' ORDER BY nm ASC";
          $result0 = mysqli_query($con, $sql0);
          
          $rpp0 = 20;
          $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
          $tcount0 = mysqli_num_rows($result0);
          $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
          $count0 = 0;
          $i0 = ($page0-1)*$rpp0;
          $no_urut0 = ($page0-1)*$rpp0;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">DIR dalam Ruangan Ini (<?php echo $d_jum['jumData']?>)</h4>
                      <span class="float-right"><strong><?php echo $d_ruang['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body pt-2 pb-2 pl-0 pr-0">
                    <form name="update" method="post" action="updateDeleteDtDir.php" onSubmit="return confirm('Hapus data terpilih?')">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="page0" class="sr-only" value="<?php echo $page0;?>" required readonly>
                      <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-outline-danger btn-xs float-right mr-3" id="submit1"> <i class="fas fa-minus-square"></i> Hapus Data Terpilih </button>
                        <div class="table-responsive pt-2 pb-2">
                          <table class="table table-hover table-bordered m-0 table-sm custom">
                            <thead class="thead-light">
                              <th width="4%" class="pl-1 text-center">No.</th>
                              <th width="12%">Kode Barang</th>
                              <th width="26%">Nama Barang</th>
                              <th width="12%">Kategori</th>
                              <th width="10%">Merk</th>
                              <th width="16%" class="text-center">Tgl dan Thn Perolehan</th>
                              <th width="10%">Kondisi</th>
                              <th width="10%" class="text-center pr-1"><input type="checkbox" id="checkAll"> Select All</th>
                            </thead>
                            <tbody>
                              <?php
                                while(($count0<$rpp0) && ($i0<$tcount0)) {
                                mysqli_data_seek($result0, $i0);
                                $data0 = mysqli_fetch_array($result0);
                                
                                $qry_kat = "SELECT * FROM opsi_kat_barang WHERE id='$data0[kategori]'";
                                $r_kat = mysqli_query($con, $qry_kat);
                                $d_kat = mysqli_fetch_assoc($r_kat);
                                
                                $qry_merk = "SELECT * FROM opsi_merk_barang WHERE id='$data0[merk]'";
                                $r_merk = mysqli_query($con, $qry_merk);
                                $d_merk = mysqli_fetch_assoc($r_merk);
                                
                                $qry_kondisi = "SELECT * FROM opsi_kondisi_barang WHERE id='$data0[kondisi]'";
                                $r_kondisi = mysqli_query($con, $qry_kondisi);
                                $d_kondisi = mysqli_fetch_assoc($r_kondisi);
                                ?>
                              <tr>
                                <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                                <td class="text-center"> <?php echo $data0['id_inventaris'];?> </td>
                                <td class="text-left"> <?php echo $data0['nm'];?> </td>
                                <td class="text-left"> <?php echo $d_kat['nm'];?> </td>
                                <td class="text-left"> <?php echo $d_merk['nm'];?> </td>
                                <td class="text-center"> <?php echo $data0['thn_perolehan'].' ['.$data0['tgl_perolehan'].']';?> </td>
                                <td class="text-left"> <?php echo $d_kondisi['nm'];?> </td>
                                <td class="text-center pr-1"> <?php echo '<input class="chk" type="checkbox" name="item[]" id="myCheckbox" value="'.$data0['id'].'" />';?> </td>
                              </tr>
                              <?php
                                $i0++; 
                                $count0++;
                                }
                                ?>                        
                            </tbody>
                          </table>
                        </div>
                        <button name="submit" type="submit" class="btn btn-outline-danger btn-xs float-right mr-3" id="submit2"> <i class="fas fa-minus-square"></i> Hapus Data Terpilih </button>
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