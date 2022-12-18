-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2022 at 11:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app_loket`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_counter`
--

CREATE TABLE `tb_counter` (
  `counter_id` char(13) NOT NULL,
  `counter_sequence` int(10) UNSIGNED NOT NULL,
  `counter_name` char(150) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `created_by` char(50) NOT NULL,
  `status` enum('open','close') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_counter`
--

INSERT INTO `tb_counter` (`counter_id`, `counter_sequence`, `counter_name`, `date_created`, `created_by`, `status`) VALUES
('lkh6868AC1244', 1, 'Loket 1', '2022-12-10 23:32:42', 'Administrator', 'close'),
('lkh6868AC1245', 2, 'Loket 2', '2022-12-10 23:32:42', 'Ridwan Naim', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `menu_id` int(10) UNSIGNED NOT NULL,
  `menu_sequence` int(10) UNSIGNED NOT NULL,
  `grup_fitur` enum('user','akses','loket','dashboard','konten','pengaturan') NOT NULL,
  `label_menu` char(100) NOT NULL,
  `slug_menu` char(150) NOT NULL,
  `icon_menu` char(80) NOT NULL,
  `tipe_menu` enum('mainmenu','submenu','button') NOT NULL,
  `mode` enum('r','w') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`menu_id`, `menu_sequence`, `grup_fitur`, `label_menu`, `slug_menu`, `icon_menu`, `tipe_menu`, `mode`) VALUES
(1, 2, 'user', 'Manajemen User', 'manajemen-user', 'fas fa-users', 'mainmenu', 'r'),
(2, 0, 'user', 'Tambah User', 'tambah-user', 'fas fa-plus-square', 'button', 'w'),
(3, 0, 'user', 'Ubah User', 'ubah-user', 'fas fa user-edit', 'button', 'w'),
(4, 0, 'user', 'Hapus User', 'hapus-user', 'fas fa-trash-alt', 'button', 'w'),
(5, 1, 'akses', 'Grup User', 'grup-user', 'fas fa-users-cog', 'submenu', 'r'),
(6, 0, 'akses', 'Tambah Grup', 'tambah-grup', 'fas fa-plus-square', 'button', 'w'),
(7, 0, 'akses', 'Ubah Grup', 'ubah-grup', 'fas fa-edit', 'button', 'w'),
(8, 0, 'akses', 'Hapus Grup', 'hapus-grup', 'fas fa-trash-alt', 'button', 'w'),
(9, 1, 'dashboard', 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 'mainmenu', 'r'),
(10, 6, 'pengaturan', 'Pengaturan Aplikasi', 'pengaturan-aplikasi', 'fas fa-cogs', 'mainmenu', 'w'),
(11, 3, 'konten', 'Konten', '#konten', 'fas fa-photo-video', 'mainmenu', 'r'),
(12, 1, 'konten', 'Slide', 'slide', 'fas fa-images', 'submenu', 'r'),
(13, 0, 'konten', 'Tambah Gambar', 'tambah-gambar', 'fas fa-plus-square', 'button', 'w'),
(14, 0, 'konten', 'Hapus Gambar', 'hapus-gambar', 'fas fa-trash-alt', 'button', 'w'),
(15, 2, 'konten', 'Running Text', 'running-text', 'fas fa-text-width', 'submenu', 'r'),
(16, 0, 'konten', 'Tambah Teks', 'tambah-teks', 'fas fa-plus-square', 'button', 'w'),
(17, 0, 'konten', 'Hapus Teks', 'hapus-teks', 'fas fa-trash-alt', 'button', 'w'),
(18, 4, 'loket', 'Loket', '#loket', 'fas fa-concierge-bell', 'mainmenu', 'r'),
(19, 2, 'akses', 'Operator', 'operator', 'fas fa-user-tag', 'submenu', 'r'),
(20, 0, 'akses', 'Tambah Operator', 'tambah-operator', 'fas fa-user-plus', 'button', 'w'),
(21, 0, 'akses', 'Hapus Operator', 'hapus-operator', 'fas fa-user-times', 'button', 'w'),
(22, 0, 'akses', 'Ubah Operator', 'ubah-operator', 'fas fa-user-edit', 'button', 'w'),
(23, 1, 'loket', 'Loket', 'loket', 'fas fa-chalkboard-teacher', 'submenu', 'r'),
(24, 0, 'loket', 'Tambah Loket', 'tambah-loket', 'fas fa-plus-square', 'button', 'w'),
(25, 0, 'loket', 'Ubah Loket', 'ubah-loket', 'fas fa-edit', 'button', 'w'),
(26, 0, 'loket', 'Hapus Loket', 'hapus-loket', 'fas fa-trash-alt', 'button', 'w'),
(27, 2, 'loket', 'Transaksi', 'transaksi', 'fas fa-clipboard-list', 'submenu', 'r'),
(28, 0, 'konten', 'Ubah Gambar', 'ubah-gambar', 'fas fa-edit', 'button', 'w'),
(29, 0, 'konten', 'Ubah Teks', 'ubah-teks', 'fas fa-edit', 'button', 'w'),
(30, 0, 'loket', 'Masuk Loket', 'masuk-loket', 'fas fa-signin', 'button', 'w'),
(31, 3, 'akses', 'Manajemen Akses', '#manajemen-akses', 'fas fa-key', 'mainmenu', 'r');

-- --------------------------------------------------------

--
-- Table structure for table `tb_operator`
--

CREATE TABLE `tb_operator` (
  `operator_id` char(13) NOT NULL,
  `counter_id` char(13) DEFAULT NULL,
  `user_id` char(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_operator`
--

INSERT INTO `tb_operator` (`operator_id`, `counter_id`, `user_id`) VALUES
('0a256188b3d05', 'lkh6868AC1244', '1aD98123944Ac'),
('2b1ae23f44c8c', 'lkh6868AC1245', '731e2c7521312');

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`role_id`, `group_id`, `menu_id`) VALUES
(193, 1, 1),
(194, 1, 2),
(195, 1, 3),
(196, 1, 4),
(197, 1, 5),
(198, 1, 19),
(199, 1, 31),
(200, 1, 6),
(201, 1, 7),
(202, 1, 8),
(203, 1, 20),
(204, 1, 21),
(205, 1, 22),
(206, 1, 18),
(207, 1, 23),
(208, 1, 27),
(209, 1, 24),
(210, 1, 25),
(211, 1, 26),
(212, 1, 30),
(213, 1, 9),
(214, 1, 11),
(215, 1, 12),
(216, 1, 15),
(217, 1, 13),
(218, 1, 14),
(219, 1, 16),
(220, 1, 17),
(221, 1, 28),
(222, 1, 29),
(223, 1, 10),
(224, 5, 18),
(225, 5, 23),
(226, 5, 27),
(227, 5, 24),
(228, 5, 25),
(229, 5, 26),
(230, 5, 30),
(231, 5, 9),
(232, 5, 11),
(233, 5, 12),
(234, 5, 15),
(235, 5, 13),
(236, 5, 14),
(237, 5, 16),
(238, 5, 17),
(239, 5, 28),
(240, 5, 29);

-- --------------------------------------------------------

--
-- Table structure for table `tb_running_text`
--

CREATE TABLE `tb_running_text` (
  `text_id` char(13) NOT NULL,
  `text` char(255) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `created_by` char(50) NOT NULL,
  `status` enum('show','hide') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_running_text`
--

INSERT INTO `tb_running_text` (`text_id`, `text`, `date_created`, `created_by`, `status`) VALUES
('285325c6558bb', 'Sed vel rhoncus purus, id egestas sapien. Vivamus leo diam, ultrices in dolor vitae, vehicula efficitur lacus. In at est vehicula, fermentum lacus at, molestie magna.', '2022-12-10 22:41:18', 'Administrator', 'show'),
('4efb722861101', 'Aliquam ornare augue quam, a vehicula magna aliquam ut.', '2022-12-10 22:41:30', 'Administrator', 'show'),
('e5a2e01e6b443', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mauris nisl, fermentum aliquet nunc eu, finibus sodales justo.', '2022-12-10 22:33:40', 'Administrator', 'show');

-- --------------------------------------------------------

--
-- Table structure for table `tb_slide`
--

CREATE TABLE `tb_slide` (
  `slide_id` char(13) NOT NULL,
  `slide_title` char(150) NOT NULL,
  `slide_description` varchar(255) DEFAULT NULL,
  `image` varchar(512) NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `upload_by` char(50) NOT NULL,
  `status` enum('show','hide') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_slide`
--

INSERT INTO `tb_slide` (`slide_id`, `slide_title`, `slide_description`, `image`, `upload_date`, `upload_by`, `status`) VALUES
('5bcd0d37617e9', 'Slide Percobaan Dua', 'Slide Percobaan Dua', 'slide-5bcd0d37617e9.jpg', '2022-12-10 21:59:58', 'Administrator', 'show'),
('960771c93abce', 'Slide Percobaan Tiga', 'Slide Percobaan Tiga', 'slide-960771c93abce.jpg', '2022-12-10 21:59:42', 'Administrator', 'show'),
('9a593209149ec', 'Slide Percobaan 1', 'Slide Percobaan Satu', 'slide-9a593209149ec1.jpg', '2022-12-10 22:03:59', 'Administrator', 'show');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaction`
--

CREATE TABLE `tb_transaction` (
  `transaction_id` char(32) NOT NULL,
  `queue_num` int(10) UNSIGNED NOT NULL,
  `counter_id` char(13) NOT NULL,
  `employee_name` char(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` enum('queue','done') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaction`
--

INSERT INTO `tb_transaction` (`transaction_id`, `queue_num`, `counter_id`, `employee_name`, `date`, `status`) VALUES
('22fe25b431b56', 4, 'lkh6868AC1245', NULL, '2022-12-18 11:41:15', 'queue'),
('23b64e345c923', 4, 'lkh6868AC1245', NULL, '2022-12-15 04:27:59', 'queue'),
('284266d4c413a', 3, 'lkh6868AC1245', 'Ridwan Naim', '2022-12-18 10:24:50', 'done'),
('5f1aa3e7fc48b', 2, 'lkh6868AC1244', NULL, '2022-12-18 11:39:42', 'queue'),
('6b0ecb03eabb3', 3, 'lkh6868AC1244', 'Administrator', '2022-12-15 04:06:35', 'done'),
('6dbd74fa028a5', 6, 'lkh6868AC1244', NULL, '2022-12-15 04:26:14', 'queue'),
('84b7dc791335c', 5, 'lkh6868AC1244', 'Administrator', '2022-12-15 04:25:37', 'done'),
('a38e9b7b9f16a', 3, 'lkh6868AC1245', NULL, '2022-12-15 04:27:49', 'queue'),
('a79ef926f976d', 2, 'lkh6868AC1244', 'Administrator', '2022-12-15 03:51:17', 'done'),
('a95ca52066faa', 1, 'lkh6868AC1244', NULL, '2022-12-18 11:38:44', 'queue'),
('d31506c8b719c', 2, 'lkh6868AC1245', 'Ridwan Naim', '2022-12-18 09:12:50', 'done'),
('dd9e02e53929c', 1, 'lkh6868AC1245', 'Ridwan Naim', '2022-12-18 09:02:07', 'done'),
('df5aeb5797078', 1, 'lkh6868AC1245', 'Administrator', '2022-12-15 03:51:33', 'done'),
('e0f306f949e3e', 3, 'lkh6868AC1244', NULL, '2022-12-18 11:42:34', 'queue'),
('e740c50fceda5', 4, 'lkh6868AC1244', 'Administrator', '2022-12-15 04:09:45', 'done'),
('f7aa8aa6f0c77', 2, 'lkh6868AC1245', 'Administrator', '2022-12-15 04:11:48', 'done'),
('fb41c0581a682', 1, 'lkh6868AC1244', 'Administrator', '2022-12-15 00:00:00', 'done');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` char(13) NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `employee_name` char(255) NOT NULL,
  `username` char(50) NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `last_ip` char(16) DEFAULT NULL,
  `user_picture` char(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `group_id`, `employee_name`, `username`, `password`, `date_created`, `last_login`, `last_ip`, `user_picture`, `status`) VALUES
('1aD98123944Ac', 1, 'Administrator', 'admin', '$argon2id$v=19$m=2048,t=8,p=4$eEw5b2ZST1FwNUkxZERjbw$/AjMoKqTkACT9cLjwPhkIo5rSHnYr6REjDaJ68DgQkc', '2022-12-05 16:17:14', '2022-12-18 15:25:48', '::1', 'Administrator-1aD98123944Ac-20221215121514.jpg', 'active'),
('731e2c7521312', 5, 'Ridwan Naim', 'ridwannaim', '$argon2id$v=19$m=2048,t=8,p=4$dmtnY3VuQmFvbk1lck83Vw$8i5r2mcG8f+xT71EgE95SbDFb8WTUzastMRjqLGqTp4', '2022-12-18 14:30:06', '2022-12-18 15:24:11', '::1', 'Ridwan_Naim-731e2c7521312-20221218083439.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_group`
--

CREATE TABLE `tb_user_group` (
  `group_id` int(10) UNSIGNED NOT NULL,
  `group_name` char(100) NOT NULL,
  `index_menu` char(100) DEFAULT NULL,
  `mode` enum('r','rw') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user_group`
--

INSERT INTO `tb_user_group` (`group_id`, `group_name`, `index_menu`, `mode`) VALUES
(1, 'Administrator', 'dashboard', 'rw'),
(5, 'operator', 'dashboard', 'rw');

-- --------------------------------------------------------

--
-- Table structure for table `tb_web_setting`
--

CREATE TABLE `tb_web_setting` (
  `site_id` int(10) UNSIGNED NOT NULL,
  `site_name` char(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_logo_alt` varchar(255) NOT NULL,
  `site_tagline` char(255) DEFAULT NULL,
  `site_address` char(255) NOT NULL,
  `site_phone` char(16) NOT NULL,
  `site_email` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_web_setting`
--

INSERT INTO `tb_web_setting` (`site_id`, `site_name`, `site_logo`, `site_logo_alt`, `site_tagline`, `site_address`, `site_phone`, `site_email`) VALUES
(1, 'Kecamatan Karawaci', 'icon.png', 'icon.png', '', 'JL. PROKLAMASI NO. 09 RT.01/03 CIMONE JAYA, KARAWACI, KOTA TANGERANG', '0215585268', 'kec.karawaci@tangerangkota.go.id');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_counter`
--
ALTER TABLE `tb_counter`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tb_operator`
--
ALTER TABLE `tb_operator`
  ADD PRIMARY KEY (`operator_id`),
  ADD KEY `counter_id` (`counter_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `tb_running_text`
--
ALTER TABLE `tb_running_text`
  ADD PRIMARY KEY (`text_id`);

--
-- Indexes for table `tb_slide`
--
ALTER TABLE `tb_slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `tb_transaction`
--
ALTER TABLE `tb_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `counter_id` (`counter_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `tb_web_setting`
--
ALTER TABLE `tb_web_setting`
  ADD PRIMARY KEY (`site_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_web_setting`
--
ALTER TABLE `tb_web_setting`
  MODIFY `site_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_operator`
--
ALTER TABLE `tb_operator`
  ADD CONSTRAINT `tb_operator_ibfk_1` FOREIGN KEY (`counter_id`) REFERENCES `tb_counter` (`counter_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_operator_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD CONSTRAINT `tb_roles_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `tb_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_roles_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `tb_user_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaction`
--
ALTER TABLE `tb_transaction`
  ADD CONSTRAINT `tb_transaction_ibfk_1` FOREIGN KEY (`counter_id`) REFERENCES `tb_counter` (`counter_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `tb_user_group` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
