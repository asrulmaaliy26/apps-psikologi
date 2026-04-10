<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id'";
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
                <h6 class="m-0">Rekap DPL PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapDplPklAdm.php?page=<?php echo $page;?>">Rekap DPL PKL</a></li>
                  <li class="breadcrumb-item active small">List DPL PKL</li>
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
                      <h4 class="card-title float-left">List DPL PKL</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="28%">Nama</td>
                            <td width="50%">Lokasi</td>
                            <td width="10%">Peserta PKL</td>
                            <td colspan="2" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT dpl_pkl.id AS id_dpl, dpl_pkl.id_pkl AS id_pkl, dpl_pkl.nip AS nip, dpl_pkl.lokasi AS lokasi FROM dpl_pkl INNER JOIN dt_pegawai ON dpl_pkl.nip=dt_pegawai.id  WHERE dpl_pkl.id_pkl='$id' ORDER BY dt_pegawai.nama_tg ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {

                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_array($res_grade);

                            $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$data[nip]'";
                            $res_dpl = mysqli_query($con, $qry_dpl);
                            $dt_dpl = mysqli_fetch_assoc($res_dpl);

                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dt_dpl[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                                                        
                            $qry1 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];

                            $qry2 = "SELECT COUNT(nilai) AS jumData FROM peserta_pkl WHERE id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];

                            $qry3 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data[nip]'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry4 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]' AND (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[cb]')";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];

                            $qry5 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE id_pkl='$data[id_pkl]' AND dpl='$data[nip]' AND id_dpl='$data[id_dpl]' AND (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]')";
                            $result5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];

                            $qry6 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data[nip]' AND (nilai <= '$dt_grade[at]' AND nilai >= '$dt_grade[cb]')";
                            $result6 =  mysqli_query($con, $qry6) or die(mysqli_error($con));
                            $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($con));
                            $jumlahData6 = $dataku6['jumData'];

                            $qry7 = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE dpl='$data[nip]' AND (nilai <= '$dt_grade[dt]' AND nilai >= '$dt_grade[db]')";
                            $result7 =  mysqli_query($con, $qry7) or die(mysqli_error($con));
                            $dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($con));
                            $jumlahData7 = $dataku7['jumData'];
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dt_dpl['nama_tg'];?> </td>
                            <td class="text-left"> <?php echo $data['lokasi'];?> </td>
                            <td class="text-center"> <?php if($jumlahData1==0) { echo '<button class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">'.$jumlahData1.'';} else { echo '<button class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat Peserta" data-toggle="modal" data-target="#modalPeserta" data-whatever="'.$data['id_dpl'].'">'.$jumlahData1.'</button>';}?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakDetailPerDplPklPerPeriodeAdm.php?id=<?php echo $data['id_dpl'];?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporDetailPerDplPklPerPeriodeAdm.php?id=<?php echo $data['id_dpl'];?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6"> <?php include "detailDplAdm.php";?> </td>
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