-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 18, 2022 at 02:25 PM
-- Server version: 10.6.4-MariaDB-1:10.6.4+maria~focal
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Toctic`
--

-- --------------------------------------------------------

--
-- Table structure for table `Channels`
--
CREATE DATABASE IF NOT EXISTS `Toctic`;
USE `Toctic`;

CREATE TABLE `Channels` (
  `id` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `MainPicture` varchar(255) DEFAULT NULL,
  `CoverPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `RegDate` date NOT NULL,
  `Type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Channels`
--

INSERT INTO `Channels` (`id`, `CreatedByUserId`, `Name`, `MainPicture`, `CoverPicture`, `Description`, `RegDate`, `Type`) VALUES
(23, 12, 'Programmer Humor', 'Picture20220218829istockphoto-1266224795-170667a.jpeg', 'Picture20220218829b6d9e4bb3642d036a207f7a83b2f9128.jpeg', NULL, '2022-02-18', 'Everything'),
(24, 13, 'Tindler Swindler', 'Picture2022021899878sub-buzz-5277-1644357327-10.jpeg', 'Picture2022021899878screenshot-2022-02-02-at-112453-1024x499.png', NULL, '2022-02-18', 'Everything');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Text` varchar(200) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `PostId`, `UserId`, `Text`, `Date`) VALUES
(59, 24, 14, 'hahhahaha', '2022-02-18'),
(60, 26, 12, 'You probably don&#39;t have PHP 8.0 on that laptop, because this function came out only on 8.0 release', '2022-02-18'),
(61, 26, 14, 'Oh, it helped. Thank you very much🙏', '2022-02-18'),
(62, 25, 13, '...', '2022-02-18');

-- --------------------------------------------------------

--
-- Table structure for table `Followed`
--

CREATE TABLE `Followed` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ChannelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Followed`
--

INSERT INTO `Followed` (`id`, `UserId`, `ChannelId`) VALUES
(9, 12, 23),
(10, 13, 24),
(12, 14, 23),
(13, 14, 24);

-- --------------------------------------------------------

--
-- Table structure for table `Likes`
--

CREATE TABLE `Likes` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Reaction` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Likes`
--

INSERT INTO `Likes` (`id`, `UserId`, `PostId`, `Reaction`) VALUES
(466, 12, 24, 0),
(467, 13, 24, 2),
(468, 14, 24, 2),
(469, 14, 26, 0),
(470, 14, 25, 2),
(471, 12, 26, 0),
(472, 12, 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `id` int(11) NOT NULL,
  `ChannelId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Notifications`
--

INSERT INTO `Notifications` (`id`, `ChannelId`, `Date`, `UserId`) VALUES
(4, 23, '2022-02-18', 12),
(5, 24, '2022-02-18', 14),
(6, 23, '2022-02-18', 14),
(7, 23, '2022-02-18', 14);

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE `Posts` (
  `id` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `ChannelId` int(11) NOT NULL,
  `ImageName` varchar(255) DEFAULT NULL,
  `VideoName` varchar(255) DEFAULT NULL,
  `Caption` varchar(500) DEFAULT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`id`, `CreatedByUserId`, `ChannelId`, `ImageName`, `VideoName`, `Caption`, `Date`) VALUES
(24, 12, 23, 'r_2296425_Mt5EJ.jpeg', NULL, 'Follow us for more😂', '2022-02-18'),
(25, 14, 24, 'everyone-is-talking-about-the-tinder-swindler-her-2-413-1644576628-4_dblbig.jpeg', NULL, '', '2022-02-18'),
(26, 14, 23, NULL, NULL, 'Hi guys, I have a problem with str_contains. It gives me an error but it was working on other laptop', '2022-02-18'),
(27, 14, 23, NULL, '-5150072459860234807.mp4', '😂😂😂😂', '2022-02-18');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Country` varchar(56) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Age` int(11) NOT NULL,
  `RegDate` date NOT NULL,
  `ProfilePicture` varchar(255) DEFAULT 'DefaultProfile.png',
  `Identifier` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `Country`, `Gender`, `Age`, `RegDate`, `ProfilePicture`, `Identifier`) VALUES
(12, 'Jhon', 'Smith', 'jhonsmith', 'hptgrgkcqqoqfzjdad@kvhrw.com', '$2y$10$eAzaqMugnYRLzfOsLanz2O88rcg7xwR36pLEnU5cnvuORflafluZG', 'United Kingdom', 'Male', 31, '2022-02-18', 'image-640.png', '620f983c844229.93738486'),
(13, 'Simon', 'Leviev', 'simonleviev', 'aqyumhedtuwtzdhkvq@nthrl.com', '$2y$10$KKz.B3McneGyry/UgqHU2egFMIpwkOjzOUudYKu1zbqg9RfMyOobi', 'United Kingdom', 'Male', 24, '2022-02-18', 'simon.jpeg', '620fa4615e3290.40724775'),
(14, 'Bob', 'Test', 'megatron', 'aqyumhedtuwtzdhkvq@nthrl.com', '$2y$10$JHSqnGrVK9KOD4dqmDL1BuGHA601QzMgnZXxQQFKPbqdtwpA2UhL6', 'United Kingdom', 'Female', 18, '2022-02-18', '12531e0475545976e249eb6eca919b51.gif', '620fa5ed3a4606.30000534');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Channels`
--
ALTER TABLE `Channels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove channel if there is no user` (`CreatedByUserId`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Comment if there is no user` (`UserId`),
  ADD KEY `Remove Comment if there is no post` (`PostId`);

--
-- Indexes for table `Followed`
--
ALTER TABLE `Followed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Follow if no User` (`UserId`),
  ADD KEY `Remove Follow if no channel` (`ChannelId`);

--
-- Indexes for table `Likes`
--
ALTER TABLE `Likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Like if no user` (`UserId`),
  ADD KEY `Remove Like if no Post` (`PostId`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Notification if no channel` (`ChannelId`),
  ADD KEY `Remove Notification if no User` (`UserId`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Post if there is no user` (`CreatedByUserId`),
  ADD KEY `Remove Post if there is no Channel` (`ChannelId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Channels`
--
ALTER TABLE `Channels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `Followed`
--
ALTER TABLE `Followed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Likes`
--
ALTER TABLE `Likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Channels`
--
ALTER TABLE `Channels`
  ADD CONSTRAINT `Remove channel if there is no user` FOREIGN KEY (`CreatedByUserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Remove Comment if there is no post` FOREIGN KEY (`PostId`) REFERENCES `Posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Comment if there is no user` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Followed`
--
ALTER TABLE `Followed`
  ADD CONSTRAINT `Remove Follow if no User` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Follow if no channel` FOREIGN KEY (`ChannelId`) REFERENCES `Channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `Remove Like if no Post` FOREIGN KEY (`PostId`) REFERENCES `Posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Like if no user` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `Remove Notification if no User` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Notification if no channel` FOREIGN KEY (`ChannelId`) REFERENCES `Channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `Remove Post if there is no Channel` FOREIGN KEY (`ChannelId`) REFERENCES `Channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Post if there is no user` FOREIGN KEY (`CreatedByUserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
