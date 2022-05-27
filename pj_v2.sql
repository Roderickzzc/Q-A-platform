/*
 Navicat Premium Data Transfer

 Source Server         : 1
 Source Server Type    : MySQL
 Source Server Version : 80027
 Source Host           : localhost:3306
 Source Schema         : pj2

 Target Server Type    : MySQL
 Target Server Version : 80027
 File Encoding         : 65001

 Date: 14/05/2022 20:02:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for answer
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer`  (
  `answerid` int NOT NULL AUTO_INCREMENT,
  `answertext` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `answer_time` datetime NOT NULL,
  `isNew` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`answerid`) USING BTREE,
  FULLTEXT INDEX `answertext`(`answertext`),
  FULLTEXT INDEX `answertext_2`(`answertext`),
  FULLTEXT INDEX `answertext_3`(`answertext`),
  FULLTEXT INDEX `answertext_4`(`answertext`),
  FULLTEXT INDEX `answertext_5`(`answertext`),
  FULLTEXT INDEX `answertext_6`(`answertext`),
  FULLTEXT INDEX `answertext_7`(`answertext`),
  FULLTEXT INDEX `answertext_8`(`answertext`),
  FULLTEXT INDEX `answertext_9`(`answertext`),
  FULLTEXT INDEX `answertext_10`(`answertext`),
  FULLTEXT INDEX `answertext_11`(`answertext`),
  FULLTEXT INDEX `answertext_12`(`answertext`),
  FULLTEXT INDEX `answertext_13`(`answertext`),
  FULLTEXT INDEX `answertext_14`(`answertext`),
  FULLTEXT INDEX `answertext_15`(`answertext`),
  FULLTEXT INDEX `answertext_16`(`answertext`),
  FULLTEXT INDEX `answertext_17`(`answertext`),
  FULLTEXT INDEX `answertext_18`(`answertext`),
  FULLTEXT INDEX `answertext_19`(`answertext`),
  FULLTEXT INDEX `answertext_20`(`answertext`),
  FULLTEXT INDEX `answertext_21`(`answertext`),
  FULLTEXT INDEX `answertext_22`(`answertext`),
  FULLTEXT INDEX `answertext_23`(`answertext`),
  FULLTEXT INDEX `answertext_24`(`answertext`),
  FULLTEXT INDEX `answertext_25`(`answertext`),
  FULLTEXT INDEX `answertext_26`(`answertext`),
  FULLTEXT INDEX `answertext_27`(`answertext`),
  FULLTEXT INDEX `answertext_28`(`answertext`),
  FULLTEXT INDEX `answertext_29`(`answertext`),
  FULLTEXT INDEX `answertext_30`(`answertext`)
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of answer
-- ----------------------------
INSERT INTO `answer` VALUES (1, 'It should be: I like the person who is nice to me. ', '2022-03-03 23:51:27', 1);
INSERT INTO `answer` VALUES (2, 'I like the person who is nice to me. who substitutes for subject nouns/pronouns (he, she, we, they)', '2022-03-04 23:52:36', 1);
INSERT INTO `answer` VALUES (3, 'You don\'t have full joins in MySQL, but you can sure emulate them.\r\n\r\nFor a code sample transcribed from this Stack Overflow question you have:\r\n\r\nWith two tables t1, t2:\r\n\r\nSELECT * FROM t1\r\nLEFT JOIN t2 ON t1.id = t2.id\r\nUNION\r\nSELECT * FROM t1\r\nRIGHT JOIN t2 ON t1.id = t2.id', '2022-04-01 23:54:39', 1);
INSERT INTO `answer` VALUES (4, 'mysql is bad. Try to use PostgreSQL', '2022-03-31 23:58:23', 1);
INSERT INTO `answer` VALUES (5, 'Bubble sort, sometimes referred to as sinking sort, is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order. The pass through the list is repeated until the list is sorted.', '2022-04-11 23:59:01', 1);
INSERT INTO `answer` VALUES (6, 'Merge Sort is a Divide and Conquer algorithm. It divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves. The merge() function is used for merging two halves. The merge(arr, l, m, r) is a key process that assumes that arr[l..m] and arr[m+1..r] are sorted and merges the two sorted sub-arrays into one. See the following C implementation for details.', '2022-03-10 23:59:42', 1);
INSERT INTO `answer` VALUES (7, ' Cost of Investment\r\nNet Return on Investment\r\n?\r\n ×100%\r\n?\r\n Cost of Investment\r\nNet Return on Investment\r\n?\r\n ×100%\r\n?\r\nNet return on investment/cost of investment *100%', '2022-04-17 00:00:44', 1);
INSERT INTO `answer` VALUES (8, 'try to look at this website: https://www.geeksforgeeks.org/bubble-sort/', '2022-04-13 00:01:58', 1);

-- ----------------------------
-- Table structure for ask
-- ----------------------------
DROP TABLE IF EXISTS `ask`;
CREATE TABLE `ask`  (
  `qid` int NOT NULL,
  `userid` int NOT NULL,
  PRIMARY KEY (`qid`, `userid`) USING BTREE,
  INDEX `ask_ibfk_2`(`userid` ASC) USING BTREE,
  CONSTRAINT `ask_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `question` (`qid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ask_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ask
-- ----------------------------
INSERT INTO `ask` VALUES (2, 2);
INSERT INTO `ask` VALUES (6, 2);
INSERT INTO `ask` VALUES (1, 3);
INSERT INTO `ask` VALUES (4, 7);
INSERT INTO `ask` VALUES (3, 8);
INSERT INTO `ask` VALUES (5, 9);
INSERT INTO `ask` VALUES (7, 10);

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `classid` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`classid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (1, 'Basic');
INSERT INTO `class` VALUES (2, 'Advacned');
INSERT INTO `class` VALUES (3, 'Expert');

-- ----------------------------
-- Table structure for giveanswer
-- ----------------------------
DROP TABLE IF EXISTS `giveanswer`;
CREATE TABLE `giveanswer`  (
  `userid` int NOT NULL,
  `answerid` int NOT NULL,
  PRIMARY KEY (`userid`, `answerid`) USING BTREE,
  INDEX `answerid`(`answerid` ASC) USING BTREE,
  CONSTRAINT `giveanswer_ibfk_1` FOREIGN KEY (`answerid`) REFERENCES `answer` (`answerid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `giveanswer_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of giveanswer
-- ----------------------------
INSERT INTO `giveanswer` VALUES (2, 1);
INSERT INTO `giveanswer` VALUES (1, 2);
INSERT INTO `giveanswer` VALUES (7, 3);
INSERT INTO `giveanswer` VALUES (4, 4);
INSERT INTO `giveanswer` VALUES (4, 5);
INSERT INTO `giveanswer` VALUES (1, 6);
INSERT INTO `giveanswer` VALUES (1, 7);
INSERT INTO `giveanswer` VALUES (1, 8);

-- ----------------------------
-- Table structure for question
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question`  (
  `qid` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `body` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `post_time` datetime NOT NULL,
  `isResolved` tinyint NOT NULL DEFAULT 0,
  `bestanswerid` int NULL DEFAULT NULL,
  PRIMARY KEY (`qid`) USING BTREE,
  INDEX `bestanswerid`(`bestanswerid` ASC) USING BTREE,
  FULLTEXT INDEX `title`(`title`),
  FULLTEXT INDEX `body`(`body`),
  FULLTEXT INDEX `title_2`(`title`),
  FULLTEXT INDEX `title_3`(`title`),
  FULLTEXT INDEX `body_2`(`body`),
  FULLTEXT INDEX `title_4`(`title`),
  FULLTEXT INDEX `body_3`(`body`),
  FULLTEXT INDEX `title_5`(`title`),
  FULLTEXT INDEX `body_4`(`body`),
  FULLTEXT INDEX `title_6`(`title`),
  FULLTEXT INDEX `body_5`(`body`),
  FULLTEXT INDEX `title_7`(`title`),
  FULLTEXT INDEX `body_6`(`body`),
  FULLTEXT INDEX `title_8`(`title`),
  FULLTEXT INDEX `body_7`(`body`),
  FULLTEXT INDEX `title_9`(`title`),
  FULLTEXT INDEX `body_8`(`body`),
  FULLTEXT INDEX `title_10`(`title`),
  FULLTEXT INDEX `body_9`(`body`),
  FULLTEXT INDEX `title_11`(`title`),
  FULLTEXT INDEX `body_10`(`body`),
  FULLTEXT INDEX `title_12`(`title`),
  FULLTEXT INDEX `body_11`(`body`),
  FULLTEXT INDEX `title_13`(`title`),
  FULLTEXT INDEX `body_12`(`body`),
  FULLTEXT INDEX `title_14`(`title`),
  FULLTEXT INDEX `body_13`(`body`),
  FULLTEXT INDEX `title_15`(`title`),
  FULLTEXT INDEX `body_14`(`body`),
  FULLTEXT INDEX `title_16`(`title`),
  FULLTEXT INDEX `body_15`(`body`),
  FULLTEXT INDEX `title_17`(`title`),
  FULLTEXT INDEX `body_16`(`body`),
  FULLTEXT INDEX `title_18`(`title`),
  FULLTEXT INDEX `body_17`(`body`),
  FULLTEXT INDEX `title_19`(`title`),
  FULLTEXT INDEX `body_18`(`body`),
  FULLTEXT INDEX `title_20`(`title`),
  FULLTEXT INDEX `body_19`(`body`),
  FULLTEXT INDEX `title_21`(`title`),
  FULLTEXT INDEX `body_20`(`body`),
  FULLTEXT INDEX `title_22`(`title`),
  FULLTEXT INDEX `body_21`(`body`),
  FULLTEXT INDEX `title_23`(`title`),
  FULLTEXT INDEX `body_22`(`body`),
  FULLTEXT INDEX `title_24`(`title`),
  FULLTEXT INDEX `body_23`(`body`),
  FULLTEXT INDEX `title_25`(`title`),
  FULLTEXT INDEX `body_24`(`body`),
  FULLTEXT INDEX `title_26`(`title`),
  FULLTEXT INDEX `body_25`(`body`),
  FULLTEXT INDEX `title_27`(`title`),
  FULLTEXT INDEX `body_26`(`body`),
  FULLTEXT INDEX `title_28`(`title`),
  FULLTEXT INDEX `body_27`(`body`),
  FULLTEXT INDEX `title_29`(`title`),
  FULLTEXT INDEX `body_28`(`body`),
  FULLTEXT INDEX `title_30`(`title`),
  FULLTEXT INDEX `body_29`(`body`),
  FULLTEXT INDEX `title_31`(`title`),
  FULLTEXT INDEX `body_30`(`body`),
  FULLTEXT INDEX `title_32`(`title`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`bestanswerid`) REFERENCES `answer` (`answerid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES (1, 'How to use relative clause?', 'I like the person. The person was nice to me. How to connect two sentences together?', '2022-03-02 23:39:01', 1, 2);
INSERT INTO `question` VALUES (2, 'What English books do you recommend?', 'I am a chinese speaker, I want to improve my english. What books do you recommend?', '2022-02-15 23:40:08', 0, NULL);
INSERT INTO `question` VALUES (3, 'How can I do a full outer join in MySQL?', 'I want to do a full outer join in MySQL. Is this possible? Is a full outer join supported by MySQL?', '2022-01-11 23:41:38', 1, 3);
INSERT INTO `question` VALUES (4, 'What are the various types of relationships in Database? Define them.', 'help!', '2022-04-02 23:43:12', 0, NULL);
INSERT INTO `question` VALUES (5, 'What is bubble sort?', 'Can anyone provide some examples on bubble sort?', '2022-04-04 23:46:08', 1, 5);
INSERT INTO `question` VALUES (6, 'What is merge sort?', 'Hi, examples will be appreciated.', '2022-03-09 23:47:02', 1, 6);
INSERT INTO `question` VALUES (7, 'How to calculate Return on Investment (ROI)?', 'Return on investment (ROI) is an approximate measure of an investment\'s profitability. How to calculate', '2022-02-01 23:49:10', 1, 7);

-- ----------------------------
-- Table structure for questionanswer
-- ----------------------------
DROP TABLE IF EXISTS `questionanswer`;
CREATE TABLE `questionanswer`  (
  `qid` int NOT NULL,
  `answerid` int NOT NULL,
  PRIMARY KEY (`qid`, `answerid`) USING BTREE,
  INDEX `answerid`(`answerid` ASC) USING BTREE,
  CONSTRAINT `questionanswer_ibfk_1` FOREIGN KEY (`answerid`) REFERENCES `answer` (`answerid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `questionanswer_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `question` (`qid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of questionanswer
-- ----------------------------
INSERT INTO `questionanswer` VALUES (1, 1);
INSERT INTO `questionanswer` VALUES (1, 2);
INSERT INTO `questionanswer` VALUES (3, 3);
INSERT INTO `questionanswer` VALUES (3, 4);
INSERT INTO `questionanswer` VALUES (5, 5);
INSERT INTO `questionanswer` VALUES (6, 6);
INSERT INTO `questionanswer` VALUES (7, 7);
INSERT INTO `questionanswer` VALUES (5, 8);

-- ----------------------------
-- Table structure for questiontopic
-- ----------------------------
DROP TABLE IF EXISTS `questiontopic`;
CREATE TABLE `questiontopic`  (
  `qid` int NOT NULL,
  `tid` int NOT NULL,
  PRIMARY KEY (`qid`, `tid`) USING BTREE,
  INDEX `tid`(`tid` ASC) USING BTREE,
  CONSTRAINT `questiontopic_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `question` (`qid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `questiontopic_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `topic` (`tid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of questiontopic
-- ----------------------------
INSERT INTO `questiontopic` VALUES (1, 1);
INSERT INTO `questiontopic` VALUES (2, 1);
INSERT INTO `questiontopic` VALUES (3, 2);
INSERT INTO `questiontopic` VALUES (4, 2);
INSERT INTO `questiontopic` VALUES (5, 2);
INSERT INTO `questiontopic` VALUES (6, 2);
INSERT INTO `questiontopic` VALUES (1, 3);
INSERT INTO `questiontopic` VALUES (7, 4);
INSERT INTO `questiontopic` VALUES (3, 7);
INSERT INTO `questiontopic` VALUES (4, 7);
INSERT INTO `questiontopic` VALUES (5, 8);
INSERT INTO `questiontopic` VALUES (6, 8);
INSERT INTO `questiontopic` VALUES (3, 9);

-- ----------------------------
-- Table structure for thumbsup
-- ----------------------------
DROP TABLE IF EXISTS `thumbsup`;
CREATE TABLE `thumbsup`  (
  `answerid` int NOT NULL,
  `userid` int NOT NULL,
  PRIMARY KEY (`answerid`, `userid`) USING BTREE,
  INDEX `thumbsup_ibfk_2`(`userid` ASC) USING BTREE,
  CONSTRAINT `thumbsup_ibfk_1` FOREIGN KEY (`answerid`) REFERENCES `answer` (`answerid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `thumbsup_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of thumbsup
-- ----------------------------
INSERT INTO `thumbsup` VALUES (3, 1);
INSERT INTO `thumbsup` VALUES (3, 2);
INSERT INTO `thumbsup` VALUES (6, 2);
INSERT INTO `thumbsup` VALUES (8, 2);
INSERT INTO `thumbsup` VALUES (1, 3);
INSERT INTO `thumbsup` VALUES (2, 3);
INSERT INTO `thumbsup` VALUES (1, 4);
INSERT INTO `thumbsup` VALUES (2, 4);
INSERT INTO `thumbsup` VALUES (3, 4);
INSERT INTO `thumbsup` VALUES (7, 4);
INSERT INTO `thumbsup` VALUES (1, 5);
INSERT INTO `thumbsup` VALUES (2, 5);
INSERT INTO `thumbsup` VALUES (3, 5);
INSERT INTO `thumbsup` VALUES (7, 5);
INSERT INTO `thumbsup` VALUES (5, 6);
INSERT INTO `thumbsup` VALUES (2, 7);
INSERT INTO `thumbsup` VALUES (2, 8);
INSERT INTO `thumbsup` VALUES (8, 9);

-- ----------------------------
-- Table structure for topic
-- ----------------------------
DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic`  (
  `tid` int NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`tid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of topic
-- ----------------------------
INSERT INTO `topic` VALUES (1, 'English');
INSERT INTO `topic` VALUES (2, 'Computer Science');
INSERT INTO `topic` VALUES (3, 'Grammar');
INSERT INTO `topic` VALUES (4, 'Finance');
INSERT INTO `topic` VALUES (5, 'Mathematics');
INSERT INTO `topic` VALUES (6, 'Algebra');
INSERT INTO `topic` VALUES (7, 'Database');
INSERT INTO `topic` VALUES (8, 'Algorithm');
INSERT INTO `topic` VALUES (9, 'MySQL');

-- ----------------------------
-- Table structure for topichierarchy
-- ----------------------------
DROP TABLE IF EXISTS `topichierarchy`;
CREATE TABLE `topichierarchy`  (
  `tid` int NOT NULL,
  `fatherid` int NOT NULL,
  PRIMARY KEY (`tid`, `fatherid`) USING BTREE,
  INDEX `fatherid`(`fatherid` ASC) USING BTREE,
  CONSTRAINT `topichierarchy_ibfk_1` FOREIGN KEY (`fatherid`) REFERENCES `topic` (`tid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `topichierarchy_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `topic` (`tid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of topichierarchy
-- ----------------------------
INSERT INTO `topichierarchy` VALUES (3, 1);
INSERT INTO `topichierarchy` VALUES (7, 2);
INSERT INTO `topichierarchy` VALUES (8, 2);
INSERT INTO `topichierarchy` VALUES (6, 5);
INSERT INTO `topichierarchy` VALUES (9, 7);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `classid` int NOT NULL DEFAULT 1,
  `email` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `uprofile` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `passw` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ucity` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ustate` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ucountry` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`userid`) USING BTREE,
  INDEX `classid`(`classid` ASC) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`classid`) REFERENCES `class` (`classid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'us123', 1, 'ueshin1@outlook.com', 'Hoping to make friends: )', '123456', 'Nara', 'Japan', 'Japan');
INSERT INTO `user` VALUES (2, 'Ying Tin Wing', 1, 'yingtinwing1211@outlook.com', '9s9wJnvvDD', 'EG84ii923N', 'Chengdu', 'China', 'China');
INSERT INTO `user` VALUES (3, 'Yuen Wing Sze', 1, 'yuews@gmail.com', 'IuhsBFOl4a', 'vO0bzDQ6yI', 'Oxford', 'United Kingdom', 'United Kingdom');
INSERT INTO `user` VALUES (4, 'Leroy Gibson', 1, 'gibson99@icloud.com', '6fyKp8crMO', '72xdfwvLYp', 'Zhongshan', 'China', 'China');
INSERT INTO `user` VALUES (5, 'Ding Zhennan', 1, 'zhennand@yahoo.com', 'hQKJnNHtyp', 'Eh3tnaCd3M', 'Chicago', 'Illinois', 'United States');
INSERT INTO `user` VALUES (6, 'Miyazaki Momoka', 1, 'momoka7@icloud.com', 'DqQUZQXkLq', 'XqI4vsCo3Q', 'Brooklyn', 'New York', 'United States');
INSERT INTO `user` VALUES (7, 'He Zhiyuan', 1, 'zhiyh@outlook.com', 'QVz5V02u70', '5MvFwOvmKp', 'London', 'United Kingdom', 'United Kingdom');
INSERT INTO `user` VALUES (8, 'Zhao Zhennan', 1, 'zhao2@icloud.com', 'Bu39KUxy5T', 'ujsDMXaruA', 'Leicester', 'United Kingdom', 'United Kingdom');
INSERT INTO `user` VALUES (9, 'Murata Kaito', 1, 'murata422@yahoo.com', 'OE8Uct4Fmx', 'FNwQDcsxLn', 'Tokyo', 'Japan', 'Japan');
INSERT INTO `user` VALUES (10, 'Tong Ming Sze', 1, 'tong6@gmail.com', 'PDY94QuQ1S', 'nDcqvWW8w1', 'Liverpool', 'United Kingdom', 'United Kingdom');
INSERT INTO `user` VALUES (11, 'fw2155', 1, 'jilinwfy@gmail.com', 'I am a CS student.', '123456', 'Brooklyn', 'NY', 'NY');

SET FOREIGN_KEY_CHECKS = 1;
