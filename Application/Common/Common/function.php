<?php
/**
 * 测试函数
 * @param $arr
 */
function i_p($arr) {
    echo '<br />'.$arr;
}

/**
 * 消息闪现函数
 * 在控制器视图函数中以需要闪现的内容为参数调用此函数，
 * 然后即可在下个显示的页面的模板中以get_flash_messages()函数显示闪现内容
 *
 * 例如，在注册页面中，后台处理后发现用户名重复，即可使用此函数，
 * 并重定向至注册页面或其他页面，均能显示内容
 *
 * 第二参数是消息样式颜色，目前使用bootstrap样式，默认为红色
 * 即alert-danger
 *
 * @param $msg 消息内容
 * @param $color 消息样式颜色，默认为red
 */
function flash($msg, $color='red') {
    $type = '';
    switch ($color) {
        case 'red': $type = 'alert-danger';break;
        case 'yellow': $type = 'alert-warning';break;
        case 'green': $type = 'alert-success';break;
        case 'blue': $type = 'alert-info';break;
    }
    $messages = session('flash_list');
    if ($messages != null) {
        $messages[] = array($msg, $type);
    } else {
        $messages = array(
            array($msg, $type)
        );
    }
    session('flash_list', $messages);
}

/**
 * 获取闪现消息函数
 * 在模板中调用此函数，并将得到的数组处理然后输出即可得到闪现消息
 *
 * @return 返回消息数组
 */
function get_flash_messages() {
    $messages = session('flash_list');
    session('flash_list', null);
    return $messages;
}