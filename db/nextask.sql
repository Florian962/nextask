-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 18, 2018 at 07:21 PM
-- Server version: 5.5.49-log
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nextask`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentOn` int(11) NOT NULL,
  `commentBy` int(11) NOT NULL,
  `commentAt` datetime NOT NULL,
  `commentActive` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `commentOn`, `commentBy`, `commentAt`, `commentActive`) VALUES
(13, 'Nu nog terug op  TO DO zetten.', 80, 4, '2018-08-18 09:41:27', 1),
(14, 'Comment.', 77, 4, '2018-08-18 18:23:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `list_id` int(11) NOT NULL,
  `listtitle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `listBy` int(11) NOT NULL,
  `listPostedOn` datetime NOT NULL,
  `listActive` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`list_id`, `listtitle`, `listBy`, `listPostedOn`, `listActive`) VALUES
(17, 'Herexamen PHP.', 4, '2018-08-18 08:44:00', 1),
(18, 'Vakantie.', 5, '2018-08-18 08:48:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL,
  `task` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `taskImage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taskIn` int(11) NOT NULL,
  `taskStatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taskActive` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task`, `duration`, `deadline`, `taskImage`, `taskIn`, `taskStatus`, `taskActive`) VALUES
(76, 'Registreren en inloggen', 8, '2018-08-20', '', 17, 'DONE', 1),
(77, 'Lijsten toevoegen en verwijderen', 5, '0000-00-00', '', 17, 'DONE', 1),
(78, 'Taken toevoegen aan een lijst', 8, '0000-00-00', '', 17, 'DONE', 1),
(79, 'Commenten op taak via AJAX', 9, '0000-00-00', '', 17, 'DONE', 1),
(80, 'Taken markeren als done of todo via AJAX', 2, '0000-00-00', '', 17, 'DONE', 1),
(81, 'Dagen resterend op taak tonen', 4, '0000-00-00', '', 17, 'DONE', 1),
(82, 'Taken worden getoond volgens deadline', 1, '0000-00-00', '', 17, 'DONE', 1),
(83, 'Deadlines verwijderen en aanpassen', 3, '0000-00-00', '', 17, 'DONE', 1),
(84, 'Een bestand aan taak koppelen', 8, '0000-00-00', '', 17, 'DONE', 1),
(85, 'Jury', 1, '2018-08-05', '', 17, 'DONE', 1),
(86, 'Sqdfsdf', 1, '0000-00-00', '', 17, 'TO DO', 0),
(87, 'Sdfqsdf', 2, '2018-11-09', '', 17, 'TO DO', 0),
(88, 'Sdqsd', 1, '2018-08-23', '', 17, 'TO DO', 0),
(89, 'Qsdfqsdf', 2, '2018-08-24', '', 17, 'DONE', 0),
(90, 'EzaRQGTSHEYKJUTH', 1, '2018-08-25', '', 17, 'DONE', 0),
(91, 'EARGZEHEZZEGZEG', 1, '2018-08-31', '', 17, 'TO DO', 0),
(92, 'Sdfqsdfqsdfqsdfqsdf', 1, '0000-00-00', '', 17, 'TO DO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(4, 'Florian', 'florianraeymaekers@gmail.com', '$2y$10$.U2crZed63hQT5HilinAUuAj//pnqmanObzOjBcLeLhD00IOJXLym'),
(5, 'Babeau', 'babeaudufraing@gmail.com', '$2y$10$KKDtyKiZEV9IGGcAdv/ry.O4oJ53RV6PmKbULWMfUlg8DwxmqgUOm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
