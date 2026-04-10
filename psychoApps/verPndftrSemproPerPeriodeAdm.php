<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM peserta_sempro WHERE id_sempro='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$id'";
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
  <style type="text/css">
    .form-control-xs {
    height: calc(1.2em + .377rem + 4px) !important;
    padding: .125rem .25rem !important;
    font-size: .75rem !important;
    line-height: 1.5;
    border-radius: .0rem;
    }
  </style>
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
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Edit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Verifikasi Pendaftar Seminar Proposal <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="verPndftrSemproAdm.php?page=<?php echo $page;?>">Verifikasi Pendaftar Seminar Proposal</a></li>
                  <li class="breadcrumb-item active small">Opsi Verifikasi Pendaftar</li>
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
                      <h4 class="card-title float-left">Opsi Verifikasi Pendaftar</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="40%" rowspan="2">Nama</td>
                            <td width="10%" rowspan="2">Tgl. Pendaftaran</td>
                            <td width="8%">File Proposal</td>
                            <td rowspan="2" colspan="2">Verifikasi</td>
                            <td class="pr-1" rowspan="2" colspan="3">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_sempro INNER JOIN dt_mhssw ON peserta_sempro.nim=dt_mhssw.nim WHERE peserta_sempro.id_sempro='$id' ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
                            $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_sempro WHERE nim='$data[nim]'";
                            $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
                            $dfrek = mysqli_fetch_assoc( $hfrek );
                            
                            $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$data[id_sempro]'";
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
                            
                            $qry_jdwl = "SELECT * FROM jadwal_sempro WHERE id_sempro='$data[id_sempro]' AND id='$data[id_jdwl]'";
                            $res_jdwl = mysqli_query($con, $qry_jdwl);
                            $dt_jdwl = mysqli_fetch_assoc($res_jdwl);
                            
                            $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji1]'";
                            $res_p1 = mysqli_query($con, $qry_p1);
                            $dt_p1 = mysqli_fetch_assoc($res_p1);
                            
                            $qry_p2 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji2]'";
                            $res_p2 = mysqli_query($con, $qry_p2);
                            $dt_p2 = mysqli_fetch_assoc($res_p2);
                            
                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$dt_jdwl[ruang]'";
                            $res_ruang = mysqli_query($con, $qry_ruang);
                            $dt_ruang = mysqli_fetch_assoc($res_ruang);
                            
                            $qry_nilai = "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$data[id]'";
                            $res_nilai = mysqli_query($con, $qry_nilai);
                            $dt_nilai = mysqli_fetch_assoc($res_nilai);
                            
                            $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$data[id_sempro]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
                            <td class="text-center"> <?php echo $data['tgl_pengajuan'];?> </td>
                            <td class="text-center"> <?php if(empty($data['file_prop'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada file!\')" title="Tidak ada file" disabled><i class="fas fa-download"></i></a>';} else { echo '<a class="btn btn-outline-info btn-flat btn-xs btn-block" title="Lihat/download" href="'.$data['file_prop'].'" target="_blank"><i class="fas fa-download"></i></a>';}?> </td>
                            <td width="16%" class="text-center">
                              <?php if($data['statusform']==2) { echo 
                                "<select name='val_adm' class='form-control form-control-xs' title='Tidak bisa diubah karena telah terjadwal' required disabled>";?>
                              <?php
                                $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi ORDER BY nm ASC" );
                                while ( $w = mysqli_fetch_array( $tampil ) ) {
                                  if ( $data['val_adm'] == $w[ 'id' ] ) {
                                    echo "<option value='$w[id]' selected>$w[nm]</option>";
                                  } else {
                                    echo "<option value='$w[id]'>$w[nm]</option>";
                                  }
                                } 
                                "</select>";}
                                else { include "opsiVerpesSemproPerPeriodeAdm.php";}?>
                            </td>
                            <td width="10%" class="text-center"><a href="catatanPesSemproPerPeriodeAdm.php?id=<?php echo $id;?>&id_pendaftar=<?php echo $data['id'];?>&nim=<?php echo $data['nim'];?>&page=<?php echo $page;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Beri catatan"><i class="far fa-comment-alt"></i> Beri Catatan</a></td>
                            <td width="4%" class="pl-1"> <button class="btn btn-outline-info btn-flat btn-xs btn-block" title="Detail pendaftaran" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $data['id'];?>"><i class="fas fa-expand"></i></button> </td>
                            <td class="text-center" width="4%"> <a href="editPesSemproPerPeriodeAdm.php?id=<?php echo $data['id'];?>&page=<?php echo $page;?>&id_sempro=<?php echo $id;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit pendaftaran"><i class="far fa-edit"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> <?php if($data['val_adm']==2 || $data['val_adm']==3) { echo "<a  class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus karena status validasi pendaftaran Diterima atau Diterima dengan Catatan\")' title='Tidak bisa dihapus karena status validasi pendaftaran Diterima atau Diterima dengan Catatan'><i class='far fa-trash-alt'></i></a>";} elseif(!empty($dt_jdwl['penguji1']) && !empty($dt_jdwl['penguji2'])) { echo "<a  class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus karena telah terjadwal\")' title='Tidak bisa dihapus karena telah terjadwal'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deletePesSemproAdm.php?id=".$id."&id_pendaftar=".$data['id']."&nim=".$data['nim']."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
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
              <h6 class="modal-title" id="modalDetailLabel">Detail Pendaftaran</h6>
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
         url: "detailPndftrSemproAdm.php",
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