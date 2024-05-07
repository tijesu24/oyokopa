-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2023 at 09:36 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photoprettify`
--

-- --------------------------------------------------------

--
-- Table structure for table `corpentries`
--

CREATE TABLE `corpentries` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `ppa` varchar(255) NOT NULL,
  `imgid` varchar(255) NOT NULL,
  `unidepartment` varchar(255) NOT NULL,
  `entrydate` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  `imgpath` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `pword` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `pword`, `status`) VALUES
(1, 'admin', 'admin', 'active'),
(2, 'wilson', 'wilson', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `ownertype` varchar(255) NOT NULL,
  `mainid` int(11) NOT NULL,
  `maintype` varchar(255) NOT NULL,
  `mediatype` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `filesize` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `ownerid`, `ownertype`, `mainid`, `maintype`, `mediatype`, `categoryid`, `location`, `details`, `filesize`, `width`, `height`, `title`, `status`) VALUES
(1, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(2, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(3, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(4, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(5, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(6, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(7, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(8, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(9, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(10, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(11, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(12, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(13, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(14, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(15, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(16, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(17, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(18, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(19, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(20, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(21, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(22, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(23, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(24, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(25, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(26, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(27, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(28, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(29, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(30, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(31, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(32, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(33, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(34, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(35, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(36, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(37, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(38, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(39, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(40, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(41, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(42, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(43, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(44, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(45, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(46, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(47, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(48, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(49, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(50, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(51, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(52, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(53, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(54, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(55, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(56, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(57, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(58, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(59, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(60, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(61, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(62, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(63, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(64, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(65, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(66, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(67, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(68, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(69, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(70, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(71, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(72, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(73, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(74, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(75, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(76, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(77, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(78, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(79, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(80, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(81, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(82, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(83, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(84, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(85, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(86, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(87, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(88, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(89, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(90, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(91, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(92, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(93, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(94, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(95, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(96, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(97, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(98, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(99, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(100, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(101, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(102, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(103, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(104, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(105, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(106, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(107, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(108, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(109, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(110, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(111, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(112, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(113, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(114, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(115, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(116, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(117, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(118, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(119, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(120, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(121, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(122, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(123, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(124, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(125, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(126, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(127, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(128, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active'),
(129, 1, 'corper', 0, '', '', 0, 'Microbiology', 'Microbiology', '', 0, 0, '', 'active'),
(130, 2, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(131, 3, 'corper', 0, '', '', 0, 'Industrial Design', 'Industrial Design', '', 0, 0, '', 'active'),
(132, 4, 'corper', 0, '', '', 0, 'Botany', 'Botany', '', 0, 0, '', 'active'),
(133, 5, 'corper', 0, '', '', 0, 'Nutrition And Dietetics', 'Nutrition And Dietetics', '', 0, 0, '', 'active'),
(134, 6, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(135, 7, 'corper', 0, '', '', 0, 'S.l.t (microbiology)', 'S.l.t (microbiology)', '', 0, 0, '', 'active'),
(136, 8, 'corper', 0, '', '', 0, 'Guidance and Counselling', 'Guidance and Counselling', '', 0, 0, '', 'active'),
(137, 9, 'corper', 0, '', '', 0, 'Communication And Language Arts', 'Communication And Language Arts', '', 0, 0, '', 'active'),
(138, 10, 'corper', 0, '', '', 0, 'Biochemistry', 'Biochemistry', '', 0, 0, '', 'active'),
(139, 11, 'corper', 0, '', '', 0, 'Political Science', 'Political Science', '', 0, 0, '', 'active'),
(140, 12, 'corper', 0, '', '', 0, 'Banking And Finance', 'Banking And Finance', '', 0, 0, '', 'active'),
(141, 13, 'corper', 0, '', '', 0, 'Community Health', 'Community Health', '', 0, 0, '', 'active'),
(142, 14, 'corper', 0, '', '', 0, 'Purchasing And Supply', 'Purchasing And Supply', '', 0, 0, '', 'active'),
(143, 15, 'corper', 0, '', '', 0, 'Accounting', 'Accounting', '', 0, 0, '', 'active'),
(144, 16, 'corper', 0, '', '', 0, 'Public Administration', 'Public Administration', '', 0, 0, '', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corpentries`
--
ALTER TABLE `corpentries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `corpentries`
--
ALTER TABLE `corpentries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
