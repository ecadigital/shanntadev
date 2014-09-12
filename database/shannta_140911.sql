-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2014 at 01:07 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shannta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(10) NOT NULL,
  `admin_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_group_id` int(10) NOT NULL,
  `admin_block` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `admin_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_language` int(10) NOT NULL DEFAULT '1',
  `admin_seq` int(10) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_user`, `admin_email`, `admin_pass`, `admin_name`, `admin_group_id`, `admin_block`, `admin_image`, `admin_language`, `admin_seq`) VALUES
(1, 'root', 'jiwako@hotmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '', 1, '1', '', 2, 1),
(2, 'admin', 'jiwako@hotmail.comx', '81dc9bdb52d04dc20036dbd8313ed055', 'Admin', 2, '1', '', 1, 2),
(3, '111', '1111@ffsdf.com', '96e79218965eb72c92a549dd5a330112', 'test', 3, '1', '', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_cfg`
--

CREATE TABLE IF NOT EXISTS `admin_cfg` (
  `admin_cfg_id` int(10) NOT NULL,
  `admin_cfg_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `admin_cfg_detail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_cfg_default` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_cfg_value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_cfg_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '0:ไม่นำไปใช้, 1:นำไปใช้',
  PRIMARY KEY (`admin_cfg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_extension`
--

CREATE TABLE IF NOT EXISTS `admin_extension` (
  `extension_id` int(10) NOT NULL,
  `extension_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `extension_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `extension_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension_installtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `extension_seq` int(10) NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_group`
--

CREATE TABLE IF NOT EXISTS `admin_group` (
  `admin_group_id` int(10) NOT NULL,
  `admin_group_desc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_group_seq` int(10) NOT NULL,
  PRIMARY KEY (`admin_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_group`
--

INSERT INTO `admin_group` (`admin_group_id`, `admin_group_desc`, `admin_group_seq`) VALUES
(1, 'root', 1),
(2, 'admin', 2),
(3, 'normal', 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_language`
--

CREATE TABLE IF NOT EXISTS `admin_language` (
  `language_id` int(1) NOT NULL,
  `language_alias` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_admin` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1:default',
  `language_front` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1:default',
  `language_admin_publish` tinyint(4) NOT NULL DEFAULT '1',
  `language_seq` int(10) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_language`
--

INSERT INTO `admin_language` (`language_id`, `language_alias`, `language_name`, `language_desc`, `language_icon`, `language_admin`, `language_front`, `language_admin_publish`, `language_seq`) VALUES
(1, 'th', 'thai', 'ภาษาไทย', 'public/upload/language/thumbnails/lang_1.png', '1', '1', 1, 1),
(2, 'en', 'english', 'English', 'public/upload/language/thumbnails/lang_2.png', '0', '0', 1, 2),
(3, 'cn', 'chinese', '中国', 'public/upload/language/thumbnails/lang_3.png', '0', '0', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `menu_id` int(10) NOT NULL,
  `menu_desc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` int(10) NOT NULL,
  `menu_admin_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu_published_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes',
  `menu_parent_id` int(10) NOT NULL,
  `menu_seq` int(10) NOT NULL,
  `menu_imgpath_admin` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_menutype_admin` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `menu_admin_group` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_notify` int(11) NOT NULL DEFAULT '0',
  `menu_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`menu_id`, `menu_desc`, `module_id`, `menu_admin_link`, `menu_published_admin`, `menu_parent_id`, `menu_seq`, `menu_imgpath_admin`, `menu_menutype_admin`, `menu_admin_group`, `menu_notify`, `menu_status`) VALUES
(1, 'Dashboard', 0, 'admin/admin/index', 1, 0, 1, '', 'A', ',1,2,', 0, '0'),
(2, 'Newsletter', 0, 'newsletter/backend/index', 1, 0, 9, '', 'A', ',1,2,', 0, '0'),
(3, 'Home&Decorations', 0, 'decoration/backend/index', 1, 0, 3, '', 'A', ',1,2,', 0, '0'),
(4, 'Flora Living', 0, 'articles/backend/index', 1, 0, 4, '', 'A', ',1,2,', 0, '0'),
(5, 'Contact', 0, 'contactus/backend/contact_datail', 1, 0, 5, '', 'A', ',1,', 0, '0'),
(6, 'Slide', 0, 'slide/backend/index', 1, 0, 8, '', 'A', ',1,2,', 0, '0'),
(7, 'Promotion', 0, 'promotion/backend/index', 1, 0, 7, '', 'A', ',1,2,', 0, '0'),
(8, 'Career', 0, 'career/backend/index', 1, 0, 6, '', 'A', ',1,2,', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `admin_module`
--

CREATE TABLE IF NOT EXISTS `admin_module` (
  `module_id` int(10) NOT NULL,
  `module_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_type` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '2' COMMENT '1:system, 2: other',
  `module_buildfrom` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:path, 2: extension',
  `module_db` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_lang` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1: have lang, 0:don,t have',
  `module_seq` int(10) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_module`
--

INSERT INTO `admin_module` (`module_id`, `module_name`, `module_desc`, `module_type`, `module_buildfrom`, `module_db`, `module_lang`, `module_seq`) VALUES
(1, 'admin', 'เมนูระบบ', '1', '', '', '', 1),
(2, 'extension', 'เมนูระบบ', '1', '', '', '', 2),
(3, 'home', 'เมนูระบบ', '1', '', '', '', 3),
(4, 'menu', 'เมนูระบบ', '1', '', '', '', 4),
(5, 'module', 'เมนูระบบ', '1', '', '', '', 5),
(6, 'language', 'เมนูระบบ', '1', '', '', '', 6),
(7, 'product', '', '2', '1', '', '1', 7),
(8, 'member', '', '2', '1', '', '1', 8),
(11, 'slide', '', '2', '1', '', '1', 11),
(12, 'contactus', '', '2', '1', '', '1', 12),
(14, 'banner', '', '2', '1', '', '1', 14),
(15, 'shoppingcart', '', '2', '1', '', '1', 15),
(16, 'news', '', '2', '1', '', '1', 16),
(17, 'main', '', '2', '1', '', '1', 17),
(18, 'faq', '', '2', '1', '', '1', 18);

-- --------------------------------------------------------

--
-- Table structure for table `admin_useronline`
--

CREATE TABLE IF NOT EXISTS `admin_useronline` (
  `online_user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `online_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`online_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE IF NOT EXISTS `collection` (
  `collection_id` int(10) NOT NULL,
  `collection_categories_id` int(10) NOT NULL DEFAULT '0',
  `collection_price` double NOT NULL DEFAULT '0',
  `collection_discount` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `collection_newprice` double NOT NULL DEFAULT '0',
  `collection_date_added` datetime NOT NULL,
  `collection_last_modified` datetime NOT NULL,
  `collection_seq` int(10) NOT NULL DEFAULT '0',
  `collection_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish, 2:delete',
  `collection_pin` tinyint(1) NOT NULL DEFAULT '0',
  `collection_hot` tinyint(1) NOT NULL DEFAULT '0',
  `collection_rec` tinyint(1) NOT NULL DEFAULT '0',
  `collection_pro` tinyint(1) NOT NULL DEFAULT '0',
  `collection_sale` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`collection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`collection_id`, `collection_categories_id`, `collection_price`, `collection_discount`, `collection_newprice`, `collection_date_added`, `collection_last_modified`, `collection_seq`, `collection_publish`, `collection_pin`, `collection_hot`, `collection_rec`, `collection_pro`, `collection_sale`) VALUES
(1, 1, 0, '0', 0, '2014-09-09 23:12:14', '2014-09-09 23:20:52', 1, '1', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `collection_categories`
--

CREATE TABLE IF NOT EXISTS `collection_categories` (
  `collection_categories_id` int(10) NOT NULL AUTO_INCREMENT,
  `collection_categories_parent_id` int(10) NOT NULL,
  `collection_categories_home_position` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `collection_categories_home_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `collection_categories_banner_position` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `collection_categories_banner_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `collection_categories_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1:publish, 0: unpublish',
  `collection_categories_hot` tinyint(1) NOT NULL DEFAULT '0',
  `collection_categories_seq` int(10) NOT NULL,
  PRIMARY KEY (`collection_categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `collection_categories`
--

INSERT INTO `collection_categories` (`collection_categories_id`, `collection_categories_parent_id`, `collection_categories_home_position`, `collection_categories_home_path`, `collection_categories_banner_position`, `collection_categories_banner_path`, `collection_categories_publish`, `collection_categories_hot`, `collection_categories_seq`) VALUES
(1, 0, 'L', '', 'L', '', '1', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `collection_categories_lang`
--

CREATE TABLE IF NOT EXISTS `collection_categories_lang` (
  `collection_categories_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `collection_categories_name` varchar(200) NOT NULL,
  `collection_categories_home_keyhead` varchar(200) NOT NULL,
  `collection_categories_home_keymessage` text NOT NULL,
  `collection_categories_banner_keyhead` varchar(200) NOT NULL,
  `collection_categories_banner_keymessage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `collection_categories_lang`
--

INSERT INTO `collection_categories_lang` (`collection_categories_id`, `language_id`, `collection_categories_name`, `collection_categories_home_keyhead`, `collection_categories_home_keymessage`, `collection_categories_banner_keyhead`, `collection_categories_banner_keymessage`) VALUES
(1, 1, 'test', '', '', '', ''),
(1, 2, '', '', '', '', ''),
(1, 3, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `collection_images`
--

CREATE TABLE IF NOT EXISTS `collection_images` (
  `collection_images_id` int(10) NOT NULL,
  `collection_id` int(10) NOT NULL,
  `collection_images_path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `collection_images_seq` int(11) NOT NULL,
  `collection_images_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collection_lang`
--

CREATE TABLE IF NOT EXISTS `collection_lang` (
  `collection_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `collection_name` varchar(200) NOT NULL,
  `collection_short_detail` text NOT NULL,
  `collection_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `collection_lang`
--

INSERT INTO `collection_lang` (`collection_id`, `language_id`, `collection_name`, `collection_short_detail`, `collection_detail`) VALUES
(1, 1, 'asdasa', '', 'dsfxcxxxxxxxxxxxxx'),
(1, 2, '3', '', '4'),
(1, 3, '5', '', '6');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE IF NOT EXISTS `contactus` (
  `contactus_id` int(10) NOT NULL AUTO_INCREMENT,
  `contactus_name` varchar(100) NOT NULL,
  `contactus_email` varchar(200) NOT NULL,
  `contactus_tel` varchar(20) NOT NULL,
  `contactus_topic` varchar(200) NOT NULL,
  `contactus_detail` text NOT NULL,
  `contactus_date` datetime NOT NULL,
  PRIMARY KEY (`contactus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(10) NOT NULL,
  `faq_date_added` datetime NOT NULL,
  `faq_last_modified` datetime NOT NULL,
  `faq_seq` int(10) NOT NULL,
  `faq_pin` tinyint(1) NOT NULL DEFAULT '0',
  `faq_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  PRIMARY KEY (`faq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_date_added`, `faq_last_modified`, `faq_seq`, `faq_pin`, `faq_publish`) VALUES
(1, '2014-08-09 14:30:10', '2014-08-09 15:15:46', 1, 0, '1'),
(2, '2014-09-10 12:19:23', '2014-09-10 12:19:53', 2, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `faq_lang`
--

CREATE TABLE IF NOT EXISTS `faq_lang` (
  `faq_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `faq_question` varchar(200) NOT NULL,
  `faq_answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faq_lang`
--

INSERT INTO `faq_lang` (`faq_id`, `language_id`, `faq_question`, `faq_answer`) VALUES
(2, 1, '1', '&lt;p&gt;2&lt;/p&gt;'),
(2, 2, 'f', '&lt;p&gt;d&lt;/p&gt;'),
(2, 3, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `jewely`
--

CREATE TABLE IF NOT EXISTS `jewely` (
  `jewely_id` int(10) NOT NULL AUTO_INCREMENT,
  `jewely_date_added` datetime NOT NULL,
  `jewely_last_modified` datetime NOT NULL,
  `jewely_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `jewely_pin` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `jewely_seq` int(10) NOT NULL,
  `jewely_view` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jewely_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jewely`
--

INSERT INTO `jewely` (`jewely_id`, `jewely_date_added`, `jewely_last_modified`, `jewely_publish`, `jewely_pin`, `jewely_seq`, `jewely_view`) VALUES
(1, '2014-09-09 23:52:32', '2014-09-09 23:52:51', '1', '0', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jewely_images`
--

CREATE TABLE IF NOT EXISTS `jewely_images` (
  `jewely_images_id` int(10) NOT NULL AUTO_INCREMENT,
  `jewely_id` int(10) NOT NULL,
  `jewely_images_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `jewely_images_seq` int(10) NOT NULL,
  `jewely_images_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`jewely_images_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jewely_lang`
--

CREATE TABLE IF NOT EXISTS `jewely_lang` (
  `jewely_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `jewely_name` varchar(200) NOT NULL,
  `jewely_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jewely_lang`
--

INSERT INTO `jewely_lang` (`jewely_id`, `language_id`, `jewely_name`, `jewely_detail`) VALUES
(1, 1, '1ererer', '&lt;p&gt;2wewewewe&lt;/p&gt;'),
(1, 2, '3', '&lt;p&gt;4&lt;/p&gt;'),
(1, 3, '5', '&lt;p&gt;6&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_user` varchar(100) NOT NULL,
  `admin_group_id` int(10) NOT NULL,
  `log_name` varchar(300) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `admin_user`, `admin_group_id`, `log_name`, `log_date`) VALUES
(1, 'admin', 2, 'log_add_product', '2014-08-07 08:55:09'),
(2, 'admin', 2, 'log_add_product', '2014-08-07 09:16:31'),
(3, 'admin', 2, 'log_add_product', '2014-08-07 10:01:51'),
(4, 'admin', 2, 'log_edit_product', '2014-08-07 10:41:28'),
(5, 'admin', 2, 'log_add_news', '2014-08-08 23:35:13'),
(6, 'admin', 2, 'log_add_jewely', '2014-08-09 00:30:46'),
(7, 'root', 1, 'log_add_faq', '2014-08-09 07:30:10'),
(8, 'root', 1, 'log_edit_faq', '2014-08-09 08:13:48'),
(9, 'root', 1, 'log_edit_faq', '2014-08-09 08:15:46'),
(10, 'root', 1, 'log_add_product', '2014-08-30 06:57:44'),
(11, 'root', 1, 'log_add_product', '2014-08-30 07:00:37'),
(12, 'root', 1, 'log_add_product', '2014-08-30 07:01:46'),
(13, 'root', 1, 'log_add_product', '2014-08-30 07:02:41'),
(14, 'root', 1, 'log_add_product', '2014-08-30 07:38:38'),
(15, 'root', 1, 'log_add_product', '2014-08-30 07:38:59'),
(16, 'root', 1, 'log_add_product', '2014-08-30 07:39:41'),
(17, 'root', 1, 'log_edit_product', '2014-09-03 10:41:57'),
(18, 'admin', 2, 'log_add_collection', '2014-09-09 16:12:14'),
(19, 'admin', 2, 'log_edit_collection', '2014-09-09 16:20:52'),
(20, 'admin', 2, 'log_add_news', '2014-09-09 16:32:26'),
(21, 'admin', 2, 'log_edit_news', '2014-09-09 16:35:52'),
(22, 'admin', 2, 'log_add_jewely', '2014-09-09 16:52:32'),
(23, 'admin', 2, 'log_edit_jewely', '2014-09-09 16:52:51'),
(24, 'admin', 2, 'log_add_faq', '2014-09-10 05:19:23'),
(25, 'admin', 2, 'log_edit_faq', '2014-09-10 05:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `log_lang`
--

CREATE TABLE IF NOT EXISTS `log_lang` (
  `log_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `log_desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `log_lang`
--

INSERT INTO `log_lang` (`log_id`, `language_id`, `log_desc`) VALUES
(13, 1, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank">test</a>'),
(13, 2, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank"></a>'),
(13, 3, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank"></a>'),
(14, 1, '<a href="/shannta/product/backend/edit_product/id/4" target="_blank">Charms 1</a>'),
(14, 2, '<a href="/shannta/product/backend/edit_product/id/4" target="_blank"></a>'),
(14, 3, '<a href="/shannta/product/backend/edit_product/id/4" target="_blank"></a>'),
(15, 1, '<a href="/shannta/product/backend/edit_product/id/5" target="_blank">Charms 2</a>'),
(15, 2, '<a href="/shannta/product/backend/edit_product/id/5" target="_blank"></a>'),
(15, 3, '<a href="/shannta/product/backend/edit_product/id/5" target="_blank"></a>'),
(16, 1, '<a href="/shannta/product/backend/edit_product/id/6" target="_blank">Charms 3</a>'),
(16, 2, '<a href="/shannta/product/backend/edit_product/id/6" target="_blank"></a>'),
(16, 3, '<a href="/shannta/product/backend/edit_product/id/6" target="_blank"></a>'),
(17, 1, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank">test</a>'),
(17, 2, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank"></a>'),
(17, 3, '<a href="/shannta/product/backend/edit_product/id/3" target="_blank"></a>'),
(18, 1, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">1</a>'),
(18, 2, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">3</a>'),
(18, 3, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">5</a>'),
(19, 1, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">asdasa</a>'),
(19, 2, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">3</a>'),
(19, 3, '<a href="/shanntadev/collection/backend/edit_collection/id/1" target="_blank">5</a>'),
(20, 1, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">1</a>'),
(20, 2, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">3</a>'),
(20, 3, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">5</a>'),
(21, 1, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">sdsdsd</a>'),
(21, 2, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">3</a>'),
(21, 3, '<a href="/shanntadev/news/backend/edit_news/id/2" target="_blank">5</a>'),
(22, 1, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">1</a>'),
(22, 2, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">3</a>'),
(22, 3, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">5</a>'),
(23, 1, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">1ererer</a>'),
(23, 2, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">3</a>'),
(23, 3, '<a href="/shanntadev/jewely/backend/edit_jewely/id/1" target="_blank">5</a>');

-- --------------------------------------------------------

--
-- Table structure for table `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `main_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL DEFAULT '0',
  `main_contact` text NOT NULL,
  `main_email` varchar(200) NOT NULL,
  `main_tel` varchar(200) NOT NULL,
  `main_facebook` varchar(200) NOT NULL,
  `main_twitter` varchar(200) NOT NULL,
  `main_intro` text NOT NULL,
  `main_intro_show` tinyint(1) NOT NULL DEFAULT '1',
  `main_lookbook_path` varchar(200) NOT NULL,
  `main_policy` text NOT NULL,
  `main_shipping` text NOT NULL,
  `main_latitude` varchar(20) NOT NULL,
  `main_longitude` varchar(20) NOT NULL,
  `main_last_modified` datetime NOT NULL,
  PRIMARY KEY (`main_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `main`
--

INSERT INTO `main` (`main_id`, `language_id`, `main_contact`, `main_email`, `main_tel`, `main_facebook`, `main_twitter`, `main_intro`, `main_intro_show`, `main_lookbook_path`, `main_policy`, `main_shipping`, `main_latitude`, `main_longitude`, `main_last_modified`) VALUES
(1, 1, '<p><strong>Have Reward</strong></p>\r\n<p>48/324 เสรีไทย<br /> แขวงคลองกุ่ม เขตบึงกุ่ม<br /> กรุงเทพมหานคร 10230</p>\r\n<p>&nbsp;</p>\r\n<p><strong>เบอร์โทรศัพท์:</strong></p>\r\n<p>+1 800 559 6580</p>\r\n<p>+1 800 603 6035</p>', '', '', '', '', '<h1 style="text-align: center;"><span style="color: #ff0000;">ขออภัยในความไม่สะดวก เว็บไซต์กำลังอยู่ในช่วงการปรับปรุง</span></h1>\r\n<h1 style="text-align: center;"><span style="color: #ff0000;">ลูกค้าสามารถใช้งานได้ใหม่ตั้งแต่เวลา 07.00 น. วันที่ 18 มิถุนายน 2557</span></h1>\r\n<h1 style="text-align: center;"><span style="color: #ff0000;">ขอบคุณค่ะ</span></h1>', 0, 'public/upload/main/thumbnails/lookbook_9e91d8ad13f7840ca3cde56ab9916888.jpg', '<p>test policy</p>', '<p>test shipping</p>', '13.753190', '100.646590', '2014-08-10 14:22:28'),
(2, 2, '', '', '', '', '', '', 0, '', '', '', '', '', '2014-08-10 10:00:00'),
(3, 3, '', '', '', '', '', '', 0, '', '', '', '', '', '2014-09-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `member_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '0=ทั่วไป',
  `member_type` int(1) NOT NULL DEFAULT '1' COMMENT '1=เอเยนต์ 2=walk',
  `member_discount` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `member_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `member_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_iden` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `member_birth_day` int(2) NOT NULL DEFAULT '0',
  `member_birth_month` int(2) NOT NULL DEFAULT '0',
  `member_birth_year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `member_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(10) NOT NULL,
  `member_postcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_tel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `member_occupation` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_income` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_point` int(5) NOT NULL DEFAULT '0',
  `member_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_publish` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_income`
--

CREATE TABLE IF NOT EXISTS `member_income` (
  `member_income_id` int(10) NOT NULL,
  `member_income_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_income_seq` int(10) NOT NULL,
  `member_income_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  PRIMARY KEY (`member_income_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_occupation`
--

CREATE TABLE IF NOT EXISTS `member_occupation` (
  `member_occupation_id` int(10) NOT NULL,
  `member_occupation_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_occupation_seq` int(10) NOT NULL,
  `member_occupation_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  PRIMARY KEY (`member_occupation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_point`
--

CREATE TABLE IF NOT EXISTS `member_point` (
  `member_point_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL DEFAULT '0',
  `member_point_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=เพิ่ม 0=ลด',
  `member_point_reason` varchar(200) NOT NULL,
  `member_point_val` int(5) NOT NULL DEFAULT '0',
  `member_point_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) NOT NULL AUTO_INCREMENT,
  `news_date_added` datetime NOT NULL,
  `news_last_modified` datetime NOT NULL,
  `news_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `news_pin` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `news_seq` int(10) NOT NULL,
  `news_view` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_date_added`, `news_last_modified`, `news_publish`, `news_pin`, `news_seq`, `news_view`) VALUES
(1, '2014-08-09 06:35:13', '2014-08-09 06:35:13', '1', '1', 1, 0),
(2, '2014-09-09 23:32:26', '2014-09-09 23:35:52', '1', '0', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_images`
--

CREATE TABLE IF NOT EXISTS `news_images` (
  `news_images_id` int(10) NOT NULL AUTO_INCREMENT,
  `news_id` int(10) NOT NULL,
  `news_images_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `news_images_seq` int(10) NOT NULL,
  `news_images_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_images_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news_images`
--

INSERT INTO `news_images` (`news_images_id`, `news_id`, `news_images_path`, `news_images_seq`, `news_images_status`) VALUES
(1, 1, 'public/upload/news/thumbnails/news1D9620322e4d3bfc618678870ec87610ef.gif', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `news_lang`
--

CREATE TABLE IF NOT EXISTS `news_lang` (
  `news_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `news_name` varchar(200) NOT NULL,
  `news_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_lang`
--

INSERT INTO `news_lang` (`news_id`, `language_id`, `news_name`, `news_detail`) VALUES
(2, 1, 'sdsdsd', '&lt;p&gt;asdasdasdsadsssssssssssssssss&lt;/p&gt;'),
(2, 2, '3', '&lt;p&gt;4&lt;/p&gt;'),
(2, 3, '5', '&lt;p&gt;6&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(10) NOT NULL,
  `product_categories_id` int(10) NOT NULL DEFAULT '0',
  `product_price` double NOT NULL DEFAULT '0',
  `product_discount` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `product_newprice` double NOT NULL DEFAULT '0',
  `product_date_added` datetime NOT NULL,
  `product_last_modified` datetime NOT NULL,
  `product_seq` int(10) NOT NULL DEFAULT '0',
  `product_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish, 2:delete',
  `product_pin` tinyint(1) NOT NULL DEFAULT '0',
  `product_hot` tinyint(1) NOT NULL DEFAULT '0',
  `product_rec` tinyint(1) NOT NULL DEFAULT '0',
  `product_pro` tinyint(1) NOT NULL DEFAULT '0',
  `product_sale` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_categories_id`, `product_price`, `product_discount`, `product_newprice`, `product_date_added`, `product_last_modified`, `product_seq`, `product_publish`, `product_pin`, `product_hot`, `product_rec`, `product_pro`, `product_sale`) VALUES
(1, 1, 0, '0', 0, '2014-08-30 14:00:37', '2014-08-30 14:00:37', 1, '1', 0, 0, 0, 0, 0),
(2, 1, 0, '0', 0, '2014-08-30 14:01:46', '2014-08-30 14:01:46', 2, '1', 0, 0, 0, 0, 0),
(3, 1, 0, '0', 0, '2014-08-30 14:02:41', '2014-09-03 17:41:57', 3, '1', 0, 0, 0, 0, 0),
(4, 1, 300, '0', 300, '2014-08-30 14:38:38', '2014-08-30 14:38:38', 4, '1', 0, 0, 0, 0, 0),
(5, 1, 3000, '0', 3000, '2014-08-30 14:38:59', '2014-08-30 14:38:59', 5, '1', 0, 0, 0, 0, 0),
(6, 1, 400, '0', 400, '2014-08-30 14:39:40', '2014-08-30 14:39:40', 6, '1', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `product_categories_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_categories_parent_id` int(10) NOT NULL,
  `product_categories_home_position` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `product_categories_home_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_categories_banner_position` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `product_categories_banner_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_categories_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1:publish, 0: unpublish',
  `product_categories_hot` tinyint(1) NOT NULL DEFAULT '0',
  `product_categories_seq` int(10) NOT NULL,
  PRIMARY KEY (`product_categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`product_categories_id`, `product_categories_parent_id`, `product_categories_home_position`, `product_categories_home_path`, `product_categories_banner_position`, `product_categories_banner_path`, `product_categories_publish`, `product_categories_hot`, `product_categories_seq`) VALUES
(1, 0, 'L', '', 'L', '', '1', 0, 1),
(2, 0, 'L', '', 'L', '', '1', 0, 2),
(3, 0, 'L', '', 'L', '', '1', 0, 3),
(4, 0, 'L', '', 'L', '', '1', 0, 4),
(5, 0, 'L', '', 'L', '', '1', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories_lang`
--

CREATE TABLE IF NOT EXISTS `product_categories_lang` (
  `product_categories_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `product_categories_name` varchar(200) NOT NULL,
  `product_categories_home_keyhead` varchar(200) NOT NULL,
  `product_categories_home_keymessage` text NOT NULL,
  `product_categories_banner_keyhead` varchar(200) NOT NULL,
  `product_categories_banner_keymessage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_categories_lang`
--

INSERT INTO `product_categories_lang` (`product_categories_id`, `language_id`, `product_categories_name`, `product_categories_home_keyhead`, `product_categories_home_keymessage`, `product_categories_banner_keyhead`, `product_categories_banner_keymessage`) VALUES
(1, 1, 'ตะกรุด', 'test', '', '', ''),
(1, 2, 'CHARMS', '', '', '', ''),
(1, 3, '魅力', '', '', '', ''),
(2, 1, 'สร้อยข้อมือ', '', '', '', ''),
(2, 2, 'BRACELETS', '', '', '', ''),
(2, 3, '手镯 ', '', '', '', ''),
(3, 1, 'แหวน', '', '', '', ''),
(3, 2, 'RINGS', '', '', '', ''),
(3, 3, '环', '', '', '', ''),
(4, 1, 'ต่างหู', '', '', '', ''),
(4, 2, 'EARRINGS', '', '', '', ''),
(4, 3, '耳环', '', '', '', ''),
(5, 1, 'สร้อยคอและจี้', '', '', '', ''),
(5, 2, 'NECKLACES AND PENDANTS', '', '', '', ''),
(5, 3, '项链和吊坠', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `product_images_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_images_path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_images_seq` int(11) NOT NULL,
  `product_images_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`product_images_id`, `product_id`, `product_images_path`, `product_images_seq`, `product_images_status`) VALUES
(1, 1, 'public/upload/product/thumbnails/product_1_b27202c49634cbebd25c8be10d710425.jpg', 1, '0'),
(2, 1, 'public/upload/product/thumbnails/product_1_a427e7e267a200a03fc72dd758e9a925.jpg', 2, '0'),
(3, 2, 'public/upload/product/thumbnails/product_2_6b0806130664bfb18e5cf8858663e821.jpg', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `product_lang`
--

CREATE TABLE IF NOT EXISTS `product_lang` (
  `product_id` int(10) NOT NULL DEFAULT '0',
  `language_id` int(10) NOT NULL DEFAULT '0',
  `product_name` varchar(200) NOT NULL,
  `product_short_detail` text NOT NULL,
  `product_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_lang`
--

INSERT INTO `product_lang` (`product_id`, `language_id`, `product_name`, `product_short_detail`, `product_detail`) VALUES
(3, 1, 'test', '', ''),
(3, 2, '', '', ''),
(3, 3, '', '', ''),
(4, 1, 'Charms 1', '', ''),
(4, 2, '', '', ''),
(4, 3, '', '', ''),
(5, 1, 'Charms 2', '', ''),
(5, 2, '', '', ''),
(5, 3, '', '', ''),
(6, 1, 'Charms 3', '', 'test'),
(6, 2, '', '', ''),
(6, 3, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_promotion`
--

CREATE TABLE IF NOT EXISTS `product_promotion` (
  `product_promotion_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_promotion_name` text COLLATE utf8_unicode_ci NOT NULL,
  `product_price` double NOT NULL DEFAULT '0',
  `product_discount` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `product_promotion_date_added` datetime NOT NULL,
  `product_promotion_last_modified` datetime NOT NULL,
  `product_promotion_seq` int(10) NOT NULL,
  `product_promotion_pin` tinyint(1) NOT NULL DEFAULT '0',
  `product_promotion_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  PRIMARY KEY (`product_promotion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE IF NOT EXISTS `province` (
  `province_id` varchar(3) NOT NULL DEFAULT '0',
  `province_name_th` varchar(255) DEFAULT NULL,
  `province_name_en` varchar(255) DEFAULT NULL,
  `region_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `province_name_th`, `province_name_en`, `region_id`) VALUES
('101', 'กระบี่', 'Krabi', 14),
('102', 'กรุงเทพมหานคร', 'Bangkok', 10),
('103', 'กาญจนบุรี', 'Kanchanaburi', 10),
('104', 'กาฬสินธุ์', 'Kalasin', 13),
('105', 'กำแพงเพชร', 'Kamphaeng Phet', 10),
('106', 'ขอนแก่น', 'Khon Kaen', 13),
('107', 'จันทบุรี', 'Chanthaburi', 11),
('108', 'ฉะเชิงเทรา', 'Chachoengsao', 11),
('109', 'ชลบุรี', 'Chonburi', 11),
('110', 'ชัยนาท', 'Chainat', 12),
('111', 'ชัยภูมิ', 'Chaiyaphum', 13),
('112', 'ชุมพร', 'Chumphon', 14),
('113', 'ตรัง', 'Trang', 14),
('114', 'ตราด', 'Trat', 11),
('115', 'ตาก', 'Tak', 10),
('116', 'นครนายก', 'Nakhon Nayok', 10),
('117', 'นครปฐม', 'Nakhon Pathom', 10),
('118', 'นครพนม', 'Nakhon Phanom', 13),
('119', 'นครราชสีมา', 'Nakhon Ratchasima', 13),
('120', 'นครศรีธรรมราช', 'Nakhon Si Thammarat', 14),
('121', 'นครสวรรค์', 'Nakhon Sawan', 12),
('122', 'นนทบุรี', 'Nonthaburi', 10),
('123', 'นราธิวาส', 'Narathiwat', 14),
('124', 'น่าน', 'Nan', 12),
('125', 'บุรีรัมย์', 'Buriram', 13),
('126', 'ปทุมธานี', 'Pathum Thani', 10),
('127', 'ประจวบคีรีขันธ์', 'Prachuap Khiri Khan', 10),
('128', 'ปราจีนบุรี', 'Prachinburi', 11),
('129', 'ปัตตานี', 'Pattani', 14),
('130', 'พระนครศรีอยุธยา', 'Ayutthaya', 10),
('131', 'พะเยา', 'Phayao', 12),
('132', 'พังงา', 'Phang Nga', 14),
('133', 'พัทลุง', 'Phattalung', 14),
('134', 'พิจิตร', 'Phichit', 10),
('135', 'พิษณุโลก', 'Phitsanulok', 12),
('136', 'ภูเก็ต', 'Phuket', 14),
('137', 'มหาสารคาม', 'Maha Sarakham', 13),
('138', 'มุกดาหาร', 'Mukdahan', 13),
('139', 'ยะลา', 'Yala', 14),
('140', 'ยโสธร', 'Yasothon', 13),
('141', 'ระนอง', 'Ranong', 14),
('142', 'ระยอง', 'Rayong', 11),
('143', 'ราชบุรี', 'Ratchaburi', 10),
('144', 'ร้อยเอ็ด', 'Roi Et', 13),
('145', 'ลพบุรี', 'Lopburi', 10),
('146', 'ลำปาง', 'Lampang', 12),
('147', 'ลำพูน', 'Lamphun', 12),
('148', 'ศรีสะเกษ', 'Si Saket', 13),
('149', 'สกลนคร', 'Sakhon Nakhon', 13),
('150', 'สงขลา', 'Songkhla', 14),
('151', 'สตูล', 'Satun', 14),
('152', 'สมุทรปราการ', 'Samut Prakan', 10),
('153', 'สมุทรสงคราม', 'Samut Songkhram', 10),
('154', 'สมุทรสาคร', 'Samut Sakhon', 10),
('155', 'สระบุรี', 'Saraburi', 10),
('156', 'สระแก้ว', 'Sa Kaeo', 11),
('157', 'สิงห์บุรี', 'Singburi', 10),
('158', 'สุพรรณบุรี', 'Suphanburi', 10),
('159', 'สุราษฎร์ธานี', 'Surat Thani', 14),
('160', 'สุรินทร์', 'Surin', 13),
('161', 'สุโขทัย', 'Sukhothaï', 10),
('162', 'หนองคาย', 'Nong Khai', 13),
('163', 'หนองบัวลำภู', 'Nong Bua Lamphu', 13),
('164', 'อำนาจเจริญ', 'Amnat Charoen', 13),
('165', 'อุดรธานี', 'Udon Thani', 13),
('166', 'อุตรดิตถ์', 'Uttaradit', 12),
('167', 'อุทัยธานี', 'Uthai Thani', 10),
('168', 'อุบลราชธานี', 'Ubon Ratchathani', 13),
('169', 'อ่างทอง', 'Ang Thong', 10),
('170', 'เชียงราย', 'Chiang Rai', 12),
('171', 'เชียงใหม่', 'Chiang Mai', 12),
('172', 'เพชรบุรี', 'Phetchaburi', 10),
('173', 'เพชรบูรณ์', 'Phetchabun', 12),
('174', 'เลย', 'Loei', 13),
('175', 'แพร่', 'Phrae', 12),
('176', 'แม่ฮ่องสอน', 'Mae Hong Son', 12),
('177', 'บึงกาฬ', 'Bueng Kan', 13);

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `slide_id` int(10) NOT NULL,
  `slide_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `slide_image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `slide_date_added` datetime NOT NULL,
  `slide_last_modified` datetime NOT NULL,
  `slide_seq` int(10) NOT NULL,
  `slide_pin` tinyint(1) NOT NULL DEFAULT '0',
  `slide_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  PRIMARY KEY (`slide_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_order`
--

CREATE TABLE IF NOT EXISTS `sp_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `order_discount` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'ส่วนลดท้ายตาราง',
  `order_summary` double NOT NULL DEFAULT '0' COMMENT 'ผลรวม',
  `order_point` int(10) NOT NULL DEFAULT '0' COMMENT 'แต้มท้ายตาราง',
  `order_point_summary` int(10) NOT NULL DEFAULT '0' COMMENT 'ผลรวมแต้ม',
  `member_first_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_last_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `member_address` text COLLATE utf8_unicode_ci NOT NULL,
  `member_tel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` date NOT NULL DEFAULT '0000-00-00',
  `order_date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_status_id` int(1) NOT NULL,
  `order_payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=dis point, 2=transfer money',
  `order_read` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '0:ยังไม่ได้อ่าน, 1: อ่านแล้ว',
  `order_tracking` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sp_order_bank`
--

CREATE TABLE IF NOT EXISTS `sp_order_bank` (
  `bank_id` int(10) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `bank_branch` varchar(200) NOT NULL,
  `bank_account` varchar(200) NOT NULL,
  `bank_no` varchar(20) NOT NULL,
  `bank_image` varchar(200) NOT NULL,
  `bank_date_added` datetime NOT NULL,
  `bank_last_modified` datetime NOT NULL,
  `bank_publish` varchar(1) NOT NULL,
  `bank_pin` varchar(1) NOT NULL,
  `bank_seq` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sp_order_bank`
--

INSERT INTO `sp_order_bank` (`bank_id`, `bank_name`, `bank_branch`, `bank_account`, `bank_no`, `bank_image`, `bank_date_added`, `bank_last_modified`, `bank_publish`, `bank_pin`, `bank_seq`) VALUES
(2, '111', '222', '333', '444', 'public/upload/bank/thumbnails/bank_2_c00cc40c3a4d6874b1738916f4cec392.jpg', '2013-07-08 08:51:39', '2013-07-08 08:51:39', '1', '0', 2),
(3, 'sfsdfsdf', 'vxcv', 'xcgfdgdf', 'gdgdfg', 'public/upload/bank/thumbnails/bank_3_1d48d20f59b887f2da390541216f55aa.jpg', '2013-07-08 09:05:02', '2013-07-08 09:05:02', '1', '0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sp_order_confirm`
--

CREATE TABLE IF NOT EXISTS `sp_order_confirm` (
  `order_confirm_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0',
  `order_confirm_name` varchar(200) NOT NULL,
  `order_confirm_surname` varchar(200) NOT NULL,
  `order_confirm_tel` varchar(200) NOT NULL,
  `order_confirm_bank` int(10) NOT NULL DEFAULT '0',
  `order_confirm_total` double NOT NULL,
  `order_confirm_transfer_date` varchar(100) NOT NULL,
  `order_confirm_path` varchar(200) NOT NULL,
  `order_confirm_note` text NOT NULL,
  `order_confirm_status` tinyint(1) NOT NULL DEFAULT '1',
  `order_confirm_date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sp_order_item`
--

CREATE TABLE IF NOT EXISTS `sp_order_item` (
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `team_id` int(10) NOT NULL DEFAULT '0',
  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `product_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `order_qty` int(10) unsigned NOT NULL,
  `order_price` decimal(12,2) NOT NULL,
  `order_discount` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_point` int(5) NOT NULL DEFAULT '0',
  `order_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_order_payment`
--

CREATE TABLE IF NOT EXISTS `sp_order_payment` (
  `order_payment_id` int(2) NOT NULL,
  `order_payment_name` varchar(100) NOT NULL,
  PRIMARY KEY (`order_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sp_order_payment`
--

INSERT INTO `sp_order_payment` (`order_payment_id`, `order_payment_name`) VALUES
(1, 'เงินในบัญชี BKKmarket'),
(2, 'โอนผ่านบัญชีธนาคาร'),
(3, 'Paysbuy'),
(4, 'Credit card'),
(5, 'Counter Service');

-- --------------------------------------------------------

--
-- Table structure for table `sp_order_status`
--

CREATE TABLE IF NOT EXISTS `sp_order_status` (
  `order_status_id` int(2) NOT NULL,
  `order_status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`order_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sp_order_status`
--

INSERT INTO `sp_order_status` (`order_status_id`, `order_status_name`) VALUES
(1, 'pending'),
(2, 'processing'),
(3, 'shipped'),
(4, 'closed'),
(5, 'waiting'),
(6, 'cancel'),
(7, 'Pending Dispute'),
(8, 'Closed Seller Win'),
(9, 'Closed Buyer Win');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `team_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL DEFAULT '0',
  `team_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE IF NOT EXISTS `voucher` (
  `voucher_id` int(10) NOT NULL,
  `voucher_no` varchar(20) NOT NULL,
  `voucher_tel` varchar(20) NOT NULL,
  `voucher_point` int(5) NOT NULL,
  `voucher_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
