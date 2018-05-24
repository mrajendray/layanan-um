<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// default page
Route::get('/', function () {
    return redirect()->to('assessment');
});

// login page
Route::get("/login", [
    'as' => 'login',
    'uses' => 'LoginController@index'
]);
Route::post("/auth/login", 'LoginController@login');
// logout
Route::get("logout", 'LoginController@logout');

// main page
Route::get("/assessment", [
    'as' => 'assessment',
    'middleware' => 'auth',
    'uses' => 'AssessmentController@index'
]);
Route::post("/assessment/submit", [
    'middleware' => 'auth',
    'uses' => 'AssessmentController@submit'
]);

// greeting data
Route::get("/greeting", [
    'middleware' => 'auth',
    'uses' => function() {
        date_default_timezone_set("Asia/Jakarta");
        $Hour = date('G');

        if ($Hour >= 5 && $Hour <= 10) {
            return "Selamat Pagi";
        } else if ($Hour >= 11 && $Hour <= 15) {
            return "Selamat Siang";
        } else if ($Hour >= 16 || $Hour <= 4) {
            return "Selamat Sore";
        };

        return "Halo";
    }
]);