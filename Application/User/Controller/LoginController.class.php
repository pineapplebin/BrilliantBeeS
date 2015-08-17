<?php
namespace User\Controller;
use Common\Controller\NormalBaseController;

class LoginController extends NormalBaseController {

    public function handle() {
        if (!IS_POST) $this->redirect('Home/Index/index');
        $login_type = I('post.login_type');
        $user_selected = I('post.user_selected');
        $user_password = I('post.user_password');

        $user_login = 'user_'.$login_type;
        $user = M('user');

        $condition = array(
            $user_login => $user_selected,
            'user_password' => $user_password
        );
        $result = $user->where($condition)->find();
        if ($result) {
            session('user_id', $result['user_id']);
            session('user_name', $result['user_name']);
            if (I('remember_me')) {
                // 长期登录操作
                flash('已点击自动登录', 'blue');
            }
            flash('登录成功', 'green');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            flash('登录失败，请再次尝试');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function logout()
    {
        session(null);
        flash('你已经成功退出', 'green');
        if ($_SERVER['HTTP_REFERER']) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect('Home/Index/index');
        }
    }
}