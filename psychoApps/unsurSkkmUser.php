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
                        <a class="nav-link active" href="unsurSkkmUser.php" role="tab" aria-selected="true">Unsur Pengisian</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatSkkmUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body pl-0 pr-0 pb-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead>
                          <tr>
                            <th width="4%" class="text-center pl-1">No.</th>
                            <th width="20%" class="text-left">Unsur SKKM</th>
                            <th width="12%" class="text-left">Standar Kredit</th>
                            <th colspan="3" class="text-left">Capaian Kredit</th>
                            <th width="12%" class="text-center pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no = 0;
                            $qry = "SELECT * FROM skkm_unsur";
                            $res = mysqli_query($con,  $qry );
                            while ( $mydata = mysqli_fetch_assoc( $res ) ) {
                              $idUnsur = $mydata[ 'id' ];
                              $unsur = $mydata[ 'unsur' ];
                              $no++;
                            
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
                            
                              $persenKredit = ( $totalKredit != 0 ) ? ( $jumKredit / $totalKredit ) * 100 : 0;
                              ?>
                          <tr>
                            <td class="text-center pl-1"><?php echo $no;?></td>
                            <td class=""><?php echo $unsur;?></td>
                            <td class="text-left"><?php if(empty($prsn2)) { echo "$prsn1"."%";} else { echo "$prsn1"."%"." - "."$prsn2"."%";}?></td>
                            <td width="2%" class="text-left"><?php if(empty($jumKredit)) { echo "0";} else { echo  $jumKredit;}?></td>
                            <td width="20%" class="text-left pl-0">
                              <div class="progress">
                                <div class="progress-bar 
                                  <?php if ($persenKredit >= $prsn1 && $persenKredit <= $prsn2){ echo "bg-success";} else if ($persenKredit < $prsn1){ echo "bg-danger";} else if ($persenKredit > $prsn2 ){ echo "bg-warning";}?>  progress-bar-striped" role="progressbar" aria-valuenow="
                                  <?php echo $jumKredit;?>" aria-valuemin="0" aria-valuemax="100" style="width:
                                  <?php printf("%1.0f",$persenKredit); print("%");?>">
                                  <span>
                                  <?php printf("%1.0f",$persenKredit); print("%");?>
                                  </span>
                                </div>
                              </div>
                            </td>
                            <td width="14%" class="text-left pr-1">
                              <?php
                                $myqry = "SELECT * FROM predikat_total_kredit";
                                $hsl = mysqli_query($con, $myqry);
                                $opsi  = mysqli_fetch_assoc($hsl);
                                $jum1 = $opsi['jumlah_1'];
                                $jum2 = $opsi['jumlah_2'];
                                $jum3 = $opsi['jumlah_3'];
                                
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
                                ?>
                            </td>
                            <td class="text-center pl-1">
                              <a class="btn btn-outline-info btn-xs btn-block"  title="Submit data" href="formSkkmUser.php?id=<?php echo $mydata[ 'id'];?>"><i class="fas fa-folder-plus"></i> Submit data</a>
                            </td>
                          </tr>
                          <?php };?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-sm-8 m-0">
                <div class="card">
                  <div class="card-body bg-info pt-2 pb-2">
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
              <div class="form-group col-sm-4 m-0">
                <button class="btn btn-info btn-lg btn-block pt-3 pb-3" data-toggle="modal" data-target="#modal-pre-cetak" data-whatever="<?php echo $username;?>" target="_blank" title="Cetak SKKM"><i class='fas fa-print'></i> Cetak SKKM</button>
              </div>
            </div>
            <div class="row">
              <?php include ("notifKetSkkmUser.php");?>
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
          var dataString = 'nim=' + recipient;
         
          $.ajax( {
            type: "GET",
            url: "bodyPetunjukCetakSkkm.php",
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