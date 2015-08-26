<?php
/**
 * 注意use是加入Common\Controller\
 */
namespace Home\Controller;
use Common\Controller\NormalBaseController;

class IndexController extends NormalBaseController {
    public function index(){
        $plate = M('plate')->order('plate_create_time')->select();
        $this->assign('plate',$plate);
        $this->display();
    }

    public function install() {
        $sql = array(
            'create_tables' => file_get_contents('./create_tables.sql'),
            'insert_group' => file_get_contents('./insert_groups.sql'),
            'insert_rows' => file_get_contents('./insert_rows.sql'),
        );

        foreach ($sql as $k=>$sql_file) {
            echo 'Starting '.$k.'.sql file.<br>';
            $count = 0;
            $sentences = explode(';', $sql_file);
            foreach ($sentences as $s) {
                $temp = $s.';';
                mysql_query($temp);
                echo '.';
                $count++;
            }
            echo ' '.$count.' setences done.<br>';
        }
    }
}