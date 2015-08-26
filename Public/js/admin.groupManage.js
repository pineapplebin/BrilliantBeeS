/**
 * Created by pineapplebin on 15-8-25.
 */
$(function() {
    /**
    $('.list-group-item').hover(
        function() {
            $(this).css('background-color', '#f0f0f0');
        },
        function() {
            $(this).css('background-color', '#fff');
    });
     *
     */

    /**
     * addGroup页
     * 处理表单填写
     */
    $('#addGroup-btn').click(function() {
        $('.warning-msg').remove();
        var group_name = $('#group_name');
        var can_save = true;
        // 判断用户组名字是否写入
        if (group_name.val() == '') {
            var warning_tag = '<span class="warning-msg">请填写名字</span>';
            group_name.focus();
            $('#group_name_label').after(warning_tag);
            can_save = false;
        }

        return can_save;
    });
});