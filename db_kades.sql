-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 28 Agu 2026 pada 12.31
-- Versi server: 8.0.31
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kades`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `distribusi_logistik`
--

DROP TABLE IF EXISTS `distribusi_logistik`;
CREATE TABLE IF NOT EXISTS `distribusi_logistik` (
  `id_distribusi` int NOT NULL AUTO_INCREMENT,
  `id_logistik` int NOT NULL,
  `id_wilayah` int NOT NULL,
  `id_petugas` int DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `tanggal_distribusi` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('diproses','dikirim','diterima') DEFAULT 'diproses',
  `keterangan` text,
  PRIMARY KEY (`id_distribusi`),
  KEY `id_logistik` (`id_logistik`),
  KEY `id_wilayah` (`id_wilayah`),
  KEY `id_petugas` (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_tps`
--

DROP TABLE IF EXISTS `hasil_tps`;
CREATE TABLE IF NOT EXISTS `hasil_tps` (
  `id_hasil` int NOT NULL AUTO_INCREMENT,
  `id_wilayah` int NOT NULL,
  `id_saksi` int NOT NULL,
  `id_paslon` int NOT NULL,
  `jumlah_suara` int NOT NULL DEFAULT '0',
  `foto_c1` varchar(255) DEFAULT NULL,
  `status_validasi` enum('pending','terverifikasi','ditolak') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hasil`),
  KEY `id_wilayah` (`id_wilayah`),
  KEY `id_saksi` (`id_saksi`),
  KEY `id_paslon` (`id_paslon`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `logistik`
--

DROP TABLE IF EXISTS `logistik`;
CREATE TABLE IF NOT EXISTS `logistik` (
  `id_logistik` int NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) NOT NULL,
  `stok_awal` int NOT NULL DEFAULT '0',
  `stok_tersisa` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_logistik`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paslon`
--

DROP TABLE IF EXISTS `paslon`;
CREATE TABLE IF NOT EXISTS `paslon` (
  `id_paslon` int NOT NULL AUTO_INCREMENT,
  `no_urut` int NOT NULL,
  `nama_calon` varchar(100) NOT NULL,
  `nama_wakil` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_paslon`),
  UNIQUE KEY `no_urut` (`no_urut`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `paslon`
--

INSERT INTO `paslon` (`id_paslon`, `no_urut`, `nama_calon`, `nama_wakil`, `foto`) VALUES
(2, 1, 'Basri', '-', '1787483365_a1601e525e0aeed7d691.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilih`
--

DROP TABLE IF EXISTS `pemilih`;
CREATE TABLE IF NOT EXISTS `pemilih` (
  `id_pemilih` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `usia` int DEFAULT NULL,
  `alamat` text,
  `id_wilayah` int NOT NULL,
  `id_relawan` int DEFAULT NULL,
  `status_pemilih` enum('belum_didata','pasti_pilih','ragu_ragu','lawan') DEFAULT 'belum_didata',
  `keterangan_aspirasi` text,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pemilih`),
  UNIQUE KEY `nik` (`nik`),
  KEY `id_wilayah` (`id_wilayah`),
  KEY `id_relawan` (`id_relawan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemilih`
--

INSERT INTO `pemilih` (`id_pemilih`, `nik`, `nama`, `jenis_kelamin`, `usia`, `alamat`, `id_wilayah`, `id_relawan`, `status_pemilih`, `keterangan_aspirasi`, `updated_at`) VALUES
(2, '7604051206960001', 'Wahyudi', 'L', 40, '-', 1, NULL, 'pasti_pilih', '-', '2026-08-24 14:50:29'),
(3, '7604051206960002', 'Ancu', 'L', 30, '-', 1, 3, 'pasti_pilih', '-', '2026-08-24 15:45:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kordes','relawan','saksi') NOT NULL DEFAULT 'relawan',
  `id_wilayah` int DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `no_hp` (`no_hp`),
  KEY `id_wilayah` (`id_wilayah`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `no_hp`, `password`, `role`, `id_wilayah`, `status_aktif`, `created_at`) VALUES
(1, 'Admin Utama', '081234567890', 'admin123', 'admin', NULL, 1, '2026-08-24 12:23:44'),
(2, 'Budi Santoso', '081299990001', 'password123', 'kordes', 1, 1, '2026-08-24 12:23:44'),
(3, 'Ahmad Rian', '081299990002', 'password123', 'relawan', 1, 1, '2026-08-24 12:23:44'),
(4, 'Dewi Lestari', '081299990003', 'password123', 'relawan', NULL, 1, '2026-08-24 12:23:44'),
(5, 'Siti Aminah', '081299990004', 'password123', 'relawan', 3, 1, '2026-08-24 12:23:44'),
(6, 'Rudi Hermawan', '081299990005', 'password123', 'relawan', 4, 1, '2026-08-24 12:23:44'),
(7, 'Eko Prasetyo', '081299990006', 'password123', 'saksi', 1, 1, '2026-08-24 12:23:44'),
(8, 'Fajar Nugraha', '081299990007', 'password123', 'saksi', NULL, 1, '2026-08-24 12:23:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wilayah`
--

DROP TABLE IF EXISTS `wilayah`;
CREATE TABLE IF NOT EXISTS `wilayah` (
  `id_wilayah` int NOT NULL AUTO_INCREMENT,
  `nama_dusun` varchar(100) NOT NULL,
  `no_tps` int NOT NULL,
  `target_suara` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_wilayah`),
  UNIQUE KEY `dusun_tps` (`nama_dusun`,`no_tps`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `wilayah`
--

INSERT INTO `wilayah` (`id_wilayah`, `nama_dusun`, `no_tps`, `target_suara`, `created_at`) VALUES
(1, 'Dusun Lombok', 1, 150, '2026-08-24 12:22:32'),
(3, 'Dusun Kappung Mesa', 1, 130, '2026-08-24 12:22:32'),
(4, 'Dusun Pukkaipi', 1, 200, '2026-08-24 12:22:32'),
(5, 'Dusun Ambopadang', 1, 150, '2026-08-24 12:22:32'),
(6, 'Dusun Patulang', 1, 120, '2026-08-24 12:22:32'),
(7, 'Dusun Tammewaru', 1, 140, '2026-08-24 12:22:32');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `distribusi_logistik`
--
ALTER TABLE `distribusi_logistik`
  ADD CONSTRAINT `fk_distribusi_logistik` FOREIGN KEY (`id_logistik`) REFERENCES `logistik` (`id_logistik`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_distribusi_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_distribusi_wilayah` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_tps`
--
ALTER TABLE `hasil_tps`
  ADD CONSTRAINT `fk_hasil_paslon` FOREIGN KEY (`id_paslon`) REFERENCES `paslon` (`id_paslon`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hasil_saksi` FOREIGN KEY (`id_saksi`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hasil_wilayah` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemilih`
--
ALTER TABLE `pemilih`
  ADD CONSTRAINT `fk_pemilih_relawan` FOREIGN KEY (`id_relawan`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pemilih_wilayah` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_wilayah` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
