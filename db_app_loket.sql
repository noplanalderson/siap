-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2022 at 04:17 PM
-- Server version: 10.4.27-MariaDB-1:10.4.27+maria~ubu2004
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
('lkh6868AC1244', 1, 'Loket 1', '2022-12-10 23:32:42', 'Administrator', 'open'),
('lkh6868AC1245', 2, 'Loket 2', '2022-12-10 23:32:42', 'Administrator', 'open');

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
(5, 3, 'akses', 'Grup User', 'grup-user', 'fas fa-key', 'mainmenu', 'r'),
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
(19, 1, 'loket', 'Operator', 'operator', 'fas fa-user-tag', 'submenu', 'r'),
(20, 0, 'loket', 'Tambah Operator', 'tambah-operator', 'fas fa-user-plus', 'button', 'w'),
(21, 0, 'loket', 'Hapus Operator', 'hapus-operator', 'fas fa-user-times', 'button', 'w'),
(22, 0, 'loket', 'Ubah Operator', 'ubah-operator', 'fas fa-user-edit', 'button', 'w'),
(23, 2, 'loket', 'Loket', 'loket', 'fas fa-chalkboard-teacher', 'submenu', 'r'),
(24, 0, 'loket', 'Tambah Loket', 'tambah-loket', 'fas fa-plus-square', 'button', 'w'),
(25, 0, 'loket', 'Ubah Loket', 'ubah-loket', 'fas fa-edit', 'button', 'w'),
(26, 0, 'loket', 'Hapus Loket', 'hapus-loket', 'fas fa-trash-alt', 'button', 'w'),
(27, 3, 'loket', 'Transaksi', 'transaksi', 'fas fa-clipboard-list', 'submenu', 'r'),
(28, 0, 'konten', 'Ubah Gambar', 'ubah-gambar', 'fas fa-edit', 'button', 'w'),
(29, 0, 'konten', 'Ubah Teks', 'ubah-teks', 'fas fa-edit', 'button', 'w'),
(30, 0, 'loket', 'Masuk Loket', 'masuk-loket', 'fas fa-signin', 'button', 'w');

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
('2432310c74651', NULL, '1aD98123944Ac'),
('2b1ae23f44c8c', 'lkh6868AC1245', '1aD98123944Ac');

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
(142, 1, 1),
(143, 1, 2),
(144, 1, 3),
(145, 1, 4),
(146, 1, 5),
(147, 1, 6),
(148, 1, 7),
(149, 1, 8),
(150, 1, 18),
(151, 1, 19),
(152, 1, 23),
(153, 1, 27),
(154, 1, 20),
(155, 1, 21),
(156, 1, 22),
(157, 1, 24),
(158, 1, 25),
(159, 1, 26),
(160, 1, 30),
(161, 1, 9),
(162, 1, 11),
(163, 1, 12),
(164, 1, 15),
(165, 1, 13),
(166, 1, 14),
(167, 1, 16),
(168, 1, 17),
(169, 1, 28),
(170, 1, 29),
(171, 1, 10);

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
('5bcd0d37617e9', 'Slide Percobaan Dua', 'Slide Percobaan Dua', 'slide-5bcd0d37617e91.jpg', '2022-12-10 21:59:58', 'Administrator', 'show'),
('960771c93abce', 'Slide Percobaan Dua', 'Slide Percobaan Dua', 'slide-960771c93abce.jpg', '2022-12-10 21:59:42', 'Administrator', 'show'),
('9a593209149ec', 'Slide Percobaan Satu', 'Slide Percobaan Satu', 'slide-9a593209149ec.jpg', '2022-12-10 22:03:59', 'Administrator', 'show');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaction`
--

CREATE TABLE `tb_transaction` (
  `transaction_id` char(32) NOT NULL,
  `counter_id` char(13) NOT NULL,
  `employee_name` char(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaction`
--

INSERT INTO `tb_transaction` (`transaction_id`, `counter_id`, `employee_name`, `date`) VALUES
('1614a4e2eacb5', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('18d33bca0edd0', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('35dd4b17a7c71', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('43738d1ce610d', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('5716b8ccc3c5a', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('bf5dae859dc63', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('cb6c7384019cd', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('d1e1c8a1dff4f', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('e2af43ead7151', 'lkh6868AC1245', 'Administrator', '2022-12-13'),
('f2b0d4b45ee40', 'lkh6868AC1245', 'Administrator', '2022-12-13');

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
('1aD98123944Ac', 1, 'Administrator', 'admin', '$argon2id$v=19$m=2048,t=8,p=4$U3JKMjh1cnAxV1duQ2hBcg$HEEGMWDjyBljw+GwENLHUBjazwH+MDVVqNrRnKdp7W0', '2022-12-05 16:17:14', '2022-12-12 19:54:48', '127.0.0.1', 'shrodinger-schrodinger-s-cat-140235.jpg', 'active');

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
(1, 'Administrator', 'dashboard', 'rw');

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
(1, 'Loket loketan', 'icon.png', 'icon.png', NULL, 'Someplace in the  Cruel World', '72777777', 'mrnaeem@tutanota.com');

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
  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
