<?php
require_once 'vendor/index.php';
// check user login status
if ($user = \App\Auth::isLogged()) {
    if ($user->role == 'admin') {
        // redirect to admin page if user role is admin
        \App\Utils::redirect('admin');
    } else {
        // redirect to assessment page
        \App\Utils::redirect('assessment');
    }
} else {
    // if user not logged in, then redirect user to login page
    \App\Utils::redirect('login.php');
}