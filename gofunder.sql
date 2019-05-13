-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 13, 2019 at 01:36 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gofunder`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
CREATE TABLE IF NOT EXISTS `campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `country_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `allow_funds` tinyint(1) NOT NULL,
  `allow_presale` tinyint(1) NOT NULL,
  `allow_speedup` tinyint(1) NOT NULL,
  `allow_share` tinyint(1) NOT NULL,
  `allow_other_country` tinyint(1) NOT NULL,
  `uri` varchar(150) NOT NULL,
  `startAt` timestamp NOT NULL,
  `finishAt` timestamp NOT NULL,
  `opt_develop` int(11) NOT NULL,
  `opt_type` int(11) NOT NULL,
  `opt_category` int(11) NOT NULL,
  `opt_funds` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cover_url` varchar(150) NOT NULL,
  `facebook` varchar(80) NOT NULL,
  `instagram` varchar(80) NOT NULL,
  `youtube` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `opt_develop` (`opt_develop`),
  KEY `opt_type` (`opt_type`),
  KEY `opt_category` (`opt_category`),
  KEY `user_id` (`user_id`),
  KEY `country_id` (`country_id`),
  KEY `opt_funds` (`opt_funds`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`id`, `title`, `country_id`, `amount`, `description`, `user_id`, `allow_funds`, `allow_presale`, `allow_speedup`, `allow_share`, `allow_other_country`, `uri`, `startAt`, `finishAt`, `opt_develop`, `opt_type`, `opt_category`, `opt_funds`, `status`, `cover_url`, `facebook`, `instagram`, `youtube`) VALUES
(2, 'Coffee When Wakeup', 1, '123.00', 'We identify the exact time that you wake up and we\'ll leave your coffee ready.', 2, 1, 0, 0, 0, 0, 'Coffee-When-Wakeup', '0000-00-00 00:00:00', '2019-05-14 06:00:00', 1, 4, 1, 7, 0, 'api/uploads/Coffee-When-Wakeup-cover', '', '', ''),
(3, 'Coffee When Wakeup', 1, '123.00', 'We identify the exact time that you wake up and we\'ll leave your coffee ready.', 15, 1, 0, 0, 0, 0, 'Coffee-When-Wakeup', '0000-00-00 00:00:00', '2019-05-06 06:00:00', 1, 4, 1, 7, 0, 'api/uploads/Coffee-When-Wakeup-cover', '', '', ''),
(4, 'Coffee When Wakeup', 1, '123.00', 'We identify the exact time that you wake up and we\'ll leave your coffee ready.', 15, 1, 0, 0, 0, 0, 'Coffee-When-Wakeup', '0000-00-00 00:00:00', '2019-05-23 06:00:00', 1, 4, 1, 7, 0, 'api/uploads/Coffee-When-Wakeup-cover4.jpg', '', '', ''),
(5, 'Café é muito bom para programar', 1, '150000.00', 'Eu gosto de tomar café enquanto escrevo código', 33, 1, 0, 0, 0, 0, 'Cafe-e-muito-bom-para-programar', '0000-00-00 00:00:00', '2019-05-22 06:00:00', 1, 4, 1, 7, 0, 'api/uploads/Cafe-e-muito-bom-para-programar-cover1.jpg', '', '', ''),
(6, 'Coffee When Wakeup', 1, '123.00', 'We identify the exact time that you wake up and we\'ll leave your coffee ready.', 28, 1, 0, 0, 0, 0, 'Coffee-When-Wakeup', '0000-00-00 00:00:00', '2019-05-13 06:00:00', 1, 4, 1, 7, 1, 'api/uploads/Coffee-When-Wakeup-cover10.jpg', 'insta2', 'face2', 'yt2'),
(7, 'Teste de campanha', 1, '123.00', 'We identify the exact time that you wake up and we\'ll leave your coffee ready.', 28, 1, 0, 0, 0, 0, 'Teste-de-campanha', '0000-00-00 00:00:00', '2019-05-22 06:00:00', 1, 4, 1, 7, 0, 'api/uploads/Teste-de-campanha-cover.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_coment`
--

DROP TABLE IF EXISTS `campaign_coment`;
CREATE TABLE IF NOT EXISTS `campaign_coment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `coment` text NOT NULL,
  `createdAt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_content`
--

DROP TABLE IF EXISTS `campaign_content`;
CREATE TABLE IF NOT EXISTS `campaign_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `html` text NOT NULL,
  `cover_url` varchar(255) NOT NULL,
  `profile_url` varchar(255) NOT NULL,
  `youtube_video_url` varchar(155) NOT NULL,
  `facebook_page` varchar(155) NOT NULL,
  `instagram_page` varchar(155) NOT NULL,
  `direct_video_url` varchar(256) NOT NULL,
  `youtube_page` varchar(155) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_faq`
--

DROP TABLE IF EXISTS `campaign_faq`;
CREATE TABLE IF NOT EXISTS `campaign_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign_faq`
--

INSERT INTO `campaign_faq` (`id`, `campaign_id`, `question`, `answer`) VALUES
(22, 6, 'perg', 'resp');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_follower`
--

DROP TABLE IF EXISTS `campaign_follower`;
CREATE TABLE IF NOT EXISTS `campaign_follower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_galery`
--

DROP TABLE IF EXISTS `campaign_galery`;
CREATE TABLE IF NOT EXISTS `campaign_galery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `picture_url` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign_galery`
--

INSERT INTO `campaign_galery` (`id`, `campaign_id`, `picture_url`, `name`) VALUES
(23, 3, 'api/uploads/gallery/teste5cd96c3061416-gallery.png', 'teste');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_item`
--

DROP TABLE IF EXISTS `campaign_item`;
CREATE TABLE IF NOT EXISTS `campaign_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `stock` int(11) NOT NULL,
  `variation` enum('color','size','model') NOT NULL,
  `variation_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_perk` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_opt`
--

DROP TABLE IF EXISTS `campaign_opt`;
CREATE TABLE IF NOT EXISTS `campaign_opt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `type` enum('develop','type','category','funds') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign_opt`
--

INSERT INTO `campaign_opt` (`id`, `name`, `type`) VALUES
(1, 'person', 'develop'),
(2, 'business', 'develop'),
(3, 'nonprofit', 'develop'),
(4, 'software', 'type'),
(5, 'product', 'type'),
(6, 'service', 'type'),
(7, 'local_money', 'funds'),
(8, 'american_dolar', 'funds'),
(9, 'criptocurrency', 'funds');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_perk`
--

DROP TABLE IF EXISTS `campaign_perk`;
CREATE TABLE IF NOT EXISTS `campaign_perk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cover_url` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shipping_worldwide` enum('world_wide','only_country') NOT NULL DEFAULT 'world_wide',
  `discount` int(11) NOT NULL,
  `shipping_price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `shipping_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `campaign_perk`
--

INSERT INTO `campaign_perk` (`id`, `campaign_id`, `name`, `description`, `cover_url`, `price`, `shipping_worldwide`, `discount`, `shipping_price`, `stock`, `shipping_date`, `status`) VALUES
(25, 3, 'bruno nao é mais lindo', 'Brunolindo2', 'api/uploads/perk/5cd58f08aa4f4-perk.png', '150.00', 'world_wide', 99, 0, 150, '2019-05-19', 0),
(26, 3, 'Bruno feio 1', 'Bruno feio', 'api/uploads/perk/5cd58f3fab202-perk.jpg', '150.00', 'only_country', 80, 150, 150, '2019-05-24', 0),
(27, 3, 'edge do bruno', '661wte6yw498yh5jw165ba15w', 'api/uploads/perk/5cd5903e435fa-perk.jpg', '54476.00', 'only_country', 1674, 40, 100, '2019-05-14', 0),
(28, 6, 'yasd', 'adasd', 'api/uploads/perk/5cd5f27c54916-perk.jpg', '123.00', 'only_country', 23, 10, 123, '2019-05-13', 0),
(30, 6, 'tese', 'asdadsasdasdasd', 'api/uploads/perk/5cd612fab2041-perk.jpg', '12.00', 'only_country', 231, 123, 123, '2019-05-22', 0),
(31, 6, '32', 't23', 'api/uploads/perk/5cd7113817c6f-perk.jpg', '123.00', 'world_wide', 10, 0, 10, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `route` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `route`) VALUES
(1, 'travel', 'travel'),
(2, 'fashion', 'fashion'),
(3, 'eletronic', 'eletronic');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People\'s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People\'s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'SS', 'South Sudan'),
(203, 'ES', 'Spain'),
(204, 'LK', 'Sri Lanka'),
(205, 'SH', 'St. Helena'),
(206, 'PM', 'St. Pierre and Miquelon'),
(207, 'SD', 'Sudan'),
(208, 'SR', 'Suriname'),
(209, 'SJ', 'Svalbard and Jan Mayen Islands'),
(210, 'SZ', 'Swaziland'),
(211, 'SE', 'Sweden'),
(212, 'CH', 'Switzerland'),
(213, 'SY', 'Syrian Arab Republic'),
(214, 'TW', 'Taiwan'),
(215, 'TJ', 'Tajikistan'),
(216, 'TZ', 'Tanzania, United Republic of'),
(217, 'TH', 'Thailand'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad and Tobago'),
(222, 'TN', 'Tunisia'),
(223, 'TR', 'Turkey'),
(224, 'TM', 'Turkmenistan'),
(225, 'TC', 'Turks and Caicos Islands'),
(226, 'TV', 'Tuvalu'),
(227, 'UG', 'Uganda'),
(228, 'UA', 'Ukraine'),
(229, 'AE', 'United Arab Emirates'),
(230, 'GB', 'United Kingdom'),
(231, 'US', 'United States'),
(232, 'UM', 'United States minor outlying islands'),
(233, 'UY', 'Uruguay'),
(234, 'UZ', 'Uzbekistan'),
(235, 'VU', 'Vanuatu'),
(236, 'VA', 'Vatican City State'),
(237, 'VE', 'Venezuela'),
(238, 'VN', 'Vietnam'),
(239, 'VG', 'Virgin Islands (British)'),
(240, 'VI', 'Virgin Islands (U.S.)'),
(241, 'WF', 'Wallis and Futuna Islands'),
(242, 'EH', 'Western Sahara'),
(243, 'YE', 'Yemen'),
(244, 'ZR', 'Zaire'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `usd` decimal(18,2) NOT NULL DEFAULT '0.00',
  `btc` double NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `recover_token` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `token` (`token`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `usd`, `btc`, `token`, `password`, `recover_token`, `created_at`) VALUES
(36, 'ds', 'a@a.com', '0.00', 0, '904f867a6b4558634f8b67aaf82710146720782c', '$2y$07$3E5sMv7F9agpXK25e7DTMecNpuJtJpLOoXgmFvznVjek3Z0qq/sQG', '', '2019-05-08 16:52:00'),
(28, 'Arthur Inda', 'arthurindarocha1@hotmail.com', '0.00', 0, '907d95db75e4cfcf3cbc27b416a0a8d4df6b1aba', '$2y$07$oPwycdH1Ghpdcm.NDiyNC.BLS0.AYOBl/B6JaYD/V7W5Uhwj6u.te', '', '2019-05-07 12:22:33'),
(21, 'teste', 'testtt2@gmail.com', '0.00', 0, '997b64df8b9dbbcb3875ee4f65137b53d3f2700b', '$2y$07$qhwqdlv69pDxrxxQUoIQgOBNrn4XyqZOEFGGhgBmzA6LOVTanjJ2W', '', '2019-05-04 00:12:33'),
(16, 'null', 'null', '0.00', 0, '9af08fd5df2aa3cfd1c8c2d554074b2d06c24bb5', '$2y$07$M/FmCiTqY.c.AFsS/x1CGeFATbHB3LNGuS2LQEq0qTbDVFRekiaaa', '', '2019-05-03 09:27:23'),
(17, 'lucas', 'lucaswillemen@gmail.coma', '0.00', 0, 'cd4094b36609151820788e559b29c3a9b4cf68c5', '$2y$07$MdIPQ4tX2yBY4Phtz7v1j.kY6gEkgwK9NOyCNHyFpiOj/kqQ1Qz9G', '', '2019-05-03 22:10:38'),
(37, 'lucas', 'l@l.com', '0.00', 0, 'e0d336705b899ff28046bc39792c5756badccf86', '$2y$07$wBlZ/CQTlr1Fu9gS7USV3eA/KOrwO012hmvXym6a3uJhedTP/T4M2', '', '2019-05-08 17:17:07'),
(34, 'Lucas Pereira Willemen', 'lucaswillemen@gmail.com', '0.00', 0, 'e0ddf2da7daeaa840459a7629158291bdaca92bd', '$2y$07$GE6WQqUdtIkYjCwhg2vTouXFJimC8Nd1N0IWXwNacxKq8H9vYA4zW', '', '2019-05-08 16:10:39'),
(33, 'Bruno da SIlva', 'ipsbruno@live.com', '0.00', 0, 'e66caeed0b9629068fc2a77f38c1b85c27183010', '$2y$07$ouqANdlqFGoAvYf5bL5l/.WcUbJow2V0VLI0bnCnNQzl1xUCys3KG', '', '2019-05-07 12:26:53'),
(15, 'Bruno', 'email@brunodasilva.com', '604.00', 0, 'f3ca04d0c7786259efdb2c453f7e76ecd52e95383f90b16fb2e96fcb2d4a531e61724b53d25b523b43ef41494ecec335b8414dbbe532d90068de18f966864617cc5936826292506ffdf6b165d67ae43ab067b369852cb76614209632184e1d41bf305f370d7e0b98fada5e577849b48a3c471437f8b65bce090047', '$2y$07$2yTRI.vcwlyFjt8Tf8BytuXK1lnSryboQQhDR1Dp7m53TKirKz3lG', '', '2019-01-30 09:07:12'),
(35, 'asd', 'asd@asd.com', '0.00', 0, 'f98c25b0746b5f09070b6cc24bc1170f5c6cb515', '$2y$07$i4NSkq5jiaL98RtPWm2rUefYVMvOTDHITPZKcANm2EUOXHJ2cxNfS', '', '2019-05-08 16:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `address` varchar(150) NOT NULL,
  `number` varchar(20) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `neighborhood` varchar(150) NOT NULL,
  `complement` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `campaign_ibfk_2` FOREIGN KEY (`opt_category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `campaign_ibfk_3` FOREIGN KEY (`opt_develop`) REFERENCES `campaign_opt` (`id`),
  ADD CONSTRAINT `campaign_ibfk_4` FOREIGN KEY (`opt_funds`) REFERENCES `campaign_opt` (`id`),
  ADD CONSTRAINT `campaign_ibfk_5` FOREIGN KEY (`opt_type`) REFERENCES `campaign_opt` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
