/**
 * Author:
 * - Moch Rajendra Yudhistira (mrajendray@gmail.com)
 */

var onGoing = false;
function rate(rating) {
    if (!onGoing) {
        onGoing = true;
        axios
            .post('/assessment/submit', {rating,})
            .then(function (response) {
                instances.open();
                setTimeout(function() {
                    instances.close();
                }, 4000);
                onGoing = false;
            })
            .catch(function(error) {
                console.log(error);
                onGoing = false;
            });
    }
}

var elem, instances;
document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();

    elem = document.querySelectorAll('.modal');
    instances = M.Modal.init(elem, {
        preventScrolling: true
    });

    instances = M.Modal.getInstance($('.modal'));
});

greeting();
setInterval(function() {
    greeting();
}, 60000);
function greeting() {
    axios
        .get('/greeting')
        .then(function(res) {
            $('#greeting').text(res.data);
        });
}