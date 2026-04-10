<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM skkm_unsur WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  extract( $dataku );
   
  $qry2 = "SELECT SUM(krdt) AS jumKredit FROM skkm WHERE nim='$username' AND unsur = '$id'";
  $result = mysqli_query($con,  $qry2 );
  $dt = mysqli_fetch_array( $result );
  $jumKredit = $dt[ 'jumKredit' ];
                            
  $query1 = "SELECT * FROM persentase_skkm WHERE id='$id'";
  $hasil1 = mysqli_query($con,  $query1 );
  $data1 = mysqli_fetch_assoc( $hasil1 );
  $prsn1 = $data1[ 'jumlah_1' ];
  $prsn2 = $data1[ 'jumlah_2' ];
                                                        
  $query = "SELECT SUM(krdt) AS totalKredit FROM skkm WHERE nim='$username'";
  $hasil = mysqli_query($con,  $query );
  $data = mysqli_fetch_array( $hasil );
  $totalKredit = $data[ 'totalKredit' ];
                            
  $persenKredit = ( $totalKredit != 0 ) ? ( $jumKredit / $totalKredit ) * 100 : 0;
  
  $myqry = "SELECT * FROM predikat_total_kredit";
  $hsl = mysqli_query($con, $myqry);
  $opsi  = mysqli_fetch_assoc($hsl);
  $jum1 = $opsi['jumlah_1'];
  $jum2 = $opsi['jumlah_2'];
  $jum3 = $opsi['jumlah_3'];
  
  $myquery1 = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $res1 = mysqli_query($con,  $myquery1 )or die( mysqli_error($con) );
  $dataku1 = mysqli_fetch_assoc( $res1 );
  $angkatan=$dataku1['angkatan'];
   
  $yearnow=date("Y");
  $monthnow=date("m");
  $jarakyear=($yearnow - $angkatan);
  $jaraksemestergenap=($jarakyear * 2);
  $jaraksemestergasal=($jarakyear * 2)+1;
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="sformSkkmUser.php" method="post" enctype="multipart/form-data">
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
                  <h1 class="m-0 float-left">Pengisian</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">SKKM (Satuan Kredit Kegiatan Mahasiswa)</li>
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
                          <a class="nav-link" href="unsurSkkmUser.php" role="tab" aria-selected="true">Unsur Pengisian</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatSkkmUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="formSkkmUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Form Submit Data Unsur <?php echo $unsur;?></a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body pb-0">
                      <div class="card card-info card-outline">
                        <div class="card-body pb-0">
                          <ul class="pl-2 text-secondary">
                            <li>Data sub unsur, jenis aitem dan bukti fisik yang diinput pada unsur <?php echo $unsur;?> ini harus sesuai dengan ketentuan yang ada di buku SKKM.</li>
                            <li>Isian form SKKM harus lengkap, didasarkan pada bukti fisik dan dapat dipertanggungjawabkan kebenarannya.</li>
                          </ul>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="unsur">Unsur <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="unsur" value="<?php echo $unsur;?>" disabled required>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="sub_unsur">Sub unsur <span class="text-danger">*</span></label>
                          <select name="sub_unsur" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM subunsurskkm WHERE idUnsur='$id'ORDER BY nmSubUnsur ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nmSubUnsur]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="jenis_aitem">Jenis aitem <span class="text-danger">*</span></label>
                          <select name="jenis_aitem" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM jenisaitemskkm WHERE idUnsur='$id' ORDER BY nmJenisAitem ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nmJenisAitem]</option>";
                              }
                              ?>
                          </select>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="bukti_fisik">Bukti fisik <span class="text-danger">*</span></label>
                          <select name="bukti_fisik" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM buktifisikskkm WHERE idUnsur='$id' ORDER BY nmBuktiFisik ASC");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[id]'>$tampil[nmBuktiFisik]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="deskrip_unsur">Deskripsi/uraian unsur <span class="text-danger">*</span></label>
                        <textarea id="textarea-custom-one" name="deskrip_unsur" class="form-control form-control-sm" style="height: 300px;" required></textarea>
                        <p class="help-block small"><strong>Misal: Seminar Nasional Psikologi Kesehatan Mental, dll.</strong></p>
                      </div>
                      <div class="form-group">
                        <label for="tmpt">Tempat/lembaga <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="tmpt" required>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="start_keg">Tanggal mulai kegiatan <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
                            <input type="text" name="start_keg" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="end_keg">Tanggal selesai kegiatan <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_dmy_two" data-target-input="nearest">
                            <input type="text" name="end_keg" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_two" required/>
                            <div class="input-group-append" data-target="#tgl_dmy_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="krdt">Kredit <span class="text-danger">*</span></label>
                          <select name="krdt" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <?php
                              $q = mysqli_query($con, "SELECT * FROM krdt_skkm");
                              while ($tampil = mysqli_fetch_array($q)){
                                echo "<option value='$tampil[jumlah_krdt]'>$tampil[jumlah_krdt]</option>";
                              }
                              ?>
                          </select>
                        </div>
                      </div>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $dataku1['nim'];?>" required readonly>
                      <input type="text" name="unsur" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input class="sr-only" type="text" name="semester" value="<?php if($monthnow <=6) { echo $jaraksemestergenap;} else { echo $jaraksemestergasal;}?>" required readonly>
                      <input type="text" name="tgl_input" class="sr-only" value="<?php echo date("Y-m-d");?>" required readonly>
                      <input type="text" name="statusform" class="sr-only" value="1" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Submit data</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-9">
                  <div class="card card-info card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Rekap Capaian Kredit Unsur <?php echo $unsur;?></h3>
                    </div>
                    <div class="card-body pl-0 pr-0 pb-0">
                      <div class="table-responsive">
                        <table class="table table-hover m-0 text-center table-sm custom">
                          <thead>
                            <tr>
                              <th width="4%" class="text-center pl-1">No.</th>
                              <th width="44%" class="text-left">Sub unsur</th>
                              <th width="32%" class="text-left">Jenis aitem</th>
                              <th width="20%" class="text-center pr-1">Kredit</th>
                          </thead>
                          <tbody>
                            <?php
                              $no = 0;
                              $query = "SELECT * FROM skkm WHERE nim='$username' AND unsur='$id'";
                              $has = mysqli_query($con,  $query )or die( 'Error' );
                              while ( $data = mysqli_fetch_assoc( $has ) ) {
                              $no++;
                              $id=$data['id'];
                              $idSubUnsur=$data['sub_unsur'];
                              $idJenisAitem=$data['jenis_aitem'];
                              $bukti_fisik=$data['bukti_fisik'];
                              $statusform=$data['statusform'];
                              $oldDate1 = $data['tgl_input'];
                              $newDate1 = date("d-m-Y", strtotime($oldDate1));
                              $oldDate2 = $data['tgl_validasi'];
                              $newDate2 = date("d-m-Y", strtotime($oldDate2));
                              
                              $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
                              $res1 = mysqli_query($con,  $qry1 )or die( 'Error' );
                              $data1 = mysqli_fetch_assoc( $res1 );
                                
                              $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
                              $res2 = mysqli_query($con,  $qry2 )or die( 'Error' );
                              $data2 = mysqli_fetch_assoc( $res2 );
                              
                              $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$bukti_fisik'";
                              $res3 = mysqli_query($con,  $qry3 )or die( 'Error' );
                              $data3 = mysqli_fetch_assoc( $res3 );
                              
                              $qry4 = "SELECT * FROM opsi_validasi WHERE id='$statusform'";
                              $res4 = mysqli_query($con,  $qry4 )or die( 'Error' );
                              $data4 = mysqli_fetch_assoc( $res4 );
                              ?>
                            <tr data-widget="expandable-table" aria-expanded="false">
                              <td class="text-center pl-1"><?php echo $no;?></td>
                              <td class="text-left"><?php echo($data1['nmSubUnsur']);?></td>
                              <td class="text-left"><?php echo($data2['nmJenisAitem']);?></td>
                              <td class="text-center pr-1"><?php echo($data['krdt']);?></td>
                            </tr>
                            <tr class="expandable-body">
                              <td colspan="4">
                                <section class="content pt-2">
                                  <div class="container-fluid">
                                    <div class="col">
                                      <div class="card">
                                        <div class="card-header">
                                          <h3 class="card-title">Detail Kredit Sub Unsur <?php echo $unsur;?></h3>
                                        </div>
                                        <div class="card-body text-left pb-0">
                                          <dl class="row">
                                            <dt class="col-sm-3">Unsur</dt>
                                            <dd class="col-sm-9"><?php echo $unsur;?></dd>
                                            <dt class="col-sm-3">Sub unsur</dt>
                                            <dd class="col-sm-9"><?php echo($data1['nmSubUnsur']);?></dd>
                                            <dt class="col-sm-3">Jenis aitem</dt>
                                            <dd class="col-sm-9"><?php echo($data2['nmJenisAitem']);?></dd>
                                            <dt class="col-sm-3">Bukti fisik</dt>
                                            <dd class="col-sm-9"><?php echo $data3['nmBuktiFisik'];?></dd>
                                            <dt class="col-sm-3">Deskripsi unsur</dt>
                                            <dd class="col-sm-9"><?php echo $data['deskrip_unsur']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskrip_unsur']);?></dd>
                                            <dt class="col-sm-3">Tempat/lembaga</dt>
                                            <dd class="col-sm-9"><?php echo $data['tmpt'];?></dd>
                                            <dt class="col-sm-3">Waktu kegiatan</dt>
                                            <dd class="col-sm-9"><?php echo $data['start_keg'].' s.d '.$data['end_keg'];?></dd>
                                            <dt class="col-sm-3">Kredit</dt>
                                            <dd class="col-sm-9"><?php echo $data['krdt'];?></dd>
                                            <dt class="col-sm-3">Submit data di semester</dt>
                                            <dd class="col-sm-9"><?php echo $data['semester'];?></dd>
                                            <dt class="col-sm-3">Tanggal input</dt>
                                            <dd class="col-sm-9"><?php echo $newDate1;?></dd>
                                            <dt class="col-sm-3">Status validasi</dt>
                                            <dd class="col-sm-9"><?php echo $data4['nm'];?> <?php if($data['statusform']==1) {echo '';} else {echo '['.$data4['nm'].' pada tanggal: '.$newDate2.']';}?></dd>
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
                            <tr>
                              <td colspan="3" class="text-right"><strong>Jumlah kredit:</strong></td>
                              <td><strong><?php if(empty($jumKredit)) { echo "0";} else { echo  $jumKredit;}?> (<?php printf("%1.0f",$persenKredit); print("%");?>)</strong></td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-right"><strong>Status:</strong></td>
                              <td><strong><?php 
                                if ($persenKredit >= $prsn1 && $persenKredit <= $prsn2){
                                echo "
                                <span class='text-success'>Sesuai standar</span>";
                                }
                                else if ($persenKredit < $prsn1){
                                echo "
                                <span class='text-danger'>Kurang dari standar</span>";
                                }
                                else if ($persenKredit > $prsn2 ){
                                echo "
                                <span class='text-warning'>Lebih dari standar</span>";
                                }
                                ?></strong></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <div class="card card-danger card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Standar Prosentase</h3>
                    </div>
                    <div class="card-body pb-0">
                      <ul class="pl-2 small text-secondary">
                        <li>Prosentase unsur <?php echo $unsur;?> tidak boleh Kurang dari Standar, harus Sesuai Standar atau Lebih dari Standar.</li>
                        <li>Prosentase antar unsur harus balance.</li>
                      </ul>
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