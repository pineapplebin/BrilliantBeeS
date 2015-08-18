<?php
/**
 * Created by PhpStorm.
 * User: pineapplebin
 * Date: 15-8-12
 * Time: 下午6:26
 */
namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class UserManageController extends AdminBaseController {
    // 用户信息显示
    public function index(){
        //查询用户具体用户 // 数据分页
        $user = M('user');
        if(!empty($_POST)){
            $page = new \Think\Page(1,1);
            // 数据集
            if(I('user_name')== ''){
                $this -> redirect('index');
            }
            $condition['user_name'] = I('user_name');
            $list = $user -> where($condition)-> limit($page->firstRow.','.$page->listRows)-> select();
            $this -> assign('count',1);           // 总记录数

            if(count($list)== 0){
                $notice = "该用户不存在!";
                $this -> assign('notice',$notice);
                $this -> assign('count',0);       // 总记录数
            }

        } else {                                  // 没有查询用户，默认显示全部用户信息
            $count = $user -> count();            // 总条数
            $page = new \Think\Page($count,10);    // 设置每页显示条数为7条

            // 样式定制
            $page -> setConfig('prev','上一页');
            $page -> setConfig('next','下一页');
            $page -> setConfig('first', '首页');
            $page -> setConfig('end', '末页');
            $this -> assign('count',$count);     //总记录数
            // 数据集
            $list = $user ->order('user_id DESC')-> limit($page->firstRow.','.$page->listRows)-> select();

        }
        $show = $page -> show();
        $this -> assign('list',$list);
        $this -> assign('page',$show);
        $this -> display();
    }

    // 修改用户数据
    public function update($user_id){
        $user = M('user');
        // 从修改页面转来，保存数据修改  （PS：post里有数据表明是修改页面的表单传来的数据）
        if(!empty($_POST)){
            $user -> create();
            $result = $user -> save();

            if($result != false){
                flash('数据修改成功！','green');
                $this ->redirect('index');
            } else {
                flash('数据未作更改!','red');
                $this -> redirect('index');
            }

        // （否则就是）点击修改链接时，将数据转向修改页面并展示出来
        } else {
            $info = $user -> find($user_id);  // 一维数组
            if($info == NULL){
                flash('用户不存在!');
                $this -> redirect('index');
            }
            $this -> assign('info',$info);

            $level = $info['user_level_group'];
            $special = $info['user_special_group'];
            $admin = $info['user_admin_group'];

            $this -> assign('Lv'.$level,"selected='selected'");
            $this -> assign('Sp'.$special,"selected='selected'");
            $this -> assign('Ad'.$admin,"selected='selected'");

            $this -> display();
        }
    }

    // 删除用户
    public function delete($user_id){
        $user = M('user');
        // 从删除页面转来，删除数据  （PS：post里有数据表明是删除面的表单传来的数据）
        if(!empty($_POST)){
            $id = I('post.user_id');
            $condition['user_id'] = array('in',$id);

            $result = $user->where($condition)->delete();

            if ($result != false)
                flash('删除成功!', 'green');
            else
                flash('删除失败!');

            $this -> redirect('index');
        // （否则就是）点击修改链接时，将数据转向修改页面并展示出来
        }else {
            $this -> assign('user_id',$user_id);
            $this -> display();
        }
    }

    // 批量删除用户
    function delete_all(){
        $user = M('user');
        if(!empty($_POST)){
            $id = I('post.delete_all');
            $condition['user_id'] = array('in',$id);
            $result = $user->where($condition)->delete();
            if ($result != false)
                flash('删除成功!', 'green');
            else
                flash('删除失败!');

            $this -> redirect('index');
        }else{
            $this -> display('index');
        }
    }

    // 添加用户
    public function add(){
        //两个逻辑① 展现表单 ② 接收表单数据
        if(!empty($_POST)){
            $username = I('post.user_name');
            $email = I('post.user_email');
            $password = I('post.user_password');

            if ($username == '' || $email == '' || $password == '') {
                flash('请输入完整信息');
                $this->redirect('add');
            }
            $user = M('user');
            $can_save = true;
            // 用户名邮箱是否重复
            $result = $user->where(array('user_name'=>$username))->find();
            if ($result) {
                flash('用户名已存在');
                $can_save = false;
            }
            // 邮箱是否重复
            $result = $user->where(array('user_email'=>$email))->find();
            if ($result) {
                flash('该邮箱已被注册');
                $can_save = false;
            }
            if($can_save){
                $signup_time = strtotime('now');
                // 保存
                $data = array(
                    'user_name' => $username,
                    'user_password' => $password,
                    'user_email' => $email,
                    'user_signup_time' => $signup_time
                );
                if ($user->data($data)->add()) {
                    flash('添加成功!','green');
                    $this -> redirect('index');
                } else {
                    flash('添加失败!', 'red');
                    $this->redirect('index');
                }
            }else{
                $this -> redirect('add');
            }
        }else{
            $this -> display();
        }
    }
}