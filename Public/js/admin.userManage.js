/**
 * Created by john on 15-8-15.
 */

/*
* 批量删除用户
*/
function deleteAll(){
    var items = document.getElementsByName("delete_all[]");      // 获取全部的checkbox
    for(var i=0; i<items.length;i++) {
        // 如果 至少 有一个checkbox被选中,就提交表单!
        if (items[i].checked) {
            if (window.confirm("确定要批量删除用户??")) {          // 提示确认批量删除
                var form = document.getElementById('delete');    // 获取delete 表单对象
                form.submit();                                   // 提交表单
                return;
            }
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
    var items = document.getElementsByName("delete_all[]");     // 获取全部的checkbox

    for(var i=0; i<items.length;i++){
            items[i].checked = all.checked;                     //所有的checkbox的'选中'属性和全选的一样
    }

}