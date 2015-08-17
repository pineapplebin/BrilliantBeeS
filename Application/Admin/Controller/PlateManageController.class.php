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
    public function plateManage(){
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
                $this->redirect(U('./Admin/PlateManage/newPlate'));
            }
        }else{
            flash('板块创建失败');
            $this->redirect(U('./Admin/PlateManage/newPlate'));
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
            $this->redirect('./Admin/PlateManage/plateManage');
        }else{
            flash('板块删除失败');
            $this->redirect('./Admin/PlateManage/plateManage');
        }

    }
}