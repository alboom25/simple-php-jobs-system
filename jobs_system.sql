/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80021
 Source Host           : localhost:3306
 Source Schema         : jobs_system

 Target Server Type    : MySQL
 Target Server Version : 80021
 File Encoding         : 65001

 Date: 02/12/2020 15:17:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_applicants
-- ----------------------------
DROP TABLE IF EXISTS `tbl_applicants`;
CREATE TABLE `tbl_applicants`  (
  `applicant_id` int(0) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone_number` int(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`applicant_id`, `email_address`) USING BTREE,
  INDEX `applicant_id`(`applicant_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_employers
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employers`;
CREATE TABLE `tbl_employers`  (
  `employer_id` int(0) NOT NULL AUTO_INCREMENT,
  `employer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `employer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `employer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `employer_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`employer_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_job_applications
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_applications`;
CREATE TABLE `tbl_job_applications`  (
  `application_id` int(0) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(0) NOT NULL,
  `job_id` int(0) NOT NULL,
  `application_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `application_status` enum('Received','Reviewing','Reviewed','Selected','Hired') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Received',
  PRIMARY KEY (`application_id`) USING BTREE,
  INDEX `job_id`(`job_id`) USING BTREE,
  INDEX `applicant_id`(`applicant_id`) USING BTREE,
  CONSTRAINT `tbl_job_applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `tbl_job_list` (`job_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tbl_job_applications_ibfk_2` FOREIGN KEY (`applicant_id`) REFERENCES `tbl_applicants` (`applicant_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_job_list
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_list`;
CREATE TABLE `tbl_job_list`  (
  `job_id` int(0) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `job_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `employer_id` int(0) NOT NULL,
  `created_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`) USING BTREE,
  INDEX `employer_id`(`employer_id`) USING BTREE,
  CONSTRAINT `tbl_job_list_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `tbl_employers` (`employer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
