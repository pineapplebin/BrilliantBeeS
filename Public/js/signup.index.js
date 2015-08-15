/**
 * Created by pineapplebin on 15-8-9.
 */

$(function() {
    /**
     * 改变验证码图片
     */
    $('#verify_img').click(function() {
        $('#verify_img').attr("src", verify_img_url + '?a=' + Math.random());
    });

    /**
     * 检验表单完整
     */
    $('#signup_btn').click(function() {
        $('.form-warning').remove();
        var username = $('input[name=user_name]');
        var email = $('input[name=user_email]');
        var pwd = $('input[name=user_pwd]');
        var re_pwd = $('input[name=re_user_pwd]');
        var can_post = true;

        var warning_tag_start = '<span class="form-warning">';
        var warning_tag_end = '</span>';

        // 验证用户名是否为空
        if (username.val() == '') {
            username.focus();
            username.after(warning_tag_start + '请输入用户名' + warning_tag_end);
            can_post = false;
        }

        // 验证邮箱是否为空
        if (email.val() == '') {
            email.focus();
            email.after(warning_tag_start + '请输入邮箱地址' + warning_tag_end);
            can_post = false;
        } else {
            // 若邮箱不为空，验证邮箱格式
            var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
            if (!reg.test(email.val())) {
                email.focus();
                email.after(warning_tag_start + '请输入正确的邮箱地址' + warning_tag_end);
                can_post = false;
            }
        }

        // 验证密码与确认密码是否一致和是否为空
        if ((pwd.val() != re_pwd.val()) || pwd.val() == '' || re_pwd.val() == '') {
            re_pwd.focus();
            re_pwd.after(warning_tag_start + '两次输入密码不一致' + warning_tag_end);
            can_post = false;
        }
        else if (pwd.val() != '' && re_pwd.val() != '' && pwd.val() == re_pwd.val()) {
            // 如果密码与确认密码一致且不为空，就使用md5加密
            var temp = $.md5(pwd.val());
            pwd.val(temp);
            re_pwd.val(temp);
        }

        return can_post;
    });
});