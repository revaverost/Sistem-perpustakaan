-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 07:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dataperpus`
--
CREATE DATABASE IF NOT EXISTS `dataperpus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dataperpus`;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode_buku` char(4) NOT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `penerbit` varchar(20) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `kj_buku` char(1) DEFAULT NULL,
  `jml_awal` int(11) NOT NULL,
  `jml_buku` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `penerbit`, `pengarang`, `tahun_terbit`, `kj_buku`, `jml_awal`, `jml_buku`, `stok`, `harga`) VALUES
('0001', 'Laut', 'Bhuana', 'POLLY CHEESEMAN', '2022', '4', 10, 9, 9, 200000),
('0002', 'Kamus Pintar 3 Bahasa', 'Gema Insani', 'TIM GEMA INSANI', '2025', '6', 15, 15, 15, 150000),
('0003', 'Majalah Prestige', 'Hitawasana Luhur', 'PRESTIGE INDONESIA', '2025', '7', 5, 5, 5, 80000),
('0004', 'Resep Tumisan', 'Gramedia', 'SISCA SOEWTOMOI', '2013', '5', 3, 3, 3, 30000),
('0005', 'Sejarah Sriwijaya', 'Falcon', 'SUPRAPTO.N', '2015', '2', 11, 11, 11, 200000),
('0006', 'Matematika Dasar', 'Adanu Abimata', 'MELINDA RISMAWATI, M.PD. ', '2023', '3', 40, 40, 40, 65000),
('0007', 'Hello Cello', 'Kawah Media', 'NADIA RISTIVANI', '2019', '1', 12, 12, 12, 99000),
('0008', 'Laut Bercerita', 'Gramedia', 'LEILA SALIKHA CHUDORI', '2017', '1', 6, 6, 6, 130000),
('0009', 'Sang Pemimpi', 'Bentang', 'ANDREA HIRATA', '2006', '1', 3, 3, 2, 75000),
('0010', 'Ensiklopedia Nusantara: Papua', 'Khalifah Mediatama', 'IGREA SISWANTO', '2018', '4', 2, 2, 2, 60000),
('0011', 'Rahasia Nusantara: candi misterius Wangsa Syailend', 'Kawah Media', 'ASISI SUHARIYANTO', '2024', '2', 6, 5, 6, 88000),
('0012', 'Jejak Nusantara', 'Selat Media', 'CELLIA WIJAYA DAN LI HANYU', '2025', '2', 7, 7, 7, 70000),
('0013', 'Majalah Hidup', 'Yayasan HIDUP ', 'HIDUP', '2020', '7', 2, 2, 2, 30000),
('0014', '424 Resep Lauk', 'Gramedia', 'LILLY T. ERWIN', '2014', '5', 3, 3, 3, 79000),
('0016', 'Kamus bahasa Indonesia', 'Gramedia', 'DENDY SUGONO', '2019', '6', 5, 4, 4, 109000),
('0017', 'Pelajaran agama Islam', 'Republika', 'PROF. DR. HAMKA', '2020', '3', 6, 5, 6, 49000);

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pm`
--

CREATE TABLE `daftar_pm` (
  `kode_pm` char(6) NOT NULL,
  `nis` char(8) DEFAULT NULL,
  `kode_buku` char(4) DEFAULT NULL,
  `kode_pg` char(4) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `ptgl_kembali` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `ket_terlambat` char(1) DEFAULT NULL,
  `ket_denda` int(11) DEFAULT NULL,
  `denda` int(11) DEFAULT NULL,
  `ket_selesai` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_pm`
--

INSERT INTO `daftar_pm` (`kode_pm`, `nis`, `kode_buku`, `kode_pg`, `tanggal`, `ptgl_kembali`, `tgl_kembali`, `ket_terlambat`, `ket_denda`, `denda`, `ket_selesai`) VALUES
('000001', '21220001', '0001', 'pg02', '2025-03-02', '2025-03-05', '2025-03-05', '1', 0, 0, '1'),
('000002', '21220002', '0002', 'pg02', '2025-03-04', '2025-03-07', '2025-03-10', '2', 3000, 3000, '1'),
('000003', '23240001', '0005', 'pg02', '2025-03-04', '2025-03-07', '2025-03-11', '2', 4000, 4000, '1'),
('000004', '23240002', '0005', 'pg02', '2025-03-04', '2025-03-07', '2025-03-09', '3', 200000, 200000, '1'),
('000005', '22230003', '0003', 'pg01', '2025-03-03', '2025-03-06', '2025-03-08', '3', 80000, 80000, '1'),
('000006', '21220004', '0005', 'pg01', '2025-03-06', '2025-03-09', '2025-03-11', '2', 2000, 2000, '1'),
('000007', '22230003', '0002', 'pg01', '2025-03-03', '2025-03-06', '2025-03-10', '3', 150000, 150000, '1'),
('000008', '22230003', '0004', 'pg04', '2025-03-03', '2025-03-06', '2025-03-11', '3', 30000, 30000, '1'),
('000009', '23240004', '0001', 'pg04', '2025-03-04', '2025-03-07', '2025-03-07', '1', 0, 0, '1'),
('000010', '21220002', '0002', 'pg03', '2025-03-12', '2025-03-15', '2025-03-14', '1', 0, 0, '1'),
('000011', '21220002', '0005', 'pg03', '2025-03-12', '2025-03-15', '2025-03-14', '1', 0, 0, '1'),
('000012', '21220001', '0002', 'pg03', '2025-04-02', '2025-04-05', '2025-04-12', '2', 7000, 7000, '1'),
('000013', '22230001', '0002', 'pg03', '2025-04-01', '2025-04-04', '2025-04-06', '3', 152000, 152000, '1'),
('000014', '22230001', '0004', 'pg03', '2025-04-01', '2025-04-04', '2025-04-04', '1', 0, 0, '1'),
('000015', '21220004', '0003', 'pg03', '2025-04-08', '2025-04-11', '2025-04-12', '3', 81000, 81000, '1'),
('000016', '21220006', '0006', 'pg03', '2025-04-09', '2025-04-12', '2025-04-14', '2', 2000, 2000, '1'),
('000017', '21220004', '0004', 'pg03', '2025-04-07', '2025-04-10', '2025-04-12', '2', 2000, 2000, '1'),
('000018', '22230002', '0007', 'pg03', '2025-04-08', '2025-04-11', '2025-04-14', '2', 3000, 3000, '1'),
('000019', '22230005', '0008', 'pg03', '2025-04-09', '2025-04-12', '2025-04-12', '1', 0, 0, '1'),
('000020', '23240006', '0008', 'pg03', '2025-04-09', '2025-04-12', '2025-04-12', '1', 0, 0, '1'),
('000021', '21220002', '0005', 'pg02', '2025-04-10', '2025-04-13', '2025-04-15', '2', 2000, 2000, '1'),
('000022', '21220002', '0010', 'pg03', '2025-04-10', '2025-04-13', '2025-04-16', '2', 3000, 2000, '2'),
('000023', '22230001', '0016', 'pg03', '2025-04-10', '2025-04-13', '2025-04-13', '1', 0, 0, '1'),
('000024', '22230005', '0011', 'pg03', '2025-04-12', '2025-04-15', '2025-04-11', '3', 88000, 88000, '1'),
('000025', '21220004', '0001', 'pg03', '2025-04-10', '2025-04-13', '2025-04-13', '1', 0, 0, '1'),
('000026', '22230009', '0016', 'pg03', '2025-04-10', '2025-04-13', '2025-04-24', '3', 110000, 110000, '1'),
('000027', '23240005', '0017', 'pg03', '2025-04-10', '2025-04-13', '2025-04-15', '3', 49000, 0, '2'),
('000028', '21220003', '0001', 'pg03', '2025-04-14', '2025-04-17', '2025-04-17', '3', 200000, 0, '2'),
('000029', '21220004', '0001', 'pg03', '2025-04-14', '2025-04-17', '2025-04-17', '1', 0, 0, '1'),
('000030', '21220004', '0001', 'pg03', '2025-04-14', '2025-04-17', '2025-04-24', '2', 7000, 0, '2'),
('000031', '22230003', '0001', 'pg03', '2025-04-14', '2025-04-17', '2025-04-17', '3', 200000, 0, '2'),
('000032', '22230004', '0009', 'pg03', '2025-04-08', '2025-04-11', NULL, NULL, NULL, NULL, NULL);

--
-- Triggers `daftar_pm`
--
DELIMITER $$
CREATE TRIGGER `buku_hilang` AFTER UPDATE ON `daftar_pm` FOR EACH ROW BEGIN
    -- Jika buku dinyatakan hilang dan sebelumnya belum hilang, kurangi jml_buku
    IF NEW.ket_terlambat = '3' AND (OLD.ket_terlambat IS NULL OR OLD.ket_terlambat <> '3') THEN
        UPDATE buku 
        SET jml_buku = jml_buku - 1
        WHERE kode_buku = NEW.kode_buku;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `daftar_pm` FOR EACH ROW BEGIN
    -- Pastikan stok hanya berkurang jika tgl_kembali NULL
    IF NEW.tgl_kembali IS NULL THEN
        UPDATE buku 
        SET stok = stok - 1
        WHERE kode_buku = NEW.kode_buku;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER UPDATE ON `daftar_pm` FOR EACH ROW BEGIN
    -- Tambah stok hanya jika sebelumnya tgl_kembali masih NULL atau '0000-00-00'
    -- dan sekarang sudah diisi, serta buku tidak hilang (ket_terlambat <> '3')
    IF (
        (OLD.tgl_kembali IS NULL OR OLD.tgl_kembali = '0000-00-00') AND
        (NEW.tgl_kembali IS NOT NULL AND NEW.tgl_kembali <> '0000-00-00') AND
        (NEW.ket_terlambat <> '3')
    ) THEN
        UPDATE buku 
        SET stok = stok + 1
        WHERE kode_buku = NEW.kode_buku;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `kode_pg` char(4) NOT NULL,
  `nama_pg` varchar(50) DEFAULT NULL,
  `jabatan` char(1) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`kode_pg`, `nama_pg`, `jabatan`, `jk`, `username`, `password`) VALUES
('pg01', 'RATNATIAN', '2', '2', 'ranatian', '$2y$10$WcEZtpn2W9F4GBEB20uR8OKq1pa1YcJ2omp4k9LpeL7VjRgkvftEe'),
('pg02', 'HASAN MARZUKI', '2', '1', 'hasanmarzuki', '$2y$10$ppq653ENMg0T0/ajL895X.WcPAkrZb32nJ7GojJ4OwFhwffyxMFIu'),
('pg03', 'SUKMAHADIANA', '1', '1', 'sukmahadiana', '$2y$10$6.Qr39OGyXVKOeq6IBKKtuHXb9LyYYOmHIQE4d6o2m4Y5r23IoIgO'),
('pg04', 'REVA', '2', '2', 'revatriana', '$2y$10$/q45Jnfli1qpimXh60axjuSCtGwCZGNuG6xlBAyhCdvFwAvmoPv6u');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` char(8) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kelas` char(1) DEFAULT NULL,
  `prodi` char(1) DEFAULT NULL,
  `tingkat` char(1) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `kelas`, `prodi`, `tingkat`, `jk`) VALUES
('21220001', 'BAGAS SUCIPTO', '3', '1', '1', '1'),
('21220002', 'JEANDRA RADEKSA', '3', '3', '2', '1'),
('21220003', 'ANINDYA SUKMA', '3', '6', '3', '2'),
('21220004', 'ARSAKAA KEELAN', '3', '8', '2', '1'),
('21220005', 'DAVID LOUIS', '1', '6', '2', '1'),
('21220006', 'ENAMI ASA', '1', '7', '1', '2'),
('22230001', 'KEYLA RISYA HASAN', '2', '4', '1', '2'),
('22230002', 'LINTANG ALFIANITA AZZAHRA', '2', '4', '1', '2'),
('22230003', 'REVA TRIANA SUKMA', '2', '4', '1', '2'),
('22230004', 'DWI RAMADANI MAGHFIROH', '3', '4', '1', '2'),
('22230005', 'GERRY', '1', '1', '2', '1'),
('22230006', 'DENNY', '2', '5', '2', '1'),
('22230007', 'SYEILA NISA', '2', '4', '2', '2'),
('22230008', 'SHAFAH', '3', '6', '3', '2'),
('22230009', 'RAYHANA ', '2', '3', '2', '2'),
('23240001', 'KINANTI', '1', '2', '2', '2'),
('23240002', 'HAEKAL LEE', '1', '5', '2', '1'),
('23240003', 'KANEYLA ADELIA', '1', '3', '3', '2'),
('23240004', 'RADEYA ANANDA', '1', '8', '2', '1'),
('23240005', 'MEISILLA', '2', '4', '1', '2'),
('23240006', 'DEALOVA ZAHRA', '2', '2', '2', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indexes for table `daftar_pm`
--
ALTER TABLE `daftar_pm`
  ADD PRIMARY KEY (`kode_pm`),
  ADD KEY `nis` (`nis`),
  ADD KEY `kode_buku` (`kode_buku`),
  ADD KEY `kode_pg` (`kode_pg`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`kode_pg`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_pm`
--
ALTER TABLE `daftar_pm`
  ADD CONSTRAINT `daftar_pm_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `daftar_pm_ibfk_2` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `daftar_pm_ibfk_3` FOREIGN KEY (`kode_pg`) REFERENCES `pegawai` (`kode_pg`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
