-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2020 at 09:28 PM
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
-- Database: `portfolio`
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
  `type` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `uploadedBy` varchar(25) COLLATE latin1_general_cs DEFAULT NULL,
  `uploadedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `name`, `link`, `caption`, `altText`, `description`, `type`, `uploadedBy`, `uploadedOn`) VALUES
(7, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_git.png', NULL, NULL, NULL, 'image/png', 'Bin Emmanuel', '2019-03-08 20:32:36'),
(9, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_artificial-intelligence-2167835__340.jpg', NULL, NULL, NULL, 'image/jpg', 'Bin Emmanuel', '2019-03-08 20:33:03'),
(15, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_gitcommit.png', NULL, NULL, NULL, 'image/png', 'Bin Emmanuel', '2019-03-11 11:35:51'),
(12, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_changepass.png', NULL, NULL, NULL, 'image/png', 'Bin Emmanuel', '2019-03-09 07:15:43'),
(13, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_unity-game-programming-for-absolute-beginners-course-download-free.jpg', NULL, NULL, NULL, 'image/jpg', 'Bin Emmanuel', '2019-03-09 21:47:35'),
(14, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_startup-849804__340.jpg', NULL, NULL, NULL, 'image/jpg', 'Bin Emmanuel', '2019-03-09 21:47:46'),
(16, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_gitaddall.png', NULL, NULL, NULL, 'image/png', 'Bin Emmanuel', '2019-03-11 11:57:22'),
(17, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_index.png', NULL, NULL, NULL, 'image/png', 'bobby', '2019-03-11 20:17:07'),
(18, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_users.png', NULL, NULL, NULL, 'image/png', 'bobby', '2019-03-13 09:14:45'),
(19, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_office-932926__340.jpg', NULL, NULL, NULL, 'image/jpg', 'bobby', '2019-03-13 09:15:09'),
(34, '', 'http://localhost:8080/portfolio/my-contents/uploads/video/bin_29934409_565826923788693_865646685664051200_n.mp4', NULL, NULL, NULL, 'video/mp4', 'bobby', '2019-04-07 08:41:01'),
(23, '', 'http://localhost:8080/portfolio../my-contents/uploads/image/bin_message.png', NULL, NULL, NULL, 'image/png', 'bobby', '2019-03-21 09:58:19'),
(27, '', 'http://localhost:8080/portfolio/my-contents/uploads/video/bin_29675558_181218809176565_1217943800480006144_n-1.mp4', NULL, NULL, NULL, 'video/mp4', 'bobby', '2019-03-21 22:37:44'),
(28, '', 'http://localhost:8080/portfolio/my-contents/uploads/image/bin_singapore-2064905__340.jpg', NULL, NULL, NULL, 'image/jpg', 'bobby', '2019-03-21 22:43:23'),
(29, '', 'http://localhost:8080/portfolio/my-contents/uploads/image/bin_purse-1478852__340.jpg', 'Some text', 'The title of the file', NULL, 'image/jpg', 'bobby', '2019-03-21 22:43:56'),
(30, '', 'http://localhost:8080/portfolio/my-contents/uploads/image/bin_technology.png', NULL, NULL, NULL, 'image/png', 'bobby', '2019-03-21 22:44:13'),
(31, '', 'http://localhost:8080/portfolio/my-contents/uploads/image/bin_slider.jpg', NULL, NULL, NULL, 'image/jpg', 'bobby', '2019-03-21 22:44:43'),
(32, '', 'http://localhost:8080/portfolio/my-contents/uploads/image/bin_paypal.png', NULL, NULL, NULL, 'image/png', 'bobby', '2019-03-21 22:45:18'),
(36, '', 'http://localhost:8080/portfolio/my-contents/uploads/video/bin_[waploaded.ng]_-_bearskiee-tv-whine-that-ass-part-3[waploaded.ng].mp4', NULL, NULL, NULL, 'video/mp4', 'bobby', '2019-04-07 08:46:03'),
(37, '', 'http://localhost:8080/portfolio/my-contents/uploads/video/bin_2a8024da-1.mp4', 'Caption Here', 'alt text', 'des', 'video/mp4', 'bobby', '2019-04-07 08:54:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
