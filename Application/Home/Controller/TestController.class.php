<?php
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class TestController extends NormalBaseController {

    public function index() {
        echo '<html><head><meta charset="UTF-8"></head>';
        echo '<body><p>确定？</p><a href="'.U('test').'">yes</a></body></html>';
    }

    public function test() {
        // 实例化类，以表的名字作参数，不需要写前缀，类文件路径如下
        $forgery = new \Common\Common\Forgery('plate');

        // 添加需要随机的字段，第二参数为内容种类，具体看类的注释
        $forgery->add_field('plate_name', 'name');
//        $forgery->add_field('user_email', 'email');
//        $forgery->add_field('user_password', 'password');

        // 添加完字段之后，执行fake方法即可生成并写入数据库，参数为需要生成的数量
        // fake返回成功插入的数量
        $result = $forgery->fake(20);

        echo '<html><head><meta charset="UTF-8"></head><body>';
        echo '<p>成功插入了'.$result.'条数据，快去数据库查看吧</p>';
    }
}