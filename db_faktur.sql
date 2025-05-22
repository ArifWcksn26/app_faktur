-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2025 pada 11.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_faktur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `perusahaan_cust` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `perusahaan_cust`, `alamat`) VALUES
(1, 'Andi Setiawan', 'PT Teknologi Indonesia', 'Jl. Merpati No. 1, Jakarta'),
(2, 'Budi Santoso', 'CV Karya Abadi', 'Jl. Kenanga No. 2, Bandung'),
(3, 'Citra Dewi', 'PT Maju Jaya', 'Jl. Melati No. 3, Surabaya'),
(4, 'Dewi Kurnia', 'CV Sejahtera', 'Jl. Anggrek No. 4, Yogyakarta'),
(5, 'Eko Prasetyo', 'PT Sukses Selalu', 'Jl. Cempaka No. 5, Semarang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_faktur`
--

CREATE TABLE `detail_faktur` (
  `no_faktur` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `detail_faktur`
--

INSERT INTO `detail_faktur` (`no_faktur`, `id_produk`, `qty`, `price`) VALUES
(6, 2, 1, 750000.00),
(6, 1, 1, 625000.00),
(2, 3, 2, 50000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur`
--

CREATE TABLE `faktur` (
  `no_faktur` int(11) NOT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `id_perusahaan` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `due_date` date NOT NULL,
  `metode_bayar` varchar(50) NOT NULL,
  `ppn` decimal(10,2) DEFAULT 0.00,
  `dp` decimal(10,2) DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL,
  `user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `faktur`
--

INSERT INTO `faktur` (`no_faktur`, `id_customer`, `id_perusahaan`, `tanggal`, `due_date`, `metode_bayar`, `ppn`, `dp`, `grand_total`, `user`) VALUES
(2, 2, 2, '2023-05-02', '2023-05-16', 'Tunai', 30000.00, 200000.00, 1800000.00, 'Admin'),
(4, 3, 4, '2025-05-24', '2025-05-31', 'Transfer', 12000.00, 0.00, 7281122.00, 'Admin'),
(5, 1, 1, '2025-05-17', '2025-05-30', 'Transfer', 165000.00, 500000.00, 1040000.00, 'Admin'),
(6, 1, 1, '2025-05-17', '2025-05-30', 'Transfer', 165000.00, 500000.00, 1040000.00, 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `alamat`, `no_telp`, `fax`) VALUES
(1, 'PT Teknologi Indonesia Raya', 'Jl. Sudirman No. 123, Jakarta', '021-12345678', '021-87654321'),
(2, 'CV Karya Abadi', 'Jl. Diponegoro No. 456, Bandung', '022-23456789', '022-98765432'),
(3, 'PT Maju Jaya', 'Jl. Merdeka No. 789, Surabaya', '031-34567890', '031-09876543'),
(4, 'CV Sejahtera', 'Jl. Raya No. 101, Yogyakarta', '0274-4567890', '0274-0987654'),
(5, 'PT Sukses Selalu', 'Jl. Cempaka No. 5, Semarang', '024-56789012', '024-2109876'),
(6, 'PT Integra Teknologi', 'Jl. Pondok Pakulonan Blok H2 No.18 RT 003/004', '083140223072', '031212311');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `price`, `jenis`, `stock`) VALUES
(1, 'Smartphone', 7500000.00, 'Elektronik', 20),
(2, 'Headphones', 1500000.00, 'Elektronik', 30),
(3, 'Buku', 25000.00, 'Pendidikan', 100),
(4, 'Kemeja', 45000.00, 'Pakaian', 50),
(5, 'Sepatu', 60000.00, 'Pakaian', 40);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `detail_faktur`
--
ALTER TABLE `detail_faktur`
  ADD KEY `no_faktur` (`no_faktur`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`no_faktur`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_perusahaan` (`id_perusahaan`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `faktur`
--
ALTER TABLE `faktur`
  MODIFY `no_faktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_faktur`
--
ALTER TABLE `detail_faktur`
  ADD CONSTRAINT `detail_faktur_ibfk_1` FOREIGN KEY (`no_faktur`) REFERENCES `faktur` (`no_faktur`),
  ADD CONSTRAINT `detail_faktur_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `faktur`
--
ALTER TABLE `faktur`
  ADD CONSTRAINT `faktur_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `faktur_ibfk_2` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
