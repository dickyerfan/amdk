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

 Date: 22/08/2025 10:57:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tahapan_kegiatan
-- ----------------------------
DROP TABLE IF EXISTS `tahapan_kegiatan`;
CREATE TABLE `tahapan_kegiatan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kegiatan` int NOT NULL,
  `judul_tahapan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_tahapan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` date NOT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_kegiatan`(`id_kegiatan` ASC) USING BTREE,
  CONSTRAINT `tahapan_kegiatan_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan_tim` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tahapan_kegiatan
-- ----------------------------
INSERT INTO `tahapan_kegiatan` VALUES (4, 1, 'Rapat Awal', 'tes', '2025-08-06', '2025-08-21 13:55:07');
INSERT INTO `tahapan_kegiatan` VALUES (5, 1, 'tes', 'tes', '2025-08-05', '2025-08-21 15:16:31');

SET FOREIGN_KEY_CHECKS = 1;
