<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page1' ] );
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
                <h6 class="m-0">Rekap Belum Mendaftar Seminar Proposal Angkatan <?php echo "$angkatan";?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPndftrSemproAdm.php?page=<?php echo $page;?>">Rekap Pendaftar Seminar Proposal</a></li>
                  <li class="breadcrumb-item active small">Nama Mahasiswa</li>
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
                      <h4 class="card-title float-left">Nama Mahasiswa</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="58%">Nama</td>
                            <td width="26%">Dosen Wali</td>
                            <td width="12%" class="pr-1">No. HP</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qNim = "SELECT nim FROM dt_mhssw WHERE status='1' AND angkatan='$angkatan'";
                            $dNim = mysqli_query($con, $qNim)or die( mysqli_error($con));
                            $dtNim = mysqli_fetch_assoc($dNim);
                            
                            $sql = "SELECT * FROM dt_mhssw WHERE status='1' AND angkatan='$angkatan' AND nim NOT IN(SELECT nim FROM peserta_sempro WHERE angkatan='$angkatan') ORDER BY nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
                            $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$data[dosen_wali]'";
                            $res_p1 = mysqli_query($con, $qry_p1);
                            $dt_p1 = mysqli_fetch_assoc($res_p1);
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
                            <td class="text-left"> <?php echo $dt_p1['nama'];?> </td>
                            <td class="text-center pr-1"> <?php echo $data['kntk'];?> </td>
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