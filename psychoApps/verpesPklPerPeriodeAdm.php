<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM peserta_pkl WHERE id_pkl='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>Edit berhasil!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifCatatan') {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>Catatan berhasil dikirim!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span>Delete berhasil!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';}  
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pendaftaran PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pndftrnPklAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                  <li class="breadcrumb-item active small">Verifikasi Pendaftar</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Verifikasi Pendaftar</h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="42%">Nama</td>
                            <td width="10%">SKS Terakhir</td>
                            <td width="10%">File Transkrip</td>
                            <td colspan="3" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.id_pkl='$id' ORDER BY dt_mhssw.nama ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                            $rmhssw = mysqli_query($con, $qry_mhssw);
                            $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
                            $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nim='$data[nim]'";
                            $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
                            $dfrek = mysqli_fetch_assoc( $hfrek );
                            
                            $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id'";
                            $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
                            $didper = mysqli_fetch_assoc($ridper);
                            
                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qry_opsi_dpl = "SELECT * FROM dpl_pkl WHERE id_pkl='$id' AND id='$data[id_dpl]'";
                            $res_opsi_dpl = mysqli_query($con, $qry_opsi_dpl);
                            $dt_opsi_dpl = mysqli_fetch_assoc($res_opsi_dpl);

                            $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dt_opsi_dpl[nip]'";
                            $res_dpl = mysqli_query($con, $qry_dpl);
                            $dt_dpl = mysqli_fetch_assoc($res_dpl);

                            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$id'";
                            $res_grade = mysqli_query($con, $qry_grade);
                            $dt_grade = mysqli_fetch_assoc($res_grade);

                            $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
                            $hdt_cek = mysqli_query($con, $qdt_cek);
                            $dcek = mysqli_fetch_assoc($hdt_cek);
                            $no++;
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php if($data['val_adm']==1) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-edit text-warning" title="'.$dcek['nm'].'"></i></div></div>';} else if($data['val_adm']==2) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek['nm'].'"></i></div></div>';} else if($data['val_adm']==3) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-check text-success" title="'.$dcek['nm'].'"></i></div></div>';} else if($data['val_adm']==4) { echo '<div class="clearfix"><div class="float-left">'.$dmhssw['nama'].' / '.$dmhssw['nim'].'</div><div class="float-right"><i class="fas fa-user-times text-dark" title="'.$dcek['nm'].'"></i></div></div>';}?> </td>
                            <td class="text-center"> <?php echo $data['sks_diambil'];?> </td>
                            <td class="text-center"> <?php if(empty($data['file_transkrip'])) { echo '<a class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada file" disabled><i class="fas fa-download"></i> Kosong</a>';} else { echo '<a class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat/download" href="'.$data['file_transkrip'].'" target="_blank"><i class="fas fa-download"></i> Download</a>';}?> </td>
                            <td width="16%" class="text-center pl-1">
                              <?php if($data['statusform']==2) { echo 
                                "<select name='val_adm' class='form-control form-control-xs' title='Tidak bisa diverifikasi! Sudah ada DPL' required disabled>";?>
                              <?php
                                $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi ORDER BY nm ASC" );
                                while ( $w = mysqli_fetch_array( $tampil ) ) {
                                  if ( $data['val_adm'] == $w[ 'id' ] ) {
                                    echo "<option value='$w[id]' selected>$w[nm]</option>";
                                  } else {
                                    echo "<option value='$w[id]'>$w[nm]</option>";
                                  }
                                } 
                                "</select>";}
                                else { include "opsiVerpesPklPerPeriodeAdm.php";}?>
                            </td>
                            <td width="10%" class="text-center"><a href="catatanPesPklPerPeriodeAdm.php?id=<?php echo $id;?>&id_pendaftar=<?php echo $data['id'];?>&nim=<?php echo $data['nim'];?>&page=<?php echo $page;?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Beri catatan"><i class="far fa-comment-alt"></i> Beri Catatan</a></td>
                            <td width="4%" class="text-center pr-1">
                              <?php if($data['val_adm'] == '2' && $data['statusform'] != '1') { echo '<a href="#" type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak bisa dihapus! Sudah ada DPL\')" title="Tidak bisa dihapus! Sudah ada DPL"><i class="fas fa-trash-alt"></i></a>';} else { echo '<a href="deletePesPklPerPeriodeAdm.php?id='.$id.'&id_pendaftar='.$data['id'].'&page='.$page.'" type="button" class="btn btn-outline-danger btn-flat btn-xs btn-block" onclick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';}?>
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="7"> <?php include('detailPesPklAdm.php');?> </td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>