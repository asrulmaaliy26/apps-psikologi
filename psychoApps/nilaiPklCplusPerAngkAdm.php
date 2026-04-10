<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  $id_pkl = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page0 = mysqli_real_escape_string($con,  $_GET[ 'page0' ] );

  $qidpercap = "SELECT * FROM pendaftaran_pkl WHERE id='$id_pkl'";
  $ridpercap = mysqli_query($con, $qidpercap)or die( mysqli_error($con));
  $didpercap = mysqli_fetch_assoc($ridpercap);
                            
  $qry_thpcap = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didpercap[tahap]'";
  $hasilcap = mysqli_query($con, $qry_thpcap);
  $dthpcap = mysqli_fetch_assoc($hasilcap);
                            
  $qry_nm_tacap = "SELECT * FROM dt_ta WHERE id='$didpercap[ta]'";
  $hasilcap = mysqli_query($con, $qry_nm_tacap);
  $dntacap = mysqli_fetch_assoc($hasilcap);
                            
  $qry_nm_smtcap = "SELECT * FROM opsi_nama_semester WHERE id='$dntacap[semester]'";
  $hcap = mysqli_query($con, $qry_nm_smtcap);
  $dsemestercap = mysqli_fetch_assoc($hcap);

  $qry_grade_per_angk = "SELECT * FROM grade_pkl WHERE id_pkl='$id_pkl'";
  $res_grade_per_angk = mysqli_query($con, $qry_grade_per_angk);
  $dt_grade_per_angk = mysqli_fetch_assoc($res_grade_per_angk);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Nilai PKL</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapNilaiPklAdm.php?page=<?php echo $page0;?>">Rekap Nilai PKL</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="nilaiPklPerAngkAdm.php?angkatan=<?php echo $angkatan;?>&page0=<?php echo $page0;?>">Nilai PKL Angkatan <?php echo $angkatan;?></a></li>
                  <li class="breadcrumb-item active small">Nilai PKL C+ Angkatan <?php echo $angkatan;?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Nilai PKL C+ Angkatan <?php echo $angkatan;?></h4>
                      <span class="badge badge-info float-right"><?php echo 'Tahap '.$dthpcap['tahap'].' '.$dsemestercap['nama'].' '.$dntacap['ta'].'';?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td rowspan="2" width="4%" class="pl-1">No.</td>
                            <td rowspan="2" width="30%">Nama</td>
                            <td colspan="2" class="border-bottom-0">DPL dan Lokasi</td>
                            <td rowspan="2" width="6%" class="pr-1">Nilai</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="26%" class="pl-1">DPL</td>
                            <td width="34%" class="pr-1">Lokasi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE (peserta_pkl.nilai <= '$dt_grade_per_angk[cplust]' AND nilai >= '$dt_grade_per_angk[cplusb]') AND (peserta_pkl.angkatan='$angkatan') AND (id_pkl='$id_pkl') ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);

                            $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nim='$data[nim]'";
                            $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
                            $dfrek = mysqli_fetch_assoc( $hfrek );
                            
                            $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$data[id_pkl]'";
                            $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
                            $didper = mysqli_fetch_assoc($ridper);
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry_opsi_dpl = "SELECT * FROM dpl_pkl WHERE id_pkl='$data[id_pkl]' AND id='$data[id_dpl]'";
                            $res_opsi_dpl = mysqli_query($con, $qry_opsi_dpl);
                            $dt_opsi_dpl = mysqli_fetch_assoc($res_opsi_dpl);

                            $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dt_opsi_dpl[nip]'";
                            $res_dpl = mysqli_query($con, $qry_dpl);
                            $dt_dpl = mysqli_fetch_assoc($res_dpl);

                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$dt_grade_per_angk[id_pkl]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);                         
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php if($data['statusform']==1) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-edit text-warning" title="'.$dcek['nm'].'"></i></div></div>';} else if($data['statusform']==2) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek['nm'].'"></i></div></div>';}?> </td>
                            <td class="text-left"> <?php if(empty($data['dpl'])) { echo "Belum ada";} else { echo $dt_dpl['nama'];}?> </td>
                            <td class="text-left"> <?php if(empty($dt_opsi_dpl['lokasi'])) { echo "Belum ada";} else { echo $dt_opsi_dpl['lokasi'];}?> </td>
                            <td class="text-center pr-1"> <?php include ("nilaiPesPklAdm.php");?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6"> <?php include("detailPesPklAdm.php");?> </td>
                          </tr>
                          <?php
                            }
                            ?>                        
                        </tbody>
                      </table>
                    </div>
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