-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Jul 2021 pada 06.52
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
(9, 5, 'XII', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_ujian`
--

CREATE TABLE `tb_jenis_ujian` (
  `id_jenis_ujian` int(11) NOT NULL,
  `jenis_ujian` varchar(100) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 'Fisika');

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
(12, 9, 'Jurusan-SF8TV');

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

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

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
-- Indeks untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  ADD PRIMARY KEY (`id_pengampu_jur`),
  ADD KEY `id_pengampu` (`id_pengampu`),
  ADD KEY `kode_jurusan` (`kode_jurusan`);

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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_guru_pengampu`
--
ALTER TABLE `tb_guru_pengampu`
  MODIFY `id_pengampu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_ujian`
--
ALTER TABLE `tb_jenis_ujian`
  MODIFY `id_jenis_ujian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tb_mapel`
--
ALTER TABLE `tb_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  MODIFY `id_pengampu_jur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_profil`
--
ALTER TABLE `tb_profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_guru_pengampu`
--
ALTER TABLE `tb_guru_pengampu`
  ADD CONSTRAINT `tb_guru_pengampu_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_guru_pengampu_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `tb_mapel` (`id_mapel`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_ibfk_1` FOREIGN KEY (`kode_jurusan`) REFERENCES `tb_jurusan` (`kode_jurusan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengampu_jur`
--
ALTER TABLE `tb_pengampu_jur`
  ADD CONSTRAINT `tb_pengampu_jur_ibfk_1` FOREIGN KEY (`id_pengampu`) REFERENCES `tb_guru_pengampu` (`id_pengampu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pengampu_jur_ibfk_2` FOREIGN KEY (`kode_jurusan`) REFERENCES `tb_jurusan` (`kode_jurusan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
