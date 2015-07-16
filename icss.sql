/*
 Navicat Premium Data Transfer

 Source Server         : mysql-localhost
 Source Server Type    : MySQL
 Source Server Version : 50625
 Source Host           : localhost
 Source Database       : icss

 Target Server Type    : MySQL
 Target Server Version : 50625
 File Encoding         : utf-8

 Date: 07/16/2015 13:23:11 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `archive_type`
-- ----------------------------
DROP TABLE IF EXISTS `archive_type`;
CREATE TABLE `archive_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `after_apply` tinyint(1) DEFAULT NULL,
  `after_approve` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BCFB81B25E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `archive_type`
-- ----------------------------
BEGIN;
INSERT INTO `archive_type` VALUES ('1', '报告', '1', '0'), ('2', '协议', '0', '1'), ('3', '鉴定书', '0', '1'), ('4', '参观报告', '1', '0');
COMMIT;

-- ----------------------------
--  Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` longtext COLLATE utf8_unicode_ci,
  `update_at` datetime DEFAULT NULL,
  `location` longtext COLLATE utf8_unicode_ci,
  `hidden` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `company_class`
-- ----------------------------
DROP TABLE IF EXISTS `company_class`;
CREATE TABLE `company_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AABABBFA5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `company_with_class`
-- ----------------------------
DROP TABLE IF EXISTS `company_with_class`;
CREATE TABLE `company_with_class` (
  `company_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`company_id`,`class_id`),
  KEY `IDX_FCA3E1B6979B1AD6` (`company_id`),
  KEY `IDX_FCA3E1B6EA000B10` (`class_id`),
  CONSTRAINT `FK_FCA3E1B6979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_FCA3E1B6EA000B10` FOREIGN KEY (`class_id`) REFERENCES `company_class` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `direction`
-- ----------------------------
DROP TABLE IF EXISTS `direction`;
CREATE TABLE `direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3E4AD1B35E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `direction`
-- ----------------------------
BEGIN;
INSERT INTO `direction` VALUES ('1', '未知'), ('4', '媒体艺术与科学'), ('5', '软件工程技术与管理'), ('3', '软件工程理论与平台'), ('2', '领域软件系统');
COMMIT;

-- ----------------------------
--  Table structure for `gender`
-- ----------------------------
DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C7470A425E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `gender`
-- ----------------------------
BEGIN;
INSERT INTO `gender` VALUES ('1', '未知'),('2', '男'),('3', '女');
COMMIT;

-- ----------------------------
--  Table structure for `intern_type`
-- ----------------------------
DROP TABLE IF EXISTS `intern_type`;
CREATE TABLE `intern_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E4A46E935E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `intern_type`
-- ----------------------------
BEGIN;
INSERT INTO `intern_type` VALUES ('1', '参观实习', '1');
COMMIT;

-- ----------------------------
--  Table structure for `intern_types_archives`
-- ----------------------------
DROP TABLE IF EXISTS `intern_types_archives`;
CREATE TABLE `intern_types_archives` (
  `intern_type_id` int(11) NOT NULL,
  `archive_type` int(11) NOT NULL,
  PRIMARY KEY (`intern_type_id`,`archive_type`),
  KEY `IDX_B38AE9B4B3D1E2A5` (`intern_type_id`),
  KEY `IDX_B38AE9B4BCFB81B2` (`archive_type`),
  CONSTRAINT `FK_B38AE9B4B3D1E2A5` FOREIGN KEY (`intern_type_id`) REFERENCES `intern_type` (`id`),
  CONSTRAINT `FK_B38AE9B4BCFB81B2` FOREIGN KEY (`archive_type`) REFERENCES `archive_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `intern_types_archives`
-- ----------------------------
BEGIN;
INSERT INTO `intern_types_archives` VALUES ('1', '4');
COMMIT;

-- ----------------------------
--  Table structure for `intern_types_projects`
-- ----------------------------
DROP TABLE IF EXISTS `intern_types_projects`;
CREATE TABLE `intern_types_projects` (
  `intern_type_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`intern_type_id`,`project_id`),
  KEY `IDX_D7BB629B3D1E2A5` (`intern_type_id`),
  KEY `IDX_D7BB629166D1F9C` (`project_id`),
  CONSTRAINT `FK_D7BB629166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_D7BB629B3D1E2A5` FOREIGN KEY (`intern_type_id`) REFERENCES `intern_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `intern_types_projects`
-- ----------------------------
BEGIN;
INSERT INTO `intern_types_projects` VALUES ('1', '4');
COMMIT;

-- ----------------------------
--  Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2FB3D0EE5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `project`
-- ----------------------------
BEGIN;
INSERT INTO `project` VALUES ('1', '未知'), ('2', '硕士研究生'), ('3', '博士研究生'), ('4', '本科生');
COMMIT;

-- ----------------------------
--  Table structure for `recruit`
-- ----------------------------
DROP TABLE IF EXISTS `recruit`;
CREATE TABLE `recruit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `ended` datetime DEFAULT NULL,
  `intro` longtext COLLATE utf8_unicode_ci,
  `hidden` tinyint(1) DEFAULT NULL,
  `apply_limit` int(11) DEFAULT NULL,
  `visit_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_106B2A6F979B1AD6` (`company_id`),
  CONSTRAINT `FK_106B2A6F979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruit_apply`
-- ----------------------------
DROP TABLE IF EXISTS `recruit_apply`;
CREATE TABLE `recruit_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recruit_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `approved` tinyint(1) DEFAULT NULL,
  `canceled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5C539DB90C13DC5` (`recruit_id`),
  KEY `IDX_B5C539DBCB944F1A` (`student_id`),
  CONSTRAINT `FK_B5C539DB90C13DC5` FOREIGN KEY (`recruit_id`) REFERENCES `recruit` (`id`),
  CONSTRAINT `FK_B5C539DBCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruit_apply_archive`
-- ----------------------------
DROP TABLE IF EXISTS `recruit_apply_archive`;
CREATE TABLE `recruit_apply_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apply_id` int(11) DEFAULT NULL,
  `archive_id` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `archive_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `archive_file` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E3A3E494DDCCBDE` (`apply_id`),
  KEY `IDX_5E3A3E492956195F` (`archive_id`),
  CONSTRAINT `FK_5E3A3E492956195F` FOREIGN KEY (`archive_id`) REFERENCES `archive_type` (`id`),
  CONSTRAINT `FK_5E3A3E494DDCCBDE` FOREIGN KEY (`apply_id`) REFERENCES `recruit_apply` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruit_type`
-- ----------------------------
DROP TABLE IF EXISTS `recruit_type`;
CREATE TABLE `recruit_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B56BE645E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruit_visit`
-- ----------------------------
DROP TABLE IF EXISTS `recruit_visit`;
CREATE TABLE `recruit_visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recruit_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `visit_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B945CFD90C13DC5` (`recruit_id`),
  KEY `IDX_4B945CFDCB944F1A` (`student_id`),
  CONSTRAINT `FK_4B945CFD90C13DC5` FOREIGN KEY (`recruit_id`) REFERENCES `recruit` (`id`),
  CONSTRAINT `FK_4B945CFDCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruits_intern_types`
-- ----------------------------
DROP TABLE IF EXISTS `recruits_intern_types`;
CREATE TABLE `recruits_intern_types` (
  `recruit_id` int(11) NOT NULL,
  `intern_type_id` int(11) NOT NULL,
  PRIMARY KEY (`recruit_id`,`intern_type_id`),
  KEY `IDX_C428782890C13DC5` (`recruit_id`),
  KEY `IDX_C4287828B3D1E2A5` (`intern_type_id`),
  CONSTRAINT `FK_C428782890C13DC5` FOREIGN KEY (`recruit_id`) REFERENCES `recruit` (`id`),
  CONSTRAINT `FK_C4287828B3D1E2A5` FOREIGN KEY (`intern_type_id`) REFERENCES `intern_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruits_projects`
-- ----------------------------
DROP TABLE IF EXISTS `recruits_projects`;
CREATE TABLE `recruits_projects` (
  `recruit_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`recruit_id`,`project_id`),
  KEY `IDX_B7C2C36490C13DC5` (`recruit_id`),
  KEY `IDX_B7C2C364166D1F9C` (`project_id`),
  CONSTRAINT `FK_B7C2C364166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_B7C2C36490C13DC5` FOREIGN KEY (`recruit_id`) REFERENCES `recruit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `recruits_types`
-- ----------------------------
DROP TABLE IF EXISTS `recruits_types`;
CREATE TABLE `recruits_types` (
  `recruit_id` int(11) NOT NULL,
  `recruit_type_id` int(11) NOT NULL,
  PRIMARY KEY (`recruit_id`,`recruit_type_id`),
  KEY `IDX_4714DA5890C13DC5` (`recruit_id`),
  KEY `IDX_4714DA58D1D1D130` (`recruit_type_id`),
  CONSTRAINT `FK_4714DA5890C13DC5` FOREIGN KEY (`recruit_id`) REFERENCES `recruit` (`id`),
  CONSTRAINT `FK_4714DA58D1D1D130` FOREIGN KEY (`recruit_type_id`) REFERENCES `recruit_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_teacher_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `department` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `major` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B723AF334ACC9A20` (`card_id`),
  KEY `IDX_B723AF331F9C1B71` (`mentor_teacher_id`),
  KEY `IDX_B723AF33166D1F9C` (`project_id`),
  KEY `IDX_B723AF33708A0E0` (`gender_id`),
  KEY `IDX_B723AF33AF73D997` (`direction_id`),
  CONSTRAINT `FK_B723AF33166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_B723AF331F9C1B71` FOREIGN KEY (`mentor_teacher_id`) REFERENCES `teacher` (`id`),
  CONSTRAINT `FK_B723AF33708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `FK_B723AF33AF73D997` FOREIGN KEY (`direction_id`) REFERENCES `direction` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `student`
-- ----------------------------
BEGIN;
INSERT INTO `student` VALUES ('1', null, '4', '2', '5', null, 'ROLE_STUDENT,ROLE_ADMIN', '1352978', '施闻轩', '2013', '软件学院', '软件工程', '310107199508133431', null, null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `teacher`
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B0F6A6D54ACC9A20` (`card_id`),
  KEY `IDX_B0F6A6D5708A0E0` (`gender_id`),
  CONSTRAINT `FK_B0F6A6D5708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', null, 'ROLE_USER', 'root', '7eb456934fd4e3b2ef64870a7e3920dc94f05557caf93700df00851dc724b893', '27262e982b280445723112153b5ff716fff157dcca474ec569e727dfe81ec480');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
