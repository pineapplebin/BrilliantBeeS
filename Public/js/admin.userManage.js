/**
 * Created by john on 15-8-15.
 */

$(function() {
    /**
     * index页面
     * 选中行加上深色
     */
    $('input[type="checkbox"]').click(function() {
        var id = this.id.split('-')[1];
        var tr_id = 'tr-' + id;
        if (this.checked == true) {
            $('#'+tr_id).addClass('active');
        } else {
            $('#'+tr_id).removeClass('active');
        }
    });

    /**
     * index页面
     * 点击全选之后给所有选中的行加上深色
     */
    $('#check_all').click(function() {
        // 获取全选checkbox
        var all = document.getElementById("check_all");
        // 获取全部的checkbox
        var items = document.getElementsByName("delete_all[]");
        for(var i=0; i<items.length;i++){
            //所有的checkbox的'选中'属性和全选的一样
            items[i].checked = all.checked;
            var id = items[i].id.split('-')[1];
            if (all.checked == true) {
                $('#tr-'+id).addClass('active');
            } else {
                $('#tr-'+id).removeClass('active');
            }
        }
    });

    /**
     * add页面
     * 提交表单时加密密码
     */
    $('#confirm_btn').click(function(){
        var password = $('input[name=user_password]');
        var can_post = true;
        if(password.val() != ''){
            var temp = $.md5(password.val());
            password.val(temp);
        }
        return can_post;

    });

    /**
     * index页面
     * 搜索使用说明展开按键
     */
    $('#open-descripition').click(function() {
        var desc = $('#search-description');
        if (desc.css('display') == 'none') {
            desc.fadeIn('slow');
        } else {
            desc.fadeOut();
        }
    });

    /**
     * index页面
     * 得到get字符串并转换
     */
    var search_content = $('input[name=search]');
    if (search_content.val() != '') {
        var text = search_content.val().replace(/\+/g, ' ');
        text = text.replace(/&gt;/g, '>');
        text = text.replace(/&lt;/g, '<');
        text = text.replace(/&amp;/g, '&');
        search_content.val(text);
    }

    /**
     * index页面
     * 批量删除用户按钮
     */
    $('#deleteAll-btn').click(function() {
        // 获取全部的checkbox
        var items = document.getElementsByName("delete_all[]");
        for(var i=0; i<items.length; i++) {
            // 如果 至少 有一个checkbox被选中,就提交表单!
            if (items[i].checked) {
                if (window.confirm("确定要批量删除用户??")) {          // 选择确认选项,批量删除
                    var form = document.getElementById('delete');    // 获取delete 表单对象
                    form.submit();                                   // 提交表单
                }
                return;                                              //选择取消选项,函数结束
            }
        }
        // 否则一个checkbox也没有选中
        alert("一个也没有选中!!");
    });
});

