<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  $angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'angkatan' ] );
  ?>
<div class="table-responsive">
  <table class="table custom">
    <tbody>
      <?php
        $qdm = "SELECT * FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan' AND smt_daftar='1' AND status='1' ORDER BY nama ASC";
        $rdm = mysqli_query($GLOBALS["___mysqli_ston"], $qdm)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($ddm = mysqli_fetch_assoc($rdm)) {
        ?>			  
      <tr>
        <td width="12%" class="text-left" style="vertical-align:top;">
          <img src="<?php echo $ddm['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddm['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
        </td>
        <td width="88%" class="text-left" style="vertical-align:top; padding-right:0px;">
          <div class="table-responsive">
            <table class="table table-condensed custom" style="font-size:13px;">
              <tbody>
                <tr>
                  <td width="18%" class="text-left" style="border-top:0px;">Nama</td>
                  <td width="2%" class="text-center" style="border-top:0px;">:</td>
                  <td width="80%" class="text-left" style="border-top:0px;"><?php echo $ddm['nama'];?></td>
                </tr>
                <tr>
                  <td class="text-left">NIM</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddm['nim'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Kontak</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddm['kntk'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Email</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddm['email'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Alamat Asal</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddm['alamat_ktp'];?></td>
                </tr>
                <tr>
                  <td class="text-left">Alamat di Malang</td>
                  <td class="text-center">:</td>
                  <td class="text-left"><?php echo $ddm['alamat_malang'];?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
      <?php
        }
        ?>
    </tbody>
  </table>
</div>