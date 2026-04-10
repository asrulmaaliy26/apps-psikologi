<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navBankUser.php";
      include 'paginationUser.php';         
            if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
            $keyword=$_REQUEST['keyword'];
            $reload = "covariabelUser.php?pagination=true&keyword=$keyword";
            
            $sql = "SELECT * FROM mag_covariable WHERE nm LIKE '%$keyword%' ORDER BY nm ASC";
      
            $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
            }else{
            $reload = "covariabelUser.php?pagination=true";
            $sql =  "SELECT * FROM mag_covariable ORDER BY nm ASC";
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
    <div class="container">
      <div class="row">
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
        <h3 class="text-center text-info">Co-Variabel Tesis</h3>
        <div class="col-lg-12">
          <div class="row">
            <ul class="nav nav-tabs" style="margin-bottom:10px;">
              <li role="presentation"><a href="variabelxyUser.php">Variabel Tesis (X dan Y)</a></li>
              <li role="presentation" class="active"><a href="covariabelUser.php">Co-Variable</a></li>
              <li role="presentation"><a href="variabelmediatorUser.php">Variabel Mediator</a></li>
              <li role="presentation"><a href="variabelmoderatorUser.php">Variabel Moderator</a></li>
              <button role="presentation" class="btn btn-success pull-right" title="Input variabel baru" data-toggle="modal" data-target="#inputVar">Input Variabel Baru</button>
            </ul>
            <div class="panel panel-info">
              <div class="panel-heading">
                <ul class="list">
                  <li>Berikut adalah list co-variabel tesis yang telah digunakan.</li>
                  <li>Silahkan cari terlebih dahulu variabel yang dimaksud. Jika telah ada, maka tidak diperlukan input variabel baru. Jika belum ada, silahkan tekan button Input Variabel Baru.</li>
                  <li>Silahkan tekan button pada kolom Opsi untuk mengedit dan menghapus, selama variabel belum digunakan.</li>
                  <li>Jika memilih variabel, disarankan untuk tidak memilih variabel yang sering digunakan.</li>
                </ul>
              </div>
              <div class="panel-body">
                <form method="post" action="covariabelUser.php">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="covariabelUser.php"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
                    <thead>
                      <tr class="success">
                        <th width="4%" class="text-center" style="vertical-align:middle;">No.</th>
                        <th width="54%" class="text-center" style="vertical-align:middle;">Nama co-variabel</th>
                        <th width="32%" class="text-center">Telah digunakan (kali)</th>
                        <th width="10%" class="text-center" style="vertical-align:middle;">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $id=$data['id'];
                        
                        $qv1 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE co_variable_1='$id'";
                        $rv1 = mysqli_query($GLOBALS["___mysqli_ston"], $qv1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dv1 = mysqli_fetch_assoc($rv1);
                        $jumV1=$dv1['jum'];
                        
                        $qv2 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE co_variable_2='$id'";
                        $rv2 = mysqli_query($GLOBALS["___mysqli_ston"], $qv2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dv2 = mysqli_fetch_assoc($rv2);
                        $jumV2=$dv2['jum'];
                        
                        $qv3 = "SELECT COUNT(*) AS jum FROM mag_revisi_tesis WHERE co_variable_3='$id'";
                        $rv3 = mysqli_query($GLOBALS["___mysqli_ston"], $qv3)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dv3 = mysqli_fetch_assoc($rv3);
                        $jumV3=$dv3['jum'];
                        
                        $sumV=$jumV1 + $jumV2 + $jumV3;
                        ?>
                      <tr>
                        <td class="text-center"><?php echo ++$no;?></td>
                        <td><?php echo $data['nm'];?></td>
                        <td class="text-center"><?php echo $sumV;?></td>
                        <td class="text-center">
                          <?php if($sumV==0) { echo
                            "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                            </button>
                            <a class='btn btn-default' href='deleteCovariabelUser.php?id=".$id."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}
                            else { echo 
                            "<button class='btn btn-primary disabled' title='Telah digunakan'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                            </button>
                            <button class='btn btn-primary disabled' title='Telah digunakan'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
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
      <form action="sformCovariabel.php" method="post">
        <div class="modal fade" id="inputVar" tabindex="-1" role="dialog" aria-labelledby="inputVarLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input co-variabel baru</h4>
              </div>
              <div class="modal-body">
                <input type="text" name="cek" class="sr-only" id="cek" value="1" required readonly>
                <input type="text" name="status" class="sr-only" id="status" value="1" required readonly>
                <div class="form-group">
                  <label for="nm">Nama co-variabel baru:</label>
                  <input type="text" name="nm" class="form-control" id="nm" placeholder="Nama co-variabel baru" required>
                </div>
                <div class="checkbox">
                  <label>
                  <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar untuk digunakan sebagaimana mestinya.
                  </label>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Edit co-variabel baru</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script>
      $( '#modalEdit' ).on( 'show.bs.modal', function ( event ) {
      var button = $( event.relatedTarget )
      var recipient = button.data( 'whatever' )
      var modal = $( this );
      var dataString = 'id=' + recipient;
      
      $.ajax( {
      type: "GET",
      url: "editCovariabelUser.php",
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