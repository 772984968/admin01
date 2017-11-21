-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 �?10 �?09 �?10:50
-- 服务器版本: 5.7.17
-- PHP 版本: 7.0.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `admin01`
--

-- --------------------------------------------------------

--
-- 表的结构 `li_access`
--

CREATE TABLE IF NOT EXISTS `li_access` (
  `role_id` smallint(6) unsigned NOT NULL COMMENT '全选id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点id',
  `level` tinyint(1) NOT NULL COMMENT '权限等级',
  `module` varchar(50) DEFAULT NULL COMMENT '角色模块',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='基于角色的权限访问表';

-- --------------------------------------------------------

--
-- 表的结构 `li_admin`
--

CREATE TABLE IF NOT EXISTS `li_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` varchar(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '上次登录ip',
  `last_time` int(11) DEFAULT NULL COMMENT '上次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `li_feedback`
--

CREATE TABLE IF NOT EXISTS `li_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` varchar(20) NOT NULL COMMENT '用户id',
  `content` tinytext COMMENT '反馈内容',
  `time` int(11) NOT NULL COMMENT '反馈时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户反馈表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `li_node`
--

CREATE TABLE IF NOT EXISTS `li_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限节点表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `li_system_log`
--

CREATE TABLE IF NOT EXISTS `li_system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL COMMENT '登录ip',
  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '操作方法',
  `time` int(11) NOT NULL COMMENT '添加时间',
  `content` varchar(30) DEFAULT NULL COMMENT '内容',
  `user` varchar(20) NOT NULL COMMENT '登录用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
