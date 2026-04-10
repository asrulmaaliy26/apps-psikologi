<?php include( "contentsConAdm.php" );
error_reporting(E_ALL & ~E_NOTICE);
$qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
$rmhssw = mysqli_query($con, $qry_mhssw);
$dmhssw = mysqli_fetch_assoc($rmhssw);
                            
$qdt_cekjudul = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$data[cekjudul]'";
$hdt_cekjudul = mysqli_query($con, $qdt_cekjudul);
$dcekjudul = mysqli_fetch_assoc($hdt_cekjudul);

$qidper = "SELECT * FROM pengajuan_dospem WHERE id='$data[id_periode]'";
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

$q_dospem1 = "SELECT * FROM dt_pegawai WHERE id=$data[dospem_skripsi1]";
$rdospem1 = mysqli_query($con, $q_dospem1);
$ddospem1 = mysqli_fetch_assoc($rdospem1);
                            
$q_dospem2 = "SELECT * FROM dt_pegawai WHERE id=$data[dospem_skripsi2]";
$rdospem2 = mysqli_query($con, $q_dospem2);
$ddospem2 = mysqli_fetch_assoc($rdospem2);                         
                            
$qcek1 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$data[cek1]'";
$hcek1 = mysqli_query($con, $qcek1);
$dcek1 = mysqli_fetch_assoc($hcek1);
                            
$qcek2 = "SELECT * FROM opsi_validasi_pengajuan_dospem WHERE id='$data[cek2]'";
$hcek2 = mysqli_query($con, $qcek2);
$dcek2 = mysqli_fetch_assoc($hcek2);
                            
$qsempro = "SELECT * FROM peserta_sempro WHERE nim='$data[nim]'";
$hsempro = mysqli_query($con, $qsempro);
$dsempro = mysqli_fetch_assoc($hsempro);
                        
$qjadwalsempro = "SELECT * FROM jadwal_sempro WHERE id_pendaftaran='$dsempro[id]'";
$hjadwalsempro = mysqli_query($con, $qjadwalsempro);
$djadwalsempro = mysqli_fetch_assoc($hjadwalsempro);
                            
$qnilaisempro = "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$dsempro[id]'";
$hnilaisempro = mysqli_query($con, $qnilaisempro);
$dnilaisempro = mysqli_fetch_assoc($hnilaisempro);
                            
$qpredikatnilaisempro = "SELECT * FROM kategori_rekom_sempro WHERE id='$dnilaisempro[rekom]'";
$hpredikatnilaisempro = mysqli_query($con, $qpredikatnilaisempro);
$dpredikatnilaisempro = mysqli_fetch_assoc($hpredikatnilaisempro);
                            
$qujskrip = "SELECT * FROM peserta_ujskrip WHERE nim='$data[nim]'";
$hujskrip = mysqli_query($con, $qujskrip);
$dujskrip = mysqli_fetch_assoc($hujskrip);

$qjadwalujskrip = "SELECT * FROM jadwal_ujskrip WHERE id_pendaftaran='$dujskrip[id]'";
$hjadwalujskrip = mysqli_query($con, $qjadwalujskrip);
$djadwalujskrip = mysqli_fetch_assoc($hjadwalujskrip);
                            
$qnilaiujskrip = "SELECT * FROM nilai_ujskrip WHERE id_pendaftaran='$dujskrip[id]'";
$hnilaiujskrip = mysqli_query($con, $qnilaiujskrip);
$dnilaiujskrip = mysqli_fetch_assoc($hnilaiujskrip);
$no++;
?>