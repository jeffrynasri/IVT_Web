-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 31 Des 2016 pada 07.32
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ivt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `nib` int(11) NOT NULL,
  `tanggal_tambah` date DEFAULT NULL,
  `nama` varchar(256) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`nib`, `tanggal_tambah`, `nama`, `jumlah`, `harga_jual`) VALUES
(2, '2016-10-26', 'Susu Milo', 2, 50000),
(3, '2016-10-26', 'Susu Bear Brand', 2, 40000),
(4, '2016-10-27', 'Indomie Rasa Goreng', 4, 15000),
(7, '2016-10-26', 'Indomie Rasa Kari', 4, 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rusak` int(11) NOT NULL,
  `nipg` int(11) DEFAULT NULL,
  `nib` int(11) DEFAULT NULL,
  `Keterangan` varchar(256) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rusak`, `nipg`, `nib`, `Keterangan`, `jumlah`) VALUES
(1, 1, 3, 'Kalengnya Penyok', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajer`
--

CREATE TABLE `manajer` (
  `nim` int(11) NOT NULL,
  `nama` varchar(256) DEFAULT NULL,
  `no_tlp` varchar(256) DEFAULT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `manajer`
--

INSERT INTO `manajer` (`nim`, `nama`, `no_tlp`, `username`, `password`) VALUES
(1, 'Joker', '082313131', 'amin', 'amin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `nipg` int(11) NOT NULL,
  `nama` varchar(256) DEFAULT NULL,
  `alamat` varchar(256) DEFAULT NULL,
  `no_tlp` varchar(256) DEFAULT NULL,
  `username` varchar(11) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`nipg`, `nama`, `alamat`, `no_tlp`, `username`, `password`) VALUES
(1, 'KUri', 'Purworejo', '082313131', 'amin', 'amin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasok`
--

CREATE TABLE `pemasok` (
  `nip` int(11) NOT NULL,
  `nama` varchar(256) DEFAULT NULL,
  `alamat` varchar(256) DEFAULT NULL,
  `no_tlp` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemasok`
--

INSERT INTO `pemasok` (`nip`, `nama`, `alamat`, `no_tlp`) VALUES
(1, 'Kertajaya Shop', 'Kertajaya No 2', '082313131');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_barang`
--

CREATE TABLE `pembelian_barang` (
  `id_pembelian` int(11) NOT NULL,
  `nim` int(11) DEFAULT NULL,
  `nip` int(11) DEFAULT NULL,
  `nib` int(11) DEFAULT NULL,
  `id_tra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian_barang`
--

INSERT INTO `pembelian_barang` (`id_pembelian`, `nim`, `nip`, `nib`, `id_tra`) VALUES
(1, 1, 1, 2, 2),
(2, 1, 1, 3, 3),
(4, 1, 1, 4, 4),
(7, 1, 1, 7, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_barang`
--

CREATE TABLE `penjualan_barang` (
  `id_penjualan` int(11) NOT NULL,
  `nipg` int(11) DEFAULT NULL,
  `nib` int(11) DEFAULT NULL,
  `id_tra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan_barang`
--

INSERT INTO `penjualan_barang` (`id_penjualan`, `nipg`, `nib`, `id_tra`) VALUES
(1, 1, 4, 8),
(3, 1, 7, 9),
(4, 1, 3, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_tra` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `pemasukan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_tra`, `tanggal`, `pengeluaran`, `pemasukan`) VALUES
(2, '2016-10-26', 50000, 0),
(3, '2016-10-26', 30000, 0),
(4, '2016-10-26', 50000, 0),
(7, '2016-10-26', 30000, 0),
(8, '2016-10-27', 0, 49000),
(9, '2016-10-26', 0, 123),
(10, '2016-10-27', 0, 20000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`nib`);

--
-- Indexes for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rusak`),
  ADD KEY `nib` (`nib`),
  ADD KEY `nipg` (`nipg`);

--
-- Indexes for table `manajer`
--
ALTER TABLE `manajer`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nipg`);

--
-- Indexes for table `pemasok`
--
ALTER TABLE `pemasok`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `pembelian_barang`
--
ALTER TABLE `pembelian_barang`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `nip` (`nip`),
  ADD KEY `nib` (`nib`),
  ADD KEY `id_tra` (`id_tra`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `penjualan_barang`
--
ALTER TABLE `penjualan_barang`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_tra` (`id_tra`),
  ADD KEY `nib` (`nib`),
  ADD KEY `nipg` (`nipg`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_tra`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `nib` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  MODIFY `id_barang_rusak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `manajer`
--
ALTER TABLE `manajer`
  MODIFY `nim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `nipg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pemasok`
--
ALTER TABLE `pemasok`
  MODIFY `nip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pembelian_barang`
--
ALTER TABLE `pembelian_barang`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `penjualan_barang`
--
ALTER TABLE `penjualan_barang`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_tra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD CONSTRAINT `barang_rusak_ibfk_2` FOREIGN KEY (`nib`) REFERENCES `barang` (`nib`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_rusak_ibfk_3` FOREIGN KEY (`nipg`) REFERENCES `pegawai` (`nipg`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian_barang`
--
ALTER TABLE `pembelian_barang`
  ADD CONSTRAINT `pembelian_barang_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pemasok` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_barang_ibfk_3` FOREIGN KEY (`nib`) REFERENCES `barang` (`nib`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_barang_ibfk_4` FOREIGN KEY (`id_tra`) REFERENCES `transaksi` (`id_tra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_barang_ibfk_5` FOREIGN KEY (`nim`) REFERENCES `manajer` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan_barang`
--
ALTER TABLE `penjualan_barang`
  ADD CONSTRAINT `penjualan_barang_ibfk_1` FOREIGN KEY (`id_tra`) REFERENCES `transaksi` (`id_tra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_barang_ibfk_3` FOREIGN KEY (`nib`) REFERENCES `barang` (`nib`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_barang_ibfk_4` FOREIGN KEY (`nipg`) REFERENCES `pegawai` (`nipg`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
