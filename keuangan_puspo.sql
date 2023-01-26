-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2021 at 10:49 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan_puspo`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_anggaran`
--

CREATE TABLE `detail_anggaran` (
  `id` int(10) NOT NULL,
  `id_anggaran` int(10) DEFAULT NULL,
  `divisi_id` int(10) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `divisi_id` int(11) NOT NULL,
  `divisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`divisi_id`, `divisi`) VALUES
(1, 'Puspo Budoyo'),
(2, 'Bendahara Pagelaran'),
(3, 'Bendahara Sekolah Budaya'),
(4, 'Bendahara Aset');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` int(13) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nama_akun`
--

CREATE TABLE `nama_akun` (
  `id` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `nama_akun` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nama_akun`
--

INSERT INTO `nama_akun` (`id`, `jenis`, `nama_akun`) VALUES
(1, 'pemasukan', 'Dana Sponsor'),
(2, 'pemasukan', 'Donasi'),
(3, 'pemasukan', 'Titipan Dana'),
(4, 'pemasukan', 'Dana Talangan'),
(5, 'pemasukan', 'Sumber Dana'),
(6, 'pemasukan', 'Iuran Bulanan'),
(7, 'pemasukan', 'Donasi Sekolah'),
(8, 'pengeluaran', 'Honor Pendukung Acara'),
(9, 'pengeluaran', 'Honor Karyawan'),
(10, 'pengeluaran', 'Transport Latihan'),
(11, 'pengeluaran', 'Konsumsi Latihan'),
(12, 'pengeluaran', 'Konsumsi Acara'),
(13, 'pengeluaran', 'Pemotretan & Casting'),
(14, 'pemasukan', 'Partisipasi Undangan'),
(15, 'pemasukan', 'Pinjaman'),
(16, 'pengeluaran', 'Bunga Tabungan'),
(17, 'pengeluaran', 'Pajak'),
(18, 'pengeluaran', 'Administrasi Tabungan'),
(19, 'pengeluaran', 'Lain-lain'),
(20, 'pengeluaran', 'Operasional Latihan'),
(21, 'pengeluaran', 'Perlengkapan'),
(22, 'pengeluaran', 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `divisi_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `role_id`, `divisi_id`) VALUES
(10, 'Administrator', '18009d695a7f0d619e706258713c6c332e369ab8f5', '1b00e93a5a7f0d61d8ddd2558846', 1, 1),
(11, 'Pagelaran', 'ac00c6740a810d614c57b3960067fa0fcccbbb9e9eae5b1824bcaaa19066df0137dea7', 'b000c45a0a810d6131d3a7dc58b5', 3, 2),
(12, 'Sekolah Budaya Nusantara', 'e4017b197c7a0d617529130c67f1abd5009fa10a749dbcfc6c442831338c4c5f41', 'e901d2897c7a0d610aa2b2f85746', 3, 3),
(13, 'Aset', '9203eb48937a0d6194bf1d4657acf06f293f2a3f7e027fa413a99f4cb01e', '9603bc07937a0d61ed0b1d8e24ab', 3, 4),
(15, 'Puspo Budoyo', 'd9038d4f9aa30e6133c0cc2c8fe1e4ee935951970d132be0d57658681e', 'dc0369c09aa30e614ad4f3eeaef8', 2, 1),
(17, 'Bendahara Aset 2', 'a5fdff453f342f6100e7671ae2021998d84aff1aa4154a97ada8adc1775e7a', 'a5fdc4383f342f6134d6c994808a', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `peran`
--

CREATE TABLE `peran` (
  `role_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peran`
--

INSERT INTO `peran` (`role_id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Bendahara Puspo Budoyo'),
(3, 'Bendahara Divisi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`divisi_id`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nama_akun`
--
ALTER TABLE `nama_akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peran`
--
ALTER TABLE `peran`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `divisi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nama_akun`
--
ALTER TABLE `nama_akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `peran`
--
ALTER TABLE `peran`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
