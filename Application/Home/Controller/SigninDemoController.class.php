<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class SigninDemoController extends NormalBaseController {

    public function index() {
        $this->display();
    }

    public function handle() {
        if (!IS_POST) {
            $this->redirect('index');
        }
        $username = I('post.username');
        $password = I('post.password');
        // 检查两个是否填入，如果没有则闪现消息
        $is_save = true;
        if ($username == '') {
            flash('请输入用户名');
            $is_save = false;
        }
        if ($password == '') {
            flash('请输入密码');
            $is_save = false;
        }
        // 如果都输入了则返回save，否则重定向至注册页面
        if ($is_save) {
            flash('你的信息已经全部输入', 'green');
        }
        $this->redirect('index');
    }
}