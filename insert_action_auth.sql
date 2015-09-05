USE `brilliant_bee_s`;

INSERT INTO  `bbs_action_auth_relation` (`action_name`, `auth_id`, `auth_name`, `restrict_desc`)
VALUES ('post', 1, '发表帖子', '没有发表帖子权限');

INSERT INTO  `bbs_action_auth_relation` (`action_name`, `auth_id`, `auth_name`, `restrict_desc`)
VALUES ('reply', 2, '回复帖子', '没有回复帖子权限');