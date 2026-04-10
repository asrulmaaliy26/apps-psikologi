<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page0 = mysqli_real_escape_string($con,  $_GET[ 'page0' ] );
  
  $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $res_dpl = mysqli_query($con, $qry_dpl);
  $dt_dpl = mysqli_fetch_assoc($res_dpl);?>
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
                <h6 class="m-0">Rekap DPL PKL</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapDplPklAdm.php?page=<?php echo $page0;?>">Rekap DPL PKL</a></li>
                  <li class="breadcrumb-item active small">Total Menjadi DPL PKL</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapDplPklAdm.php?pagination=true";
           $sql = "SELECT * FROM dpl_pkl WHERE nip='$id' ORDER BY id_pkl DESC";
           $result = mysqli_query($con, $sql);
           
           $rpp = 10;
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
                      <h4 class="card-title float-left">Total Menjadi DPL PKL</h4>
                      <span class="badge badge-info float-right"> <?php echo $dt_dpl['nama'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="20%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pendaftaran</td>
                            <td width="30%" rowspan="2">Lokasi</td>
                            <td width="10%" rowspan="2">Peserta PKL</td>
                            <td rowspan="2" colspan="2" class="pr-1">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td class="pl-1" width="14%">Mulai</td>
                            <td class="pr-1" width="14%">Akhir</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id_pkl = $data['id_pkl'];
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

                            $qryjumdpl = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$id' AND id_dpl='$data[id]'";
                            $resjumdpl = mysqli_query($con,  $qryjumdpl )or DIE( mysqli_error($con) );
                            $dtjumDpl = mysqli_fetch_array( $resjumdpl );
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $didper['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $didper['end_datetime'];?> </td>
                            <td class="text-left"> <?php echo $data['lokasi'];?> </td>                            
                            <td class="text-center"> <?php if($dtjumDpl['jumData']==0) { echo '<button class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$dtjumDpl['jumData'].'';} else { echo '<button class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat Peserta" data-toggle="modal" data-target="#modalPeserta" data-whatever="'.$data['id'].'">'.$dtjumDpl['jumData'].'</button>';}?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakDetailPerDplPklPerPeriodeAdm.php?id=<?php echo $data['id'];?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporDetailPerDplPklPerPeriodeAdm.php?id=<?php echo $data['id'];?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
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
              <h6 class="modal-title" id="modalPesertaLabel">Peserta PKL</h6>
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
       var dataString = 'id_dpl=' + recipient;
       $.ajax( {
         type: "GET",
         url: "pesertaPklPerDplAdm.php",
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