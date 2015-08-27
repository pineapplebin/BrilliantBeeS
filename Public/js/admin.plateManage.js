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

    /**
     * modify页面的编辑按钮
     */
    $('#edit-btn').click(function() {
        var fake_name = $('#fake-name');
        fake_name.css('display', 'none');
        var fake_desc = $('#fake-desc');
        fake_desc.css('display', 'none');

        var name = $('input[name=plate_name]');
        var desc = $('textarea[name=plate_desc]');

        name.css('display', 'inline-block');
        name.focus();
        name.val(fake_name.text());
        desc.css('display', 'inline-block');
        desc.val(fake_desc.text());
        $('#cancel-btn').css('display', 'inline');
        $('#submit-btn').css('display', 'inline');
    });

    /**
     * modify页面的取消编辑按钮
     */
    $('#cancel-btn').click(function() {
        $('.warning-msg').remove();

        $('#fake-name').css('display', 'inline-block');
        $('#fake-desc').css('display', 'inline-block');

        $('input[name=plate_name]').css('display', 'none');
        $('textarea[name=plate_desc]').css('display', 'none');
        $('#cancel-btn').css('display', 'none');
        $('#submit-btn').css('display', 'none');
    });

    /**
     * modify页面的保存修改按钮
     */
    $('#submit-btn').click(function() {
        $('.warning-msg').remove();

        var name = $('input[name=plate_name]');
        var desc = $('textarea[name=plate_desc]');
        var can_post = true;

        var warning_tag_start = '<span class="warning-msg">';
        var warning_tag_end = '</span>';

        if (name.val() == '') {
            name.focus();
            name.after(warning_tag_start + '请输入板块名称' + warning_tag_end);
            can_post = false;
        }
        if (desc.val() == '') {
            desc.focus();
            desc.after(warning_tag_start + '请输入板块描述' + warning_tag_end);
            can_post = false;
        }
        return can_post;
    });
});

