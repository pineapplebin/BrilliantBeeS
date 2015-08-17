<?php
namespace Common\Controller;
use Common\Controller;

/**
 * 非后台控制类基类
 * @package Common\Controller
 */
class NormalBaseController extends CommonController {

    /**
     * 初始化方法
     * 所有派生自NormalBaseController的控制器都会先执行此方法内的内容
     */
    public function _initialize() {
        $current_user_id = session('user_id');
        $current_user_name = session('user_name');
        if ($current_user_id && $current_user_name) {
            $this->assign('current_user', $current_user_name);
            $this->assign('is_login', 1);
        }
    }
}