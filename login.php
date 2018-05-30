<?php
namespace App;
require_once 'vendor/index.php';

// --check user login status--
if ($user = Auth::isLogged()) {
    // if user logged and want to logout
    if (isset($_REQUEST['logout']))
        Auth::logout();
    else if ($user->role ==='admin')
        Utils::redirect('admin');
    else
        Utils::redirect('assessment');
}

// make sure everything is clean
Auth::logout();

// --start login--
// init var
$wrongCred = false;
// check given user request
if (!Utils::check_request($_REQUEST, array('username', 'password'), 'POST')) {
    // get user request into php variable
    $request = \Kiss\Utils::array_clean($_REQUEST, array(
        'username' => 'string',
        'password' => 'string',
    ));
    // try to login
    if ($attempt = Auth::attempt($request['username'], $request['password'])) {
        // if login succeed and role is admin
        if ($attempt->role === 'admin') {
            // go to admin page
            $redir = '/admin';
        } else if ($attempt->role === 'institute') {
            // go to assessment page
            $redir = '/assessment';
        }
        // set token for auto login system
        echo '
        <script type="text/javascript" src="/resource/js/vendor/jquery.min.js"></script>
        <script type="text/javascript" src="/resource/js/autologin.js"></script>
        <script>
            setToken("'.$attempt->username.'","'.$attempt->remember_token.'");
            window.location = "'.$redir.'";
        </script>
        ';
    } {
        // if login failed
        $wrongCred = true;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login EVAN">
    <meta name="author" content="">
    <link rel="icon" href="/resource/images/logoUM.png">
    <title>Masuk ke EVAN</title>
    <link href="/resource/stylesheet/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="/resource/stylesheet/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="text-center">
        <img src="resource/images/logo.png" alt="">
        <h3 class="form-signin-heading">Masuk ke EVAN</h3>

        <br>
    </div>
    <?php
    if ($wrongCred)
        print('<div class="text-center"><span class="label label-danger">User ID atau kata sandi Salah!!!</span></div>');
    ?>
    <form id="lgnForm" class="form-signin" action="/login.php" method="post" style="margin-top:15px;">
        <label for="username" class="sr-only">Username</label>
        <input id="username" type="username" name="username" class="form-control" placeholder="Masukan Username Fakultas" required="required" autofocus="autofocus">
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Masukan Kata Sandi" required="required">
        <button id="lgnButton" class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
    </form>

</div>
<div class="footer inline-list">
    <ul>

    </ul>
</div>

<script type="text/javascript" src="/resource/js/vendor/jquery.min.js"></script>
<script type="text/javascript" src="/resource/js/autologin.js"></script>
<script>
    $(document).ready(function() {
        regisLogin($('#lgnForm'), $('#username'), $('#password'));
        <?php
        if (isset($_REQUEST['logout']))
            echo "logout()";
        else if ($wrongCred)
            echo "loginFail()";
        else
            echo "tryLogin($('#lgnForm'), $('#username'), $('#password'));";
        ?>
    });
</script>
</body>
</html>