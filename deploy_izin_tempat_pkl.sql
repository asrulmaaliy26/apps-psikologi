-- Tambahan kolom file persetujuan dari krisis center untuk fitur Izin Tempat PKL 
-- pada tabel sitp

ALTER TABLE `sitp` ADD COLUMN `file_persetujuan` varchar(100) DEFAULT NULL;

-- Ubah kolom tgl_dikeluarkan agar bisa bernilai NULL (untuk kompatibilitas MySQL strict mode)
ALTER TABLE `sitp` MODIFY `tgl_dikeluarkan` date DEFAULT NULL;
