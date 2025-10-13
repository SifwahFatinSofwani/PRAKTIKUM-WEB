CREATE DATABASE kipkuliah;
USE kipkuliah;
CREATE TABLE `mahasiswa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(20) NOT NULL UNIQUE,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `agama` ENUM('Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu') NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
  `foto_profil` VARCHAR(255) NOT NULL,
  `foto_sktm` VARCHAR(255) NOT NULL,
  `nilai_rata_rata` DECIMAL(5, 2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);