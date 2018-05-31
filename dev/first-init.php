<?php
require_once '../vendor/index.php';
try {
    // create new user as admin
    if ($admin = \App\Auth::register("admin", "admin", "admin")) {

        // create table users
        $newUser = R::dispense('users');
        $newUser->user_id = $admin->id;
        $newUser->institute = 'admin';
        $newUser->created_at = date("Y-m-d H:i:s");
        $newUser->updated_at = $newUser->created_at;
        R::store($newUser);

        // create assessment table
        $newAssessment = \R::dispense('assessments');
        $newAssessment->institute_id = 1;
        $newAssessment->rating = 0;
        $newAssessment->rated_at = date("Y-m-d H:i:s");
        $newAssessment->created_at = $newAssessment->rated_at;
        $assessmentID = \R::store($newAssessment);
        // succeed
        \App\Utils::dd(array("firstInit"=>"succeed","randkey"=>substr(md5(uniqid('')), 0, 32)), true);
    }
    // succeed
    \App\Utils::dd(array("firstInit"=>"already inited"), true);
} catch(Exception $e) {
    var_dump($e);
    exit();
}