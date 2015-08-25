<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PostController extends NormalBaseController {

    public function index($id,$plate_name) {
        $plate_id = I('get.id');
        $plate_name = I('get.plate_name');
        
        if(session('user_name')==''||session('user_id')==''){
            flash('请先登录');
            $this->redirect('Plate/forum?id='.$plate_id);
        }
        $this->assign('plate_id',$plate_id);
        $this->assign('plate_name',$plate_name);
        $this->display();
    }

    //发帖处理函数
    public function handle(){
        $title = I('post.post_title');
        $content = I('post.post_content');
        $plate_id = I('post.plate_id');

        if($title==''||$content==''){
            flash('主题和内容不能为空');
            $this->redirect('index?id='.$plate_id);
        }

        $time = time();
        $auth_name = session('user_name');
        $auth_id = session('user_id');
        $last_reply_time = $time;

        $post_data['post_title']=$title;
        $post_data['post_content']=$content;
        $post_data['post_time']=$time;
        $post_data['post_last_reply_time']=$last_reply_time;
        $post_data['post_author_id']=$auth_id;
        $post_data['post_author_name']=$auth_name;
        $post_data['post_plate']=$plate_id;

        $post=M('post');
        if($post->add($post_data)) $this->redirect('Plate/forum?id='.$plate_id);
        else {
            flash('发帖失败');
            $this->redirect('index?id='.$plate_id);
        }

    }

    //浏览贴函数
    public function forum($id,$plate_id,$plate_name){
        $post_id = I('get.id');        
        $plate_id = I('get.plate_id');
        $plate_name = I('get.plate_name');

        $post_title = M('post')->where('post_id='.$post_id)->getField('post_title');
        $this->assign('plate_id',$plate_id);
        $this->assign('plate_name',$plate_name);
        $this->assign('post_title',$post_title);
        $this->assign('post_id',$post_id);

        
        $this->display();

    }
}