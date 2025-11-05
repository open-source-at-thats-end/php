--
-- Table structure for table `lead_email`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_lead_email` (
  `ldemail_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ldemail_user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ldemail_to_name` varchar(50) NOT NULL,
  `ldemail_to_email` varchar(255) NOT NULL,
  `ldemail_from_name` varchar(50) NOT NULL,
  `ldemail_from_email` varchar(250) NOT NULL,
  `ldemail_lead_id` int(11) UNSIGNED DEFAULT '0',
  `ldemail_type` varchar(25) DEFAULT NULL COMMENT 'Type Of Email',
  `ldemail_ref_id` varchar(25) DEFAULT NULL COMMENT 'Reference ID',
  `ldemail_subject` varchar(255) NOT NULL,
  `ldemail_cc` text,
  `ldemail_ccother` text,
  `ldemail_bcc` text,
  `ldemail_content` longtext NOT NULL,
  `ldemail_sign` text,
  `ldemail_use_header_footer` varchar(3) NOT NULL DEFAULT 'Yes',
  `ldemail_datetime` datetime NOT NULL,
  `ldemail_sent` varchar(3) NOT NULL DEFAULT 'No' COMMENT 'Email Sent or Not',
  PRIMARY KEY (`ldemail_id`),
  KEY `ldemail_user_id` (`ldemail_user_id`),
  KEY `ldemail_lead_id` (`ldemail_lead_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `lead_master`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_lead_master` (
  `lead_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lead_type` varchar(100) DEFAULT NULL COMMENT 'RegisterUser, Schedule Showing',
  `lead_user_id` int(10) UNSIGNED DEFAULT '0',
  `lead_agent_id` int(11) NOT NULL DEFAULT '0',
  `lead_employee_id` smallint(6) NOT NULL DEFAULT '0',
  `lead_from_site` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1 - Main, 2 - Agent, 3 - Mobile',
  `lead_first_name` varchar(50) DEFAULT NULL,
  `lead_last_name` varchar(50) DEFAULT NULL,
  `lead_home_phone` varchar(20) DEFAULT NULL,
  `lead_work_phone` varchar(20) DEFAULT NULL,
  `lead_mobile` varchar(20) DEFAULT NULL,
  `lead_email` varchar(255) DEFAULT NULL,
  `lead_comment` text,
  `lead_ListingID_MLS_ID` varchar(30) DEFAULT NULL,
  `lead_listing_Id` varchar(20) DEFAULT NULL,
  `lead_mlsp_id` tinyint(4) DEFAULT '0',
  `lead_listing_type` varchar(30) DEFAULT NULL COMMENT 'Bank Owned /MLS / Pre-Foreclosure',
  `lead_created_by` varchar(20) DEFAULT NULL,
  `lead_created_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`lead_id`),
  KEY `lead_type` (`lead_type`),
  KEY `lead_user_id` (`lead_user_id`),
  KEY `lead_agent_id` (`lead_agent_id`),
  KEY `lead_from_site` (`lead_from_site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `predefined_searches`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_predefined_searches` (
  `psearch_id` int(11) NOT NULL AUTO_INCREMENT,
  `psearch_title` varchar(250) CHARACTER SET utf8 NOT NULL,
  `psearch_criteria` text CHARACTER SET utf8 NOT NULL,
  `psearch_result_limit` varchar(20) DEFAULT '',
  `psearch_tag` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `psearch_added_date` date NOT NULL,
  `psearch_added_by_id` int(10) NOT NULL DEFAULT '1',
  `psearch_added_by_type` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT 'Admin',
  `psearch_sys_name` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`psearch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `send_saved_searches`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_send_saved_searches` (
  `user_usearch_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_search_id` int(11) NOT NULL COMMENT 'search id',
  `user_usearch_criteria` text,
  `sent_email_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Ref. Email Id',
  PRIMARY KEY (`user_usearch_id`),
  KEY `user_search_id` (`user_search_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_favorite_property`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_user_favorite_property` (
  `fav_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fav_user_id` bigint(20) UNSIGNED NOT NULL,
  `fav_mlsp_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `fav_mls_num` varchar(32) NOT NULL,
  `fav_date_time` datetime NOT NULL,
  PRIMARY KEY (`fav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_saved_searches`
--

CREATE TABLE IF NOT EXISTS `wp_lpt_user_saved_searches` (
  `search_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `search_user_id` int(10) UNSIGNED NOT NULL,
  `search_criteria` text NOT NULL,
  `search_resultcount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `search_title` varchar(100) NOT NULL DEFAULT '',
  `search_url` text,
  `search_lastrun` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `search_alert_type` tinyint(1) NOT NULL DEFAULT '0',
  `search_alert_last_sent` int(11) NOT NULL DEFAULT '0' COMMENT 'Last Alert Sent Date',
  `search_send_till_lastupdatedate` varchar(100) NOT NULL COMMENT 'Max date saved from Listing''s LastUpdateDate',
  `search_added_by_id` int(11) NOT NULL DEFAULT '0',
  `search_added_by_type` varchar(10) NOT NULL DEFAULT 'User',
  `search_saved_from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '	( 1 => Site, 2 => App)',
  PRIMARY KEY (`search_id`),
  KEY `search_user_id` (`search_user_id`),
  KEY `search_alert_type` (`search_alert_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Saved Searches Table';

--
-- Table structure for table `agent_profile`
--

CREATE TABLE IF NOT EXISTS `wp_agent_profile`
(
`Agent_Id` tinyint(15) unsigned NOT NULL AUTO_INCREMENT,
  `Agent_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Agent_Email` varchar(255)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Agent_phone` varchar(10),
  `Agent_Photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Agent_Office` varchar(10),

  PRIMARY KEY (`Agent_Id`),
  KEY `Agent_Name` (`Agent_Name`),
  KEY `Agent_Email` (`Agent_Email`),
  KEY `Agent_phone` (`Agent_phone`),
  KEY `Agent_Photo` (`Agent_Photo`),
  KEY `Agent_Office` (`Agent_Office`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8