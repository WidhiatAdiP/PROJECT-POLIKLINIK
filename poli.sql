-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 01:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poli`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'widhiat', '$2y$10$O1Pg16vvhazKssgyTVAwrOivlItZB0hQZ12unVLCDMIV/PNxP69lW'),
(2, 'Wahyuu', '$2y$10$k4d5G02bapsg.WLfiqlx8uTCXVOOlOmXyAFdVsSXlms94TLc5wDOq'),
(9, 'badut', '$2y$10$L2/vwWZi98iulDNuu0ree.iaHQVEZOB/OlimeFDEAbjguCpMmYa/a'),
(10, 'addmin', '$2y$10$d.2IGTw3.ijshK.vs.BD.uw80Tztam/5iKyTcJvYOOLnRfdk8PdJC'),
(11, 'maja', '$2y$10$HhDV5LWZ.ecwBNtvIAzCE.Vwo5aO1TrJ7LOViT96gl4e4XWA6YXjW');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status_periksa` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `status_periksa`) VALUES
(1, 1, 2, 'keselek meteor dok', 1, 1),
(2, 8, 1, 'Kemasukan lalat dok', 2, 1),
(9, 10, 1, 'batuk pilek', 3, 1),
(10, 12, 1, 'batuk pilek kelesek', 4, 1),
(11, 13, 1, 'keselek', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(7, 2, 14),
(14, 5, 13),
(15, 5, 14),
(16, 6, 13),
(19, 7, 14),
(20, 1, 13),
(21, 8, 13),
(22, 8, 14),
(23, 9, 17),
(24, 10, 13),
(25, 10, 14),
(26, 10, 15),
(27, 11, 13),
(28, 11, 14),
(29, 11, 15),
(30, 12, 13),
(31, 12, 14),
(32, 12, 15);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `password`, `alamat`, `no_hp`, `id_poli`) VALUES
(1, 'Raka', '$2y$10$7A7Fs9rICEECyp93M1rt7.0BAOrQNaCkExcM9XNCqRZ8hlqELbhCK', 'Jalan Panembahan Candi Kudus', '08223028421', 2),
(2, 'Wahyu', 'wahyu123', 'Jalan Semarang Barat', '08740965430', 1),
(8, 'Wahyuu', '$2y$10$uthbcQ8wjaaxBaRzDf/wZ.aXOyZZ0ule56mkURGxnSHyQ2o2zFXIS', 'Jalan Imam Bonjol Selatan Pati', '08223028421', 1),
(9, 'vader', '$2y$10$qade3jiXTbaFp/Yg7QnQUehlekqLmKddjMhDXXaBmE/N8G41tC5Ya', 'Jalan Korelasi barat Jakarta', '08450732132', 3),
(10, 'wedhang', '$2y$10$ramhZr/BCnVJLITrDbuYweFZx1GLcgDBJtyIfHXUDxMdkLW71dxdi', 'jalan imam penjul', '019230284212', 4),
(11, 'raja', '$2y$10$OB3HXFe1E17hs/7paCSMEe0vu53Q8GKx0uvx.jDIoKpDWnJHBzYg.', 'Jalan Imam Bonjol Selatan ', '019230284012', 5),
(12, 'Rama', '', 'Semarang Tegal', '08975342132', 6);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 2, 'Selasa', '10:00:00', '16:00:00'),
(2, 1, 'Senin', '09:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(13, 'Asam Sulfat', '150ml', 100000),
(14, 'Natrium Hidroksida', '150ml', 110000),
(15, 'Albendazol', 'Tablet 400 mg', 16000),
(16, 'Alopurinol ', 'Tablet 100 mg', 16000),
(17, 'Asam Folat', 'Tablet 5mg', 62000);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `password`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(1, 'Widhiat Adi Prasetyo', '$2y$10$maaAmjeIhbxlvnKmohr/Qeen1YiaigO.TYwPftFrLCCZGUuzBA74m', 'Jalan Imam Bonjol Selatan Pati', '223456876132', '089743135980', '202401-002'),
(8, 'Maudya', '$2y$10$X.udcGJf9XW99dmBnzI1he.7ke8gJRLkvnIHxFHK2PvAIlSyZNmbi', 'Jalan Imam Bonjol Semarang', '223456876132', '08963728511', '202401-003'),
(9, 'Maseh', '$2y$10$T3NqCoIHKfQZxmQzxXFjK.ftjIL0tHD/Ia2yqvLS21uStO3bAJZA6', 'Meteseh Timur Semarang', '123456', '089743135980', '202401-004'),
(10, 'radit', '$2y$10$HR/PAZwtybHwBIxJAcZ0iu9xyf8WWXScIZGUom4v26O1QlZO4EwGC', 'Jalan Korelasi Utara Jakarta', '54321', '08223028420', '202401-005'),
(11, 'mamake', '$2y$10$wJNm9P3iAoOQJtfkiaCdAOWtHZZa4bKbiXpeVB006mLcuBkclHnfm', 'jalan imam bonjola', '1231', '01923028401', '202401-006'),
(12, 'wedus', '$2y$10$uNTMS3WfmyFuv5OoA.n.V.fhwg2q4HqEVLQESIiFaCAEKPhI2u57O', 'jalan imam penjol', '132111', '019231028401', '202401-007'),
(13, 'mansur', '$2y$10$DmRWwffvNLHGD7Ui5TrixuYXmyNRYGcVFGkC9IFgtIS8wT1Fa74Dm', 'Jalan Korelasi Jakarta', '1111212121', '0192302842111', '202401-008');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 1, '2024-01-07 07:32:00', '', 100000),
(2, 2, '2023-12-26 12:03:35', 'Minum Obate maseeeh ben sehat', 120000),
(5, 6, '2024-01-04 18:46:00', 'Minum obat secara teratur ya', 120000),
(6, 5, '2024-01-04 18:47:00', 'Sering bersihkan telinga dan minum obatnya', 90000),
(7, 3, '2024-01-27 00:14:00', 'Catatan uPDATE', 30000),
(8, 7, '2024-01-07 13:39:00', 'banyak minum asam sulfat', 210000),
(9, 8, '2024-01-07 13:55:00', 'Konsumsi Asam Folat', 62000),
(10, 9, '2024-01-07 15:24:00', 'minum ', 226000),
(11, 10, '2024-01-07 17:23:00', 'turu', 226000),
(12, 11, '2024-01-07 18:05:00', 'minum lek', 226000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poli Umums', 'Dokter Umum'),
(2, 'Spesialis Telinga', 'Dokter Telinga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `id_periksa` (`id_periksa`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_daftar_poli` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `daftar_poli_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `detail_periksa_ibfk_1` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`),
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`);

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id`) REFERENCES `daftar_poli` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_periksa_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poli`
--
ALTER TABLE `poli`
  ADD CONSTRAINT `poli_ibfk_1` FOREIGN KEY (`id`) REFERENCES `dokter` (`id_poli`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
