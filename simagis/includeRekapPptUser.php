<?php
  include( "koneksiUser.php" );
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Berikut adalah Dosen pembimbing tesis yang Anda pilih.</li>
      <li>Dosen pembimbing tesis yang telah Anda pilih dapat diedit sebelum diverifikasi oleh admin.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pengajuan Pembimbing Tesis
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_ppt";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-9">
        <div class="table-responsive">
          <table class="table table-condensed custom">
            <thead>
              <tr class="active">
                <th width="46%">Dosen pembimbing tesis</th>
                <th width="18%" class="text-center">Tgl. pengajuan</th>
                <th width="24%" class="text-center">Status pengajuan</th>
                <th width="12%" class="text-center">Opsi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $qry = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$dataku[nim]'";
                $has = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $data = mysqli_fetch_assoc($has);
                
                $qdw1 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis1]'";
                $rdw1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddw1 = mysqli_fetch_assoc($rdw1);
                
                $qdp1 = "SELECT * FROM dt_pegawai WHERE id='$ddw1[nip]'";
                $rdp1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddp1 = mysqli_fetch_assoc($rdp1);
                
                $qr1 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp1[kepakaran_mayor]'";
                $rr1 = mysqli_query($GLOBALS["___mysqli_ston"], $qr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $dr1 = mysqli_fetch_assoc($rr1);
                
                $qdw2 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis2]'";
                $rdw2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddw2 = mysqli_fetch_assoc($rdw2);
                
                $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$ddw2[nip]'";
                $rdp2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $ddp2 = mysqli_fetch_assoc($rdp2);
                
                $qr2 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp2[kepakaran_mayor]'";
                $rr2 = mysqli_query($GLOBALS["___mysqli_ston"], $qr2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $dr2 = mysqli_fetch_assoc($rr2);
                
                $q = "SELECT nim FROM mag_pengelompokan_dospem_tesis WHERE nim='$data[nim]'";
                $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                $d = mysqli_num_rows($r);
                
                ?>
              <tr class="active">
                <td><?php echo $ddp1['nama'].' <code>(I)</code>';?></td>
                <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                <td class="text-center"><?php if($data['cek1']==1) {echo "Belum diverifikasi";} else if($data['cek1']==2) {echo "<code>Telah diverifikasi</code>";} else {echo "<code>Belum mengajukan</code>";}?></td>
                <td class="text-center">
                  <?php if($d==0) { echo "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                    </button>";} else { echo "<button class='btn btn-warning' title='Detail' data-toggle='modal' data-target='#modalDetailPtPilihanSatu' data-whatever='".$data['id']."'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></button>";} ?>
                  <?php if($data['cek1']==1) { echo
                    "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEditPtPilihanSatu' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                    </button>";}
                    else if($data['cek1']==2) { echo 
                    "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                    </button>";}
                    else { echo
                    "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                    </button>"
                    ;}?>
                </td>
              </tr>
              <tr class="active">
                <td><?php echo $ddp2['nama'].' <code>(II)</code>';?></td>
                <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                <td class="text-center"><?php if($data['cek2']==1) {echo "Belum diverifikasi";} else if($data['cek2']==2) {echo "<code>Telah diverifikasi</code>";} else {echo "<code>Belum mengajukan</code>";}?></td>
                <td class="text-center">
                  <?php if($d==0) { echo "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                    </button>";} else { echo "<button class='btn btn-warning' title='Detail' data-toggle='modal' data-target='#modalDetailPtPilihanDua' data-whatever='".$data['id']."'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></button>";} ?>
                  <?php if($data['cek2']==1) { echo
                    "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEditPtPilihanDua' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                    </button>";}
                    else if($data['cek2']==2) { echo 
                    "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                    </button>";}
                    else { echo
                    "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                    </button>"
                    ;}?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-3">
        <div class="table-responsive">
          <table class="table table-condensed custom">
            <thead>
              <tr class="active">
                <th width="80%" class="text-center">Judul & Outline</th>
                <th width="20%" class="text-center">Opsi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="active">
                <td class="text-center"><?php if($d==0) { echo "<button class='btn btn-warning btn-block btn-sm disabled' title='Belum mengajukan'>Belum mengajukan
                  </button>";} else { echo "<button class='btn btn-sm btn-warning' title='Edit' data-toggle='modal' data-target='#modalJudOut' data-whatever='".$data['id']."'>Lihat judul & outline</button>";}?></td>
                <td class="text-center">
                  <?php if($data['cekjudul']==1) { echo
                    "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEditJudOut' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                    </button>";}
                    else if($data['cekjudul']==2) { echo 
                    "<button class='btn btn-primary disabled' title='Telah diverifikasi'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                    </button>";}
                    else { echo 
                    "<button class='btn btn-default disabled' title='Belum mengajukan'><span class='glyphicon glyphicon-transfer' aria-hidden='true'></span>
                    </button>";}?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="panel panel-danger" style="margin-bottom:0px;">
          <div class="panel-heading text-center">Catatan Pengajuan</div>
          <div class="panel-body">
            <?php echo $data['catatan'];?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-info">
  <div class="panel-heading text-center">
    <span class="lead">Opsi dan Profil Dosen Pembimbing Tesis</span>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-bordered table-hover custom" style="margin-bottom:0px;">
        <thead>
          <tr>
            <th width="4%" class="text-center">No.</th>
            <th width="36%">Nama</th>
            <th width="20%">Rumpun Keilmuan Psi.</th>
            <th width="15%">Kuota Dospem I</th>
            <th width="15%">Kuota Dospem II</th>
            <th width="12%" class="text-center">Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            $qdpt = "SELECT * FROM mag_dospem_tesis WHERE id_periode='$id_periode'";
            $rdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            while($ddpt = mysqli_fetch_assoc($rdpt)) {
            $no++;
                            
            $qp = "SELECT * FROM dt_pegawai WHERE id='$ddpt[nip]'";
            $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dp = mysqli_fetch_assoc($rp);
                            
            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
            $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
            $dr = mysqli_fetch_assoc($rr);                  
            
            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddpt[id]' AND id_periode='$data[id_periode]' AND (cek1='1' OR cek1='2') AND status='1'";
            $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData1 = $dataku1['jumData'];
            $sisa1 = $ddpt['kuota1'] - $jumlahData1;
                            
            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddpt[id]' AND id_periode='$data[id_periode]' AND (cek2='1' OR cek2='2') AND status='1'";
            $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData2 = $dataku2['jumData'];
            $sisa2 = $ddpt['kuota2'] - $jumlahData2;
            ?>
          <tr>
            <td class="text-center"><?php echo $no;?></td>
            <td><?php echo $dp['nama'];?></td>
            <td><?php echo $dr['nm'];?></td>
            <td><?php if($ddpt['kuota1'] - $jumlahData1==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota1'].' (tersisa '.$sisa1.')';}?></td>
            <td><?php if($ddpt['kuota2'] - $jumlahData2==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota2'].' (tersisa '.$sisa2.')';}?></td>
            <td class="text-center">
              <button class="btn btn-sm btn-block btn-success" title="Lebih detail" data-toggle="modal" data-target="#modalDetail" data-whatever="<?php echo $ddpt['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
              </button>
            </td>
          </tr>
          <?php };?>
        </tbody>
      </table>
    </div>
  </div>
</div>