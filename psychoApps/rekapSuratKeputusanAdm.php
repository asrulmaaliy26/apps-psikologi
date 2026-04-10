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
                <h4 class="mb-0">Surat Keputusan</h4>
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
          $reload = "rekapSuratKeputusanAdm.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT eska.id
          , eska.perihal
          , eska.pertimbangan
          , eska.no_dipa
          , eska.awal_berlaku
          , eska.akhir_berlaku
          , eska.tgl_ditetapkan
          , eska.tembusan
          , eska.jenis_sk
          , eska.dekan
          , eska.tahun
          , eska.executor
          , eska.editor
          , o.id
          , o.kode_ordner
          , o.nm_ordner
          , ab1.nama
          , ab2.nama
          FROM sk eska
          INNER JOIN dt_all_adm ab1
          on eska.executor = ab1.username
          INNER JOIN dt_all_adm ab2
          on eska.editor = ab2.username
          
          WHERE (eska.id LIKE '%$keyword%' OR eska.perihal LIKE '%$keyword%' OR eska.pertimbangan LIKE '%$keyword%' OR eska.no_dipa LIKE '%$keyword%' OR eska.awal_berlaku LIKE '%$keyword%' OR eska.akhir_berlaku LIKE '%$keyword%' OR eska.tgl_ditetapkan LIKE '%$keyword%' OR eska.tembusan LIKE '%$keyword%' OR eska.jenis_sk LIKE '%$keyword%' OR eska.dekan LIKE '%$keyword%' OR eska.tahun LIKE '%$keyword%' OR eska.executor LIKE '%$keyword%' OR eska.editor LIKE '%$keyword%' OR ab1.nama LIKE '%$keyword%' OR ab2.nama LIKE '%$keyword%') AND (eska.tahun='$tahun') ORDER BY eska.id DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapSuratKeputusanAdm.php?pagination=true";
          $sql = "SELECT * FROM sk WHERE tahun='$tahun' ORDER BY id DESC";
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
                <form method="post" action="rekapSuratKeputusanSearchAdm.php">
                  <?php  error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group">
                    <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Kata kunci pencarian..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-sm btn-default">
                      <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-8 mb-2">
                <a href="inputSuratKeputusanAdm.php?page=<?php echo $page;?>" class="btn btn-outline-danger btn-sm float-sm-right"><i class="bi bi-envelope-plus"></i> Input data</a>
              </div>
            </div>
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Surat Keputusan</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td width="6%" class="text-center pl-1">No.</td>
                            <td width="54%">Perihal</td>
                            <td width="20%" class="text-center">Tgl. Berlaku</td>
                            <td width="10%" class="text-center">Tgl. Surat</td>
                            <td width="10%" class="text-center pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $data['perihal'];?></td>
                            <td class="text-center"><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
                            <td class="text-center"><?php echo $data['tgl_ditetapkan'];?></td>
                            <td class="text-center pr-1">
                              <a href="editSkAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-warning btn-xs" title="Edit surat"><i class="bi bi-pencil-square"></i></a>
                              <div class="btn-group">
                                <button type="button" class="btn btn-secondary btn-xs"><i class="bi bi-printer"></i></button>
                                <button type="button" class="btn btn-xs btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm-left" role="menu">
                                  <a class="dropdown-item" href="cetakSkModel_1.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="SK non honor dengan jabatan pada lampiran">SK Format I</a>
                                  <a class="dropdown-item" href="cetakSkModel_2.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="SK non honor tanpa jabatan pada lampiran">SK Format II</a>
                                  <a class="dropdown-item" href="cetakSkModel_3.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="SK berhonor dengan jabatan pada lampiran">SK Format III</a>
                                  <a class="dropdown-item" href="cetakSkModel_4.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" target="_blank" data-toggle="tooltip" data-placement="top" title="SK berhonor tanpa jabatan pada lampiran">SK Format IV</a>
                                </div>
                              </div>
                              <a href="deleteSkAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn btn-outline-danger btn-xs" onClick="return confirm('Yakin data ini dihapus?')" title="Hapus surat"><i class="bi bi-trash"></i></a>
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="5">
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
                                        <th class="pl-1">No. Agenda Berkas Surat</th>
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
                                        <td><?php echo $dEksekutor['nama'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Editor</th>
                                        <td>:</td>
                                        <td><?php echo $dEditor['nama'];?></td>
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