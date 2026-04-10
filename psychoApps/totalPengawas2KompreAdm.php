<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );

  $qdt_pengawas = "SELECT * FROM dt_pengawas_kompre WHERE id='$id'";
  $hdt_pengawas = mysqli_query($con, $qdt_pengawas);
  $dpengawas = mysqli_fetch_assoc($hdt_pengawas);
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
                <h6 class="m-0">Rekap Pengawas Kompre</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPengawasKompreAdm.php">Rekap Pengawas Kompre</a></li>
                  <li class="breadcrumb-item active small">Pengawas II</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "totalPengawas2KompreAdm.php?pagination=true&id=$id";
           $sql = "SELECT * FROM jadwal_kompre WHERE pengawas2='$id'";
           $result = mysqli_query($con, $sql);
           
           $rpp = 30;
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
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Pengawas II</h4>
                      <span class="badge badge-info float-right"> <?php echo $dpengawas['nm'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="36%">Periode Pendaftaran</td>
                            <td width="44%">Jadwal Ujian</td>
                            <td width="16%" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $sesuaikanTgl = date("d-m-Y", strtotime($data['tgl_kompre']));

                            $formatTgl=date("d-m-Y", strtotime($data['tgl_kompre']));
                            $day = date('D', strtotime($formatTgl));
                            $dayList = array(
                              'Sun' => 'Minggu',
                              'Mon' => 'Senin',
                              'Tue' => 'Selasa',
                              'Wed' => 'Rabu',
                              'Thu' => 'Kamis',
                              'Fri' => "Jum'at",
                              'Sat' => 'Sabtu'
                              );
                            
                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$data[ruang]'";
                            $rruang = mysqli_query($con, $qry_ruang);
                            $druang = mysqli_fetch_assoc($rruang);

                            $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$data[id_kompre]'";
                            $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
                            $didper = mysqli_fetch_assoc($ridper);

                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
                            $hasil = mysqli_query($con, $qry_jenis_periode);
                            $djp = mysqli_fetch_assoc($hasil);

                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);

                            $qryJumPeserta = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE id_jdwl='$data[id]'";
                            $hJumPeserta = mysqli_query($con,  $qryJumPeserta )or DIE( mysqli_error($con) );
                            $dJumPeserta = mysqli_fetch_assoc( $hJumPeserta );
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-left"> <?php echo $dayList[$day].', '.$sesuaikanTgl.', Pukul: '.$data['jam_mulai'].' s.d '.$data['jam_selesai'].', Tempat: '.$druang['nm'];?> </td>
                            <td class="pr-1"> <button class="btn btn-outline-danger btn-flat btn-xs btn-block" title="Peserta ujian" data-toggle="modal" data-target="#modalPeserta" data-whatever="<?php echo $data['id'];?>"><i class="fas fa-users"></i> Lihat Peserta (<?php echo $dJumPeserta['jumData'];?>)</button> </td>
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
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
      <div class="modal fade" id="modalPeserta" tabindex="-1" aria-labelledby="modalPesertaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
          <div class="modal-content bg-success">
            <div class="modal-header">
              <h6 class="modal-title" id="modalPesertaLabel">Peserta Ujian</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="isiModalPeserta"></div>
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
      $( '#modalPeserta' ).on( 'show.bs.modal', function ( event ) {
       var button = $( event.relatedTarget )
       var recipient = button.data( 'whatever' )
       var modal = $( this );
       var dataString = 'id=' + recipient;
       $.ajax( {
         type: "GET",
         url: "pesertaKomprePerPengawasAdm.php",
         data: dataString,
         cache: false,
         success: function ( data ) {
           console.log( data );
           modal.find( '.isiModalPeserta' ).html( data );
         },
         error: function ( err ) {
           console.log( err );
         }
       } );
      } );
    </script>
  </body>
</html>