<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login EVAN">
    <meta name="author" content="">
    <link rel="icon" href="/img/logoUM.png">
    <title>Masuk ke EVAN</title>
    <link href="/css/login/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login/signin.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="text-center">
        <img src="/img/logo.png" alt="">
        <h3 class="form-signin-heading">Masuk ke EVAN</h3>

        <br>
    </div>

    <form class="form-signin" action="/auth/login" method="post" style="margin-top:15px;">
        {{ csrf_field() }}
        <label for="username" class="sr-only">Masukan username fakultas</label>
        <input id="username" type="username" name="username" class="form-control" placeholder="Masukkan NIP / NIM Anda" required="required" autofocus="autofocus">
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi Anda" required="required">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
    </form>

</div>
<style>
    .footer ul {
        display: inline-block;
        list-style: outside none none;
    }

    .footer.inline-list {
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }

    .footer {
        color: rgba(255, 255, 255, 0.25);
    }

    .footer {
        color: #fff;
        font-size: 11px;
        position: absolute;
        text-align: center;
        width: 100%;
    }

    .inline-list {
        margin-left: -20px;
    }

    .footer li {
        display: inline;
    }

    .footer a {
        color: white;
        text-decoration: none;
    }
</style>
<div class="footer inline-list">
    <ul>

    </ul>
</div>
</body>
</html>