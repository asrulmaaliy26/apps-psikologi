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
                  <li class="breadcrumb-item active">Ujian Skripsi</li>
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
                        <a class="nav-link" href="prePendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="riwayatPendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Riwayat</a>
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
                            <th width="18%">Status</th>
                            <th width="46%">Nilai</th>
                            <th colspan="5" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_ujskrip WHERE nim='$username'";
                            $result = mysqli_query($con,  $sql )or die( mysqli_error($con) );
                            while($data = mysqli_fetch_assoc( $result )) {
                            $id=$data['id'];
                            $oldDate = $data['tgl_validasi'];
                            $newDate = date("d-m-Y", strtotime($oldDate));
                            $no++;
                            
                            $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$data[id_ujskrip]'";
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
                            
                            $qry_jdwl = "SELECT * FROM jadwal_ujskrip WHERE id_ujskrip='$data[id_ujskrip]' AND id='$data[id_jdwl]'";
                            $res_jdwl = mysqli_query($con, $qry_jdwl);
                            $dt_jdwl = mysqli_fetch_assoc($res_jdwl);
                            $oldDateJad = $dt_jdwl['tgl_ujian'];
                            $newDateJad = date("d-m-Y", strtotime($oldDateJad));

                            $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[ketua_penguji]'";
                            $res_p1 = mysqli_query($con, $qry_p1);
                            $dt_p1 = mysqli_fetch_assoc($res_p1);
                            
                            $qry_p2 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[sekretaris_penguji]'";
                            $res_p2 = mysqli_query($con, $qry_p2);
                            $dt_p2 = mysqli_fetch_assoc($res_p2);
                            
                            $qry_p3 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji_utama]'";
                            $res_p3 = mysqli_query($con, $qry_p3);
                            $dt_p3 = mysqli_fetch_assoc($res_p3);

                            $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$dt_jdwl[ruang]'";
                            $res_ruang = mysqli_query($con, $qry_ruang);
                            $dt_ruang = mysqli_fetch_assoc($res_ruang);
                            
                            $qry_nilai = "SELECT * FROM nilai_ujskrip WHERE id_pendaftaran='$data[id]'";
                            $res_nilai = mysqli_query($con, $qry_nilai);
                            $dt_nilai = mysqli_fetch_assoc($res_nilai);
                            
                            $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$data[id_ujskrip]'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);
                            
                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"><?php echo $no;?></td>
                            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-center"><?php echo $dcek['nm'];;?></td>
                            <td class="text-center pr-1"><?php include "nilaiPesUjskripUser.php";?></td>
                            <td width="4%" class="text-center pl-1"><?php if($data['val_adm']==1 OR $data['val_adm']==4) { echo "<a class='btn btn-outline-warning btn-xs btn-block' onclick='return confirm(\"Yakin data ini diedit?\")' title='Yakin data ini diedit?' href='detailRiwayatPendaftaranUjskripUser.php?id=".$data['id']."'><i class='far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit. Pendaftaran telah diterima\")' title='Tidak bisa diedit. Pendaftaran telah diterima' disabled><i class='far fa-edit'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if($data['val_adm']==1 OR $data['val_adm']==4) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Yakin data ini dihapus?' href='deletePendaftaranUjskripUser.php?id=".$data['id']."'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus. Pendaftaran telah diterima\")' title='Tidak bisa dihapus. Pendaftaran telah diterima' disabled><i class='far fa-trash-alt'></i></a>";}?></td>
                            <td width="4%" class="text-center"><?php if(!empty($data['catatan'])) { echo "<a class='btn btn-outline-primary btn-xs btn-block' title='Lihat catatan' href='catatanPendaftaranUjskripUser.php?id=".$data['id']."'><i class='far fa-comment-dots'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak ada catatan.\")' title='Tidak ada catatan.' disabled><i class='far fa-comment-dots'></i></a>";}?></td>
                            <td width="4%" class="text-center pr-1"><button class='btn btn-outline-primary btn-xs btn-block' data-toggle='modal' data-target='#modal-pre-cetak' data-whatever='<?php echo $data['id'];?>' target='_blank' title='Cetak bukti pendaftaran'><i class='fas fa-print'></i></button></td>
                            <td width="4%" class="text-center pr-1"><a class='btn btn-outline-primary btn-xs btn-block' title='Jadwal ujian skripsi' href='jadwalUjskripUser.php?id=<?php echo $data['id'];?>'><i class="far fa-calendar-alt"></i></a></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="9">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="col">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3 class="card-title">Detail Pendaftaran</h3>
                                      </div>
                                      <div class="card-body text-left pb-0">
                                        <dl class="row">
                                          <dt class="col-sm-4">Tanggal pendaftaran</dt>
                                          <dd class="col-sm-8"><?php echo $data['tgl_pengajuan'];?></dd>
                                          <dt class="col-sm-4">Periode pendaftaran</dt>
                                          <dd class="col-sm-8"><?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></dd>
                                          <dt class="col-sm-4">Judul skripsi</dt>
                                          <dd class="col-sm-8"><?php echo $data['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']);?></dd>
                                          <dt class="col-sm-4">Lampiran file</dt>
                                          <dd class="col-sm-8"><?php if(empty($data['file_skripsi'])) { echo 'Tidak ada';} else { echo '<a class="btn btn-outline-primary btn-xs" title="Lihat/download" href="'.$data['file_skripsi'].'" target="_blank">Skripsi</a>';}?></dd>
                                          <dt class="col-sm-4">Status verifikasi</dt>
                                          <dd class="col-sm-8"><?php if($data['val_adm']==1) { echo $dcek['nm'];} elseif($data['val_adm']==2) { echo $dcek['nm'].'<br/> Tanggal verifikasi: '.$newDate;} elseif($data['val_adm']==3) { echo $dcek['nm'].'<br/> Tanggal verifikasi: '.$newDate;} elseif($data['val_adm']==4) { echo $dcek['nm'].'<br/> Tanggal verifikasi: '.$newDate;}?>
                                          </dd>
                                          <dt class="col-sm-4">Catatan pendaftaran</dt>
                                          <dd class="col-sm-8"><?php if(empty($data['catatan'])) { echo "Tidak ada";} else { echo $data['catatan']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['catatan']);}?></dd>
                                          <dt class="col-sm-4">Jadwal</dt>
                                          <dd class="col-sm-8"><?php if(empty($dt_jdwl['tgl_ujian']) && empty($dt_jdwl['jam_mulai']) && empty($dt_jdwl['jam_selesai']) && empty($dt_jdwl['ruang'])) { echo "Belum ada";} else { echo "Ketua Penguji: $dt_p1[nama]
                                            <br/>Sekretaris Penguji: $dt_p2[nama]
                                            <br/>Penguji Utama: $dt_p3[nama]
                                            <br/>Tanggal Ujian: $newDateJad
                                            <br/>Pukul: $dt_jdwl[jam_mulai] - $dt_jdwl[jam_selesai]
                                            <br/>Ruang: $dt_ruang[nm]";}?></dd>
                                          <dt class="col-sm-4">Nilai</dt>
                                          <dd class="col-sm-8">Ketua penguji: <?php include("nilaiKetuaPesUjskripUser.php");?>
                                            <br/>Sekretaris penguji: <?php include("nilaiSekretarisPesUjskripUser.php");?>
                                            <br/>Penguji utama: <?php include("nilaiUtamaPesUjskripUser.php");?></dd>
                                          <dt class="col-sm-4">Rerata nilai</dt>
                                          <dd class="col-sm-8"><?php include "nilaiPesUjskripUser.php";?></dd>
                                        </dl>
                                      </div>
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
            url: "bodyPetunjukCetakPujskrip.php",
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