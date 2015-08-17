<?php
/**
 * 注意use是加入Common\Controller\
 */
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class IndexController extends NormalBaseController {
    public function index(){
        $plate = M('plate')->order('plate_create_time')->select();
        $this->assign('plate',$plate);
        $this->display();
    }
}