/* Master tables */
DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone_value` float(3,1) NOT NULL DEFAULT '0.0',
  `timezone_text` varchar(100) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `educations`;
CREATE TABLE IF NOT EXISTS `educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_name` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `certifications`;
CREATE TABLE IF NOT EXISTS `certifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `nationalities`;
CREATE TABLE IF NOT EXISTS `nationalities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3),
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `symbol_left` varchar(12),
  `symbol_right` varchar(12),
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `pay_grades`;
CREATE TABLE IF NOT EXISTS `pay_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id`	int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `min_salary` decimal(12,2),
  `max_salary`	decimal(12,2),
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employment_types`;
CREATE TABLE IF NOT EXISTS `employment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `job_titles`;
CREATE TABLE IF NOT EXISTS `job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar (20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `specification` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `recruitment_status`;
CREATE TABLE IF NOT EXISTS `recruitment_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT 'Application Init: 1, SHORTLIST: 2, REJECT: 3, SCHEDULE_INTERVIEW: 4, INTERVIEW_PASSED: 5, INTERVIEW_FAILED: 6, OFFER_JOB: 7, DECISION_OFFER: 8, HIRE: 9, SCHEDULE_2ND_INTERVIEW: 10',
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `organization_types`;
CREATE TABLE IF NOT EXISTS `organization_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `organization_structures`;
CREATE TABLE IF NOT EXISTS `organization_structures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `address` text DEFAULT '',
  `organization_type_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `organization_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0: Root',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `company_infos`;
CREATE TABLE IF NOT EXISTS `company_infos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tax_code` varchar(30) DEFAULT NULL,
  `registration_number` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip_code` varchar(30) DEFAULT NULL,
  `street1` varchar(100) DEFAULT NULL,
  `street2` varchar(100) DEFAULT NULL,
  `logo` varchar(30) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `marriages`;
CREATE TABLE IF NOT EXISTS `marriages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `dependents`;
CREATE TABLE IF NOT EXISTS `dependents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `pay_frequencies`;
CREATE TABLE IF NOT EXISTS `pay_frequencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 PACK_KEYS=0;

/* Transaction Tables*/
DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
	`company_id` int(11) NOT NULL DEFAULT '0',
	`employee_number` int(7) NOT NULL DEFAULT '0',
	`employee_code` varchar(50) DEFAULT NULL,
	`first_name` varchar(100) NOT NULL DEFAULT '',
	`middle_name` varchar(100) DEFAULT '',
	`last_name` varchar(100) NOT NULL DEFAULT '',
	`nationality_id` int(11) NOT NULL DEFAULT '0',
	`nic_no` varchar(50) DEFAULT NULL COMMENT 'National Identify Card',
	`sin_no` varchar(50) DEFAULT NULL COMMENT 'Social Insurance Number',
	`ssn_no` varchar(50) DEFAULT NULL COMMENT 'Social Security Number, NIRC: National Registration Identification Card Number',
	`other_id_no` varchar(50) DEFAULT NULL COMMENT 'Other ID number',
	`driver_license_num` varchar(100) DEFAULT '',
	`driver_license_exp_date` date DEFAULT NULL,
	`military_service` varchar(100) DEFAULT '',

	`nick_name` varchar(100) DEFAULT '',
	`gender_id` int(11) NOT NULL DEFAULT '1',
	`marriage_id` int(11) NOT NULL DEFAULT '0',
	`birthday` date,
	`smoker` tinyint(1) unsigned DEFAULT 0,

	`employee_type_id` int(11) NOT NULL DEFAULT '0',
	`job_title_id` int(11) NOT NULL DEFAULT '0',
	`eeo_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Equal Employment Opportunity Category',
	`pay_grade_id` int(11) NOT NULL DEFAULT '0',
	`work_station` int(6) DEFAULT NULL,
	`joined_date` date,
	`terminal_reason_id` int(4) DEFAULT NULL,
	`terminal_date` date,
	`ip` varchar(20) NOT NULL DEFAULT '',

	`street1` varchar(100) DEFAULT '',
	`street2` varchar(100) DEFAULT '',
	`country_id` int(11) NOT NULL DEFAULT '0',
	`state_id` int(11) NOT NULL DEFAULT '0',
	`city` varchar(255) DEFAULT NULL,
	`zip_code` varchar(20) DEFAULT NULL,
	`home_phone` varchar(20) DEFAULT NULL,
	`mobile_phone` varchar(20) DEFAULT NULL,
	`work_phone` varchar(20) DEFAULT NULL,
	`work_email` varchar(100) DEFAULT NULL,
	`other_email` varchar(100) DEFAULT NULL,
	`note` varchar(500) DEFAULT '',

	`department` int(11) NOT NULL DEFAULT '0' COMMENT 'This is an organization_structure_id',
	`supervisor` int(11) NOT NULL DEFAULT '0' COMMENT 'This is an employee_id',

	`created_at` datetime DEFAULT '0000-00-00 00:00:00',
	`created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`updated_at` datetime DEFAULT '0000-00-00 00:00:00',
	`updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
	`deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`deleted_flg` tinyint(1) unsigned DEFAULT 0,
	`published` tinyint(1) NOT NULL DEFAULT '1',
	`custom1` varchar(250) DEFAULT NULL,
	`custom2` varchar(250) DEFAULT NULL,
	`custom3` varchar(250) DEFAULT NULL,
	`custom4` varchar(250) DEFAULT NULL,
	`custom5` varchar(250) DEFAULT NULL,
	`custom6` varchar(250) DEFAULT NULL,
	`custom7` varchar(250) DEFAULT NULL,
	`custom8` varchar(250) DEFAULT NULL,
	`custom9` varchar(250) DEFAULT NULL,
	`custom10` varchar(250) DEFAULT NULL,

	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_skills`;
CREATE TABLE IF NOT EXISTS `employee_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `skill_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to skill id',
  `year_of_exp` int(2) DEFAULT 0 COMMENT 'Amount of year experience',
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_media`;
CREATE TABLE IF NOT EXISTS `employee_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) COMMENT 'Reference to employee_id. Null: in case only take media (ex: document)',
  `media_type` varchar(50) COMMENT 'Type of media: picture, document',
  `data` MEDIUMBLOB NULL COMMENT 'Data of media only for picture',
  `file_path` varchar(150) COMMENT 'File path of media on server',
  `file_name` varchar(100) COMMENT 'File name of media',
  `file_origin_name` varchar(100) COMMENT 'Original file name of media',
  `file_size` int(10) COMMENT 'File size of picture',
  `file_mime_type` varchar(20) COMMENT 'File type of media: with picture: jpg/png',
  `file_extension` varchar(20) COMMENT 'extension',
  `width` int(5) COMMENT 'File width only for picture',
  `height` int(5) COMMENT 'File height only for picture',
  `thumb_width` varchar(20) COMMENT 'File thumb width only for picture',
  `thumb_height` varchar(20) COMMENT 'File thumb height only for picture',
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_languages`;
CREATE TABLE IF NOT EXISTS `employee_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `language_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to language id',
  `reading` varchar(100) NULL COMMENT 'Elementary Proficiency,Limited Working Proficiency,Professional Working Proficiency,Full Professional Proficiency,Native or Bilingual Proficiency',
  `speaking` varchar(100) COMMENT 'Elementary Proficiency,Limited Working Proficiency,Professional Working Proficiency,Full Professional Proficiency,Native or Bilingual Proficiency',
  `writing` varchar(100) COMMENT 'Elementary Proficiency,Limited Working Proficiency,Professional Working Proficiency,Full Professional Proficiency,Native or Bilingual Proficiency',
  `understanding` varchar(100) COMMENT 'Elementary Proficiency,Limited Working Proficiency,Professional Working Proficiency,Full Professional Proficiency,Native or Bilingual Proficiency',
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_education`;
CREATE TABLE IF NOT EXISTS `employee_education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `education_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to education id',
  `institute` varchar(400) NULL COMMENT 'Institute detail info',
  `start_date` date,
  `end_date` date,
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_certifications`;
CREATE TABLE IF NOT EXISTS `employee_certifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `certification_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to certification id',
  `institute` varchar(400) NULL COMMENT 'Institute detail info',
  `start_date` date,
  `end_date` date,
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_experiences`;
CREATE TABLE IF NOT EXISTS `employee_experiences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `company_name` varchar(100) DEFAULT '' COMMENT 'Company name that worked for',
  `job_title` varchar(100) DEFAULT '' COMMENT 'Position at the company',
  `start_date` date,
  `end_date` date,
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_salaries`;
CREATE TABLE IF NOT EXISTS `employee_salaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `pay_frequency_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to pay frequency id',
  `currency_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to currency id',
  `amount` decimal(10,2) DEFAULT '0.0',
  `detail` text DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_emergency_contacts`;
CREATE TABLE IF NOT EXISTS `employee_emergency_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Name of contact',
  `relationship` varchar(100) NOT NULL DEFAULT '',
  `home_phone` varchar(15) DEFAULT '',
  `work_phone` varchar(15) DEFAULT '',
  `mobile_phone` varchar(15) DEFAULT '',
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `employee_dependents`;
CREATE TABLE IF NOT EXISTS `employee_dependents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Name of contact',
  `dependent_id` int(11) NOT NULL DEFAULT '0',
  `birthday` date,
  `note` varchar(100) DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

------ This is part for Recruitment ------
DROP TABLE IF EXISTS `recruit_vacancies`;
CREATE TABLE IF NOT EXISTS `recruit_vacancies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `job_title_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to job title id',
  `hiring_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id (HR manager)',
  `contact_person_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to employee id (HR officer)',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Name of vacancy',
  `amount` int(4) DEFAULT '1' COMMENT 'Amount of contact to candidate',
  `description` text DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0 COMMENT 'Never delete physical vacancy, only delete logical by update delete flag to 1',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `recruit_vacancy_attachments`;
CREATE TABLE IF NOT EXISTS `recruit_vacancy_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `vacancy_id` int(11) NOT NULL COMMENT 'Reference to vacancy id',
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(200) DEFAULT NULL,
  `file_size` int(11) NOT NULL,
  `file_content` mediumblob,
  `attachment_type` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_vacancy_id` (`vacancy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `recruit_candidates`;
CREATE TABLE IF NOT EXISTS `recruit_candidates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
	`first_name` varchar(100) NOT NULL DEFAULT '',
	`middle_name` varchar(100) DEFAULT '',
	`last_name` varchar(100) NOT NULL DEFAULT '',
	`nationality_id` int(11) NOT NULL DEFAULT '0',
	`work_email` varchar(100) DEFAULT NULL,
	`other_email` varchar(100) DEFAULT NULL,
	`contact_number` varchar(30) COMMENT 'Number of contact',
	`recruitment_status_id` int(11) DEFAULT '1' COMMENT 'Refer to recruitment id. Store current status(last status)',
	`application_way` int(11) NOT NULL DEFAULT '1' COMMENT 'Normal: 1, Online: 2, Employee Introduction: 3, Other: 4',
	`keywords` varchar(255) DEFAULT '',
	`application_date` date,
	`comment` text DEFAULT '',
	`created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Person add the candidate',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `recruit_candidate_attachments`;
CREATE TABLE IF NOT EXISTS `recruit_candidate_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `candidate_id` int(11) NOT NULL COMMENT 'Reference to candidate id',
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(200) DEFAULT NULL,
  `file_size` int(11) NOT NULL,
  `file_content` mediumblob,
  `attachment_type` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_candidate_id` (`candidate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `recruit_candidate_histories`;
CREATE TABLE IF NOT EXISTS `recruit_candidate_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to candidate id',
  `vacancy_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to vacancy id',
  `interview_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Reference to interview id',
  `recruitment_status_id` int(11) DEFAULT '1' COMMENT 'Refer to recruitment id',
  `note` text DEFAULT '',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Person add the candidate',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_flg` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_candidate_id` (`candidate_id`),
  KEY `idx_vacancy_id` (`vacancy_id`),
  KEY `idx_interview_id` (`interview_id`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_updated_by` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `recruit_candidates_vacancies` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `candidate_id` int(11) NOT NULL COMMENT 'Reference to candidate id',
  `vacancy_id` int(11) NOT NULL COMMENT 'Reference to vacancy id',
  PRIMARY KEY (`id`),
  KEY `idx_candidate_id` (`candidate_id`),
  KEY `idx_vacancy_id` (`vacancy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
------ This is part for Recruitment ------