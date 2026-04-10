<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navMasterDataAdm.php";
      include 'pagination.php';         
            if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
            $keyword=$_REQUEST['keyword'];
            $reload = "variabelxyAdm.php?pagination=true&keyword=$keyword";
            
            $sql = "SELECT * FROM mag_variablexy WHERE nm LIKE '%$keyword%' ORDER BY nm ASC";
      
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }else{
            $reload = "variabelxyAdm.php?pagination=true";
            $sql =  "SELECT * FROM mag_variablexy ORDER BY cek ASC";
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }
            
            $rpp = 20;
            $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
            $tcount = mysqli_num_rows($result);
            $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
            $count = 0;
            $i = ($page-1)*$rpp;
            $no_urut = ($page-1)*$rpp;
          ?>
          <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
          echo '<div class="alert alert-warning custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
            
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-danger custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil dihapus...</div>';}
          ?>
    <div class="container">
      <div class="row">
        <h3 class="text-center text-info">Variabel Tesis (X dan Y)</h3>
        <div class="col-lg-12">
          <div class="row">
            <ul class="nav nav-tabs" style="margin-bottom:10px;">
              <li role="presentation" class="active"><a href="variabelxyAdm.php">Variabel Tesis (X dan Y)</a></li>
              <li role="presentation"><a href="covariabelAdm.php">Co-Variable</a></li>
              <li role="presentation"><a href="variabelmediatorAdm.php">Variabel Mediator</a></li>
              <li role="presentation"><a href="variabelmoderatorAdm.php">Variabel Moderator</a></li>
            </ul>
            <div class="panel panel-info">
              <div class="panel-heading">
                <ul class="list">
                  <li>Berikut adalah list Variabel Tesis (X dan Y) yang telah digunakan.</li>
                  <li>Variabel yang belum diverifikasi tidak dapat digunakan (diinputkan) oleh mahasiswa.</li>
                  <li>Silahkan tekan button pada kolom Opsi untuk melihat dan konfigurasi data.</li>
                </ul>
              </div>
              <div class="panel-body">
                <form method="post" action="variabelxyAdm.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="variabelxyAdm.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr class="success">
                        <th rowspan="2" width="4%" class="text-center" style="vertical-align:middle;">No.</th>
                        <th rowspan="2" width="44%" class="text-center" style="vertical-align:middle;">Nama Variabel X dan Y</th>
                        <th colspan="2" class="text-center">Telah Digunakan pada Variabel (Kali)</th>
                        <th rowspan="2" class="text-center" width="14%">Validasi</th>
                        <th rowspan="2" width="10%" class="text-center" style="vertical-align:middle;">Opsi</th>
                      </tr>
                      <tr class="success">
                        <th width="14%" class="text-center">X</th>
                        <th width="14%" class="text-center">Y</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id=$data['id'];
                        
                        $qx1 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_x1='$id'";
                        $rx1 = mysqli_query($GLOBALS["___mysqli_ston"], $qx1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dx1 = mysqli_fetch_assoc($rx1);
                        $jumX1=$dx1['jum'];
                        
                        $qx2 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_x2='$id'";
                        $rx2 = mysqli_query($GLOBALS["___mysqli_ston"], $qx2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dx2 = mysqli_fetch_assoc($rx2);
                        $jumX2=$dx2['jum'];
                        
                        $qx3 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_x3='$id'";
                        $rx3 = mysqli_query($GLOBALS["___mysqli_ston"], $qx3)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dx3 = mysqli_fetch_assoc($rx3);
                        $jumX3=$dx3['jum'];
                        
                        $qy1 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_y1='$id'";
                        $ry1 = mysqli_query($GLOBALS["___mysqli_ston"], $qy1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dy1 = mysqli_fetch_assoc($ry1);
                        $jumY1=$dy1['jum'];
                        
                        $qy2 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_y2='$id'";
                        $ry2 = mysqli_query($GLOBALS["___mysqli_ston"], $qy2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dy2 = mysqli_fetch_assoc($ry2);
                        $jumY2=$dy2['jum'];
                        
                        $qy3 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE variable_y3='$id'";
                        $ry3 = mysqli_query($GLOBALS["___mysqli_ston"], $qy3)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dy3 = mysqli_fetch_assoc($ry3);
                        $jumY3=$dy3['jum'];

                        $sumX=$jumX1 + $jumX2 + $jumX3;
                        $sumY=$jumY1 + $jumY2 + $jumY3;
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no;?></td>
                        <td><?php echo $data['nm'];?></td>
                        <td class="text-center"><?php echo $sumX;?></td>
                        <td class="text-center"><?php echo $sumY;?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                        <?php if($data['cek']==1 OR $data['cek']==2 AND ($sumX==0 AND $sumY==0)) { echo 
                          "<label for='' class='sr-only'>Validasi</label>
                          <form class='' style='margin-bottom:0px;' action='updateVerifikasiVariableXy.php' method='post'>
                            <input type='text' class='sr-only' name='id' value='".$id."'>
                            <input type='text' class='sr-only' name='page' value='".$page."'>
                            <select name='cek' class='form-control input-sm' onchange='this.form.submit();' required>";?>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM  mag_opsi_verifikasi ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $data['cek'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                              <?php echo
                            "</select>
                          </form>";}
                          else { echo 
                          "<label for='' class='sr-only'>Validasi</label>
                          <form class='' style='margin-bottom:0px;' action=''>
                            <select class='form-control input-sm' disabled>";?>
                            <?php
                              $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM  mag_opsi_verifikasi ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $data['cek'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                              <?php echo
                            "</select>
                          </form>";}?>
                        </td>
                        <td class="text-center">
                          <?php if($data['cek']==1 AND ($sumX==0 AND $sumY==0)) { echo
                            "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                            </button>
                            <a class='btn btn-default' href='deleteVariabelxyAdm.php?id=".$id."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}
                            else { echo 
                            "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                            </button>
                            <button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                            </button>"
                            ;}?>
                        </td>
                      </tr>
                      <?php
                        $i++; 
                        $count++;
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Edit variabel X dan Y baru</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $( '#modalEdit' ).on( 'show.bs.modal', function ( event ) {
      var button = $( event.relatedTarget )
      var recipient = button.data( 'whatever' )
      var modal = $( this );
      var dataString = 'id=' + recipient;
      
      $.ajax( {
      type: "GET",
      url: "editVariabelxyAdm.php",
      data: dataString,
      cache: false,
      success: function ( data ) {
      console.log( data );
      modal.find( '.isiModalEdit' ).html( data );
      },
      error: function ( err ) {
      console.log( err );
      }
      } );
      } );
    </script>
  </body>
</html>