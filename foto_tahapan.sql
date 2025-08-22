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

 Date: 22/08/2025 10:56:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for foto_tahapan
-- ----------------------------
DROP TABLE IF EXISTS `foto_tahapan`;
CREATE TABLE `foto_tahapan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tahapan` int NOT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `uploaded_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_tahapan`(`id_tahapan` ASC) USING BTREE,
  CONSTRAINT `foto_tahapan_ibfk_1` FOREIGN KEY (`id_tahapan`) REFERENCES `tahapan_kegiatan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of foto_tahapan
-- ----------------------------
INSERT INTO `foto_tahapan` VALUES (1, 4, 'Rekap_RKAP_190825.jpg', '2025-08-21 13:55:07');
INSERT INTO `foto_tahapan` VALUES (2, 5, 'Logo_2.jpg', '2025-08-21 15:16:31');
INSERT INTO `foto_tahapan` VALUES (3, 5, 'WhatsApp_Image_2025-06-26_at_14_18_31.jpeg', '2025-08-21 15:16:31');

SET FOREIGN_KEY_CHECKS = 1;
