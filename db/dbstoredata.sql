-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2020 at 10:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbstorage`
--

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `link` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `caption` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `altText` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `description` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `type` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `uploadedBy` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `uploadedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `name`, `link`, `caption`, `altText`, `description`, `type`, `uploadedBy`, `uploadedOn`) VALUES
(44, 'WordPress', 'uploads\\zips\\dbs_300a9b319c81cf632a0022e85d3a9574.zip', NULL, NULL, NULL, 'application/zip', NULL, '2020-05-17 19:53:52'),
(46, 'Technology', 'uploads\\images\\dbs_ff27d4ff2a58ef00910d7e934a6d366d.jpg', NULL, NULL, NULL, 'image/jpg', NULL, '2020-05-17 19:58:45'),
(42, 'Dragon Programming Language', 'uploads\\images\\dbs_daeba8ffb55d3b94b33a5a0fd616f36a.png', NULL, NULL, NULL, 'image/png', NULL, '2020-05-17 19:51:43'),
(47, 'Cooling System', 'uploads\\images\\dbs_a6c1b67897dd6424840c39e3520070b4.png', NULL, NULL, NULL, 'image/png', NULL, '2020-05-17 19:59:03'),
(45, 'Country Codes', 'uploads\\zips\\dbs_a57976655427a288971ae23da08058af.zip', NULL, NULL, NULL, 'application/zip', NULL, '2020-05-17 19:54:34'),
(48, 'GPU', 'uploads\\images\\dbs_ea46782c593a7a72480c831e4bdb3ea2.png', NULL, NULL, NULL, 'image/png', NULL, '2020-05-17 19:59:13'),
(49, 'Graphic Card', 'uploads\\images\\dbs_e5019cf826044b7f6f3589e4abfb3927.png', NULL, NULL, NULL, 'image/png', NULL, '2020-05-17 19:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attempt` tinyint(1) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(45) NOT NULL,
  `full_name` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `profile_pic` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `password`, `role`, `status`, `profile_pic`, `date`) VALUES
(39, 'admin@dbstoredata.com', 'Admin', '$2y$10$KfZxP2EbbiJU3c8yEjHVt.GV80TH2Tzvs6LWrL0Rj2Pv9RLemg496', 'admin', 1, '', '2020-04-26 11:46:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
