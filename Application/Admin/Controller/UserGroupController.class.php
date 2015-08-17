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

	//处理各组权限的显示
	public function show_auth(){
		//获取表名，即哪个管理组
		$table = I('post.paritem');     
		//获取表内字段名
		$attribute = I('post.subitem');						
		//获取权限表
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
		else if($table==''){}
		else if($table=='special_group'){
			switch ($attribute) {
				case 'banned_to_post':
					$group_list=$group->where('special_name="banned_to_post"')->getField('special_group_auth');
					break;
				case 'banned_to_visit ':
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
		$arry = $this->eight_to_ten($group_list);
		$this->ten_to_eight($arry);
		$this->assign('group_list',$arry);
		$this->assign('auth_list',$auth_list);
		$this->assign('table',$table);
		$this->assign('attribute',$attribute);
		$this->display('index');
	}
	public function edit_auth(){
		//获取表名，即哪个管理组
		$table = I('post.paritem');     
		//获取表内字段名
		$attribute = I('post.subitem');	
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
				case 'banned_to_visit ':
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
		$arry = $this->eight_to_ten($group_list);				
		$this->assign('group_list',$arry);
		$this->assign('auth_list',$auth_list);
		$this->assign('table',$table);
		$this->assign('attribute',$attribute);
		$this->assign('num',0);
		$this->display();
	}

	public function new_auth(){
		$arry = array();
		for($j=0;$j<35;$j++) $arry[$j]='0';
		for($i=0;$i<35;$i++){
			if(I('post.selects'.$i)) $arry[$i] = I('post.selects'.$i);
			else continue;
		}	

		$auths = $this->ten_to_eight($arry);
		$attribute=I('post.attribute_name');
		$table=I('post.table_name');
		if($table==''||$attribute=='') $this->redirect('index');
		$save_auth = M(I('post.table_name'));
		$data['admin_group_auth']=$auths;
		
		if($table=='admin_group'){			
		switch ($attribute) {
				case 'noviciate_moderator':					
					$save_auth->where('admin_name="noviciate_moderator"')->save($data);				
					break;
				case 'moderator':
					$save_auth->where('admin_name="moderator"')->save($data);
					break;
				case 'super_moderator':
					$save_auth->where('admin_name="super_moderator"')->save($data);
					break;
				case 'admin':
					$save_auth->where('admin_name="admin"')->save($data);													
					break;				
				default:				
					break;
			}
		}		
		else if($table=='special_group'){
			switch (I('post.attribute_name')) {
				case 'banned_to_post':
					$save_auth->where('special_name="banned_to_post"')->save($auths);
					break;
				case 'banned_to_visit ':
					$save_auth->where('special_name="banned_to_visit"')->save($auths);
					break;
				case 'ban_ip':
					$save_auth->where('special_name="ban_ip"')->save($auths);
					break;
				case 'is_tourist':
					$save_auth->where('special_name="is_tourist"')->save($auths);
					break;
				case 'wait_for_verify':
					$save_auth->where('special_name="wait_for_verify"')->save($auths);
					break;			
				default:				
					break;
			}
		}
		else{
			switch (I('post.attribute_name')) {				
				case 'level1':
					$save_auth->where('level_name="level1"')->save($auths);
					break;		
				case 'level2':
					$save_auth->where('level_name="level2"')->save($auths);
					break;		
				case 'level3':
					$save_auth->where('level_name="level3"')->save($auths);
					break;		
				case 'level4':
					$save_auth->where('level_name="level4"')->save($auths);
					break;		
				case 'level5':
					$save_auth->where('level_name="level5"')->save($auths);
					break;		
				case 'level6':
					$save_auth->where('level_name="level6"')->save($auths);
					break;		
				case 'level7':
					$save_auth->where('level_name="level7"')->save($auths);
					break;		
				case 'level8':
					$save_auth->where('level_name="level8"')->save($auths);
					break;		
				case 'level9':
					$save_auth->where('level_name="level9"')->save($auths);
					break;		
				case 'levelx':
					$save_auth->where('level_name="levelx"')->save($auths);
					break;		
				default:				
					break;
			}
		}
		$this->redirect('index');
	}

	//数字转换函数，3位二进制和十进制的转换
	public function eight_to_ten($data){
		//$data为用户权限，$array为对应$data数据的35个元素
		//arr为数组$arry		
		$arry = array();
		$arrys = array();
		$arr=0;	
		for($i=0;$i<12;$i++){
			switch ($data[$i]) {
				case '0':
				$arry[$arr++]='0';
				$arry[$arr++]='0';
				$arry[$arr++]='0';			
					break;
				case '1':
				$arry[$arr++]='0';
				$arry[$arr++]='0';
				$arry[$arr++]='1';				
					break;
				case '2':
				$arry[$arr++]='0';
				$arry[$arr++]='1';
				$arry[$arr++]='0';
					break;
				case '3':
				$arry[$arr++]='0';
				$arry[$arr++]='1';
				$arry[$arr++]='1';
					break;
				case '4':
				$arry[$arr++]='1';
				$arry[$arr++]='0';
				$arry[$arr++]='0';
					break;
				case '5':
				$arry[$arr++]='1';
				$arry[$arr++]='0';
				$arry[$arr++]='1';
					break;
				case '6':
				$arry[$arr++]='1';
				$arry[$arr++]='1';
				$arry[$arr++]='0';
					break;
				case '7':
				$arry[$arr++]='1';
				$arry[$arr++]='1';
				$arry[$arr++]='1';
					break;				
				default:				
					break;
			}
		}
		for($j=0;$j<35;$j++) $arrys[$j]=$arry[$j];
		return $arrys;		
	}

	//数字转换函数，十进制和3位二进制的转换
	public function ten_to_eight($data){
		$data[35]='1';
		$arr=0;	
		$s_auth='';		
		for($i=0;$i<12;$i++){
			$temp=$data[$arr].$data[$arr+1].$data[$arr+2];
			switch ($temp) {
				case '000':
					$s_auth=$s_auth.'0';
					break;
				case '001':
					$s_auth=$s_auth.'1';
					break;
				case '010':
					$s_auth=$s_auth.'2';
					break;
				case '011':
					$s_auth=$s_auth.'3';
					break;
				case '100':
					$s_auth=$s_auth.'4';
					break;
				case '101':
					$s_auth=$s_auth.'5';
					break;
				case '110':
					$s_auth=$s_auth.'6';
					break;
				case '111':
					$s_auth=$s_auth.'7';
					break;				
				default:
					break;
			}
			$arr=$arr+3;
		}
		return $s_auth;
	}

}