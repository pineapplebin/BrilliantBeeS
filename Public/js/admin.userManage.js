/**
 * Created by john on 15-8-15.
 */

/*
* 批量删除用户
*/
function deleteAll(){
    var items = document.getElementsByName("check_all[]");      // 获取全部的checkbox
    for(var i=0; i<items.length;i++) {
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
}

/*
* 全选
*/
function checkAll(){
    var all = document.getElementById("check_all");             // 获取全选checkbox
    var items = document.getElementsByName("check_all[]");     // 获取全部的checkbox
    for(var i=0; i<items.length;i++){
            items[i].checked = all.checked;                     //所有的checkbox的'选中'属性和全选的一样
    }
}

$(function(){
    $('#confirm_btn').click(function(){
        var password = $('input[name=user_password]');
        var can_post = true;
        if(password.val() != ''){
            var temp = $.md5(password.val());
            password.val(temp);
        }
        return can_post;

    });

    $('input[type="checkbox"]').click(function() {
        var id = this.id.split('-')[1];
        var tr_id = 'tr-' + id;
        if (this.checked == true) {
            $('#'+tr_id).addClass('active');
        } else {
            $('#'+tr_id).removeClass('active');
        }
    });

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
});

/*
 *增加版主
 */
function addAll(){
    var items = document.getElementsByName("check_all[]");      // 获取全部的checkbox
    for(var i=0; i<items.length;i++) {
        // 如果 至少 有一个checkbox被选中,就提交表单!
        if (items[i].checked) {
            if (window.confirm("确定增加版主?")) {          // 选择确认选项,批量删除
                var form = document.getElementById('add');    // 获取delete 表单对象
                form.submit();                                   // 提交表单
            }
            return;                                              //选择取消选项,函数结束
        }
    }
    // 否则一个checkbox也没有选中
    alert("一个也没有选中!!");
}
