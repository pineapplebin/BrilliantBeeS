/**
 * Created by pineapplebin on 15-8-9.
 */
function change_verify() {
    var x = document.getElementById('verify_img');
    x.src = verify_img_url + '?a=' + Math.random();
}