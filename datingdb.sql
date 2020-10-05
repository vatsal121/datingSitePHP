-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2020 at 01:29 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(50) NOT NULL,
  `msg_from_user_id` int(50) NOT NULL,
  `msg` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `msg_to_user_id` int(50) NOT NULL,
  `msg_date` datetime NOT NULL,
  `is_msg_read` tinyint(1) NOT NULL DEFAULT 0,
  `msg_read_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg_from_user_id`, `msg`, `msg_to_user_id`, `msg_date`, `is_msg_read`, `msg_read_date`) VALUES
(1, 13, 'Hello Vatsal', 14, '2020-10-04 01:18:23', 1, NULL),
(2, 14, 'Hello Meet', 13, '2020-10-04 01:18:54', 1, '2020-10-04 19:23:26'),
(3, 13, 'Hello from 13 to 15', 15, '2020-10-04 01:19:12', 0, NULL),
(4, 15, 'Hello from 15 to 13', 13, '2020-10-04 01:19:20', 0, NULL),
(5, 14, 'Hi I am Test User', 13, '2020-10-04 03:31:07', 1, '2020-10-04 19:23:26'),
(6, 14, 'How are you?', 13, '2020-10-04 03:32:02', 1, '2020-10-04 19:23:26'),
(7, 14, 'This is latest msg by vatsal to meet', 13, '2020-10-04 04:08:41', 1, '2020-10-04 19:23:26'),
(8, 13, 'This is latest msg by meet  to vatsal', 14, '2020-10-04 04:10:44', 1, NULL),
(9, 14, 'Hi Female Girl', 15, '2020-10-04 04:15:39', 0, NULL),
(15, 13, 'TIme 5.33 AM', 14, '2020-10-04 05:34:04', 1, NULL),
(16, 14, 'yes', 13, '2020-10-04 05:34:23', 1, '2020-10-04 19:23:26'),
(17, 14, 'Are you there>', 15, '2020-10-04 06:02:52', 0, NULL),
(18, 14, '😉', 13, '2020-10-04 06:07:34', 1, '2020-10-04 19:23:26'),
(19, 14, '😉', 13, '2020-10-04 18:19:40', 1, '2020-10-04 19:23:26'),
(20, 14, '😉', 16, '2020-10-04 18:20:08', 0, NULL),
(21, 14, '😉', 13, '2020-10-04 18:31:15', 1, '2020-10-04 19:23:26'),
(22, 14, '😉', 15, '2020-10-04 18:32:26', 0, NULL),
(23, 14, 'Hi', 13, '2020-10-04 19:05:28', 1, '2020-10-04 19:23:26'),
(24, 14, 'Hi Meet', 13, '2020-10-04 19:18:53', 1, '2020-10-04 19:23:26'),
(25, 14, 'Hi Meet', 13, '2020-10-04 19:20:31', 1, '2020-10-04 19:23:26'),
(26, 14, 'How are you?', 13, '2020-10-04 19:24:54', 1, '2020-10-04 19:26:13'),
(27, 14, 'How are you?', 13, '2020-10-04 19:25:33', 1, '2020-10-04 19:26:13'),
(28, 14, 'How are you?', 13, '2020-10-04 19:25:46', 1, '2020-10-04 19:26:13'),
(29, 13, 'I am fine thanks', 14, '2020-10-04 19:26:24', 1, '2020-10-04 19:26:40'),
(30, 14, 'Ok', 13, '2020-10-04 19:27:07', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `imgUrl` text NOT NULL,
  `receive_notification` tinyint(1) NOT NULL DEFAULT 0,
  `user_role` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `email`, `password`, `firstName`, `lastName`, `city`, `bio`, `birthDate`, `gender`, `imgUrl`, `receive_notification`, `user_role`, `created_date`, `modified_date`) VALUES
(13, 'patel00446@gmail.com', 'test', 'Meet', 'Patel', 'Montreal', '', '1995-12-01', 'male', './images/user_images/patel00446@gmail.com_login-background.jpg', 0, 'regular', '2020-09-30 18:45:17', NULL),
(14, 'testing@gmail.com', 'test', 'Vatsal 1', 'Chauhan', 'Surat', 'i AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole dayi AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole dayi AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole dayi AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole dayi AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole day', '1995-01-12', 'male', './images/user_images/testing@gmail.com_pngfuel.com.png', 0, 'premium', '2020-10-01 17:16:30', NULL),
(15, 'abc@gmail.com', 'test', 'Female', 'Girl', 'Quebec', '', '1999-01-22', 'female', './images/user_images/abc@gmail.com_raspberries-1426859_1920.jpg', 0, 'regular', '2020-10-01 17:25:50', NULL),
(16, 'xyz@gmail.com', 'test1', 'C', 'V', 'Montreal', '', '1995-01-12', 'female', './images/user_images/xyz@gmail.com_salad-2756467_1920.jpg', 0, 'regular', '2020-10-03 23:53:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_favourite_list`
--

CREATE TABLE `user_favourite_list` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `user_id_favourited` int(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `MSG_FROM_USER` (`msg_from_user_id`),
  ADD KEY `MSG_TO_USER` (`msg_to_user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_favourite_list`
--
ALTER TABLE `user_favourite_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_favourite` (`user_id`),
  ADD KEY `user_id_to_favourite` (`user_id_favourited`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_favourite_list`
--
ALTER TABLE `user_favourite_list`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `MSG_FROM_USER` FOREIGN KEY (`msg_from_user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MSG_TO_USER` FOREIGN KEY (`msg_to_user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_favourite_list`
--
ALTER TABLE `user_favourite_list`
  ADD CONSTRAINT `user_id_favourite` FOREIGN KEY (`user_id`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_to_favourite` FOREIGN KEY (`user_id_favourited`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
