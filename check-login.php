<?php
require_once 'vendor/index.php';

// --check user login status--
if ($user = \App\Auth::isLogged()) {
    $ret = array(
        "notlogged"=>false,
        "role"=>$user->role,
        "user_id"=>$user->id,
        "username"=>$user->username
    );
    \App\Utils::dd($ret, true);
}
\App\Utils::dd(array('notlogged'=>true), true);