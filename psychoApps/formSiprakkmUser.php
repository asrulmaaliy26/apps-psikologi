<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);
  
  $qnotif = "SELECT * FROM notif_submit_surat LIMIT 1";
  $rnotif = mysqli_query($con, $qnotif)or die( mysqli_error($con));
  $dnotif = mysqli_fetch_assoc($rnotif);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="sformSiprakkmUser.php" method="post" enctype="multipart/form-data">
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
                    <li class="breadcrumb-item active">Izin Praktikum Kelompok Testee Mahasiswa</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
              <div class="modal-content bg-info">
                <div class="modal-header">
                  <h4 class="modal-title"><?php echo $dnotif['judul'];?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p><?php echo nl2br($dnotif['isi']);?></p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">OK, saya mengerti...</button>
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
                          <a class="nav-link active" href="formSiprakkmUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSiprakkmUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="matkul_testee">Matakuliah testee <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="matkul_testee" required>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="dosen_testee">Nama dosen matakuliah testee (dengan gelar) <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="dosen_testee" required>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="matkul">Praktikum untuk matakuliah <span class="text-danger">*</span></label>
                          <select name="matkul" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM matkul_praktikum ORDER BY nama ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nama]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="waktu">Tanggal praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="waktu" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="jam">Jam mulai praktikum <span class="text-danger">*</span></label>
                          <div class="input-group date" id="jam_one" data-target-input="nearest">
                            <input type="text" name="jam" class="form-control form-control-sm datetimepicker-input" data-target="#jam_one" required/>
                            <div class="input-group-append" data-target="#jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-clock"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group mt-2">
                        <span class="d-block p-2 bg-info text-white">Nama-nama testee (Kosongkan kolom yang tidak diisi!)</span>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 1 <span class="text-danger">*</span></label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee1" class="form-control" required>
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee1" class="form-control" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 2 <span class="text-danger">*</span></label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee2" class="form-control" required>
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee2" class="form-control" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 3</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee3" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee3" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 4</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee4" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee4" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 5</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee5" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee5" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 6</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee6" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee6" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 7</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee7" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee7" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 8</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee8" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee8" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 9</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee9" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee9" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 10</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee10" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee10" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 11</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee11" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee11" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 12</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee12" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee12" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 13</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee13" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee13" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 14</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee14" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee14" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 15</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee15" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee15" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 16</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee16" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee16" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 17</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee17" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee17" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 18</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee18" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee18" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="">Testee 19</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee19" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee19" class="form-control">
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="">Testee 20</label>
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" name="testee20" class="form-control">
                            <div class="input-group-prepend">
                              <span class="input-group-text border-left-0">NIM</span>
                            </div>
                            <input type="text" name="nim_testee20" class="form-control">
                          </div>
                        </div>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
                      <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                      <input type="text" name="statusform" class="sr-only" value="1" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Submit permohonan surat</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php include( "footerAdm.php" );?>
      <?php include( "jsAdm.php" );?>
    </body>
  </form>
</html>