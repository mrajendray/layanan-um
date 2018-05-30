<?php
require_once '../vendor/index.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'institute') {
    // return auth error
    $ret = array(
        "error"=>true,
        "ermsg"=>"auth"
    );
    \App\Utils::dd($ret, true);
}

// --prepare request data--
// check given user request
if (\App\Utils::check_request($_REQUEST, array('rating'), 'POST')) {
    // return request error
    $ret = array(
        "error"=>true,
        "ermsg"=>"param"
    );
    \App\Utils::dd($ret, true);
}
// get user request into php variable
$request = \Kiss\Utils::array_clean($_REQUEST, array('rating' => 'int'));

// get institute from username
$institute = \R::find('users', 'user_id = ?', array($user->id));
if (sizeof($institute) != 1) {
    // there is some credentials error
    \App\Utils::dd(array("error"=>true, "ermsg"=>"cred_err"), true);
}
// get first institute data
$institute = $institute[key($institute)];

// --save rating into database--
$newAssessment = \R::dispense('assessments');
$newAssessment->institute_id = $institute->id;
$newAssessment->rating = $request['rating'];
$newAssessment->rated_at = date("Y-m-d H:i:s");
$newAssessment->created_at = $newAssessment->rated_at;
$assessmentID = \R::store($newAssessment);

// assessment submit completed
\App\Utils::dd(array("completed"=>"thankyou","error"=>false), true);