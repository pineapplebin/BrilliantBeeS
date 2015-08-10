<?php
namespace User\Controller;
use Common\Controller\NormalBaseController;

class SignupController extends NormalBaseController {

    public function index() {
        $this->display();
    }

    public function handle() {
        if (!IS_POST) $this->redirect('Home/Index/index');

        $username = I('post.user_name');
        $email = I('post.user_email');
        $password = I('post.user_pwd');
        $re_password = I('post.re_user_pwd');
        $verify_text = I('post.verify');

        if ($username == '' || $email == '' || $password == '' || $re_password == '') {
            flash('请输入完整信息');
            $this->redirect('index');
        }

        $can_save = true;
        $user = M('user');
        // 验证用户名是否重复
        $result = $user->where(array('user_name'=>$username))->find();
        if ($result) {
            $can_save = false;
            flash('用户名已被注册');
        }
        // 验证邮箱是否重复
        $result = $user->where(array('user_email'=>$email))->find();
        if ($result) {
            $can_save = false;
            flash('邮箱地址已被注册');
        }
        // 验证两次输入密码一样
        if ($password != $re_password) {
            $can_save = false;
            flash('两次输入密码不一致');
        }

        // 验证验证码输入
        $verify = new \Think\Verify();
        if (!$verify->check($verify_text)) {
            $can_save = false;
            flash('验证码不正确');
        }

        if ($can_save) {
            // 保存
            flash('你已经成功注册', 'green');
            $this->redirect('Home/Index/index');
        } else {
            $this->redirect('index');
        }

    }

    public function verify() {
        $verify = new \Think\Verify();
        $verify->fontSize = 20;
        $verify->length = 4;
        $verify->imageW = 150;
        $verify->imageH = 40;
        $verify->entry();
    }

}