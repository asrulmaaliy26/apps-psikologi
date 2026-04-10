<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $qry_periode = "SELECT * FROM mag_periode_pengajuan_dospem WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$data[tahap]'";
  $hsl = mysqli_query($con, $qry_nm_thp);
  $dtahap = mysqli_fetch_assoc($hsl);

  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magVerPptAdm.php?page=<?php echo $page;?>">Verifikasi Pengajuan</a></li>
                  <li class="breadcrumb-item active"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination1.php';
           $reload1 = "magVerPengajuPtPerPeriodeAdm.php?id=$id&page=$page";
           $sql1 = "SELECT 
           mag_pengelompokan_dospem_tesis.id AS idPersonal,
           mag_pengelompokan_dospem_tesis.id_periode,
           mag_pengelompokan_dospem_tesis.nim,
           mag_pengelompokan_dospem_tesis.judul_tesis,
           mag_pengelompokan_dospem_tesis.outline_tesis,
           mag_pengelompokan_dospem_tesis.dospem_tesis1,
           mag_pengelompokan_dospem_tesis.dospem_tesis2,
           mag_pengelompokan_dospem_tesis.nip_dospem_tesis1,
           mag_pengelompokan_dospem_tesis.nip_dospem_tesis2,
           mag_pengelompokan_dospem_tesis.tgl_pengajuan,
           mag_pengelompokan_dospem_tesis.thn_pengajuan,
           mag_pengelompokan_dospem_tesis.cek1,
           mag_pengelompokan_dospem_tesis.cek2,
           mag_pengelompokan_dospem_tesis.cekjudul,
           mag_pengelompokan_dospem_tesis.tgl_mulai,
           mag_pengelompokan_dospem_tesis.thn_mulai,
           mag_pengelompokan_dospem_tesis.catatan,
           mag_pengelompokan_dospem_tesis.tgl_akhir,
           mag_pengelompokan_dospem_tesis.thn_akhir,
           mag_pengelompokan_dospem_tesis.verifikasi_admin,
           mag_pengelompokan_dospem_tesis.status,
           mag_dt_mhssw_pasca.nim,
           mag_dt_mhssw_pasca.nama,
           dp1.id,
           dp1.nama AS nmDospem1,
           dp2.id,
           dp2.nama AS nmDospem2

           FROM mag_pengelompokan_dospem_tesis
           LEFT JOIN mag_dt_mhssw_pasca
           ON mag_pengelompokan_dospem_tesis.nim=mag_dt_mhssw_pasca.nim
           LEFT JOIN dt_pegawai dp1
           ON mag_pengelompokan_dospem_tesis.nip_dospem_tesis1=dp1.id
           LEFT JOIN dt_pegawai dp2
           ON mag_pengelompokan_dospem_tesis.nip_dospem_tesis2=dp2.id

            WHERE mag_pengelompokan_dospem_tesis.id_periode='$id' ORDER BY mag_dt_mhssw_pasca.nama ASC";
           $result1 = mysqli_query($con, $sql1);
           
           $rpp1 = 10;
           $page1 = isset($_GET["page1"]) ? (intval($_GET["page1"])) : 1;
           $tcount1 = mysqli_num_rows($result1);
           $tpages1 = ($tcount1) ? ceil($tcount1/$rpp1) : 1;
           $count1 = 0;
           $i1 = ($page1-1)*$rpp1;
           $no_urut = ($page1-1)*$rpp1;
          ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th rowspan="2" width="4%" class="pl-1">No.</th>
                            <th rowspan="2" width="38%">Nama [NIM]</th>
                            <th rowspan="2" width="10%">Tgl. Pengajuan</th>
                            <th colspan="3">Persetujuan Kaprodi</th>
                            <th rowspan="2" width="12%" class="pr-1">Verifikasi</th>
                          </tr>
                          <tr>
                            <th width="12%" class="pl-1">Dospem Tesis I</th>
                            <th width="12%">Dospem Tesis II</th>
                            <th width="12%" class="pr-1">Judul</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count1<$rpp1) && ($i1<$tcount1)) {
                            mysqli_data_seek($result1, $i1);
                            $data = mysqli_fetch_array($result1);
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
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dnm['nama'].' ['.$dnm['nim'].']';?></td>
                            <td><?php echo $data['tgl_pengajuan'];?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $data['nmDospem1'];?>"><?php echo $dOpsiPersetujuan1['nm'];?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $data['nmDospem2'];?>"><?php echo $dOpsiPersetujuan2['nm'];?></td>
                            <td data-toggle="tooltip" data-placement="top" title="Judul tidak dimuat disini. Silahkan tekan pada kolom ini untuk lebih detailnya..."><?php echo $dOpsiPersetujuanJudul['nm'];?></td>
                            <td class="pr-1"><?php if($data['cek1']==2 && $data['cek2']==2 && $data['cekjudul']==2 && $data['status']==1) { include 'magOpsiVerPengajuPtPerPeriodeAdm.php';} else { include 'magOpsiVerPengajuPtPerPeriodeDisabledAdm.php';}?></td>
                          </tr>
                          <?php
                            $i1++; 
                            $count1++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one1($reload1, $page1, $tpages1); ?></div>
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