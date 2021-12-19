-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Des 2021 pada 08.45
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transaksi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0->pending, 1->paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `invoice`, `tanggal`, `total`, `status`) VALUES
(1, 'INV202112180926', '2021-12-18 09:06:26', 22000, '1'),
(2, 'INV202112180912', '2021-12-18 09:07:12', 22000, '0'),
(3, 'INV202112180924', '2021-12-18 09:07:24', 22000, '0'),
(4, 'INV202112180944', '2021-12-18 09:08:44', 0, '0'),
(5, 'INV202112180905', '2021-12-18 09:09:05', 22000, '0'),
(6, 'INV202112180915', '2021-12-18 09:09:15', 18000, '0'),
(7, 'INV202112180943', '2021-12-18 09:11:43', 18000, '0'),
(8, 'INV202112180946', '2021-12-18 09:11:46', 18000, '0'),
(9, 'INV202112180955', '2021-12-18 09:12:55', 18000, '0'),
(10, 'INV202112180907', '2021-12-18 09:13:07', 18000, '0'),
(11, 'INV202112180915', '2021-12-18 09:13:15', 18000, '0'),
(12, 'INV202112190851', '2021-12-19 08:29:51', 2600, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `id_transaksi`, `id_item`, `jumlah`, `harga`) VALUES
(1, 1, 1, 2, 2000),
(2, 1, 2, 3, 6000),
(3, 2, 1, 2, 2000),
(4, 2, 2, 3, 6000),
(5, 3, 1, 2, 2000),
(6, 3, 2, 3, 6000),
(7, 5, 1, 2, 2000),
(8, 5, 2, 3, 6000),
(9, 6, 1, 0, 2000),
(10, 6, 2, 3, 6000),
(11, 7, 1, 0, 2000),
(12, 7, 2, 3, 6000),
(13, 8, 1, 0, 2000),
(14, 8, 2, 3, 6000),
(15, 9, 1, 0, 2000),
(16, 9, 2, 3, 6000),
(17, 10, 1, 0, 2000),
(18, 10, 2, 3, 6000),
(19, 11, 1, 0, 2000),
(20, 11, 2, 3, 6000),
(21, 12, 1, 1, 2000),
(22, 12, 2, 3, 200);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
