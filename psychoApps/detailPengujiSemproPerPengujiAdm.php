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
                src="<?php echo '/sikep/'.$data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="">
            </div>
            <h3 class="profile-username text-center"><?php echo $data['nama_tg'];?></h3>
            <p class="text-muted text-center"><?php echo $data['id'];?></p>
            <ul class="list-group list-group-unbordered mb-3 text-left">
              <li class="list-group-item">
                <b>Menjadi Penguji I</b> <a class="float-right"><?php echo "$jumlahData1";?></a>
              </li>
              <li class="list-group-item">
                <b>Menjadi Penguji II</b> <a class="float-right"><?php echo "$jumlahData2";?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profil<?php echo $data['id'];?>" data-toggle="tab">Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#rekap<?php echo $data['id'];?>" data-toggle="tab">Rekap</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="profil<?php echo $data['id'];?>">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                  </div>
                  <div class="card-body">
                    <div class="post text-left">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo '/sikep/'.$data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="user image">
                        <span class="username">
                        <span><?php echo $data['nama'];?></span>
                        </span>
                        <span class="description"><?php echo $data['id'];?></span>
                        <span class="description"><b>Kontak:</b> <?php echo $data['kntk1'];?></span>
                        <span class="description"><b>Email:</b> <?php echo $data['email1'];?></span>
                      </div>
                      <dl>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Mayor</dt>
                        <dd><?php echo $dr['nm'];?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Minor</dt>
                        <dd><?php echo $data['kepakaran_minor'];?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Tren Riset</dt>
                        <dd><?php echo $data['trend_riset']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['trend_riset']);?></dd>
                        <dt><i class="fas fa-user-graduate mr-1"></i> Riset Terkini</dt>
                        <dd><?php echo $data['profil_riset_terkini']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['profil_riset_terkini']);?></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="rekap<?php echo $data['id'];?>">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Penguji pada Periode Terkini </h3>
                  </div>
                  <div class="card-body text-left p-0">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <span class="nav-link text-primary">
                        Menjadi Penguji I <span class="float-right badge bg-primary"><?php echo $jumlahData3;?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-primary">
                        Menjadi Penguji II <span class="float-right badge bg-primary"><?php echo $jumlahData4;?></span>
                        </span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Penguji pada Semua Periode</h3>
                  </div>
                  <div class="card-body text-left p-0">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <span class="nav-link text-danger">
                        Menjadi Penguji I <span class="float-right badge bg-danger"><?php echo "$jumlahData1";?></span>
                        </span>
                      </li>
                      <li class="nav-item">
                        <span class="nav-link text-danger">
                        Menjadi Penguji II <span class="float-right badge bg-danger"><?php echo "$jumlahData2";?></span>
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