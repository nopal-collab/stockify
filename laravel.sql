-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2026 at 08:34 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Import Excel Product', 'Import data product dari file Excel', '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(2, 1, 'Tambah Atribut', 'Menambahkan atribut: Ukuran Pakaian (select)', '2026-05-14 23:53:57', '2026-05-14 23:53:57'),
(3, 1, 'Tambah Atribut', 'Menambahkan atribut: Warna (color)', '2026-05-14 23:53:57', '2026-05-14 23:53:57'),
(4, 1, 'Tambah Atribut', 'Menambahkan atribut: Garansi (select)', '2026-05-14 23:53:57', '2026-05-14 23:53:57'),
(5, 2, 'Tambah Produk', 'Menambahkan produk: Laptop ASUS VivoBook 15', '2026-05-15 23:53:57', '2026-05-15 23:53:57'),
(6, 2, 'Tambah Produk', 'Menambahkan produk: Smartphone Samsung Galaxy A54', '2026-05-15 23:53:57', '2026-05-15 23:53:57'),
(7, 2, 'Buat Transaksi Masuk', 'Barang masuk 15 unit Laptop ASUS (pending)', '2026-05-28 23:53:57', '2026-05-28 23:53:57'),
(8, 3, 'Konfirmasi Transaksi', 'Mengkonfirmasi penerimaan 15 unit Laptop ASUS', '2026-05-28 23:53:57', '2026-05-28 23:53:57'),
(9, 1, 'Buat Stock Opname', 'Membuat sesi: Stock Opname Mei 2026', '2026-05-26 23:53:57', '2026-05-26 23:53:57'),
(10, 2, 'Selesaikan Opname', 'Menyelesaikan Stock Opname Mei 2026 — 6 produk diperiksa', '2026-05-27 23:53:57', '2026-05-27 23:53:57'),
(11, 2, 'Buat Transaksi Masuk', 'Barang masuk 50 unit Beras Premium (pending)', '2026-06-03 17:53:57', '2026-06-03 17:53:57'),
(12, 2, 'Buat Transaksi Keluar', 'Barang keluar 20 unit Kaos (pending)', '2026-06-03 21:53:57', '2026-06-03 21:53:57'),
(13, 1, 'Buat Stock Opname', 'Membuat sesi: Stock Opname Juni 2026 — Minggu 1', '2026-06-03 22:53:57', '2026-06-03 22:53:57'),
(14, 1, 'Tambah Atribut', 'Menambahkan atribut: Ukuran Pakaian (select)', '2026-05-15 12:02:44', '2026-05-15 12:02:44'),
(15, 1, 'Tambah Atribut', 'Menambahkan atribut: Warna (color)', '2026-05-15 12:02:44', '2026-05-15 12:02:44'),
(16, 1, 'Tambah Atribut', 'Menambahkan atribut: Garansi (select)', '2026-05-15 12:02:44', '2026-05-15 12:02:44'),
(17, 2, 'Tambah Produk', 'Menambahkan produk: Laptop ASUS VivoBook 15', '2026-05-16 12:02:44', '2026-05-16 12:02:44'),
(18, 2, 'Tambah Produk', 'Menambahkan produk: Smartphone Samsung Galaxy A54', '2026-05-16 12:02:44', '2026-05-16 12:02:44'),
(19, 2, 'Buat Transaksi Masuk', 'Barang masuk 15 unit Laptop ASUS (pending)', '2026-05-29 12:02:44', '2026-05-29 12:02:44'),
(20, 3, 'Konfirmasi Transaksi', 'Mengkonfirmasi penerimaan 15 unit Laptop ASUS', '2026-05-29 12:02:44', '2026-05-29 12:02:44'),
(21, 1, 'Buat Stock Opname', 'Membuat sesi: Stock Opname Mei 2026', '2026-05-27 12:02:44', '2026-05-27 12:02:44'),
(22, 2, 'Selesaikan Opname', 'Menyelesaikan Stock Opname Mei 2026 — 6 produk diperiksa', '2026-05-28 12:02:44', '2026-05-28 12:02:44'),
(23, 2, 'Buat Transaksi Masuk', 'Barang masuk 50 unit Beras Premium (pending)', '2026-06-04 06:02:44', '2026-06-04 06:02:44'),
(24, 2, 'Buat Transaksi Keluar', 'Barang keluar 20 unit Kaos (pending)', '2026-06-04 10:02:44', '2026-06-04 10:02:44'),
(25, 1, 'Buat Stock Opname', 'Membuat sesi: Stock Opname Juni 2026 — Minggu 1', '2026-06-04 11:02:44', '2026-06-04 11:02:44'),
(26, 3, 'Konfirmasi Transaksi', 'Mengkonfirmasi transaksi #28 Barang Masuk sebanyak 8 unit — produk: Laptop ASUS VivoBook 15', '2026-06-05 03:48:02', '2026-06-05 03:48:02'),
(27, 3, 'Konfirmasi Transaksi', 'Mengkonfirmasi transaksi #27 Barang Masuk sebanyak 5 unit — produk: Printer Canon PIXMA G2020', '2026-06-05 03:52:50', '2026-06-05 03:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Elektronik', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(3, 'Pakaian', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(4, 'Makanan & Minuman', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(5, 'Furnitur', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(6, 'Alat Tulis', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_01_01_000000_create_settings_table', 1),
(5, '2026_05_13_000000_create_users_table', 1),
(6, '2026_05_13_115911_create_categories_table', 1),
(7, '2026_05_13_120355_create_products_table', 1),
(8, '2026_05_15_023730_create_stock_transactions_table', 1),
(9, '2026_05_15_030546_add_image_to_products_table', 1),
(10, '2026_05_15_063716_create_suppliers_table', 1),
(11, '2026_05_15_071837_add_supplier_id_to_products_table', 1),
(12, '2026_05_16_031058_create_activity_logs_table', 1),
(13, '2026_05_16_070246_add_timestamps_to_users_table', 1),
(14, '2026_05_20_035636_add_status_to_stock_transactions_table', 1),
(15, '2026_05_25_000001_add_foreign_key_user_id_to_stock_transactions_table', 1),
(16, '2026_06_01_000001_create_stock_opnames_table', 1),
(17, '2026_06_01_000002_create_stock_opname_items_table', 1),
(18, '2026_06_01_100001_add_price_and_min_stock_to_products_table', 1),
(19, '2026_06_02_000001_create_product_attributes_table', 1),
(20, '2026_06_02_000002_create_product_attribute_values_table', 1),
(21, '2026_06_04_000001_make_categories_description_nullable', 1),
(22, '2026_06_04_000001_make_suppliers_columns_nullable', 1),
(23, '2026_06_04_000002_make_suppliers_columns_nullable', 2),
(24, '2026_06_04_000003_fix_products_columns', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `min_stock` int NOT NULL DEFAULT '5',
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `stock`, `harga_beli`, `harga_jual`, `min_stock`, `description`, `image`, `created_at`, `updated_at`, `supplier_id`) VALUES
(1, 2, 'Monitor LG 24 inch IPS', 15, 1800000.00, 2350000.00, 3, 'Monitor IPS Full HD 1080p, 75Hz, anti-glare', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 2),
(2, 2, 'Keyboard Mechanical Logitech G Pro', 30, 850000.00, 1150000.00, 5, 'Keyboard gaming mekanikal, backlit RGB', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 2),
(3, 2, 'Headphone Sony WH-1000XM4', 12, 2900000.00, 3750000.00, 3, 'Headphone noise cancelling, baterai 30 jam', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 2),
(4, 3, 'Celana Jogger Pria', 80, 55000.00, 95000.00, 15, 'Celana jogger cotton fleece, nyaman santai', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 3),
(5, 3, 'Kemeja Flanel Kotak-kotak', 45, 75000.00, 130000.00, 10, 'Kemeja flanel lengan panjang, hangat', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 3),
(6, 4, 'Kopi Arabica Gayo 250gr', 100, 45000.00, 65000.00, 20, 'Kopi arabica single origin Gayo Aceh', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 4),
(7, 4, 'Teh Hijau Premium 100 Kantong', 75, 22000.00, 35000.00, 15, 'Teh hijau celup tanpa pemanis', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 4),
(8, 5, 'Meja Kerja Minimalis 120cm', 10, 650000.00, 950000.00, 2, 'Meja kerja particle board HPL, 120x60x75cm', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', 5),
(9, 6, 'Penggaris Besi 30cm', 200, 8000.00, 15000.00, 30, 'Penggaris besi anti karat 30cm', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', NULL),
(10, 6, 'Spidol Whiteboard Snowman (12 pcs)', 90, 18000.00, 28000.00, 20, 'Spidol whiteboard 12 warna, mudah dihapus', NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26', NULL),
(11, 2, 'Laptop ASUS VivoBook 15', 33, 7500000.00, 9200000.00, 5, 'Laptop tipis ringan Intel Core i5, RAM 8GB, SSD 512GB.', NULL, '2026-06-03 23:53:57', '2026-06-05 03:48:02', 2),
(12, 2, 'Smartphone Samsung Galaxy A54', 40, 4200000.00, 5100000.00, 8, 'HP Android kamera 50MP, baterai 5000mAh, layar AMOLED 6.4\".', NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57', 2),
(13, 2, 'Printer Canon PIXMA G2020', 8, 1350000.00, 1750000.00, 5, 'Printer inkjet multifungsi tangki tinta isi ulang.', NULL, '2026-06-03 23:53:57', '2026-06-05 03:52:50', 2),
(14, 3, 'Kaos Polos Cotton Combed 30s', 150, 35000.00, 65000.00, 20, 'Kaos polos berkualitas tinggi, lembut dan adem.', NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57', 3),
(15, 3, 'Jaket Fleece Polos', 60, 85000.00, 145000.00, 10, 'Jaket fleece tebal, hangat untuk outdoor.', NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57', 3),
(16, 4, 'Beras Premium 5kg', 4, 68000.00, 82000.00, 10, 'Beras putih premium pulen dari petani lokal.', NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57', 4),
(17, 4, 'Minyak Goreng Bimoli 2L', 200, 28000.00, 35000.00, 30, 'Minyak goreng sawit murni kemasan 2 liter.', NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57', 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `options` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `name`, `type`, `options`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ukuran Pakaian', 'select', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', 'Ukuran standar pakaian internasional', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(2, 'Garansi', 'select', '[\"Tanpa Garansi\",\"1 Bulan\",\"3 Bulan\",\"6 Bulan\",\"1 Tahun\",\"2 Tahun\"]', 'Masa garansi resmi dari produsen', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(3, 'Kapasitas', 'select', '[\"64GB\",\"128GB\",\"256GB\",\"512GB\",\"1TB\"]', 'Kapasitas penyimpanan perangkat', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(4, 'Warna', 'color', NULL, 'Warna utama produk', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(5, 'Berat (kg)', 'number', NULL, 'Berat produk dalam kilogram', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(6, 'Voltase (V)', 'number', NULL, 'Tegangan listrik yang dibutuhkan', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(7, 'Material', 'text', NULL, 'Bahan atau material utama produk', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(8, 'Merek', 'text', NULL, 'Nama merek atau brand produk', '2026-06-04 12:02:43', '2026-06-04 12:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_attribute_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attribute_values`
--

INSERT INTO `product_attribute_values` (`id`, `product_id`, `product_attribute_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 11, 4, '#2563EB', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(2, 11, 2, '1 Tahun', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(3, 11, 3, '512GB', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(4, 11, 5, '1.8', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(5, 11, 8, 'ASUS', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(6, 11, 6, '220', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(7, 12, 4, '#1E1E1E', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(8, 12, 2, '1 Tahun', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(9, 12, 3, '128GB', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(10, 12, 5, '0.202', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(11, 12, 8, 'Samsung', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(12, 13, 4, '#000000', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(13, 13, 2, '1 Tahun', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(14, 13, 5, '3.8', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(15, 13, 8, 'Canon', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(16, 13, 6, '220', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(17, 14, 4, '#FFFFFF', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(18, 14, 1, 'M', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(19, 14, 7, 'Cotton Combed 30s', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(20, 14, 5, '0.18', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(21, 15, 4, '#374151', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(22, 15, 1, 'L', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(23, 15, 7, 'Fleece 270 GSM', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(24, 15, 5, '0.45', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(25, 16, 5, '5', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(26, 16, 8, 'Cap Koki', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(27, 17, 5, '1.84', '2026-06-04 12:02:43', '2026-06-04 12:02:43'),
(28, 17, 8, 'Bimoli', '2026-06-04 12:02:43', '2026-06-04 12:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'Stockify', '2026-06-03 23:28:29', '2026-06-03 23:28:29'),
(2, 'logo', NULL, '2026-06-03 23:28:29', '2026-06-03 23:28:29'),
(3, 'app_logo', NULL, '2026-06-03 23:28:30', '2026-06-03 23:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `stock_opnames`
--

CREATE TABLE `stock_opnames` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_by` bigint UNSIGNED NOT NULL,
  `completed_by` bigint UNSIGNED DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_opnames`
--

INSERT INTO `stock_opnames` (`id`, `title`, `notes`, `status`, `created_by`, `completed_by`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'Stock Opname Mei 2026', 'Opname rutin akhir bulan Mei. Semua produk diperiksa fisik oleh tim gudang.', 'completed', 1, 2, '2026-05-27 23:53:57', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(2, 'Stock Opname Juni 2026 — Minggu 1', 'Opname awal bulan Juni. Staff gudang silakan input stok fisik masing-masing produk.', 'in_progress', 1, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(3, 'Stock Opname Juni 2026 — Minggu 2', 'Direncanakan untuk minggu kedua Juni. Belum dimulai.', 'draft', 1, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname_items`
--

CREATE TABLE `stock_opname_items` (
  `id` bigint UNSIGNED NOT NULL,
  `stock_opname_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `system_stock` int NOT NULL,
  `physical_stock` int DEFAULT NULL,
  `difference` int DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_opname_items`
--

INSERT INTO `stock_opname_items` (`id`, `stock_opname_id`, `product_id`, `system_stock`, `physical_stock`, `difference`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 15, 14, -1, 'Selisih 1 unit — kemungkinan unit display', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(2, 1, 12, 17, 17, 0, 'Sesuai sistem', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(3, 1, 14, 50, 52, 2, 'Kelebihan 2 unit — kemungkinan salah catat sebelumnya', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(4, 1, 17, 150, 148, -2, 'Selisih 2 unit — kemungkinan pecah dalam pengiriman', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(5, 1, 15, 30, 30, 0, 'Sesuai sistem', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(6, 1, 16, 4, 4, 0, 'Sesuai sistem', '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(7, 2, 1, 15, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(8, 2, 2, 30, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(9, 2, 3, 12, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(10, 2, 4, 80, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(11, 2, 5, 45, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(12, 2, 6, 100, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(13, 2, 7, 75, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(14, 2, 8, 10, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(15, 2, 9, 200, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(16, 2, 10, 90, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(17, 2, 11, 25, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(18, 2, 12, 40, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(19, 2, 13, 3, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(20, 2, 14, 150, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(21, 2, 15, 60, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(22, 2, 16, 4, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57'),
(23, 2, 17, 200, NULL, NULL, NULL, '2026-06-03 23:53:57', '2026-06-03 23:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product_id`, `user_id`, `type`, `qty`, `note`, `created_at`, `updated_at`, `status`) VALUES
(1, 11, 2, 'in', 15, 'Restock batch 1 dari PT Elektronik Nusantara', '2026-05-14 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(2, 12, 2, 'in', 25, 'Penerimaan order bulan lalu', '2026-05-16 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(3, 14, 2, 'in', 80, 'Restock kaos dari CV Sandang Jaya', '2026-05-19 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(4, 17, 2, 'in', 100, 'Penerimaan minyak goreng dari PT Pangan Makmur', '2026-05-20 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(5, 11, 2, 'out', 5, 'Pengiriman ke cabang Jakarta Selatan', '2026-05-24 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(6, 12, 2, 'out', 8, 'Penjualan ke reseller Bandung', '2026-05-26 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(7, 14, 2, 'out', 30, 'Distribusi ke toko retail Surabaya', '2026-05-28 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(8, 17, 2, 'out', 50, 'Pengiriman ke distributor Jawa Timur', '2026-05-29 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(9, 15, 2, 'in', 40, 'Restock jaket musim dingin', '2026-05-30 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(10, 15, 2, 'out', 10, 'Pengiriman ke outlet Bandung', '2026-06-01 23:53:57', '2026-06-03 23:53:57', 'confirmed'),
(11, 16, 2, 'in', 50, 'Restock beras — perlu pengecekan fisik karung', '2026-06-03 17:53:57', '2026-06-03 23:53:57', 'pending'),
(12, 13, 2, 'in', 5, 'Penerimaan printer baru — cek kondisi & kelengkapan', '2026-06-03 19:53:57', '2026-06-03 23:53:57', 'pending'),
(13, 11, 2, 'in', 8, 'Restock laptop batch 2 — verifikasi serial number', '2026-06-03 20:53:57', '2026-06-03 23:53:57', 'pending'),
(14, 14, 2, 'out', 20, 'Permintaan kirim ke reseller Jakarta — siapkan dulu', '2026-06-03 21:53:57', '2026-06-03 23:53:57', 'pending'),
(15, 12, 2, 'out', 5, 'Retur ke supplier — unit display rusak', '2026-06-03 22:53:57', '2026-06-03 23:53:57', 'pending'),
(16, 11, 2, 'in', 15, 'Restock batch 1 dari PT Elektronik Nusantara', '2026-05-15 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(17, 12, 2, 'in', 25, 'Penerimaan order bulan lalu', '2026-05-17 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(18, 14, 2, 'in', 80, 'Restock kaos dari CV Sandang Jaya', '2026-05-20 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(19, 17, 2, 'in', 100, 'Penerimaan minyak goreng dari PT Pangan Makmur', '2026-05-21 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(20, 11, 2, 'out', 5, 'Pengiriman ke cabang Jakarta Selatan', '2026-05-25 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(21, 12, 2, 'out', 8, 'Penjualan ke reseller Bandung', '2026-05-27 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(22, 14, 2, 'out', 30, 'Distribusi ke toko retail Surabaya', '2026-05-29 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(23, 17, 2, 'out', 50, 'Pengiriman ke distributor Jawa Timur', '2026-05-30 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(24, 15, 2, 'in', 40, 'Restock jaket musim dingin', '2026-05-31 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(25, 15, 2, 'out', 10, 'Pengiriman ke outlet Bandung', '2026-06-02 12:02:43', '2026-06-04 12:02:43', 'confirmed'),
(26, 16, 2, 'in', 50, 'Restock beras — perlu pengecekan fisik karung', '2026-06-04 06:02:43', '2026-06-04 12:02:43', 'pending'),
(27, 13, 2, 'in', 5, 'Penerimaan printer baru — cek kondisi & kelengkapan', '2026-06-04 08:02:43', '2026-06-05 03:52:50', 'confirmed'),
(28, 11, 2, 'in', 8, 'Restock laptop batch 2 — verifikasi serial number', '2026-06-04 09:02:43', '2026-06-05 03:48:02', 'confirmed'),
(29, 14, 2, 'out', 20, 'Permintaan kirim ke reseller Jakarta — siapkan dulu', '2026-06-04 10:02:43', '2026-06-04 12:02:43', 'pending'),
(30, 12, 2, 'out', 5, 'Retur ke supplier — unit display rusak', '2026-06-04 11:02:43', '2026-06-04 12:02:43', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(2, 'PT Elektronik Nusantara', NULL, NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(3, 'CV Sandang Jaya', NULL, NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(4, 'PT Pangan Makmur', NULL, NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26'),
(5, 'UD Mebel Sejahtera', NULL, NULL, '2026-06-03 23:37:26', '2026-06-03 23:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','manajer_gudang','staff_gudang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff_gudang',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Stockify', 'admin@stockify.com', NULL, '$2y$10$iA/I5EA/AChxExC3YvSpeOOWLm4grLvszvFFxO23Qj7JohCjYTgRO', 'admin', NULL, '2026-06-03 23:28:30', '2026-06-03 23:28:30'),
(2, 'Budi Santoso', 'manajer@stockify.com', NULL, '$2y$10$4OV7QB2D7mAWYrlKDNnoM.nLu8IHgVFHxH5k1R0ksjc3ja9QwAVeS', 'manajer_gudang', NULL, '2026-06-03 23:28:30', '2026-06-03 23:28:30'),
(3, 'Siti Rahayu', 'staff@stockify.com', NULL, '$2y$10$dmIVoO8zihMELUKW2uRGlu/wmzWVdqn7NQ3zEqKWrvHLTMF2/N7w.', 'staff_gudang', NULL, '2026-06-03 23:28:30', '2026-06-03 23:28:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_attribute_values_product_id_product_attribute_id_unique` (`product_id`,`product_attribute_id`),
  ADD KEY `product_attribute_values_product_attribute_id_foreign` (`product_attribute_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_opnames_created_by_foreign` (`created_by`),
  ADD KEY `stock_opnames_completed_by_foreign` (`completed_by`);

--
-- Indexes for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_opname_items_stock_opname_id_foreign` (`stock_opname_id`),
  ADD KEY `stock_opname_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`),
  ADD KEY `stock_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD CONSTRAINT `product_attribute_values_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attribute_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_opnames`
--
ALTER TABLE `stock_opnames`
  ADD CONSTRAINT `stock_opnames_completed_by_foreign` FOREIGN KEY (`completed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_opnames_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_opname_items`
--
ALTER TABLE `stock_opname_items`
  ADD CONSTRAINT `stock_opname_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_opname_items_stock_opname_id_foreign` FOREIGN KEY (`stock_opname_id`) REFERENCES `stock_opnames` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
