-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2013 at 01:43 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `b_id` int(10) NOT NULL AUTO_INCREMENT,
  `c_id` int(20) NOT NULL,
  `b_name` varchar(20) NOT NULL,
  `b_author` varchar(20) DEFAULT NULL,
  `b_publisher` varchar(20) DEFAULT NULL,
  `b_quantity` int(10) NOT NULL,
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`b_id`, `c_id`, `b_name`, `b_author`, `b_publisher`, `b_quantity`) VALUES
(1, 1, 'C Programming', 'Y.K', 'ANSI', 5),
(5, 2, 'UNIX', 'ABC', 'ANSI', 6);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `bk_id` int(10) NOT NULL AUTO_INCREMENT,
  `u_id` int(10) NOT NULL,
  `b_id` int(10) NOT NULL,
  `d_booking` date NOT NULL,
  `d_return` date NOT NULL,
  `sf_tran` int(2) NOT NULL,
  `r_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`bk_id`),
  UNIQUE KEY `bk_id` (`bk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `booking`
--


-- --------------------------------------------------------

--
-- Table structure for table `b_cate`
--

CREATE TABLE IF NOT EXISTS `b_cate` (
  `c_id` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(30) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `b_cate`
--

INSERT INTO `b_cate` (`c_id`, `c_name`) VALUES
(1, 'DATABASE'),
(2, 'EMBEDDED');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL DEFAULT 'm',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `sign_up_date` date NOT NULL DEFAULT '0000-00-00',
  `last_log_date` date NOT NULL DEFAULT '0000-00-00',
  `bio_body` text,
  `website` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `friend_array` text,
  `account_type` enum('a','b','c') NOT NULL DEFAULT 'a',
  `email_activated` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `firstname`, `lastname`, `gender`, `birthday`, `country`, `state`, `city`, `email`, `password`, `ipaddress`, `sign_up_date`, `last_log_date`, `bio_body`, `website`, `youtube`, `facebook`, `twitter`, `friend_array`, `account_type`, `email_activated`) VALUES
(1, 'Lucky', '', '', 'm', '0000-00-00', '', '', '', 'aaa@b.k', '202cb962ac59075b964b07152d234b70', '127.0.0.1', '0000-00-00', '2013-11-10', NULL, NULL, NULL, NULL, NULL, NULL, 'a', '1'),
(5, 'Khan', 'Sahiba ', 'Khanam', 'f', '2010-01-01', 'India', 'Bihar', 'Katihar', 'aaa@bbb.com', 'e10adc3949ba59abbe56e057f20f883e', '127.0.0.1', '2013-11-11', '2013-11-20', '', 'www.abc.com', '4561231', '321564', NULL, NULL, 'a', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
