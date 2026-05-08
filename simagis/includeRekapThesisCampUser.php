<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $sql = "SELECT tc.*, p.ta FROM mag_peserta_thesis_camp tc 
          JOIN mag_periode_thesis_camp p ON tc.id_periode_thesis_camp = p.id 
          WHERE tc.nim = '$nim' ORDER BY tc.tgl_daftar DESC";
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
  ?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="text-center">Riwayat Pendaftaran Thesis Camp</h4>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Tahun Akademik</th>
            <th>Topik / Judul</th>
            <th>Tahapan</th>
            <th>Tgl Daftar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
              $qry_ta = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_dt_ta WHERE id='$row[ta]'");
              $dta = mysqli_fetch_assoc($qry_ta);
              
              $qry_smt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM opsi_nama_semester WHERE id='$dta[semester]'");
              $dsmt = mysqli_fetch_assoc($qry_smt);
              ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $dsmt['nama'].' '.$dta['ta']; ?></td>
            <td><?php echo $row['topik']; ?></td>
            <td><?php echo $row['tahapan']; ?></td>
            <td><?php echo $row['tgl_daftar']; ?></td>
          </tr>
          <?php } 
            if(mysqli_num_rows($result) == 0) {
              echo "<tr><td colspan='5' class='text-center'>Belum ada riwayat pendaftaran.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
