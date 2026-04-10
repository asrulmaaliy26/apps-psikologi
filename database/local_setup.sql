-- Setup database lokal (MySQL/MariaDB, user root, password kosong)
-- Jalankan di phpMyAdmin tab SQL, atau: mysql -u root < database/local_setup.sql

CREATE DATABASE IF NOT EXISTS `db_apps-psi`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Beberapa skrip di psychoApps memakai nama DB `psikologi` (sudah root + password kosong di kode)
CREATE DATABASE IF NOT EXISTS `psikologi`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
