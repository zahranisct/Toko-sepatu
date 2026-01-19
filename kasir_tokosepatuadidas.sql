-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Jan 2026 pada 06.47
-- Versi server: 8.0.30
-- Versi PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_tokosepatuadidas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `transaksi_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `harga` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `qty`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(12, 7, 11, 2, 1400000, 2800000, '2026-01-06 04:33:59', '2026-01-06 04:33:59'),
(13, 7, 1, 1, 2500000, 2500000, '2026-01-06 04:33:59', '2026-01-06 04:33:59'),
(14, 8, 2, 1, 700000, 700000, '2026-01-06 04:37:14', '2026-01-06 04:37:14'),
(15, 8, 8, 1, 1250000, 1250000, '2026-01-06 04:37:14', '2026-01-06 04:37:14'),
(16, 9, 1, 1, 2500000, 2500000, '2026-01-07 04:26:47', '2026-01-07 04:26:47'),
(17, 9, 10, 2, 1550000, 3100000, '2026-01-07 04:26:47', '2026-01-07 04:26:47'),
(18, 9, 15, 1, 1650000, 1650000, '2026-01-07 04:26:47', '2026-01-07 04:26:47'),
(19, 10, 13, 1, 1000000, 1000000, '2026-01-07 07:39:23', '2026-01-07 07:39:23'),
(20, 10, 6, 1, 1500000, 1500000, '2026-01-07 07:39:23', '2026-01-07 07:39:23'),
(21, 10, 1, 3, 2500000, 7500000, '2026-01-07 07:39:23', '2026-01-07 07:39:23'),
(22, 11, 15, 2, 1650000, 3300000, '2026-01-07 11:28:07', '2026-01-07 11:28:07'),
(23, 11, 1, 1, 2500000, 2500000, '2026-01-07 11:28:07', '2026-01-07 11:28:07'),
(24, 12, 14, 10, 1500000, 15000000, '2026-01-09 01:59:52', '2026-01-09 01:59:52'),
(25, 15, 6, 5, 1500000, 7500000, '2026-01-09 04:29:05', '2026-01-09 04:29:05'),
(27, 17, 17, 1, 800000, 800000, '2026-01-09 06:34:42', '2026-01-09 06:34:42'),
(28, 17, 9, 5, 2000000, 10000000, '2026-01-09 06:34:42', '2026-01-09 06:34:42'),
(29, 18, 2, 2, 700000, 1400000, '2026-01-09 06:39:55', '2026-01-09 06:39:55'),
(30, 19, 5, 5, 1500000, 7500000, '2026-01-12 03:05:19', '2026-01-12 03:05:19'),
(31, 20, 1, 2, 2500000, 5000000, '2026-01-12 04:03:43', '2026-01-12 04:03:43'),
(32, 20, 14, 1, 1500000, 1500000, '2026-01-12 04:03:43', '2026-01-12 04:03:43'),
(33, 21, 8, 5, 1250000, 6250000, '2026-01-14 04:40:38', '2026-01-14 04:40:38'),
(34, 21, 7, 1, 2500000, 2500000, '2026-01-14 04:40:38', '2026-01-14 04:40:38'),
(35, 22, 5, 2, 1500000, 3000000, '2026-01-14 05:02:54', '2026-01-14 05:02:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_kasir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kasir`
--

INSERT INTO `kasir` (`id`, `user_id`, `nama_kasir`, `nomor_hp`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Alden Walker', '086735898655', 'Jl. BackBlue', 'aktif', '2025-12-12 06:51:23', '2026-01-07 11:20:02'),
(2, 6, 'Ariana Fellician', '087562975644', 'Jl. SeacretViolet', 'aktif', '2025-12-12 07:13:17', '2025-12-12 07:13:17'),
(5, 4, 'Zahrani Sweta', '081267895467', 'Pralon', 'aktif', '2026-01-09 03:01:33', '2026-01-09 03:01:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kategori` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `nama_kategori`, `kode_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Sepatu Lifestyle', 'LFS', '2025-12-11 02:21:09', '2025-12-17 08:18:55'),
(2, 'Sepatu Running', 'RUN', '2025-12-11 03:45:08', '2025-12-17 08:19:04'),
(5, 'Sepatu Training', 'TRN', '2025-12-17 08:29:49', '2025-12-17 08:29:49'),
(6, 'Sepatu Sepak Bola', 'SOC', '2025-12-17 08:30:13', '2025-12-17 08:30:13'),
(7, 'Sepatu Basket', 'BKT', '2025-12-17 08:31:34', '2025-12-17 08:31:34'),
(8, 'Sepatu Outdoor', 'OUT', '2025-12-17 08:32:03', '2025-12-17 08:32:03'),
(9, 'Sepatu Skateboarding', 'SKT', '2025-12-17 08:32:33', '2025-12-17 08:32:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_stok`
--

CREATE TABLE `log_stok` (
  `id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `stok_awal` int NOT NULL,
  `stok_berubah` int NOT NULL,
  `stok_akhir` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_09_020613_create_user_table', 2),
(5, '2025_12_09_021025_create_kategori_produk_table', 2),
(6, '2025_12_09_021037_create_produk_table', 2),
(7, '2025_12_09_021048_create_transaksi_table', 2),
(8, '2025_12_09_021100_create_detail_transaksi_table', 2),
(9, '2025_12_09_021135_create_log_stok_table', 2),
(10, '2025_12_12_130055_create_kasirs_table', 3),
(11, '2025_12_24_064807_add_kasir_id_to_transaksi_table', 4),
(12, '2026_01_09_093339_add_timestamps_to_user_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `harga` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_produk` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `nama_produk`, `stok`, `harga`, `created_at`, `updated_at`, `kode_produk`, `model`, `warna`) VALUES
(1, 1, 'Samba', 92, 2500000, '2025-12-11 06:33:50', '2026-01-12 04:03:43', 'LFS-SMB-WHT-2', 'SMB', 'WHT'),
(2, 1, 'Superstar', 96, 700000, '2025-12-11 06:47:56', '2026-01-09 06:39:55', 'LFS-SPR-WHT', 'SPR', 'WHT'),
(5, 2, 'Ultraboost', 93, 1500000, '2025-12-17 08:37:46', '2026-01-14 05:02:54', 'RUN-ULT-WTH', 'ULTR', 'WTH'),
(6, 2, 'Adizero', 94, 1500000, '2025-12-17 08:38:36', '2026-01-09 04:29:05', 'RUN-ADZ-BLK-2', 'ADZ', 'BLK'),
(7, 2, 'Solarboost', 99, 2500000, '2025-12-17 08:39:45', '2026-01-14 04:40:38', 'RUN-SBT-WTH-2', 'SBT', 'WTH'),
(8, 5, 'Alphatorsion', 94, 1250000, '2025-12-17 08:40:35', '2026-01-14 04:40:38', 'TRN-ALP-BLK-2', 'ALP', 'BLK'),
(9, 6, 'Predator', 95, 2000000, '2025-12-17 08:41:43', '2026-01-09 06:34:42', 'SOC-PDT-WHT-2', 'PDT', 'WHT'),
(10, 1, 'Stan Smith', 98, 1550000, '2025-12-17 08:43:04', '2026-01-07 04:26:47', 'LFS-STS-BLU-2', 'STS', 'BLU'),
(11, 6, 'D.O.N.', 98, 1400000, '2025-12-17 08:43:43', '2026-01-06 04:33:59', 'SOC-DON-BLK-2', 'DON', 'BLK'),
(12, 8, 'Terrex', 100, 1800000, '2025-12-17 08:44:36', '2025-12-17 08:48:53', 'OUT-TRX-BLK-2', 'TRX', 'BLK'),
(13, 9, 'Busenitz', 99, 1000000, '2025-12-17 08:45:31', '2026-01-07 07:39:23', 'SKT-BUS-BLK-2', 'BUS', 'BLK'),
(14, 9, '3ST', 89, 1500000, '2025-12-17 08:46:05', '2026-01-12 04:03:43', 'SKT-3ST-WTH-2', '3ST', 'WTH'),
(15, 7, 'Harden', 97, 1650000, '2025-12-17 08:50:02', '2026-01-07 11:28:07', 'BKT-HRD-RED', 'HRD', 'RED'),
(16, 6, 'X', 100, 1700000, '2025-12-17 08:50:54', '2026-01-09 05:27:03', 'SOC-X-GRN-2', 'X', 'GRN'),
(17, 5, 'CrazyTrain', 98, 800000, '2025-12-17 08:52:06', '2026-01-09 06:34:42', 'TRN-CRZ-WHT', 'CRZ', 'WHT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('oeGlQ94Oi5slL6AEg3DVVOLpidnmQRyyQBV6KXX6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiME1vS3lyZzNlTzFGaGNLRkI1YlgzUkhDTTV3S3I4R0V5NW1WTnpqeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuIjtzOjU6InJvdXRlIjtzOjEzOiJhZG1pbi5sYXBvcmFuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1768527936);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kasir_id` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int NOT NULL,
  `metode_bayar` enum('cash','qris') COLLATE utf8mb4_unicode_ci NOT NULL,
  `uang_tunai` int DEFAULT NULL,
  `kembalian` int DEFAULT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `kasir_id`, `kode_transaksi`, `total_harga`, `metode_bayar`, `uang_tunai`, `kembalian`, `tanggal_transaksi`, `created_at`, `updated_at`) VALUES
(7, 3, 1, 'TRX-1767674039', 5300000, 'qris', 5300000, 0, '2026-01-06 11:33:59', '2026-01-06 04:33:59', '2026-01-06 04:33:59'),
(8, 3, 2, 'TRX-1767674234', 1950000, 'cash', 2000000, 50000, '2026-01-06 11:37:14', '2026-01-06 04:37:14', '2026-01-06 04:37:14'),
(9, 3, 1, 'TRX-1767760007', 7250000, 'qris', 7250000, 0, '2026-01-07 11:26:47', '2026-01-07 04:26:47', '2026-01-07 04:26:47'),
(10, 3, 1, 'TRX-1767771563', 10000000, 'qris', 10000000, 0, '2026-01-07 14:39:23', '2026-01-07 07:39:23', '2026-01-07 07:39:23'),
(11, 3, 1, 'TRX-1767785287', 5800000, 'cash', 6000000, 200000, '2026-01-07 18:28:07', '2026-01-07 11:28:07', '2026-01-07 11:28:07'),
(12, 3, 2, 'TRX-1767923992', 15000000, 'cash', 15000000, 0, '2026-01-09 08:59:52', '2026-01-09 01:59:52', '2026-01-09 01:59:52'),
(15, 6, 2, 'TRX-3F2C91-1767932945', 7500000, 'cash', 8000000, 500000, '2026-01-09 11:29:05', '2026-01-09 04:29:05', '2026-01-09 04:29:05'),
(17, 5, 1, 'TRX-781E37-1767940482', 10800000, 'cash', 10800000, 0, '2026-01-09 13:34:42', '2026-01-09 06:34:42', '2026-01-09 06:34:42'),
(18, 5, 1, 'TRX-0A8D6D-1767940795', 1400000, 'cash', 1500000, 100000, '2026-01-09 13:39:55', '2026-01-09 06:39:55', '2026-01-09 06:39:55'),
(19, 5, 1, 'TRX-52FFFE-1768187119', 7500000, 'cash', 8000000, 500000, '2026-01-12 10:05:19', '2026-01-12 03:05:19', '2026-01-12 03:05:19'),
(20, 6, 2, 'TRX-9E3C64-1768190623', 6500000, 'cash', 6500000, 0, '2026-01-12 11:03:43', '2026-01-12 04:03:43', '2026-01-12 04:03:43'),
(21, 6, 2, 'TRX-844D0D-1768365638', 8750000, 'qris', 8750000, 0, '2026-01-14 11:40:38', '2026-01-14 04:40:38', '2026-01-14 04:40:38'),
(22, 5, 1, 'TRX-133402-1768366974', 3000000, 'cash', 3000000, 0, '2026-01-14 12:02:54', '2026-01-14 05:02:54', '2026-01-14 05:02:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Adidas', 'adminadidas', '$2y$12$giRJzfwmvAVuJdlMii9z3eG4XSpjGV59DQMpCinKF8WVFrjev.wqW', 'admin', '2026-11-25 02:39:07', '2025-11-25 02:39:07'),
(3, 'Kasir Adidas', 'kasiradidas', '$2y$12$VRQO/lEPoueyUcGGai.cpeT0poYYTH0rcayNIltRu9HakcXvykrFa', 'kasir', '2025-12-05 02:40:49', '2025-12-05 02:40:49'),
(5, 'Alden Walker', 'AldenWalker', '$2y$12$/w3Uwc7o/htbZt8F9Kw3l.AtZBMVFSUrsNFW26jkXTngremrCJLG6', 'kasir', '2025-12-10 03:16:20', '2025-12-10 03:16:20'),
(6, 'Ariana Fellician', 'ArianaFellician', '$2y$12$FWXcrOcvNHN09XMaoDKm4eZRTlaHDj.vXqUQb2QZKe.TrIEVgg./y', 'kasir', '2025-12-10 03:35:27', '2025-12-10 03:35:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksi_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksi_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_stok`
--
ALTER TABLE `log_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_stok_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`),
  ADD KEY `produk_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksi_user_id_foreign` (`user_id`),
  ADD KEY `transaksi_kasir_id_foreign` (`kasir_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `log_stok`
--
ALTER TABLE `log_stok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log_stok`
--
ALTER TABLE `log_stok`
  ADD CONSTRAINT `log_stok_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `kasir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
