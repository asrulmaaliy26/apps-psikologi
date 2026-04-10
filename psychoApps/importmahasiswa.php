<?php
//koneksi ke database, username,password  dan nama database menyesuaikan 

require_once __DIR__ . '/db_env.php';
list($dbserver, $dbusername, $dbpassword, $dbname) = psycho_db_config('db_apps-psi');

error_reporting(E_ALL ^ E_DEPRECATED);
($con = mysqli_connect( $dbserver,  $dbusername,  $dbpassword ))or die( mysqli_error($con) );
mysqli_select_db($con, $dbname)or die( mysqli_error($con) );

//memanggil file excel_reader
require "excel_reader.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['mahasiswa']['name']) ;
    move_uploaded_file($_FILES['mahasiswa']['tmp_name'], $target);

// tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['mahasiswa']['name'],0777);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['mahasiswa']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//             kosongkan tabel pegawai
             $truncate ="TRUNCATE TABLE dt_mhssw";
             mysqli_query($con, $truncate);
    };
    
//   import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//    membaca data (kolom ke-1 sd terakhir)
      $nim           = $data->val($i, 1);
      $angkatan  = $data->val($i, 2);
	  $nama           = $data->val($i, 3);
      $tanggal_lahir   = $data->val($i, 4);
      $nama_ayah   = $data->val($i, 5);
      $nama_ibu   = $data->val($i, 6);
      $jenis_kelamin   = $data->val($i, 7);
      $kntk   = $data->val($i, 8);
      $imel   = $data->val($i, 9);
	  $status  = $data->val($i, 10);
      $password  = $data->val($i, 11);

//      setelah data dibaca, masukkan ke tabel mahasiswa sql
      $query = "INSERT into dt_mhssw (nim,angkatan,nama,tanggal_lahir,nama_ayah,nama_ibu,jenis_kelamin,kntk,imel,status,password)values('$nim','$angkatan','$nama','$tanggal_lahir','$nama_ayah','$nama_ibu','$jenis_kelamin','$kntk','$imel','$status',MD5('$password'))";
      $hasil = mysqli_query($con, $query);
    }
    
    if(!$hasil){
//          jika import gagal
          die(mysqli_error($con));
      }else{
//          jika impor berhasil
          echo "Data berhasil diimpor.";
    }
    
//    hapus file xls yang udah dibaca
    unlink($_FILES['mahasiswa']['name']);
}

?>

<form name="myForm" id="myForm" onSubmit="return validateForm()" action="importmahasiswa.php" method="post" enctype="multipart/form-data">
    <input type="file" id="mahasiswa" name="mahasiswa" />
    <input type="submit" name="submit" value="Import" /><br/>
    <label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>
</form>

<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('mahasiswa', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>