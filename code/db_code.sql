CREATE DATABASE IF NOT EXISTS `Toctic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Toctic`;

CREATE TABLE `Users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Age` int(11) NOT NULL,
  `RegDate` varchar(30),
  `ProfilePicture` varchar(500) NOT NULL,
  `Token` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Channels` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `CreatedBy` int(10) NOT NULL,
  `MainPic` varchar(500) NOT NULL,
  `CoverPic` varchar(500) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `RegDate` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ChannelId` int(10) NOT NULL,
  `Img` varchar(500),
  `Video` varchar(500),
  `Caption` varchar(255),
  `likes` int,
  `RegDate` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ChannelId` int(10) NOT NULL,
  `UserId` int(10) NOT NULL,
  `Text` varchar(255),
  `Date` varchar(30),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



