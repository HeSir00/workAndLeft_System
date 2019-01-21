/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hesir_workandlife

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-21 17:40:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `h_blog_article`
-- ----------------------------
DROP TABLE IF EXISTS `h_blog_article`;
CREATE TABLE `h_blog_article` (
  `blog_article_id` int(50) NOT NULL AUTO_INCREMENT,
  `blog_article_title` varchar(255) DEFAULT NULL,
  `blog_mark_id` varchar(100) NOT NULL,
  `blog_cate_id` int(50) NOT NULL,
  `blog_folder_id` int(50) NOT NULL,
  `blog_article_time` int(50) DEFAULT NULL,
  `blog_article_view` int(50) DEFAULT '0',
  `blog_article_md` varchar(255) DEFAULT NULL,
  `blog_article_html` varchar(255) DEFAULT NULL,
  `blog_article_state` int(1) NOT NULL,
  `blog_article_comment` varchar(255) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`blog_article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_blog_article
-- ----------------------------
INSERT INTO `h_blog_article` VALUES ('7', '这是文章111', '4', '2', '2', '1547778315', '0', ' ## hesir\n```\n function*(){P\n}\n```', '<h2><a id=\"hesir_0\"></a>hesir</h2>\n<pre><code class=\"lang-\"> function*(){P\n}\n</code></pre>\n', '1', null, '5');

-- ----------------------------
-- Table structure for `h_blog_cate`
-- ----------------------------
DROP TABLE IF EXISTS `h_blog_cate`;
CREATE TABLE `h_blog_cate` (
  `blog_cate_id` int(50) NOT NULL AUTO_INCREMENT,
  `blog_cate_name` varchar(255) DEFAULT NULL,
  `blog_cate_icon` varchar(255) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`blog_cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_blog_cate
-- ----------------------------
INSERT INTO `h_blog_cate` VALUES ('1', 'nodeJs', null, '5');
INSERT INTO `h_blog_cate` VALUES ('2', '1234123', null, '5');
INSERT INTO `h_blog_cate` VALUES ('5', '111', './static/upload/20190117/1547693982.jpeg', '5');

-- ----------------------------
-- Table structure for `h_blog_folder`
-- ----------------------------
DROP TABLE IF EXISTS `h_blog_folder`;
CREATE TABLE `h_blog_folder` (
  `blog_folder_id` int(50) NOT NULL AUTO_INCREMENT,
  `blog_folder_name` varchar(255) DEFAULT NULL,
  `blog_folder_time` int(15) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`blog_folder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_blog_folder
-- ----------------------------
INSERT INTO `h_blog_folder` VALUES ('3', 'nodejs1', '1547694778', '5');
INSERT INTO `h_blog_folder` VALUES ('2', 'js', '1547694771', '5');

-- ----------------------------
-- Table structure for `h_blog_mark`
-- ----------------------------
DROP TABLE IF EXISTS `h_blog_mark`;
CREATE TABLE `h_blog_mark` (
  `blog_mark_id` int(50) NOT NULL AUTO_INCREMENT,
  `blog_mark_name` varchar(255) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`blog_mark_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_blog_mark
-- ----------------------------
INSERT INTO `h_blog_mark` VALUES ('3', '标签', '5');
INSERT INTO `h_blog_mark` VALUES ('2', 'mark', '5');
INSERT INTO `h_blog_mark` VALUES ('4', '123', '5');

-- ----------------------------
-- Table structure for `h_difficult_cate`
-- ----------------------------
DROP TABLE IF EXISTS `h_difficult_cate`;
CREATE TABLE `h_difficult_cate` (
  `difficult_cate_id` int(50) NOT NULL AUTO_INCREMENT,
  `difficult_cate_name` varchar(255) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`difficult_cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_difficult_cate
-- ----------------------------
INSERT INTO `h_difficult_cate` VALUES ('1', 'add1', '5');
INSERT INTO `h_difficult_cate` VALUES ('5', 'node', '5');
INSERT INTO `h_difficult_cate` VALUES ('6', '132', '5');
INSERT INTO `h_difficult_cate` VALUES ('7', '132123123', '5');
INSERT INTO `h_difficult_cate` VALUES ('8', '1其实对方', '5');
INSERT INTO `h_difficult_cate` VALUES ('9', '1其实对方1', '5');
INSERT INTO `h_difficult_cate` VALUES ('10', '1其实2', '5');
INSERT INTO `h_difficult_cate` VALUES ('11', '1其4', '5');
INSERT INTO `h_difficult_cate` VALUES ('12', '1其123', '5');
INSERT INTO `h_difficult_cate` VALUES ('13', '1其123123', '5');
INSERT INTO `h_difficult_cate` VALUES ('14', '1其123123123133', '5');

-- ----------------------------
-- Table structure for `h_difficult_content`
-- ----------------------------
DROP TABLE IF EXISTS `h_difficult_content`;
CREATE TABLE `h_difficult_content` (
  `difficult_content_id` int(50) NOT NULL AUTO_INCREMENT,
  `difficult_content_answer` varchar(255) DEFAULT NULL,
  `difficult_content_question` varchar(255) DEFAULT NULL,
  `difficult_content_time` int(11) NOT NULL,
  `difficult_content_degree` int(4) DEFAULT NULL,
  `difficult_cate_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`difficult_content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_difficult_content
-- ----------------------------
INSERT INTO `h_difficult_content` VALUES ('1', '123123', '1231', '0', '1', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('2', '1231231', '123', '0', '100', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('3', '阿达', '阿达', '1547532913', '100', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('4', '123123', '123', '1547534116', '1000', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('5', '13', '1', '1547538167', '100', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('6', '234', '1', '0', '1', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('7', '34', '1', '0', '1', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('8', '34', '1', '0', '1', '1', '5');
INSERT INTO `h_difficult_content` VALUES ('9', '34', '1', '0', '1', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('10', '34', '1', '0', '1', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('11', '34', '1', '0', '1', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('12', '34', '1', '0', '1', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('13', '123', '1', '0', '1', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('14', '123123', '1231', '1547539951', '1000', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('15', '123123', '核算', '0', '1000', '5', '5');
INSERT INTO `h_difficult_content` VALUES ('17', 'founction(){\n\n\nconsole.log(123)\n}', 'code', '1547541405', '100', '5', '5');

-- ----------------------------
-- Table structure for `h_education_child`
-- ----------------------------
DROP TABLE IF EXISTS `h_education_child`;
CREATE TABLE `h_education_child` (
  `education_child_id` int(50) NOT NULL AUTO_INCREMENT,
  `education_child_name` varchar(255) DEFAULT NULL,
  `education_child_sex` int(1) DEFAULT NULL,
  `education_child_photo` varchar(255) DEFAULT NULL,
  `education_child_birthday` int(15) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`education_child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_education_child
-- ----------------------------
INSERT INTO `h_education_child` VALUES ('1', 'hesir', '1', './static/upload/20190118/1547797270.jpeg', '1547481600', '5');

-- ----------------------------
-- Table structure for `h_education_growthdiary`
-- ----------------------------
DROP TABLE IF EXISTS `h_education_growthdiary`;
CREATE TABLE `h_education_growthdiary` (
  `education_growthdiary_id` int(50) NOT NULL AUTO_INCREMENT,
  `education_growthdiary_photo` varchar(255) DEFAULT NULL,
  `education_growthdiary_text` varchar(255) DEFAULT NULL,
  `education_growthdiary_time` int(50) DEFAULT NULL,
  `education_growthdiary_address` varchar(255) DEFAULT NULL,
  `education_child_id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`education_growthdiary_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_education_growthdiary
-- ----------------------------
INSERT INTO `h_education_growthdiary` VALUES ('3', './static/upload/20190121/1548059228.png', '12', '1548059228', '12', '1', '5');

-- ----------------------------
-- Table structure for `h_education_plan`
-- ----------------------------
DROP TABLE IF EXISTS `h_education_plan`;
CREATE TABLE `h_education_plan` (
  `education_plan_id` int(10) NOT NULL AUTO_INCREMENT,
  `education_plan_answer` varchar(255) DEFAULT NULL,
  `education_plan_question` varchar(255) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `education_plan_time` int(15) DEFAULT NULL,
  `education_plan_address` varchar(255) DEFAULT NULL,
  `education_plan_state` int(4) DEFAULT NULL,
  PRIMARY KEY (`education_plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_education_plan
-- ----------------------------

-- ----------------------------
-- Table structure for `h_footprint`
-- ----------------------------
DROP TABLE IF EXISTS `h_footprint`;
CREATE TABLE `h_footprint` (
  `footprint_id` int(50) NOT NULL AUTO_INCREMENT,
  `footprint_title` varchar(255) DEFAULT NULL,
  `footprint_address` varchar(255) DEFAULT NULL,
  `footprint_time` int(15) DEFAULT NULL,
  `footprint_photo` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(50) NOT NULL,
  PRIMARY KEY (`footprint_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_footprint
-- ----------------------------
INSERT INTO `h_footprint` VALUES ('22', '1', '1', '1547632883', './static/upload/20190116/1547632883.png', '5');
INSERT INTO `h_footprint` VALUES ('23', 'qweqe', '驱蚊器二2', '1547800162', './static/upload/20190118/1547800162.jpeg./static/upload/20190118/1547800162.png', '5');
INSERT INTO `h_footprint` VALUES ('25', '', '', '1548058426', './static/upload/20190121/1548058426.jpeg', '5');

-- ----------------------------
-- Table structure for `h_user`
-- ----------------------------
DROP TABLE IF EXISTS `h_user`;
CREATE TABLE `h_user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `user_phone` bigint(11) DEFAULT NULL,
  `user_sex` int(1) DEFAULT NULL,
  `user_qq` int(10) DEFAULT NULL,
  `user_date` int(50) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_permission` int(1) NOT NULL,
  `user_footprint` varchar(50) NOT NULL,
  `user_studyeducation` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_user
-- ----------------------------
INSERT INTO `h_user` VALUES ('5', 'hesir22', '28fc2749e2c71d04b6f08df7128b73db', '18628953635', '1', '378504221', '1547198126', 'hewenxiaotj@163.com', '四川成都', '0', '1000', '', '1');
INSERT INTO `h_user` VALUES ('3', 'hesir12', '28fc2749e2c71d04b6f08df7128b73db', '0', '0', '0', '1547198141', '', '', '0', '0', '', '1');
