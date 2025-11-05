ALTER TABLE wp_lpt_predefined_searches ADD COLUMN IF NOT EXISTS `psearch_sys_name` INT(2) NOT NULL DEFAULT '1';

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