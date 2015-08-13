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

    $('#login-btn').click(function() {
        var pwd = $('input[name="user_password"]');
        var user = $('input[name="user_selected"]');
        if (pwd.val() != '' && user.val() != '') {
            pwd.val($.md5(pwd.val()));
        } else {
            return false;
        }
    });

    $('#select-user').click(function() {
        change_select('用户名', 'name');
    });

    $('#select-email').click(function() {
        change_select('邮箱', 'email');
    });

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


function change_select(che, eng) {
    var triangle = '<span class="caret"></span>';
    var show_che = $('#dropdownMenu');
    show_che.text(che);
    show_che.append(triangle);

    var change_eng = $('#login_type_select');
    change_eng.val(eng);
}
