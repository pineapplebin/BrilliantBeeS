<?php

namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class GroupManageController extends AdminBaseController {

    /**
     * 用户组管理首页
     */
    public function index() {
        $level_groups = M('level_group')->select();
        $special_groups = M('special_group')->select();
        $admin_groups = M('admin_group')->select();

        $this->assign('level_groups', $level_groups);
        $this->assign('special_groups', $special_groups);
        $this->assign('admin_groups', $admin_groups);
        $this->display();
    }

    /**
     * 新建用户组
     */
    public function addGroup($gtype) {
        $g_type = I('get.gtype');
        if (empty($g_type) || (int)$g_type > 3 || (int)$g_type < 1) {
            $this->redirect('index');
        }
        $type_list = array(
            1 => array('level_group', '晋级用户组'),
            2 => array('special_group', '特殊用户组'),
            3 => array('admin_group', '管理用户组'),
        );

        // 列举权限供用户编辑
        $auth = M('authority')->order('auth_level ASC')->select();

        $this->assign('auths', $auth);
        $this->assign('group_chs', $type_list[$g_type][1]);
        $this->assign('group_type', $g_type);
        $this->display();
    }

    /**
     * 新建用户组处理
     */
    public function addGroupHandle() {
        if (!IS_POST) $this->redirect('index');

        // 先判断组类别，写入新组数据
        $type_list = array(
            1 => array('level', '晋级用户组'),
            2 => array('special', '特殊用户组'),
            3 => array('admin', '管理用户组'),
        );
        $group_type = I('post.group_type');
        $group_table = M($type_list[$group_type][0].'_group');
        $data = array(
            $type_list[$group_type][0].'_name' => I('post.group_name'),
        );
        try {
            $group_id = $group_table->data($data)->add();
        } catch(\Exception $e) {
            flash('你输入的用户组名字已存在，请使用其他名字！');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // 判断权限配置
        $auth_ids = M('authority')->field('auth_id')->select();
        $relation = M($type_list[$group_type][0].'_auth_relation');
        foreach ($auth_ids as $a_id) {
            if (!empty(I('post.auth_'.$a_id['auth_id']))) {
                $relation->data(array(
                    'group_id' => $group_id,
                    'auth_id' => $a_id['auth_id'],
                    'auth_value' => I('post.auth_'.$a_id['auth_id']),
                ))->add();
            }
        }
        flash('新建用户组成功！', 'green');
        $this->redirect('index');
    }

    /**
     * 编辑用户组权限
     */
    public function editGroup($gtype, $gid) {
        $type_list = array(
            1 => array('level', '晋级用户组'),
            2 => array('special', '特殊用户组'),
            3 => array('admin', '管理用户组'),
        );
        // 查询当前用户拥有的权限值
        $relation = M($type_list[$gtype][0].'_auth_relation')
            ->where(array('group_id'=>$gid))->select();          
        // 查询所有权限
        $auths = M('authority')->order('auth_level ASC')->select();
        // 查询当前用户组信息
        $group = M($type_list[$gtype][0].'_group')
            ->field($type_list[$gtype][0].'_name')
            ->where(array($type_list[$gtype][0].'_id'=>$gid))->find();
        // 转换权限值数组的结构
        $auth_value = array();
        foreach ($relation as $row) {
            $auth_value[$row['auth_id']] = $row;
        }

        $this->assign('auth_value', $auth_value);
        $this->assign('auths', $auths);
        $this->assign('type_chs', $type_list[$gtype][1]);
        $this->assign('group_chs', $group[$type_list[$gtype][0].'_name']);
        $this->assign('group_type', $gtype);
        $this->assign('group_id', $gid);
        $this->display();
    }

    /**
     * 编辑用户组权限处理
     */
    public function editGroupHandle() {
        if (!IS_POST) $this->redirect('index');

        $type_list = array(
            1 => array('level', '晋级用户组'),
            2 => array('special', '特殊用户组'),
            3 => array('admin', '管理用户组'),
        );
        $group_type = I('post.group_type');
        $group_id = I('post.group_id');

        // 修改用户组名称
        if (I('post.group_name') == '') {
            flash('请输入用户名！');
            $this->redirect('index');
        } else {
            // 写入新的用户组名字
            $data = array($type_list[$group_type][0].'_name'=>I('post.group_name'));
            $result = M($type_list[$group_type][0].'_group')
                ->where(array($type_list[$group_type][0].'_id'=>$group_id))
                ->save($data);
        }
        // 查询权限id
        $auth_ids = M('authority')->field('auth_id')->select();
        // 先删除所有该用户在bss_group_auth_relation中的行
        $relation = M($type_list[$group_type][0].'_auth_relation');
        $relation->where(array('group_id'=>$group_id))->delete();
        // 重新写入相关的权限内容
        foreach ($auth_ids as $a_id) {
            if (!empty(I('post.auth_' . $a_id['auth_id']))) {
                $relation->data(array(
                    'group_id' => $group_id,
                    'auth_id' => $a_id['auth_id'],
                    'auth_value' => I('post.auth_' . $a_id['auth_id']),
                ))->add();
            }
        }
        flash('修改'.$type_list[$group_type][1].'下的用户组成功！', 'green');
        $this->redirect('index');
    }

    /**
     * 删除用户组确认
     */
    public function deleteGroup($gtype, $gid) {
        $type_list = array(
            1 => array('level', '晋级用户组'),
            2 => array('special', '特殊用户组'),
            3 => array('admin', '管理用户组'),
        );
        $group_name = $type_list[$gtype][0];
        $group_id = $gid;

        $memberNum = M($group_name.'_group')->where($group_name.'_id='.$gid)->getField($group_name.'_members');
        if($memberNum){
            flash('该用户组存在用户');
        }
        else{

            try {
                M($group_name.'_group')->where($group_name.'_id='.$gid)->delete();  
                flash('删除成功', 'green');    
            } catch (\Exception $e) {
                flash('删除失败');
            }                                  
        }
        $this->redirect('index');
    }
}