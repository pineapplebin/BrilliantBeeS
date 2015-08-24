<?php
$config = array(
    // 路由配置
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => array(
        'forum/:id' => 'Home/Plate/forum',
    ),
    // 动态配置文件路径
    'DYNAMIC_CONFIG_FILE_PATH'      =>      './Application/Common/Conf/dynamic.config.php',
);
$config = array_merge(include './conf.php', $config);
return array_merge(include $config['DYNAMIC_CONFIG_FILE_PATH'], $config);