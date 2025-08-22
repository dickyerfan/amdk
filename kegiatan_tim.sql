/*
 Navicat Premium Data Transfer

 Source Server         : siaap
 Source Server Type    : MySQL
 Source Server Version : 100621 (10.6.21-MariaDB-0ubuntu0.22.04.2)
 Source Host           : 192.168.55.3:3306
 Source Schema         : amdk

 Target Server Type    : MySQL
 Target Server Version : 100621 (10.6.21-MariaDB-0ubuntu0.22.04.2)
 File Encoding         : 65001

 Date: 22/08/2025 10:56:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kegiatan_tim
-- ----------------------------
DROP TABLE IF EXISTS `kegiatan_tim`;
CREATE TABLE `kegiatan_tim`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ketua_tim` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kegiatan_tim
-- ----------------------------
INSERT INTO `kegiatan_tim` VALUES (1, 'RKAP Tahun 2026', 'Tim Pembuatan RKAP tahun 2026', 'Dicky Erfan Septiono', '2025-08-21 13:12:56');

SET FOREIGN_KEY_CHECKS = 1;
