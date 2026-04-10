<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  ?>
<div class="panel panel-info">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
        <thead>
          <tr class="success">
            <th width="2%" class="text-center">No.</th>
            <th width="36%" class="text-center">Periode seminar proposal tesis</th>
            <th width="14%" class="text-center">Tgl. pendaftaran</th>
            <th width="18%" class="text-center">Status</th>
            <th width="30%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            $qry = "select * from mag_peserta_sempro WHERE nim='$nim'";
            $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            while($md = mysqli_fetch_assoc( $has )) {
            $id=$md['id'];
            $no++;
            
            $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$md[id_sempro]'";
            $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
            $data = mysqli_fetch_assoc($hasil);
            $id_sempro=$data['id'];
            $thp=$data['tahap'];
            $ta=$data['ta'];
            
            $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
            $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
            $dthp = mysqli_fetch_assoc($hasil);
            
            $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
            $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
            $dnta = mysqli_fetch_assoc($hasil);
            
            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
            $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
            $dsemester = mysqli_fetch_assoc($h);
            ?>
          <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td class="text-center"><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']."";?></td>
            <td class="text-center"><?php echo $md['tgl_pendaftaran'];?></td>
            <td class="text-center"><?php if($md['cek']==1) { echo "Belum diverifikasi"; } else { echo "<code>Telah diverifikasi</code>"; }?></td>
            <td class="text-center">
              <button class='btn btn-sm btn-primary' title='Lebih detail' data-toggle='modal' data-target='#modalDetail' data-whatever='<?php echo $md['id']?>'><span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span> Detail</button>
              <a role="button" href="cetakPendSemproUser.php?id=<?php echo $md['id']?>" class="btn btn-default" title="Cetak pendaftaran" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
              <?php if($md['cek']==1) { echo
                "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$md[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>
                  <a class='btn btn-default' href='deletePendSemproUser.php?id=".$md['id']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";}
                     else { echo 
                     "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                      </button>
                      <button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                     </button>"
                ;}?>
              <button class='btn btn-danger btn-sm' title='Lihat catatan' data-toggle='modal' data-target='#modalCatatan' data-whatever='<?php echo $md['id'];?>'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span> Catatan</button>       
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalDetail" aria-labelledby="labelModalDetail" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalDetail">Detail Pendaftaran Seminar Proposal Tesis</h4>
      </div>
      <div class="modal-body">
        <div class="isiModalDetail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalEdit">Form Edit Pendaftaran Seminar Proposal Tesis</h4>
      </div>
      <div class="modal-body">
        <div class="isiModalEdit"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalCatatan" aria-labelledby="labelModalCatatan" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalCatatan">Catatan Pendaftaran Seminar Proposal Tesis</h4>
      </div>
      <div class="modal-body">
        <div class="isiModalCatatan"></div>
      </div>
    </div>
  </div>
</div>

