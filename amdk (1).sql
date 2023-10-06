-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 05:42 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amdk`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_baku`
--

CREATE TABLE `barang_baku` (
  `id_barang_baku` int(11) NOT NULL,
  `nama_barang_baku` varchar(50) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_jenis_barang` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `status_barang_baku` int(1) NOT NULL DEFAULT 1,
  `tgl_input` datetime NOT NULL DEFAULT current_timestamp(),
  `input_barang_baku` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_baku`
--

INSERT INTO `barang_baku` (`id_barang_baku`, `nama_barang_baku`, `id_satuan`, `id_jenis_barang`, `kode_barang`, `status_barang_baku`, `tgl_input`, `input_barang_baku`) VALUES
(1, 'galon baru', 1, 1, 'gal', 1, '2023-09-30 21:26:54', 'Dwi Bekti Hariyanto'),
(2, 'tisu galon', 1, 1, 'tig', 1, '2023-09-30 21:28:29', 'Dwi Bekti Hariyanto'),
(3, 'segel galon', 1, 1, 'seg', 1, '2023-09-30 21:35:29', 'Dwi Bekti Hariyanto'),
(4, 'tutup galon', 1, 1, 'tug', 1, '2023-09-30 21:36:00', 'Dwi Bekti Hariyanto'),
(5, 'stiker galon', 2, 1, 'stg', 1, '2023-09-30 21:39:20', 'Dwi Bekti Hariyanto'),
(6, 'isolasi', 5, 6, 'iso', 1, '2023-09-30 21:39:56', 'Dwi Bekti Hariyanto'),
(7, 'sedotan', 1, 2, 'sed', 1, '2023-09-30 21:40:21', 'Dwi Bekti Hariyanto'),
(8, 'kardus gelas ijen', 1, 2, 'kgi', 1, '2023-09-30 21:41:56', 'Dwi Bekti Hariyanto'),
(9, 'kardus gelas ijen merah', 1, 2, 'kgim', 1, '2023-09-30 21:42:39', 'Dwi Bekti Hariyanto'),
(10, 'kardus gelas genggong', 1, 2, 'kgg', 1, '2023-09-30 21:43:07', 'Dwi Bekti Hariyanto');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis_barang` int(11) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL,
  `tgl_input_jenis_barang` datetime NOT NULL DEFAULT current_timestamp(),
  `input_jenis_barang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis_barang`, `jenis_barang`, `tgl_input_jenis_barang`, `input_jenis_barang`) VALUES
(1, 'galon', '2023-09-30 21:07:23', 'Dwi Bekti Hariyanto'),
(2, 'gelas 220ml', '2023-09-30 21:07:38', 'Dwi Bekti Hariyanto'),
(3, 'botol 330ml', '2023-09-30 21:07:46', 'Dwi Bekti Hariyanto'),
(4, 'botol 500ml', '2023-09-30 21:08:01', 'Dwi Bekti Hariyanto'),
(5, 'botol 1500ml', '2023-09-30 21:08:16', 'Dwi Bekti Hariyanto'),
(6, 'gelas & botol', '2023-09-30 21:38:44', 'Dwi Bekti Hariyanto'),
(7, 'lain-lain', '2023-10-01 05:07:26', 'Dwi Bekti Hariyanto');

-- --------------------------------------------------------

--
-- Table structure for table `keluar_baku`
--

CREATE TABLE `keluar_baku` (
  `id_keluar_baku` int(11) NOT NULL,
  `id_barang_baku` int(11) NOT NULL,
  `jumlah_keluar` int(10) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status_keluar` int(1) NOT NULL DEFAULT 0,
  `input_status_keluar` varchar(50) NOT NULL,
  `tgl_input_keluar` datetime NOT NULL DEFAULT current_timestamp(),
  `bukti_keluar_gd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keluar_baku`
--

INSERT INTO `keluar_baku` (`id_keluar_baku`, `id_barang_baku`, `jumlah_keluar`, `tanggal_keluar`, `status_keluar`, `input_status_keluar`, `tgl_input_keluar`, `bukti_keluar_gd`) VALUES
(1, 8, 400, '2023-09-01', 1, 'Muh Abd Cholil', '2023-10-05 11:04:49', '2023-09-01.jpg'),
(2, 4, 1000, '2023-09-04', 1, 'Muh Abd Cholil', '2023-10-05 11:05:32', '2023-09-04.jpg'),
(3, 7, 96000, '2023-09-04', 1, 'Muh Abd Cholil', '2023-10-05 11:05:55', '2023-09-04.jpg'),
(4, 10, 500, '2023-09-05', 1, 'Muh Abd Cholil', '2023-10-05 11:08:09', '2023-09-05.jpg'),
(5, 8, 400, '2023-09-06', 1, 'Muh Abd Cholil', '2023-10-05 11:09:09', '2023-10-06.jpg'),
(6, 8, 400, '2023-09-07', 1, 'Muh Abd Cholil', '2023-10-05 11:10:10', '2023-09-07.jpg'),
(7, 7, 96000, '2023-09-11', 1, 'Muh Abd Cholil', '2023-10-05 11:10:51', '2023-09-11.jpg'),
(8, 6, 144, '2023-09-12', 1, 'Muh Abd Cholil', '2023-10-05 11:16:13', '2023-09-11.jpg'),
(9, 8, 240, '2023-09-12', 1, 'Muh Abd Cholil', '2023-10-05 11:17:52', '2023-09-12.jpg'),
(10, 10, 200, '2023-09-12', 1, 'Muh Abd Cholil', '2023-10-05 11:18:13', '2023-09-12.jpg'),
(11, 3, 1000, '2023-09-13', 1, 'Muh Abd Cholil', '2023-10-05 11:19:20', '2023-09-13.jpg'),
(12, 7, 96000, '2023-09-13', 1, 'Muh Abd Cholil', '2023-10-05 11:46:31', '2023-09-13.jpg'),
(13, 8, 600, '2023-09-13', 1, 'Muh Abd Cholil', '2023-10-05 11:46:50', '2023-09-13.jpg'),
(14, 8, 500, '2023-09-14', 1, 'Muh Abd Cholil', '2023-10-05 11:47:59', '2023-09-14.jpg'),
(15, 8, 400, '2023-09-15', 1, 'Muh Abd Cholil', '2023-10-05 11:48:39', '2023-09-15.jpg'),
(16, 8, 500, '2023-09-18', 1, 'Muh Abd Cholil', '2023-10-05 11:49:36', '2023-09-18.jpg'),
(17, 10, 500, '2023-09-20', 1, 'Muh Abd Cholil', '2023-10-05 11:50:09', '2023-09-20.jpg'),
(18, 8, 500, '2023-09-21', 1, 'Muh Abd Cholil', '2023-10-05 11:51:03', '2023-09-21.jpg'),
(19, 4, 1000, '2023-09-22', 1, 'Muh Abd Cholil', '2023-10-05 11:52:02', '2023-09-22.jpg'),
(20, 3, 1000, '2023-09-26', 1, 'Muh Abd Cholil', '2023-10-05 11:55:21', '2023-09-26.jpg'),
(21, 7, 96000, '2023-09-26', 1, 'Muh Abd Cholil', '2023-10-05 11:55:48', '2023-09-26.jpg'),
(22, 8, 500, '2023-09-26', 1, 'Muh Abd Cholil', '2023-10-05 11:56:16', '2023-09-26.jpg'),
(23, 10, 500, '2023-09-26', 1, 'Muh Abd Cholil', '2023-10-05 11:56:32', '2023-09-26.jpg'),
(24, 8, 500, '2023-09-27', 1, 'Muh Abd Cholil', '2023-10-05 11:57:29', '2023-09-27.jpg'),
(25, 8, 400, '2023-09-28', 1, 'Muh Abd Cholil', '2023-10-05 11:58:04', '2023-09-28.jpg'),
(26, 8, 200, '2023-09-29', 1, 'Muh Abd Cholil', '2023-10-05 11:58:28', '2023-09-29.jpg'),
(27, 10, 200, '2023-09-29', 1, 'Muh Abd Cholil', '2023-10-05 11:58:44', '2023-09-29.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `masuk_baku`
--

CREATE TABLE `masuk_baku` (
  `id_masuk_baku` int(11) NOT NULL,
  `id_barang_baku` int(11) NOT NULL,
  `jumlah_masuk` int(10) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status_masuk` int(1) NOT NULL DEFAULT 0,
  `input_status_masuk` varchar(50) NOT NULL,
  `tgl_input_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update_masuk` datetime NOT NULL,
  `bukti_masuk_sj` varchar(50) NOT NULL,
  `bukti_masuk_gd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masuk_baku`
--

INSERT INTO `masuk_baku` (`id_masuk_baku`, `id_barang_baku`, `jumlah_masuk`, `tanggal_masuk`, `status_masuk`, `input_status_masuk`, `tgl_input_masuk`, `tgl_update_masuk`, `bukti_masuk_sj`, `bukti_masuk_gd`) VALUES
(1, 6, 144, '2023-09-12', 1, 'Dwi Bekti Hariyanto', '2023-10-05 11:13:17', '2023-10-05 11:13:53', '2023-09-11.jpg', '138327065_756557328312747_5300519839286804070_n.jpg'),
(2, 7, 1920000, '2023-09-22', 1, 'Dwi Bekti Hariyanto', '2023-10-05 11:53:25', '2023-10-05 11:54:02', '2023-09-22.jpg', '272040805_331086798885295_2032618712761514991_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rusak_baku`
--

CREATE TABLE `rusak_baku` (
  `id_rusak_baku` int(11) NOT NULL,
  `id_barang_baku` int(11) NOT NULL,
  `jumlah_rusak_baku` int(10) NOT NULL,
  `tanggal_rusak_baku` date NOT NULL,
  `status_rusak_baku` int(1) NOT NULL DEFAULT 1,
  `input_status_rusak_baku` varchar(50) NOT NULL,
  `tgl_input_rusak_baku` datetime NOT NULL DEFAULT current_timestamp(),
  `bukti_rusak_baku` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `tgl_input_satuan` datetime NOT NULL DEFAULT current_timestamp(),
  `input_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `satuan`, `tgl_input_satuan`, `input_satuan`) VALUES
(1, 'pcs', '2023-09-30 21:05:36', 'Dwi Bekti Hariyanto'),
(2, 'meter', '2023-09-30 21:37:05', 'Dwi Bekti Hariyanto'),
(3, 'galon', '2023-09-30 21:37:25', 'Dwi Bekti Hariyanto'),
(4, 'rol', '2023-09-30 21:37:30', 'Dwi Bekti Hariyanto'),
(5, 'dus', '2023-09-30 21:37:45', 'Dwi Bekti Hariyanto');

-- --------------------------------------------------------

--
-- Table structure for table `stok_awal_harian`
--

CREATE TABLE `stok_awal_harian` (
  `id_stok_awal_harian` int(11) NOT NULL,
  `id_barang_baku` int(11) NOT NULL,
  `tanggal_stok_harian` date NOT NULL,
  `jumlah_stok_harian` int(10) NOT NULL,
  `input_stok_harian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stok_awal_harian`
--

INSERT INTO `stok_awal_harian` (`id_stok_awal_harian`, `id_barang_baku`, `tanggal_stok_harian`, `jumlah_stok_harian`, `input_stok_harian`) VALUES
(1, 1, '2023-10-04', 71, 'Bekti'),
(3, 1, '2023-10-05', 71, 'Dwi Bekti Hariyanto');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `upk_bagian` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `level` varchar(50) NOT NULL DEFAULT 'Pengguna',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_pengguna`, `nama_lengkap`, `upk_bagian`, `password`, `level`, `status`) VALUES
(2, 'administrator', 'Dicky Erfan Septiono', 'dicky', '$2y$10$MFzEk5qSvSQo1l8Ip4Psaelp4bi20s9Fwus8n3I0J5tien9xdao8G', 'Admin', 1),
(18, 'admin', 'Suwarna', 'admin', '$2y$10$rlcKUpdaS8gX9cYZO1OwveUlifZyAB8V3qStlq16chvl85RjqYOOm', 'Admin', 1),
(23, 'Barang Baku', 'Dwi Bekti Hariyanto', 'baku', '$2y$10$SrOVe0nXrG2ERB7SWwBKX.dRZTPkPHWKih8DWW89whqAT2BGywnje', 'Pengguna', 1),
(24, 'Barang Produksi', 'Muh Abd Cholil', 'produksi', '$2y$10$m1cIFZkeGC3JSe1L0Rin1eM17ot2aiLWrRy6bTkVv7capXALepI3u', 'Pengguna', 1),
(25, 'Barang Jadi', 'Zainul Hasan', 'jadi', '$2y$10$wA3JxLnd1utg.xmRyXf6rea9GRCD2nmSsWViwQi4f3adR5VRvFUGq', 'Pengguna', 1),
(26, 'Pemasaran', 'Reza Yudianto', 'pasar', '$2y$10$tXTj7SZFfvn09qJwQK0zs.4hJzOI/CcBtvwUXVA3W61QqZYAQyc3i', 'Pengguna', 1),
(51, 'Keuangan', 'Ardiylla Rosza', 'uang', '$2y$10$ZnJTXVo5Nw5tg.oMYy7CX.4aoBdIj6VleM/c0X1mKW7bVLNTrhRb2', 'Pengguna', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_baku`
--
ALTER TABLE `barang_baku`
  ADD PRIMARY KEY (`id_barang_baku`),
  ADD KEY `id_satuan` (`id_satuan`),
  ADD KEY `id_jenis_barang` (`id_jenis_barang`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis_barang`);

--
-- Indexes for table `keluar_baku`
--
ALTER TABLE `keluar_baku`
  ADD PRIMARY KEY (`id_keluar_baku`),
  ADD KEY `id_barang_baku` (`id_barang_baku`);

--
-- Indexes for table `masuk_baku`
--
ALTER TABLE `masuk_baku`
  ADD PRIMARY KEY (`id_masuk_baku`),
  ADD KEY `id_barang_baku` (`id_barang_baku`);

--
-- Indexes for table `rusak_baku`
--
ALTER TABLE `rusak_baku`
  ADD PRIMARY KEY (`id_rusak_baku`),
  ADD KEY `id_barang_baku` (`id_barang_baku`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `stok_awal_harian`
--
ALTER TABLE `stok_awal_harian`
  ADD PRIMARY KEY (`id_stok_awal_harian`),
  ADD KEY `id_barang_baku` (`id_barang_baku`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_baku`
--
ALTER TABLE `barang_baku`
  MODIFY `id_barang_baku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id_jenis_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keluar_baku`
--
ALTER TABLE `keluar_baku`
  MODIFY `id_keluar_baku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `masuk_baku`
--
ALTER TABLE `masuk_baku`
  MODIFY `id_masuk_baku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rusak_baku`
--
ALTER TABLE `rusak_baku`
  MODIFY `id_rusak_baku` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stok_awal_harian`
--
ALTER TABLE `stok_awal_harian`
  MODIFY `id_stok_awal_harian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_baku`
--
ALTER TABLE `barang_baku`
  ADD CONSTRAINT `barang_baku_ibfk_1` FOREIGN KEY (`id_jenis_barang`) REFERENCES `jenis_barang` (`id_jenis_barang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_baku_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON UPDATE CASCADE;

--
-- Constraints for table `keluar_baku`
--
ALTER TABLE `keluar_baku`
  ADD CONSTRAINT `keluar_baku_ibfk_1` FOREIGN KEY (`id_barang_baku`) REFERENCES `barang_baku` (`id_barang_baku`) ON UPDATE CASCADE;

--
-- Constraints for table `masuk_baku`
--
ALTER TABLE `masuk_baku`
  ADD CONSTRAINT `masuk_baku_ibfk_1` FOREIGN KEY (`id_barang_baku`) REFERENCES `barang_baku` (`id_barang_baku`) ON UPDATE CASCADE;

--
-- Constraints for table `rusak_baku`
--
ALTER TABLE `rusak_baku`
  ADD CONSTRAINT `rusak_baku_ibfk_1` FOREIGN KEY (`id_barang_baku`) REFERENCES `barang_baku` (`id_barang_baku`) ON UPDATE CASCADE;

--
-- Constraints for table `stok_awal_harian`
--
ALTER TABLE `stok_awal_harian`
  ADD CONSTRAINT `stok_awal_harian_ibfk_1` FOREIGN KEY (`id_barang_baku`) REFERENCES `barang_baku` (`id_barang_baku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
