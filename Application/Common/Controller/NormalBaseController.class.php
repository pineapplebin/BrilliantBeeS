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
        
        $this->checkAccess();

    }

    /**
    *检查行为是否需要权限
    */
    public function checkAccess(){
       $auth_id = I('post.auth_id');
       $action_auth = $Think.CONTROLLER_NAME;
       $action_auth = $action_auth.'/'.$Think.ACTION_NAME;       
       $condition = array('action_name'=>$action_auth,'auth_id'=>$auth_id); 
        //需要权限控制
       $result = M('action_auth_relation')->where($condition)->find();        
       if($result){
            $this->checkLogIn();
            $this->checkUserAuth($result['auth_id'], $result['restrict_desc']);
       }
    }

    /**
    *检查用户是否已登录
    */    
    public function checkLogIn(){
        if(session('user_name') == '') {            
            $this->error('请先登录');
        }
    }

    /**
    *检查用户是否有此权限
    */
    public function checkUserAuth($auth_id, $restrict_desc){
        //预置没有权限
        $user_id = session('user_id');
        $condition = array('user_id'=>$user_id);
        $result = M('user')->where($condition)->field('user_level_group,user_special_group,user_admin_group')->find();
        $have_auth = false; 
          
        foreach ($result as $group_type_key => $group_type_value) {
                $type = preg_split('/_/', $group_type_key)[1];
                if($result['user_'.$type.'_group']>0){
                    $condition = array('group_id'=>$group_type_value,'auth_id'=>$auth_id);
                    $auth_value = M($type.'_auth_relation')->where($condition)->getField('auth_value');
                    
                    if($auth_value) {
                        $have_auth = true;
                        break;
                    }  
                }
        }                 
        if(!$have_auth){
            $this->error($restrict_desc);                        
        }        
    }
}