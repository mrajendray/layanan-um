<?php
require_once '../vendor/index.php';

// --prepare request data--
// check given user request
//TODO: make it back to post requets
if (\App\Utils::check_request($_REQUEST, array('institute', 'username', 'password'), 'GET')) {
    die('no parameter or please use post!');
}
// get user request into php variable
$request = \Kiss\Utils::array_clean($_REQUEST, array(
    'institute' => 'string',
    'username' => 'string',
    'password' => 'string',
));

// --make new user--
if ($register = \App\Auth::register($request['username'], $request['password'], 'institute')) {
    $newUser = R::dispense('users');
    $newUser->user_id = $register->id;
    $newUser->institute = $request['institute'];
    $newUser->created_at = date("Y-m-d H:i:s");
    $newUser->updated_at = $newUser->created_at;
    R::store($newUser);

    die('username created');
} else {
    die('username is used');
}