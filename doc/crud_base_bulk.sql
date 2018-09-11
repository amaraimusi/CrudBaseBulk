-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.30-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_base_bulk`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bulk_makes`
--

CREATE TABLE `bulk_makes` (
  `id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL COMMENT '任務id',
  `field_name` varchar(64) NOT NULL COMMENT 'フィールド名',
  `type_a` int(11) NOT NULL COMMENT 'タイプA',
  `field_type` varchar(64) NOT NULL COMMENT 'フィールド型',
  `orig_type` varchar(64) NOT NULL COMMENT 'オリジナル型',
  `type_long` int(11) DEFAULT NULL COMMENT '型長さ',
  `null_flg` int(11) DEFAULT '0' COMMENT 'NULLフラグ',
  `p_key_flg` int(11) DEFAULT '0' COMMENT '主キーフラグ',
  `def_val` varchar(64) DEFAULT NULL COMMENT 'デフォルト値',
  `extra` varchar(256) DEFAULT NULL COMMENT '補足',
  `comment` varchar(256) DEFAULT NULL COMMENT 'コメント',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `bulk_makes`
--

INSERT INTO `bulk_makes` (`id`, `mission_id`, `field_name`, `type_a`, `field_type`, `orig_type`, `type_long`, `null_flg`, `p_key_flg`, `def_val`, `extra`, `comment`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(25, 2, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(32, 2, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 10, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(33, 2, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 11, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(34, 2, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 12, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(35, 2, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 13, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(36, 2, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 14, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(37, 2, 'yagi_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '山羊名', 2, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(38, 2, 'yagi_val1', 24, 'int', 'int(11)', 11, 0, 0, NULL, '', '山羊値１', 3, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(39, 2, 'yagi_date', 25, 'date', 'date', 0, 0, 0, NULL, '', 'yagi_date', 4, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(40, 2, 'yagi_x_date', 15, 'date', 'date', 0, 1, 0, NULL, '', '山羊X日付', 5, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(41, 2, 'yagi_group', 27, 'int', 'int(11)', 11, 0, 0, NULL, '', '山羊種別', 6, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(42, 2, 'yagi_dt', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', 'yagi_dt', 7, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(43, 2, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 9, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(44, 2, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 8, 0, NULL, NULL, '2018-04-23 17:13:54', '2018-04-23 08:13:54'),
(45, 3, 'id', 22, 'int', 'int(10) unsigned', 10, 1, 1, NULL, 'auto_increment', 'ID', 1, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(46, 3, 'username', 2, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', 'ユーザー名', 2, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(47, 3, 'password', 2, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', 'パスワード', 3, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(48, 3, 'role', 27, 'varchar', 'varchar(20)', 20, 0, 0, '', '', '権限', 4, 0, 'yagi', '::1', '2018-04-30 13:17:53', '2018-04-30 04:25:26'),
(49, 3, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '作成日時', 9, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(50, 3, 'modified', 21, 'datetime', 'datetime', 0, 0, 0, NULL, '', '更新日時', 10, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(51, 4, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(52, 4, 'yagi_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '山羊名', 2, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(53, 4, 'yagi_val1', 24, 'int', 'int(11)', 11, 0, 0, NULL, '', '山羊値１', 3, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(54, 4, 'yagi_date', 25, 'date', 'date', 0, 0, 0, NULL, '', 'yagi_date', 4, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(55, 4, 'yagi_x_date', 25, 'date', 'date', 0, 1, 0, NULL, '', '山羊X日付', 5, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(56, 4, 'yagi_group', 27, 'int', 'int(11)', 11, 0, 0, '', '', '山羊種別', 6, 0, 'kani', '::1', '2018-04-28 23:09:47', '2018-04-28 22:00:42'),
(57, 4, 'yagi_dt', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', 'yagi_dt', 7, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(58, 4, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 8, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(59, 4, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 9, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(60, 4, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 10, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(61, 4, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 11, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(62, 4, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 12, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(63, 4, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 13, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(64, 4, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 14, 0, NULL, NULL, '2018-04-28 23:09:47', '2018-04-28 14:09:47'),
(65, 3, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 5, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(66, 3, 'delete_flg', 12, 'tinyint', 'tinyint(4)', 4, 0, 0, '0', '', '削除フラグ', 6, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(67, 3, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新ユーザー', 7, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(68, 3, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', '更新IPアドレス', 8, 0, NULL, NULL, '2018-04-30 13:17:53', '2018-04-30 04:17:53'),
(69, 5, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'ID', 1, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(70, 5, 'kl_category_name', 2, 'varchar', 'varchar(64)', 64, 1, 0, NULL, '', 'カテゴリ名', 2, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(71, 5, 'category_code', 2, 'varchar', 'varchar(16)', 16, 1, 0, NULL, '', 'カテゴリコード', 3, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(72, 5, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 4, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(73, 5, 'delete_flg', 12, 'tinyint', 'tinyint(4)', 4, 0, 0, '0', '', '削除フラグ', 5, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(74, 5, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新ユーザー', 6, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(75, 5, 'ip_addr', 19, 'varchar', 'varchar(16)', 16, 0, 0, NULL, '', 'IPアドレス', 7, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(76, 5, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 8, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(77, 5, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日時', 9, 0, NULL, NULL, '2018-05-08 19:09:05', '2018-05-08 10:09:05'),
(78, 6, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'ID', 1, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(79, 6, 'kl_text', 3, 'text', 'text', 0, 0, 0, NULL, '', '心得テキスト', 2, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(80, 6, 'xid', 2, 'varchar', 'varchar(32)', 32, 1, 0, NULL, '', 'XID', 3, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(83, 6, 'contents_url', 2, 'varchar', 'varchar(1024)', 1024, 0, 0, NULL, '', '内容URL', 5, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(84, 6, 'doc_name', 2, 'varchar', 'varchar(256)', 256, 0, 0, NULL, '', '文献名', 6, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(85, 6, 'doc_text', 3, 'text', 'text', 0, 0, 0, NULL, '', '文献テキスト', 7, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(86, 6, 'dtm', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', '学習日時', 8, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(87, 6, 'level', 24, 'int', 'int(11)', 11, 0, 0, '0', '', '学習レベル', 9, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(88, 6, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 10, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(89, 6, 'delete_flg', 12, 'tinyint', 'tinyint(4)', 4, 0, 0, '0', '', '削除フラグ', 11, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(90, 6, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新ユーザー', 12, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(91, 6, 'ip_addr', 19, 'varchar', 'varchar(16)', 16, 0, 0, NULL, '', 'IPアドレス', 13, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(92, 6, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 14, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(93, 6, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日時', 15, 0, NULL, NULL, '2018-05-08 19:54:37', '2018-05-08 10:54:37'),
(94, 6, 'kl_category', 27, 'int', 'int(11)', 11, 1, 0, '0', '', 'カテゴリ', 4, 0, 'kani', '::1', '2018-05-08 19:54:37', '2018-05-08 10:54:48'),
(95, 7, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(96, 7, 'rec_title', 2, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', 'rec_title', 2, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(97, 7, 'rec_date', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', 'rec_date', 3, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(98, 7, 'note', 3, 'varchar', 'varchar(1000)', 1000, 0, 0, '', '', 'note', 4, 0, 'kani', '::1', '2018-06-16 19:51:16', '2018-06-16 10:51:45'),
(99, 7, 'category_id2', 6, 'int', 'int(11)', 11, 0, 0, '', '', 'category_id2', 5, 0, 'kani', '::1', '2018-06-16 19:51:16', '2018-06-16 10:54:18'),
(100, 7, 'category_id1', 6, 'int', 'int(11)', 11, 0, 0, '', '', 'category_id1', 6, 0, 'kani', '::1', '2018-06-16 19:51:16', '2018-06-16 10:54:28'),
(101, 7, 'tags', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', 'tags', 7, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(102, 7, 'photo_fn', 2, 'varchar', 'varchar(128)', 128, 0, 0, NULL, '', 'photo_fn', 8, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(103, 7, 'photo_dir', 2, 'varchar', 'varchar(128)', 128, 0, 0, NULL, '', '写真ディレクトリパス', 9, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(104, 7, 'ref_url', 2, 'varchar', 'varchar(2083)', 2083, 0, 0, NULL, '', '参照URL', 10, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(105, 7, 'nendo', 24, 'int', 'int(11)', 11, 0, 0, NULL, '', 'nendo', 11, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(106, 7, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, NULL, '', 'sort_no', 12, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(107, 7, 'no_a', 24, 'int', 'int(11)', 11, 0, 0, NULL, '', '番号A', 13, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(108, 7, 'no_b', 24, 'int', 'int(11)', 11, 0, 0, NULL, '', 'no_b', 14, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(109, 7, 'parent_id', 6, 'int', 'int(11)', 11, 0, 0, '', '', '親ID', 15, 0, 'kani', '::1', '2018-06-16 19:51:16', '2018-06-16 10:52:31'),
(110, 7, 'probe_id', 6, 'int', 'int(11)', 11, 0, 0, '', '', 'サンプルID', 16, 0, 'kani', '::1', '2018-06-16 19:51:16', '2018-06-16 10:52:44'),
(111, 7, 'publish', 5, 'tinyint', 'tinyint(1)', 1, 0, 0, NULL, '', '公開フラグ', 17, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(112, 7, 'create_date', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', 'create_date', 18, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(113, 7, 'update_date', 14, 'datetime', 'datetime', 0, 0, 0, NULL, '', 'update_date', 19, 0, NULL, NULL, '2018-06-16 19:51:16', '2018-06-16 10:51:16'),
(114, 8, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'ID', 1, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(115, 8, 'category', 2, 'varchar', 'varchar(16)', 16, 0, 0, NULL, '', 'カテゴリ', 2, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(116, 8, 'diary_date', 25, 'date', 'date', 0, 1, 0, NULL, '', '日誌日付', 3, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(117, 8, 'diary_dt', 14, 'datetime', 'datetime', 0, 1, 0, NULL, '', '日誌日時', 4, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(118, 8, 'diary_note', 3, 'text', 'text', 0, 1, 0, NULL, '', '日誌', 5, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(119, 8, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 6, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(120, 8, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 7, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(121, 8, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 8, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(122, 8, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 9, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(123, 8, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 10, 0, NULL, NULL, '2018-07-14 07:42:22', '2018-07-13 22:42:22'),
(124, 9, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(125, 9, 'bio_cls_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '綱名', 2, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(126, 9, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 3, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(127, 9, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 4, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(128, 9, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 5, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(129, 9, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 6, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(130, 9, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 7, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(131, 9, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 8, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(132, 9, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 9, 0, NULL, NULL, '2018-09-01 22:55:07', '2018-09-01 13:55:07'),
(133, 10, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(134, 10, 'en_ctg_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '絶滅危惧種カテゴリー名', 2, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(135, 10, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 3, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(136, 10, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 4, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(137, 10, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 5, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(138, 10, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 6, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(139, 10, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 7, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(140, 10, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 8, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(141, 10, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 9, 0, NULL, NULL, '2018-09-01 23:50:11', '2018-09-01 14:50:11'),
(142, 11, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(143, 11, 'bio_cls_id', 27, 'int', 'int(11)', 11, 0, 0, NULL, '', '綱ID', 2, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(144, 11, 'family_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '科', 3, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(145, 11, 'wamei', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '和名', 4, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(146, 11, 'scien_name', 2, 'varchar', 'varchar(225)', 225, 0, 0, NULL, '', '学名', 5, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(147, 11, 'en_ctg_id', 27, 'int', 'int(11)', 11, 0, 0, '0', '', '絶滅危惧種カテゴリーID', 6, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(148, 11, 'endemic_sp_flg', 11, 'tinyint', 'tinyint(4)', 4, 0, 0, '0', '', '固有種フラグ', 7, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(149, 11, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 8, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(150, 11, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 9, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(151, 11, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 10, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(152, 11, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 11, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(153, 11, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 12, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(154, 11, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 13, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(155, 11, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 14, 0, NULL, NULL, '2018-09-02 15:16:01', '2018-09-02 06:16:01'),
(156, 12, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(157, 12, 'animal_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '動物名', 2, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(158, 12, 'anim_ctg_id', 27, 'int', 'int(11)', 11, 0, 0, NULL, '', '動物カテゴリ', 3, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(159, 12, 'place', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '場所', 4, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(160, 12, 'img_fn', 28, 'varchar', 'varchar(256)', 256, 0, 0, NULL, '', '動物画像', 5, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(161, 12, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 6, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(162, 12, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 7, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(163, 12, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 8, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(164, 12, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 9, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(165, 12, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 10, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(166, 12, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 11, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(167, 12, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 12, 0, NULL, NULL, '2018-09-11 11:31:02', '2018-09-11 02:31:02'),
(168, 13, 'id', 22, 'int', 'int(11)', 11, 1, 1, NULL, 'auto_increment', 'id', 1, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(169, 13, 'anim_ctg_name', 2, 'varchar', 'varchar(255)', 255, 0, 0, NULL, '', '動物カテゴリ名', 2, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(170, 13, 'note', 3, 'text', 'text', 0, 1, 0, NULL, '', '備考', 3, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(171, 13, 'sort_no', 17, 'int', 'int(11)', 11, 0, 0, '0', '', '順番', 4, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(172, 13, 'delete_flg', 12, 'tinyint', 'tinyint(1)', 1, 0, 0, '0', '', '無効フラグ', 5, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(173, 13, 'update_user', 18, 'varchar', 'varchar(50)', 50, 0, 0, NULL, '', '更新者', 6, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(174, 13, 'ip_addr', 19, 'varchar', 'varchar(40)', 40, 0, 0, NULL, '', 'IPアドレス', 7, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(175, 13, 'created', 20, 'datetime', 'datetime', 0, 0, 0, NULL, '', '生成日時', 8, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34'),
(176, 13, 'modified', 21, 'timestamp', 'timestamp', 0, 0, 0, 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', '更新日', 9, 0, NULL, NULL, '2018-09-10 15:18:34', '2018-09-10 06:18:34');

-- --------------------------------------------------------

--
-- テーブルの構造 `hinagatas`
--

CREATE TABLE `hinagatas` (
  `id` int(11) NOT NULL,
  `hina_code` varchar(64) NOT NULL COMMENT '雛型コード',
  `type_a` int(11) DEFAULT NULL COMMENT 'タイプA',
  `hinagata` text NOT NULL COMMENT '雛型',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `hinagatas`
--

INSERT INTO `hinagatas` (`id`, `hina_code`, `type_a`, `hinagata`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, '1000', 1, '			array(\'name\'=>\'kj_%field_s\',\'def\'=>null),', 2, 0, 'kani', '::1', '2018-04-02 22:25:17', '2018-04-20 10:52:25'),
(2, '1000', 12, '			array(\'name\'=>\'kj_%field_s\',\'def\'=>0),', 1, 0, 'kani', '::1', '2018-04-16 08:37:31', '2018-04-20 10:51:20'),
(3, '1001', 5, '				\'kj_%field_s\' => array(\n						\'custom\'=>array(\n								\'rule\' => array( \'custom\', \'/^[-]?[0-9] ?$/\' ),\n								\'message\' => \'%commentは整数を入力してください。\',\n								\'allowEmpty\' => true\n						),\n				),', 7, 0, 'kani', '::1', '2018-04-17 07:44:05', '2018-04-21 03:15:41'),
(4, '1001', 6, '				\'kj_%field_s\' => array(\n						\'naturalNumber\'=>array(\n								\'rule\' => array(\'naturalNumber\', true),\n								\'message\' => \'%commentは数値を入力してください\',\n								\'allowEmpty\' => true\n						),\n				),', 6, 0, 'kani', '::1', '2018-04-17 10:05:42', '2018-04-21 03:14:39'),
(5, '1001', 2, '				\'kj_%field_s\'=> array(\n						\'maxLength\'=>array(\n								\'rule\' => array(\'maxLength\', 255),\n								\'message\' => \'%commentは%type_long文字以内で入力してください\',\n								\'allowEmpty\' => true\n						),\n				),', 5, 0, 'kani', '::1', '2018-04-20 11:23:06', '2018-04-21 03:11:31'),
(6, '1001', 14, '				\'kj_%field_s\'=> array(\n						\'maxLength\'=>array(\n								\'rule\' => array(\'maxLength\', 20),\n								\'message\' => \'%commentは20文字以内で入力してください\',\n								\'allowEmpty\' => true\n						),\n				),', 8, 0, 'kani', '::1', '2018-04-20 22:39:52', '2018-04-21 03:16:19'),
(7, '1002', 1, '			\'%field_s\'=>array(\n					\'name\'=>\'%comment\',\n					\'row_order\'=>\'%model_c.%field_s\',\n					\'clm_show\'=>1,\n			),', 11, 0, 'kani', '::1', '2018-04-20 22:44:28', '2018-04-21 03:17:01'),
(8, '1002', 22, '			\'id\'=>array(\n					\'name\'=>\'ID\',//HTMLテーブルの列名\n					\'row_order\'=>\'%model_c.id\',//SQLでの並び替えコード\n					\'clm_show\'=>1,//デフォルト列表示 0:非表示 1:表示\n			),', 12, 0, 'kani', '::1', '2018-04-20 22:44:42', '2018-04-21 03:17:49'),
(9, '1000', 24, '			array(\'name\'=>\'kj_%field_s1\',\'def\'=>null),\n			array(\'name\'=>\'kj_%field_s2\',\'def\'=>null),', 3, 0, 'kani', '::1', '2018-04-20 23:18:54', '2018-04-20 21:54:00'),
(10, '1000', 25, '			array(\'name\'=>\'kj_%field_s1\',\'def\'=>null),\n			array(\'name\'=>\'kj_%field_s2\',\'def\'=>null),', 4, 0, 'kani', '::1', '2018-04-21 13:26:56', '2018-04-21 04:26:56'),
(11, '1001', 24, '				\'kj_%field_s1\' => array(\n						\'custom\'=>array(\n								\'rule\' => array( \'custom\', \'/^[-]?[0-9] ?$/\' ),\n								\'message\' => \'%commentは整数を入力してください。\',\n								\'allowEmpty\' => true\n						),\n				),\n				\'kj_%field_s2\' => array(\n						\'custom\'=>array(\n								\'rule\' => array( \'custom\', \'/^[-]?[0-9] ?$/\' ),\n								\'message\' => \'%commentは整数を入力してください。\',\n								\'allowEmpty\' => true\n						),\n				),', 9, 0, 'kani', '::1', '2018-04-21 13:31:57', '2018-04-28 03:27:17'),
(12, '1001', 25, '				\'kj_%field_s1\'=> array(\n						\'rule\' => array( \'date\', \'ymd\'),\n						\'message\' => \'%comment【範囲1】は日付形式【yyyy-mm-dd】で入力してください。\',\n						\'allowEmpty\' => true\n				),\n				\'kj_%field_s2\'=> array(\n						\'rule\' => array( \'date\', \'ymd\'),\n						\'message\' => \'%comment【範囲2】は日付形式【yyyy-mm-dd】で入力してください。\',\n						\'allowEmpty\' => true\n				),', 10, 0, 'kani', '::1', '2018-04-21 13:34:14', '2018-04-21 04:34:14'),
(13, '1003', 1, '		if(!empty($kjs[\'kj_%field_s\'])){\n			$cnds[]=\"%model_c.%field_s = {$kjs[\'kj_%field_s\']}\";\n		}', 13, 0, 'kani', '::1', '2018-04-21 13:38:27', '2018-04-21 04:38:27'),
(14, '1003', 2, '		if(!empty($kjs[\'kj_%field_s\'])){\n			$cnds[]=\"%model_c.%field_s LIKE \'%{$kjs[\'kj_%field_s\']}%\'\";\n		}', 14, 0, 'kani', '::1', '2018-04-21 13:41:39', '2018-04-21 04:41:39'),
(15, '1003', 24, '		if(!empty($kjs[\'kj_%field_s1\'])){\n			$cnds[]=\"%model_c.%field_s >= {$kjs[\'kj_%field_s1\']}\";\n		}\n		if(!empty($kjs[\'kj_%field_s2\'])){\n			$cnds[]=\"%model_c.%field_s <= {$kjs[\'kj_%field_s2\']}\";\n		}', 15, 0, 'kani', '::1', '2018-04-21 22:44:28', '2018-04-21 13:44:28'),
(16, '1003', 25, '		if(!empty($kjs[\'kj_%field_s1\'])){\n			$cnds[]=\"%model_c.%field_s >= \'{$kjs[\'kj_%field_s1\']}\'\";\n		}\n		if(!empty($kjs[\'kj_%field_s2\'])){\n			$cnds[]=\"%model_c.%field_s <= \'{$kjs[\'kj_%field_s2\']}\'\";\n		}', 16, 0, 'kani', '::1', '2018-04-21 22:45:43', '2018-04-21 13:45:43'),
(17, '1003', 14, '		if(!empty($kjs[\'kj_%field_s\'])){\n			$kj_%field_s = $kjs[\'kj_%field_s\'];\n			$dtInfo = $this->CrudBase->guessDatetimeInfo($kj_%field_s);\n			$cnds[]=\"DATE_FORMAT(%model_c.%field_s,\'{$dtInfo[\'format_mysql_a\']}\') = DATE_FORMAT(\'{$dtInfo[\'datetime_b\']}\',\'{$dtInfo[\'format_mysql_a\']}\')\";\n		}', 17, 0, 'kani', '::1', '2018-04-21 22:48:20', '2018-04-21 13:48:20'),
(18, '1003', 5, '		if(!empty($kjs[\'kj_%field_s\']) || $kjs[\'kj_%field_s\'] ===\'0\' || $kjs[\'kj_%field_s\'] ===0){\n			$cnds[]=\"%model_c.%field_s = {$kjs[\'kj_%field_s\']}\";\n		}', 18, 0, 'kani', '::1', '2018-04-21 22:49:53', '2018-04-21 13:49:53'),
(19, '1003', 12, '		$kj_delete_flg = $kjs[\'kj_delete_flg\'];\n		if(!empty($kjs[\'kj_delete_flg\']) || $kjs[\'kj_delete_flg\'] ===\'0\' || $kjs[\'kj_delete_flg\'] ===0){\n			if($kjs[\'kj_delete_flg\'] != -1){\n			   $cnds[]=\"%model_c.delete_flg = {$kjs[\'kj_delete_flg\']}\";\n			}\n		}', 19, 0, 'kani', '::1', '2018-04-21 22:50:33', '2018-04-21 14:27:03'),
(20, '1003', 26, '		if(!empty($kjs[\'kj_%field_s\'])){\n			$kj_%field_s=$kjs[\'kj_%field_s\'].\' 00:00:00\';\n			$cnds[]=\"%model_c.%field_s >= \'{$kj_%field_s}\'\";\n		}', 20, 0, 'kani', '::1', '2018-04-21 22:53:51', '2018-04-21 13:53:51'),
(21, '1004', 1, '		$this->CrudBase->inputKjText($kjs,\'kj_%field_s\',\'%comment\');', 21, 0, 'kani', '::1', '2018-04-21 23:36:52', '2018-04-21 14:36:52'),
(22, '1004', 24, '		$this->CrudBase->inputKjNouislider($kjs,\'%field_s\',\'%comment\');', 22, 0, 'kani', '::1', '2018-04-21 23:42:45', '2018-04-21 14:42:45'),
(23, '1004', 25, '		$this->CrudBase->inputKjMoDateRng($kjs,\'kj_%field_s\',\'%comment\');', 23, 0, 'kani', '::1', '2018-04-21 23:44:33', '2018-04-21 14:44:33'),
(24, '1004', 27, '		$this->CrudBase->inputKjSelect($kjs,\'kj_%field_s\',\'%comment\',$%field_lccList); ', 24, 0, 'kani', '::1', '2018-04-22 08:30:27', '2018-09-02 21:56:18'),
(25, '1004', 22, '		$this->CrudBase->inputKjId($kjs);', 25, 0, 'kani', '::1', '2018-04-22 08:32:26', '2018-04-21 23:32:26'),
(26, '1004', 17, '		$this->CrudBase->inputKjHidden($kjs,\'kj_sort_no\');', 26, 0, 'kani', '::1', '2018-04-22 08:33:01', '2018-04-21 23:33:01'),
(27, '1004', 12, '		$this->CrudBase->inputKjDeleteFlg($kjs);', 27, 0, 'kani', '::1', '2018-04-22 08:33:29', '2018-04-21 23:33:30'),
(28, '1004', 20, '		$this->CrudBase->inputKjCreated($kjs);', 28, 0, 'kani', '::1', '2018-04-22 08:35:40', '2018-04-21 23:35:40'),
(29, '1004', 21, '		$this->CrudBase->inputKjModified($kjs);', 29, 0, 'kani', '::1', '2018-04-22 08:36:00', '2018-04-21 23:36:00'),
(30, '1005', 1, '	$this->CrudBase->tdPlain($ent,\'%field_s\');', 30, 0, 'kani', '::1', '2018-04-22 12:44:54', '2018-04-22 03:44:54'),
(31, '1005', 22, '	$this->CrudBase->tdId($ent,\'id\',array(\'checkbox_name\'=>\'pwms\'));', 31, 0, 'kani', '::1', '2018-04-22 12:45:49', '2018-04-22 03:45:49'),
(32, '1005', 9, '	$this->CrudBase->tdMoney($ent,\'%field_s\');', 32, 0, 'kani', '::1', '2018-04-22 12:46:41', '2018-04-22 03:46:41'),
(33, '1005', 2, '	$this->CrudBase->tdStr($ent,\'%field_s\');', 33, 0, 'kani', '::1', '2018-04-22 12:48:38', '2018-04-22 03:48:38'),
(34, '1005', 27, '	$this->CrudBase->tdList($ent,\'%field_s\',$%field_lccList);', 34, 0, 'kani', '::1', '2018-04-22 12:49:32', '2018-04-22 03:52:26'),
(35, '1005', 3, '	$this->CrudBase->tdNote($ent,\'%field_s\');', 35, 0, 'kani', '::1', '2018-04-22 12:50:26', '2018-04-22 03:50:26'),
(36, '1005', 12, '	$this->CrudBase->tdDeleteFlg($ent,\'delete_flg\');', 36, 0, 'kani', '::1', '2018-04-22 12:51:02', '2018-04-22 03:51:02'),
(37, '1006', 1, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  maxlength=\"%type_long\" title=\"%type_long文字以内で入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 37, 0, 'kani', '::1', '2018-04-22 14:02:09', '2018-04-22 05:02:09'),
(38, '1006', 6, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[0-9] $\" maxlength=\"11\" title=\"数値（自然数）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 38, 0, 'kani', '::1', '2018-04-22 14:21:15', '2018-04-22 05:21:15'),
(39, '1007', 15, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"([0-9]{4})(/|-)([0-9]{1,2})(/|-)([0-9]{1,2})\" title=\"日付形式（Y-m-d）で入力してください(例：2012-12-12)\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 39, 1, 'kani', '::1', '2018-04-22 14:24:06', '2018-04-28 22:12:47'),
(40, '1006', 27, '		<tr><td>%comment: </td><td>\n			<?php $this->CrudBase->selectX(\'%field_s\',null,$%field_lccList,null);?>\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 40, 0, 'kani', '::1', '2018-04-22 16:38:09', '2018-04-22 07:38:09'),
(41, '1006', 14, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"([0-9]{4})(/|-)([0-9]{1,2})(/|-)([0-9]{1,2}) [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}\" title=\"日時形式（Y-m-d H:i:s）で入力してください(例：2012-12-12 12:12:12)\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 41, 0, 'kani', '::1', '2018-04-22 16:40:33', '2018-05-16 03:18:52'),
(42, '1006', 3, '		<tr><td>%comment： </td><td>\n			<textarea name=\"%field_s\" ></textarea>\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 43, 0, 'kani', '::1', '2018-04-22 16:51:35', '2018-05-11 17:44:25'),
(43, '1006', 22, '', 44, 0, 'kani', '::1', '2018-04-22 16:54:24', '2018-04-22 07:54:24'),
(44, '1006', 5, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[ -]?[0-9] $\" maxlength=\"11\" title=\"数値（整数数）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 45, 0, 'kani', '::1', '2018-04-23 15:55:07', '2018-04-23 06:55:07'),
(45, '1006', 10, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[ -]?([0-9]*[.])?[0-9] $\" maxlength=\"11\" title=\"数値（浮動小数点）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 46, 0, 'kani', '::1', '2018-04-23 15:55:56', '2018-04-23 06:55:56'),
(46, '1006', 12, '', 47, 0, 'kani', '::1', '2018-04-23 15:57:25', '2018-04-23 07:09:48'),
(47, '1006', 17, '', 48, 0, 'kani', '::1', '2018-04-23 15:58:47', '2018-04-23 06:58:47'),
(48, '1006', 18, '', 49, 0, 'kani', '::1', '2018-04-23 15:58:53', '2018-04-23 06:58:53'),
(49, '1006', 19, '', 50, 0, 'kani', '::1', '2018-04-23 15:59:00', '2018-04-23 06:59:00'),
(50, '1006', 26, '', 51, 0, 'kani', '::1', '2018-04-23 15:59:10', '2018-04-23 06:59:10'),
(51, '1007', 22, '		<tr><td>ID: <span class=\"id\"></span></td><td></td></tr>', 52, 0, 'kani', '::1', '2018-04-23 16:06:09', '2018-04-25 21:44:03'),
(52, '1007', 12, '		<tr><td>削除： </td><td>\n			<input type=\"checkbox\" name=\"delete_flg\" class=\"valid\"  />\n		</td></tr>', 53, 0, 'kani', '::1', '2018-04-23 16:09:40', '2018-04-23 07:09:40'),
(53, '1007', 1, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  maxlength=\"%type_long\" title=\"%type_long文字以内で入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 54, 0, 'kani', '::1', '2018-04-23 16:10:14', '2018-04-23 07:10:14'),
(54, '1007', 6, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[0-9] $\" maxlength=\"11\" title=\"数値（自然数）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 55, 0, 'kani', '::1', '2018-04-23 16:10:19', '2018-04-23 07:10:19'),
(55, '1007', 27, '		<tr><td>%comment: </td><td>\n			<?php $this->CrudBase->selectX(\'%field_s\',null,$%field_lccList,null);?>\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>\n', 56, 0, 'kani', '::1', '2018-04-23 16:10:34', '2018-04-23 07:10:35'),
(56, '1007', 14, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"([0-9]{4})(/|-)([0-9]{1,2})(/|-)([0-9]{1,2}) [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}\" title=\"日時形式（Y-m-d H:i:s）で入力してください(例：2012-12-12 12:12:12)\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 57, 0, 'kani', '::1', '2018-04-23 16:10:41', '2018-05-16 03:19:22'),
(57, '1007', 3, '		<tr><td>%comment： </td><td>\n			<textarea name=\"%field_s\"></textarea>\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 58, 0, 'kani', '::1', '2018-04-23 16:10:47', '2018-05-11 17:45:01'),
(58, '1007', 22, '		<tr><td>ID: </td><td>\n			<span class=\"id\"></span>\n		</td></tr>', 59, 0, 'kani', '::1', '2018-04-23 16:11:13', '2018-04-23 07:11:13'),
(59, '1007', 5, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[ -]?[0-9] $\" maxlength=\"11\" title=\"数値（整数数）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 60, 0, 'kani', '::1', '2018-04-23 16:11:22', '2018-04-23 07:11:22'),
(60, '1007', 10, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[ -]?([0-9]*[.])?[0-9] $\" maxlength=\"11\" title=\"数値（浮動小数点）を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 61, 0, 'kani', '::1', '2018-04-23 16:11:29', '2018-04-23 07:11:29'),
(61, '1007', 12, '		<tr><td>削除：<input type=\"checkbox\" name=\"delete_flg\" class=\"valid\"  /> </td><td></td></tr>', 62, 0, 'kani', '::1', '2018-04-23 16:11:53', '2018-04-25 21:44:39'),
(62, '1007', 17, '', 63, 0, 'kani', '::1', '2018-04-23 16:11:59', '2018-04-23 07:12:04'),
(63, '1007', 18, '', 64, 0, 'kani', '::1', '2018-04-23 16:12:24', '2018-04-23 07:12:24'),
(64, '1007', 19, '', 65, 0, 'kani', '::1', '2018-04-23 16:12:36', '2018-04-23 07:12:36'),
(65, '1007', 26, '', 66, 0, 'kani', '::1', '2018-04-23 16:12:42', '2018-04-23 07:12:42'),
(66, '1020', 1, '', 67, 0, 'kani', '::1', '2018-04-23 16:22:25', '2018-04-23 07:22:25'),
(67, '1020', 27, '\n		// %commentリスト\n		$%field_lccList = $this->%model_c->get%field_cList();\n		$%field_s_json = json_encode($%field_lccList,JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);\n		$this->set(array(\'%field_lccList\' => $%field_lccList,\'%field_s_json\' => $%field_s_json));', 68, 0, 'kani', '::1', '2018-04-23 16:22:38', '2018-09-02 06:22:00'),
(68, '1021', 1, '', 69, 0, 'kani', '::1', '2018-04-23 16:41:02', '2018-04-23 07:41:30'),
(69, '1021', 27, '	/**\n	 * %commentリストをDBから取得する\n	 */\n	public function get%field_cList(){\n		if(empty($this->%field_out_model_c)){\n			App::uses(\'%field_out_model_c\',\'Model\');\n			$this->%field_out_model_c=ClassRegistry::init(\'%field_out_model_c\');\n		}\n		$fields=array(\'id\',\'%field_out_model_s_name\');//SELECT情報\n		$conditions=array(\"delete_flg = 0\");//WHERE情報\n		$order=array(\'sort_no\');//ORDER情報\n		$option=array(\n				\'fields\'=>$fields,\n				\'conditions\'=>$conditions,\n				\'order\'=>$order,\n		);\n\n		$data=$this->%field_out_model_c->find(\'all\',$option); // DBから取得\n		\n		// 構造変換\n		if(!empty($data)){\n			$data = Hash::combine($data, \'{n}.%field_out_model_c.id\',\'{n}.%field_out_model_c.%field_out_model_s_name\');\n		}\n		\n		return $data;\n	}', 70, 0, 'kani', '::1', '2018-04-23 16:41:22', '2018-09-02 13:46:45'),
(70, '1022', 1, '', 71, 0, 'kani', '::1', '2018-04-23 16:55:06', '2018-04-23 07:55:06'),
(71, '1022', 27, '	<input id=\"%field_s_json\" type=\"hidden\" value=\'<?php echo $%field_s_json; ?>\' />', 72, 0, 'kani', '::1', '2018-04-23 16:55:18', '2018-04-23 07:55:18'),
(72, '1023', 1, '', 73, 0, 'kani', '::1', '2018-04-23 17:11:58', '2018-04-23 08:11:58'),
(73, '1023', 27, '	// %commentリストJSON\n	var %field_s_json = jQuery(\'#%field_s_json\').val();\n	var %field_lccList = JSON.parse(%field_s_json);\n	disFilData[\'%field_s\'] ={\'fil_type\':\'select\',\'option\':{\'list\':%field_lccList}};', 74, 0, 'kani', '::1', '2018-04-23 17:12:13', '2018-04-23 22:05:09'),
(74, '1030', 1, '', 75, 0, 'kani', '::1', '2018-04-24 09:55:06', '2018-04-24 00:55:06'),
(75, '1030', 15, '	$(\"#new_inp_%field_s\").datepicker({dateFormat:\'yy-mm-dd\'});\n	$(\"#edit_%field_s\").datepicker({dateFormat:\'yy-mm-dd\'});', 76, 0, 'kani', '::1', '2018-04-24 09:55:58', '2018-04-24 00:55:58'),
(76, '1006', 15, '		<tr><td>%comment: </td><td>\n			<input id=\"new_inp_%field_s\" type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"([0-9]{4})(/|-)([0-9]{1,2})(/|-)([0-9]{1,2})\" title=\"日付形式（Y-m-d）で入力してください(例：2012-12-12)\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 42, 0, 'kani', '::1', '2018-04-24 09:58:09', '2018-04-24 00:58:09'),
(77, '1007', 15, '		<tr><td>%comment: </td><td>\n			<input id=\"edit_%field_s\" type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"([0-9]{4})(\\/|-)([0-9]{1,2})(\\/|-)([0-9]{1,2})\" title=\"日付形式（Y-m-d）で入力してください(例：2012-12-12)\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 57, 0, 'kani', '::1', '2018-04-24 14:26:53', '2018-04-28 22:12:38'),
(78, '1007', 4, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[+-]?([0-9]*[.])?[0-9]+$\" maxlength=\"11\" title=\"数値を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 44, 0, 'kani', '::1', '2018-04-28 15:59:12', '2018-04-28 13:00:35'),
(79, '1006', 4, '		<tr><td>%comment: </td><td>\n			<input type=\"text\" name=\"%field_s\" class=\"valid\" value=\"\"  pattern=\"^[+-]?([0-9]*[.])?[0-9]+$\" maxlength=\"11\" title=\"数値を入力してください\" />\n			<label class=\"text-danger\" for=\"%field_s\"></label>\n		</td></tr>', 44, 0, 'kani', '::1', '2018-04-28 21:59:33', '2018-04-28 13:01:32'),
(80, '1040', 22, '	public $useTable = \'%table_s\';', 77, 0, 'kani', '::1', '2018-04-29 06:44:17', '2018-04-28 21:54:13'),
(81, '1005', 28, '	$this->CrudBase->tdImage($ent,\'%field_s\');', 33, 0, 'kani', '::1', '2018-09-11 11:16:46', '2018-09-11 02:22:09'),
(82, '1006', 28, '		<tr><td>%comment: </td><td>\n			<label for=\"%field_s_n\" class=\"fuk_label\" style=\"width:200px;height:240px;\">\n				<input type=\"file\" id=\"%field_s_n\" class=\"%field_s\" style=\"display:none\" accept=\"image/*\" title=\"画像ファイルをドラッグ＆ドロップ\" />\n			</label>\n		</td></tr>', 37, 0, 'kani', '::1', '2018-09-11 11:21:33', '2018-09-11 02:25:49'),
(83, '1007', 28, '		<tr><td>%comment: </td><td>\n			<label for=\"%field_s_e\" class=\"fuk_label\" style=\"width:200px;height:240px;\">\n				<input type=\"file\" id=\"%field_s_e\" class=\"%field_s\" style=\"display:none\" accept=\"image/*\" title=\"画像ファイルをドラッグ＆ドロップ\" />\n			</label>\n		</td></tr>', 54, 0, 'kani', '::1', '2018-09-11 11:24:50', '2018-09-11 02:25:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `hina_files`
--

CREATE TABLE `hina_files` (
  `id` int(11) NOT NULL,
  `hina_file_name` varchar(255) DEFAULT NULL COMMENT '雛ファイル名',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `hina_files`
--

INSERT INTO `hina_files` (`id`, `hina_file_name`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, 'テスト1', NULL, 0, 'kani', '::1', '2018-04-10 14:36:24', '2018-04-10 05:36:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `hina_file_lists`
--

CREATE TABLE `hina_file_lists` (
  `id` int(11) NOT NULL,
  `hina_file_id` int(11) NOT NULL COMMENT '雛ファイルID',
  `hina_fp` varchar(1024) NOT NULL COMMENT '雛ファイルパス',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `hina_file_lists`
--

INSERT INTO `hina_file_lists` (`id`, `hina_file_id`, `hina_fp`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, 1, 'Controller\\XxxController.php', NULL, 0, 'kani', '::1', '2018-04-10 16:12:25', '2018-04-10 21:20:16'),
(2, 1, 'Model\\Xxx.php', NULL, 0, 'kani', '::1', '2018-04-10 16:19:03', '2018-04-10 21:20:44'),
(3, 1, 'View\\Xxx\\index.ctp', NULL, 0, 'kani', '::1', '2018-04-11 06:21:27', '2018-04-10 21:21:27'),
(4, 1, 'webroot\\js\\Xxx\\index.js', NULL, 0, 'kani', '::1', '2018-04-11 06:22:29', '2018-04-10 21:22:29'),
(5, 1, 'webroot\\css\\Xxx\\index.css', NULL, 0, 'kani', '::1', '2018-04-11 06:22:54', '2018-04-10 21:47:22');

-- --------------------------------------------------------

--
-- テーブルの構造 `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `mission_name` varchar(255) NOT NULL COMMENT '任務名',
  `hina_file_id` int(11) NOT NULL COMMENT '雛ファイルID',
  `from_path` varchar(1024) NOT NULL COMMENT '複製元パス',
  `from_scr_code` varchar(64) NOT NULL COMMENT '複製元画面コード',
  `from_db_name` varchar(64) NOT NULL COMMENT '複製元DB名',
  `from_tbl_name` varchar(64) NOT NULL COMMENT '複製元テーブル名',
  `from_wamei` varchar(256) NOT NULL COMMENT '複製元和名',
  `to_path` varchar(1024) NOT NULL COMMENT '複製先パス',
  `to_scr_code` varchar(64) NOT NULL COMMENT '複製先画面コード',
  `to_db_name` varchar(64) NOT NULL COMMENT '複製先DB名',
  `to_tbl_name` varchar(64) NOT NULL COMMENT '複製先テーブル名',
  `to_wamei` varchar(256) NOT NULL COMMENT '複製先和名',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `missions`
--

INSERT INTO `missions` (`id`, `mission_name`, `hina_file_id`, `from_path`, `from_scr_code`, `from_db_name`, `from_tbl_name`, `from_wamei`, `to_path`, `to_scr_code`, `to_db_name`, `to_tbl_name`, `to_wamei`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, 'TEST', 0, 'd', 'abc', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 'cake_demo', 'asfasdfa', NULL, 1, 'kani', '::1', '2018-04-01 23:06:48', '2018-04-05 14:19:52'),
(2, 'TEST１', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\animal_park\\app', 'Yagi', 'animal_park', 'yagis', 'ヤギ', 1, 0, 'kani', '::1', '2018-04-05 23:19:41', '2018-04-16 00:43:21'),
(3, '動物・ユーザー管理', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\animal_park\\app', 'UserMng', 'animal_park', 'users', 'ユーザー管理', 8, 0, 'kani', '::1', '2018-04-28 22:47:51', '2018-04-28 13:51:49'),
(4, 'TEST2 テーブルと画面コードが異なる', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\animal_park\\app', 'HijarX', 'animal_park', 'yagis', 'ヒージャー', 9, 0, 'kani', '::1', '2018-04-28 23:09:35', '2018-04-28 14:09:35'),
(5, '心得システム・心得カテゴリー', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\Users\\user\\git\\knowledge\\app', 'KlCategory', 'zss_rec', 'kl_categorys', '心得カテゴリー', 11, 0, 'kani', '::1', '2018-05-08 19:06:03', '2018-05-08 10:08:38'),
(6, '心得システム・心得メイン', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\Users\\user\\git\\knowledge\\app', 'Knowledge', 'zss_rec', 'knowledges', '心得メイン', 10, 0, 'kani', '::1', '2018-05-08 19:16:30', '2018-05-08 10:16:30'),
(7, 'RecX', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\zss_rec\\app', 'RecX', 'zss_rec', 'recs', '農業記録X', 7, 0, 'kani', '::1', '2018-06-16 19:51:07', '2018-06-16 10:51:07'),
(8, 'RecX', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\zss_rec\\app', 'DiaryA', 'zss_rec', 'diary_as', '日誌Ａ', 6, 0, 'kani', '::1', '2018-07-14 07:41:56', '2018-07-13 22:41:56'),
(9, 'cb_red_book/BioCls', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\cb_red_book\\app', 'BioCls', 'cb_red_book', 'bio_clss', '綱', 3, 0, 'kani', '::1', '2018-09-01 22:54:54', '2018-09-01 14:48:05'),
(10, 'cb_red_book/EnCtg', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\cb_red_book\\app', 'EnCtg', 'cb_red_book', 'en_ctgs', '絶滅危惧種カテゴリー', 4, 0, 'kani', '::1', '2018-09-01 23:49:49', '2018-09-01 14:49:49'),
(11, 'cb_red_book/EnSp', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\cb_red_book\\app', 'EnSp', 'cb_red_book', 'en_sps', '絶滅危惧生物', 5, 0, 'kani', '::1', '2018-09-02 07:44:07', '2018-09-01 22:44:07'),
(12, '沖縄の動物', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\okianim\\app', 'OkiAnimal', 'okianim', 'oki_animals', '沖縄動物', 2, 0, 'kani', '::1', '2018-09-10 15:14:34', '2018-09-10 06:15:21'),
(13, '沖縄の動物', 1, 'C:\\Users\\user\\git\\cake_demo\\app', 'Neko', 'cake_demo', 'nekos', 'ネコ', 'C:\\xampp\\htdocs\\okianim\\app', 'AnimCtg', 'okianim', 'anim_ctgs', '動物カテゴリ', 2, 0, 'kani', '::1', '2018-09-10 15:18:21', '2018-09-10 06:18:21');

-- --------------------------------------------------------

--
-- テーブルの構造 `type_as`
--

CREATE TABLE `type_as` (
  `id` int(11) NOT NULL,
  `type_a_name` varchar(256) NOT NULL COMMENT 'タイプ名',
  `par_id` int(11) DEFAULT '0' COMMENT '親ID',
  `cnd_eq_field_name` varchar(64) DEFAULT NULL COMMENT 'フィールド名条件【完全一致】',
  `cnd_in_field_name` varchar(64) DEFAULT NULL COMMENT 'フィールド名条件【部分一致】',
  `cnd_eq_field_type` varchar(32) DEFAULT NULL COMMENT 'フィールド型条件【完全一致】',
  `cnd_in_field_type` varchar(32) DEFAULT NULL COMMENT 'フィールド型条件【部分一致】',
  `cnd_type_long1` int(11) DEFAULT NULL COMMENT '型長さ条件1',
  `cnd_type_long2` int(11) DEFAULT NULL COMMENT '型長さ条件2',
  `cnd_null_flg` int(11) NOT NULL DEFAULT '0' COMMENT 'NULLフラグ条件',
  `cnd_p_key_flg` int(11) DEFAULT '0' COMMENT '主キーフラグ条件',
  `cnd_eq_def_val` varchar(256) DEFAULT NULL COMMENT 'デフォルト値条件【完全一致】',
  `cnd_in_def_val` varchar(256) DEFAULT NULL COMMENT 'デフォルト値条件【部分一致】',
  `cnd_eq_extra` varchar(256) DEFAULT NULL COMMENT '補足条件【完全一致】',
  `cnd_in_extra` varchar(256) DEFAULT NULL COMMENT '補足条件【部分一致】',
  `cnd_eq_comment` varchar(256) DEFAULT NULL COMMENT 'コメント条件【完全一致】',
  `cnd_in_comment` varchar(256) DEFAULT NULL COMMENT 'コメント条件【部分一致】',
  `sort_no` int(11) DEFAULT '0' COMMENT '順番',
  `delete_flg` tinyint(1) DEFAULT '0' COMMENT '無効フラグ',
  `update_user` varchar(50) DEFAULT NULL COMMENT '更新者',
  `ip_addr` varchar(40) DEFAULT NULL COMMENT 'IPアドレス',
  `created` datetime DEFAULT NULL COMMENT '生成日時',
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `type_as`
--

INSERT INTO `type_as` (`id`, `type_a_name`, `par_id`, `cnd_eq_field_name`, `cnd_in_field_name`, `cnd_eq_field_type`, `cnd_in_field_type`, `cnd_type_long1`, `cnd_type_long2`, `cnd_null_flg`, `cnd_p_key_flg`, `cnd_eq_def_val`, `cnd_in_def_val`, `cnd_eq_extra`, `cnd_in_extra`, `cnd_eq_comment`, `cnd_in_comment`, `sort_no`, `delete_flg`, `update_user`, `ip_addr`, `created`, `modified`) VALUES
(1, '基本型', 0, '', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 1, 0, 'kani', '::1', '2018-04-03 17:47:24', '2018-04-18 13:28:24'),
(2, '文字列型', 1, '', '', '', 'varchar,text', NULL, NULL, 0, 0, '', '', '', '', '', '', 3, 0, 'kani', '::1', '2018-04-16 09:34:49', '2018-04-18 13:30:45'),
(3, 'ノート型', 2, '', '', 'text', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 4, 0, 'kani', '::1', '2018-04-16 09:36:23', '2018-04-18 13:31:32'),
(4, '数値系', 1, '', '', '', 'int,float,double,decimal', NULL, NULL, 0, 0, '', '', '', '', '', '', 5, 0, 'kani', '::1', '2018-04-18 22:32:42', '2018-04-18 13:32:42'),
(5, '整数型', 4, '', '', '', 'int', NULL, NULL, 0, 0, '', '', '', '', '', '', 6, 0, 'kani', '::1', '2018-04-18 22:33:36', '2018-04-18 13:33:36'),
(6, '自然数型', 5, '', '', 'int', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 7, 0, 'kani', '::1', '2018-04-18 22:36:01', '2018-04-18 13:36:01'),
(7, 'ID系', 6, '', '_id', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 8, 0, 'kani', '::1', '2018-04-18 22:38:47', '2018-04-18 13:38:47'),
(8, 'TEST', 0, '', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 6, 1, 'kani', '::1', '2018-04-20 10:41:43', '2018-04-20 13:08:51'),
(9, '通貨型', 4, '', '', 'decimal', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 9, 0, 'kani', '::1', '2018-04-20 10:44:03', '2018-04-20 03:24:20'),
(10, '浮動小数型', 4, '', '', 'float,double', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 10, 0, 'kani', '::1', '2018-04-20 10:44:20', '2018-04-20 03:25:30'),
(11, '空有無フラグ', 4, '', '_flg', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 12, 0, 'kani', '::1', '2018-04-20 10:44:55', '2018-04-20 03:26:40'),
(12, '削除フラグ', 11, 'delete_flg', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 13, 0, 'kani', '::1', '2018-04-20 10:45:22', '2018-04-20 03:27:32'),
(13, '有無フラグ', 4, '', '_flg', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 11, 0, 'kani', '::1', '2018-04-20 10:48:37', '2018-04-20 03:28:23'),
(14, '日時型', 1, '', '', 'datetime', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 15, 0, 'kani', '::1', '2018-04-20 10:50:51', '2018-04-20 03:33:58'),
(15, '日付型', 14, '', '', 'date', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 16, 0, 'kani', '::1', '2018-04-20 10:52:53', '2018-04-20 03:35:23'),
(16, '時刻型', 14, '', '', 'time', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 17, 0, 'kani', '::1', '2018-04-20 10:54:59', '2018-04-20 03:33:02'),
(17, '順番型', 5, 'sort_no', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 18, 0, 'kani', '::1', '2018-04-20 11:06:53', '2018-04-20 03:35:15'),
(18, '更新ユーザー', 2, 'update_user', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 19, 0, 'kani', '::1', '2018-04-20 11:08:35', '2018-04-20 03:37:55'),
(19, '更新IPアドレス', 2, 'ip_addr', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 20, 0, 'kani', '::1', '2018-04-20 11:08:43', '2018-04-20 03:38:31'),
(20, '生成日時', 26, 'created', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 22, 0, 'kani', '::1', '2018-04-20 12:39:18', '2018-04-21 14:28:10'),
(21, '更新日時', 26, 'modified', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 23, 0, 'kani', '::1', '2018-04-20 12:39:44', '2018-04-21 14:28:19'),
(22, 'id型', 6, 'id', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 25, 0, 'kani', '::1', '2018-04-20 22:05:14', '2018-04-20 13:05:15'),
(23, '共通系', 1, 'sort_no,update_user,ip_addr,delete_flg,created,modified,created', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 2, 0, 'kani', '::1', '2018-04-20 23:17:08', '2018-04-20 14:17:08'),
(24, '範囲数値', 4, '', '', 'int,float,double,decimal', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 14, 0, 'kani', '::1', '2018-04-21 06:50:51', '2018-04-20 21:50:51'),
(25, '日付範囲', 15, '', '', 'date', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 24, 0, 'kani', '::1', '2018-04-21 13:25:52', '2018-04-21 04:28:33'),
(26, '更新・生成日時', 14, 'created,modified', '', '', '', NULL, NULL, 0, 0, '', '', '', '', '', '', 21, 0, 'kani', '::1', '2018-04-21 22:52:29', '2018-04-21 13:52:29'),
(27, 'SELECT型', 5, '', '_id', '', 'int', NULL, NULL, 0, 0, '', '', '', '', '', '', 26, 0, 'kani', '::1', '2018-04-21 23:47:26', '2018-04-21 14:47:56'),
(28, '画像ファイル型', 2, '', '_fn', '', '', NULL, NULL, 0, NULL, '', '', '', '', '', '', 27, 0, 'kani', '::1', '2018-09-11 11:02:07', '2018-09-11 02:02:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `role` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`) VALUES
(1, 'yagi', 'metabo', NULL, NULL, NULL),
(2, 'buta', '6bc982d69201cebd343e66fd3ef0969e8a174ea2', 'admin', '2014-06-30 07:58:30', '2014-06-30 07:58:30'),
(3, 'kani', '26d1cc26d3e5bd63041e42c0c397fd4154fd329c', 'admin', '2014-06-30 08:24:48', '2014-06-30 08:24:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_makes`
--
ALTER TABLE `bulk_makes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hinagatas`
--
ALTER TABLE `hinagatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hina_files`
--
ALTER TABLE `hina_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hina_file_lists`
--
ALTER TABLE `hina_file_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_as`
--
ALTER TABLE `type_as`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_makes`
--
ALTER TABLE `bulk_makes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `hinagatas`
--
ALTER TABLE `hinagatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `hina_files`
--
ALTER TABLE `hina_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hina_file_lists`
--
ALTER TABLE `hina_file_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `type_as`
--
ALTER TABLE `type_as`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
