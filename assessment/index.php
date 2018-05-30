<?php
require_once '../vendor/index.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'institute') {
    \App\Utils::redirect('login.php');
}
// find logged user id in database
$institutes = \R::find('users', 'user_id = ?', array($user->id));
// if user id not found
if (sizeof($institutes) != 1) {
    \App\Utils::redirect('login.php?logout');
}
// get first data from database result
$institute = $institutes[key($institutes)];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Survey Layanan UM</title>
    <link rel="icon" type="image/png" href="/resource/images/logoUM.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
    <link href="/resource/stylesheet/vendor/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/resource/stylesheet/vendor/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/resource/stylesheet/vendor/animate.css" type="text/css" rel="stylesheet" media="screen"/>
    <link href="/resource/stylesheet/assessment.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<img class="backg" src="/resource/images/bg1.jpg">
<div class="center-logo">
    <img src="/resource/images/logo.png">
</div>
<h2 align="center" class="style-font title-font-head" style="font-size: 35px" id="greeting-id">Selamat Siang</h2>
<h2 align="center" class="style-font title-font-head" style="font-size: 20px;font-style: italic;" id="greeting-en">Good Afternoon</h2>
<h4 align="center" class="style-font" style="font-size: 35px">Mohon Nilai Layanan Kami</h4>
<h4 align="center" class="style-font" style="font-size: 20px;font-style: italic;">Please rate our service</h4>
<div class="container">
    <div class="flex-container">
        <div class="flex-item point" onclick="rate(0)">
            <img src="/resource/images/assessment/1.svg" width="150px" height="150px">
            <h4 align="center" class="style-font">Excellent</h4>
        </div>
        <div class="flex-item point" onclick="rate(1)">
            <img src="/resource/images/assessment/2.svg" width="150px" height="150px">
            <h4 align="center" class="style-font">Good</h4>
        </div>
        <div class="flex-item point" onclick="rate(2)">
            <img src="/resource/images/assessment/3.svg" width="150px" height="150px">
            <h4 align="center" class="style-font">Bad</h4>
        </div>
        <div class="flex-item point" onclick="rate(3)">
            <img src="/resource/images/assessment/4.svg" width="150px" height="150px">
            <h4 align="center" class="style-font">Very Bad</h4>
        </div>
    </div>
</div>
<div id="modal1" class="modal custom-modal">
    <div class="modal-content custom-modal-content">
        <h4>Terima Kasih</h4>
        <p>Terima kasih telah memberikan penilaian terhadap pelayanan kami</p>
    </div>
</div>
<footer class="page-footer transparent" style="padding-top: 0px">
    <div class="container ">
        <div class="center flex-container" style="margin-top: 0px">
            <div class="foot-sm">
                <img src="/resource/images/web.png" width="50px" height="50px">
                <a class="style-font"> www.um.ac.id </a>
            </div>

            <div class="foot-sm">
                <img src="/resource/images/ig.png" width="50px" height="50px">
                <a class="style-font"> @universitasnegerimalang </a>
            </div>

            <div class="foot-sm">
                <img src="/resource/images/fb.png" width="50px" height="50px">
                <a class="style-font"> Informasi.UM </a>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="/resource/js/vendor/jquery.min.js"></script>
<script type="text/javascript" src="/resource/js/vendor/materialize.min.js"></script>
<script type="text/javascript" src="/resource/js/vendor/axios.min.js"></script>
<script type="text/javascript" src="/resource/js/assessment.js"></script>
</body>
</html>