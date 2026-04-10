<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Kirim File Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Surat Keputusan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "rekapKirimSuratKeputusanAdm.php?pagination=true&keyword=$keyword";
          
           $sql = "SELECT ss.id
          , ss.deskripsi
          , ss.jenis_surat
          , ss.file_surat
          , ss.tgl_upload
          , ss.bln_upload          
          , ss.thn_upload
          , ss.catatan
          , ss.executor
          , ss.editor
          FROM sending_surat ss
          LEFT JOIN penerima_surat ps
          ON ps.id_sending_surat = ss.id
          LEFT JOIN dt_pegawai dp
          ON dp.id = ps.penerima
          LEFT JOIN dt_all_adm ab1
          ON ab1.username = ss.executor
          LEFT JOIN dt_all_adm ab2
          ON ab2.username = ss.editor
          WHERE (ss.deskripsi LIKE '%$keyword%' OR ss.jenis_surat LIKE '%$keyword%' OR ss.file_surat LIKE '%$keyword%' OR ss.tgl_upload LIKE '%$keyword%' OR ss.bln_upload LIKE '%$keyword%' OR ss.thn_upload LIKE '%$keyword%' OR ss.catatan LIKE '%$keyword%' OR ss.executor LIKE '%$keyword%' OR ss.editor LIKE '%$keyword%' OR dp.nama LIKE '%$keyword%' OR ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND ss.thn_upload='$tahun' AND ss.jenis_surat='1' GROUP BY ss.id ORDER BY ss.tgl_upload DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapKirimSuratKeputusanAdm.php?pagination=true";
          $sql = "SELECT * FROM sending_surat WHERE thn_upload='$tahun' AND jenis_surat='1' ORDER BY tgl_upload DESC";
          $result = mysqli_query($con, $sql);
          }
          
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
              <div class="col-sm-4 mb-2">
                <form method="post" action="rekapKirimSuratKeputusanAdm.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="rekapKirimSuratKeputusanAdm.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-8 mb-2">
                <a href="inputFileSkAdm.php?page=<?php echo $page;?>" class="btn btn-outline-danger btn-sm float-sm-right"><i class="fas fa-upload"></i> Upload file baru</a>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Tahun <?php echo $tahun;?></h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                          <th scope="col" width="4%" class="text-center pl-1">No.</th>
                          <th scope="col" width="40%">Keterangan tentang File</th>
                          <th scope="col" width="8%" class="text-center">File</th>
                          <th scope="col" width="10%" class="text-center">Tgl. Upload</th>
                          <th scope="col" width="6%" class="text-center">Penerima</th>
                          <th scope="col" colspan="4" class="text-center pr-1">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM penerima_surat WHERE id_sending_surat='$data[id]'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left" title="<?php echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);?>"><?php $allowedlimit = 58; if(mb_strlen($data['deskripsi'])>$allowedlimit) { echo mb_substr($data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']),0,$allowedlimit)."...".'';} else {echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);}?></td>
                            <td class="text-center"><?php if(empty($data['file_surat'])) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" onclick="return confirm(\'Tidak ada file!\')" title="Tidak ada file" disabled><i class="fas fa-download"></i></a>';} else { echo '<a class="btn btn-outline-warning btn-xs btn-block" title="Lihat/download" href="'.$data['file_surat'].'" target="_blank"><i class="fas fa-download"></i></a>';}?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_upload']) );?></td>
                            <td class="text-center"><?php echo $data1['jumData'];?></td>
                            <td class="text-center" width="12%"><a href="inputPenerimaFileSkAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" class="btn btn-outline-primary btn-xs btn-block" title="Input penerima file"><i class="fas fa-user-plus"></i> Input Penerima</a></td>
                            <td class="text-center" width="12%"><?php if(empty($data1['jumData'])) {echo '<a class="btn btn-outline-secondary btn-xs btn-block" onClick="return confirm(\'Belum ada penerima file\')" title="Belum ada penerima"><i class="fas fa-user-slash"></i> Hapus Penerima</a>';} else { echo '<a href="deletePenerimaFileSkAdm.php?id='.$data['id'].'&page='.$page.'" class="btn btn-outline-danger btn-xs btn-block" title="Hapus penerima file"><i class="fas fa-user-slash"></i> Hapus Penerima</a>';}?></td>
                            <td class="text-center pl-2" width="4%"><a href="editFileSkAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-warning btn-xs btn-block" title="Edit file"><i class="bi bi-pencil-square"></i></a></td>
                            <td class="text-center pr-2" width="4%"><a href="deleteFileSkAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-danger btn-xs btn-block" onClick="return confirm('Yakin data ini dihapus?')" title="Hapus file"><i class="bi bi-trash"></i></a></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="9">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Keterangan tentang File</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Upload File</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_upload']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Penerima File</th>
                                        <td>:</td>
                                        <td>
                                          <?php 
                                            $qPenerima="SELECT penerima_surat.id,penerima_surat.id_sending_surat,penerima_surat.penerima,dt_pegawai.id AS id_pegawai,dt_pegawai.nama_tg FROM penerima_surat LEFT JOIN dt_pegawai ON penerima_surat.penerima=dt_pegawai.id WHERE penerima_surat.id_sending_surat='$data[id]' ORDER BY dt_pegawai.nama_tg ASC";
                                            $rPenerima=mysqli_query($con, $qPenerima) or die (mysqli_error($con));
                                            while($dPenerima=mysqli_fetch_assoc($rPenerima)) {
                                            echo $dPenerima['nama_tg'].' ['.$dPenerima['id_pegawai'].']'; echo "<br/>";}?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Eksekutor</th>
                                        <td>:</td>
                                        <td><?php echo $dEksekutor['nm_person'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Editor</th>
                                        <td>:</td>
                                        <td><?php echo $dEditor['nm_person'];?></td>
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