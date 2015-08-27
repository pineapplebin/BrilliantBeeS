<?php
namespace Common\Controller;
use Common\Controller\CommonController;

/**
 * 后台控制器基类
 * @package Common\Controller
 */
class AdminBaseController extends CommonController {
    /**
     * 初始化方法
     * 所有派生自AdminBaseController的控制器都会先执行此方法内的内容
     */
    public function _initialize() {
        $controller = $Think.CONTROLLER_NAME;
        $this->assign($controller, 'active');
    }
}