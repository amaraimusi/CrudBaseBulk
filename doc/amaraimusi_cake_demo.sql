-- phpMyAdmin SQL Dump
-- version 3.3.10.5
-- http://www.phpmyadmin.net
--
-- ホスト: mysql303.db.sakura.ne.jp
-- 生成時間: 2018 年 3 月 08 日 13:36
-- サーバのバージョン: 5.5.59
-- PHP のバージョン: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `amaraimusi_cake_demo`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `kanis`
--

CREATE TABLE IF NOT EXISTS `kanis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kani_val` int(11) DEFAULT NULL,
  `kani_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `kani_date` date DEFAULT NULL,
  `kani_group` int(11) DEFAULT NULL COMMENT '猫種別',
  `kani_dt` datetime DEFAULT NULL,
  `note` text CHARACTER SET utf8 NOT NULL COMMENT '備考',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) CHARACTER SET utf8 DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- テーブルのデータをダンプしています `kanis`
--

INSERT INTO `kanis` (`id`, `kani_val`, `kani_name`, `kani_date`, `kani_group`, `kani_dt`, `note`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, 1, 'neko', '2014-04-01', 2, '2014-12-12 00:00:00', '', 0, 'test', '::1', NULL, '2015-11-17 06:45:38'),
(2, 25, 'kani5', '2014-04-03', 1, '2014-12-12 00:00:01', '', 0, 'test', '::1', NULL, '2015-12-02 04:36:33'),
(4, 4, 'buta', '2014-04-04', 2, '2014-12-12 00:00:03', 'AA\\r\\nBBB\\r\\n<input />', 0, 'kani', '::1', '2015-10-30 23:59:59', '2015-11-10 05:04:04'),
(5, 3, 'yagi', '2015-09-17', 2, '2014-12-12 00:00:02', '', 0, 'kani', '::1', '2015-10-31 00:00:00', '2015-11-10 05:03:40'),
(6, 3, 'ari', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(7, 3, 'tori', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 1, 'kani', '::1', NULL, '2015-09-17 05:19:49'),
(8, 3, 'kame', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(9, 111, 'イッパイアッテナ', '2012-05-29', 3, '2014-04-28 10:04:00', 'いろは', 0, 'kani', '::1', NULL, '2015-09-16 20:56:07'),
(10, 123, 'PANDA', '1970-01-01', NULL, '2014-04-28 10:05:00', '', 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(11, 123, 'るどるふ', NULL, 5, NULL, '', 0, 'kani', '::1', '2015-09-17 05:39:20', '2015-09-16 20:39:20');

-- --------------------------------------------------------

--
-- テーブルの構造 `nekos`
--

CREATE TABLE IF NOT EXISTS `nekos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neko_val` int(11) DEFAULT NULL,
  `neko_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `neko_date` date DEFAULT NULL,
  `neko_group` int(11) DEFAULT NULL COMMENT '猫種別',
  `neko_dt` datetime DEFAULT NULL,
  `note` text CHARACTER SET utf8 NOT NULL COMMENT '備考',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) CHARACTER SET utf8 DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- テーブルのデータをダンプしています `nekos`
--

INSERT INTO `nekos` (`id`, `neko_val`, `neko_name`, `neko_date`, `neko_group`, `neko_dt`, `note`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, 1, 'neko', '2014-04-01', 2, '2014-12-12 00:00:00', '', 0, 0, 'kani', '119.245.191.174', NULL, '2015-11-17 17:40:54'),
(2, 2, '三毛A', '2014-04-02', 3, '2014-12-12 00:00:01', '', 0, 0, 'kani', '119.245.191.174', NULL, '2016-07-26 16:20:19'),
(4, 4, 'buta', '2014-04-04', NULL, '2014-12-12 00:00:03', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(5, 3, 'yagi', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(6, 3, 'ari', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(7, 3, 'tori', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(8, 3, 'kame', '2014-04-03', NULL, '2014-12-12 00:00:02', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01'),
(9, 111, '|| ''a'' == NULL', '1970-01-01', NULL, '2014-04-28 10:04:00', '白菜とサラダセット', 0, 0, 'kani', '119.245.191.174', NULL, '2016-09-20 18:02:16'),
(10, 123, 'PANDA', '1970-01-01', NULL, '2014-04-28 10:05:00', '', 0, 0, NULL, NULL, NULL, '2015-09-16 07:40:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- テーブルのデータをダンプしています `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`) VALUES
(1, 'yagi', 'metabo', NULL, NULL, NULL),
(2, 'buta', '6bc982d69201cebd343e66fd3ef0969e8a174ea2', 'admin', '2014-06-30 07:58:30', '2014-06-30 07:58:30'),
(3, 'kani', '26d1cc26d3e5bd63041e42c0c397fd4154fd329c', 'admin', '2014-06-30 08:24:48', '2014-06-30 08:24:48');
