/**
 * Author:
 * - Moch Rajendra Yudhistira (mrajendray@gmail.com)
 */
var onGoing = false;
function rate(rating) {
    console.log(rating);
    if (onGoing) return;
    onGoing = true;
    axios
        .post('/assessment/submit.php', 'rating='+rating)
        .then(function (res) {
            onGoing = false;
            res = res.data;
            if (res.error) {
                if (res.ermsg === 'auth' || res.ermsg === 'cred_err')
                    window.location = '/login.php';
                console.log(res);
                return;
            } else if (res.completed) {
                instances.open();
                setTimeout(function () {
                    instances.close();
                }, 4000);
            } else console.error(res);
        })
        .catch(function(error) {
            onGoing = false;
            console.log(error);
        });
}

// init modal instance
var elem, instances;
document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();

    elem = document.querySelectorAll('.modal');
    instances = M.Modal.init(elem, {
        preventScrolling: true
    });

    instances = M.Modal.getInstance($('.modal'));
});

// request greeting
greeting();
// forever greeting request to keep user logged
setInterval(function() {
    greeting();
}, 60000);
// get greeting
function greeting() {
    axios
        .get('/assessment/greeting.php')
        .then(function(res) {
            res = res.data;
            if (!res.error) {
                $('#greeting-id').text(res.greetingID);
                $('#greeting-en').text(res.greetingEN);
            } else
                window.location = '/login.php';
        });
}