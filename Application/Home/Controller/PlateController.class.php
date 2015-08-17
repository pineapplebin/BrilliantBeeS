<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PlateController extends NormalBaseController {

    public function forum() {
        $id = $_GET['id'];
        $post = M('post');
        $result = $post->where(array('post_plate' => $id))->select();
        $this->assign('result', $result);
        $this->display();
    }

    public function index() {
        echo '<a href="'.U('/forum/1').'">click me</a>';
    }

    public function test() {
        $a = array('1' => 1, '2' => 2);
        print_array(strtotime('now'), 1);
        print_array($a, 1);
    }

}