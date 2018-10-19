-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-10-19 02:54:22
-- 服务器版本： 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `junxun`
--

-- --------------------------------------------------------

--
-- 表的结构 `junxun_comment`
--

DROP TABLE IF EXISTS `junxun_comment`;
CREATE TABLE IF NOT EXISTS `junxun_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL COMMENT '主图id',
  `name` varchar(50) NOT NULL COMMENT '评论人名字',
  `say` varchar(250) NOT NULL COMMENT '评论内容',
  `ip` varchar(50) NOT NULL COMMENT 'IP地址',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '回复时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='评论';

-- --------------------------------------------------------

--
-- 表的结构 `junxun_photo`
--

DROP TABLE IF EXISTS `junxun_photo`;
CREATE TABLE IF NOT EXISTS `junxun_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题或者名字',
  `main_photo` varchar(150) NOT NULL COMMENT '主图文件名',
  `say` varchar(500) NOT NULL COMMENT '想说的话',
  `beauty` decimal(9,2) NOT NULL COMMENT '颜值',
  `smile` decimal(9,2) NOT NULL COMMENT '笑容',
  `popular` int(11) NOT NULL DEFAULT '0' COMMENT '人气',
  `votes` int(11) NOT NULL DEFAULT '0' COMMENT '票数',
  `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否审核，0为未审核，1为审核通过，2为审核不通过',
  `contact` varchar(100) DEFAULT NULL,
  `ip` varchar(50) NOT NULL COMMENT 'IP地址',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `junxun_second_photo`
--

DROP TABLE IF EXISTS `junxun_second_photo`;
CREATE TABLE IF NOT EXISTS `junxun_second_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL COMMENT '对应的主图id',
  `name` varchar(150) NOT NULL COMMENT '图片名字',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `junxun_votes`
--

DROP TABLE IF EXISTS `junxun_votes`;
CREATE TABLE IF NOT EXISTS `junxun_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL COMMENT 'IP',
  `post_id` int(11) NOT NULL COMMENT '投票的图片ID',
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='投票记录';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
