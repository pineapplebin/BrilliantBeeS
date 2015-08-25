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

	public function index(){				
		$this->display();
	}

		
	public function handle(){

		//获取表名，即哪个管理组
		$tab= I('post.paritem');     
		//获取表内字段名
		if($tab=='admin_group') $arr= I('post.sub_admin');
		else if($tab=='special_group') $arr= I('post.sub_special');
		else $arr= I('post.sub_level');
		//获取权限表			
		$this->redirect('show_auth?t='.$tab.'&tt='.$arr);
	}
	
		//处理各组权限的显示
	public function show_auth($t,$tt){

		$table = $t;
		$attribute = $tt;
		
		if($table==''||$attribute=='') $this->redirect('index');
		$auth = M('authority');
		$group = M($table);		
		$auth_list = $auth->field('auth_name')->select();

		if($table=='admin_group'){
			switch ($attribute) {
				case 'noviciate_moderator':
					$group_list=$group->where('admin_name="noviciate_moderator"')->getField('admin_group_auth');
					break;
				case 'moderator':
					$group_list=$group->where('admin_name="moderator"')->getField('admin_group_auth');
					break;
				case 'super_moderator':
					$group_list=$group->where('admin_name="super_moderator"')->getField('admin_group_auth');
					break;
				case 'admin':				
					$group_list=$group->where('admin_name="admin"')->getField('admin_group_auth');	
					break;				
				default:				
					break;
			}
		}
		else if($table=='special_group'){
			switch ($attribute) {
				case 'banned_to_post':
					$group_list=$group->where('special_name="banned_to_post"')->getField('special_group_auth');
					break;
				case 'banned_to_visit':
					$group_list=$group->where('special_name="banned_to_visit"')->getField('special_group_auth');
					break;
				case 'ban_ip':
					$group_list=$group->where('special_name="ban_ip"')->getField('special_group_auth');
					break;
				case 'is_tourist':
					$group_list=$group->where('special_name="is_tourist"')->getField('special_group_auth');
					break;
				case 'wait_for_verify':
					$group_list=$group->where('special_name="wait_for_verify"')->getField('special_group_auth');
					break;			
				default:				
					break;
			}
		}
		else{
			switch ($attribute) {				
				case 'level1':
					$group_list=$group->where('level_name="level1"')->getField('level_group_auth');
					break;		
				case 'level2':
					$group_list=$group->where('level_name="level2"')->getField('level_group_auth');
					break;		
				case 'level3':
					$group_list=$group->where('level_name="level3"')->getField('level_group_auth');
					break;		
				case 'level4':
					$group_list=$group->where('level_name="level4"')->getField('level_group_auth');
					break;		
				case 'level5':
					$group_list=$group->where('level_name="level5"')->getField('level_group_auth');
					break;		
				case 'level6':
					$group_list=$group->where('level_name="level6"')->getField('level_group_auth');
					break;		
				case 'level7':
					$group_list=$group->where('level_name="level7"')->getField('level_group_auth');
					break;		
				case 'level8':
					$group_list=$group->where('level_name="level8"')->getField('level_group_auth');
					break;		
				case 'level9':
					$group_list=$group->where('level_name="level9"')->getField('level_group_auth');
					break;		
				case 'levelx':
					$group_list=$group->where('level_name="levelx"')->getField('level_group_auth');
					break;		
				default:				
					break;
			}
		}	
		for($j=0;$j<35;$j++) $arry[$j]=$group_list[$j];
		$this->assign('group_list',$arry);
		$this->assign('auth_list',$auth_list);
		$this->assign('table',$table);
		$this->assign('attribute',$attribute);
		$this->assign('num',0);
		$this->display('index');		
	}	

	//获取35个checkbox的选择并存数据库
	public function save_auth(){
		$arry = array();
		for($j=0;$j<35;$j++) $arry[$j]='0';
		for($i=0;$i<35;$i++){
			if(I('post.selects'.$i)) $arry[$i] = I('post.selects'.$i);
			else continue;
		}

		$auths='';
		for($i=0;$i<35;$i++) $auths=$auths.$arry[$i];
		$attribute=I('post.attribute_name');
		$table=I('post.table_name');		
		if($table==''||$attribute=='') $this->redirect('index');
		$save_auth = M(I('post.table_name'));

		$data_admin['admin_group_auth']=$auths;
		$data_special['special_group_auth']=$auths;
		$data_level['level_group_auth']=$auths;
		
		if($table=='admin_group'){			
		switch ($attribute) {
				case 'noviciate_moderator':					
					$save_auth->where('admin_name="noviciate_moderator"')->save($data_admin);				
					break;
				case 'moderator':
					$save_auth->where('admin_name="moderator"')->save($data_admin);
					break;
				case 'super_moderator':
					$save_auth->where('admin_name="super_moderator"')->save($data_admin);
					break;
				case 'admin':
					$save_auth->where('admin_name="admin"')->save($data_admin);													
					break;				
				default:				
					break;
			}
		}		
		else if($table=='special_group'){
			switch (I('post.attribute_name')) {
				case 'banned_to_post':					
					$save_auth->where('special_name="banned_to_post"')->save($data_special);
					break;
				case 'banned_to_visit':					
					$save_auth->where('special_name="banned_to_visit"')->save($data_special);
					break;
				case 'ban_ip':
					$save_auth->where('special_name="ban_ip"')->save($data_special);
					break;
				case 'is_tourist':
					$save_auth->where('special_name="is_tourist"')->save($data_special);
					break;
				case 'wait_for_verify':
					$save_auth->where('special_name="wait_for_verify"')->save($data_special);
					break;			
				default:				
					break;
			}
		}
		else{
			switch (I('post.attribute_name')) {				
				case 'level1':
					$save_auth->where('level_name="level1"')->save($data_level);
					break;		
				case 'level2':
					$save_auth->where('level_name="level2"')->save($data_level);
					break;		
				case 'level3':
					$save_auth->where('level_name="level3"')->save($data_level);
					break;		
				case 'level4':
					$save_auth->where('level_name="level4"')->save($data_level);
					break;		
				case 'level5':
					$save_auth->where('level_name="level5"')->save($data_level);
					break;		
				case 'level6':
					$save_auth->where('level_name="level6"')->save($data_level);
					break;		
				case 'level7':
					$save_auth->where('level_name="level7"')->save($data_level);
					break;		
				case 'level8':
					$save_auth->where('level_name="level8"')->save($data_level);
					break;		
				case 'level9':
					$save_auth->where('level_name="level9"')->save($data_level);
					break;		
				case 'levelx':
					$save_auth->where('level_name="levelx"')->save($data_level);
					break;		
				default:				
					break;
			}
		}
		$this->redirect('show_auth?t='.$table.'&tt='.$attribute);
	}
}


