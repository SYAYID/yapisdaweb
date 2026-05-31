-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 11:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yapisdaweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamats`
--

CREATE TABLE `alamats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kampung_ktp` varchar(255) NOT NULL,
  `rt_ktp` varchar(255) NOT NULL,
  `rw_ktp` varchar(255) NOT NULL,
  `desa_kelurahan_ktp` varchar(255) NOT NULL,
  `kecamatan_ktp` varchar(255) NOT NULL,
  `provinsi_ktp` varchar(255) NOT NULL,
  `domisili_sama_ktp` tinyint(1) NOT NULL DEFAULT 0,
  `kampung_domisili` varchar(255) DEFAULT NULL,
  `rt_domisili` varchar(255) DEFAULT NULL,
  `rw_domisili` varchar(255) DEFAULT NULL,
  `desa_kelurahan_domisili` varchar(255) DEFAULT NULL,
  `kecamatan_domisili` varchar(255) DEFAULT NULL,
  `provinsi_domisili` varchar(255) DEFAULT NULL,
  `status_tempat_tinggal` enum('Milik Sendiri','Sewa','Kontrak','Bersama Keluarga','Asrama','Lainnya') DEFAULT NULL,
  `jarak_ke_sekolah` enum('<1 km','1-3 km','3-5 km','>5 km') DEFAULT NULL,
  `moda_transportasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `kk_area` varchar(255) NOT NULL,
  `kk_number` varchar(16) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `religion` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `previous_school` varchar(255) NOT NULL,
  `major_choice` varchar(255) NOT NULL,
  `citizenship` enum('WNI','WNA') NOT NULL,
  `birth_certificate_number` varchar(255) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `head_circumference` int(11) DEFAULT NULL,
  `siblings_count` int(11) NOT NULL,
  `child_order` int(11) NOT NULL,
  `disability` varchar(255) NOT NULL DEFAULT 'Tidak Ada',
  `parent_ktp_village` varchar(255) NOT NULL,
  `parent_ktp_rt` varchar(255) NOT NULL,
  `parent_ktp_rw` varchar(255) NOT NULL,
  `parent_ktp_subdistrict` varchar(255) NOT NULL,
  `parent_ktp_district` varchar(255) NOT NULL,
  `parent_ktp_city` text DEFAULT NULL,
  `parent_ktp_province` varchar(255) NOT NULL,
  `parent_ktp_residence_status` varchar(255) NOT NULL,
  `parent_ktp_distance_to_school` varchar(255) NOT NULL,
  `parent_ktp_transportation` varchar(255) NOT NULL,
  `same_as_ktp` tinyint(1) NOT NULL DEFAULT 0,
  `current_village` varchar(255) DEFAULT NULL,
  `current_rt` varchar(255) DEFAULT NULL,
  `current_rw` varchar(255) DEFAULT NULL,
  `current_subdistrict` varchar(255) DEFAULT NULL,
  `current_district` varchar(255) DEFAULT NULL,
  `current_city` text DEFAULT NULL,
  `current_province` varchar(255) DEFAULT NULL,
  `current_residence_status` varchar(255) DEFAULT NULL,
  `current_distance_to_school` varchar(255) DEFAULT NULL,
  `current_transportation` varchar(255) DEFAULT NULL,
  `father_nik` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `father_birth_place` varchar(255) NOT NULL,
  `father_birth_date` date NOT NULL,
  `father_education` varchar(255) NOT NULL,
  `father_occupation` varchar(255) NOT NULL,
  `father_income` varchar(255) NOT NULL,
  `father_phone` varchar(255) NOT NULL,
  `father_disability` varchar(255) NOT NULL DEFAULT 'Tidak Ada',
  `mother_nik` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mother_birth_place` varchar(255) NOT NULL,
  `mother_birth_date` date NOT NULL,
  `mother_education` varchar(255) NOT NULL,
  `mother_occupation` varchar(255) NOT NULL,
  `mother_income` varchar(255) NOT NULL,
  `mother_phone` varchar(255) NOT NULL,
  `mother_disability` varchar(255) NOT NULL DEFAULT 'Tidak Ada',
  `has_guardian` tinyint(1) NOT NULL DEFAULT 0,
  `guardian_nik` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_birth_place` varchar(255) DEFAULT NULL,
  `guardian_birth_date` date DEFAULT NULL,
  `guardian_education` varchar(255) DEFAULT NULL,
  `guardian_occupation` varchar(255) DEFAULT NULL,
  `guardian_income` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(255) DEFAULT NULL,
  `guardian_disability` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) NOT NULL,
  `kk_path` varchar(255) NOT NULL,
  `birth_certificate_path` varchar(255) NOT NULL,
  `mother_ktp_path` varchar(255) NOT NULL,
  `father_ktp_path` varchar(255) NOT NULL,
  `guardian_ktp_path` varchar(255) DEFAULT NULL,
  `diploma_path` varchar(255) DEFAULT NULL,
  `report_card_path` varchar(255) NOT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokumens`
--

CREATE TABLE `dokumens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kk_path` varchar(255) NOT NULL,
  `akta_lahir_path` varchar(255) NOT NULL,
  `ktp_ayah_path` varchar(255) DEFAULT NULL,
  `ktp_ibu_path` varchar(255) DEFAULT NULL,
  `ktp_wali_path` varchar(255) DEFAULT NULL,
  `ijazah_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_23_080014_create_siswas_table', 1),
(5, '2026_01_23_080015_create_alamats_table', 1),
(6, '2026_01_23_080015_create_dokumens_table', 1),
(7, '2026_01_23_080015_create_orang_tuas_table', 1),
(8, '2026_01_29_143725_create_applicants_table', 2),
(9, '2026_01_29_143725_create_registrations_table', 3),
(10, '2026_01_29_143725_create_schools_table', 4),
(11, '2026_01_29_183643_add_city_columns_to_applicants_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orang_tuas`
--

CREATE TABLE `orang_tuas` (
  `nik_ayah` varchar(255) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `tempat_lahir_ayah` varchar(255) NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `pendidikan_ayah` varchar(255) NOT NULL,
  `pekerjaan_ayah` varchar(255) NOT NULL,
  `penghasilan_ayah` varchar(255) NOT NULL,
  `hp_ayah` varchar(255) NOT NULL,
  `disabilitas_ayah` varchar(255) DEFAULT NULL,
  `nik_ibu` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `tempat_lahir_ibu` varchar(255) NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `pendidikan_ibu` varchar(255) NOT NULL,
  `pekerjaan_ibu` varchar(255) NOT NULL,
  `penghasilan_ibu` varchar(255) NOT NULL,
  `hp_ibu` varchar(255) NOT NULL,
  `disabilitas_ibu` varchar(255) DEFAULT NULL,
  `ada_wali` tinyint(1) NOT NULL DEFAULT 0,
  `nik_wali` varchar(255) DEFAULT NULL,
  `nama_wali` varchar(255) DEFAULT NULL,
  `tempat_lahir_wali` varchar(255) NOT NULL,
  `tanggal_lahir_wali` date NOT NULL,
  `pendidikan_wali` varchar(255) NOT NULL,
  `pekerjaan_wali` varchar(255) NOT NULL,
  `penghasilan_wali` varchar(255) NOT NULL,
  `hp_wali` varchar(255) NOT NULL,
  `disabilitas_wali` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `major` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL,
  `used_quota` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `major`, `quota`, `used_quota`, `created_at`, `updated_at`) VALUES
(1, 'Akuntansi dan Keuangan Lembaga', 72, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25'),
(2, 'Desain Komunikasi Visual', 108, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25'),
(3, 'Manajemen Perkantoran dan Layanan Bisnis', 144, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25'),
(4, 'Teknik Kendaraan Ringan', 72, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25'),
(5, 'Teknik Komputer dan Jaringan', 144, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25'),
(6, 'Teknik Sepeda Motor', 72, 0, '2026-01-30 00:21:42', '2026-01-30 02:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wilayah_kk` enum('Dalam Wilayah Banten','Luar Wilayah Banten') NOT NULL,
  `no_kk` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu') NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `asal_sekolah` varchar(255) NOT NULL,
  `jurusan_pilihan_1` varchar(255) NOT NULL,
  `jurusan_pilihan_2` varchar(255) NOT NULL,
  `kewarganegaraan` enum('WNI','WNA') NOT NULL,
  `no_akta_lahir` varchar(255) DEFAULT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `lingkar_kepala` int(11) NOT NULL,
  `jumlah_saudara` int(11) NOT NULL,
  `anak_ke` int(11) NOT NULL,
  `disabilitas` varchar(255) DEFAULT NULL,
  `foto_pas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-01-30 00:22:26', '$2y$12$LWb7aNKwmGAH9EaEkAEOGuygCqGPkjgm1OeakGNhqSRL6JVnyym7O', 'zOr0C7E3PC', '2026-01-30 00:22:26', '2026-01-30 00:22:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamats`
--
ALTER TABLE `alamats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alamats_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applicants_registration_number_unique` (`registration_number`),
  ADD UNIQUE KEY `applicants_nik_unique` (`nik`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `dokumens`
--
ALTER TABLE `dokumens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumens_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamats`
--
ALTER TABLE `alamats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokumens`
--
ALTER TABLE `dokumens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamats`
--
ALTER TABLE `alamats`
  ADD CONSTRAINT `alamats_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dokumens`
--
ALTER TABLE `dokumens`
  ADD CONSTRAINT `dokumens_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
