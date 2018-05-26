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
    \App\Utils::dd(array('error'=>false, 'greeting'=>'Selamat Pagi'), true);
} else if ($Hour >= 11 && $Hour <= 15) {
    \App\Utils::dd(array('error'=>false, 'greeting'=>'Selamat Siang'), true);
} else if ($Hour >= 16 || $Hour <= 4) {
    \App\Utils::dd(array('error'=>false, 'greeting'=>'Selamat Sore'), true);
};

\App\Utils::dd(array('error'=>false, 'greeting'=>'Hallo'), true);