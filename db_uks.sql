-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2021 pada 01.36
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uks`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pinjaman`
--

CREATE TABLE `detail_pinjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_inventaris` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pinjaman`
--

INSERT INTO `detail_pinjaman` (`id_peminjaman`, `id_inventaris`, `jumlah`) VALUES
(15, 2, 1),
(16, 5, 4),
(17, 2, 4),
(18, 2, 5),
(19, 2, 5),
(20, 2, 5),
(21, 5, 3),
(22, 2, 3),
(23, 5, 3),
(24, 2, 5),
(24, 5, 4),
(25, 5, 6),
(29, 2, 8),
(29, 5, 7),
(30, 2, 2),
(30, 5, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `instansi`
--

CREATE TABLE `instansi` (
  `id_instansi` int(11) NOT NULL,
  `nama_instansi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `instansi`
--

INSERT INTO `instansi` (`id_instansi`, `nama_instansi`) VALUES
(1, 'Universitas Andalas'),
(2, 'Universitas Gajah Mada');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventaris`
--

CREATE TABLE `inventaris` (
  `id_inventaris` int(11) NOT NULL,
  `nama_inventaris` varchar(100) NOT NULL,
  `harga_mahasiswa` int(11) NOT NULL,
  `harga_nonmahasiswa` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `inventaris`
--

INSERT INTO `inventaris` (`id_inventaris`, `nama_inventaris`, `harga_mahasiswa`, `harga_nonmahasiswa`, `gambar`, `keterangan`) VALUES
(2, 'Baju Adat Sumbar', 30000, 40000, 'baju adat sumbar.jpg', 'Baju Adat Dari Sumatera Barat Lengkap'),
(5, 'Talempong', 20000, 50000, 'R.jpg', 'Terbuat dari kuningan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status_peminjaman` varchar(40) NOT NULL,
  `status_harga` varchar(40) DEFAULT NULL,
  `surat_peminjaman` varchar(255) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `tanggal_pinjam`, `tanggal_kembali`, `status_peminjaman`, `status_harga`, `surat_peminjaman`, `tanggal_pengajuan`) VALUES
(15, 12, '2021-12-22', '2021-12-28', 'Disetujui Divisi Rumah Tangga', 'Disetujui Divisi Pemasaran', 'paper desa wisata (1).docx', '2021-12-20'),
(16, 7, '2021-12-22', '2021-12-23', 'Disetujui', NULL, NULL, '2021-12-20'),
(17, 7, '2021-12-22', '2021-12-25', 'Disetujui Divisi Rumah Tangga', 'Disetujui Divisi Pemasaran', NULL, '2021-12-20'),
(18, 12, '2021-12-21', '2021-12-25', 'Sudah Dikembalikan', 'Disetujui Peminjam', 'INTRUKSI TUGAS KELOMPOK E-BISNIS 02.pdf', '2021-12-20'),
(19, 7, '2021-12-23', '2021-12-25', 'Disetujui Divisi Rumah Tangga', 'Disetujui Divisi Pemasaran', NULL, '2021-12-21'),
(20, 12, '2021-12-22', '2021-12-24', 'Disetujui Divisi Rumah Tangga', 'Disetujui Divisi Pemasaran', 'sekal.pdf', '2021-12-21'),
(21, 12, '2021-12-22', '2021-12-25', 'Ditolak Divisi Rumah Tangga', NULL, 'Komitmen Muslim Sejati.pdf', '2021-12-21'),
(22, 12, '2021-12-22', '2021-12-29', 'Diajukan', NULL, 'Pertanyaan.docx', '2021-12-21'),
(23, 12, '2021-12-23', '2021-12-25', 'Diajukan', NULL, 'SitiNinaAzwaliaTanjung_1911521014_InstruksModul10.docx', '2021-12-21'),
(24, 12, '2021-12-23', '2021-12-25', 'Diajukan', NULL, 'sekal.pdf', '2021-12-21'),
(25, 16, '2021-12-24', '2021-12-25', 'Disetujui Divisi Rumah Tangga', 'Ditolak Divisi Pemasaran', 'Laporan Sprint 1_Kelompok 6.docx', '2021-12-22'),
(26, 16, '2021-12-19', '2021-12-28', 'Sudah Dikembalikan', 'Disetujui Peminjam', '1911521008_HayatulAnnisaBasyiroh_PaperDesaWisata.pdf', '2021-12-22'),
(27, 16, '2021-12-23', '2021-12-31', 'Ditolak Divisi Rumah Tangga', NULL, 'ringkasan, ikhtisar, abstrak, resensi (1).docx', '2021-12-22'),
(28, 7, '2021-12-24', '2022-01-05', 'Disetujui Divisi Rumah Tangga', 'Ditolak Divisi Pemasaran', NULL, '2021-12-22'),
(29, 14, '2021-12-31', '2022-01-06', 'Ditolak Divisi Rumah Tangga', NULL, NULL, '2021-12-28'),
(30, 7, '2021-12-31', '2022-01-08', 'Disetujui Divisi Rumah Tangga', NULL, NULL, '2021-12-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_instansi` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_user` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_instansi`, `nama_lengkap`, `username`, `password`, `jenis_user`, `tanggal_lahir`, `no_hp`, `jenis_kelamin`, `alamat`, `foto`) VALUES
(6, 2, 'ulftm11', 'ulftm1', '25d55ad283aa400af464c76d713c07ad', 'Admin', '2000-07-12', '08638726782', 'Perempuan', 'Jl.Fatimah Jalil No.31 Payakumbuh', 'Dashboard.png'),
(7, 1, 'Admin', 'adm', '25d55ad283aa400af464c76d713c07ad', 'Pengurus UKS', '2000-12-01', '082345332345', 'Perempuan', 'Padang', 'MicrosoftTeams-image.png'),
(12, 2, 'Ulfatmi Hanifa', 'ulfa', '25d55ad283aa400af464c76d713c07ad', 'Divisi Pemasaran', '2000-11-28', '0876554433', 'Perempuan', 'Jl.Fatimah Jalil No.31 Payakumbuh', 'MicrosoftTeams-image.png'),
(14, 1, 'Ulfatmi Hanifa', 'chevalargoutama', '25d55ad283aa400af464c76d713c07ad', 'Divisi Rumah Tangga', '2000-12-08', '09090901900', 'Perempuan', 'Jl.Fatimah Jalil No.31 Payakumbuh', 'Anggota UKS.png'),
(16, 1, 'Anita Anggraini', 'anta', '25d55ad283aa400af464c76d713c07ad', 'Peminjam di Luar UKS', '2000-12-05', '082381982234', 'Perempuan', 'Padang', 'Anggota UKS.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pinjaman`
--
ALTER TABLE `detail_pinjaman`
  ADD PRIMARY KEY (`id_peminjaman`,`id_inventaris`),
  ADD KEY `inventaris_detail_pinjaman_fk` (`id_inventaris`);

--
-- Indeks untuk tabel `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indeks untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id_inventaris`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `user_peminjaman_fk` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `instansi_user_fk` (`id_instansi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id_inventaris` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pinjaman`
--
ALTER TABLE `detail_pinjaman`
  ADD CONSTRAINT `inventaris_detail_pinjaman_fk` FOREIGN KEY (`id_inventaris`) REFERENCES `inventaris` (`id_inventaris`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `peminjaman_detail_pinjaman_fk` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `user_peminjaman_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `instansi_user_fk` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
