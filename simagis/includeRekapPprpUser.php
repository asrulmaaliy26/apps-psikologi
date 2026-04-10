<?php
  include( "koneksiUser.php" );
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Berikut adalah peminatan rumpun psikologi yang Anda pilih.</li>
      <li>Peminatan rumpun psikologi yang telah Anda pilih dapat diedit sebelum diverifikasi oleh admin.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pengajuan Peminatan Rumpun Psikologi
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_pprp";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
        <thead>
          <tr class="success">
            <th width="43%" class="text-center">Peminatan rumpun psikologi</th>
            <th width="21%" class="text-center">Tgl. pengajuan</th>
            <th width="24%" class="text-center">Status pengajuan</th>
            <th width="12%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $qry = "select * from mag_pengelompokan_rumpun WHERE nim='$dataku[nim]'";
            $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $data = mysqli_fetch_assoc( $has );
            
            $q = "select * from mag_opsi_rumpun WHERE id='$data[rumpun]'";
            $c = mysqli_query($GLOBALS["___mysqli_ston"],  $q )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            $d = mysqli_fetch_assoc( $c );						
            ?>
          <tr>
            <td class="text-center"><?php echo $d['nm'];?></td>
            <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
            <td class="text-center"><?php if($data['cek']==1) { echo "Belum diverifikasi"; } else { echo "<code>Telah diverifikasi</code>"; }?></td>
            <td class="text-center">
              <?php if($data['cek']==1) { echo
                "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                </button>";}
                else { echo 
                "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                </button>";}?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>