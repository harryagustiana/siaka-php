-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30 Mei 2016 pada 14.20
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ciaka_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_bahanpelajaran`
--

CREATE TABLE `kmn_bahanpelajaran` (
  `ID_MATAPELAJARAN` varchar(10) NOT NULL,
  `ID_LEVELKELAS` varchar(10) DEFAULT NULL,
  `KETERANGAN` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_bahanpelajaran`
--

INSERT INTO `kmn_bahanpelajaran` (`ID_MATAPELAJARAN`, `ID_LEVELKELAS`, `KETERANGAN`) VALUES
('KBM0001', 'KG0002', 'Deskripsi logaritma adalah'),
('KBM0002', 'KG0001', '<p>Test ke <strong>dua</strong></p>'),
('KBM0003', 'KG0005', '<p>Deskripsi Materi C</p>\r\n<p>&nbsp;</p>\r\n<p><img src="/assets/tinymce_images/Tshirt_Harry_Artworks_Kekinian.png" width="107" height="106" /></p>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_hasilbelajar`
--

CREATE TABLE `kmn_hasilbelajar` (
  `NO_TEST` varchar(50) NOT NULL,
  `ID_SISWA` varchar(50) DEFAULT NULL,
  `TGL_TEST` date DEFAULT NULL,
  `WAKTU` int(11) DEFAULT NULL,
  `SKOR` int(11) DEFAULT NULL,
  `ID_LEVELKELAS` varchar(10) DEFAULT NULL,
  `CATATAN` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_hasilbelajar`
--

INSERT INTO `kmn_hasilbelajar` (`NO_TEST`, `ID_SISWA`, `TGL_TEST`, `WAKTU`, `SKOR`, `ID_LEVELKELAS`, `CATATAN`) VALUES
('KTR2016050001', 'KS06050001', '2016-05-10', 90, 100, 'KG0004', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_levelkelas`
--

CREATE TABLE `kmn_levelkelas` (
  `ID_LEVELKELAS` varchar(10) NOT NULL,
  `NAMA_LEVEL` varchar(30) DEFAULT NULL,
  `MATA_PELAJARAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_levelkelas`
--

INSERT INTO `kmn_levelkelas` (`ID_LEVELKELAS`, `NAMA_LEVEL`, `MATA_PELAJARAN`) VALUES
('KG0001', 'A', 'Mathematic'),
('KG0002', 'B', 'Mathematic'),
('KG0003', 'C', 'Mathematic'),
('KG0004', 'A', 'EFL'),
('KG0005', 'B', 'EFL'),
('KG0006', 'C', 'EFL'),
('KG0007', 'D', 'Mathematic');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_levelpengguna`
--

CREATE TABLE `kmn_levelpengguna` (
  `ID_LEVELPENGGUNA` varchar(10) NOT NULL,
  `ROLE` text,
  `KETERANGAN` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_levelpengguna`
--

INSERT INTO `kmn_levelpengguna` (`ID_LEVELPENGGUNA`, `ROLE`, `KETERANGAN`) VALUES
('KUR0001', 'Super Administrator', ''),
('KUR0002', 'Admin Akademik', ''),
('KUR0003', 'Admin Pembayaran', ''),
('KUR0004', 'Wali Siswa', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_pembayaran`
--

CREATE TABLE `kmn_pembayaran` (
  `ID_SISWA` varchar(50) DEFAULT NULL,
  `NO_PEMBAYARAN` varchar(50) NOT NULL,
  `NAMA_AKUN` varchar(50) DEFAULT NULL,
  `JUMLAH` int(11) DEFAULT NULL,
  `TGL_BAYAR` date DEFAULT NULL,
  `JAM_BAYAR` varchar(6) DEFAULT NULL,
  `TUJUAN_TRANSFER` tinyint(30) DEFAULT NULL,
  `METODE_TRANSFER` tinyint(1) DEFAULT NULL,
  `BULAN` tinyint(1) DEFAULT NULL,
  `TAHUN` varchar(5) DEFAULT NULL,
  `CATATAN` text,
  `STATUS` tinyint(1) DEFAULT NULL,
  `JENIS_PEMBAYARAN` int(11) DEFAULT NULL,
  `FOTO_BUKTI` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_pembayaran`
--

INSERT INTO `kmn_pembayaran` (`ID_SISWA`, `NO_PEMBAYARAN`, `NAMA_AKUN`, `JUMLAH`, `TGL_BAYAR`, `JAM_BAYAR`, `TUJUAN_TRANSFER`, `METODE_TRANSFER`, `BULAN`, `TAHUN`, `CATATAN`, `STATUS`, `JENIS_PEMBAYARAN`, `FOTO_BUKTI`) VALUES
('KS06050001', 'KP2016050001', NULL, 4000000, '2016-05-10', '18:00', NULL, NULL, 5, '2016', NULL, 1, 0, 'http://localhost/assets/uploads/KP2016050001_EOB Solution Mock Up.jpg'),
('KS06050001', 'KP2016050002', 'Debi', 3000000, '2016-05-10', '18:00', 1, 1, 1, '2016', 'Test 2', 1, 0, 'http://localhost/assets/uploads/KP2016050002_buckle-logo-200.jpeg'),
('KS06050002', 'KP2016050003', 'Harry', 50000, '2016-05-26', '15:00', 1, 1, 1, '2016', 'Test', 0, 0, 'http://localhost/assets/uploads/KP2016050003_kelas-informatika-logo.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_siswa`
--

CREATE TABLE `kmn_siswa` (
  `ID_PENGGUNA` varchar(10) DEFAULT NULL,
  `ID_SISWA` varchar(50) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `KELAS` varchar(100) DEFAULT NULL,
  `SEKOLAH` varchar(100) DEFAULT NULL,
  `ALAMAT` text,
  `MATH_LEVEL` text,
  `EFL_LEVEL` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_siswa`
--

INSERT INTO `kmn_siswa` (`ID_PENGGUNA`, `ID_SISWA`, `NAMA`, `KELAS`, `SEKOLAH`, `ALAMAT`, `MATH_LEVEL`, `EFL_LEVEL`) VALUES
('KUS0001', 'KS06050001', 'Debi Renggana Maulana', '2', 'SMA Negeri 1 Banjaran', 'Baleendah', 'KG0001,KG0002', 'KG0004'),
('KUS0002', 'KS06050002', 'Harry Agustiana', '2', 'SMA Negeri 1 Margahayu', 'Soreang', 'KG0001', 'KG0004,KG0005,KG0006');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmn_user`
--

CREATE TABLE `kmn_user` (
  `ID_PENGGUNA` varchar(10) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `ID_LEVELPENGGUNA` varchar(10) DEFAULT NULL,
  `TGL_TERDAFTAR` datetime DEFAULT NULL,
  `TGL_UBAHDATA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kmn_user`
--

INSERT INTO `kmn_user` (`ID_PENGGUNA`, `USERNAME`, `PASSWORD`, `ID_LEVELPENGGUNA`, `TGL_TERDAFTAR`, `TGL_UBAHDATA`) VALUES
('KUA0001', 'admin', '0192023a7bbd73250516f069df18b500', 'KUR0001', '2016-05-24 01:41:09', '2016-05-30 09:06:46'),
('KUA0002', 'akademik', '0192023a7bbd73250516f069df18b500', 'KUR0002', '2016-05-30 07:36:05', '2016-05-30 09:07:38'),
('KUA0003', 'finance', '0192023a7bbd73250516f069df18b500', 'KUR0003', '2016-05-30 07:43:03', '2016-05-30 09:07:31'),
('KUS0001', 'user1', '0192023a7bbd73250516f069df18b500', 'KUR0004', '2016-05-26 07:02:29', '2016-05-30 09:07:06'),
('KUS0002', 'user2', '0192023a7bbd73250516f069df18b500', 'KUR0004', '2016-05-26 12:38:48', '2016-05-30 09:07:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kmn_bahanpelajaran`
--
ALTER TABLE `kmn_bahanpelajaran`
  ADD PRIMARY KEY (`ID_MATAPELAJARAN`),
  ADD KEY `FK_REFERENCE_8` (`ID_LEVELKELAS`);

--
-- Indexes for table `kmn_hasilbelajar`
--
ALTER TABLE `kmn_hasilbelajar`
  ADD PRIMARY KEY (`NO_TEST`),
  ADD KEY `FK_REFERENCE_6` (`ID_LEVELKELAS`),
  ADD KEY `FK_REFERENCE_7` (`ID_SISWA`);

--
-- Indexes for table `kmn_levelkelas`
--
ALTER TABLE `kmn_levelkelas`
  ADD PRIMARY KEY (`ID_LEVELKELAS`);

--
-- Indexes for table `kmn_levelpengguna`
--
ALTER TABLE `kmn_levelpengguna`
  ADD PRIMARY KEY (`ID_LEVELPENGGUNA`);

--
-- Indexes for table `kmn_pembayaran`
--
ALTER TABLE `kmn_pembayaran`
  ADD PRIMARY KEY (`NO_PEMBAYARAN`),
  ADD KEY `FK_REFERENCE_3` (`ID_SISWA`);

--
-- Indexes for table `kmn_siswa`
--
ALTER TABLE `kmn_siswa`
  ADD PRIMARY KEY (`ID_SISWA`),
  ADD KEY `FK_REFERENCE_2` (`ID_PENGGUNA`);

--
-- Indexes for table `kmn_user`
--
ALTER TABLE `kmn_user`
  ADD PRIMARY KEY (`ID_PENGGUNA`),
  ADD KEY `FK_REFERENCE_9` (`ID_LEVELPENGGUNA`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kmn_bahanpelajaran`
--
ALTER TABLE `kmn_bahanpelajaran`
  ADD CONSTRAINT `FK_REFERENCE_8` FOREIGN KEY (`ID_LEVELKELAS`) REFERENCES `kmn_levelkelas` (`ID_LEVELKELAS`);

--
-- Ketidakleluasaan untuk tabel `kmn_hasilbelajar`
--
ALTER TABLE `kmn_hasilbelajar`
  ADD CONSTRAINT `FK_REFERENCE_6` FOREIGN KEY (`ID_LEVELKELAS`) REFERENCES `kmn_levelkelas` (`ID_LEVELKELAS`),
  ADD CONSTRAINT `FK_REFERENCE_7` FOREIGN KEY (`ID_SISWA`) REFERENCES `kmn_siswa` (`ID_SISWA`);

--
-- Ketidakleluasaan untuk tabel `kmn_pembayaran`
--
ALTER TABLE `kmn_pembayaran`
  ADD CONSTRAINT `FK_REFERENCE_3` FOREIGN KEY (`ID_SISWA`) REFERENCES `kmn_siswa` (`ID_SISWA`);

--
-- Ketidakleluasaan untuk tabel `kmn_siswa`
--
ALTER TABLE `kmn_siswa`
  ADD CONSTRAINT `FK_REFERENCE_2` FOREIGN KEY (`ID_PENGGUNA`) REFERENCES `kmn_user` (`ID_PENGGUNA`);

--
-- Ketidakleluasaan untuk tabel `kmn_user`
--
ALTER TABLE `kmn_user`
  ADD CONSTRAINT `FK_REFERENCE_9` FOREIGN KEY (`ID_LEVELPENGGUNA`) REFERENCES `kmn_levelpengguna` (`ID_LEVELPENGGUNA`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
