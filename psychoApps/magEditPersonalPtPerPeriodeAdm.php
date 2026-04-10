<?php 
  include( "contentsConAdm.php" );
  $idPersonal = mysqli_real_escape_string($con, $_GET[ 'idPersonal' ] );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );
  
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
  
  $qdw = "SELECT * FROM mag_dospem_tesis WHERE id='$idPersonal'";
  $rdw = mysqli_query($con, $qdw)or die( mysqli_error($con));
  $ddw = mysqli_fetch_assoc($rdw);
  
  $qdp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
  $rdp = mysqli_query($con, $qdp)or die( mysqli_error($con));
  $ddp = mysqli_fetch_assoc($rdp);
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
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalPtAdm.php?page=<?php echo $page;?>">Personal Dospem Tesis</a></li>
                  <li class="breadcrumb-item"><a href="magPersonalPtPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></a></li>
                  <li class="breadcrumb-item active">Edit</li>
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
                  <form action="magUpdatePersonalPtPerPeriodeAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Edit</h3>
                        <span><?php echo $ddp['nama_tg'];?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <input type="text" name="idPersonal" class="sr-only" value="<?php echo $idPersonal;?>" required readonly>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="page1" class="sr-only" value="<?php echo $page1;?>" required readonly>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="nip">Dospem Tesis <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm"  value="<?php echo $ddp['nama_tg'];?>" disabled required/>
                        </div>
                        <div class="form-group col-3">
                          <label for="kuota1">Kuota Dospem I <span class="text-danger">*</span></label>
                          <input type="number" min="0" max="20" name="kuota1" class="form-control form-control-sm" value="<?php echo $ddw['kuota1'];?>" required/>
                        </div>
                        <div class="form-group col-3">
                          <label for="kuota2">Kuota Dospem II <span class="text-danger">*</span></label>
                          <input type="number" min="0" max="20" name="kuota2" class="form-control form-control-sm" value="<?php echo $ddw['kuota2'];?>" required/>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-outline-success btn-sm float-left">Update</button>
                      <a href="magPersonalPtPerPeriodeAdm.php?id=<?php echo "$id";?>&page=<?php echo "$page";?>&page1=<?php echo "$page1";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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