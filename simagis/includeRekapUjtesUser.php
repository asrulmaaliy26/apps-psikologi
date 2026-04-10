<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Berikut adalah data pendaftaran Ujian Tesis Anda.</li>
      <li>Pendaftaran Ujian Tesis dapat diedit atau dihapus sebelum diverifikasi oleh admin.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pendaftaran Ujian Tesis
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_put";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
        <tr class="success">
          <th width="2%" class="text-center">No.</th>
          <th width="36%" class="text-center">Periode ujian tesis</th>
          <th width="14%" class="text-center">Tgl. pendaftaran</th>
          <th width="18%" class="text-center">Status</th>
          <th width="30%" class="text-center">Opsi</th>
        </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            $qry = "select * from mag_peserta_ujtes WHERE nim='$nim'";
            $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
            while($md = mysqli_fetch_assoc( $has )) {
            $id=$md['id'];
            $no++;
            
            $qry_moment = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$md[id_ujtes]'";
            $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
            $data = mysqli_fetch_assoc($hasil);
            $id_ujtes=$data['id'];
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
              <a role="button" href="cetakPendUjtesUser.php?id=<?php echo $md['id']?>" class="btn btn-default" title="Cetak pendaftaran" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
              <?php if($md['cek']==1) { echo
                "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEdit' data-whatever='$md[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></button>
                  <a class='btn btn-default' href='deletePendUjtesUser.php?id=".$md['id']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";}
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