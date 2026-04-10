<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  
  $qps = "SELECT * FROM mag_peserta_sempro WHERE id='$id'";
  $rps = mysqli_query($GLOBALS["___mysqli_ston"], $qps)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dps = mysqli_fetch_assoc($rps);
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$dps[id_sempro]'";
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
  
  $qpdpt = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$dps[nim]'";
  $rpdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qpdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dpdpt = mysqli_fetch_assoc($rpdpt);
  
  $qdpt1 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$dpdpt[dospem_tesis1]'";
  $ddpt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt1 = mysqli_fetch_assoc($ddpt1);
  
  $qdpt2 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$dpdpt[dospem_tesis2]'";
  $ddpt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt2 = mysqli_fetch_assoc($ddpt2);  
  
  $qry_grade = "SELECT * FROM mag_grade_sempro WHERE id_sempro='$dps[id_sempro]'";
  $res_grade = mysqli_query($GLOBALS["___mysqli_ston"], $qry_grade);
  $dt_grade = mysqli_fetch_array($res_grade);

  $qnilai =  "SELECT * FROM mag_nilai_sempro WHERE id_pendaftaran='$id'";
  $rnilai = mysqli_query($GLOBALS["___mysqli_ston"], $qnilai);
  $dnilai = mysqli_fetch_array($rnilai);
                            
  if($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 3;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 2;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji4']) / 1;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1']) / 1;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2']) / 2;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3']) / 3;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 3;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji4']) / 3;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji4']) / 2;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3']) / 2;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji3']) / 2;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji2'] + $dnilai['nilai_penguji4']) / 2;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1']) / 1;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji2']) / 1;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji3']) / 1;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji4']) / 1;}
  elseif($dnilai['nilai_penguji1']=='0' && $dnilai['nilai_penguji2']=='0' && $dnilai['nilai_penguji3']=='0' && $dnilai['nilai_penguji4']=='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 4;}
  elseif($dnilai['nilai_penguji1']!='0' && $dnilai['nilai_penguji2']!='0' && $dnilai['nilai_penguji3']!='0' && $dnilai['nilai_penguji4']!='0') {
  $nilaiakhir = ($dnilai['nilai_penguji1'] + $dnilai['nilai_penguji2'] + $dnilai['nilai_penguji3'] + $dnilai['nilai_penguji4']) / 4;}
  ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading text-center">Pendaftaran Seminar Proposal Tesis</div>
      <div class="table-responsive">
        <table class="table custom">
          <tr>
            <th width="28%" class="text-left">Periode pendaftaran</th>
            <td width="3%" class="text-center">:</td>
            <td width="69%" class="text-left"><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']."";?></td>
          </tr>
          <tr>
            <th class="text-left">Tanggal pendaftaran</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php echo $dps['tgl_pendaftaran'];?></td>
          </tr>
          <tr>
            <th class="text-left">Status pendaftaran</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php if($dps['cek']==1) { echo 'Belum diverifikasi';} else {echo 'Telah diverifikasi';}?></td>
          </tr>
          <tr>
            <th class="text-left" style="vertical-align:top;">Judul proposal tesis</th>
            <td class="text-center" style="vertical-align:top;">:</td>
            <td class="text-left" style="vertical-align:top;"><?php echo $dps['judul_prop'];?></td>
          </tr>
          <tr>
            <th class="text-left">Dosen pembimbing tesis I</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php echo $ddpt1['nama'];?></td>
          </tr>
          <tr>
            <th class="text-left">Dosen pembimbing tesis II</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php echo $ddpt2['nama'];?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <?php
    $qjdwl = "select * from mag_jadwal_sempro WHERE id='$dps[id_jdwl]'";
    $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qjdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
    $djdwl = mysqli_fetch_assoc($row);
              
    $qpl = "select * from dt_pegawai WHERE id='$djdwl[penguji1]'";
	  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qpl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
	  $dp1 = mysqli_fetch_assoc($row);
              
    $qp2 = "select * from dt_pegawai WHERE id='$djdwl[penguji2]'";
	  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
	  $dp2 = mysqli_fetch_assoc($row);
	  
	  $qp3 = "select * from dt_pegawai WHERE id='$djdwl[penguji3]'";
	  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
	  $dp3 = mysqli_fetch_assoc($row);
	  
	  $qp4 = "select * from dt_pegawai WHERE id='$djdwl[penguji4]'";
	  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qp4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
	  $dp4 = mysqli_fetch_assoc($row);

    $qr = "select * from dt_ruang WHERE id='$djdwl[ruang]'";
	  $row = mysqli_query($GLOBALS["___mysqli_ston"],  $qr )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
	  $dr = mysqli_fetch_assoc($row);
              
    $tanggal=date("d-m-Y", strtotime($djdwl['tgl_seminar']));
	  $day = date('D', strtotime($tanggal));
	  $dayList = array(
	  'Sun' => 'Minggu',
	  'Mon' => 'Senin',
	  'Tue' => 'Selasa',
	  'Wed' => 'Rabu',
	  'Thu' => 'Kamis',
	  'Fri' => "Jum'at",
	  'Sat' => 'Sabtu');
       ?>
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading text-center">Jadwal Seminar Proposal Tesis</div>
      <div class="table-responsive">
        <table class="table custom">
          <tr>
            <th width="28%" class="text-left">Tanggal</th>
            <td width="3%" class="text-center">:</td>
            <td width="69%" class="text-left"><?php if(empty($djdwl['tgl_seminar'])) { echo "Belum diproses"; } else { echo $dayList[$day].', '.$djdwl['tgl_seminar'];}?></td>
          </tr>
          <tr>
            <th class="text-left">Pukul</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php if(empty($djdwl['jam_mulai']) && empty($djdwl['jam_selesai'])) { echo "Belum diproses"; } else { echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'].' WIB.';}?></td>
          </tr>
          <tr>
            <th class="text-left">Ruang</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php if(empty($djdwl['ruang'])) { echo "Belum diproses"; } else { echo $dr['nm'];}?></td>
          </tr>
          <tr>
            <th class="text-left">Penguji Utama</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php if(empty($djdwl['penguji3'])) { echo "Belum diproses"; } else { echo $dp3['nama'];}?></td>
          </tr>
          <tr>
            <th class="text-left">Ketua Penguji</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php if(empty($djdwl['penguji4'])) { echo "Belum diproses"; } else { echo $dp4['nama'];}?></td>
          </tr>
          <tr>
            <th class="text-left">Pembimbing I</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php echo $dp1['nama'];?></td>
          </tr>
          <tr>
            <th class="text-left">Pembimbing II</th>
            <td class="text-center">:</td>
            <td class="text-left"><?php echo $dp2['nama'];?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading text-center">Penilaian dan Hasil Seminar</div>
      <div class="table-responsive">
        <table class="table table-condensed table-bordered custom">
          <thead>
            <tr>
              <th class="text-center" width="20%">Penguji</th>
              <th class="text-center" width="40%">Nilai</th>
              <th class="text-center" width="40%">Nilai Akhir</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">Penguji Utama</td>
              <td class="text-center">
                <?php if($dnilai['nilai_penguji3']=='0') { echo "0"." ";}
                elseif($dnilai['nilai_penguji3'] <= $dt_grade['lt'] && $dnilai['nilai_penguji3'] >= $dt_grade['lb']) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'Lanjut';}
                elseif($dnilai['nilai_penguji3'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji3'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'Lanjut (Revisi)';} 
                elseif($dnilai['nilai_penguji3'] <= $dt_grade['sut'] && $dnilai['nilai_penguji3'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji3'], 2, '.', '').' '.'Seminar Ulang';}?>
              </td>
              <td class="text-center" rowspan="4">
                <code>
                  <?php if($nilaiakhir=='0') { echo "0"." ";}
                  elseif($nilaiakhir <= $dt_grade['lt'] && $nilaiakhir >= $dt_grade['lb']) { echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Lanjut</small>';}
                  elseif($nilaiakhir <= $dt_grade['lrt'] && $nilaiakhir >= $dt_grade['lrb']) { echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Lanjut (Revisi)</small>';} 
                  elseif($nilaiakhir <= $dt_grade['sut'] && $nilaiakhir >= $dt_grade['sub']) { echo number_format((float)$nilaiakhir, 2, '.', '').' '.'<small>Seminar Ulang</small>';}?>
                </code>
              </td>
            </tr>
            <tr>
              <td class="text-center">Ketua Penguji</td>
              <td class="text-center">
                <?php if($dnilai['nilai_penguji4']=='0') { echo "0"." ";}
                elseif($dnilai['nilai_penguji4'] <= $dt_grade['lt'] && $dnilai['nilai_penguji4'] >= $dt_grade['lb']) { echo number_format((float)$dnilai['nilai_penguji4'], 2, '.', '').' '.'Lanjut';}
                elseif($dnilai['nilai_penguji4'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji4'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji4'], 2, '.', '').' '.'Lanjut (Revisi)';} 
                elseif($dnilai['nilai_penguji4'] <= $dt_grade['sut'] && $dnilai['nilai_penguji4'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji4'], 2, '.', '').' '.'Seminar Ulang';}?>
              </td>
            </tr>
            <tr>
              <td class="text-center">Pembimbing I</td>
              <td class="text-center">
                <?php if($dnilai['nilai_penguji1']=='0') { echo "0"." ";}
                elseif($dnilai['nilai_penguji1'] <= $dt_grade['lt'] && $dnilai['nilai_penguji1'] >= $dt_grade['lb']) { echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'Lanjut';}
                elseif($dnilai['nilai_penguji1'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji1'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'Lanjut (Revisi)';} 
                elseif($dnilai['nilai_penguji1'] <= $dt_grade['sut'] && $dnilai['nilai_penguji1'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji1'], 2, '.', '').' '.'Seminar Ulang';}?>
              </td>
            </tr>
            <tr>
              <td class="text-center">Pembimbing II</td>
              <td class="text-center">
                <?php if($dnilai['nilai_penguji2']=='0') { echo "0"." ";}
                elseif($dnilai['nilai_penguji2'] <= $dt_grade['lt'] && $dnilai['nilai_penguji2'] >= $dt_grade['lb']) { echo number_format((float)$dnilai['nilai_penguji2'], 2, '.', '').' '.'Lanjut';}
                elseif($dnilai['nilai_penguji2'] <= $dt_grade['lrt'] && $dnilai['nilai_penguji2'] >= $dt_grade['lrb']) { echo number_format((float)$dnilai['nilai_penguji2'], 2, '.', '').' '.'Lanjut (Revisi)';} 
                elseif($dnilai['nilai_penguji2'] <= $dt_grade['sut'] && $dnilai['nilai_penguji2'] >= $dt_grade['sub']) { echo number_format((float)$dnilai['nilai_penguji2'], 2, '.', '').' '.'Seminar Ulang';}?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading text-center">Catatan Penguji</div>
      <div class="table-responsive">
        <table class="table table-condensed table-bordered custom">
          <thead>
            <tr>
              <th class="text-center" width="20%">Penguji</th>
              <th class="text-center" width="80%">Catatan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">Penguji Utama</td>
              <td><?php echo $dnilai['catatan_penguji3'];?></td>
            </tr>
            <tr>
              <td class="text-center">Ketua Penguji</td>
              <td><?php echo $dnilai['catatan_penguji4'];?></td>
            </tr>
            <tr>
              <td class="text-center">Pembimbing I</td>
              <td><?php echo $dnilai['catatan_penguji1'];?></td>
            </tr>
            <tr>
              <td class="text-center">Pembimbing II</td>
              <td><?php echo $dnilai['catatan_penguji2'];?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>