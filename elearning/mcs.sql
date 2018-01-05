/*
Navicat MySQL Data Transfer

Source Server         : Divine Developers
Source Server Version : 50133
Source Host           : localhost:3306
Source Database       : mcs

Target Server Type    : MYSQL
Target Server Version : 50133
File Encoding         : 65001

Date: 2014-01-02 22:04:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `audit_tray`
-- ----------------------------
DROP TABLE IF EXISTS `audit_tray`;
CREATE TABLE `audit_tray` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `operation` varchar(400) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `login` varchar(111) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of audit_tray
-- ----------------------------
INSERT INTO `audit_tray` VALUES ('1', 'admin', 'Logged Out', '01/01/2014-01:01:50', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('2', 'admin', 'Logged In', '01/01/2014-01:01:10', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('3', 'admin', 'Logged Out', '01/01/2014-01:01:12', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('4', 'admin', 'Logged In', '01/01/2014-01:01:30', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('5', 'admin', 'Logged Out', '01/01/2014-01:01:11', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('6', '7777', 'Logged In', '01/01/2014-01:01:21', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('7', '7777', 'Logged Out', '01/01/2014-02:01:52', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('8', 'head', 'Logged In', '01/01/2014-02:01:58', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('9', 'head', 'Logged Out', '01/01/2014-04:01:51', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('10', 'MCS145357E', 'Logged In', '01/01/2014-04:01:38', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('11', '', 'Logged Out', '01/01/2014-04:01:54', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('12', 'head', 'Logged In', '01/01/2014-04:01:59', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('13', 'head', 'Logged Out', '01/01/2014-04:01:09', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('14', 'MCS145357E', 'Logged In', '01/01/2014-04:01:17', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('15', '', 'Logged Out', '01/01/2014-04:01:02', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('16', 'head', 'Logged In', '01/01/2014-04:01:12', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('17', 'head', 'Logged Out', '01/01/2014-04:01:23', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('18', 'admin', 'Logged In', '01/01/2014-04:01:42', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('19', 'admin', 'Logged Out', '01/01/2014-04:01:39', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('20', 'MCS144634D', 'Logged In', '01/01/2014-04:01:10', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('21', '', 'Logged Out', '01/01/2014-04:01:16', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('22', '7771', 'Logged In', '01/01/2014-04:01:27', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('23', '7771', 'Logged Out', '01/01/2014-04:01:30', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('24', '7771', 'Logged In', '01/01/2014-04:01:39', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('25', 'head', 'Logged Out', '01/01/2014-05:01:07', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('26', '7777', 'Logged In', '01/01/2014-05:01:18', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('27', '7771', 'Logged Out', '01/01/2014-05:01:29', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('28', 'head', 'Logged In', '01/01/2014-05:01:38', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('29', 'head', 'Logged Out', '01/01/2014-05:01:19', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('30', 'head', 'Logged In', '01/01/2014-05:01:26', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('31', '7777', 'Logged Out', '01/01/2014-05:01:42', '01/01/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('32', '7771', 'Logged In', '01/01/2014-05:01:01', '01/01/2014', 'login');
INSERT INTO `audit_tray` VALUES ('33', 'head', 'Logged In', '01/02/2014-03:01:41', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('34', 'head', 'Logged Out', '01/02/2014-03:01:57', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('35', '7771', 'Logged In', '01/02/2014-03:01:05', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('36', '7771', 'Logged Out', '01/02/2014-07:01:22', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('37', '7777', 'Logged In', '01/02/2014-07:01:38', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('38', 'head', 'Logged In', '01/02/2014-08:01:36', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('39', 'head', 'Logged Out', '01/02/2014-09:01:06', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('40', '7771', 'Logged In', '01/02/2014-09:01:12', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('41', '7777', 'Logged Out', '01/02/2014-09:01:09', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('42', 'head', 'Logged In', '01/02/2014-09:01:20', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('43', 'head', 'Logged Out', '01/02/2014-09:01:11', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('44', 'MCS144634D', 'Logged In', '01/02/2014-09:01:55', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('45', '', 'Logged Out', '01/02/2014-09:01:07', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('46', 'head', 'Logged In', '01/02/2014-10:01:21', '01/02/2014', 'login');
INSERT INTO `audit_tray` VALUES ('47', 'head', 'Logged Out', '01/02/2014-10:01:16', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('48', '7771', 'Logged Out', '01/02/2014-10:01:41', '01/02/2014', 'logout');
INSERT INTO `audit_tray` VALUES ('49', '', 'Logged Out', '01/02/2014-10:01:13', '01/02/2014', 'logout');

-- ----------------------------
-- Table structure for `average`
-- ----------------------------
DROP TABLE IF EXISTS `average`;
CREATE TABLE `average` (
  `student` varchar(111) NOT NULL,
  `average` varchar(111) NOT NULL,
  `grade` varchar(111) NOT NULL,
  `class` varchar(111) NOT NULL,
  `subject_id` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `id` int(111) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of average
-- ----------------------------
INSERT INTO `average` VALUES ('MCS145357E', '99', '7', 'A', 'maths', '2014', '3', '1');
INSERT INTO `average` VALUES ('MCS145357E', '97.17', '7', 'A', 'english', '2014', '3', '2');
INSERT INTO `average` VALUES ('MCS145357E', '99', '7', 'A', 'shona', '2014', '3', '3');
INSERT INTO `average` VALUES ('MCS144634D', '46.6', '7', 'B', 'maths', '2014', '3', '4');
INSERT INTO `average` VALUES ('MCS144634D', '1', '7', 'B', 'english', '2014', '3', '5');
INSERT INTO `average` VALUES ('MCS144634D', '98', '7', 'B', 'shona', '2014', '3', '6');
INSERT INTO `average` VALUES ('MCS138178I', '0', '', '', 'maths', '', '', '7');
INSERT INTO `average` VALUES ('MCS138178I', '0', '', '', 'english', '', '', '8');
INSERT INTO `average` VALUES ('MCS138178I', '0', '', '', 'shona', '', '', '9');

-- ----------------------------
-- Table structure for `class`
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `name` varchar(55) NOT NULL,
  `level` varchar(55) NOT NULL,
  `teacher` varchar(55) NOT NULL,
  `date` varchar(55) NOT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('A', '7', '7777', '01/01/2014', '1');
INSERT INTO `class` VALUES ('B', '7', '7771', '01/01/2014', '2');

-- ----------------------------
-- Table structure for `correct`
-- ----------------------------
DROP TABLE IF EXISTS `correct`;
CREATE TABLE `correct` (
  `ecnumber` varchar(111) NOT NULL,
  `student` varchar(111) NOT NULL,
  `remark` varchar(1555) NOT NULL,
  `subject_id` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `idc` int(111) NOT NULL AUTO_INCREMENT,
  `date` varchar(111) NOT NULL,
  `status` varchar(111) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`idc`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of correct
-- ----------------------------
INSERT INTO `correct` VALUES ('7777', 'MCS145357E', 'iwe chari wakadhakkwa', 'HEAD', '2014', '3', '1', '01/01/2014', 'corrected');
INSERT INTO `correct` VALUES ('7777', 'MCS145357E', 'haya wadi koiwe', 'HEAD', '2014', '3', '2', '01/01/2014', 'pending');
INSERT INTO `correct` VALUES ('7771', 'MCS144634D', 'iweeeee\r\n\r\n', 'HEAD', '2014', '3', '3', '01/01/2014', 'pending');
INSERT INTO `correct` VALUES ('7771', 'MCS144634D', 'newe wo', 'HEAD', '2014', '3', '4', '01/01/2014', 'pending');

-- ----------------------------
-- Table structure for `cw`
-- ----------------------------
DROP TABLE IF EXISTS `cw`;
CREATE TABLE `cw` (
  `reg` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `subject_id` varchar(255) DEFAULT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cw
-- ----------------------------

-- ----------------------------
-- Table structure for `expire`
-- ----------------------------
DROP TABLE IF EXISTS `expire`;
CREATE TABLE `expire` (
  `expiredate` varchar(111) NOT NULL,
  `setdate` varchar(111) NOT NULL,
  `length` varchar(111) NOT NULL,
  `id` int(111) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of expire
-- ----------------------------
INSERT INTO `expire` VALUES ('01/11/2014', '01/01/2014', '11', '1');

-- ----------------------------
-- Table structure for `expire_tray`
-- ----------------------------
DROP TABLE IF EXISTS `expire_tray`;
CREATE TABLE `expire_tray` (
  `username` varchar(111) NOT NULL,
  `expiredate` varchar(111) NOT NULL,
  `setdate` varchar(111) NOT NULL,
  `length` varchar(111) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of expire_tray
-- ----------------------------

-- ----------------------------
-- Table structure for `final`
-- ----------------------------
DROP TABLE IF EXISTS `final`;
CREATE TABLE `final` (
  `ecnumber` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `year` varchar(111) NOT NULL,
  `date` varchar(111) NOT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of final
-- ----------------------------
INSERT INTO `final` VALUES ('7777', '3', '2014', '01/01/2014-02:01:37', '2');
INSERT INTO `final` VALUES ('7771', '3', '2014', '01/01/2014-05:01:25', '3');

-- ----------------------------
-- Table structure for `remarks`
-- ----------------------------
DROP TABLE IF EXISTS `remarks`;
CREATE TABLE `remarks` (
  `student` varchar(111) NOT NULL,
  `remark` varchar(1555) NOT NULL,
  `subject_id` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `term` varchar(111) NOT NULL,
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `date` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of remarks
-- ----------------------------
INSERT INTO `remarks` VALUES ('MCS145357E', 'Wendy you are a star keep it up', 'maths', '2014', '3', '1', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'Wendy you are a star weenglish', 'english', '2014', '3', '2', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'pull up you socks', 'content', '2014', '3', '3', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'shona wakugona wendy', 'shona', '2014', '3', '4', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'Right click always do not copy and [paste . its bad ask me and i will tell you  its bad. really bad', 'Computers', '2014', '3', '5', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'haya', 'Art_Craft', '2014', '3', '6', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'she is a good batsman', 'Extra_Mural_Actvites', '2014', '3', '7', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'wakapenga wendy', 'OVERALL', '2014', '3', '8', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS145357E', 'sure wakapenga wendy keep it up', 'HEAD', '2014', '3', '9', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'jldsjsjcxz', 'shona', '2014', '3', '10', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'kjszx', 'Computers', '2014', '3', '11', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'uridofo ', 'maths', '2014', '3', '12', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'tawanda shaaa read a novel,or somethg', 'english', '2014', '3', '13', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'hesvy', 'content', '2014', '3', '14', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'ckhxk', 'Art_Craft', '2014', '3', '15', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'skdhzxjx ', 'Extra_Mural_Actvites', '2014', '3', '16', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'kjxhkh cx', 'OVERALL', '2014', '3', '17', '01/01/2014');
INSERT INTO `remarks` VALUES ('MCS144634D', 'wakapusa', 'HEAD', '2014', '3', '18', '01/01/2014');

-- ----------------------------
-- Table structure for `reports`
-- ----------------------------
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `report` varchar(255) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `reg` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(111) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reports
-- ----------------------------

-- ----------------------------
-- Table structure for `results`
-- ----------------------------
DROP TABLE IF EXISTS `results`;
CREATE TABLE `results` (
  `reg` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `effort` varchar(255) DEFAULT NULL,
  `mark` varchar(255) DEFAULT NULL,
  `subject_id` varchar(255) DEFAULT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `open` varchar(255) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `class` varchar(55) DEFAULT NULL,
  `level` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of results
-- ----------------------------
INSERT INTO `results` VALUES ('MCS145357E', 'Mechanical', 'A', '99', 'maths', '1', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Mental', 'A', '99', 'maths', '2', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Problems', 'A', '99', 'maths', '3', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Test1', 'A', '99', 'maths', '4', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Test2', 'A', '99', 'maths', '5', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Spelling', 'A', '99', 'english', '6', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Dictation', 'A', '88', 'english', '7', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Language', 'A', '99', 'english', '8', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Comprehension', 'A', '99', 'english', '9', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Test1', 'A', '99', 'english', '10', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Test2', 'A', '99', 'english', '11', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Writting', 'A', 'A', 'english', '12', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Reading', 'A', 'A', 'english', '13', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Hand_writting', 'D', 'D', 'english', '14', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Scripture', 'D', 'D', 'content', '15', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Science', 'D', 'D', 'content', '16', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Social_studies', 'C', 'C', 'content', '17', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Shona', 'A', '99', 'other', '18', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Computers', 'A', 'A', 'other', '19', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Art_Craft', 'A', 'A', 'other', '20', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'Extra_Mural_Actvites', 'A', 'A', 'other', '21', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Average', '6', 'Follows Directions', '22', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Very Good', '10', 'Strives to Improve', '23', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Good', '8', 'Works Independently', '24', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Very Good', '10', 'Makes good use of Time', '25', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Good', '8', 'Ability to concentrate', '26', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'habits', 'Very Good', '10', 'Homework', '27', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Very Good', '10', 'Co-operates with Others', '28', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Very Good', '10', 'Self Confidence', '29', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Average', '6', 'Attitude to School', '30', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Very Good', '10', 'School Behaviour', '31', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Very Good', '10', 'Leadership/Initiative', '32', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS145357E', 'social', 'Very Good', '10', 'Care of Property', '33', 'no', '2014', '3', 'A', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Mechanical', 'A', '99', 'maths', '36', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Computers', 'C', 'C', 'other', '35', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Shona', 'A', '98', 'other', '34', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Mental', 'U', '33', 'maths', '37', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Problems', 'A', '99', 'maths', '38', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Test2', 'U', '1', 'maths', '39', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Test1', 'U', '1', 'maths', '40', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Hand_writting', 'A', 'A', 'english', '41', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Reading', 'A', 'A', 'english', '42', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Spelling', 'U', '1', 'english', '43', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Dictation', 'U', '1', 'english', '44', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Language', 'U', '1', 'english', '45', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Comprehension', 'U', '1', 'english', '46', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Test1', 'U', '1', 'english', '47', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Test2', 'U', '1', 'english', '48', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Writting', 'A', 'A', 'english', '49', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Scripture', 'A', 'A', 'content', '50', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Science', 'A', 'A', 'content', '51', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Social_studies', 'A', 'A', 'content', '52', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Art_Craft', 'A', 'A', 'other', '53', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'Extra_Mural_Actvites', 'A', 'A', 'other', '54', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Follows Directions', '55', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Strives to Improve', '56', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Works Independently', '57', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Makes good use of Time', '58', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Ability to concentrate', '59', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'habits', 'Very Good', '10', 'Homework', '60', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Good', '10', 'Co-operates with Others', '61', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Poor', '2', 'Self Confidence', '62', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Good', '10', 'Attitude to School', '63', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Good', '10', 'School Behaviour', '64', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Poor', '2', 'Leadership/Initiative', '65', 'no', '2014', '3', 'B', '7');
INSERT INTO `results` VALUES ('MCS144634D', 'social', 'Very Good', '10', 'Care of Property', '66', 'no', '2014', '3', 'B', '7');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `reg` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `suspend` int(255) DEFAULT '1',
  `dates` varchar(66) DEFAULT NULL,
  `picture` varchar(77) DEFAULT NULL,
  `status` varchar(111) DEFAULT 'ENROLLED',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('MCS145357E', 'Wendy', 'Tabeni', '1134 Mkoba 12 Gweru', 'wndy@ymcmb.com', '0773928332', 'female', '1/1/1997', '1', 'password', '1', '01/01/2014', '13885767501378260_677086392302153_1248999509_n.jpg', 'ENROLLED');
INSERT INTO `student` VALUES ('MCS144634D', 'Tawanda', 'Marime', '734 Jacaranda street  Kopje Gweru', 'wndy@ymcmb.com', '0773928332', 'male', '1/1/1997', '2', 'password', '1', '01/01/2014', '1388586431316882_250063195049976_1732407640_n.jpg', 'ENROLLED');

-- ----------------------------
-- Table structure for `student_class`
-- ----------------------------
DROP TABLE IF EXISTS `student_class`;
CREATE TABLE `student_class` (
  `level` varchar(111) NOT NULL,
  `class` varchar(111) NOT NULL,
  `session` varchar(111) NOT NULL,
  `student` varchar(111) NOT NULL,
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `shona` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of student_class
-- ----------------------------
INSERT INTO `student_class` VALUES ('7', 'A', '2014', 'MCS145357E', '1', 'L 1');
INSERT INTO `student_class` VALUES ('7', 'B', '2014', 'MCS144634D', '2', 'L 1');

-- ----------------------------
-- Table structure for `subjects`
-- ----------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `subject` varchar(55) NOT NULL,
  `type` varchar(55) NOT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of subjects
-- ----------------------------
INSERT INTO `subjects` VALUES ('maths', 'Mechanical', '1');
INSERT INTO `subjects` VALUES ('maths', 'Mental', '2');
INSERT INTO `subjects` VALUES ('maths', 'Problems', '3');
INSERT INTO `subjects` VALUES ('maths', 'Test1', '4');
INSERT INTO `subjects` VALUES ('maths', 'Test2', '5');
INSERT INTO `subjects` VALUES ('english', 'Spelling', '6');
INSERT INTO `subjects` VALUES ('english', 'Dictation', '7');
INSERT INTO `subjects` VALUES ('english', 'Language', '8');
INSERT INTO `subjects` VALUES ('english', 'Comprehension', '9');
INSERT INTO `subjects` VALUES ('english', 'Writting', '10');
INSERT INTO `subjects` VALUES ('english', 'Reading', '11');
INSERT INTO `subjects` VALUES ('english', 'Hand_writting', '12');
INSERT INTO `subjects` VALUES ('english', 'Test1', '13');
INSERT INTO `subjects` VALUES ('english', 'Test2', '14');
INSERT INTO `subjects` VALUES ('content', 'Scripture', '15');
INSERT INTO `subjects` VALUES ('content', 'Science', '16');
INSERT INTO `subjects` VALUES ('content', 'Social_studies', '17');
INSERT INTO `subjects` VALUES ('other', 'Shona', '18');
INSERT INTO `subjects` VALUES ('other', 'Computers', '19');
INSERT INTO `subjects` VALUES ('other', 'Art_Craft', '20');
INSERT INTO `subjects` VALUES ('other', 'Extra_Mural_Actvites', '21');

-- ----------------------------
-- Table structure for `term`
-- ----------------------------
DROP TABLE IF EXISTS `term`;
CREATE TABLE `term` (
  `term` varchar(111) NOT NULL,
  PRIMARY KEY (`term`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of term
-- ----------------------------
INSERT INTO `term` VALUES ('3');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `namee` varchar(40) DEFAULT NULL,
  `surname` varchar(40) DEFAULT NULL,
  `sex` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `idnumber` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `access` varchar(30) DEFAULT NULL,
  `suspend` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'Ernest', 'Muroiwa', null, null, null, 'admin', 'admin', null, '1', null, '1', '1');
INSERT INTO `users` VALUES ('14', 'Mervyn', 'Jutha', 'Male', 'merve@mcs.ac.zw', 'Long Road New Christmas Gift Gweru', 'head', 'password', '11-22222233-A-33', '1', '12/31/2013', '2', '1');
INSERT INTO `users` VALUES ('15', 'William', 'Chari', 'Male', 'emuroiwa@gmail.com', '41 Grays rd Ridgemont Gweru', '7777', 'password', '11-32982834-B-23', '1', '01/01/2014', '3', '1');
INSERT INTO `users` VALUES ('16', 'Terence', 'Mubayiwa', 'Male', 'emuroiwa@gmail.com', '8237 Mkoba1 Gweru', '7771', 'password', '11-22222221-A-12', '1', '01/01/2014', '3', '1');
