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
        $this->assign('post_title',$result[1]['post_title']);
        //时间戳转时间
        $result_time=$post->where(array('post_plate' => $id))->field('post_time')->select();
        $length=0;
        while($result_time[$length]!=''){            
            $times[$length]=date("Y-m-d",implode($result_time[$length]));
            $length++;
        }
        $this->assign('times',$times);
        $this->assign('num',0);
        $this->assign('plate_name',$plate_name);
        $this->assign('plate_desc',$plate_desc);
        $this->assign('result', $result);
        $this->assign('id',$id);
        $this->display();
    }

    public function handle(){  
          
        $plate_id = I('post.plate_id');
        $title = I('post.post_title');
        $content = I('post.post_content');

        if(session('user_name')==''||session('user_id')==''){
            flash('请先登录');
            $this->redirect('forum?id='.$plate_id);
        }
        if($title==''||$content==''){
            flash('主题和内容不能为空');
            $this->redirect('forum?id='.$plate_id);
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
        if($post->add($post_data)) $this->redirect('forum?id='.$plate_id);
        else {
            flash('发帖失败');
            $this->redirect('forum?id='.$plate_id);
        }
        
    }

}