/*
* Close alerts
*/

var alert_pos = 60;
setInterval(fadeOutAlert, 1000);

function fadeOutAlert() {
    $('.alerte').delay(2000).fadeOut(2000, function () {
        if (alert_pos > 60) {
            alert_pos -= 72;
        }
    });
}

$('body').on('click', '.closebtn', function () {
    if (alert_pos > 60) {
        alert_pos -= 72;
    }
    var div = $(this).parents('div');
    div.css('opacity', '0');
    setTimeout(function () {
        div.css('display', 'none');
    }, 600);
})