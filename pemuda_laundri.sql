-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 08:55 AM
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
-- Database: `pemuda_laundri`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama_paket` varchar(255) DEFAULT NULL,
  `harga_paket` decimal(10,2) DEFAULT NULL,
  `jumlah_pesanan` int(11) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `jumlah_pesanan` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `keterangan` enum('proses','selesai') NOT NULL DEFAULT 'proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`id`, `username`, `nama_paket`, `jumlah_pesanan`, `total_harga`, `keterangan`) VALUES
(9, 'tegar', 'Cuci Basah - Rp.15.000', 5, 75000, 'selesai'),
(10, 'rere', 'Cuci Kering - Rp.10.000', 12, 120000, 'selesai'),
(11, 'rere', 'Cuci Kering - Rp.10.000', 23, 230000, 'selesai'),
(12, 'tegar', 'Cuci Basah - Rp.15.000', 7, 105000, 'selesai'),
(13, 'tegar', 'Cuci Kering - Rp.10.000', 3, 30000, 'proses'),
(14, 'tegar', 'Cuci Basah - Rp.15.000', 2, 30000, 'proses'),
(15, 'tegar', 'Cuci Kering - Rp.10.000', 2, 20000, 'proses'),
(16, 'rere', 'Cuci Kering - Rp.10.000', 2, 20000, 'proses'),
(17, 'rere', 'Cuci Basah + Setrika - Rp.20.000', 3, 60000, 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `kode_paket` varchar(100) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga_paket` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`kode_paket`, `nama_paket`, `harga_paket`) VALUES
('A0120022', 'Cuci Kering - Rp.10.000', 10000),
('A0120023', 'Cuci Basah - Rp.15.000', 15000),
('A0120024', 'Cuci Basah + Setrika - Rp.20.000', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `jenis_kelamin` enum('male','female') NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`id_pelanggan`, `username`, `nama_pelanggan`, `jenis_kelamin`, `telp`, `alamat`, `password`, `role`) VALUES
(1, 'tete', 'tete123', 'male', '08321343245', 'jalan mahali 159', '$2y$10$EVGDs1WUK.ELOfMaR76BLe0qNUYm9/SLceQhymkSDx2sQTLbsdNlG', 'admin'),
(2, 'tegar', 'tegar123', 'female', '081234324543', 'gumawang belitang sumatera selatan seten', '$2y$10$YCBOlvhw.JQiE1.o.3oDQ.SxWvEPRIaqg5jDhAWybxvNQYkh82eQO', 'user'),
(6, 'rere', 'rere123', 'female', '012382137873284', 'fdsafdsa', '$2y$10$5/G3ezlMmIwNRcR7fv5g0ePjnqrtCPnKDT6YlrtvghUvnQCBXAh5e', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `jumlah_total_harga` decimal(10,2) NOT NULL,
  `keterangan` enum('proses','selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `username`, `tgl_terima`, `tgl_selesai`, `jumlah_total_harga`, `keterangan`) VALUES
(2, 'tegar', '2024-01-15', '2024-01-18', 60000.00, 'selesai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`kode_paket`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
