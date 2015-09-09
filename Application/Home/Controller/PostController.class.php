<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class PostController extends NormalBaseController{

    public function index(){
        $post_id = I('get.post_id');
        $post = M('post');
        $reply = M('reply');
        $Post = $post->where(array('post_id' => $post_id))->find();            // 贴子信息
        $Reply = $reply->where(array('reply_post_id' => $post_id))->select();  // 回复贴信息
        $reply_num = count($Reply,1);                                              // 回复数
        if($Post){
            $this -> assign('Post',$Post);
            $this -> assign('Reply',$Reply);
            $this -> assign('reply_num',$reply_num);
            $this -> display();
        }else{
            $this->error('帖子不存在');
            redirect($_SERVER['HTTP_REFERER']);
        }

    }
    public  function handle(){
        if (!IS_POST) $this->redirect('Home/Index/index');
               
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
               
        if($can_save){
            $time = strtotime('now');
            $post_plate = I('post.plate_id');

            $post_data = array(
                'post_title' => $title,
                'post_content' => $content,
                'post_time' => $time,
                'post_last_reply_time' => $time,
                'post_plate' => $post_plate,
                'post_author_id' => $post_author_id,
                'post_author_name' => $post_author_name,
            );

            $post = M('post');
            $post_result = $post -> data($post_data) -> add();
            // 对应板块的帖子总数加1
            $plate = M('plate');
            $plate_result = $plate -> where(array('plate_id' => $post_plate))-> setInc('plate_post_count');

            if($post_result && $plate_result){
                flash('发贴成功!','green');
                $this -> redirect('/forum/'.$post_plate);
            }else{
                $this -> error('发贴失败!');
            }

        }else{
            $this -> error('发贴失败!');
        }
    }

    // 处理回帖
    public  function reply(){
        if(!empty($_POST)){
            $reply_content = I('post.reply_content');
            $reply_post_id = I('reply_post_id');
            $reply_author_id = session('user_id');
            $reply_author_name = session('user_name');

            $can_save = true;

            if($reply_content == '' || $reply_post_id == ''){
                $can_save = false;
                $this -> error('回复内容不能为空!');
                exit;
            }
            if($reply_author_id == '' || $reply_author_name == ''){
                $can_save = false;
                $this -> error('你没有发帖的权限,请升级!');
            }

            if($can_save){
                $reply_time = strtotime('now');
                $reply = M('reply');
                $post = M('post');

                $Post= $post -> where(array('post_id' => $reply_post_id))-> find();
                $post_reply_count = $Post['post_reply_count'] + 2;                  //楼层数=当前回复数+2

                $data = array(
                    'reply_post_id' => $reply_post_id,
                    'reply_content' => $reply_content,
                    'reply_author_id' => $reply_author_id,
                    'reply_author_name' => $reply_author_name,
                    'reply_time' => $reply_time,
                    'reply_floor' => $post_reply_count
                );
                $reply_result=$reply -> data($data) -> add();

                // 更新帖子回复数,最后回复时间
                $post -> post_last_reply_count = $post_reply_count;
                $post -> post_last_reply_time = $reply_time;
                $post_result = $post -> where(array('post_id' => $reply_post_id))-> setInc('post_reply_count');

                if($reply_result && $post_result){
                    flash('回帖成功!','green');
                    $this -> redirect('index?post_id='.$reply_post_id);
                }else{
                    $this -> error('回帖失败!');
                }
            }


        }else{
            $this -> display('Plate/index');
        }
    }
}