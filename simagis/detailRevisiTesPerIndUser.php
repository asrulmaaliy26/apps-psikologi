<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
    
  $myquery = "SELECT * FROM mag_revisi_tesis WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qx1 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_x1]'";
  $rx1 = mysqli_query($GLOBALS["___mysqli_ston"],  $qx1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dx1 = mysqli_fetch_assoc( $rx1 );
  
  $qx2 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_x2]'";
  $rx2 = mysqli_query($GLOBALS["___mysqli_ston"],  $qx2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dx2 = mysqli_fetch_assoc( $rx2 );
  
  $qx3 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_x3]'";
  $rx3 = mysqli_query($GLOBALS["___mysqli_ston"],  $qx3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dx3 = mysqli_fetch_assoc( $rx3 );
  
  $qy1 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_y1]'";
  $ry1 = mysqli_query($GLOBALS["___mysqli_ston"],  $qy1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dy1 = mysqli_fetch_assoc( $ry1 );
  
  $qy2 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_y2]'";
  $ry2 = mysqli_query($GLOBALS["___mysqli_ston"],  $qy2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dy2 = mysqli_fetch_assoc( $ry2 );
  
  $qy3 = "SELECT * FROM mag_variablexy WHERE id='$dataku[variable_y3]'";
  $ry3 = mysqli_query($GLOBALS["___mysqli_ston"],  $qy3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dy3 = mysqli_fetch_assoc( $ry3 );
  
  $qc1 = "SELECT * FROM mag_covariable WHERE id='$dataku[co_variable_1]'";
  $rc1 = mysqli_query($GLOBALS["___mysqli_ston"],  $qc1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dc1 = mysqli_fetch_assoc( $rc1 );
  
  $qc2 = "SELECT * FROM mag_covariable WHERE id='$dataku[co_variable_2]'";
  $rc2 = mysqli_query($GLOBALS["___mysqli_ston"],  $qc2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dc2 = mysqli_fetch_assoc( $rc2 );
  
  $qc3 = "SELECT * FROM mag_covariable WHERE id='$dataku[co_variable_3]'";
  $rc3 = mysqli_query($GLOBALS["___mysqli_ston"],  $qc3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dc3 = mysqli_fetch_assoc( $rc3 );
  
  $qmed = "SELECT * FROM mag_mediatorvariable WHERE id='$dataku[mediator]'";
  $rmed = mysqli_query($GLOBALS["___mysqli_ston"],  $qmed )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dmed = mysqli_fetch_assoc( $rmed );
  
  $qmod = "SELECT * FROM mag_moderatorvariable WHERE id='$dataku[moderator]'";
  $rmod = mysqli_query($GLOBALS["___mysqli_ston"],  $qmod )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dmod = mysqli_fetch_assoc( $rmod );
  
  $qjnsp = "SELECT * FROM mag_jns_pen WHERE id='$dataku[jns_penel]'";
  $rjnsp = mysqli_query($GLOBALS["___mysqli_ston"],  $qjnsp )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djnsp = mysqli_fetch_assoc( $rjnsp );
  
  $qjak = "SELECT * FROM mag_jns_alat_ukur WHERE id='$dataku[jns_alat_ukur]'";
  $rjak = mysqli_query($GLOBALS["___mysqli_ston"],  $qjak )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djak = mysqli_fetch_assoc( $rjak );
  
  $qryperiod = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$dataku[id_ujtes]'";
  $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dperiod = mysqli_fetch_assoc($rperiod);
  $tahap = $dperiod['tahap'];
  $ta = $dperiod['ta'];
                         
  $qry_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                         
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                         
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qnm =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim = '$dataku[nim]'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
  $dnm = mysqli_fetch_assoc($r);
  
  $qdpes = "SELECT * FROM mag_peserta_ujtes WHERE id='$dataku[id_peserta]'";
  $rpes = mysqli_query($GLOBALS["___mysqli_ston"], $qdpes)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpes = mysqli_fetch_assoc($rpes);
  
  $qjad = "SELECT * FROM mag_jadwal_ujtes WHERE id_pendaftaran='$dpes[id]'";
  $rjad = mysqli_query($GLOBALS["___mysqli_ston"], $qjad)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $djad = mysqli_fetch_assoc($rjad);
  
  $qruang = "SELECT * FROM dt_ruang WHERE id='$djad[ruang]'";
  $rruang = mysqli_query($GLOBALS["___mysqli_ston"], $qruang)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $druang = mysqli_fetch_assoc($rruang);
  
  $qid1 = "SELECT * FROM dt_pegawai WHERE id='$dpes[dospem_tesis1]'";
  $rid1 = mysqli_query($GLOBALS["___mysqli_ston"], $qid1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $did1 = mysqli_fetch_assoc($rid1);
  
  $qid2 = "SELECT * FROM dt_pegawai WHERE id='$dpes[dospem_tesis2]'";
  $rid2 = mysqli_query($GLOBALS["___mysqli_ston"], $qid2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $did2 = mysqli_fetch_assoc($rid2);
  
  $qpgj1 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji1]'";
  $rpgj1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj1 = mysqli_fetch_assoc($rpgj1);
  
  $qpgj2 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji2]'";
  $rpgj2 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj2 = mysqli_fetch_assoc($rpgj2);
  
  $qpgj3 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji3]'";
  $rpgj3 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj3)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj3 = mysqli_fetch_assoc($rpgj3);
  
  $qpgj4 = "SELECT * FROM dt_pegawai WHERE id='$djad[penguji4]'";
  $rpgj4 = mysqli_query($GLOBALS["___mysqli_ston"], $qpgj4)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpgj4 = mysqli_fetch_assoc($rpgj4);
  
  $qn = "SELECT * FROM mag_nilai_ujtes WHERE id_pendaftaran='$dpes[id]'";
  $rn = mysqli_query($GLOBALS["___mysqli_ston"], $qn)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dn = mysqli_fetch_assoc($rn);
  
  $nilaiakhir = ($dn['mean_nilai_penguji1'] + $dn['mean_nilai_penguji2'] + $dn['mean_nilai_penguji3'] + $dn['mean_nilai_penguji4']) / 4;
  $nilaibulat = round($nilaiakhir);
  ?>
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-2 col-sm-12 col-xs-12">
        <div class="box_1 pull-left hidden-sm hidden-xs">
          <label>
          <img src="<?php echo '/simagis/'.$dnm['photo'];?>" onError="this.onerror=null;this.src='<?php if($dnm['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
        <div class="box_1 center-block hidden-lg hidden-md">
          <label>
          <img src="<?php echo '/simagis/'.$dnm['photo'];?>" onError="this.onerror=null;this.src='<?php if($dnm['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
          </label>
        </div>
      </div>
      <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="panel panel-danger">
          <div class="panel-heading text-center">Detail Data</div>
          <div class="table-responsive">
            <table class="table" style="font-size: 13px;">
              <tbody>
                <tr>
                  <td width="26%" class="text-left">Nama</td>
                  <td width="2%" class="text-center">:</td>
                  <td width="62%" class="text-left"><?php echo $dnm['nama'].' / '.$dnm['nim'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Dospem</td>
                  <td class="text-center">:</td>
                  <td class="text-left">[1]. <?php echo $did1['nama'];?> [2]. <?php echo $did2['nama'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Periode Ujian</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo 'Tahap'.' '.$dthp['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Daftar</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dpes['tgl_pendaftaran'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Ujian</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $djad['tgl_ujian'].', '."Pukul:".' '.$djad['jam_mulai'].'-'.$djad['jam_selesai'].', '."Tempat: ".$druang['nm'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Judul Tesis</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dpes['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dpes['judul_tesis']);?></td>
                </tr>
                <tr>
                  <td class="text-left">Penguji [Nilai]</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo "[Penguji Utama]".' '.$dpgj3['nama'].' ['.$dn['mean_nilai_penguji3'].']';?>
                    <br/>
                    <?php echo "[Ketua Penguji]".' '.$dpgj4['nama'].' ['.$dn['mean_nilai_penguji4'].']';?>
                    <br/>
                    <?php echo "[Pembimbing I]".' '.$dpgj1['nama'].' ['.$dn['mean_nilai_penguji1'].']';?>
                    <br/>
                    <?php echo "[Pembimbing II]".' '.$dpgj2['nama'].' ['.$dn['mean_nilai_penguji2'].']';?>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Nilai Akhir</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php if($nilaibulat >=91 && $nilaibulat <= 100) { echo 'A';} if($nilaibulat >=80 && $nilaibulat <= 90) { echo 'B+';} if($nilaibulat >=70 && $nilaibulat <= 79) { echo 'B';} if($nilaibulat >=60 && $nilaibulat <= 69) { echo 'C+';} if($nilaibulat >=0 && $nilaibulat <= 59) { echo 'C (Tidak Lulus)';}?> (<?php echo $nilaibulat;?>)</td>
                </tr>
                <tr>
                  <td class="text-left">Tgl. Upload Revisi</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dataku['tgl_upload'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Judul Tesis Pasca Revisi</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $dataku['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['judul_tesis']);?>
                    <br/>
                    <code><?php echo 'Variable X1: '.$dx1['nm'].', X2: '.$dx2['nm'].', X3: '.$dx3['nm'];?></code>
                    <br/>
                    <code><?php echo 'Variable Y1: '.$dy1['nm'].', Y2: '.$dy2['nm'].', Y3: '.$dy3['nm'];?></code>
                    <br/>
                    <code><?php echo 'Co-Variable 1: '.$dc1['nm'].', 2: '.$dc2['nm'].', 3: '.$dc3['nm'];?></code>
                    <br/>
                    <code><?php echo 'Mediator Variable: '.$dmed['nm'];?></code>
                    <br/>
                    <code><?php echo 'Mediator Variable: '.$dmod['nm'];?></code>
                    <br/>
                    <code><?php echo 'Jenis Penelitian: '.$djnsp['nm'];?></code>
                    <br/>
                    <code><?php echo 'Jenis Alat Ukur: '.$djak['nm'];?></code>
                    <br/>
                    <code><?php echo 'Keyword 1: '.$dataku['keyword_1'].', 2: '.$dataku['keyword_2'].', 3: '.$dataku['keyword_3'].', 4: '.$dataku['keyword_4'];?></code>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>