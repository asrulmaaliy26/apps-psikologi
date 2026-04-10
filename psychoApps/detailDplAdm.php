<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);?>
<section class="content pt-2">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                src="<?php echo '/sikep/'.$dt_dpl['photo'];?>" onError="this.onerror=null;this.src='<?php if($dt_dpl['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="">
            </div>
            <h3 class="profile-username text-center"><?php echo $dt_dpl['nama_tg'];?></h3>
            <p class="text-muted text-center"><?php echo $dt_dpl['id'];?></p>
            <ul class="list-group list-group-unbordered mb-3 text-left">
              <li class="list-group-item">
                <b>Peserta PKL</b> <a class="float-right"><?php echo "$jumlahData1";?></a>
              </li>
              <li class="list-group-item">
                <b>Lulus</b> <a class="float-right"><?php echo "$jumlahData4";?></a>
              </li>
              <li class="list-group-item">
                <b>Gagal</b> <a class="float-right"><?php echo "$jumlahData5";?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profil<?php echo $data['id_dpl'];?>" data-toggle="tab">Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#rekap<?php echo $data['id_dpl'];?>" data-toggle="tab">Rekap</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="profil<?php echo $data['id_dpl'];?>">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                  </div>
                  <div class="card-body">
                    <div class="post text-left">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo '/sikep/'.$dt_dpl['photo'];?>" onError="this.onerror=null;this.src='<?php if($dt_dpl['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="user image">
                        <span class="username">
                        <span><?php echo $dt_dpl['nama'];?></span>
                        </span>
                        <span class="description"><?php echo $dt_dpl['id'];?></span>
                        <span class="description"><b>Kontak:</b> <?php echo $dt_dpl['kntk1'];?></span>
                        <span class="description"><b>Email:</b> <?php echo $dt_dpl['email1'];?></span>
                      </div>
                      <dl>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Mayor</dt>
                        <dd><?php echo $dr['nm'];?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Minor</dt>
                        <dd><?php echo $dt_dpl['kepakaran_minor'];?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Tren Riset</dt>
                        <dd><?php echo $dt_dpl['trend_riset']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt_dpl['trend_riset']);?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Riset Terkini</dt>
                        <dd><?php echo $dt_dpl['profil_riset_terkini']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt_dpl['profil_riset_terkini']);?></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="rekap<?php echo $data['id_dpl'];?>">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Rekap Periode Ini</h3>
                  </div>
                  <div class="card-body text-left p-0">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <span class="nav-link text-primary">
                        Peserta PKL <span class="float-right badge bg-primary"><?php echo $jumlahData1;?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-primary">
                        Lulus <span class="float-right badge bg-primary"><?php echo $jumlahData4;?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-primary">
                        Gagal <span class="float-right badge bg-primary"><?php echo $jumlahData5;?></span>
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Rekap Semua Periode</h3>
                  </div>
                  <div class="card-body text-left p-0">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <span class="nav-link text-danger">
                        Peserta PKL <span class="float-right badge bg-danger"><?php echo "$jumlahData3";?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-danger">
                        Lulus <span class="float-right badge bg-danger"><?php echo "$jumlahData6";?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-danger">
                        Gagal <span class="float-right badge bg-danger"><?php echo "$jumlahData7";?></span>
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>