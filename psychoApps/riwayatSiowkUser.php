<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qnotif = "SELECT * FROM notif_submit_surat LIMIT 1";
  $rnotif = mysqli_query($con, $qnotif)or die( mysqli_error($con));
  $dnotif = mysqli_fetch_assoc($rnotif);
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
              <div class="col-sm-4">
                <h1 class="m-0 float-left">Permohonan Surat</h1>
              </div>
              <div class="col-sm-8">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Izin Observasi dan Wawancara (Matkul) Kelompok</li>
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
                        <a class="nav-link" href="formSiowkUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="riwayatSiowkUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th width="4%" class="pl-1">No.</th>
                            <th width="12%">Tgl. pengajuan</th>
                            <th width="46%">Tempat observasi dan wawancara</th>
                            <th width="10%">Anggota</th>
                            <th width="12%">Status surat</th>
                            <th colspan="4" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM siow_kelompok WHERE nim=$dataku[nim] ORDER BY id DESC";
                            $result = mysqli_query($con, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                            $id = $data['id'];
                            
                            $qrykota = "SELECT * FROM dt_kota WHERE id='$data[kota_penelitian]'";
                            $reskota = mysqli_query($con,  $qrykota )or die( mysqli_error($con) );
                            $dtkota = mysqli_fetch_assoc( $reskota );
                            
                            $qryval = "SELECT * FROM opsi_status_pengajuan_surat WHERE id='$data[statusform]'";
                            $resval = mysqli_query($con,  $qryval )or die( mysqli_error($con) );
                            $dtval = mysqli_fetch_assoc( $resval );
                            $no++;
                            ?> 
                          <tr>
                            <td class="text-center pl-1"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-center"><?php echo $data['tempat_ow'].' di '.$dtkota['nm_kota'];?></td>
                            <td class="text-center"><button type="button" class="btn btn-outline-info btn-xs btn-block" data-toggle="modal" data-target="#anggota" data-whatever="<?php echo $id;?>">Lihat</button></td>
                            <td class="text-center pr-1"><?php echo $dtval['nm'];?></td>
                            <td width="4%" class="text-center pl-1"><?php if($data['statusform']==1 OR $data['statusform']==4) { echo "<a class='btn btn-outline-warning btn-xs btn-block' onclick='return confirm(\"Yakin data ini diedit?\")' title='Yakin data ini diedit?' href='editSiowkUser.php?id=".$data['id']."'><i class='far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit. Permohonan surat telah diterima/diproses/selesai\")' title='Tidak bisa diedit. Permohonan surat telah diterima/diproses/selesai' disabled><i class='far fa-edit'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if($data['statusform']==1 OR $data['statusform']==4) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Yakin data ini dihapus?' href='deleteSiowkUser.php?id=".$data['id']."'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus. Permohonan surat telah diterima/diproses/selesai\")' title='Tidak bisa dihapus. Permohonan surat telah diterima/diproses/selesai' disabled><i class='far fa-trash-alt'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if(!empty($data['catatan'])) { echo "<a class='btn btn-outline-primary btn-xs btn-block' title='Lihat catatan' href='catatanSiowkUser.php?id=".$data['id']."'><i class='far fa-comment-dots'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada catatan.\")' title='Tidak ada catatan.' disabled><i class='far fa-comment-dots'></i></a>";}?></td>
                            <td width="4%" class="text-center pr-1"><?php if($data['statusform']==3) { echo "<button class='btn btn-outline-primary btn-xs btn-block' data-toggle='modal' data-target='#modal-pre-cetak' data-whatever='".$data['id']."' target='_blank' title='Cetak surat'><i class='fas fa-print'></i></button>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Belum bisa dicetak, sebelum Status surat: Selesai!\")' title='Belum bisa dicetak, sebelum Status surat: Selesai!' disabled><i class='fas fa-print'></i></a>";}?></td>
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
              <?php include ("notifKetSurat.php");?>
            </div>
            <div class="modal fade" id="anggota">
              <div class="modal-dialog">
                <div class="modal-content bg-info">
                  <div class="modal-header">
                    <h4 class="modal-title">Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                  </div>
                  <div class="modal-body">
                    <div class="isi-anggota"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
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
      $( '#anggota' ).on( 'show.bs.modal', function ( event ) {
          var button = $( event.relatedTarget )
          var recipient = button.data( 'whatever' )
          var modal = $( this );
          var dataString = 'id=' + recipient;
         
          $.ajax( {
            type: "GET",
            url: "anggotaSiowk.php",
            data: dataString,
            cache: false,
            success: function ( data ) {
              console.log( data );
              modal.find( '.isi-anggota' ).html( data );
            },
            error: function ( err ) {
              console.log( err );
            }
          } );
         } );

      $( '#modal-pre-cetak' ).on( 'show.bs.modal', function ( event ) {
          var button = $( event.relatedTarget )
          var recipient = button.data( 'whatever' )
          var modal = $( this );
          var dataString = 'id=' + recipient;
         
          $.ajax( {
            type: "GET",
            url: "bodyPetunjukCetakSiowk.php",
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