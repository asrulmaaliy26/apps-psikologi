<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $myquery = "SELECT * from dt_pegawai WHERE id='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  
  $myquery = "SELECT * from peserta_ujskrip WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qformnilai = "SELECT * from nilai_ujskrip WHERE id_pendaftaran='$dt[id]'";
  $rfn = mysqli_query($con,  $qformnilai )or die( mysqli_error($con) );
  $dfn = mysqli_fetch_assoc( $rfn );
  
  $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$dt[id_ujskrip]'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_array($res_grade);
  
  $sqlmhssw =  "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
  $rmhssw = mysqli_query($con, $sqlmhssw);
  $dmhssw = mysqli_fetch_array($rmhssw);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Penilaian</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a href="dashboardBeritaAcaraUjskrip.php?page=<?php echo $page;?>">Ujian Skripsi</a></li>
                  <li class="breadcrumb-item active small">Form Berita Acara</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Berita Acara</h4>
                    <span class="small float-right"> <?php echo $dmhssw['nama'].' ['.$dmhssw['nim'].']';?></span>
                  </div>
                  <div class="card-body">
                    <?php include ("petunjukPengisianBaUjskrip.php");?>
                    <div class="table-responsive">
                      <table class="table table-sm custom mb-0">
                        <thead>
                          <tr>
                            <th width="2%" class="text-center pl-1">No.</th>
                            <th width="48%" class="text-center">Aspek Penilaian</th>
                            <th colspan="10" class="text-center pr-1">Pilihan Nilai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <form action="updateBa1UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">1.</td>
                              <td class="text-left"><?php include ("itemPenilaian1BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==1) { echo '<button name="sekretaris1" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris1" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==2) { echo '<button name="sekretaris1" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris1" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==3) { echo '<button name="sekretaris1" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris1" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==4) { echo '<button name="sekretaris1" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris1" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==5) { echo '<button name="sekretaris1" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris1" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==6) { echo '<button name="sekretaris1" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris1" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==7) { echo '<button name="sekretaris1" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris1" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==8) { echo '<button name="sekretaris1" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris1" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris1']==9) { echo '<button name="sekretaris1" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris1" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%" class="pr-1"><?php if($dfn['sekretaris1']==10) { echo '<button name="sekretaris1" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris1" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa2UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">2.</td>
                              <td class="text-left"><?php include ("itemPenilaian2BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==1) { echo '<button name="sekretaris2" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris2" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==2) { echo '<button name="sekretaris2" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris2" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==3) { echo '<button name="sekretaris2" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris2" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==4) { echo '<button name="sekretaris2" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris2" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==5) { echo '<button name="sekretaris2" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris2" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==6) { echo '<button name="sekretaris2" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris2" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==7) { echo '<button name="sekretaris2" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris2" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==8) { echo '<button name="sekretaris2" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris2" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==9) { echo '<button name="sekretaris2" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris2" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris2']==10) { echo '<button name="sekretaris2" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris2" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa3UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">3.</td>
                              <td class="text-left"><?php include ("itemPenilaian3BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==1) { echo '<button name="sekretaris3" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris3" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==2) { echo '<button name="sekretaris3" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris3" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==3) { echo '<button name="sekretaris3" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris3" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==4) { echo '<button name="sekretaris3" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris3" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==5) { echo '<button name="sekretaris3" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris3" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==6) { echo '<button name="sekretaris3" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris3" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==7) { echo '<button name="sekretaris3" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris3" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==8) { echo '<button name="sekretaris3" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris3" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==9) { echo '<button name="sekretaris3" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris3" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris3']==10) { echo '<button name="sekretaris3" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris3" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa4UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">4.</td>
                              <td class="text-left"><?php include ("itemPenilaian4BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==1) { echo '<button name="sekretaris4" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris4" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==2) { echo '<button name="sekretaris4" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris4" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==3) { echo '<button name="sekretaris4" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris4" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==4) { echo '<button name="sekretaris4" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris4" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==5) { echo '<button name="sekretaris4" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris4" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==6) { echo '<button name="sekretaris4" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris4" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==7) { echo '<button name="sekretaris4" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris4" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==8) { echo '<button name="sekretaris4" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris4" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==9) { echo '<button name="sekretaris4" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris4" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris4']==10) { echo '<button name="sekretaris4" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris4" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa5UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">5.</td>
                              <td class="text-left"><?php include ("itemPenilaian5BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==1) { echo '<button name="sekretaris5" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris5" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==2) { echo '<button name="sekretaris5" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris5" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==3) { echo '<button name="sekretaris5" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris5" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==4) { echo '<button name="sekretaris5" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris5" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==5) { echo '<button name="sekretaris5" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris5" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==6) { echo '<button name="sekretaris5" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris5" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==7) { echo '<button name="sekretaris5" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris5" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==8) { echo '<button name="sekretaris5" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris5" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==9) { echo '<button name="sekretaris5" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris5" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris5']==10) { echo '<button name="sekretaris5" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris5" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa6UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">6.</td>
                              <td class="text-left"><?php include ("itemPenilaian6BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==1) { echo '<button name="sekretaris6" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris6" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==2) { echo '<button name="sekretaris6" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris6" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==3) { echo '<button name="sekretaris6" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris6" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==4) { echo '<button name="sekretaris6" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris6" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==5) { echo '<button name="sekretaris6" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris6" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==6) { echo '<button name="sekretaris6" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris6" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==7) { echo '<button name="sekretaris6" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris6" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==8) { echo '<button name="sekretaris6" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris6" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==9) { echo '<button name="sekretaris6" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris6" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris6']==10) { echo '<button name="sekretaris6" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris6" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa7UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">7.</td>
                              <td class="text-left"><?php include ("itemPenilaian7BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==1) { echo '<button name="sekretaris7" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris7" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==2) { echo '<button name="sekretaris7" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris7" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==3) { echo '<button name="sekretaris7" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris7" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==4) { echo '<button name="sekretaris7" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris7" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==5) { echo '<button name="sekretaris7" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris7" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==6) { echo '<button name="sekretaris7" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris7" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==7) { echo '<button name="sekretaris7" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris7" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==8) { echo '<button name="sekretaris7" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris7" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==9) { echo '<button name="sekretaris7" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris7" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris7']==10) { echo '<button name="sekretaris7" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris7" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa8UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">8.</td>
                              <td class="text-left"><?php include ("itemPenilaian8BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==1) { echo '<button name="sekretaris8" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris8" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==2) { echo '<button name="sekretaris8" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris8" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==3) { echo '<button name="sekretaris8" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris8" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==4) { echo '<button name="sekretaris8" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris8" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==5) { echo '<button name="sekretaris8" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris8" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==6) { echo '<button name="sekretaris8" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris8" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==7) { echo '<button name="sekretaris8" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris8" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==8) { echo '<button name="sekretaris8" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris8" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==9) { echo '<button name="sekretaris8" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris8" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris8']==10) { echo '<button name="sekretaris8" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris8" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa9UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">9.</td>
                              <td class="text-left"><?php include ("itemPenilaian9BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==1) { echo '<button name="sekretaris9" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris9" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==2) { echo '<button name="sekretaris9" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris9" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==3) { echo '<button name="sekretaris9" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris9" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==4) { echo '<button name="sekretaris9" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris9" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==5) { echo '<button name="sekretaris9" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris9" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==6) { echo '<button name="sekretaris9" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris9" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==7) { echo '<button name="sekretaris9" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris9" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==8) { echo '<button name="sekretaris9" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris9" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==9) { echo '<button name="sekretaris9" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris9" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris9']==10) { echo '<button name="sekretaris9" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris9" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                          </form>
                          <form action="updateBa10UjskripSekretaris.php" method="post">
                            <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                            <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                            <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                            <tr>
                              <td class="text-center pl-1">10.</td>
                              <td class="text-left"><?php include ("itemPenilaian10BaUjskrip.php");?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==1) { echo '<button name="sekretaris10" value="1" class="btn btn-success btn-xs btn-block" type="input">1</button>';} else { echo '<button name="sekretaris10" value="1" class="btn btn-outline-success btn-xs btn-block" type="input">1</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==2) { echo '<button name="sekretaris10" value="2" class="btn btn-success btn-xs btn-block" type="input">2</button>';} else { echo '<button name="sekretaris10" value="2" class="btn btn-outline-success btn-xs btn-block" type="input">2</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==3) { echo '<button name="sekretaris10" value="3" class="btn btn-success btn-xs btn-block" type="input">3</button>';} else { echo '<button name="sekretaris10" value="3" class="btn btn-outline-success btn-xs btn-block" type="input">3</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==4) { echo '<button name="sekretaris10" value="4" class="btn btn-success btn-xs btn-block" type="input">4</button>';} else { echo '<button name="sekretaris10" value="4" class="btn btn-outline-success btn-xs btn-block" type="input">4</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==5) { echo '<button name="sekretaris10" value="5" class="btn btn-success btn-xs btn-block" type="input">5</button>';} else { echo '<button name="sekretaris10" value="5" class="btn btn-outline-success btn-xs btn-block" type="input">5</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==6) { echo '<button name="sekretaris10" value="6" class="btn btn-success btn-xs btn-block" type="input">6</button>';} else { echo '<button name="sekretaris10" value="6" class="btn btn-outline-success btn-xs btn-block" type="input">6</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==7) { echo '<button name="sekretaris10" value="7" class="btn btn-success btn-xs btn-block" type="input">7</button>';} else { echo '<button name="sekretaris10" value="7" class="btn btn-outline-success btn-xs btn-block" type="input">7</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==8) { echo '<button name="sekretaris10" value="8" class="btn btn-success btn-xs btn-block" type="input">8</button>';} else { echo '<button name="sekretaris10" value="8" class="btn btn-outline-success btn-xs btn-block" type="input">8</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==9) { echo '<button name="sekretaris10" value="9" class="btn btn-success btn-xs btn-block" type="input">9</button>';} else { echo '<button name="sekretaris10" value="9" class="btn btn-outline-success btn-xs btn-block" type="input">9</button>';};?></td>
                              <td width="5%"><?php if($dfn['sekretaris10']==10) { echo '<button name="sekretaris10" value="10" class="btn btn-success btn-xs btn-block" type="input">10</button>';} else { echo '<button name="sekretaris10" value="10" class="btn btn-outline-success btn-xs btn-block" type="input">10</button>';};?></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td colspan="2" class="text-right pl-1"><strong>Total Nilai:</strong></td>
                              <td colspan="2" class="text-right pr-1"><strong><?php include "meanNilaiSekretarisPenilaianUjskrip.php";?></strong></td>
                            </tr>
                          </form>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <div class="col">
                <form action="updateCatatanBaUjskripSekretaris.php" method="post">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <h4 class="card-title">Catatan/Revisi</h4>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $dfn['id'];?>" required readonly>
                      <input type="text" name="id_pendaftaran" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <div class="form-group">
                        <textarea id="textarea-custom-one" name="catatan_sekretaris" class="form-control form-control-sm" style="height: 300px;"><?php echo $dfn['catatan_sekretaris'];?></textarea>
                      </div>
                      <button role="button" type="submit" class="btn btn-sm btn-outline-info">Kirim Catatan/Revisi</button>
                      <a href="dashboardBeritaAcaraUjskrip.php?page=<?php echo $page;?>" class="btn btn-sm btn-outline-danger float-right">Selesai</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>