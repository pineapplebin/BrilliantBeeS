<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PlateController extends NormalBaseController {

    public function index() {
       $this -> display();
    }

    public  function forum(){
        $id = I('get.id');
        $post = M('plate');
        $condition['plate_id'] = $id;
        $result = $post->where($condition)->find();
        $post = M('post');
        $list = $post -> where(array('post_plate' => $id))->order('post_time DESC') -> select();

        if($result){
            $this -> assign('Plate', $result);
            $this -> assign('List', $list);
            $this -> display('index');
        } else{
            $this -> error('访问的板块不存在!');
        }

    }
}