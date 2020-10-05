-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2020 at 07:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

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
CREATE DATABASE IF NOT EXISTS `datingdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `datingdb`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `msg_from_user_id` int(50) NOT NULL,
  `msg` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `msg_to_user_id` int(50) NOT NULL,
  `msg_date` datetime NOT NULL,
  `is_msg_read` tinyint(1) NOT NULL DEFAULT 0,
  `msg_read_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `MSG_FROM_USER` (`msg_from_user_id`),
  KEY `MSG_TO_USER` (`msg_to_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg_from_user_id`, `msg`, `msg_to_user_id`, `msg_date`, `is_msg_read`, `msg_read_date`) VALUES
(1, 1, 'Hello Meet', 2, '2020-10-04 23:49:58', 1, '2020-10-04 23:58:13'),
(2, 1, 'How are you?', 2, '2020-10-04 23:50:16', 1, '2020-10-04 23:58:13'),
(3, 1, '😉', 3, '2020-10-04 23:51:07', 0, NULL),
(4, 1, '😉', 6, '2020-10-04 23:57:36', 1, '2020-10-05 00:29:24'),
(5, 2, 'Hi vatsal', 1, '2020-10-04 23:58:21', 1, '2020-10-05 00:05:47'),
(6, 2, '😉', 4, '2020-10-05 00:05:13', 0, NULL),
(7, 6, 'Hi meet', 2, '2020-10-05 00:29:41', 1, '2020-10-05 00:53:29'),
(8, 6, 'Wow', 2, '2020-10-05 00:29:51', 1, '2020-10-05 00:53:29'),
(9, 6, 'Wow', 2, '2020-10-05 00:31:02', 1, '2020-10-05 00:53:29'),
(10, 6, '😉', 3, '2020-10-05 00:31:20', 0, NULL),
(20, 9, 'Hi', 2, '2020-10-05 01:45:04', 1, '2020-10-05 01:47:37'),
(21, 9, '😉', 2, '2020-10-05 01:45:12', 1, '2020-10-05 01:47:37'),
(22, 9, 'Hi', 1, '2020-10-05 01:47:10', 0, NULL),
(23, 2, '😉', 5, '2020-10-05 01:47:31', 0, NULL),
(24, 2, 'Hey', 9, '2020-10-05 01:47:41', 1, '2020-10-05 01:48:13'),
(25, 2, '😉', 9, '2020-10-05 01:47:53', 1, '2020-10-05 01:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
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
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `email`, `password`, `firstName`, `lastName`, `city`, `bio`, `birthDate`, `gender`, `imgUrl`, `receive_notification`, `user_role`, `created_date`, `modified_date`) VALUES
(1, 'vatsal@gmail.com', 'test', 'Vatsal', 'Chauhan', 'Montreal', 'Hi,\r\nPassionate to code and play sports.\r\nLearning to play life by ears', '1995-01-12', 'male', './images/user_images/vatsal@gmail.com_malepic1.jpg', 1, 'premium', '2020-10-04 23:11:39', '0000-00-00 00:00:00'),
(2, 'meet@gmail.com', 'test', 'Meet', 'Patel', 'Montreal', 'I am meet\r\nPleasure to meet you', '1998-05-05', 'male', './images/user_images/meet@gmail.com_malepic3.jpg', 1, 'premium', '2020-10-04 23:12:37', '0000-00-00 00:00:00'),
(3, 'justin@gmail.com', 'test', 'Justin', 'Matthew', 'Montreal', '', '1990-02-05', 'male', './images/user_images/justin@gmail.com_malepic2.jpg', 0, 'regular', '2020-10-04 23:13:37', NULL),
(4, 'janki@gmail.com', 'test', 'Janki', 'Jariwala', 'Quebec', '', '1996-12-13', 'female', './images/user_images/janki@gmail.com_femalepic1.jpg', 0, 'regular', '2020-10-04 23:14:25', NULL),
(5, 'mariadb@gmail.com', 'test', 'Maria', 'DB', 'Hamilton', '', '1995-09-28', 'female', './images/user_images/mariadb@gmail.com_femalepic2.jpg', 0, 'regular', '2020-10-04 23:15:45', NULL),
(6, 'angelpriya@gmail.com', 'test', 'Angel', 'Priya', 'Windsor', '', '1997-05-10', 'female', './images/user_images/angelpriya@gmail.com_femalepic3.jpg', 0, 'regular', '2020-10-04 23:16:35', NULL),
(9, 'testing@gmail.com', 'test', 'Test', 'User', 'Calgary', 'Hi,\r\nMy name is Test User\r\nI love dating', '1996-01-28', 'male', './images/user_images/testing@gmail.com_output-onlinepngtools.png', 0, 'premium', '2020-10-05 01:44:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_favourite_list`
--

DROP TABLE IF EXISTS `user_favourite_list`;
CREATE TABLE IF NOT EXISTS `user_favourite_list` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `user_id_favourited` int(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_favourite` (`user_id`),
  KEY `user_id_to_favourite` (`user_id_favourited`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_favourite_list`
--

INSERT INTO `user_favourite_list` (`id`, `user_id`, `user_id_favourited`, `dateCreated`) VALUES
(9, 1, 2, '2020-10-05 00:43:56'),
(10, 1, 5, '2020-10-05 00:43:59'),
(11, 1, 6, '2020-10-05 00:44:01'),
(12, 2, 4, '2020-10-05 00:54:09'),
(20, 9, 2, '2020-10-05 01:48:37');

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
