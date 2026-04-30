CREATE TABLE IF NOT EXISTS `org_mhs_kat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `org_mhs_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `org_mhs_personalia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(50) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nim` (`nim`),
  KEY `kat_id` (`kat_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default roles
INSERT INTO `org_mhs_role` (`nm`) VALUES ('Ketua'), ('Sekretaris'), ('Bendahara'), ('Anggota') ON DUPLICATE KEY UPDATE nm=nm;
