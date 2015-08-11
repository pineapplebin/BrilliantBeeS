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

});