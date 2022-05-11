-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2022 at 03:30 PM
-- Server version: 10.3.31-MariaDB-0+deb10u1
-- PHP Version: 7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialsite`
--
CREATE DATABASE IF NOT EXISTS `socialsite` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `socialsite`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accountType` varchar(20) NOT NULL DEFAULT 'user',
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `bio` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `username`, `email`, `password`, `accountType`, `fname`, `lname`, `bio`) VALUES
(1, 'zeke', 'Zeke.Inman@gmail.com', '46e470d67e80bc19552b5ea1fd29d4563958be5b', 'user', NULL, NULL, NULL),
(3, 'Willstidd', 'willstidd2@gmail.com', 'e5e8b3bc753d729b734e86fa49720e3ae2debf8b', 'user', 'willard', 'stidd', NULL),
(4, 'Michael', 'stevenschuck4132@gmail.com', 'a74eb04516c5d5814dbbba08e4d8310ffd951fa0', 'user', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postID` int(10) NOT NULL,
  `accountID` int(10) NOT NULL,
  `title` varchar(30) NOT NULL,
  `message` varchar(40) DEFAULT NULL,
  `imgLocation` varchar(250) DEFAULT NULL,
  `privacySetting` varchar(20) NOT NULL DEFAULT 'public',
  `postDate` datetime NOT NULL DEFAULT current_timestamp(),
  `postUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `accountID`, `title`, `message`, `imgLocation`, `privacySetting`, `postDate`, `postUpdate`) VALUES
(1, 1, 'Test', '12345678910', NULL, 'public', '2022-05-07 11:16:57', '2022-05-08 12:16:18'),
(2, 1, 'Evan', 'your sisters hot :)', NULL, 'public', '2022-05-07 11:20:35', '2022-05-11 12:12:56'),
(6, 3, 'Evan', 'where you get bitches ', NULL, 'public', '2022-05-08 15:14:53', NULL),
(7, 4, 'Google:', 'Sex gifs', NULL, 'public', '2022-05-11 15:28:19', NULL),
(8, 4, 'Help', 'How do you delete a message!!?!?!?', NULL, 'public', '2022-05-11 15:28:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
