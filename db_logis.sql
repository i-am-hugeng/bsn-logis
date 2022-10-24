-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2022 at 03:34 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_logis`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identifications`
--

CREATE TABLE `identifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sk_revisi` int(10) UNSIGNED NOT NULL,
  `komtek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekretariat_komtek` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `identifications`
--

INSERT INTO `identifications` (`id`, `id_sk_revisi`, `komtek`, `sekretariat_komtek`, `created_at`, `updated_at`) VALUES
(5, 1, '11-12 - Kaleng Kerupuk', 'adfsadfdfsdfa.<br />\r\ndfgsdgdfgdfgdgsdg.<br />\r\nblabla@cie.com', '2022-09-30 04:54:25', '2022-09-30 04:54:25'),
(6, 4, 'Komtek 65-05 Produk Perikanan', 'Direktorat Pengolahan dan Bina Mutu,<br />\r\nDirektorat Jenderal Penguatan Daya Saing Produk Kelautan dan Perikanan,<br />\r\nKementerian Kelautan dan Perikanan.<br />\r\nsimsonmasengi@hotmail.com<br />\r\nakkh@bsn.go.id', '2022-10-06 01:39:58', '2022-10-06 01:39:58'),
(7, 5, 'Komite Teknis 81-02 - Industri keramik', 'Pusat Standardisasi Industri, Badan Penelitian dan Pengembangan Industri, Kementerian Perindustrian<br />\r\nherry_bogor@yahoo.com<br />\r\nummykalsumade@yahoo.co.id<br />\r\nreginareginess@gmail.com<br />\r\ntalaidin81@gmail.com<br />\r\npustan@kemenperin.go.id<br />\r\ndewita447@gmail.com', '2022-10-06 01:49:30', '2022-10-06 01:49:30'),
(8, 6, '65-05 - Produk Perikanan', 'Sekretariat : Direktorat Pengolahan dan Bina Mutu<br />\r\nAlamat Sekretariat :Jl. Medan Merdeka Timur No. 16 Jakarta Pusat<br />\r\nNo Telp 021-3500149<br />\r\nNo Fax 021-3500149<br />\r\nEmail ratnamariyana@yahoo.com', '2022-10-06 01:52:13', '2022-10-06 01:52:13'),
(9, 7, '65-08 - Produk Perikanan Nonpangan', 'Sekretariat : Dit. Pengolahan dan Bina Mutu<br />\r\nAlamat Sekretariat : Jl. Medan Merdeka Timur No. 16<br />\r\nNo Telp 0213513279<br />\r\nNo Fax 0213513279<br />\r\nEmail sni_ppn@yahoo.com', '2022-10-06 07:10:05', '2022-10-06 07:10:05'),
(10, 11, '91-02 - Kimia Bahan Konstruksi', 'Sekretariat<br />\r\n Pusat Perumusan, Penerapan, dan Pemberlakuan Standardisasi Industri - Badan Standardisasi dan Kebijakan Jasa Industri - Kementerian Perindustrian', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(11, 10, '31-01 - Elektronika Untuk Keperluan Rumah Tangga', 'Sekretariat<br />\r\n Pusat Standardisasi, Badan Penelitian dan Pengembangan Industri Departemen Perindustrian', '2022-10-10 07:50:33', '2022-10-10 07:50:33'),
(12, 8, '13-04 - Kendaraan dan Peralatan Pemadam Kebakaran', 'Sekretariat<br />\r\n Direktorat Pengembangan Standar Infrastruktur, Penilaian Kesesuaian, Personal dan Ekonomi Kreatif', '2022-10-10 07:51:46', '2022-10-10 07:51:46'),
(13, 12, '65-05 Produk Perikanan', 'Direktorat Pengolahan dan Bina Mutu<br />\r\nDirektorat Jenderal Penguatan Daya Saing Produk Kelautan dan Perikanan<br />\r\nKementerian Kelautan dan Perikanan<br />\r\nsimsonmasengi@hotmail.com<br />\r\nakkh@bsn.go.id', '2022-10-11 05:52:44', '2022-10-11 05:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_materials`
--

CREATE TABLE `meeting_materials` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_meeting_schedule` int(10) UNSIGNED NOT NULL,
  `nmr_sni_lama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jdl_sni_lama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_sni_lama` int(11) DEFAULT NULL,
  `status_nodin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meeting_materials`
--

INSERT INTO `meeting_materials` (`id`, `id_meeting_schedule`, `nmr_sni_lama`, `jdl_sni_lama`, `status_sni_lama`, `status_nodin`, `created_at`, `updated_at`) VALUES
(1, 1, 'SNI TEST 1234-1:2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl (Part:1)', 0, 1, NULL, '2022-10-06 06:39:16'),
(2, 1, 'SNI TEST 1234-2:2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl (Part:2)', 0, 1, NULL, '2022-10-06 06:39:16'),
(3, 1, 'SNI 03-0680-1998', 'TANDAS JONGKOK JENIS VITORUS CINA', 1, 1, NULL, '2022-10-06 04:24:19'),
(4, 1, 'SNI 2802:2015', 'AGAR-AGAR TEPUNG', 1, 1, NULL, '2022-10-06 04:24:19'),
(5, 2, 'SNI 8090:2014', 'PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN SEGAR', 1, 0, NULL, '2022-10-06 06:38:20'),
(6, 2, 'SNI 8091:2014', 'PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN BEKU', 0, 0, NULL, '2022-10-06 06:38:20'),
(7, 3, 'KARAGINAN MURNI - BAGIAN 1: KAPPA (K) KARAGINAN MURNI METODE PENJENDALAN KCL - SYARAT MUTU DAN PENGOLAHAN', 'KARAGINAN MURNI (REFINED CARRAGEENAN) - BAGIAN 1: KAPPA KARAGINAN - SYARAT MUTU DAN PENGOLAHAN', 0, 0, NULL, '2022-10-10 04:24:32'),
(8, 4, 'SNI 03-2156-1991', 'BLOK BETON RINGAN BERGELEMBUNG UDARA (AIRATED) DENGAN PROSES OTOKLAP', 1, 1, NULL, '2022-10-10 07:23:07'),
(9, 5, 'SNI 03-3988-1995', 'PENGUJIAN KEMAMPUAN PEMADAMAN DAN PENILAIAN ALAT PEMADAM API RINGAN', 1, 0, NULL, '2022-10-10 07:58:49'),
(11, 6, 'SNI lEC 62321:2015', 'PRODUK ELEKTROTEKNIK - PENENTUAN KADAR ENAM UNSUR YANG DIREGULASI (TIMBAL, AIR RAKSA, KADMIUM, KROMIUM HEKSAVALEN, BIFENIL POLIBROMINAT, ETER DIFENIL POLIBROMINAT)', 1, 0, NULL, '2022-10-10 12:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_schedules`
--

CREATE TABLE `meeting_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `pic_rapat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_rapat` date NOT NULL,
  `status_pembahasan` int(11) NOT NULL,
  `status_nodin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meeting_schedules`
--

INSERT INTO `meeting_schedules` (`id`, `pic_rapat`, `tanggal_rapat`, `status_pembahasan`, `status_nodin`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Khairuddin', '2022-10-20', 1, 1, '2022-10-06 02:33:46', '2022-10-06 06:39:16'),
(2, 'Arsanti Rakhasiwi', '2022-10-26', 1, 0, '2022-10-06 06:36:56', '2022-10-06 06:38:20'),
(3, 'Aya Sofa Novia', '2022-11-03', 1, 0, '2022-10-06 07:13:34', '2022-10-10 04:24:32'),
(4, 'Aya Sofa Novia', '2022-10-20', 1, 1, '2022-10-10 07:10:22', '2022-10-10 07:23:07'),
(5, 'Refiano Andores', '2022-10-31', 1, 0, '2022-10-10 07:52:34', '2022-10-10 07:58:49'),
(6, 'Aya Sofa Novia', '2022-11-14', 1, 0, '2022-10-10 12:19:37', '2022-10-10 12:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_07_27_010297_create_transition_times_table', 1),
(6, '2022_07_27_010299_create_standard_implementers_table', 1),
(7, '2022_07_27_010300_create_old_standards_table', 1),
(8, '2022_07_27_010310_create_identifications_table', 1),
(9, '2022_07_27_010311_create_revision_decrees_table', 1),
(10, '2022_08_19_164445_create_meeting_materials_table', 1),
(11, '2022_08_19_164521_create_official_memo_histories_table', 1),
(12, '2022_08_19_164522_create_official_memos_table', 1),
(13, '2022_08_19_164526_create_meeting_schedules_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `official_memos`
--

CREATE TABLE `official_memos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_meeting_schedule` int(10) UNSIGNED NOT NULL,
  `nmr_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_nodin` int(11) NOT NULL,
  `nmr_kepka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `official_memos`
--

INSERT INTO `official_memos` (`id`, `id_meeting_schedule`, `nmr_surat`, `jenis_nodin`, `nmr_kepka`, `created_at`, `updated_at`) VALUES
(1, 1, '189/ND/SPSPK/10/2022', 1, '123/KEPKA-BSN/TRANSISI/10/2022', '2022-10-06 04:24:19', '2022-10-06 04:25:52'),
(2, 1, '123/KEPKA-BSN/ABOLISI/10/2022', 0, '123/KEPKA-BSN/ABOLISI/10/2022', '2022-10-06 06:39:16', '2022-10-06 06:40:09'),
(3, 4, '123/ND-SPSPK/TRANSISI/10/2022', 1, '234/KEPKA-BSN/10/2022', '2022-10-10 07:23:07', '2022-10-10 07:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `official_memo_histories`
--

CREATE TABLE `official_memo_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_official_memo` int(10) UNSIGNED NOT NULL,
  `status_nodin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `official_memo_histories`
--

INSERT INTO `official_memo_histories` (`id`, `id_official_memo`, `status_nodin`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '2022-10-06 04:24:19', '2022-10-06 04:24:19'),
(2, 1, 1, '2022-10-06 04:24:37', '2022-10-06 04:24:37'),
(3, 1, 2, '2022-10-06 04:24:47', '2022-10-06 04:24:47'),
(4, 1, 3, '2022-10-06 04:24:56', '2022-10-06 04:24:56'),
(5, 1, 4, '2022-10-06 04:25:05', '2022-10-06 04:25:05'),
(6, 1, 5, '2022-10-06 04:25:13', '2022-10-06 04:25:13'),
(7, 1, 6, '2022-10-06 04:25:52', '2022-10-06 04:25:52'),
(8, 2, 0, '2022-10-06 06:39:16', '2022-10-06 06:39:16'),
(9, 2, 1, '2022-10-06 06:39:25', '2022-10-06 06:39:25'),
(10, 2, 2, '2022-10-06 06:39:31', '2022-10-06 06:39:31'),
(11, 2, 3, '2022-10-06 06:39:37', '2022-10-06 06:39:37'),
(12, 2, 4, '2022-10-06 06:39:43', '2022-10-06 06:39:43'),
(13, 2, 5, '2022-10-06 06:39:48', '2022-10-06 06:39:48'),
(14, 2, 6, '2022-10-06 06:40:09', '2022-10-06 06:40:09'),
(15, 3, 0, '2022-10-10 07:23:07', '2022-10-10 07:23:07'),
(16, 3, 1, '2022-10-10 07:24:45', '2022-10-10 07:24:45'),
(17, 3, 2, '2022-10-10 07:24:53', '2022-10-10 07:24:53'),
(18, 3, 3, '2022-10-10 07:24:58', '2022-10-10 07:24:58'),
(19, 3, 4, '2022-10-10 07:25:04', '2022-10-10 07:25:04'),
(20, 3, 5, '2022-10-10 07:25:10', '2022-10-10 07:25:10'),
(21, 3, 6, '2022-10-10 07:25:48', '2022-10-10 07:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `old_standards`
--

CREATE TABLE `old_standards` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sk_revisi` int(10) UNSIGNED NOT NULL,
  `nmr_sni_lama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jdl_sni_lama` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `old_standards`
--

INSERT INTO `old_standards` (`id`, `id_sk_revisi`, `nmr_sni_lama`, `jdl_sni_lama`, `created_at`, `updated_at`) VALUES
(1, 1, 'SNI TEST 1234-1:2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl (Part:1)', NULL, '2022-09-27 03:11:37'),
(2, 1, 'SNI TEST 1234-2:2012', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl (Part:2)', NULL, '2022-09-27 03:11:37'),
(3, 2, 'SNI 0039:2013', 'PIPA BAJA SALURAN AIR DENGAN ATAU TANPA LAPISAN SENG', NULL, '2022-10-06 01:04:56'),
(4, 3, 'SNI 7796:2013', 'ALAT\r\nPENANGKAPAN IKAN - BOUKE AMI PADA KAPAL 10 GT - 30 GT', NULL, '2022-10-06 00:51:01'),
(5, 4, 'SNI 8090:2014', 'PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN SEGAR', NULL, NULL),
(6, 4, 'SNI 8091:2014', 'PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN BEKU', NULL, NULL),
(7, 5, 'SNI 03-0680-1998', 'TANDAS JONGKOK JENIS VITORUS CINA', NULL, NULL),
(8, 6, 'SNI 2802:2015', 'AGAR-AGAR TEPUNG', NULL, NULL),
(9, 7, 'KARAGINAN MURNI - BAGIAN 1: KAPPA (K) KARAGINAN MURNI METODE PENJENDALAN KCL - SYARAT MUTU DAN PENGOLAHAN', 'KARAGINAN MURNI (REFINED CARRAGEENAN) - BAGIAN 1: KAPPA KARAGINAN - SYARAT MUTU DAN PENGOLAHAN', NULL, NULL),
(10, 8, 'SNI 03-3988-1995', 'PENGUJIAN KEMAMPUAN PEMADAMAN DAN PENILAIAN ALAT PEMADAM API RINGAN', NULL, NULL),
(11, 10, 'SNI lEC 62321:2015', 'PRODUK ELEKTROTEKNIK - PENENTUAN KADAR ENAM UNSUR YANG DIREGULASI (TIMBAL, AIR RAKSA, KADMIUM, KROMIUM HEKSAVALEN, BIFENIL POLIBROMINAT, ETER DIFENIL POLIBROMINAT)', NULL, NULL),
(12, 11, 'SNI 03-2156-1991', 'BLOK BETON RINGAN BERGELEMBUNG UDARA (AIRATED) DENGAN PROSES OTOKLAP', NULL, NULL),
(13, 12, 'SNI 2694:2013', 'SURIMI', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `revision_decrees`
--

CREATE TABLE `revision_decrees` (
  `id` int(10) UNSIGNED NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nmr_sk_sni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian_sk` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `tanggal_terima` date NOT NULL,
  `nmr_sni_baru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jdl_sni_baru` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_sni_baru` year(4) NOT NULL,
  `status_proses_pic` int(11) NOT NULL,
  `status_bahan_rapat` int(11) NOT NULL,
  `sifat_sni` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `revision_decrees`
--

INSERT INTO `revision_decrees` (`id`, `pic`, `nmr_sk_sni`, `uraian_sk`, `tanggal_sk`, `tanggal_terima`, `nmr_sni_baru`, `jdl_sni_baru`, `tahun_sni_baru`, `status_proses_pic`, `status_bahan_rapat`, `sifat_sni`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Khairuddin', '123/SK-SNI/BSN/08/2022', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl, tristique et nibh id, lacinia volutpat nisi. Aliquam pellentesque mauris faucibus nulla condimentum ultrices. Nam elementum tellus non sodales placerat. Nullam sagittis arcu sit amet vestibulum lacinia. Ut porttitor iaculis massa, vel accumsan elit malesuada eget.', '2022-08-17', '0000-00-00', 'SNI TEST 1234:2022', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus nisl', 2022, 1, 0, 1, '2022-09-27 03:10:04', '2022-09-30 04:54:25'),
(2, 'Ahmad Khairuddin', '18/KEP/BSN/2/2022', 'SNI 39:2022 PIPA BAJA DENGAN ATAU TANPA LAPISAN SENG UNTUK SALURAN AIR DAN INSTALASI GAS SEBAGAI REVISI DARI SNI 0039:2013 PIPA BAJA SALURAN AIR DENGAN ATAU TANPA LAPISAN SENG', '2022-02-14', '2022-03-02', 'SNI 39:2022', 'PIPA BAJA DENGAN ATAU TANPA LAPISAN SENG UNTUK SALURAN AIR DAN INSTALASI GAS', 2022, 1, 0, 0, '2022-09-27 03:32:50', '2022-10-06 01:15:44'),
(3, 'Ahmad Khairuddin', '721/KEP/BSN/12/2021', 'SNI 7796:2021 ALAT PENANGKAPAN IKAN - BOUKE AMI PADA KAPAL 10 GT - 30 GT SEBAGAI REVISI DARI SNI 7796:2013 ALAT PENANGKAPAN IKAN - BOUKE AMI PADA KAPAL 10 GT - 30 GT', '2021-12-31', '0000-00-00', 'SNI 7796:2021', 'ALAT PENANGKAPAN IKAN - BOUKE AMI PADA KAPAL 10 GT - 30 GT', 2021, 1, 0, 0, '2022-10-06 00:48:45', '2022-10-06 00:51:28'),
(4, 'Arsanti Rakhasiwi', '722/KEP/BSN/12/2021', 'SNI 9026:2021 KAPAL PERIKANAN - PALKA IKAN SEGAR DAN IKAN BEKU PADA KAPAL PENANGKAP IKAN SEBAGAI REVISI DARI SNI 8090:2014 PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN SEGAR DAN SNI 8091:2014 PENANGANAN IKAN DI ATAS KAPAL - FASILITAS PALKA IKAN BEKU', '2021-12-31', '2022-01-10', 'SNI 9026:2021', 'KAPAL PERIKANAN - PALKA IKAN SEGAR DAN IKAN BEKU PADA KAPAL PENANGKAP IKAN', 2021, 1, 0, 1, '2022-10-06 01:09:15', '2022-10-06 01:39:58'),
(5, 'Aya Sofa Novia', '768/KEP/BSN/12/2021', 'SNI 680:2021 KLOSET JONGKOK KERAMIK SEBAGAI REVISI DARI SNI 03-0680-1998 TANDAS JONGKOK JENIS VITORUS CINA', '2021-12-31', '2022-01-05', 'SNI 680:2021', 'KLOSET JONGKOK KERAMIK', 2021, 1, 0, 1, '2022-10-06 01:11:51', '2022-10-06 01:49:30'),
(6, 'Refiano Andores', '709/KEP/BSN/12/2021', 'SNI 2802:2021 TEPUNG AGAR-AGAR MURNI SEBAGAl REVISI DARI SNI 2802:2015 AGAR-AGAR TEPUNG', '2021-12-31', '2022-01-05', 'SNI 2802:2021', 'TEPUNG AGAR-AGAR MURNI', 2021, 1, 0, 1, '2022-10-06 01:14:30', '2022-10-06 01:52:13'),
(7, 'Ahmad Khairuddin', '716/KEP/BSN/12/2021', 'SNI 8391-1:2021 KARAGINAN MURNI - BAGIAN 1: KAPPA (K) KARAGINAN MURNI METODE PENJENDALAN KCL - SYARAT MUTU DAN PENGOLAHAN SEBAGAI REVISI DARI SNI 8391-1:2017 KARAGINAN MURNI (REFINED CARRAGEENAN) - BAGIAN 1: KAPPA KARAGINAN - SYARAT MUTU DAN PENGOLAHAN', '2022-01-25', '2022-02-28', 'SNI 8391-1:2021', 'KARAGINAN MURNI - BAGIAN 1: KAPPA (K) KARAGINAN MURNI METODE PENJENDALAN KCL - SYARAT MUTU DAN PENGOLAHAN', 2022, 1, 0, 1, '2022-10-06 07:07:16', '2022-10-06 07:10:05'),
(8, 'Arsanti Rakhasiwi', '14/KEP/BSN/1/2022', 'SNI 180-1:2022 ALAT PEMADAM API PORTABEL (APAP) -BAGIAN 1: SYARAT MUTU SEBAGAI REVISI DARI SNI 180:2021 ALAT PEMADAM API PORTABEL (APAP) DAN SNI 03-3988-1995 PENGUJIAN KEMAMPUAN PEMADAMAN DAN PENILAIAN ALAT PEMADAM API RINGAN', '2021-12-31', '2022-01-17', 'SNI 180:2021', 'ALAT PEMADAM API PORTABEL (APAP)', 2021, 1, 0, 1, '2022-10-10 02:30:56', '2022-10-10 07:51:46'),
(10, 'Ahmad Khairuddin', '772/KEP/BSN/12/2021', 'SNI lEC 62321-1:2013 PENENTUAN BAH AN TERTENTU ZAT DALAM PRODUK ELEKTROTEKNIK - BAGIAN 1: PENDAHULUAN DAN IKHTISAR SEBAGAI REVISI DARI SNI lEC 62321:2015 PRODUK ELEKTROTEKNIK - PENENTUAN KADAR ENAM UNSUR YANG DIREGULASI (TIMBAL, AIR RAKSA, KADMIUM, KROMIUM HEKSAVALEN, BIFENIL POLIBROMINAT, ETER DIFENIL POLIBROMINAT)', '2022-02-02', '2021-12-31', 'SNI lEC 62321-1:2013', 'PENENTUAN BAH AN TERTENTU ZAT DALAM PRODUK ELEKTROTEKNIK - BAGIAN 1: PENDAHULUAN DAN IKHTISAR', 2021, 1, 0, 1, '2022-10-10 02:46:27', '2022-10-10 07:50:33'),
(11, 'Arsanti Rakhasiwi', '732/KEP/BSN/12/2021', 'SNI 2156:2021 SPESIFIKASI BETON AERASI AUTOKLAF SEBAGAl REVISI DARI SNI 03-2156-1991 BLOK BETON RINGAN BERGELEMBUNG UDARA (AIRATED) DENGAN PROSES OTOKLAP', '2021-12-31', '2022-02-02', 'SNI 2156:2021', 'SPESIFIKASI BETON AERASI AUTOKLAF', 2021, 1, 0, 1, '2022-10-10 06:55:14', '2022-10-10 07:06:01'),
(12, 'Aya Sofa Novia', '706/KEP/BSN/12/2021', 'SNI 2694:2021 SURIMI BEKU SEBAGAI REVISI DARI SNI<br />\r\n2694:2013 SURIMI', '2021-12-31', '2022-01-11', 'SNI 2694:2021', 'SURIMI BEKU', 2021, 1, 0, 1, '2022-10-11 05:43:33', '2022-10-11 05:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `standard_implementers`
--

CREATE TABLE `standard_implementers` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_identifikasi` int(10) UNSIGNED NOT NULL,
  `penerap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `standard_implementers`
--

INSERT INTO `standard_implementers` (`id`, `id_identifikasi`, `penerap`, `created_at`, `updated_at`) VALUES
(11, 5, 'a', '2022-09-30 04:54:25', '2022-09-30 04:54:25'),
(12, 5, 'b', '2022-09-30 04:54:25', '2022-09-30 04:54:25'),
(13, 6, '-', '2022-10-06 01:39:58', '2022-10-06 01:39:58'),
(14, 7, 'LSPro Balai Besar Keramik', '2022-10-06 01:49:30', '2022-10-06 01:49:30'),
(15, 8, 'Balai Besar Industri Agro (LSPro BBIA)', '2022-10-06 01:52:13', '2022-10-06 01:52:13'),
(16, 9, '-', '2022-10-06 07:10:05', '2022-10-06 07:10:05'),
(17, 10, 'Balai Sertifikasi Indonesia, Kementrian Perindustrian (LSPro BSI)', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(18, 10, 'Balai Besar Teknologi Kekuatan Struktur (LSPro B2TKS)', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(19, 10, 'Multicon', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(20, 10, 'ALFACON', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(21, 10, 'TR BLOCK, SUPREME BLOCK', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(22, 10, 'RUBICON', '2022-10-10 07:06:01', '2022-10-10 07:06:01'),
(23, 11, '-', '2022-10-10 07:50:33', '2022-10-10 07:50:33'),
(24, 12, 'Balai Sertifikasi Indonesia, Kementrian Perindustrian (LSPro BSI)', '2022-10-10 07:51:46', '2022-10-10 07:51:46'),
(25, 13, 'Balai Besar Pengujian Penerapan Produk Kelautan dan Perikanan (BBP3KP)', '2022-10-11 05:52:44', '2022-10-11 05:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `transition_times`
--

CREATE TABLE `transition_times` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sni_lama` int(10) UNSIGNED NOT NULL,
  `batas_transisi` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transition_times`
--

INSERT INTO `transition_times` (`id`, `id_sni_lama`, `batas_transisi`, `created_at`, `updated_at`) VALUES
(1, 3, '2024-10-10', '2022-10-06 04:19:05', '2022-10-06 04:19:05'),
(2, 4, '2022-12-31', '2022-10-06 04:19:05', '2022-10-06 04:19:05'),
(3, 5, '2022-10-12', '2022-10-06 06:38:20', '2022-10-06 06:38:20'),
(5, 8, '2024-09-30', '2022-10-10 07:16:31', '2022-10-10 07:16:31'),
(6, 9, '2023-10-25', '2022-10-10 07:58:49', '2022-10-10 07:58:49'),
(7, 11, '2022-10-11', '2022-10-10 12:25:41', '2022-10-10 12:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `level`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Irma Permata Sari', 'irpermata@bsn.go.id', 0, NULL, '$2y$10$AHd2a0nXzZrnt137XbcYe.7TfXOjztJTJMFlHoR1zhpZfjSoWzq8u', NULL, '2022-08-08 21:30:59', '2022-08-08 21:30:59'),
(2, 'Arsanti Rakhasiwi', 'arsantirs@bsn.go.id', 1, NULL, '$2y$10$ZLvMk0hIJgUzdCrTJP05BOwNFWAqm0G6oX.xwochBoFW/HZq2Fd0i', NULL, '2022-08-08 21:33:59', '2022-08-08 21:33:59'),
(3, 'Refiano Andores', 'refiano.andores@bsn.go.id', 1, NULL, '$2y$10$HUeG.NH5hbArR0aUpcL9POzCxucau0KSl9NCI4/kKrFvgMw0X4ToS', NULL, '2022-08-08 21:42:56', '2022-08-08 21:42:56'),
(4, 'Aya Sofa Novia', 'ayasofa.novia@bsn.go.id', 1, NULL, '$2y$10$p/JsnYHAhoMPPw4Vz4.Pc.OAQlyDegacH.NDzWMoEd2ipUVC5Cb5S', NULL, '2022-08-08 21:44:00', '2022-08-08 21:44:00'),
(5, 'Ahmad Khairuddin', 'ahmad.khairuddin@bsn.go.id', 1, NULL, '$2y$10$hdQ2SC2JGRaMVX90p8Bnxe.SAZbjHl6RKjAAP/p3y2JOJc2vyxxCu', NULL, '2022-08-08 21:45:16', '2022-08-08 21:45:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `identifications`
--
ALTER TABLE `identifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identifications_id_sk_revisi_foreign` (`id_sk_revisi`);

--
-- Indexes for table `meeting_materials`
--
ALTER TABLE `meeting_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_materials_id_meeting_schedule_foreign` (`id_meeting_schedule`);

--
-- Indexes for table `meeting_schedules`
--
ALTER TABLE `meeting_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `official_memos`
--
ALTER TABLE `official_memos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `official_memos_id_meeting_schedule_foreign` (`id_meeting_schedule`);

--
-- Indexes for table `official_memo_histories`
--
ALTER TABLE `official_memo_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `official_memo_histories_id_official_memo_foreign` (`id_official_memo`);

--
-- Indexes for table `old_standards`
--
ALTER TABLE `old_standards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `old_standards_id_sk_revisi_foreign` (`id_sk_revisi`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `revision_decrees`
--
ALTER TABLE `revision_decrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `standard_implementers`
--
ALTER TABLE `standard_implementers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `standard_implementers_id_identifikasi_foreign` (`id_identifikasi`);

--
-- Indexes for table `transition_times`
--
ALTER TABLE `transition_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transition_times_id_sni_lama_foreign` (`id_sni_lama`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identifications`
--
ALTER TABLE `identifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `meeting_materials`
--
ALTER TABLE `meeting_materials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `meeting_schedules`
--
ALTER TABLE `meeting_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `official_memos`
--
ALTER TABLE `official_memos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `official_memo_histories`
--
ALTER TABLE `official_memo_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `old_standards`
--
ALTER TABLE `old_standards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `revision_decrees`
--
ALTER TABLE `revision_decrees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `standard_implementers`
--
ALTER TABLE `standard_implementers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transition_times`
--
ALTER TABLE `transition_times`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `identifications`
--
ALTER TABLE `identifications`
  ADD CONSTRAINT `identifications_id_sk_revisi_foreign` FOREIGN KEY (`id_sk_revisi`) REFERENCES `revision_decrees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meeting_materials`
--
ALTER TABLE `meeting_materials`
  ADD CONSTRAINT `meeting_materials_id_meeting_schedule_foreign` FOREIGN KEY (`id_meeting_schedule`) REFERENCES `meeting_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `official_memos`
--
ALTER TABLE `official_memos`
  ADD CONSTRAINT `official_memos_id_meeting_schedule_foreign` FOREIGN KEY (`id_meeting_schedule`) REFERENCES `meeting_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `official_memo_histories`
--
ALTER TABLE `official_memo_histories`
  ADD CONSTRAINT `official_memo_histories_id_official_memo_foreign` FOREIGN KEY (`id_official_memo`) REFERENCES `official_memos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `old_standards`
--
ALTER TABLE `old_standards`
  ADD CONSTRAINT `old_standards_id_sk_revisi_foreign` FOREIGN KEY (`id_sk_revisi`) REFERENCES `revision_decrees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `standard_implementers`
--
ALTER TABLE `standard_implementers`
  ADD CONSTRAINT `standard_implementers_id_identifikasi_foreign` FOREIGN KEY (`id_identifikasi`) REFERENCES `identifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transition_times`
--
ALTER TABLE `transition_times`
  ADD CONSTRAINT `transition_times_id_sni_lama_foreign` FOREIGN KEY (`id_sni_lama`) REFERENCES `meeting_materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
