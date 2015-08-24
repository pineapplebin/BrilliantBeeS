<?php
/**
 * Created by PhpStorm.
 * User: pineapplebin
 * Date: 15-8-12
 * Time: 下午6:27
 */
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Org\Util\Date;
use Think\Page;

class PlateManageController extends AdminBaseController {

    /**
     * 显示板块信息
     */
    public function index(){
        import('Think.Page');

        $count = M('plate')->count();
        $page=new Page($count,10);
        $limit=$page->firstRow.','.$page->listRows;
        $plate = M('plate')->order('plate_create_time DESC')->limit($limit)->select();
        $this->plate=$plate;
        $this->page=$page->show();
        $this->display();
        }

    /**
     * 新建板块
     */
    public function newPlate(){
//        if(!is_POST){
//            $this->redirect('./Admin/PlateManage/plateManage');
//        }
        $this->display();
    }
    public function newPlateHandle(){
//        if(!is_POST){
//            $this->redirect('./Admin/PlateManage/newPlate');
//        }
        $can_Save = true;
        /**
         * 判断是否为空
         * @plateName 板块名称
         * @plateDescription 板块描述
         */
        if(I('plateName')=='' || I('plateDescription')==''){
            flash('请输入板块完整信息');
            $can_Save=false;
            $this->redirect('newPlate');
        }
        //名称查重
        $newPlate=M('plate');
        $is_Exist=$newPlate->where(array('plate_name'=>'plateName'))->find();
        if($is_Exist){
            flash('板块名已被使用');
            $can_Save=false;
            $this->redirect('newPlate');
        }
        if($can_Save){
            $data=array(
                'plate_name'=>I('post.plateName'),
                'plate_desc'=>I('post.plateDescription'),
                'plate_create_time'=>date('Y-m-d H:i')
            );
            $result=$newPlate->data($data)->add();
            if($result){
                flash('板块创建成功','green');
                $this->redirect('plateManage');
            }else{
                flash('板块创建失败');
                $this->redirect('newPlate');
            }
        }else{
            flash('板块创建失败');
            $this->redirect('newPlate');
        }
    }

    /**
     * 删除板块确认
     */
    public function deletePlateCfm(){
        $delete = M('plate')->where(array('plate_id'=>I('id')))->select();
        $this->assign('delete',$delete);
        $this->display();

    }
    /**
     * 删除板块
     */
    public function deletePlateHandle(){
        $deletePlate=M('plate');
        $result=$deletePlate->where(array('plate_id'=>I('id')))->delete();
        if($result){
            flash('板块删除成功','green');
            $this->redirect('index');
        }else{
            flash('板块删除失败');
            $this->redirect('index');
        }

    }

    /**
     * 版主管理
     * @  在plate表中增加版主数plate_num字段,默认为0.
     * @  在user表中增加管理的版块的ID字段user_admin_group_plateNum,默认为0.
     * @  版块管理原则是一个具有版主身份的用户对应一个版块,一个版块对应多个版主.
     * @  当用户的user_admin_group_plateNum字段不为0时,表示已拥有管理的版块,
     *    增加版主时,在版主候选列表中不再显示该用户.
     * @  删除版主时,修改plate_num,并将user_admin_group_plateNum的值置0.
     *
     */
    public function plateAdminHandle(){
        $user = M('user');      //user表操作对象
        //列出版主(2),超级版主(3)
        $user_stamp['user_admin_group'] = array(
            array('gt',1),
            array('lt',4)
        );//1<user_admin_group<4,即2和3
        $user_stamp['user_admin_group_plateID'] = array('eq',I('pid'));
        $plate_id = I('pid');
        $user_admin = $user->where($user_stamp)->select();
        $this->assign('user_admin',$user_admin);
        $this->assign('plate_id',$plate_id);
        $this->display();
    }
    /**
     * 增加版主
     */
    public function addAdmin(){
        $plate_id = I('pid');
        $user_stamp['user_admin_group'] = array(
            array('gt',1),
            array('lt',4)
        );
        $user_stamp['user_admin_group_plateID'] = 0;
        $user = M('user')->where($user_stamp)->select();
        $this->assign('addAdmin',$user);
        $this->assign('plate_id',$plate_id);
        $this->display();
    }
    public function addAdminHandle() {
        $plate_id = I('post.pid');
        $plate = M('plate');    //plate表操作对象
        $user = M('user');      //user表操作对象
        $count = $plate->where(array('plate_id'=>$plate_id))->getField('plate_admin_num');
        if(!empty($_POST)){
            $id = I('post.check_all');
            $u_condition['user_id'] = array('in',$id);
            $p_condition['plate_id'] = $plate_id;
            $plate_data['plate_admin_num'] = $count+count($id);
            $p_result = $plate->where($p_condition)->save($plate_data);
            $user_data['user_admin_group_plateID'] = $plate_id;
            $u_result = $user->where($u_condition)->save($user_data);
            if ($p_result != false && $u_result !=false ){
                flash('添加成功!', 'green');
            } else{
                flash('添加失败!');
            }
            $this -> redirect('addAdmin');
        }else{
            $this -> display('plateAdminHandle');
        }
    }

    /**
     * 删除板块
     * @ 删除时,将user表的user_admin_group_plateID置0
     *   将plate表的plate_admin_num减1
     */
    public function delAdmin(){//确认删除页面
        $delete = M('user')->where(array('user_id'=>I('u_id')))->select();
        $this->assign('delete',$delete);
        $this->display();
    }
    public function delAdminHandle(){
        $user = M('user');
        $plate = M('plate');
        $plate_id = $user->where(array('user_id'=>I('u_id')))->getField('user_admin_group_plateID');
        $count = $plate->where($plate_id)->getField('plate_admin_num');
        $p_data['plate_admin_num'] = $count-1;
        $nul['user_admin_group_plateID']=0;
        $u_result = $user->where(array('user_id'=>I('u_id')))->save($nul);
        $p_result = $plate->where($plate_id)->save($p_data);
        if($u_result!=false && $p_result!=false){
            flash('删除成功','green');
            $this->redirect('plateAdminHandle');
        }else{
            flash('删除失败');
            $this->redirect('plateAdminHandle');
        }
    }
}