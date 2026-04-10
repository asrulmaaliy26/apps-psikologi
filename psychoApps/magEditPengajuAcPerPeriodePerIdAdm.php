<?php 
  include( "contentsConAdm.php" );
  $idPersonal = mysqli_real_escape_string($con, $_GET[ 'idPersonal' ] );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );

  $qry_periode = "SELECT * FROM mag_periode_pengajuan_ac WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qPac = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE id='$idPersonal'";
  $rPac = mysqli_query($con, $qPac)or die( mysqli_error($con));
  $dPac = mysqli_fetch_assoc($rPac);
  
  $qdm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$dPac[nim]'";
  $rdm = mysqli_query($con, $qdm)or die( mysqli_error($con));
  $ddm = mysqli_fetch_assoc($rdm);
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
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magEditPacAdm.php?page=<?php echo $page;?>">Edit Pengajuan</a></li>
                  <li class="breadcrumb-item"><a href="magEditPengajuAcPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></a></li>
                  <li class="breadcrumb-item active">Per Mahasiswa</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <form action="magUpdatePengajuAcPerPeriodePerIdAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Per Mahasiswa</h3>
                        <span><?php echo $ddm['nama'].' ['.$ddm['nim'].']';?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="idPersonal" class="sr-only" value="<?php echo $idPersonal;?>" required readonly>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="page1" class="sr-only" value="<?php echo $page1;?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <div class="form-group">
                        <label for="nip">Academic Coach <span class="text-danger">*</span></label>
                        <?php
                          echo "<select name='dosen_wali' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con, "SELECT * FROM mag_dosen_wali" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
                            $r = mysqli_query($con, $mqry)or die( mysqli_error($con));
                            $d = mysqli_fetch_array($r);
                            if ( $dPac['dosen_wali'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$d[nama_tg]</option>";
                            } else {
                              echo "<option value='$w[id]'>$d[nama_tg]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-outline-success btn-sm float-left">Update</button>
                      <a href="magEditPengajuAcPerPeriodeAdm.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>&page1=<?php echo "$page1";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
                    </div>
                  </form>
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