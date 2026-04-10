<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_pkl = mysqli_real_escape_string($con,  $_GET[ 'id_pkl' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM dpl_pkl WHERE id='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  $dpl = $dper['nip'];
  
  $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dper[nip]'";
  $res_dpl = mysqli_query($con, $qry_dpl);
  $dt_dpl = mysqli_fetch_assoc($res_dpl);

  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id_pkl'";
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
              <h6 class="m-0">Pendaftaran PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item small"><a class="text-info" href="pndftrnPklAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                <li class="breadcrumb-item small"><a class="text-info" href="pengelompokanPesPerDplPerPeriodeAdm.php?id=<?php echo $id_pkl;?>&page=<?php echo $page;?>">Pendistribusian DPL</a></li>
                <li class="breadcrumb-item active small">Peserta Per DPL</li>
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
                    <h4 class="card-title float-left">Peserta Per DPL</h4>
                    <span class="badge badge-info float-right"><?php echo $dt_dpl['nama'];?></span>
                  </div>
                </div>
                <div class="card-body pt-2 pb-2 pl-0 pr-0">
                  <form name="update" method="post" action="deleteDplPesertaPklAdm.php" onSubmit="return confirm('Hapus data terpilih?')">
                  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                  <input type="text" name="id_pkl" class="sr-only" value="<?php echo $id_pkl;?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="form-group">
                    <button name="submit" type="submit" class="btn btn-outline-danger btn-flat btn-xs float-right mr-3" id="submit1"> <i class="fas fa-user-plus"></i> Hapus Data Terpilih </button>
                    <div class="table-responsive pt-2 pb-2">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="86%">Nama</td>
                            <td width="10%" class="pr-1"><input type="checkbox" id="checkAll"> Pilih Semua</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.dpl='$dpl' AND peserta_pkl.id_dpl='$id' AND peserta_pkl.id_pkl='$id_pkl' AND peserta_pkl.val_adm='2' AND peserta_pkl.statusform='2' ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $no++;
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $data['nama'].' / '.$data['nim'];?> </td>
                            <td class="text-center pr-1"> <?php echo '<input class="chk" type="checkbox" name="item[]" id="myCheckbox" value="'.$data['id'].'" />';?> </td>
                          </tr>
                            <?php
                              }
                              ?>
                        </tbody>
                      </table>
                    </div>
                    <button name="submit" type="submit" class="btn btn-outline-danger btn-flat btn-xs float-right mr-3" id="submit2"> <i class="fas fa-user-plus"></i> Hapus Data Terpilih </button>
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
    <script type="text/javascript">
      $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
      });
      $('#submit1,#submit2').prop("disabled", true);
      $('input:checkbox').click(function() {
      if ($(this).is(':checked')) {
      $('#submit1,#submit2').prop("disabled", false);
      } else {
      if ($('.chk').filter(':checked').length < 1){
      $('#submit1,#submit2').attr('disabled',true);}
      }
      });
    </script>
  </body>
</html>