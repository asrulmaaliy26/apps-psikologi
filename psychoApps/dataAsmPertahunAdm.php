<?php include( "contentsConAdm.php" );
$tahun=mysqli_real_escape_string($con, $_GET['tahun']);
$page_a=mysqli_real_escape_string($con, $_GET['page_a']);
?>
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
                <h4 class="mb-0">Rekap Data</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dataAsmAdm.php?page=<?php echo $page_a;?>">Agenda Surat Masuk</a></li>
                  <li class="breadcrumb-item active small">Tahun <?php echo $tahun;?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "dataAsmPertahunAdm.php?pagination=true&keyword=$keyword&tahun=$tahun&page_a=$page_a";
          
          $sql = "SELECT sm.id
          , sm.tgl_terima
          , sm.no_berkas
          , sm.pengirim
          , sm.tgl_surat
          , sm.tahun
          , sm.no_surat
          , sm.jml_berkas
          , sm.perihal
          , sm.ordner
          , sm.berkas
          , sm.executor
          , sm.editor
          FROM surat_masuk sm
          LEFT JOIN ordner o
          on o.id = sm.ordner
          LEFT JOIN dt_all_adm ab1
          on ab1.username = sm.executor
          LEFT JOIN dt_all_adm ab2
          on ab2.username = sm.editor
          
          WHERE (sm.tgl_terima LIKE '%$keyword%' OR sm.no_berkas LIKE '%$keyword%' OR sm.pengirim LIKE '%$keyword%' OR sm.tgl_surat LIKE '%$keyword%' OR sm.tahun LIKE '%$keyword%' OR sm.no_surat LIKE '%$keyword%' OR sm.jml_berkas LIKE '%$keyword%' OR sm.perihal LIKE '%$keyword%' OR sm.ordner LIKE '%$keyword%' OR sm.berkas LIKE '%$keyword%' OR sm.executor LIKE '%$keyword%' OR sm.editor LIKE '%$keyword%' OR o.kode_ordner LIKE '%$keyword%' OR o.nm_ordner LIKE '%$keyword%' OR ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND (sm.tahun='$tahun') GROUP BY sm.id ORDER BY ABS(sm.no_berkas) DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "dataAsmPertahunAdm.php?pagination=true";
          $sql = "SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) DESC";
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
              <div class="col-sm mb-2">
              <form method="post" action="dataAsmPertahunAdm.php?tahun=<?php echo $tahun;?>&page_a=<?php echo $page_a;?>">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="dataAsmPertahunAdm.php?tahun=<?php echo $tahun;?>&page_a=<?php echo $page_a;?>"><i class="fas fa-sync"></i> Kembali</a>
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
                      <h4 class="card-title">Tahun <?php echo $tahun;?></h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead class="thead-light">
                            <th width="4%" class="text-center pl-1">No.</th>
                            <th width="8%" class="text-center">No. Berkas</th>
                            <th width="30%">Pengirim</th>
                            <th width="38%">Perihal</th>
                            <th width="8%" class="text-center">Tgl. Surat</th>
                            <th colspan="3" class="text-center pr-1">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qryOrdner = "SELECT * FROM ordner WHERE id='$data[ordner]'";
                            $rOrdner = mysqli_query($con, $qryOrdner);
                            $dOrdner = mysqli_fetch_assoc($rOrdner);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-center"><?php echo $data['no_berkas'];?></td>
                            <td class="text-left"><?php echo $data['pengirim'];?></td>
                            <td class="text-left" title="<?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?>"><?php $allowedlimit = 58; if(mb_strlen($data['perihal'])>$allowedlimit) { echo mb_substr($data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']),0,$allowedlimit)."...".'';} else {echo  $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);}?></td>
                            <td class="text-center"><?php echo $data['tgl_surat'];?></td>
                            <td width="4%" class="text-center pl-2"><a href="editDataAsmPertahunAdm.php?id=<?php echo $data['id'];?>&page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-warning btn-block btn-xs" title="Edit agenda"><i class="bi bi-pencil-square"></i></a></td>
                            <td width="4%" class="text-center"><a href="cetakDisposisiDataAsmPertahunAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-secondary btn-block btn-xs" target="_blank" title="Cetak disposisi"><i class="bi bi-printer"></i></a></td>
                            <td width="4%" class="text-center pr-2"><a href="deleteDataAsmPertahunAdm.php?id=<?php echo $data['id'];?>&page_a=<?php echo $page_a;?>&tahun=<?php echo $tahun;?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-danger btn-block btn-xs" onClick="return confirm('Yakin data ini dihapus?')" title="Hapus agenda"><i class="bi bi-trash"></i></a></td>
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Tanggal Diterima</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php echo $data['tgl_terima'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nomor Agenda Berkas Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['no_berkas'];?></td>
                                      </tr>
                                      <tr>
                                        <th colspan="3" class="pl-1 text-danger">KETERANGAN DARI SURAT MASUK</th>
                                      </tr>                                      
                                      <tr>
                                        <th class="pl-1">Pengirim Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['pengirim'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_surat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">No. Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['no_surat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Jumlah Berkas Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['jml_berkas'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Perihal Surat</th>
                                        <td>:</td>
                                        <td><?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Ordner Surat</th>
                                        <td>:</td>
                                        <td><?php echo $dOrdner['nm_ordner'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">File Surat</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['berkas'])) { echo "Tidak ada";} else { echo '<a href="'.$data['berkas'].'" target="_blank">Unduh</a>';}?></td>
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