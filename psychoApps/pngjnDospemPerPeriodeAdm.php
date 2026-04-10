<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id_periode = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id_periode='$id_periode'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id_periode'";
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
            <?php 
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item active small">Verifikasi Pengajuan</li>
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
                      <h4 class="card-title float-left">Verifikasi Pengajuan</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="29%">Nama</td>
                            <td width="26%">Pilihan Dospem Skripsi I</td>
                            <td width="26%">Pilihan Dospem Skripsi II</td>
                            <td class="pr-1" colspan="3">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id_periode ='$id_periode' ORDER BY nim ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            $id = $data['id'];
                            include( "phpverdos.php" );
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dmhssw['nama']. '/' .$dmhssw['nim'];?> </td>
                            <td class="text-left"> <?php if($data['cek1']==1) { echo '<div class="clearfix"><div class="float-left">'.$ddospem1['nama'].'</div><div class="float-right"><i class="fas fa-user-edit text-warning" title="'.$dcek1['nm'].'"></i></div></div>';} else if($data['cek1']==2) { echo '<div class="clearfix"><div class="float-left">'.$ddospem1['nama'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek1['nm'].'"></i></div></div>';} else if($data['cek1']==3) { echo '<div class="clearfix"><div class="float-left">'.$ddospem1['nama'].'</div><div class="float-right"><i class="fas fa-user-check text-danger" title="'.$dcek1['nm'].'"></i></div></div>';} else if($data['cek1']==4) { echo '<div class="clearfix"><div class="float-left">'.$ddospem1['nama'].'</div><div class="float-right"><i class="fas fa-user-times text-dark" title="'.$dcek1['nm'].'"></i></div></div>';}?> </td>
                            <td class="text-left"> <?php if($data['cek2']==1) { echo '<div class="clearfix"><div class="float-left">'.$ddospem2['nama'].'</div><div class="float-right"><i class="fas fa-user-edit text-warning" title="'.$dcek2['nm'].'"></i></div></div>';} else if($data['cek2']==2) { echo '<div class="clearfix"><div class="float-left">'.$ddospem2['nama'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek2['nm'].'"></i></div></div>';} else if($data['cek2']==3) { echo '<div class="clearfix"><div class="float-left">'.$ddospem2['nama'].'</div><div class="float-right"><i class="fas fa-user-check text-danger" title="'.$dcek2['nm'].'"></i></div></div>';} else if($data['cek2']==4) { echo '<div class="clearfix"><div class="float-left">'.$ddospem2['nama'].'</div><div class="float-right"><i class="fas fa-user-times text-dark" title="'.$dcek2['nm'].'"></i></div></div>';}?> </td>
                            <td width="5%" class="pl-1"> <button class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Detail pengajuan" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $data['id'];?>"><i class="fas fa-expand"></i></button> </td>
                            <td width="5%"> <?php if($data['status'] == 3) { echo "<button class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa diverifikasi! Pembimbingan telah selesai\")' title='Tidak bisa diverifikasi! Pembimbingan telah selesai'><i class='fas fa-user-edit'></i></button>";} else { echo "<a class='btn btn-outline-warning btn-flat btn-xs btn-block' title='Verifikasi pengajuan' href='verifikasiPengDospemAdm.php?id=".$data['id']."&page=".$page."'><i class='fas fa-user-edit'></i></a>";}?> </td>
                            <td width="5%" class="pr-1"> <?php if(($data['status'] == 2) || ($data['status'] == 3)) { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Pembimbingan sedang berjalan atau telah selesai\")' title='Tidak bisa dihapus! Pembimbingan sedang berjalan atau telah selesai' disabled><i class='far fa-trash-alt'></i>
                              </a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deletePengDospemAdm.php?id=".$id."&page=".$page."&id_periode=".$id_periode."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                              src="<?php echo $dmhssw['photo'];?>" onError="this.onerror=null;this.src='<?php if($dmhssw['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">
                                          </div>
                                          <h3 class="profile-username text-center"><?php echo $dmhssw['nama'];?></h3>
                                          <p class="text-muted text-center"><?php echo $dmhssw['nim'];?></p>
                                          <ul class="list-group list-group-unbordered mb-3 text-left">
                                            <li class="list-group-item">
                                              <b>Kontak</b> <a class="float-right"><?php echo $dmhssw['kntk'];?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Email</b> <a class="float-right"><?php echo $dmhssw['imel'];?></a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-7">
                                      <?php include( "profilPembimbingan.php" );?>
                                    </div>
                                  </div>
                                </div>
                              </section>
                            </td>
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
      <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h6 class="modal-title" id="modalDetailLabel">Detail Pengajuan</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="isiModalDetail"></div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-warning btn-flat btn-sm" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $( '#modalDetail' ).on( 'show.bs.modal', function ( event ) {
       var button = $( event.relatedTarget )
       var recipient = button.data( 'whatever' )
       var modal = $( this );
       var dataString = 'id=' + recipient;
       $.ajax( {
         type: "GET",
         url: "detailPerPengDospemAdm.php",
         data: dataString,
         cache: false,
         success: function ( data ) {
           console.log( data );
           modal.find( '.isiModalDetail' ).html( data );
         },
         error: function ( err ) {
           console.log( err );
         }
       } );
      } );
    </script>
  </body>
</html>