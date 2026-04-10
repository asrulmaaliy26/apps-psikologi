<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);?>
<section class="content pt-2">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                src="<?php echo $dmhssw['photo'];?>" onError="this.onerror=null;this.src='<?php if($dmhssw['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">
            </div>
            <h3 class="profile-username text-center"><?php echo $dmhssw['nama'];?></h3>
            <p class="text-muted text-center"><?php echo $dmhssw['nim'];?></p>
            <ul class="list-group list-group-unbordered mb-3 text-left">
              <li class="list-group-item">
                <b>Kontak</b> <a class="float-right"><?php echo $dmhssw['kntk'];?></a>
              </li>
              <li class="list-group-item">
                <b>Email</b> <a class="float-right"><?php echo $dmhssw['imel'];?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detail Pendaftaran</h3>
          </div>
          <div class="card-body text-left pb-0">
            <dl class="row">
              <dt class="col-sm-5">Pendaftaran Ke</dt>
              <dd class="col-sm-7"><?php echo $dfrek['jumData'];?></dd>
              <dt class="col-sm-5">Tanggal Pendaftaran</dt>
              <dd class="col-sm-7"><?php echo $data['tgl_pengajuan'];?></dd>
              <dt class="col-sm-5">Periode Pendaftaran</dt>
              <dd class="col-sm-7"><?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?></dd>
              <dt class="col-sm-5">SKS Terakhir</dt>
              <dd class="col-sm-7"><?php echo $data['sks_diambil'];?></dd>
              <dt class="col-sm-5">Lampiran File</dt>
              <dd class="col-sm-7"><?php if(empty($data['file_transkrip'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs" title="Tidak ada file" disabled><i class="fas fa-download"></i> Kosong</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs" title="Lihat/download" href="'.$data['file_transkrip'].'" target="_blank"><i class="fas fa-download"></i> Transkrip Nilai</a>';}?></dd>
              <dt class="col-sm-5">Riwayat Penyakit</dt>
              <dd class="col-sm-7"><?php echo $data['riwayat_penyakit'];?></dd>
              <dt class="col-sm-5">Status Verifikasi</dt>
              <dd class="col-sm-7"><?php if($data['val_adm']==1) { echo '<span class="bg-warning">'.$dcek['nm'].'</span>';} elseif($data['val_adm']==2) { echo '<span class="bg-primary">'.$dcek['nm'].'</span>';} elseif($data['val_adm']==3) { echo '<span class="bg-danger">'.$dcek['nm'].'</span>';} elseif($data['val_adm']==4) { echo '<span class="bg-danger">'.$dcek['nm'].'<br/> Tanggal Verifikasi: <span class="text-secondary">'.$data['tgl_validasi'].'</span>';}?>
                <br/>
                Tanggal Verifikasi: <span class="text-secondary"><?php echo $data['tgl_validasi'];?></span>
              </dd>
              <dt class="col-sm-5">Catatan</dt>
              <dd class="col-sm-7"><?php if(empty($data['catatan'])) { echo "Tidak ada";} else { echo nl2br($data['catatan']);}?></dd>
              <dt class="col-sm-5">DPL</dt>
              <dd class="col-sm-7"><?php if(empty($dt_opsi_dpl['nip'])) { echo "Belum ada";} else { echo $dt_dpl['nama'];}?></dd>
              <dt class="col-sm-5">Lokasi PKL</dt>
              <dd class="col-sm-7"><?php if(empty($dt_opsi_dpl['lokasi'])) { echo "Belum ada";} else { echo $dt_opsi_dpl['lokasi'];}?></dd>
              <dt class="col-sm-5">Nilai</dt>
              <dd class="col-sm-7"><?php include "nilaiPesPklAdm.php";?></dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>