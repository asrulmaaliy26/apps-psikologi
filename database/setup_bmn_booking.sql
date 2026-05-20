-- SQL Migration for BMN Room Booking Feature

-- Create bmn_ruangan_booking table
CREATE TABLE IF NOT EXISTS `bmn_ruangan_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kondisi` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create bmn_peminjaman_ruangan table
CREATE TABLE IF NOT EXISTS `bmn_peminjaman_ruangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruangan_id` int(11) NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `admin_comment` text DEFAULT NULL,
  `booking_token` varchar(100) NOT NULL,
  `original_ruangan_id` int(11) DEFAULT NULL,
  `original_tanggal` date DEFAULT NULL,
  `original_jam_mulai` time DEFAULT NULL,
  `original_jam_selesai` time DEFAULT NULL,
  `has_changes` tinyint(1) NOT NULL DEFAULT 0,
  `changes_detail` text DEFAULT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ruangan_id` (`ruangan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
