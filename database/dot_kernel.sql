-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 28, 2013 at 05:12 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dot_kernel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `firstName`, `lastName`, `dateCreated`, `isActive`) VALUES
(1, 'admin', 'cbd9c45d95caff1358e6be17d45847ef', 'team@dotkernel.com', 'Default', 'Account', '2010-03-14 20:05:43', '1');

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE IF NOT EXISTS `adminlogin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL,
  `adminId` int(11) unsigned NOT NULL,
  `referer` text NOT NULL,
  `userAgent` text NOT NULL,
  `dateLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `adminId` (`adminId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`id`, `ip`, `adminId`, `referer`, `userAgent`, `dateLogin`) VALUES
(1, '127.0.0.1', 1, 'http://dotkernel.me/admin/admin/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-26 04:54:14'),
(2, '127.0.0.1', 1, 'http://dotkernel.me/admin/admin/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-26 04:55:02'),
(3, '127.0.0.1', 1, 'http://dotkernel.me/admin/admin/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-27 02:13:46'),
(4, '127.0.0.1', 1, 'http://dotkernel.me/admin/admin/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-28 05:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `emailtransporter`
--

CREATE TABLE IF NOT EXISTS `emailtransporter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `server` varchar(100) NOT NULL DEFAULT 'smtp.gmail.com',
  `port` int(5) NOT NULL DEFAULT '465',
  `ssl` enum('tls','ssl') NOT NULL DEFAULT 'tls',
  `capacity` int(11) NOT NULL DEFAULT '2000',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `counter` int(11) NOT NULL DEFAULT '0',
  `isActive` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `postion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `description`, `status`, `postion`) VALUES
(1, 'Menu Left Sidebar', 'Menu Left Sidebar Menu Left SidebarMenu Left SidebarMenu Left SidebarMenu Left SidebarMenu Left SidebarMenu Left SidebarMenu Left Sidebar', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE IF NOT EXISTS `menuitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `menu_top` tinyint(1) NOT NULL,
  `menu_left` tinyint(1) DEFAULT NULL,
  `menu_bottom` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `menuitem`
--

INSERT INTO `menuitem` (`id`, `title`, `link`, `description`, `status`, `menu_top`, `menu_left`, `menu_bottom`) VALUES
(1, 'Home', '/page/home', 'Home Home Home Home Home Home Home Home ', 1, 0, 1, 1),
(2, 'About', '/page/about', 'About the company', 1, 1, 1, 0),
(11, 'Who we are', '/page/who-we-are', 'Who we are Who we are Who we are Who we are Who we are ', 1, 1, 1, 0),
(12, 'Code Standar', '/page/coding-standard', 'Code Standar Code Standar Code Standar Code Standar ', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `title` text NOT NULL,
  `comment` text NOT NULL,
  `isEditable` enum('1','0') NOT NULL DEFAULT '0',
  `type` enum('radio','option','textarea') NOT NULL DEFAULT 'textarea',
  `possibleValues` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `key`, `value`, `title`, `comment`, `isEditable`, `type`, `possibleValues`) VALUES
(1, 'siteEmail', '', 'Site Email Address', 'The email address that recieves all contact emails from the site.\r\nAlso used as Sender Email for ''forgot password''.', '1', 'textarea', ''),
(2, 'devEmails', 'team@dotkernel.com', 'Developer Emails', 'developer emails, for debug purpose, separated by comma', '0', 'textarea', ''),
(3, 'timeFormatShort', '%d %b %Y', 'Short Date/Time Format.', '%d - day of the month as a decimal number (range 01 to 31) %b - abbreviated month name according to the current locale %B - full month name according to the current locale %m - month as a decimal number (range 01 to 12) %y - year as a decimal number without a century (range 00 to 99) %Y - year as a decimal number including the century', '1', 'option', '%d %b %Y;%d %B %Y;%d %B %y;%d %m %Y;%d %m %y;%B %d, %Y;%b %d, %Y'),
(4, 'timeFormatLong', '%b %d, %Y, %H:%M', 'Long Date/Time Format.', 'Date/time format, including hours, minutes and seconds', '1', 'option', '%d %b %Y, %H:%M;%d %B %Y, %H:%M;%d %B %y, %H:%M;%d %m %Y, %H:%M;%d %m %y, %H:%M;%B %d, %Y, %H:%M;%b %d, %Y, %H:%M'),
(5, 'smtpAddresses', 'aol.com;aim.com;comcast.net;hotmail.com;earthlink.net;juno.com;juno.net;bellsouth.net;cox.net;roadrunner.com;sbcglobal.net', 'Email servers where we need to use external SMTP in order to send emails.', '', '0', 'textarea', ''),
(6, 'smtpActive', '0', 'Use external SMTP servers', 'If we use or not external SMTP servers.', '1', 'radio', '1;0'),
(7, 'resultsPerPage', '5', 'Default results per page', 'How many records will be on every page, if is not specified otherwise by a specific configuration value', '1', 'option', '5;10;20;30;40;50'),
(8, 'whoisUrl', 'http://whois.domaintools.com', '', 'Whois lookup and Domain name search', '0', 'textarea', ''),
(9, 'paginationStep', '6', 'Pagination Step', 'The maximum number of pages that are shown on either side of the current page in the pagination header.', '1', 'option', '3;4;5;6;7;8;9;10');

-- --------------------------------------------------------

--
-- Table structure for table `statisticvisit`
--

CREATE TABLE IF NOT EXISTS `statisticvisit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL,
  `proxyIp` varchar(255) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `accept` text NOT NULL,
  `acceptLanguage` text NOT NULL,
  `acceptEncoding` text NOT NULL,
  `acceptCharset` text NOT NULL,
  `userAgent` text NOT NULL,
  `cacheControl` text NOT NULL,
  `cookie` text NOT NULL,
  `xWapProfile` text NOT NULL,
  `xForwardedFor` text NOT NULL,
  `xForwardedHost` text NOT NULL,
  `xForwardedServer` text NOT NULL,
  `referer` text NOT NULL,
  `dateHit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `statisticvisitmobile`
--

CREATE TABLE IF NOT EXISTS `statisticvisitmobile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visitId` int(11) unsigned NOT NULL,
  `fallBack` varchar(100) NOT NULL,
  `brandName` varchar(100) NOT NULL,
  `modelName` varchar(100) NOT NULL,
  `browserName` varchar(100) NOT NULL,
  `browserVersion` varchar(100) NOT NULL,
  `deviceOs` varchar(100) NOT NULL,
  `deviceOsVersion` varchar(100) NOT NULL,
  `screenWidth` int(6) NOT NULL,
  `screenHeight` int(6) NOT NULL,
  `isTablet` enum('0','1') NOT NULL DEFAULT '0',
  `isMobile` enum('0','1') NOT NULL DEFAULT '0',
  `isSmartphone` enum('0','1') NOT NULL DEFAULT '0',
  `isIphone` enum('0','1') NOT NULL DEFAULT '0',
  `isAndroid` enum('0','1') NOT NULL DEFAULT '0',
  `isBlackberry` enum('0','1') NOT NULL DEFAULT '0',
  `isSymbian` enum('0','1') NOT NULL DEFAULT '0',
  `isWindowsMobile` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `visitId` (`visitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `firstName`, `lastName`, `dateCreated`, `isActive`) VALUES
(1, 'admin', 'admin123', 'admin@yopmail.com', 'Hoang', 'Nguyen', '2013-11-26 09:51:32', '1');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE IF NOT EXISTS `userlogin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL,
  `country` varchar(255) NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `referer` text NOT NULL,
  `userAgent` text NOT NULL,
  `dateLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `adminId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `ip`, `country`, `userId`, `referer`, `userAgent`, `dateLogin`) VALUES
(1, '127.0.0.1', 'NA', 1, 'http://dotkernel.me/user/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-26 09:51:47'),
(2, '127.0.0.1', 'NA', 1, 'http://dotkernel.me/user/login', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '2013-11-28 06:57:13');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD CONSTRAINT `fk_adminLogin_admin` FOREIGN KEY (`adminId`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statisticvisitmobile`
--
ALTER TABLE `statisticvisitmobile`
  ADD CONSTRAINT `statisticVisitMobile_ibfk_1` FOREIGN KEY (`visitId`) REFERENCES `statisticvisit` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD CONSTRAINT `fk_userLogin_user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
