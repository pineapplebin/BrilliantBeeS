<?php

namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class ActionAuthController extends AdminBaseController {
    public function index(){
        $auth_name_id = M('action_auth_relation')->field('auth_name,auth_id')->select();
        $this->assign('auth_name_id', $auth_name_id);
        $this->display();
    }

    public function handle(){
        if(!IS_POST) $this->redirect('index');

        $get_auth_name = I('post.select_auth');
        if($get_auth_name=='') $this->redirect('index');
        else {
            $result['action_name'] = preg_split('/_/', $get_auth_name)[0];         
            $result['auth_id'] = (int)preg_split('/_/', $get_auth_name)[1];
            $result['auth_name'] = preg_split('/_/', $get_auth_name)[2];
            $result['restrict_desc'] = preg_split('/_/', $get_auth_name)[3];
            M('action_auth_relation')->add($result);
            $this->redirect('index');           
        }
    }

    public function delete(){
        if(!IS_POST) $this->redirect('index');

        $get_auth_id = I('post.auth_id');
        M('action_auth_relation')->where('auth_id='.$get_auth_id)->delete();
        $this->redirect('index');           
    }
    
}