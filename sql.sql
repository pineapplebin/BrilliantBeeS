-- 创建数据库
CREATE DATABASE IF NOT EXISTS `hahahatest` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
USE `hahahatest`;
-- 用户表
DROP TABLE IF EXISTS `bbs_user`;
CREATE TABLE IF NOT EXISTS `bbs_user`(
    `user_id`  int primary key auto_increment,
    `user_name` varchar(20) not null,
    `user_psw` varchar(32) not null,
    `user_email` varchar(32) not null,
    `user_sex` smallint default 1,
    `user_birth` varchar(10),
    `user_level_group` int default 0,
    `user_special_group` int default 0,
    `user_admin_group` int default 0
)engine=myisam default charset=utf8;

-- 晋级用户组表
DROP TABLE IF EXISTS `bbs_level_group`;
CREATE TABLE IF NOT EXISTS `bbs_level_group`(
    `level_id`  int primary key auto_increment,
    `level_name` varchar(20) not null,
    `level_group_auth` int not null
)engine=myisam default charset=utf8;

-- 特殊用户组
DROP TABLE IF EXISTS `bbs_special_group`;
CREATE TABLE IF NOT EXISTS `bbs_special_group`(
    `special_id`  int primary key auto_increment,
    `special_name` varchar(20) not null,
    `special_group_auth` int not null
)engine=myisam default charset=utf8;

-- 管理用户组
DROP TABLE IF EXISTS `bbs_admin_group`;
CREATE TABLE IF NOT EXISTS `bbs_admin_group`(
    `admin_id` int primary key auto_increment,
    `admin_name` varchar(20) not null,
    `admin_group_auth` int not null
)engine=myisam default charset=utf8;

-- 权限表
DROP TABLE IF EXISTS `bbs_authority`;
CREATE TABLE IF NOT EXISTS `bbs_authority`(
    `auth_id`  int primary key auto_increment,
    `auth_name` varchar(40)
)engine=myisam default charset=utf8;

-- 帖
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE IF NOT EXISTS `bbs_post`(
    `post_id`  int primary key auto_increment,
    `post_title` varchar(100) not null,
    `post_content` varchar(2000) not null,
    `post_time` varchar(20) not null,
    `post_modify_time` int,
    `post_last_reply_time` int,
    `post_author_id` int not null,
    `post_author_name` varchar(20) not null,
    `post_reply_count` int not null default 0,
    `post_checked` int not null default 0,  -- 帖子点击量
    `post_plate` int not null,
    `post_is_closed` boolean default 0,
    `post_is_top` boolean default 0
)engine=myisam default charset=utf8;

-- 回复
DROP TABLE IF EXISTS `bbs_reply`;
CREATE TABLE IF NOT EXISTS `bbs_reply`(
    `reply_id`  int primary key auto_increment,
    `reply_post_id` int not null,
    `reply_content` varchar(1000) not null,
    `reply_author_id` int not null,
    `reply_author_name` int not null,
    `reply_time` varchar(20) not null
)engine=myisam default charset=utf8;

-- 板块
DROP TABLE IF EXISTS `bbs_plate`;
CREATE TABLE IF NOT EXISTS `bbs_plate`(
    `plate_id`  int primary key auto_increment,
    `plate_name` varchar(40) not null,
    `plate_post_count` int not null default 0,
    `plate_reply_count` int not null default 0
)engine=myisam default charset=utf8;