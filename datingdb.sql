-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2020 at 05:45 AM
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
  `msg` varchar(500) NOT NULL,
  `msg_to_user_id` int(50) NOT NULL,
  `msg_date` datetime NOT NULL,
  `is_msg_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `user_role` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `email`, `password`, `firstName`, `lastName`, `city`, `bio`, `birthDate`, `gender`, `imgUrl`, `user_role`, `created_date`, `modified_date`) VALUES
(13, 'patel00446@gmail.com', 'test', 'Test', 'User', 'Montreal', '', '1995-12-01', 'male', './images/user_images/patel00446@gmail.com_login-background.jpg', 'regular', '2020-09-30 18:45:17', NULL),
(14, 'testing@gmail.com', 'test', 'Vatsal 1', 'Chauhan', 'Surat', 'i AM vatsAL\r\nI ;ike [rogramming very much and I can do programming whole day', '1995-01-12', 'male', './images/user_images/testing@gmail.com_pngfuel.com.png', 'premium', '2020-10-01 17:16:30', NULL),
(15, 'abc@gmail.com', 'test', 'Female', 'Girl', 'Quebec', '', '1999-01-22', 'female', './images/user_images/abc@gmail.com_raspberries-1426859_1920.jpg', 'regular', '2020-10-01 17:25:50', NULL);

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
