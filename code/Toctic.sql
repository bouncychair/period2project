-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 08, 2022 at 01:42 PM
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
(1, 6, 'FirstChannel', '1400.jpeg', NULL, 'This is first channel', '2021-12-09', ''),
(2, 7, 'geekcommunity', 'avatar.png', 'Flag-of-The-Netherlands3.png', 'Test description', '2021-12-20', ''),
(15, 7, 'Netherlands', 'Picture20220111200512531e0475545976e249eb6eca919b51.gif', 'Picture202201112005800px-Flag_of_the_Netherlands.png', 'Hi there', '2022-01-11', 'Everything'),
(16, 6, 'Github', 'Picture2022012474535Picture20220111200512531e0475545976e249eb6eca919b51.gif', 'Picture20220124745351200px-Flag_of_the_United_Kingdom.svg.png', 'This channel is just for testing', '2022-01-24', 'Everything'),
(17, 6, 'jajaja', 'Picture2022020880262Screen Shot 1400-11-17 at 12.55.35.png', 'Picture2022020880262Screen Shot 1400-11-10 at 15.46.49.png', 'jajajaja', '2022-02-08', 'photo'),
(18, 6, 'dadad', 'Picture2022020820569Screen Shot 1400-11-17 at 12.55.35.png', 'Picture2022020820569Screen Shot 1400-11-10 at 15.47.23.png', 'adadad', '2022-02-08', 'photo'),
(19, 6, 'CreatedChannelfsf', 'Picture2022020829347Screen Shot 1400-11-10 at 15.47.23.png', 'Picture2022020829347Screen Shot 1400-11-10 at 15.47.23.png', 'sfsfsf', '2022-02-08', 'photo');

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
(3, 7, 2),
(4, 7, 1);

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
(463, 7, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `id` int(11) NOT NULL,
  `ChannelId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(7, 7, 1, 'cute-penguin-cartoon-icon-vector.jpeg103655.jpeg', NULL, 'Test post', '2022-01-11'),
(10, 7, 1, 'funny-dancing-cartoon-penguin-earmuffs-vector-flat-illustration-adorable-happy-polar-animal-moving-warm-accessory-isolated-175368179.jpeg103829.jpeg', NULL, 'post 2', '2022-01-11'),
(13, 7, 1, NULL, NULL, 'Hi guys, How are you today?', '2022-01-11'),
(14, 7, 1, NULL, NULL, 'Wassuppp', '2022-01-11'),
(15, 7, 1, NULL, NULL, 'Wassuppp', '2022-01-11'),
(16, 7, 2, NULL, NULL, 'Wassuppp', '2022-01-11'),
(17, 7, 2, 'paper-plane-10.png', NULL, 'hahahahha', '2022-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `Tokens`
--

CREATE TABLE `Tokens` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Token` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 'Sahib', 'Zulfigar', 'sahibthecreator', 'sahibzulfigar4@gmail.com', '$2y$10$/Mr3uCYRSQIGp7gm9tpsOusN8JkHbXQJzTpj5eBjXnBa2njZcCrKC', 'Netherlands', 'Male', 17, '2021-12-09', '391912870_CHRISTMAS_TREE_400px.gif', '61b200540e92a6.83807161'),
(7, 'Bob', 'Test', 'Rob', 'sahibzulfigar4@gmail.com', '$2y$10$RGWX1YrZ6uGyxwGqriosn.nCdw4MA5hCWY5cwDOwJzDn97BBy8hG.', 'Netherlands', 'Male', 21, '2021-12-09', 'joker (1).jpg', '61b238d576f565.22469766'),
(8, 'Bob', 'Test', 'bobtester', 'sahibzulfigar4@gmail.com', '$2y$10$gJ0TIth/IoVV9cMaZTtFlOSi/VZYWQeSzPgCxYnqVTbzbISCeLjfq', 'Netherlands', 'Male', 21, '2021-12-09', 'DefaultProfile.png', '61b238dbbff6d8.91529916'),
(9, 'MrTest', 'Tester', 'mrtester', 'sahibzulfigar4@gmail.com', '$2y$10$ArXk97vGOci/Zw9P9GqAyO102RBFt6SshFU8RiOWk0oMzZgMFmnPy', 'Netherlands', 'Other', 29, '2021-12-10', 'DefaultProfile.png', '61b33747c7b1a2.85638735'),
(10, 'Test', 'Ivanov', 'ivanov91', 'sahibzulfigar4@gmail.com', '$2y$10$Dz8oAn5bwYm9Ts5UGr7RauhRIgiqlbNq8JhqbVbOifEyMsWeUjdJ6', 'United Kingdom', 'Male', 10, '2021-12-22', 'DefaultProfile.png', '61c36a9a0362c0.36966284'),
(11, 'test', 'test', 'test183', 'sahibzulfigar4@gmail.com', '$2y$10$PWPyM8AxIm96cz9zSZgJkO3ZusTCXxEHQ88VzWBgiVxH6duMaFERe', 'Netherlands', 'Male', 17, '2022-02-08', 'DefaultProfile.png', '62026f16ec94f9.37719721');

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
  ADD KEY `Remove Notification if no Post` (`PostId`),
  ADD KEY `Remove Notification if no User` (`ChannelId`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Post if there is no user` (`CreatedByUserId`),
  ADD KEY `Remove Post if there is no Channel` (`ChannelId`);

--
-- Indexes for table `Tokens`
--
ALTER TABLE `Tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Remove Token if no User` (`UserId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `Followed`
--
ALTER TABLE `Followed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Likes`
--
ALTER TABLE `Likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Tokens`
--
ALTER TABLE `Tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `Remove Notification if no Post` FOREIGN KEY (`PostId`) REFERENCES `Posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Notification if no User` FOREIGN KEY (`ChannelId`) REFERENCES `Channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `Remove Post if there is no Channel` FOREIGN KEY (`ChannelId`) REFERENCES `Channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Remove Post if there is no user` FOREIGN KEY (`CreatedByUserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Tokens`
--
ALTER TABLE `Tokens`
  ADD CONSTRAINT `Remove Token if no User` FOREIGN KEY (`UserId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
