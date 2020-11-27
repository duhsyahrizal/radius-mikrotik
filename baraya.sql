-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2020 pada 09.37
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baraya`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayhost_users`
--

CREATE TABLE `bayhost_users` (
  `bayhost_user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL COMMENT '1=admin, 2=operator, 3=teknisi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bayhost_users`
--

INSERT INTO `bayhost_users` (`bayhost_user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'IkhlasBayhost!@#', '1'),
(2, 'operator', 'ikhlasop', '2'),
(3, 'teknisi', 'IkhlasTeknisi123', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `client_gateway`
--

CREATE TABLE `client_gateway` (
  `client_gateway_id` int(11) NOT NULL,
  `host` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `boarding_house_name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `client_gateway`
--

INSERT INTO `client_gateway` (`client_gateway_id`, `host`, `username`, `password`, `boarding_house_name`, `type`) VALUES
(1, '10.1.1.50', 'abay', 'ikhlasjtr', 'palem', 'radius'),
(2, '10.1.1.51', 'abay', 'ikhlasjtr', 'cosmic', 'radius'),
(3, '10.1.1.52', 'abay', 'ikhlasjtr', 'aldilla', 'radius'),
(4, '10.1.1.56', 'abay', 'ikhlasjtr', 'atika2', 'radius'),
(5, '10.1.1.57', 'abay', 'ikhlasjtr', 'pelangi', 'radius'),
(6, '10.1.1.61', 'abay', 'ikhlasjtr', 'boulevard1', 'radius'),
(7, '10.1.1.65', 'abay', 'ikhlasjtr', 'boulevard2', 'radius'),
(8, '10.1.1.66', 'abay', 'ikhlasjtr', 'edelweis', 'radius'),
(9, '10.11.25.59', 'abay', 'ikhlasjtr', 'concent pie', 'personal'),
(10, '10.11.25.14', 'abay', 'ikhlasjtr', 'concent d\'aksara', 'personal');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mikrotik_package`
--

CREATE TABLE `mikrotik_package` (
  `mikrotik_package_id` int(11) NOT NULL,
  `profile_id` varchar(5) NOT NULL,
  `limitation_id` varchar(5) NOT NULL,
  `profile_limitation_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mikrotik_package`
--

INSERT INTO `mikrotik_package` (`mikrotik_package_id`, `profile_id`, `limitation_id`, `profile_limitation_id`) VALUES
(1, '*2', '*2', '*2'),
(2, '*3', '*3', '*3'),
(3, '*4', '*4', '*4'),
(4, '*9', '*5', '*A'),
(5, '*A', '*6', '*B'),
(6, '*B', '*7', '*C'),
(7, '*C', '*8', '*D'),
(8, '*D', '*9', '*1C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `radius_account`
--

CREATE TABLE `radius_account` (
  `radius_account_id` int(11) NOT NULL,
  `radius_user_id` varchar(5) NOT NULL,
  `radius_package_id` varchar(5) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `place_of_birth` varchar(20) NOT NULL,
  `date_of_birth` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `boarding_house_name` varchar(20) NOT NULL,
  `telephone` varchar(14) NOT NULL,
  `active_period` varchar(10) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `radius_package`
--

CREATE TABLE `radius_package` (
  `radius_package_id` int(11) NOT NULL,
  `mikrotik_id` varchar(100) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `active_period` varchar(100) NOT NULL,
  `time_limit` varchar(100) NOT NULL,
  `quota_limit` varchar(100) NOT NULL,
  `rate_limit` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `radius_package`
--

INSERT INTO `radius_package` (`radius_package_id`, `mikrotik_id`, `package_name`, `active_period`, `time_limit`, `quota_limit`, `rate_limit`, `price`) VALUES
(1, '*2', '5 GB', '4w2d', '0s', '5368709120', '3145728', 50000),
(2, '*3', '8 GB', '4w2d', '0s', '8589934592', '3145728', 75000),
(3, '*4', '12 GB', '4w2d', '0s', '12884901888', '3145728', 100000),
(4, '*9', '18 GB', '4w2d', '0s', '19327352832', '5242880', 150000),
(5, '*A', 'UNL 1MB', '4w2d', '0s', '0', '1048576', 90000),
(6, '*B', 'UNL 1,5MB', '4w2d', '0s', '0', '1572864', 125000),
(7, '*C', 'UNL 3MB', '4w2d', '0s', '0', '3145728', 225000),
(8, '*D', 'UNL 5MB', '4w2d', '0s', '0', '5242880', 350000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `radius_report`
--

CREATE TABLE `radius_report` (
  `radius_report_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `package` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created_by` varchar(15) NOT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `radius_report`
--

INSERT INTO `radius_report` (`radius_report_id`, `description`, `package`, `price`, `type`, `created_by`, `created_at`) VALUES
(1, 'Created User abduh', '5 GB', 50000, 'user', 'teknisi', '19-11-2020'),
(2, 'Created User abduh', 'UNL 5MB', 350000, 'user', 'teknisi', '19-11-2020'),
(3, 'Created User abduh', '18 GB', 150000, 'user', 'admin', '20-11-2020'),
(4, 'Created User admin', 'UNL 5MB', 350000, 'user', 'admin', '20-11-2020');

-- --------------------------------------------------------

--
-- Struktur dari tabel `radius_users`
--

CREATE TABLE `radius_users` (
  `radius_user_id` int(11) NOT NULL,
  `mikrotik_id` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `shared_users` varchar(100) DEFAULT NULL,
  `download_used` bigint(20) NOT NULL COMMENT 'Format: bytes',
  `upload_used` bigint(20) NOT NULL COMMENT 'Format: bytes',
  `status` int(11) DEFAULT 1 COMMENT 'disable=0 | active=1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_group`
--

CREATE TABLE `role_group` (
  `role_group_id` int(11) NOT NULL,
  `role_name` varchar(25) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `manage_user` tinyint(4) NOT NULL,
  `manage_packet` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role_group`
--

INSERT INTO `role_group` (`role_group_id`, `role_name`, `user_id`, `manage_user`, `manage_packet`) VALUES
(1, 'admin', '1', 1, 1),
(2, 'operator', '2', 1, 1),
(3, 'teknisi', '3', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `modified_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `username`, `token`, `modified_at`) VALUES
(1, 'admin', 'a1eb5d662a33998104bab7fd7fabb232', '2020-11-20 08:05:14'),
(2, 'teknisi', 'ccc38bcfd2fc1d956bb71fd39ff8fa16', '2020-11-19 13:00:10'),
(3, 'operator', '00f7ffb8a5f5ddc2855b3ee5c4c22b24', '2020-11-13 18:02:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bayhost_users`
--
ALTER TABLE `bayhost_users`
  ADD PRIMARY KEY (`bayhost_user_id`);

--
-- Indeks untuk tabel `client_gateway`
--
ALTER TABLE `client_gateway`
  ADD PRIMARY KEY (`client_gateway_id`);

--
-- Indeks untuk tabel `mikrotik_package`
--
ALTER TABLE `mikrotik_package`
  ADD PRIMARY KEY (`mikrotik_package_id`);

--
-- Indeks untuk tabel `radius_account`
--
ALTER TABLE `radius_account`
  ADD PRIMARY KEY (`radius_account_id`);

--
-- Indeks untuk tabel `radius_package`
--
ALTER TABLE `radius_package`
  ADD PRIMARY KEY (`radius_package_id`);

--
-- Indeks untuk tabel `radius_report`
--
ALTER TABLE `radius_report`
  ADD PRIMARY KEY (`radius_report_id`);

--
-- Indeks untuk tabel `radius_users`
--
ALTER TABLE `radius_users`
  ADD PRIMARY KEY (`radius_user_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `role_group`
--
ALTER TABLE `role_group`
  ADD PRIMARY KEY (`role_group_id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bayhost_users`
--
ALTER TABLE `bayhost_users`
  MODIFY `bayhost_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `client_gateway`
--
ALTER TABLE `client_gateway`
  MODIFY `client_gateway_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mikrotik_package`
--
ALTER TABLE `mikrotik_package`
  MODIFY `mikrotik_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `radius_account`
--
ALTER TABLE `radius_account`
  MODIFY `radius_account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `radius_package`
--
ALTER TABLE `radius_package`
  MODIFY `radius_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `radius_report`
--
ALTER TABLE `radius_report`
  MODIFY `radius_report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `radius_users`
--
ALTER TABLE `radius_users`
  MODIFY `radius_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role_group`
--
ALTER TABLE `role_group`
  MODIFY `role_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
