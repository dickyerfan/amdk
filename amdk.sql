-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 10:27 AM
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
