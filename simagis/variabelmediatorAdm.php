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
            $reload = "variabelmediatorAdm.php?pagination=true&keyword=$keyword";
            
            $sql = "SELECT * FROM mag_mediatorvariable WHERE nm LIKE '%$keyword%' ORDER BY nm ASC";
      
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }else{
            $reload = "variabelmediatorAdm.php?pagination=true";
            $sql =  "SELECT * FROM mag_mediatorvariable ORDER BY nm ASC";
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
        <h3 class="text-center text-info">Variabel Mediator Tesis</h3>
        <div class="col-lg-12">
          <div class="row">
            <ul class="nav nav-tabs" style="margin-bottom:10px;">
              <li role="presentation"><a href="variabelxyAdm.php">Variabel Tesis (X dan Y)</a></li>
              <li role="presentation"><a href="covariabelAdm.php">Co-Variable</a></li>
              <li role="presentation" class="active"><a href="variabelmediatorAdm.php">Variabel Mediator</a></li>
              <li role="presentation"><a href="variabelmoderatorAdm.php">Variabel Moderator</a></li>
            </ul>
            <div class="panel panel-info">
              <div class="panel-heading">
                <ul class="list">
                  <li>Berikut adalah list Variabel Mediator Tesis yang telah digunakan.</li>
                  <li>Variabel yang belum diverifikasi tidak dapat digunakan (diinputkan) oleh mahasiswa.</li>
                  <li>Silahkan tekan button pada kolom Opsi untuk melihat dan konfigurasi data.</li>
                </ul>
              </div>
              <div class="panel-body">
                <form method="post" action="variabelmediatorAdm.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="variabelmediatorAdm.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;  font-size:13px;">
                    <thead>
                      <tr class="success">
                        <th width="4%" class="text-center" style="vertical-align:middle;">No.</th>
                        <th width="52%" class="text-center" style="vertical-align:middle;">Nama Variabel Mediator</th>
                        <th width="20%" class="text-center">Telah Digunakan (Kali)</th>
                        <th width="14%" class="text-center">Validasi</th>
                        <th width="10%" class="text-center" style="vertical-align:middle;">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id=$data['id'];
                        
                        $qv1 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE mediator='$id'";
                        $rv1 = mysqli_query($GLOBALS["___mysqli_ston"], $qv1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dv1 = mysqli_fetch_assoc($rv1);
                        $jumV1=$dv1['jum'];
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no;?></td>
                        <td><?php echo $data['nm'];?></td>
                        <td class="text-center"><?php echo $jumV1;?></td>
                        <td class="text-center" style="padding-bottom:2px; padding-top:2px;">
                        <?php if($data['cek']==1 OR $data['cek']==2 AND $jumV1==0) { echo 
                          "<label for='' class='sr-only'>Validasi</label>
                          <form class='' style='margin-bottom:0px;' action='updateVerifikasiMedVariable.php' method='post'>
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
                          <?php if($data['cek']==1 AND $jumV1==0) { echo
                            "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                            </button>
                            <a class='btn btn-default' href='deleteMedVariabelAdm.php?id=".$id."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
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
              <h4 class="modal-title" id="modalEdit">Edit variabel mediator baru</h4>
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
      url: "editMedVariabelAdm.php",
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