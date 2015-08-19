<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PostController extends NormalBaseController{

    public function index(){
        if(!empty($_POST)){
            $title = I('post.post_title');
            $content = I('post.post_content');
            $post_author_id = session('user_id');
            $post_author_name = session('user_name');

            $can_save = true;

            if($title == '' || $content == ''){
                $can_save = false;
                $this -> error('标题和内容不能为空');
                exit;
            }
            if($post_author_id == '' || $post_author_name == ''){
                $can_save = false;
                $this -> error('你没有发帖的权限,请升级!');
            }
            if($can_save){
                $time = strtotime('now');
                $post_plate = I('post.plate_id');

                $data = array(
                    'post_title' => $title,
                    'post_content' => $content,
                    'post_time' => $time,
                    'post_last_reply_time' => $time,
                    'post_plate' => $post_plate,
                    'post_author_id' => $post_author_id,
                    'post_author_name' => $post_author_name,
                );

                $post = M('post');
                $post_result = $post -> data($data) -> add();
                // 对应板块的帖子总数加1
                $plate = M('plate');
                $plate_result = $plate -> where(array('plate_id' => $post_plate))-> setInc('plate_post_count');

                if($post_result && $plate_result){
                    flash('发贴成功!');
                    $this -> redirect('Index/index');
                }else{
                    $this -> error('发贴失败!');
                }

            }else{
                $this -> error('发贴失败!');
            }

        }else{
            $this -> display('Plate/index');
        }
    }
}