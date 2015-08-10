<?php
/**
 * 注意use是加入Common\Controller\
 */
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class IndexController extends NormalBaseController {
    public function index(){
        $this->display();
    }
}