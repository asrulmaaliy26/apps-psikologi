-- Create table for Lab Booking Periods (managed by assistants)
CREATE TABLE IF NOT EXISTS `lab_booking_periode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan_id` int(11) DEFAULT NULL,
  `info_tenaga` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Closed, 1: Open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create table for Lab Booking Data (submitted by students)
CREATE TABLE IF NOT EXISTS `lab_booking_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori_peserta` varchar(50) DEFAULT NULL,
  `jml_orang` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `keperluan_alat` text DEFAULT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `tipe_alat` varchar(255) DEFAULT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `periode_id` (`periode_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
