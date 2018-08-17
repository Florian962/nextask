-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 17, 2018 at 03:22 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `commentOn`, `commentBy`, `commentAt`, `commentActive`) VALUES
(1, 'Was wel wat werk.', 24, 1, '2018-08-15 08:16:06', 1),
(2, 'Wat een mooie foto.', 25, 1, '2018-08-17 13:59:43', 1),
(5, 'Sqdf.', 25, 1, '2018-08-17 14:27:35', 0),
(6, 'Dfgn,.', 25, 1, '2018-08-17 14:32:45', 0),
(7, 'Hjk.', 25, 1, '2018-08-17 14:36:46', 0),
(8, 'Dxfghjk;:=.', 25, 1, '2018-08-17 14:36:55', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`list_id`, `listtitle`, `listBy`, `listPostedOn`, `listActive`) VALUES
(7, 'Kebab eten.', 1, '2018-08-15 08:15:00', 0),
(8, 'PHP herexamne.', 1, '2018-08-15 08:15:00', 0),
(9, 'PHP Herexamen.', 1, '2018-08-15 08:57:00', 1),
(10, 'Schilderen.', 1, '2018-08-16 18:48:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statusBy` int(11) NOT NULL,
  `statusOn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task`, `duration`, `deadline`, `taskImage`, `taskIn`, `taskStatus`, `taskActive`) VALUES
(25, 'Inloggen en registreren', 5, '0000-00-00', 'users/feest.jpg', 9, 'DONE', 1),
(26, 'Lijsten toevoegen en verwijderen', 8, '0000-00-00', '', 9, 'TO DO', 1),
(27, 'Taken toevoegen aan een specifieke lijst', 6, '0000-00-00', '', 9, 'DONE', 1),
(28, 'Reageren op een taak met AJAX', 10, '0000-00-00', '', 9, 'DONE', 1),
(29, '# dagen tot deadline zichtbaar', 5, '0000-00-00', '', 9, 'TO DO', 1),
(30, 'Taken sorteren op deadline', 7, '0000-00-00', '', 9, 'TO DO', 1),
(31, 'Deadlines verwijderen en aanpassen', 9, '0000-00-00', '', 9, 'TO DO', 1),
(32, 'Geen dubbele taken in een lijst', 2, '0000-00-00', '', 9, 'TO DO', 0),
(33, 'User testing', 4, '2018-08-29', '', 9, 'TO DO', 0),
(48, 'Kebab', 6, '0000-00-00', '', 9, 'TO DO', 0),
(51, 'Jury', 1, '0000-00-00', '', 9, 'TO DO', 0),
(56, 'Usertesting', 2, '2018-08-29', '', 9, 'TO DO', 0),
(57, 'Geen dubbele taken in de lijst', 5, '0000-00-00', '', 9, 'TO DO', 0),
(58, 'Geen dubbele taken in de lijst', 6, '0000-00-00', '', 9, 'TO DO', 0),
(65, 'Sdfdsf', 2, '0000-00-00', '', 9, 'TO DO', 0),
(66, 'Sdvsvdsdv', 1, '0000-00-00', '', 9, 'TO DO', 0),
(67, 'Sqdfqsdf', 3, '0000-00-00', '', 9, 'TO DO', 0),
(68, 'Qsdfqsdf', 2, '0000-00-00', '', 9, 'TO DO', 0),
(69, 'Sdfsdf', 2, '0000-00-00', '', 9, 'TO DO', 0),
(70, 'Ezfzef', 2, '0000-00-00', '', 9, 'TO DO', 0),
(71, 'Qsdfsqdfsdfsdf', 1, '0000-00-00', '', 9, 'TO DO', 0),
(72, 'Qsdfqsdfqsdfqsdfqsdfqsdfqsdfqsdf', 1, '0000-00-00', '', 9, 'TO DO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'Florian', 'florianraeymaekers@gmail.com', '17ff5c22b104febde8564c62cbfdd7a4');

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
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
