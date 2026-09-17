-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Agu 2021 pada 05.21
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appus_lite`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `username_admin` varchar(100) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username_admin`, `password_admin`) VALUES
(1, 'admin', '$2y$10$LRLj6kuNs8xgaSZKgfEg4OiCwEzNkiJ7EPPsBMd0vDK0LEPJv6KXm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_butir_pdf`
--

CREATE TABLE `tb_butir_pdf` (
  `id_pdf` int(11) NOT NULL,
  `kode_soal` varchar(100) NOT NULL,
  `nama_pdf` varchar(255) NOT NULL,
  `kunci_jwb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dokumen`
--

CREATE TABLE `tb_dokumen` (
  `id_dok` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_dokumen`
--

INSERT INTO `tb_dokumen` (`id_dok`, `nama_dokumen`) VALUES
(1, 'media_add/soalmediainteraktif.xlsx'),
(2, 'media_add/soal_sejarah_indonesia.xlsx'),
(3, 'media_add/soal_sejarah_indonesia_12.xlsx'),
(4, 'media_add/soal_sejarah_indonesia_33.xlsx'),
(5, 'media_add/soal_sejarah_indonesia_11.xlsx'),
(6, 'media_add/soal_sejarah_indonesia_19.xlsx'),
(7, 'media_add/soal_sejarah_indonesia_82.xlsx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `username_guru` varchar(50) NOT NULL,
  `password_guru` varchar(255) NOT NULL,
  `pass_show_guru` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `nama_guru`, `username_guru`, `password_guru`, `pass_show_guru`) VALUES
(5, 'Hajid Hamidi, S. Kom', 'hajid', '$2y$10$Qy8s.DdJcWQYehriqxGTY.lCYqVqY7V7u1iRLzMi3IdDRJUGd2S/a', 'hajid'),
(6, 'Hayyu Muiz, S. Pd.', 'hayyu', '$2y$10$Fo5WsKi6qvgW9cLsV3B7Bu8OXnkoR.Vhz66/VLiQN.qytmkWuw6sK', 'hayyu'),
(7, 'Sri Windiharti, S. Pd. I', 'windi', '$2y$10$obk0LCnCuTl2OfU.yv9JQuOLcZdEOMTSEeekLTp24ffAUhpy0Pn/a', 'windi'),
(8, 'Erni Mufidyah, S. Pd.', 'erni', '$2y$10$FKSMZQqsoPMEo.Z5WaU/UOahSTXnnDms.lDWtqhrYDW6gzMk40A2e', 'erni');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru_pengampu`
--

CREATE TABLE `tb_guru_pengampu` (
  `id_pengampu` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_guru_pengampu`
--

INSERT INTO `tb_guru_pengampu` (`id_pengampu`, `id_mapel`, `tingkat`, `id_guru`) VALUES
(7, 4, 'XI', 6),
(9, 5, 'XII', 8),
(10, 7, 'X', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `kode_soal` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `wk_mulai` time NOT NULL,
  `wk_selesai` time NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id_jadwal`, `kode_soal`, `tanggal`, `wk_mulai`, `wk_selesai`, `durasi`) VALUES
(4, 'US6KT', '2021-08-04', '21:00:00', '23:00:00', 120),
(5, 'US9KM', '2021-08-04', '21:50:00', '22:50:00', 90);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_ujian`
--

CREATE TABLE `tb_jenis_ujian` (
  `id_jenis_ujian` int(11) NOT NULL,
  `jenis_ujian` varchar(100) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jenis_ujian`
--

INSERT INTO `tb_jenis_ujian` (`id_jenis_ujian`, `jenis_ujian`, `tahun_ajaran`) VALUES
(2, 'Ujian Akhir Semester Genap', '2020/2021'),
(3, 'Ujian Akhir Semester Gasal', '2020/2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `kode_jurusan` varchar(100) NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `warna_jurusan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`kode_jurusan`, `nama_jurusan`, `warna_jurusan`) VALUES
('jurSTBQG', 'Otomatisasi dan Tata Kelola Perkantoran', '#47dc7b'),
('Jurusan-0JE76', 'Multimedia', '#40b1f7'),
('Jurusan-84F93', 'Rekayasa Perangkat Lunak', '#ff6161'),
('Jurusan-BL328', 'Akuntansi dan Lembaga Keuangan', '#ffe97a'),
('Jurusan-SF8TV', 'Bisnis Daring dan Pemasaran', '#d970ff');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kode_jurusan` varchar(100) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `tingkat`, `kode_jurusan`, `nama_kelas`) VALUES
(1, 'X', 'Jurusan-0JE76', 'X MM 1'),
(2, 'XI', 'Jurusan-84F93', 'XI RPL 1'),
(3, 'X', 'Jurusan-0JE76', 'X MM 2'),
(4, 'XII', 'jurSTBQG', 'XII OTKP 1'),
(6, 'XII', 'jurSTBQG', 'XII OTKP 2'),
(7, 'X', 'Jurusan-BL328', 'X AKL 1'),
(8, 'X', 'Jurusan-SF8TV', 'XI BDP 1'),
(9, 'X', 'jurSTBQG', 'X OTKP 1'),
(10, 'X', 'jurSTBQG', 'X OTKP 2'),
(11, 'XI', 'Jurusan-0JE76', 'XI MM 1'),
(12, 'XI', 'Jurusan-0JE76', 'XI MM 2'),
(13, 'X', 'Jurusan-84F93', 'X RPL 1'),
(14, 'XI', 'Jurusan-BL328', 'XI AKL 2'),
(15, 'XII', 'Jurusan-SF8TV', 'XII BDP 1'),
(17, 'XI', 'Jurusan-84F93', 'XI RPL 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mapel`
--

CREATE TABLE `tb_mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_mapel`
--

INSERT INTO `tb_mapel` (`id_mapel`, `nama_mapel`) VALUES
(3, 'Ilmu Pengetahuan Alam'),
(4, 'Matematika'),
(5, 'Bahasa Indonesia'),
(6, 'Fisika'),
(7, 'Sejarah Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_opsi_jwb`
--

CREATE TABLE `tb_opsi_jwb` (
  `id_opsi` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `opsi_jwb` varchar(255) NOT NULL,
  `media_pendukung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_opsi_jwb`
--

INSERT INTO `tb_opsi_jwb` (`id_opsi`, `id_pertanyaan`, `opsi_jwb`, `media_pendukung`) VALUES
(26, 11, 'Antar muka (user interface)', ''),
(27, 11, 'Storyboard', ''),
(28, 11, 'Struktur navigasi', ''),
(29, 11, 'Action script 3.0', ''),
(30, 11, 'Efek visual', ''),
(31, 12, 'Linier', ''),
(32, 12, 'Hirarki', ''),
(33, 12, 'Jaringan', ''),
(34, 12, 'Spoke and hub', ''),
(35, 12, 'Kombinasi', ''),
(36, 13, 'Linier', ''),
(37, 13, 'Hirarki', ''),
(38, 13, 'Jaringan', ''),
(39, 13, 'Simplicity', ''),
(40, 13, 'Kombinasi', ''),
(41, 14, 'Antar muka (user interface)', ''),
(42, 14, 'Storyboard', ''),
(43, 14, 'Struktur navigasi', ''),
(44, 14, 'Action script 3.0', ''),
(45, 14, 'Efek visual', ''),
(46, 15, 'Linier', ''),
(47, 15, 'Hirarki', ''),
(48, 15, 'Jaringan', ''),
(49, 15, 'Spoke and hub', ''),
(50, 15, 'Kombinasi', ''),
(51, 16, 'Linier', ''),
(52, 16, 'Hirarki', ''),
(53, 16, 'Jaringan', ''),
(54, 16, 'Simplicity', ''),
(55, 16, 'Kombinasi', ''),
(101, 26, 'Geologi', ''),
(102, 26, 'Arkeologi', ''),
(103, 26, 'Tipologi', ''),
(104, 26, 'Epigrafi', ''),
(105, 26, 'Fisiologi', ''),
(106, 27, 'Rumah tinggal yang berupa celah-celah batu karang.', 'media_add/3.png'),
(107, 27, 'Bukit batu karang disepanjang pantai sumatera timur.', ''),
(108, 27, 'Sampah-sampah dapur yang terdiri dari kulit kerang.', ''),
(109, 27, 'Sisa-sisa makanan yang terdiri dari tulang belulang ikan.', ''),
(110, 27, 'Gua-gua tempat tinggal manusia purba zaman mezolithikum.', ''),
(111, 28, 'Suku Dayak', ''),
(112, 28, 'Suku Batak', ''),
(113, 28, 'Suku Toraja', ''),
(114, 28, 'Suku Dayak dan Toraja', ''),
(115, 28, 'Suku Batak, Dayak dan Toraja', ''),
(116, 29, 'Geologi', ''),
(117, 29, 'Arkeologi', ''),
(118, 29, 'Tipologi', ''),
(119, 29, 'Epigrafi', ''),
(120, 29, 'Fisiologi', ''),
(121, 30, 'Rumah tinggal yang berupa celah-celah batu karang.', 'media_add/3_39.png'),
(122, 30, 'Bukit batu karang disepanjang pantai sumatera timur.', ''),
(123, 30, 'Sampah-sampah dapur yang terdiri dari kulit kerang.', ''),
(124, 30, 'Sisa-sisa makanan yang terdiri dari tulang belulang ikan.', ''),
(125, 30, 'Gua-gua tempat tinggal manusia purba zaman mezolithikum.', ''),
(126, 31, 'Suku Dayak', ''),
(127, 31, 'Suku Batak', ''),
(128, 31, 'Suku Toraja', ''),
(129, 31, 'Suku Dayak dan Toraja', ''),
(130, 31, 'Suku Batak, Dayak dan Toraja', ''),
(131, 32, 'Geologi', 'media_add/audio1.wav'),
(132, 32, 'Arkeologi', 'media_add/audio3.wav'),
(133, 32, 'Tipologi', ''),
(134, 32, 'Epigrafi', ''),
(135, 32, 'Fisiologi', ''),
(136, 33, 'Rumah tinggal yang berupa celah-celah batu karang.', 'media_add/3_61.png'),
(137, 33, 'Bukit batu karang disepanjang pantai sumatera timur.', ''),
(138, 33, 'Sampah-sampah dapur yang terdiri dari kulit kerang.', 'media_add/audio5.wav'),
(139, 33, 'Sisa-sisa makanan yang terdiri dari tulang belulang ikan.', ''),
(140, 33, 'Gua-gua tempat tinggal manusia purba zaman mezolithikum.', ''),
(141, 34, 'Suku Dayak', 'media_add/audio2.wav'),
(142, 34, 'Suku Batak', 'media_add/audio4.wav'),
(143, 34, 'Suku Toraja', ''),
(144, 34, 'Suku Dayak dan Toraja', ''),
(145, 34, 'Suku Batak, Dayak dan Toraja', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengampu_jur`
--

CREATE TABLE `tb_pengampu_jur` (
  `id_pengampu_jur` int(11) NOT NULL,
  `id_pengampu` int(11) NOT NULL,
  `kode_jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengampu_jur`
--

INSERT INTO `tb_pengampu_jur` (`id_pengampu_jur`, `id_pengampu`, `kode_jurusan`) VALUES
(1, 7, 'Jurusan-0JE76'),
(2, 7, 'Jurusan-84F93'),
(8, 9, 'jurSTBQG'),
(9, 9, 'Jurusan-0JE76'),
(10, 9, 'Jurusan-84F93'),
(11, 9, 'Jurusan-BL328'),
(12, 9, 'Jurusan-SF8TV'),
(13, 10, 'jurSTBQG'),
(14, 10, 'Jurusan-0JE76'),
(15, 10, 'Jurusan-84F93'),
(16, 10, 'Jurusan-BL328'),
(17, 10, 'Jurusan-SF8TV');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pertanyaan`
--

CREATE TABLE `tb_pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `kode_soal` varchar(50) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `media_pendukung` varchar(255) NOT NULL,
  `kunci_jwb` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pertanyaan`
--

INSERT INTO `tb_pertanyaan` (`id_pertanyaan`, `kode_soal`, `pertanyaan`, `media_pendukung`, `kunci_jwb`) VALUES
(11, 'US9KM', 'Bagian dari multimedia interaktif yang berfungsi untuk menggambarkan dengan jelas hubungan dan rantai kerja seluruh elemen dalam aplikasi adalah…', '', '28'),
(12, 'US9KM', 'Struktur yang paling sederhana dalam mendesain aliran aplikasi multimedia adalah…', '', '31'),
(13, 'US9KM', 'Yang bukan merupakan jenis struktur navigasi di bawah ini adalah…', '', '39'),
(14, 'US9KM', 'Bagian dari multimedia interaktif yang berfungsi untuk menggambarkan dengan jelas hubungan dan rantai kerja seluruh elemen dalam aplikasi adalah…', '', '43'),
(15, 'US9KM', 'Struktur yang paling sederhana dalam mendesain aliran aplikasi multimedia adalah…', '', '46'),
(16, 'US9KM', 'Yang bukan merupakan jenis struktur navigasi di bawah ini adalah…', '', '54'),
(26, 'USBLD', 'Ilmu yang mempelajari benda-benda peninggalan sejarah disebut ….', '5_71.png', '102'),
(27, 'USBLD', 'Kjokkenmoddinger, merupakan salah satu peralatan yang ditemukan pada zaman batu.\nKjokkenmoddinger adalah …\n', 'media_add/4.png', '108'),
(28, 'USBLD', 'Bangsa Indonesia sekarang yang termasuk keturunan bangsa proto melayu ….', 'media_add/5.png', '115'),
(29, 'USBLD', 'Ilmu yang mempelajari benda-benda peninggalan sejarah disebut ….', 'media_add/2_82.png', '117'),
(30, 'USBLD', 'Kjokkenmoddinger, merupakan salah satu peralatan yang ditemukan pada zaman batu.\nKjokkenmoddinger adalah …\n', 'media_add/4_21.png', '123'),
(31, 'USBLD', 'Bangsa Indonesia sekarang yang termasuk keturunan bangsa proto melayu ….', 'media_add/5_71.png', '130'),
(32, 'USBLD', 'Ilmu yang mempelajari benda-benda peninggalan sejarah disebut ….', 'media_add/2_26.png', '132'),
(33, 'USBLD', 'Kjokkenmoddinger, merupakan salah satu peralatan yang ditemukan pada zaman batu.\nKjokkenmoddinger adalah …\n', 'media_add/4_8.png', '138'),
(34, 'USBLD', 'Bangsa Indonesia sekarang yang termasuk keturunan bangsa proto melayu ….', 'media_add/5_2.png', '145');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_profil`
--

CREATE TABLE `tb_profil` (
  `id_profil` int(11) NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `nama_kepsek` varchar(100) NOT NULL,
  `logo_sekolah` varchar(255) NOT NULL,
  `kop_sekolah` varchar(255) NOT NULL,
  `bg_sekolah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_profil`
--

INSERT INTO `tb_profil` (`id_profil`, `nama_sekolah`, `nama_kepsek`, `logo_sekolah`, `kop_sekolah`, `bg_sekolah`) VALUES
(1, 'SMK MUH. 2 KLATEN UTARA', 'Prihari Darwiyono, S. Pd', 'logosmk_31.png', 'kopsmk.jpg', 'smk.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nomor_peserta` varchar(50) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `password_siswa` varchar(255) NOT NULL,
  `pass_show_siswa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`nomor_peserta`, `nama_siswa`, `id_kelas`, `password_siswa`, `pass_show_siswa`) VALUES
('021001', 'Doni Kurniawan', 14, '$2y$10$lihAy.byvQajgmkrajX5pOeC9GUTDfgm0crEfxadjCCYa0k57MNBS', 'doni'),
('021002', 'Sulistyowati', 3, '$2y$10$zqrfzpJ9MHBVEdTA4X0KkOxpX.2sptDDj63gB730j7DwTi71biPb.', 'sulis'),
('021003', 'Fariz Firmansyah', 2, '$2y$10$YSkxXl/HlgETg5OGq9jxy./17syGebZIOs.h9rdrLVeUZyxKRvUTC', 'fariz'),
('021004', 'Inggit Larasati', 15, '$2y$10$/cYyw.BpHFLDLnmbWvYTdO0tAWLqYIVI/MdHFPxHJ37x5LrpORg6O', 'inggit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_soal`
--

CREATE TABLE `tb_soal` (
  `kode_soal` varchar(50) NOT NULL,
  `id_pengampu` int(11) NOT NULL,
  `id_jenis_ujian` int(11) NOT NULL,
  `acak_pertanyaan` varchar(5) NOT NULL,
  `acak_opsi` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_soal`
--

INSERT INTO `tb_soal` (`kode_soal`, `id_pengampu`, `id_jenis_ujian`, `acak_pertanyaan`, `acak_opsi`) VALUES
('US6KT', 7, 3, 'Ya', 'Ya'),
('US9KM', 9, 2, 'Tidak', 'Ya'),
('USBLD', 10, 2, 'Ya', 'Tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_stt_ujian`
--

CREATE TABLE `tb_stt_ujian` (
  `id_ujian` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_pengampu` int(11) NOT NULL,
  `kode_soal` varchar(50) NOT NULL,
  `stt_ujian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_butir_pdf`
--
ALTER TABLE `tb_butir_pdf`
  ADD PRIMARY KEY (`id_pdf`),
  ADD KEY `kode_soal` (`kode_soal`);

--
-- Indeks untuk tabel `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD PRIMARY KEY (`id_dok`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `tb_guru_pengampu`
--
ALTER TABLE `tb_guru_pengampu`
  ADD PRIMARY KEY (`id_pengampu`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `kode_soal` (`kode_soal`);

--
-- Indeks untuk tabel `tb_jenis_ujian`
--
ALTER TABLE `tb_jenis_ujian`
  ADD PRIMARY KEY (`id_jenis_ujian`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kode_jurusan` (`kode_jurusan`);

--
-- Indeks untuk tabel `tb_mapel`
--
ALTER TABLE `tb_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `tb_opsi_jwb`
--
ALTER TABLE `tb_opsi_jwb`
  ADD PRIMARY KEY (`id_opsi`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indeks untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  ADD PRIMARY KEY (`id_pengampu_jur`),
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `kode_jurusan` (`kode_jurusan`);

--
-- Indeks untuk tabel `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `kode_soal` (`kode_soal`);

--
-- Indeks untuk tabel `tb_profil`
--
ALTER TABLE `tb_profil`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nomor_peserta`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`kode_soal`),
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `id_jenis_ujian` (`id_jenis_ujian`);

--
-- Indeks untuk tabel `tb_stt_ujian`
--
ALTER TABLE `tb_stt_ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `kode_soal` (`kode_soal`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_butir_pdf`
--
ALTER TABLE `tb_butir_pdf`
  MODIFY `id_pdf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  MODIFY `id_dok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_guru_pengampu`
--
ALTER TABLE `tb_guru_pengampu`
  MODIFY `id_pengampu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_ujian`
--
ALTER TABLE `tb_jenis_ujian`
  MODIFY `id_jenis_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tb_mapel`
--
ALTER TABLE `tb_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_opsi_jwb`
--
ALTER TABLE `tb_opsi_jwb`
  MODIFY `id_opsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  MODIFY `id_pengampu_jur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tb_profil`
--
ALTER TABLE `tb_profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_stt_ujian`
--
ALTER TABLE `tb_stt_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_butir_pdf`
--
ALTER TABLE `tb_butir_pdf`
  ADD CONSTRAINT `tb_butir_pdf_ibfk_1` FOREIGN KEY (`kode_soal`) REFERENCES `tb_soal` (`kode_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_guru_pengampu`
--
ALTER TABLE `tb_guru_pengampu`
  ADD CONSTRAINT `tb_guru_pengampu_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_guru_pengampu_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `tb_mapel` (`id_mapel`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `tb_jadwal_ibfk_1` FOREIGN KEY (`kode_soal`) REFERENCES `tb_soal` (`kode_soal`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_ibfk_1` FOREIGN KEY (`kode_jurusan`) REFERENCES `tb_jurusan` (`kode_jurusan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_opsi_jwb`
--
ALTER TABLE `tb_opsi_jwb`
  ADD CONSTRAINT `tb_opsi_jwb_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `tb_pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  ADD CONSTRAINT `tb_pengampu_jur_ibfk_1` FOREIGN KEY (`id_pengampu`) REFERENCES `tb_guru_pengampu` (`id_pengampu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pengampu_jur_ibfk_2` FOREIGN KEY (`kode_jurusan`) REFERENCES `tb_jurusan` (`kode_jurusan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  ADD CONSTRAINT `tb_pertanyaan_ibfk_1` FOREIGN KEY (`kode_soal`) REFERENCES `tb_soal` (`kode_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD CONSTRAINT `tb_soal_ibfk_1` FOREIGN KEY (`id_jenis_ujian`) REFERENCES `tb_jenis_ujian` (`id_jenis_ujian`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_soal_ibfk_2` FOREIGN KEY (`id_pengampu`) REFERENCES `tb_guru_pengampu` (`id_pengampu`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_stt_ujian`
--
ALTER TABLE `tb_stt_ujian`
  ADD CONSTRAINT `tb_stt_ujian_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_stt_ujian_ibfk_2` FOREIGN KEY (`kode_soal`) REFERENCES `tb_soal` (`kode_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_stt_ujian_ibfk_3` FOREIGN KEY (`id_pengampu`) REFERENCES `tb_guru_pengampu` (`id_pengampu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
