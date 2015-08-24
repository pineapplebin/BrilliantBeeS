<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class SiteSettingController extends AdminBaseController {

    public function index() {
        if (C('OPEN_SIGNUP')) {
            $this->assign('signup_open', 'checked="checked"');
        }
        if (C('OPEN_SIGNUP_VERIFY')) {
            $this->assign('signup_verify_open', 'checked="checked"');
        }
        $this->display();
    }

    public function handle() {
        if (!IS_POST) $this->redirect('Home/Index/index');
        $post_config = I('post.');
        // 检测提交的checkbox是否存在，不存在则置值为0
        if (!$post_config['OPEN_SIGNUP']) {
            $post_config['OPEN_SIGNUP'] = '0';
        }
        if (!$post_config['OPEN_SIGNUP_VERIFY']) {
            $post_config['OPEN_SIGNUP_VERIFY'] = '0';
        }
        // 转换字符串为整型
        $post_config['LOGIN_ERROR_COUNT'] = (int)$post_config['LOGIN_ERROR_COUNT'];
        $post_config['LOGIN_ERROR_TIME'] = (int)$post_config['LOGIN_ERROR_TIME'];

        // 检测提交方式为checkbox的配置项，是否为空，为空则表示
        $dynamic_config = array_merge(include C('DYNAMIC_CONFIG_FILE_PATH'), $post_config);
        $write_content = '<?php return ' . var_export($dynamic_config, true) . ';';

        if (file_put_contents(C('DYNAMIC_CONFIG_FILE_PATH'), $write_content)) {
            // 如果修改成功则以字符串查询形式返回给前端刷新
            flash('修改成功', 'green');
        } else {
            flash('修改失败，请查看项目是否有权限修改文件');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}