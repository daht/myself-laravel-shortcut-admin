/*
 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : admin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 04/12/2020 16:49:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `unionid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信union_id',
  `openid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信open_id',
  `is_bind_wechat` int(11) NULL DEFAULT 0 COMMENT '是否绑定微信',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '1是管理员 2 员工 0 普通客户',
  `access_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `is_disable` int(11) NULL DEFAULT 0 COMMENT '0 正常 1 禁用 反义词Enable',
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `last_login_at` int(11) NULL DEFAULT 0 COMMENT '最后登录时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`) USING BTREE,
  UNIQUE INDEX `mobile`(`mobile`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'daht', 'daht', '', '', 0, '$2y$10$e.BfUDU24Jl3ysNyqI.fxueUL8I9FEIs34TkwxNLeKRICoWURtkJe', 0, '', 'KGrCZAxYzzfRqVWqbJBLmVD3pxdlyb63jOmiIEIAxcx9HKmB7FTIJVM7fyfT', 0, '', 1607071219, NULL, '2020-11-04 08:54:40', '2020-12-04 16:46:53');
INSERT INTO `admin` VALUES (16, 'admin', '总管理员', '', '', 0, '$2y$10$p9fb12BUf7uF/i/vFnz9D.A64xVU.Op4rvldvGC73YdsFdRzmFCTe', 0, '', 'KXeq3yK9x9ioUKTMPEFlk7KJnuSagUpVvmPvJBBooc9aBqQZWOWyQ7dwS9uB', 0, '', 1607068731, NULL, '2020-12-04 15:58:28', '2020-12-04 15:58:51');

-- ----------------------------
-- Table structure for admin_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log`  (
  `admin_log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作记录描述',
  `admin_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人账号(当前)',
  `admin_remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人备注(当前)',
  `admin_mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人手机号(当前)',
  `admin_id` int(11) NOT NULL COMMENT '操作人ID',
  `admin_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作人IP地址',
  `route` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作路由',
  `method` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作类型 GET POST',
  `result` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '操作数据json',
  `type` tinyint(1) NULL DEFAULT 0 COMMENT '日志类型:0.操作日志 1.系统日志',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`admin_log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91716 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_route
-- ----------------------------
DROP TABLE IF EXISTS `admin_route`;
CREATE TABLE `admin_route`  (
  `admin_route_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '后台路由ID',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父类ID',
  `parent_all_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '上级所有父类ID',
  `level` tinyint(1) NOT NULL DEFAULT 1 COMMENT '层级',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由名称',
  `is_menu` int(11) NOT NULL DEFAULT 0 COMMENT '菜单是否展示',
  `is_url` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否是访问地址',
  `method` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:get 1:post 2:put 3:PATCH 4:DELETE ',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '路由地址',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `sort` int(11) NULL DEFAULT 1 COMMENT '排序',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`admin_route_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商城管理后台路由表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_route
-- ----------------------------
INSERT INTO `admin_route` VALUES (1, 0, '', 1, '系统管理', 1, 0, 0, '/system', 'icon-setup', 1, NULL, '2020-11-14 17:11:19', '2020-11-18 19:48:57');
INSERT INTO `admin_route` VALUES (2, 1, '1', 2, '导航管理', 1, 1, 0, '/system/menu', '', 1, NULL, '2020-11-14 17:11:21', NULL);
INSERT INTO `admin_route` VALUES (4, 1, '1', 3, '身份管理', 1, 1, 0, '/system/roles', '', 1, NULL, '2020-11-14 17:11:28', NULL);
INSERT INTO `admin_route` VALUES (25, 1, '1', 2, '管理员管理', 1, 1, 0, '/system/admin', '', 1, NULL, '2020-11-16 12:31:43', '2020-11-16 12:31:43');
INSERT INTO `admin_route` VALUES (26, 2, '1,2', 3, '添加权限', 0, 0, 1, '/system/permissions/create', '', 1, NULL, '2020-11-16 12:42:06', '2020-11-16 12:42:06');
INSERT INTO `admin_route` VALUES (27, 2, '1,2', 3, '删除权限', 0, 0, 1, '/system/permissions/delete', '', 1, NULL, '2020-11-16 12:42:26', '2020-11-16 12:42:26');
INSERT INTO `admin_route` VALUES (28, 25, '1,25', 3, '更改管理员', 0, 0, 1, '/system/admin/update', '', 1, NULL, '2020-11-17 13:51:58', '2020-11-17 13:51:58');
INSERT INTO `admin_route` VALUES (29, 25, '1,25', 3, '添加管理员', 0, 0, 1, '/system/admin/create', '', 1, NULL, '2020-11-17 13:52:51', '2020-11-17 13:52:51');
INSERT INTO `admin_route` VALUES (30, 25, '1,25', 3, '删除管理员', 0, 0, 1, '/system/admin/delete', '', 1, NULL, '2020-11-17 13:53:20', '2020-11-17 13:53:20');
INSERT INTO `admin_route` VALUES (37, 2, '1,2', 3, '查看模块', 1, 0, 0, '/system/permissions', '', 1, NULL, '2020-11-18 17:28:01', '2020-11-18 20:22:23');
INSERT INTO `admin_route` VALUES (40, 4, '1,4', 4, '添加身份', 1, 0, 0, '/system/roles/create', '', 1, NULL, '2020-11-19 20:42:19', '2020-11-19 20:42:19');
INSERT INTO `admin_route` VALUES (41, 4, '1,4', 4, '删除身份', 0, 0, 1, '/system/roles/delete', '', 1, NULL, '2020-11-19 20:42:33', '2020-11-19 20:42:33');
INSERT INTO `admin_route` VALUES (42, 4, '1,4', 4, '更改身份', 0, 0, 1, '/system/roles/update', '', 1, NULL, '2020-11-19 20:42:44', '2020-11-19 20:42:44');
INSERT INTO `admin_route` VALUES (43, 4, '1,4', 4, '编辑身份权限', 0, 0, 1, '/system/roles2permissions/update', '', 1, NULL, '2020-11-19 20:43:01', '2020-11-19 20:43:01');
INSERT INTO `admin_route` VALUES (47, 4, '1,4', 4, '身份权限管理', 1, 0, 0, '/system/roles2permissions', '', 1, NULL, '2020-12-04 15:51:12', '2020-12-04 15:51:12');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\Admin', 4);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\Admin', 15);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Admin', 7);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Admin', 8);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Admin', 13);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Admin', 14);
INSERT INTO `model_has_roles` VALUES (7, 'App\\Models\\Admin', 16);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (15, '/system/admin', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (14, '/system/roles', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (13, '/system/permissions/add', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (12, '/system/menu', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (11, '/system', 'web', '2020-11-17 10:37:59', '2020-11-18 19:48:57', NULL);
INSERT INTO `permissions` VALUES (16, '/system/permissions/create', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (17, '/system/permissions/delete', 'web', '2020-11-17 10:37:59', '2020-11-17 10:37:59', NULL);
INSERT INTO `permissions` VALUES (18, '/system/admin/update', 'web', '2020-11-17 13:51:58', '2020-11-17 13:51:58', NULL);
INSERT INTO `permissions` VALUES (19, '/system/admin/create', 'web', '2020-11-17 13:52:51', '2020-11-17 13:52:51', NULL);
INSERT INTO `permissions` VALUES (20, '/system/admin/delete', 'web', '2020-11-17 13:53:20', '2020-11-17 13:53:20', NULL);
INSERT INTO `permissions` VALUES (26, '/system/permissions', 'web', '2020-11-18 17:28:01', '2020-11-18 17:28:01', NULL);
INSERT INTO `permissions` VALUES (29, '/system/roles/create', 'web', '2020-11-19 20:42:19', '2020-11-19 20:42:19', NULL);
INSERT INTO `permissions` VALUES (30, '/system/roles/delete', 'web', '2020-11-19 20:42:33', '2020-11-19 20:42:33', NULL);
INSERT INTO `permissions` VALUES (31, '/system/roles/update', 'web', '2020-11-19 20:42:44', '2020-11-19 20:42:44', NULL);
INSERT INTO `permissions` VALUES (32, '/system/roles2permissions/update', 'web', '2020-11-19 20:43:01', '2020-11-19 20:43:01', NULL);
INSERT INTO `permissions` VALUES (36, '/system/roles2permissions', 'web', '2020-12-04 15:51:12', '2020-12-04 15:51:12', NULL);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (11, 3);
INSERT INTO `role_has_permissions` VALUES (11, 4);
INSERT INTO `role_has_permissions` VALUES (11, 7);
INSERT INTO `role_has_permissions` VALUES (12, 3);
INSERT INTO `role_has_permissions` VALUES (12, 7);
INSERT INTO `role_has_permissions` VALUES (14, 7);
INSERT INTO `role_has_permissions` VALUES (15, 4);
INSERT INTO `role_has_permissions` VALUES (15, 7);
INSERT INTO `role_has_permissions` VALUES (16, 3);
INSERT INTO `role_has_permissions` VALUES (16, 7);
INSERT INTO `role_has_permissions` VALUES (17, 7);
INSERT INTO `role_has_permissions` VALUES (18, 4);
INSERT INTO `role_has_permissions` VALUES (18, 7);
INSERT INTO `role_has_permissions` VALUES (19, 4);
INSERT INTO `role_has_permissions` VALUES (20, 4);
INSERT INTO `role_has_permissions` VALUES (26, 3);
INSERT INTO `role_has_permissions` VALUES (26, 7);
INSERT INTO `role_has_permissions` VALUES (29, 7);
INSERT INTO `role_has_permissions` VALUES (30, 7);
INSERT INTO `role_has_permissions` VALUES (31, 7);
INSERT INTO `role_has_permissions` VALUES (32, 7);
INSERT INTO `role_has_permissions` VALUES (36, 7);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (3, '编辑', 'web', '2020-11-18 13:57:38', '2020-11-18 14:05:26', NULL);
INSERT INTO `roles` VALUES (4, '文案', 'web', '2020-11-18 14:05:08', '2020-12-04 13:56:57', NULL);
INSERT INTO `roles` VALUES (7, '总管理员', 'web', '2020-12-04 15:57:49', '2020-12-04 15:57:49', NULL);

SET FOREIGN_KEY_CHECKS = 1;
