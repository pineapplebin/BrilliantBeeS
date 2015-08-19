<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PlateController extends NormalBaseController {

    public function forum() {
        //获取板块id
        $id = $_GET['id'];

        $post = M('post');
        $plate = M('plate');
        $user = M('user');
        //获取板块名称与描述
        $plate_name = $plate->where('plate_id='.$id)->getField('plate_name');
        $plate_desc = $plate->where(array('plate_id'=>$id))->getField('plate_desc');
        //版主名
        //......
        //获取该块帖子
        $result = $post->where(array('post_plate' => $id))->select();
        $this->assign('plate_name',$plate_name);
        $this->assign('plate_desc',$plate_desc);
        $this->assign('result', $result);
        $this->display();
    }

    public function index() {
        //echo '<a href="'.U('/forum/14').'">click me</a>';
        echo U('Post/index');
    }

    public function test() {
        $a = array('1' => 1, '2' => 2);
        print_array(strtotime('now'), 1);
        print_array($a, 1);
    }

}