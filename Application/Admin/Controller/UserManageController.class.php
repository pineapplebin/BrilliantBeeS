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

    /**
     * 用户管理首页
     * 显示用户信息
     */
    public function index() {
        // 数据分页
        $user = M('user');
        $count = $user->count();             // 总条数
        $page = new \Think\Page($count, 15);    // 设置每页显示条数为10条

        // 分页设置
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('end', '末页');
        $this->assign('count',$count);     //总记录数
        $list = $user->order('user_id DESC')
            ->limit($page->firstRow.','.$page->listRows)->select();

        // 读取数据库得到bbs_user里面group_id表示的组别
        $type_group = array(
            'level' => M('level_group')->select(),
            'special' => M('special_group')->select(),
            'admin' => M('admin_group')->select(),
        );
        $group_info = array();
        foreach ($type_group as $key=>$type) {
            foreach ($type as $group) {
                $group_info[$key][$group[$key.'_id']] = $group;
            }
        }

        $show = $page -> show();
        $this->assign('title', '用户管理');
        $this->assign('group_info', $group_info);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 搜索处理
     * 按输入的搜索语句进行搜索，若为空则重定向至用户管理首页
     */
    public function search() {
        if (!IS_POST || I('post.search') == '') $this->redirect('index');
        $search = I('post.search');

        // 更换内容
        $search = str_replace('&gt;', '>', $search);
        $search = str_replace('&lt;', '<', $search);
        $search = str_replace('&amp;', '&', $search);

        // 检验语法
        $element_list = preg_split('/ +/', $search);
        $l_bracket_count = 0;
        $r_bracket_count = 0;
        // 遍历元素
        $field_list = array('id', 'name', 'email', 'level_group', 'special_group', 'admin_group');
        foreach ($element_list as $key=>$element) {
            if (preg_match('/;/', $element)) {
                flash('搜索语句有误，请检验语句是否合法');
                $this->redirect('index', array('s'=>$search));
            }
            if (preg_match('/[=\&\|\(\)][\w\d]+$/', $element) ||
                preg_match('/^[\w\d]+[=\&\|\(\)]/', $element)) {
                flash('搜索语句有误，请检验空格是否有遗漏');
                $this->redirect('index', array('s'=>$search));
            }
            switch ($element) {
                case '(' : $l_bracket_count++; break;
                case ')' : $r_bracket_count++; break;
                case 'time' :
                    $element_list[$key] = 'user_signup_time';
                    $element_list[$key+2] = strtotime($element_list[$key+2]);
                    break;
            }
            if (in_array($element, $field_list)) {
                $element_list[$key] = 'user_'.$element;
                $element_list[$key+2] = '\''.$element_list[$key+2].'\'';
            }
        }
        if ($l_bracket_count != $r_bracket_count) {
            flash('搜索语句有误，请检验输入的搜索语句中的括号是否成对或空格是否有遗漏');
            $this->redirect('index', array('s'=>$search));
        }
        $new_search = implode(' ', $element_list);

        $user = M('user');
        $condition = array('_string' => $new_search);
        try {
            $result = $user->where($condition)->limit(50)->select();
            if (!$result) {
                $this->assign('notice', '没有找到相关的用户');
            }
            // 读取数据库得到bbs_user里面group_id表示的组别
            $type_group = array(
                'level' => M('level_group')->select(),
                'special' => M('special_group')->select(),
                'admin' => M('admin_group')->select(),
            );
            $group_info = array();
            foreach ($type_group as $key=>$type) {
                foreach ($type as $group) {
                    $group_info[$key][$group[$key.'_id']] = $group;
                }
            }

            $this->assign('count', count($result));
            $this->assign('list', $result);
            $this->assign('title', '用户搜索 - 搜索语句为<code>'.$search.'</code>');
            $this->assign('group_info', $group_info);
            $this->display('index');
        } catch(\Exception $e) {
            flash('搜索失败，请检验查询语句是否无误');
            $this->redirect('index', array('s'=>$search));
        }
//        print_array($new_search);
    }

    /**
     * 修改用户信息
     * @param $user_id
     */
    public function update($user_id){
        $user = M('user');        

        $info = $user->find($user_id);  // 一维数组
        if($info == NULL){
            flash('用户不存在！');
            $this -> redirect('index');
        }

        // 读取数据库得到bbs_user里面group_id表示的组别
        // 生成option标签以供选择
        $type_group = array(
            'level' => M('level_group')->select(),
            'special' => M('special_group')->select(),
            'admin' => M('admin_group')->select(),
        );
        $group_info = array();
        foreach ($type_group as $key=>$type) {
            foreach ($type as $group) {
                $group_info[$key][$group[$key.'_id']] = $group;
            }
        }

        $this->assign('info',$info);
        $this->assign('group_info', $group_info);
        $this->display();
    }

    /**
     * 修改用户数据处理
     */
    public function updateHandle() {
        if (!IS_POST) $this->redirect('index');

        $user = M('user');
        //更新前用户情况
        $condition = array('user_id' => $_POST['user_id']);
        $oldGroup = $user->where($condition)->field('user_level_group, user_special_group, user_admin_group')->find();
        
        //搜索变动的分组情况
        $group_type[0] = 'user_level_group';
        $group_type[1] = 'user_special_group';
        $group_type[2] = 'user_admin_group';

        for($i = 0; $i <3; $i++){
            //得到如level_group或者。。。
            preg_match('/(sp).*p|(ad).*p|(le).*p/', $group_type[$i], $type_name); 
            //得到如level或者。。。
            $type = preg_split('/_/', $type_name[0])[0];            

            //发现post的和原来的分组情况有改变,原来不是0的-1，是0的不变，新的+1
            if($oldGroup[$group_type[$i]]!=$_POST[$group_type[$i]]){
                //原来的不变，新的+1
                if($oldGroup[$group_type[$i]]=='0' && $_POST[$group_type[$i]]!='0'){
                    $condition = array($type.'_id' => $_POST[$group_type[$i]]);
                    $newNum[$type.'_members'] = (int)M($type_name[0])->where($condition)->getField($type.'_members') + 1;                    
                    M($type_name[0])->where($condition)->save($newNum);
                }
                //原来的-1，新的不变
                else if($oldGroup[$group_type[$i]]!='0' && $_POST[$group_type[$i]]=='0'){
                    $condition = array($type.'_id' => $oldGroup[$group_type[$i]]);
                    $newNum[$type.'_members'] = (int)M($type_name[0])->where($condition)->getField($type.'_members') - 1;                    
                    M($type_name[0])->where($condition)->save($newNum);
                }
                //原来的-1，新的+1
                else if($oldGroup[$group_type[$i]]!='0' && $_POST[$group_type[$i]]!='0'){
                    $conditionNEW = array($type.'_id' => $_POST[$group_type[$i]]);
                    $conditionOLD = array($type.'_id' => $oldGroup[$group_type[$i]]);
                    $newNum[$type.'_members'] = (int)M($type_name[0])->where($conditionNEW)->getField($type.'_members') + 1;                    
                    M($type_name[0])->where($conditionNEW)->save($newNum);
                    $newNum[$type.'_members'] = (int)M($type_name[0])->where($conditionOLD)->getField($type.'_members') - 1;                    
                    M($type_name[0])->where($conditionOLD)->save($newNum);
                }
            }                        
            
        }
       

        try {
            $user->create();            
            $result = $user->save();

        } catch(\Exception $e) {
            flash('发生错误，请重新尝试！');
            $this->redirect('update');
        }

        if($result != false){
            flash('数据修改成功！','green');
        } else {
            flash('数据未作更改!');
        }
        $this ->redirect('index');
    }

    /**
     * 删除用户页面
     *
     * 还应判断该用户是否存在管理板块的情况，
     * 若存在，则需要先处理才能删除
     *
     * @param $user_id
     */
    public function delete($user_id){
        $user = M('user')->where(array('user_id'=>$user_id))->find();
        $can_delete = true;

        // 查找是否正在管理某个板块
        $relation = M('user_plate_relation')
            ->join('bbs_plate ON bbs_user_plate_relation.plate_id=bbs_plate.plate_id')
            ->where(array('user_id'=>$user_id))->select();
        if (count($relation) != 0) {
            $can_delete = false;
            $this->assign('plates', $relation);
        }

        $this->assign('user',$user);
        $this->assign('can_delete', $can_delete);
        $this->display();
    }

    /**
     * 删除用户处理
     */
    public function deleteHandle() {
        if (!IS_POST) $this->redirect('index');

        $user = M('user');
        $id = I('post.user_id');
        $condition['user_id'] = $id;

        try {
            $result = $user->where($condition)->delete();
        } catch(\Exception $e) {
            flash('发生错误，请重新尝试');
            $this->redirect('delete', array('user_id'=>$id));
        }

        if ($result != false) {
            flash('删除成功!', 'green');
        } else {
            flash('删除失败!');
        }

        $this -> redirect('index');
    }


    /**
     * 批量删除用户处理
     */
    function deleteBatchHandle(){
        if (!IS_POST) $this->redirect('index');

        $user = M('user');
        $ids = I('post.delete_all');

        // 批量删除只能删除不属于管理用户组的用户
        $condition = array(
            'user_id' => array('in', $ids),
            'user_admin_group' => 0,
        );

        try {
            $result = $user->where($condition)->delete();
            if ($result != count($ids)) {
                $flash_msg = '批量删除只能删除不属于管理用户组的用户！其他用户已被删除';
            } else {
                $flash_msg = '批量选中的用户已全被删除！';
            }
            flash($flash_msg, 'green');
        } catch(\Exception $e) {
            flash('发生错误，请重新尝试！');
        }

        $this -> redirect('index');
    }

    /**
     * 添加用户页面
     */
    public function add(){
        // 读取数据库得到bbs_user里面group_id表示的组别
        // 生成option标签以供选择
        $type_group = array(
            'level' => M('level_group')->select(),
            'special' => M('special_group')->select(),
            'admin' => M('admin_group')->select(),
        );
        $group_info = array();
        foreach ($type_group as $key=>$type) {
            foreach ($type as $group) {
                $group_info[$key][$group[$key.'_id']] = $group;
            }
        }

        $this->assign('group_info', $group_info);
        $this->display();
    }

    /**
     * 添加用户处理
     */
    public function addHandle() {
        if (!IS_POST) $this->redirect('index');

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

        // 数据写入
        if ($can_save) {
            $data = array(
                'user_name' => $username,
                'user_password' => $password,
                'user_email' => $email,
                'user_signup_time' => strtotime('now'),
                'user_level_group' => I('post.user_level_group'),
                'user_special_group' => I('post.user_special_group'),
                'user_admin_group' => I('post.user_admin_group'),
            );
            try {
                $user->data($data)->add();
                flash('添加用户成功！', 'green');
                $this->redirect('index');
            } catch(\Exception $e) {
                flash('发生错误，请重新尝试！');
                $this->redirect('add');
            }
        } else {
            $this -> redirect('add');
        }
    }
}