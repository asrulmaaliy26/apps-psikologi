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
                <h4 class="mb-0">Buat Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Surat Tugas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "rekapSuratTugasAdm.php?pagination=true&keyword=$keyword";
          
           $sql = "SELECT este.id
          , este.pertimbangan
          , este.dasar
          , este.perihal
          , este.no_dipa          
          , este.awal_berlaku
          , este.akhir_berlaku
          , este.tgl_ditetapkan
          , este.jenis_st
          , este.dekan
          , este.tahun
          , este.executor
          , este.editor
          FROM st este
          INNER JOIN opsi_jenis_st ojs
          ON ojs.id = este.jenis_st
          INNER JOIN personil_st pst
          ON pst.id_st = este.id
          INNER JOIN dt_pegawai dp
          ON dp.id = pst.nama
          LEFT JOIN dt_all_adm ab1
          ON ab1.username = este.executor
          LEFT JOIN dt_all_adm ab2
          ON ab2.username = este.editor
          WHERE (este.pertimbangan LIKE '%$keyword%' OR este.dasar LIKE '%$keyword%' OR este.perihal LIKE '%$keyword%' OR este.no_dipa LIKE '%$keyword%' OR este.awal_berlaku LIKE '%$keyword%' OR este.akhir_berlaku LIKE '%$keyword%' OR este.tgl_ditetapkan LIKE '%$keyword%' OR este.jenis_st LIKE '%$keyword%' OR este.dekan LIKE '%$keyword%' OR este.tahun LIKE '%$keyword%' OR este.executor LIKE '%$keyword%' OR este.editor LIKE '%$keyword%' OR ojs.nm LIKE '%$keyword%' OR pst.id_st LIKE '%$keyword%' OR pst.urutan LIKE '%$keyword%' OR pst.nama LIKE '%$keyword%' OR pst.jabatan_st LIKE '%$keyword%' OR pst.urutan_jabatan LIKE '%$keyword%' OR dp.nama LIKE '%$keyword%' OR ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND (este.tahun='$tahun') GROUP BY este.id ORDER BY este.tgl_ditetapkan DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapSuratTugasAdm.php?pagination=true";
          $sql = "SELECT * FROM st WHERE tahun='$tahun' ORDER BY tgl_ditetapkan DESC";
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
                <form method="post" action="rekapSuratTugasAdm.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="rekapSuratTugasAdm.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-8 mb-2">
                <div class="btn-group float-sm-right">
                  <button type="button" class="btn btn-outline-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-envelope-plus"></i> Input data</button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="inputStSpdAdm.php?page=<?php echo $page;?>" class="dropdown-item" type="button">ST SPD</a>
                    <a href="inputStPenunjukanAdm.php?page=<?php echo $page;?>" class="dropdown-item" type="button">ST Penunjukan</a>
                    <a href="inputStKepanitiaanAdm.php?page=<?php echo $page;?>" class="dropdown-item" type="button">ST Kepanitiaan</a>        
                  </div>
                </div>
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
                          <th width="48%">Perihal Tugas yang Diberikan</th>
                          <th width="10%">Jenis ST</th>
                          <th width="16%" class="text-center">Tgl. Berlaku</th>
                          <th width="10%" class="text-center">Tgl. Ditetapkan</th>
                          <th colspan="3" class="text-center pr-1">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qryJenisSt = "SELECT * FROM opsi_jenis_st WHERE id='$data[jenis_st]'";
                            $rJenisSt = mysqli_query($con, $qryJenisSt);
                            $dJenisSt = mysqli_fetch_assoc($rJenisSt);
                            
                            $qryTtd = "SELECT * FROM dt_pegawai WHERE id='$data[dekan]'";
                            $rTtd = mysqli_query($con, $qryTtd);
                            $dTtd = mysqli_fetch_assoc($rTtd);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left" title="<?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?>"><?php $allowedlimit = 58; if(mb_strlen($data['perihal'])>$allowedlimit) { echo mb_substr($$data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']),0,$allowedlimit)."...".'';} else {echo  $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);}?></td>
                            <td class="text-left"><?php echo $dJenisSt['nm'];?></td>
                            <td class="text-center"><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                            <?php 
                              if($data['jenis_st']==1) { echo '
                              <td width="4%" class="text-center pl-2"><a href="editStKepanitiaanAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-warning btn-xs" title="Edit ST Kepanitiaan"><i class="bi bi-pencil-square"></i></a></td>
                              <td width="4%" class="text-center"><a href="cetakSTKepanitiaanAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-secondary btn-xs" target="_blank" title="Cetak ST Kepanitiaan"><i class="bi bi-printer"></i></a></td>
                              <td width="4%" class="text-center pr-2"><a href="deleteStAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-danger btn-xs" onClick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus surat"><i class="bi bi-trash"></i></a></td>';}
                              else if($data['jenis_st']==2) { echo '
                              <td width="4%" class="text-center pl-2"><a href="editStSpdAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-warning btn-xs" title="Edit ST SPD"><i class="bi bi-pencil-square"></i></a></td>
                              <td width="4%" class="text-center"><a href="cetakSTSpdAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-secondary btn-xs" target="_blank" title="Cetak ST SPD"><i class="bi bi-printer"></i></a></td>
                              <td width="4%" class="text-center pr-2"><a href="deleteStAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-danger btn-xs" onClick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus surat"><i class="bi bi-trash"></i></a></td>';}
                              else if($data['jenis_st']==3) { echo '
                              <td width="4%" class="text-center pl-2"><a href="editStPenunjukanAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-warning btn-xs" title="Edit ST Penunjukan"><i class="bi bi-pencil-square"></i></a></td>
                              <td width="4%" class="text-center"><a href="cetakSTPenunjukanAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-secondary btn-xs" target="_blank" title="Cetak ST Penunjukan"><i class="bi bi-printer"></i></a></td>
                              <td width="4%" class="text-center pr-2"><a href="deleteStAdm.php?id='.$data['id'].'&page='.$page.'" role="button" class="btn-block btn btn-outline-danger btn-xs" onClick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus surat"><i class="bi bi-trash"></i></a></td>';}
                              ?>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Nomor Agenda Berkas Surat</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php if($data['no_agenda_surat']=='') {echo "-";} else {echo $data['no_agenda_surat'];}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Perihal Tugas yang Diberikan</th>
                                        <td>:</td>
                                        <td><?php echo $data['perihal']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Dasar Penerbitan Surat Tugas</th>
                                        <td>:</td>
                                        <td><?php echo $data['dasar']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['dasar']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tgl. Berlaku</th>
                                        <td>:</td>
                                        <td><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Ditetapkan</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Jenis Surat Tugas</th>
                                        <td>:</td>
                                        <td><?php echo $dJenisSt['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Nama-nama yang Diberi Tugas</th>
                                        <td>:</td>
                                        <td>
                                          <?php 
                                            $qPersonil="SELECT * FROM personil_st WHERE id_st='$data[id]' AND nama<>'' ORDER BY urutan_jabatan";
                                            $rPersonil=mysqli_query($con, $qPersonil) or die (mysqli_error($con));
                                            while($dPersonil=mysqli_fetch_assoc($rPersonil)) {
                                            
                                            $qNamaPersonil="SELECT * FROM dt_pegawai WHERE id='$dPersonil[nama]'";
                                            $rNamaPersonil=mysqli_query($con, $qNamaPersonil) or die (mysqli_error($con));
                                            $dNamaPersonil=mysqli_fetch_assoc($rNamaPersonil);
                                            
                                            if($dPersonil['nama'] == $dNamaPersonil['id']) { echo $dNamaPersonil['nama'];} else { echo $dPersonil['nama'];} echo "<br/>";
                                            }
                                            ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pejabat Penandatangan</th>
                                        <td>:</td>
                                        <td><?php echo $dTtd['nama'];?></td>
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