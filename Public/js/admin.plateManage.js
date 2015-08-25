/**
 * Created by pineapplebin on 15-8-25.
 */
$(function() {
    /**
     * newPlate页面的提交按钮
     * 检验表单完整
     */
    $('#newplate-btn').click(function() {
        $('.warning-msg').remove();
        var pName = $('input[name=plateName]');
        var pDesc = $('textarea[name=plateDescription]');
        var warning_tag_start = '<span class="warning-msg">';
        var warning_tag_end = '</span>';
        var can_post = true;

        if (pName.val() == '') {
            pName.focus();
            pName.after(warning_tag_start + '请输入板块名' + warning_tag_end);
            can_post = false;
        }

        if (pDesc.val() == '') {
            pDesc.focus();
            pDesc.after(warning_tag_start + '请输入板块描述' + warning_tag_end);
            can_post = false;
        }

        return can_post;
    });

    /**
     * addAdmin页面的增加版主按钮
     * 检验是否选择
     */
    $('#addadmin-btn').click(function() {
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
    });

    /**
     * addAdmin页面的全选按钮
     * 全部选择按钮
     */
    $('#check_all').click(function() {
        var all = document.getElementById("check_all");             // 获取全选checkbox
        var items = document.getElementsByName("check_all[]");     // 获取全部的checkbox
        for(var i=0; i<items.length;i++){
            items[i].checked = all.checked;                     //所有的checkbox的'选中'属性和全选的一样
        }
    });
});
