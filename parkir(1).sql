-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13 Jan 2015 pada 08.46
-- Versi Server: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `buku_id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(75) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `harga_pinjam` int(11) NOT NULL,
  `denda_pinjam` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`buku_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`buku_id`, `judul_buku`, `pengarang`, `jenis_id`, `harga_pinjam`, `denda_pinjam`, `status`) VALUES
(1, 'Harry Potter', 'Max Lewis', 1, 2000, 500, 1),
(2, 'gajah mada', 'mak', 1, 2000, 3000, 1),
(3, 'Rajawali', 'Fadholi', 1, 2000, 3000, 1),
(4, 'Harr', 'Fad', 1, 2000, 3000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis`
--

CREATE TABLE IF NOT EXISTS `jenis` (
  `jenis_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`jenis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `jenis`
--

INSERT INTO `jenis` (`jenis_id`, `nama`, `status`) VALUES
(1, 'Fiksi', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`level_id`, `nama`, `status`) VALUES
(1, 'Admin', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` varchar(32) NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_petugas`, `nama_lengkap`, `username`, `password`, `level`) VALUES
(1, 'Fadholi FH', 'fad', 'admin@', 'admin'),
(2, 'Hafid Alpin AG', 'al', 'all', 'admin'),
(3, 'admin', 'admin', 'admin', 'admin'),
(4, 'petugas', 'petugas', 'petugas', 'petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `parkir`
--

CREATE TABLE IF NOT EXISTS `parkir` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nopol` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `masuk` time NOT NULL,
  `keluar` time DEFAULT NULL,
  `lama_parkir` mediumint(9) DEFAULT NULL,
  `biaya` varchar(100) DEFAULT NULL,
  `id_petugas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data untuk tabel `parkir`
--

INSERT INTO `parkir` (`id`, `nopol`, `tanggal`, `masuk`, `keluar`, `lama_parkir`, `biaya`, `id_petugas`) VALUES
(58, 'R 12 D', '2014-08-28', '22:56:45', '22:57:06', 0, '1000', 2),
(59, 'AA 1 AA', '2014-08-29', '13:36:27', '13:36:39', 0, '1000', 4),
(60, 'A 1 B', '2014-08-29', '13:36:53', '13:37:03', 0, '1000', 4),
(61, 'RI 2', '2014-08-29', '14:02:40', '20:47:47', 6, '7000', 4),
(62, 'R 44 A', '2014-08-29', '14:27:26', '20:32:21', 6, '7000', 3),
(63, 'F 4 AB', '2014-08-31', '18:35:53', '18:36:15', 0, '1000', 3),
(64, 'F 44 AA', '2014-08-31', '18:40:26', '18:40:46', 0, '1000', 4),
(65, 'R 1 AS', '2014-09-01', '09:57:32', '12:49:55', 3, '4000', 4),
(66, 'R 1 AS', '2014-09-01', '12:50:45', NULL, NULL, NULL, 3),
(67, 'R 4 AS', '2014-09-01', '12:51:22', '12:52:05', 0, '1000', 3),
(68, 'AA 1 FF', '2014-09-12', '10:50:27', NULL, NULL, NULL, 3),
(69, 'AA 2 FF', '2014-09-12', '10:50:51', '10:51:15', 0, '1000', 3);

--
-- Trigger `parkir`
--
DROP TRIGGER IF EXISTS `parkir`;
DELIMITER //
CREATE TRIGGER `parkir` BEFORE INSERT ON `parkir`
 FOR EACH ROW begin
	set new.tanggal = now();
	set new.masuk = now();
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `transaksi_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_harus_kembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `denda` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `petugas` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_parkir`
--

CREATE TABLE IF NOT EXISTS `t_parkir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tempat` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kota` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `t_parkir`
--

INSERT INTO `t_parkir` (`id`, `nama_tempat`, `alamat`, `kota`) VALUES
(1, 'Mall Senayan City', 'Jl. Senayan No.132, Jakarta Pusat, Jakarta', 'Jakarta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `tgl_lahir` datetime NOT NULL,
  `level_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `nama_lengkap`, `foto`, `alamat`, `no_hp`, `tgl_lahir`, `level_id`, `status`) VALUES
(1, 'rachel', 'rachel', 'rachel gita', 'default.jpg', 'Banjarnegara', '08122776856', '1997-10-23 00:00:00', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
