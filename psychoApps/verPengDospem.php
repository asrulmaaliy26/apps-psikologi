<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];?>
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
                <h4 class="mb-0">Persetujuan</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Pengajuan Dospem Tesis</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $tahun = date("Y");    
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          $keyword=$_REQUEST['keyword'];
          $reload = "verPengDospem.php?pagination=true&keyword=$keyword";
          
          $sql = "SELECT 
          mpdt.id AS idPersonal,
          mpdt.id_periode,
          mpdt.nim,
          mpdt.judul_tesis,
          mpdt.outline_tesis,
          mpdt.dospem_tesis1,
          mpdt.dospem_tesis2,
          mpdt.nip_dospem_tesis1,
          mpdt.nip_dospem_tesis2,
          mpdt.tgl_pengajuan,
          mpdt.thn_pengajuan,
          mpdt.cek1,
          mpdt.cek2,
          mpdt.cekjudul,
          mpdt.tgl_mulai,
          mpdt.thn_mulai,
          mpdt.catatan,
          mpdt.tgl_akhir,
          mpdt.thn_akhir,
          mpdt.verifikasi_admin,
          mpdt.status,
          mdmp.nim,
          mdmp.nama AS nmMhssw,
          dp1.id,
          dp1.nama AS nmDospem1,
          dp2.id,
          dp2.nama AS nmDospem2
          
          FROM mag_pengelompokan_dospem_tesis mpdt
          LEFT JOIN mag_dt_mhssw_pasca mdmp
          ON mpdt.nim=mdmp.nim
          LEFT JOIN dt_pegawai dp1
          ON mpdt.nip_dospem_tesis1=dp1.id
          LEFT JOIN dt_pegawai dp2
          ON mpdt.nip_dospem_tesis2=dp2.id
          
          WHERE mpdt.id LIKE '%$keyword%'
          OR mpdt.id_periode LIKE '%$keyword%'
          OR mpdt.nim LIKE '%$keyword%'
          OR mpdt.judul_tesis LIKE '%$keyword%'
          OR mpdt.outline_tesis LIKE '%$keyword%'
          OR mpdt.dospem_tesis1 LIKE '%$keyword%'
          OR mpdt.dospem_tesis2 LIKE '%$keyword%'
          OR mpdt.nip_dospem_tesis1 LIKE '%$keyword%'
          OR mpdt.nip_dospem_tesis2 LIKE '%$keyword%'
          OR mpdt.tgl_pengajuan LIKE '%$keyword%'
          OR mpdt.thn_pengajuan LIKE '%$keyword%'
          OR mpdt.cek1 LIKE '%$keyword%'
          OR mpdt.cek2 LIKE '%$keyword%'
          OR mpdt.cekjudul LIKE '%$keyword%'
          OR mpdt.tgl_mulai LIKE '%$keyword%'
          OR mpdt.thn_mulai LIKE '%$keyword%'
          OR mpdt.catatan LIKE '%$keyword%'
          OR mpdt.tgl_akhir LIKE '%$keyword%'
          OR mpdt.thn_akhir LIKE '%$keyword%'
          OR mpdt.verifikasi_admin LIKE '%$keyword%'
          OR mpdt.status LIKE '%$keyword%'
          OR mdmp.nim LIKE '%$keyword%'
          OR mdmp.nama LIKE '%$keyword%'
          OR dp1.id LIKE '%$keyword%'
          OR dp1.nama LIKE '%$keyword%'
          OR dp2.id LIKE '%$keyword%'
          OR dp2.nama LIKE '%$keyword%'
          ORDER BY mpdt.verifikasi_admin ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "verPengDospem.php?pagination=true";
          $sql = "SELECT 
          mpdt.id AS idPersonal,
          mpdt.id_periode,
          mpdt.nim,
          mpdt.judul_tesis,
          mpdt.outline_tesis,
          mpdt.dospem_tesis1,
          mpdt.dospem_tesis2,
          mpdt.nip_dospem_tesis1,
          mpdt.nip_dospem_tesis2,
          mpdt.tgl_pengajuan,
          mpdt.thn_pengajuan,
          mpdt.cek1,
          mpdt.cek2,
          mpdt.cekjudul,
          mpdt.tgl_mulai,
          mpdt.thn_mulai,
          mpdt.catatan,
          mpdt.tgl_akhir,
          mpdt.thn_akhir,
          mpdt.verifikasi_admin,
          mpdt.status,
          mdmp.nim,
          mdmp.nama AS nmMhssw,
          dp1.id,
          dp1.nama AS nmDospem1,
          dp2.id,
          dp2.nama AS nmDospem2
          
          FROM mag_pengelompokan_dospem_tesis mpdt
          LEFT JOIN mag_dt_mhssw_pasca mdmp
          ON mpdt.nim=mdmp.nim
          LEFT JOIN dt_pegawai dp1
          ON mpdt.nip_dospem_tesis1=dp1.id
          LEFT JOIN dt_pegawai dp2
          ON mpdt.nip_dospem_tesis2=dp2.id
          ORDER BY mpdt.verifikasi_admin ASC";
          
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
                <form method="post" action="verPengDospem.php">
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
                      <a class="btn btn-sm btn-warning" title="Kembali" href="verPengDospem.php"><i class="fas fa-sync"></i> Kembali</a>
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
                    <h4 class="card-title">Pengajuan Dospem Tesis</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm custom mb-0">
                        <thead>
                          <tr class="text-left bg-success">
                            <td scope="col" rowspan="2" width="4%" class="text-center pl-1">No.</td>
                            <td scope="col" rowspan="2" width="40%" class="text-center">Nama Mahasiswa</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center">Tgl. Pengajuan</td>
                            <td scope="col" colspan="3" class="text-center">Persetujuan</td>
                            <td scope="col" rowspan="2" width="10%" class="text-center pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-success">
                            <td width="12%" class="pl-1">Dospem Tesis I</td>
                            <td width="12%">Dospem Tesis II</td>
                            <td width="12%" class="pr-1">Judul</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $idPersonal=$data['idPersonal'];
                            
                            $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                            $res = mysqli_query($con, $qnm);
                            $dnm =mysqli_fetch_assoc($res);
                            
                            $qOpsiPersetujuan1 = "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem WHERE id='$data[cek1]'";
                            $rOpsiPersetujuan1 = mysqli_query($con, $qOpsiPersetujuan1);
                            $dOpsiPersetujuan1 = mysqli_fetch_assoc($rOpsiPersetujuan1);
                            
                            $qOpsiPersetujuan2 = "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem WHERE id='$data[cek2]'";
                            $rOpsiPersetujuan2 = mysqli_query($con, $qOpsiPersetujuan2);
                            $dOpsiPersetujuan2 = mysqli_fetch_assoc($rOpsiPersetujuan2);
                            
                            $qOpsiPersetujuanJudul = "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem WHERE id='$data[cekjudul]'";
                            $rOpsiPersetujuanJudul = mysqli_query($con, $qOpsiPersetujuanJudul);
                            $dOpsiPersetujuanJudul = mysqli_fetch_assoc($rOpsiPersetujuanJudul);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $data['nmMhssw'].' ['.$data['nim'].']';?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-center" data-toggle="tooltip" data-placement="top" title="<?php echo $data['nmDospem1'];?>"><?php echo $dOpsiPersetujuan1['nm'];?></td>
                            <td class="text-center" data-toggle="tooltip" data-placement="top" title="<?php echo $data['nmDospem2'];?>"><?php echo $dOpsiPersetujuan2['nm'];?></td>
                            <td class="text-center" data-toggle="tooltip" data-placement="top" title="Judul tidak dimuat disini. Silahkan pilih menu Opsi atau tekan pada kolom ini untuk lebih detailnya..."><?php echo $dOpsiPersetujuanJudul['nm'];?></td>
                            <td class="text-center pr-1"> <?php if($data['verifikasi_admin']=='2') { echo '<a class="btn btn-outline-secondary btn-xs btn-block" onclick="return confirm(\'Tidak bisa diedit. Persetujuan telah diverifikasi oleh admin.\')" title="Tidak bisa diedit. Persetujuan telah diverifikasi oleh admin." disabled>Telah diverifikasi</a>';} else { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Edit Persetujuan" href="verPengDospemPerId.php?id='.$data['idPersonal'].'&page='.$page.'">Edit Persetujuan</a>';}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7">
                              <div class="card bg-gradient-light rounded-0 shadow">
                                <div class="card-body p-0">
                                  <table class="table no-border rounded-0 mb-0">
                                    <tbody>
                                      <tr>
                                        <th width="20%" class="pl-1">Nama Mahasiswa</th>
                                        <td width="4%">:</td>
                                        <td width="76%"><?php echo $data['nmMhssw'].' ['.$data['nim'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Tanggal Pengajuan</th>
                                        <td>:</td>
                                        <td><?php echo $data['tgl_pengajuan'];?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Dospem Tesis I yang Diajukan</th>
                                        <td>:</td>
                                        <td><?php echo $data['nmDospem1'].' ['.$dOpsiPersetujuan1['nm'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Dospem Tesis II yang Diajukan</th>
                                        <td>:</td>
                                        <td><?php echo $data['nmDospem2'].' ['.$dOpsiPersetujuan2['nm'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th style="vertical-align:top;" class="pl-1">Judul Tesis yang Diajukan</th>
                                        <td style="vertical-align:top;">:</td>
                                        <td style="vertical-align:top;"><?php echo $data['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_tesis']).' ['.$dOpsiPersetujuanJudul['nm'].']';?></td>
                                      </tr>
                                      <tr>
                                        <th class="pl-1">Catatan Pengajuan</th>
                                        <td>:</td>
                                        <td><?php echo $data['catatan'];?></td>
                                      </tr>
                                      <?php
                                      if($data['verifikasi_admin']=='1' && $data['status']=='1') {echo
                                        '<tr>
                                           <th class="pl-1">Status Pembimbingan</th>
                                           <td>:</td>
                                           <td>Pengajuan</td>
                                         </tr>';}
                                      elseif($data['verifikasi_admin']=='2' && $data['status']=='1') {echo
                                        '<tr>
                                           <th class="pl-1">Status Pembimbingan</th>
                                           <td>:</td>
                                           <td>Proses [Tanggal mulai: '.$data['tgl_mulai'].']</td>
                                         </tr>';}
                                      elseif($data['verifikasi_admin']=='2' && $data['status']=='2') {echo
                                        '<tr>
                                           <th class="pl-1">Status Pembimbingan</th>
                                           <td>:</td>
                                           <td>Selesai [Tanggal mulai: '.$data['tgl_mulai'].'. Tanggal selesai: '.$data['tgl_akhir'].']</td>
                                         </tr>';}
                                      ?>                                      
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