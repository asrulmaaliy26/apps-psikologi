<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 float-left">Pendaftaran</h1>
              </div>
              <div class="col-sm-6">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm">
                <div class="card card-success card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" href="prePendaftaranPklUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="riwayatPendaftaranPklUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body pl-0 pr-0 pb-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th width="4%" class="pl-1">No.</th>
                            <th width="12%">Tgl. pendaftaran</th>
                            <th width="36%">Pilihan lokasi PKL</th>
                            <th width="22%">DPL</th>
                            <th width="10%">Status</th>
                            <th colspan="4" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_pkl WHERE nim='$username'";
                            $result = mysqli_query($con,  $sql )or die( mysqli_error($con) );
                            while($data = mysqli_fetch_assoc( $result )) {
                            $id=$data['id'];
                            $no++;
                            
                            $query = "SELECT * FROM dpl_pkl WHERE id='$data[id_dpl]'";
                            $res = mysqli_query($con,  $query )or die( mysql_erdror() );
                            $mydata = mysqli_fetch_assoc( $res );
                            
                            $myquery = "SELECT * FROM dt_pegawai WHERE id='$mydata[nip]'";
                            $res = mysqli_query($con,  $myquery )or die( mysql_erdror() );
                            $dt = mysqli_fetch_assoc( $res );
                            
                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-center"><?php echo $mydata['lokasi'];?></td>
                            <td class="text-center pr-1"><?php echo $dt['nama'];;?></td>
                            <td class="text-center pr-1"><?php echo $dcek['nm'];;?></td>
                            <td width="4%" class="text-center pl-1"><?php if($data['val_adm']==1 OR $data['val_adm']==4) { echo "<a class='btn btn-outline-warning btn-xs btn-block' onclick='return confirm(\"Yakin data ini diedit?\")' title='Yakin data ini diedit?' href='detailRiwayatPendaftaranPklUser.php?id=".$data['id']."'><i class='far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit. Pendaftaran telah diterima\")' title='Tidak bisa diedit. Pendaftaran telah diterima' disabled><i class='far fa-edit'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if($data['val_adm']==1 OR $data['val_adm']==4) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Yakin data ini dihapus?' href='deletePendaftaranPklUser.php?id=".$data['id']."'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus. Pendaftaran telah diterima\")' title='Tidak bisa dihapus. Pendaftaran telah diterima' disabled><i class='far fa-trash-alt'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if(!empty($data['catatan'])) { echo "<a class='btn btn-outline-primary btn-xs btn-block' title='Lihat catatan' href='catatanPendaftaranPklUser.php?id=".$data['id']."'><i class='far fa-comment-dots'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada catatan.\")' title='Tidak ada catatan.' disabled><i class='far fa-comment-dots'></i></a>";}?></td>
                            <td width="4%" class="text-center pr-1"><button class='btn btn-outline-primary btn-xs btn-block' data-toggle='modal' data-target='#modal-pre-cetak' data-whatever='<?php echo $data['id'];?>' target='_blank' title='Cetak bukti pendaftaran'><i class='fas fa-print'></i></button></td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <?php include ("notifKetPngjnPendftrn.php");?>
            </div>
            <div class="modal fade" id="modal-pre-cetak">
              <div class="modal-dialog modal-lg">
                <div class="modal-content bg-info">
                  <div class="isi-modal-pre-cetak"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
    <script>
      $( '#modal-pre-cetak' ).on( 'show.bs.modal', function ( event ) {
          var button = $( event.relatedTarget )
          var recipient = button.data( 'whatever' )
          var modal = $( this );
          var dataString = 'id=' + recipient;
         
          $.ajax( {
            type: "GET",
            url: "bodyPetunjukCetakPpkl.php",
            data: dataString,
            cache: false,
            success: function ( data ) {
              console.log( data );
              modal.find( '.isi-modal-pre-cetak' ).html( data );
            },
            error: function ( err ) {
              console.log( err );
            }
          } );
         } );
    </script>
  </body>
</html>