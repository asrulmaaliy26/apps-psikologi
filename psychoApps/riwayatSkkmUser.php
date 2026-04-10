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
                <h1 class="m-0 float-left">Pengisian</h1>
              </div>
              <div class="col-sm-6">
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
                        <a class="nav-link active" href="riwayatSkkmUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body pl-0 pr-0 pb-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 text-center table-sm custom">
                        <?php
                          $qry = "SELECT * FROM skkm_unsur";
                          $res = mysqli_query($con,  $qry )or die( 'Error' );
                          while ( $isi = mysqli_fetch_assoc( $res ) ) {
                          $idUnsur=$isi['id'];
                          ?>
                        <thead>
                          <tr>
                            <th colspan="6" class="pl-2 text-left bg-gradient-info">Unsur <?php echo $isi['unsur'];?></th>
                          </tr>
                        </thead>
                        <thead>
                          <tr>
                            <th width="3%" class="pl-2">No.</th>
                            <th width="54%" class="text-left">Sub Unsur</th>
                            <th width="29%" class="text-left">Jenis Aitem</th>
                            <th width="6%">Kredit</th>
                            <th colspan="2" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $query = "SELECT * FROM skkm WHERE nim='$username' and unsur='$idUnsur'";
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
                            <td class="text-center pl-2"><?php echo $no;?></td>
                            <td class="text-left"><?php echo($data1['nmSubUnsur']);?></td>
                            <td class="text-left"><?php echo($data2['nmJenisAitem']);?></td>
                            <td class="text-center pr-1"><?php echo($data['krdt']);?></td>
                            <td width="4%" class="text-center pl-2"><?php if($data['statusform']==1 OR $data['statusform']==4) { echo "<a class='btn btn-outline-warning btn-xs btn-block' onclick='return confirm(\"Yakin data ini diedit?\")' title='Yakin data ini diedit?' href='editSkkmUser.php?id=".$data['id']."'><i class='far fa-edit'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit. SKKM telah diterima\")' title='Tidak bisa diedit. SKKM telah diterima' disabled><i class='far fa-edit'></i></a>";}?></td>
                            <td width="4%" class="text-center pr-2"><?php if($data['statusform']==1 OR $data['statusform']==4) { echo "<a class='btn btn-outline-danger btn-xs btn-block' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Yakin data ini dihapus?' href='deleteSkkmUser.php?id=".$data['id']."'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-secondary btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus. SKKM telah diterima\")' title='Tidak bisa dihapus. SKKM telah diterima' disabled><i class='far fa-trash-alt'></i></a>";}?></td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="col">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3 class="card-title text-left">Detail Kredit Sub Unsur <?php echo $isi['unsur'];?></h3>
                                      </div>
                                      <div class="card-body text-left pb-0">
                                        <dl class="row">
                                          <dt class="col-sm-3">Unsur</dt>
                                          <dd class="col-sm-9"><?php echo $isi['unsur'];?></dd>
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
                            $qry2 = "SELECT SUM(krdt) AS jumKredit FROM skkm WHERE nim='$username' AND unsur = '$idUnsur'";
                            $result = mysqli_query($con,  $qry2 );
                            $dt = mysqli_fetch_array( $result );
                            $jumKredit = $dt[ 'jumKredit' ];
                            
                            $query1 = "SELECT * FROM persentase_skkm WHERE id='$idUnsur'";
                            $hasil1 = mysqli_query($con,  $query1 );
                            $data1 = mysqli_fetch_assoc( $hasil1 );
                            $prsn1 = $data1[ 'jumlah_1' ];
                            $prsn2 = $data1[ 'jumlah_2' ];
                                                        
                            $query = "SELECT SUM(krdt) AS totalKredit FROM skkm WHERE nim='$username'";
                            $hasil = mysqli_query($con,  $query );
                            $data = mysqli_fetch_array( $hasil );
                            $totalKredit = $data[ 'totalKredit' ];
                            
                            $persenKredit = ( $totalKredit != 0 ) ? ( $jumKredit / $totalKredit ) * 100 : 0;}
                            ?>
                          <tr>
                            <td colspan="3" class="text-right"><strong>Jumlah kredit:</strong></td>
                            <td colspan="3" class="text-left"><strong><?php if(empty($jumKredit)) { echo "0";} else { echo  $jumKredit;}?> (<?php printf("%1.0f",$persenKredit); print("%");?>)</strong></td>
                          </tr>
                          <tr>
                            <td colspan="3" class="text-right"><strong>Status:</strong></td>
                            <td colspan="3" class="text-left"><strong><?php 
                              if ($persenKredit >= $prsn1 && $persenKredit <= $prsn2){
                              echo "<span class='text-success'>Sesuai standar</span>";
                              }
                              else if ($persenKredit < $prsn1){
                              echo "<span class='text-danger'>Kurang dari standar</span>";
                              }
                              else if ($persenKredit > $prsn2 ){
                              echo "<span class='text-warning'>Lebih dari standar</span>";
                              }
                              ?></strong></td>
                          </tr>
                        </tbody>
                        <?php
                          }
                          ?>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer">
                    Total kredit: 
                    <?php 
                      $myqry = "SELECT * FROM predikat_total_kredit";
                      $hsl = mysqli_query($con, $myqry);
                      $opsi  = mysqli_fetch_assoc($hsl);
                      $jum1 = $opsi['jumlah_1'];
                      $jum2 = $opsi['jumlah_2'];
                      $jum3 = $opsi['jumlah_3'];
                      if ($totalKredit > $jum3){
                      echo "$totalKredit";
                      }
                      else if ($totalKredit >= $jum2){
                      echo "$totalKredit";
                      }
                      else if ($totalKredit >= $jum1){
                      echo "$totalKredit";
                      }
                      else{
                      echo "$totalKredit";
                      }
                       ?>
                    <br/>
                    Predikat:
                    <?php 
                      if ($totalKredit > $jum3){
                       echo "Prestisius";
                       }
                       else if ($totalKredit >= $jum2){
                       echo "Sangat Aktif";
                       }
                       else if ($totalKredit >= $jum1){
                       echo "Aktif";
                       }
                       else{
                       echo "Kurang";
                       }
                        ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <?php include ("notifKetSkkmUser.php");?>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>