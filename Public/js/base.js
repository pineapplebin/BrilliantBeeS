/**
 * Created by pineapplebin on 15-8-11.
 */

$(function() {

    /**
     * 3秒后自动将flash信息淡出
     */
    setTimeout(function() {
        var flash_msgs = $('div.flash_messages');
        flash_msgs.fadeOut();
        setTimeout(function(){
            flash_msgs.empty();
        }, 500);
    }, 3000);

    /**
     * 登录密码MD5加密
     */
    $('#login-btn').click(function() {
        var pwd = $('input[name="user_password"]');
        var user = $('input[name="user_selected"]');
        if (pwd.val() != '' && user.val() != '') {
            pwd.val($.md5(pwd.val()));
        } else {
            return false;
        }
    });

    /**
     * 选择登录方式
     */
    $('#select-user').click(function() {
        $('input[name="user_selected"]').focus();
        change_select('用户名', 'name');
    });

    $('#select-email').click(function() {
        $('input[name="user_selected"]').focus();
        change_select('邮箱', 'email');
    });

    /**
     * 选择记住我
     */
    $('#remember-span').click(function() {
        var fake_dot = $('#fake-checked');
        var true_dot = $('input[name="remember_me"]');
        if (true_dot.attr('checked') == 'checked') {
            true_dot.attr('checked', false);
            fake_dot.css('opacity', 0.2);
        } else {
            true_dot.attr('checked', true);
            fake_dot.css('opacity', 1);
        }
    });
});

/**
 * 表情，粗体，斜体转换函数
 */
$(function(){
    //粗体，斜体转换    
    $('div.edit_input a#b_style, div.edit_input a#i_style').click(function(){
        var a_id = $(this).attr('id');
        var font_type = a_id.split(/_/)[0];

        if(document.getElementById('post_content')) var content_type = 'post_content';
        else if(document.getElementById('reply_content')) var content_type = 'reply_content';
        var textarea_content = document.getElementById(content_type).value;
        document.getElementById(content_type).value = textarea_content + '['+font_type+'][/'+font_type+']';
        document.getElementById(content_type).focus();       

    });

    //表情转换
    $('div.edit_input a#face_pannel').click(function(){        
        $(this).toggleClass('face_pannel');
        $('div.face_style').toggle();        
    });
    $('div.face_style img').click(function(){
        var face_list = new Array();
        face_list['touxiao'] = '偷笑';
        face_list['fanu'] = '发怒';
        face_list['zhouma'] = '咒骂'; 
        face_list['weixiao'] = '微笑';
        face_list['jingya'] = '惊讶';
        face_list['liulei'] = '流泪';
        face_list['se'] = '色';
        face_list['tiaopi'] = '调皮';
        face_list['ku'] = '酷'; 

        var face_src = $(this).attr('src');    
        var face_name = face_src.split(/[/.]/);

        if(document.getElementById('post_content')) var content_type = 'post_content';
        else if(document.getElementById('reply_content')) var content_type = 'reply_content';
        var textarea_content = document.getElementById(content_type).value;
        document.getElementById(content_type).value = textarea_content + '['+face_list[face_name[face_name.length-2]]+']';
        document.getElementById(content_type).focus();         
    });
});


function change_select(che, eng) {
    var triangle = '<span class="caret"></span>';
    var show_che = $('#dropdownMenu');
    show_che.text(che);
    show_che.append(triangle);

    var change_eng = $('#login_type_select');
    change_eng.val(eng);
}

