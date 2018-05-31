function autoLogin() {
    const reqHeaders = {
        'headers': {
            'Access-Control-Allow-Headers': 'x-access-token',
        }
    };
    axios.get("http://localhost:5658/um/evan/login/login", reqHeaders)
        .then(function (res) {
            username.val(res.data.username);
            password.val(res.data.password);
            form.submit();
        })
        .catch(function (error) {
            console.error("Koneksi ke server login local error. status: "+error);
            setTimeout(function() {
                autoLogin();
            }, 1000);
        });
}
autoLogin();

/** var autologin = localStorage.getItem("autologin");
if (!autologin) resetStore();

function resetStore() {
    storeUpdate({
        logged: false,
        username: null,
        password: null,
        remember_token: null,
    }, true)
}
function storeUpdate(data, first = false) {
    if (!first) {
        let old = JSON.parse(localStorage.getItem("autologin"));
        data = $.extend({}, old, data);
    }
    localStorage.setItem("autologin", JSON.stringify(data))
}

function regisLogin(form, username, password) {
    form.submit(function (e) {
        storeUpdate({
            username: username.val(),
            password: password.val()
        })
    })
}
function setToken(username, remember_token) {
    storeUpdate({
        logged: true,
        username,
        remember_token
    })
}
function tryLogin(form, username, password) {
    let d = JSON.parse(localStorage.getItem("autologin"));
    if (!d.logged)
        return;
    username.val(d.username);
    password.val(d.password);
    form.submit();
}
function loginFail() {
    resetStore();
}
function logout() {
    resetStore();
} */