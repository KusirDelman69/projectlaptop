-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2026 at 06:02 AM
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
-- Database: `peminjaman_laptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(2, 'IT Support', 'admin', '$2y$10$2zMnxwqro72qY1PA2IMMPO0hFRLWoBRDU3D9JiA/47/sq9rign04C', '2026-03-09 08:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE `laptops` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `spesifikasi` text DEFAULT NULL,
  `status` enum('tersedia','dipinjam','maintenance') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `kode`, `merk`, `model`, `spesifikasi`, `status`, `created_at`) VALUES
(1, 'LT-001', 'Lenovo', 'Ideapad S145', 'RAM 8 GB, SSD 256 GB, AMD A4', 'dipinjam', '2026-03-10 04:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `laptop_id` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_kembali_rencana` date DEFAULT NULL,
  `tgl_kembali_aktual` datetime DEFAULT NULL,
  `kondisi_pinjam` text DEFAULT 'Baik',
  `kondisi_kembali` text DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `laptop_id`, `nama_user`, `departemen`, `keperluan`, `tgl_pinjam`, `tgl_kembali_rencana`, `tgl_kembali_aktual`, `kondisi_pinjam`, `kondisi_kembali`, `status`, `created_at`) VALUES
(1, 1, 'Julio', 'HR', 'Kerja', '2026-03-10 11:51:10', NULL, NULL, 'Baik', NULL, 'dipinjam', '2026-03-10 04:51:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
