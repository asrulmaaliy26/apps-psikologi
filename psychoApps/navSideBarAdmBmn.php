<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $d = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dtDosen = mysqli_fetch_assoc($d);
  ?>
<aside <?php include( "main-sidebar-style.php" )?>>
  <?php include( "brandNavAdm.php" );?>
  <div class="sidebar text-xs">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboardAdmBmn.php" class="nav-link">
            <i class="fas fa-chart-line nav-icon"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="dtBarang.php" class="nav-link">
            <i class="fas fa-laptop nav-icon"></i>
            <p>
              Data Barang
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="dtRuang.php" class="nav-link">
            <i class="fas fa-home nav-icon"></i>
            <p>
              Data Ruang
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="dtDir.php" class="nav-link">
            <i class="fas fa-laptop-house nav-icon"></i>
            <p>
              Daftar Inventaris Ruangan (DIR)
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-retweet nav-icon"></i>
            <p>
              Data Peminjaman
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dtPinjamBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Peminjaman Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtBarangKembali.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Barang Kembali</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtBarangDipinjam.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Barang Dipinjam</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtPinjamRuang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Peminjaman Ruang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtRuangKembali.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ruang Kembali</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="dtRuangDipinjam.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Ruang Dipinjam</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-tools nav-icon"></i>
            <p>
              Konfigurasi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="opsiSumDanaPerBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Sumber Dana Perolehan Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiKatBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kategori Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiSubKatBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Sub Kategori Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiMerkBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Merk Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiKonBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kondisi Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiKatRuang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Kategori Ruang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiJenRuang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Jenis Ruang</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fas fa-print nav-icon"></i>
            <p>
              Cetak
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="praCetakDtBarangPerMerk.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cetakDtRuang.php" class="nav-link" target="_blank">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Data Ruang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiSubKatBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Daftar Inventaris Ruangan (DIR)</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiMerkBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Peminjaman Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="opsiKonBarang.php" class="nav-link">
                <i class="text-xs far fa-circle nav-icon"></i>
                <p>Peminjaman Ruang</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>