<?php
require_once '../vendor/index.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'admin') {
    \App\Utils::redirect('login.php');
}

\App\Utils::redirect('admin/assessment.php');