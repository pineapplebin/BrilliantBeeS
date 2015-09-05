USE `brilliant_bee_s`;

INSERT INTO  `bbs_admin_group` (`admin_name`) VALUES ('见习版主');

INSERT INTO  `bbs_admin_group` (`admin_name`) VALUES ('版主');

INSERT INTO  `bbs_admin_group` (`admin_name`) VALUES ('超级版主');

INSERT INTO  `bbs_admin_group` (`admin_name`) VALUES ('管理员');


INSERT INTO  `bbs_special_group` (`special_name`) VALUES ('禁止发帖');

INSERT INTO  `bbs_special_group` (`special_name`) VALUES ('禁止浏览');

INSERT INTO  `bbs_special_group` (`special_name`) VALUES ('禁止访问');

INSERT INTO  `bbs_special_group` (`special_name`) VALUES ('游客');

INSERT INTO  `bbs_special_group` (`special_name`) VALUES ('未验证');


INSERT INTO  `bbs_level_group` (`level_name`) VALUES ('普通会员');

INSERT INTO  `bbs_level_group` (`level_name`) VALUES ('晋级会员');

INSERT INTO  `bbs_level_group` (`level_name`) VALUES ('高级会员');

INSERT INTO  `bbs_level_group` (`level_name`) VALUES ('资深会员');

INSERT INTO  `bbs_level_group` (`level_name`) VALUES ('骨灰会员');

INSERT INTO  `bbs_admin_auth_relation` (`group_id`, `auth_id`, `auth_value`)
VALUES (1, 5, 1);

INSERT INTO  `bbs_admin_auth_relation` (`group_id`, `auth_id`, `auth_value`)
VALUES (2, 5, 1);

INSERT INTO  `bbs_admin_auth_relation` (`group_id`, `auth_id`, `auth_value`)
VALUES (3, 5, 1);

INSERT INTO  `bbs_admin_auth_relation` (`group_id`, `auth_id`, `auth_value`)
VALUES (4, 5, 1);

