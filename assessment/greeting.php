<?php
require_once '../vendor/index.php';

// --check user login status--
if (!\App\Auth::isLogged()) {
    // return auth error
    $ret = array(
        "error"=>true,
        "ermsg"=>"auth"
    );
    \App\Utils::dd($ret, true);
}

date_default_timezone_set("Asia/Jakarta");
$Hour = date('G');

if ($Hour >= 5 && $Hour <= 10) {
    \App\Utils::dd(array('error'=>false, 'greetingID'=>'Selamat Pagi', 'greetingEN'=>'Good Morning'), true);
} else if ($Hour >= 11 && $Hour <= 15) {
    \App\Utils::dd(array('error'=>false, 'greetingID'=>'Selamat Siang', 'greetingEN'=>'Good Afternoon'), true);
} else if ($Hour >= 16 || $Hour <= 4) {
    \App\Utils::dd(array('error'=>false, 'greetingID'=>'Selamat Sore', 'greetingEN'=>'Good Afternoon'), true);
};

\App\Utils::dd(array('error'=>false, 'greeting'=>'Hallo'), true);