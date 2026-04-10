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
                  <li class="breadcrumb-item active small">Surat Perjalanan Dinas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "rekapSpdAdm.php?pagination=true&keyword=$keyword";
          
           $sql = "SELECT espede.id
          , espede.penerima
          , espede.pangkat
          , espede.jabatan_instansi_penerima
          , espede.maksud_spd
          , espede.tempat_berangkat
          , espede.tempat_tujuan
          , espede.tempat_tujuan2
          , espede.tempat_tujuan3
          , espede.tanggal_berangkat
          , espede.tanggal_kembali
          , espede.durasi_spd
          , espede.ppk
          , espede.jabatan_ppk
          , espede.dekan
          , espede.tgl_ditetapkan
          , espede.tahun
          , espede.executor
          , espede.editor
          FROM spd espede
          LEFT JOIN dt_pegawai dp
          ON dp.id = espede.penerima
          LEFT JOIN dt_kota dk
          ON dk.id = espede.tempat_berangkat
          LEFT JOIN dt_kota dk1
          ON dk1.id = espede.tempat_tujuan
          LEFT JOIN dt_kota dk2
          ON dk2.id = espede.tempat_tujuan2
          LEFT JOIN dt_kota dk3
          ON dk3.id = espede.tempat_tujuan3          
          LEFT JOIN dt_all_adm ab1
          on espede.executor = ab1.username
          LEFT JOIN dt_all_adm ab2
          on espede.editor = ab2.username
          
          WHERE (espede.penerima LIKE '%$keyword%' OR espede.pangkat LIKE '%$keyword%' OR espede.jabatan_instansi_penerima LIKE '%$keyword%' OR espede.maksud_spd LIKE '%$keyword%' OR espede.tempat_berangkat LIKE '%$keyword%' OR espede.tempat_tujuan LIKE '%$keyword%' OR espede.tempat_tujuan2 LIKE '%$keyword%' OR espede.tempat_tujuan3 LIKE '%$keyword%' OR espede.tanggal_berangkat LIKE '%$keyword%' OR espede.tanggal_kembali LIKE '%$keyword%' OR espede.durasi_spd LIKE '%$keyword%' OR espede.ppk LIKE '%$keyword%' OR espede.jabatan_ppk LIKE '%$keyword%' OR espede.dekan LIKE '%$keyword%' OR espede.tgl_ditetapkan LIKE '%$keyword%' OR espede.tahun LIKE '%$keyword%' OR espede.executor LIKE '%$keyword%' OR espede.editor LIKE '%$keyword%' OR dp.nama LIKE '%$keyword%' OR dk.nm_kota LIKE '%$keyword%' OR dk1.nm_kota LIKE '%$keyword%' OR dk2.nm_kota LIKE '%$keyword%' OR dk3.nm_kota LIKE '%$keyword%') OR (ab1.nm_person LIKE '%$keyword%' OR ab2.nm_person LIKE '%$keyword%') AND (espede.tahun='$tahun') GROUP BY espede.id ORDER BY espede.tgl_ditetapkan DESC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "rekapSpdAdm.php?pagination=true";
          $sql = "SELECT * FROM spd WHERE tahun='$tahun' ORDER BY tgl_ditetapkan DESC";
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
                <form method="post" action="rekapSpdAdm.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="rekapSpdAdm.php"><i class="fas fa-sync"></i> Kembali</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-8 mb-2">
                <a href="inputSpdAdm.php?page=<?php echo $page;?>" class="btn btn-outline-danger btn-sm float-sm-right"><i class="bi bi-envelope-plus"></i> Input data</a>
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
                          <th width="24%">Penerima SPD</th>
                          <th width="30%">Maksud SPD</th>
                          <th width="10%" class="text-center">Tgl. Berangkat</th>
                          <th width="10%" class="text-center">Tgl. Kembali</th>
                          <th width="10%" class="text-center">Tgl. Ditetapkan</th>
                          <th colspan="3" class="text-center pr-1">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qryPenerima = "SELECT * FROM dt_pegawai WHERE id='$data[penerima]'";
                            $rPenerima = mysqli_query($con, $qryPenerima);
                            $dPenerima = mysqli_fetch_assoc($rPenerima);
                            
                            $qryPangkatPenerima = "SELECT * FROM opsi_jabatan_instansi WHERE id='$dPenerima[jabatan_instansi]'";
                            $rPangkatPenerima = mysqli_query($con, $qryPangkatPenerima);
                            $dPangkatPenerima = mysqli_fetch_assoc($rPangkatPenerima);
                            
                            $qryKotaBerangkat = "SELECT * FROM dt_kota WHERE id='$data[tempat_berangkat]'";
                            $rKotaBerangkat = mysqli_query($con, $qryKotaBerangkat);
                            $dKotaBerangkat = mysqli_fetch_assoc($rKotaBerangkat);
                            
                            $qTtujuan="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan]'";
                            $resTtujuan=mysqli_query($con, $qTtujuan) or die (mysqli_error($con));
                            $dTtujuan=mysqli_fetch_assoc($resTtujuan);
                            
                            $qTtujuan2="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan2]'";
                            $resTtujuan2=mysqli_query($con, $qTtujuan2) or die (mysqli_error($con));
                            $dTtujuan2=mysqli_fetch_assoc($resTtujuan2);
                            
                            $qTtujuan3="SELECT * FROM dt_kota WHERE id='$data[tempat_tujuan3]'";
                            $resTtujuan3=mysqli_query($con, $qTtujuan3) or die (mysqli_error($con));
                            $dTtujuan3=mysqli_fetch_assoc($resTtujuan3);
                            
                            $qnmppk="SELECT * FROM dt_pegawai WHERE id='$data[ppk]'";
                            $resnmppk=mysqli_query($con, $qnmppk) or die (mysqli_error($con));
                            $dnmppk=mysqli_fetch_assoc($resnmppk);
                            
                            $qjabataninstppk="SELECT * FROM opsi_jabatan_instansi WHERE id='$data[jabatan_ppk]'";
                            $resjabataninstppk=mysqli_query($con, $qjabataninstppk) or die (mysqli_error($con));
                            $djabataninstppk=mysqli_fetch_assoc($resjabataninstppk);
                            
                            $qryEksekutor = "SELECT * FROM dt_all_adm WHERE username='$data[executor]'";
                            $rEksekutor = mysqli_query($con, $qryEksekutor);
                            $dEksekutor = mysqli_fetch_assoc($rEksekutor);
                            
                            $qryEditor = "SELECT * FROM dt_all_adm WHERE username='$data[editor]'";
                            $rEditor = mysqli_query($con, $qryEditor);
                            $dEditor = mysqli_fetch_assoc($rEditor);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dPenerima['nama'];?></td>
                            <td class="text-left" title="<?php echo $data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']);?>"><?php $allowedlimit = 58; if(mb_strlen($data['maksud_spd'])>$allowedlimit) { echo mb_substr($$data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']),0,$allowedlimit)."...".'';} else {echo  $data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']);}?></td>
                            </td>
                            <td class="text-center"><?php echo $data['tanggal_berangkat'];?></td>
                            <td class="text-center"><?php echo $data['tanggal_kembali'];?></td>
                            <td class="text-center"><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                            <td width="4%" class="text-center pl-2"><a href="editSpdAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn-block btn btn-outline-warning btn-xs" title="Edit SPD"><i class="bi bi-pencil-square"></i></a></td>
                            <td width="4%" class="text-center"><a href="cetakSpdAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn-block btn btn-outline-secondary btn-xs" target="_blank" title="Cetak SPD"><i class="bi bi-printer"></i></a></td>
                            <td width="4%" class="text-center pr-2"><a href="deleteSpdAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>" role="button" class="btn-block btn btn-outline-danger btn-xs" onClick="return confirm('Yakin data ini dihapus?')" title="Hapus surat"><i class="bi bi-trash"></i></a></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="9">
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
                                        <th class="pl-1">Penerima</th>
                                        <td>:</td>
                                        <td><?php echo $dPenerima['nama'].' / '.$dPangkatPenerima['nm_panjang'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Maksud SPD</th>
                                        <td>:</td>
                                        <td><?php echo $data['maksud_spd']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['maksud_spd']);?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tempat Berangkat</th>
                                        <td>:</td>
                                        <td><?php echo $dKotaBerangkat['nm_kota'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tempat Tujuan</th>
                                        <td>:</td>
                                        <td><?php if(empty($data['tempat_tujuan2']) && empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]";} else if(!empty($data['tempat_tujuan2']) && empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]".", ". "$dTtujuan2[nm_kota]";} else if(!empty($data['tempat_tujuan2']) && !empty($data['tempat_tujuan3'])) { echo "$dTtujuan[nm_kota]".", "."$dTtujuan2[nm_kota]".", ". "$dTtujuan3[nm_kota]";}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Berangkat</th>
                                        <td>:</td>
                                        <td><?php echo $data['tanggal_berangkat'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Kembali</th>
                                        <td>:</td>
                                        <td><?php echo $data['tanggal_kembali'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Lama Perjalanan Dinas</th>
                                        <td>:</td>
                                        <td><?php echo $data['durasi_spd'];?> hari</td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Ditetapkan</th>
                                        <td>:</td>
                                        <td><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Pejabat Penandatangan</th>
                                        <td>:</td>
                                        <td><?php echo $dnmppk['nama'].' / '.$djabataninstppk['nm'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Eksekutor</th>
                                        <td>:</td>
                                        <td><?php if($data['executor']=='') { echo '-';} else { echo $dEksekutor['nm_person'];}?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Editor</th>
                                        <td>:</td>
                                        <td><?php if($data['editor']=='') { echo '-';} else { echo $dEditor['nm_person'];}?></td>
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