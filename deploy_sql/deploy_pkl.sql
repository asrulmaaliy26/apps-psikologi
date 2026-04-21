CREATE TABLE IF NOT EXISTS `pkl_plot_periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(50) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `status` enum('Buka','Tutup') NOT NULL DEFAULT 'Tutup',
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pkl_penjurusan` (
  `id_penjurusan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penjurusan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_penjurusan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pkl_lembaga` (
  `id_lembaga` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) NOT NULL,
  `id_penjurusan` int(11) NOT NULL,
  `nama_tempat` varchar(150) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `kuota` int(11) NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  PRIMARY KEY (`id_lembaga`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pkl_plot_pendaftar` (
  `id_plot` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `id_lembaga` int(11) NOT NULL,
  `waktu_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_plot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
