promotions|
CREATE TABLE IF NOT EXISTS `promotions` (
  `promotions_id` int(10) NOT NULL,
  `promotions_create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `promotions_publish` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:publish, 0: unpublish',
  `promotions_seq` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`promotions_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;|#
promotions_lang|
CREATE TABLE IF NOT EXISTS `promotions_lang` (
  `promotions_id` int(10) NOT NULL,
  `language_id` int(10) NOT NULL,
  `promotions_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `promotions_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `promotions_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`promotions_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;|