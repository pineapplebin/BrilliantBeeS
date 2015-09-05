<?php
/**
 * Created by PhpStorm.
 * User: pineapplebin
 * Date: 15-8-25
 * Time: 下午8:08
 */
echo '<meta charset="UTF-8">';

$con = mysql_connect('localhost', 'root', '');
mysql_query("SET NAMES UTF8");

$sql = array(
    'create_tables' => file_get_contents('create_tables.sql'),
    'insert_group' => file_get_contents('insert_groups.sql'),
    'insert_rows' => file_get_contents('insert_rows.sql'),
);

foreach ($sql as $k=>$sql_file) {
    echo 'Starting '.$k.'.sql file.<br>';
    $count = 0;
    $sentences = explode(';', $sql_file);
    foreach ($sentences as $s) {
        $temp = $s.';';
        if (mysql_query($temp, $con)) {
            echo '.';
            $count++;
        } else {
//            echo '<br>Error!!!!Please try again.';
//            mysql_close($con);
//            die();
        }
    }
    echo ' '.$count.' setences done.<br>';
}

mysql_close($con);