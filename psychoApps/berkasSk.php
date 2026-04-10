<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $myquery = "SELECT * FROM dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Download Berkas</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">SK (Surat Keputusan)</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "berkasSk.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT ps.id
          , ps.id_sending_surat
          , ps.jenis_surat_penerima
          , ps.penerima
          , ps.tgl_kirim
          , ps.bln_kirim
          , ps.thn_kirim
          
          FROM penerima_surat ps
          INNER JOIN sending_surat ss
          on ps.id_sending_surat = ss.id
          LEFT JOIN opsi_jenis_file_surat ojfs
          on ss.jenis_surat = ojfs.id
          LEFT JOIN dt_all_adm ab
          on ss.executor = ab.username

          WHERE (ps.id_sending_surat LIKE '%$keyword%' OR ps.jenis_surat_penerima LIKE '%$keyword%' OR ps.penerima LIKE '%$keyword%' OR ps.tgl_kirim LIKE '%$keyword%' OR ps.bln_kirim LIKE '%$keyword%' OR ps.thn_kirim LIKE '%$keyword%' OR ss.deskripsi LIKE '%$keyword%' OR ss.jenis_surat LIKE '%$keyword%' OR ss.file_surat LIKE '%$keyword%' OR ss.tgl_upload LIKE '%$keyword%' OR ss.bln_upload LIKE '%$keyword%' OR ss.thn_upload LIKE '%$keyword%' OR ss.catatan LIKE '%$keyword%' OR ss.executor LIKE '%$keyword%' OR ss.editor LIKE '%$keyword%' OR ojfs.nm LIKE '%$keyword%' OR ab.nm_person LIKE '%$keyword%') AND ps.penerima=$dtDosen[id] AND ps.jenis_surat_penerima = '1' GROUP BY ps.id ORDER BY ps.id_sending_surat DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "berkasSk.php?pagination=true";
          $sql = "SELECT * FROM penerima_surat WHERE penerima='$dtDosen[id]' AND jenis_surat_penerima ='1' ORDER BY id_sending_surat DESC";
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
                <form method="post" action="berkasSk.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="berkasSk.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">SK (Surat Keputusan)</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" width="56%" class="text-center">Keterangan Berkas</td>
                            <td scope="col" width="20%" class="text-center">Pengirim</td>
                            <td scope="col" width="10%" class="text-center">Tgl. Kirim</td>
                            <td scope="col" width="10%" class="text-center pr-1">Berkas</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $id = $data['id'];
                            
                            $qss =  "SELECT * FROM sending_surat WHERE id='$data[id_sending_surat]'";
                            $rss = mysqli_query($con, $qss);
                            $dss = mysqli_fetch_array($rss);
                            
                            $qab =  "SELECT * FROM dt_all_adm WHERE username='$dss[executor]'";
                            $rab = mysqli_query($con, $qab);
                            $dab = mysqli_fetch_array($rab);

                            include_once("month_function_4.php");
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dss['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dss['deskripsi']);?></td>
                            <td class="text-left"><?php echo $dab['nm_person'];?></td>
                            <td class="text-center"><?php echo tglIndo($data['tgl_kirim']);?></td>
                            <td class="text-center pr-1"> <?php if(empty($dss['file_surat'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada file!\')" title="Tidak ada file" disabled><i class="fas fa-download"></i></a>';} else { echo '<a class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Lihat/download" href="'.$dss['file_surat'].'" target="_blank"><i class="fas fa-download"></i></a>';}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table no-border rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="22%" class="pl-1">Keterangan Berkas</th>
                                        <td width="4%">:</td>
                                        <td width="74%"><?php echo $dss['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dss['deskripsi']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pengirim</th>
                                        <td>:</td>
                                        <td><?php echo $dab['nm_person'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tgl. Kirim</th>
                                        <td>:</td>
                                        <td><?php echo tglIndo($data['tgl_kirim']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Catatan</th>
                                        <td>:</td>
                                        <td><?php echo $dss['catatan'];?></td>
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
                </div>
                <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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