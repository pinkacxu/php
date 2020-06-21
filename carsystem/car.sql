-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-06-21 15:09:22
-- 服务器版本： 10.1.36-MariaDB
-- PHP 版本： 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `car`
--

-- --------------------------------------------------------

--
-- 表的结构 `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `brand`
--

INSERT INTO `brand` (`id`, `title`) VALUES
(1, 'Mercedes'),
(2, 'BMW'),
(3, 'Audi '),
(4, 'Land Rover'),
(5, 'レクサス');

-- --------------------------------------------------------

--
-- 表的结构 `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `bid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `click` int(11) NOT NULL DEFAULT '1',
  `content` text,
  `price` float(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `car`
--

INSERT INTO `car` (`id`, `cid`, `bid`, `title`, `picurl`, `click`, `content`, `price`) VALUES
(23, 1, 5, 'レクサス', 'uploadfile/2014-05/1400946780BBmg8krkxYng.jpg', 6, '安い', 1200.00),
(24, 2, 5, 'トヨタ', 'uploadfile/2014-05/1400946852jLuSi3eX5G4p.jpg', 4, 'きれい', 1800.00);

-- --------------------------------------------------------

--
-- 表的结构 `carclass`
--

CREATE TABLE `carclass` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `carclass`
--

INSERT INTO `carclass` (`id`, `title`, `picurl`) VALUES
(1, 'ミニカー', 'uploadfile/2014-05/1400946130UsZKjmSFzPKc.gif'),
(2, '小型車', 'uploadfile/2014-05/14009466286epRzMKf97hN.gif'),
(3, 'コンパクト', 'uploadfile/2014-05/1400946608uygYRwMXApEk.gif'),
(4, '中型車', 'uploadfile/2014-05/1400946598JJHPmnEvt8b7.gif'),
(5, '大型車', 'uploadfile/2014-05/1400946584s8B9FTtdKdaD.gif'),
(6, '高級車', 'uploadfile/2014-05/1400946565CSkkVcXhR8yN.gif'),
(7, 'SUV', 'uploadfile/2014-05/1400946554IDXj8pJkphzn.gif'),
(8, 'MPV', 'uploadfile/2014-05/14009465423cMbd2DuvxWY.gif');

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(3) DEFAULT NULL,
  `tel` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `realname`, `email`, `gender`, `tel`) VALUES
(30, 'a', '8277e0910d750195b448797616e091ad', 'c', 'e', '男', 'd');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `content` text,
  `mid` int(4) DEFAULT NULL,
  `number` varchar(64) DEFAULT NULL,
  `carid` int(11) DEFAULT NULL,
  `zdates` text NOT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0未处理1已付款2已发货3已签收4已归还'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `address`, `content`, `mid`, `number`, `carid`, `zdates`, `status`) VALUES
(6, '請求', '請求', 31, '201712022016166e7wX', 26, '20171207,20171214,20171208,20171215', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(21, 'admin', 'e10adc3949ba59abbe56e057f20f883e');

--
-- 转储表的索引
--

--
-- 表的索引 `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `carclass`
--
ALTER TABLE `carclass`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `carclass`
--
ALTER TABLE `carclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
