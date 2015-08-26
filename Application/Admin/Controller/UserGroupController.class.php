<?php
/**
 * Created by PhpStorm.
 * User: pineapplebin
 * Date: 15-8-12
 * Time: 下午6:27
 */
namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class UserGroupController extends AdminBaseController {

	/**
	 * 用户组权限管理首页
	 */
	public function index() {
		$this->display();
	}

		
	public function handle() {
		// 获取表名，即哪个管理组
		$tab = I('post.paritem');
		// 获取表内字段名
		if ($tab =='admin_group') {
			$arr = I('post.sub_admin');
		} else if ($tab =='special_group') {
			$arr = I('post.sub_special');
		} else {
			$arr = I('post.sub_level');
		}
		// 获取权限表
		$this->redirect('show_auth?t='.$tab.'&tt='.$arr);
	}
	
		//处理各组权限的显示
	public function show_auth($t, $tt) {
		$table = $t;
		$attribute = $tt;
		
		if($table == '' || $attribute == '') $this->redirect('index');
		$auth = M('authority');
		$group = M($table);
		$auth_list = $auth->field('auth_name')->select();

		// 拼装字符串，查询字段
		$group_type = preg_split('/_/', $table)[0];
		$condition = array(
			$group_type.'_name' => $attribute,
		);
		$target_field = $table.'_auth';
		$group_list = $group->where($condition)->getField($target_field);

		$array = array();
		for ($j=0; $j<35; $j++) {
			$array[$j] = $group_list[$j];
		}
		$this->assign('group_list',$array);
		$this->assign('auth_list',$auth_list);
		$this->assign('table',$table);
		$this->assign('attribute',$attribute);
		$this->assign('num',0);
		$this->display('index');
	}	

	//获取35个checkbox的选择并存数据库
	public function save_auth(){
		$arry = array();
		for($j = 0; $j < 35; $j++) {
			$arry[$j]='0';
		}
		for($i = 0; $i < 35; $i++){
			if (I('post.selects'.$i)) {
				$arry[$i] = I('post.selects'.$i);
			}
			else continue;
		}

		$auths = '';
		for ($i = 0; $i < 35; $i++) {
			$auths=$auths.$arry[$i];
		}
		$attribute = I('post.attribute_name');
		$table = I('post.table_name');
		if($table == '' || $attribute == '') $this->redirect('index');
		$save_auth = M($table);


		$group_type = preg_split('/_/', $table)[0];
		$condition = array(
			$group_type.'_name' => $attribute,
		);
		$data = array(
			$table.'_auth' => $auths,
		);
		$save_auth->where($condition)->save($data);
		
		$this->redirect('show_auth?t='.$table.'&tt='.$attribute);
	}
}


