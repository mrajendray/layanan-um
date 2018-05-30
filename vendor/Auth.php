<?php
namespace App;
require_once 'config.php';
require_once 'library/Kiss/Utils.php';
require_once 'Utils.php';
require_once 'database.php';

class Auth {
    const table = "usercredentials";

    public static function attempt($username, $password) {
        // --checking user credentials on database--
        // find username
        $userIDs = \R::find(Auth::table, 'username = ?', array($username));
        // check existence of username
        if (sizeof($userIDs) == 1) {
            // get user data
            $user = $userIDs[key($userIDs)];
            // hash password
            $password = \Kiss\Utils::hash_password($password, APP_KEY);
            // check user password
            if ($user->password == $password) {
                // generate new token and set to user object
                $user->remember_token = $user->username.'.'.substr(md5(uniqid('')), 0, 32);
                // set timestamp for user object
                $user->updated_at = date("Y-m-d H:i:s");
                // save updated user object into database
                \R::store($user);
                // set login cookie
                self::setCookie($user->username, $user->remember_token);
                // return user object
                return $user;
            }
        }
        // if username not found or wrong password
        return false;
    }

    public static function logout() {
        $cookie = Utils::check_request($_COOKIE, array('username', 'remember_token'));
        if (!Utils::check_request($_REQUEST, array('username', 'remember_token'), 'POST') ||  !$cookie) {
            // get user request into php variable
            $request = \Kiss\Utils::array_clean((!$cookie) ? $_COOKIE : $_REQUEST, array(
                'username' => 'string',
                'remember_token' => 'string',
            ));
            // --checking user credentials on database--
            // find username
            $userIDs = \R::find(Auth::table, 'username = ? AND remember_token = ?', array($request['username'], $request['remember_token']));
            // check existence of username
            if (sizeof($userIDs) == 1) {
                // get user data
                $user = $userIDs[key($userIDs)];
                // reset remember token
                $user->remember_token = '';
                // save it
                \R::store($user);
            }
        }
        // then destroy saved cookie
        self::unsetCookie();
    }

    public static function isLogged() {
        // check login data from cookie and from user request post
        $cookie = Utils::check_request($_COOKIE, array('username', 'remember_token'));
        if (!Utils::check_request($_REQUEST, array('username', 'remember_token'), 'POST') ||  !$cookie) {
            // get user request/cookie into request variable
            $request = \Kiss\Utils::array_clean((!$cookie) ? $_COOKIE : $_REQUEST, array(
                'username' => 'string',
                'remember_token' => 'string',
            ));
            // --checking user credentials on database--
            // find username
            $userIDs = \R::find(Auth::table, 'username = ?', array($request['username']));
            // check existence of username
            if (sizeof($userIDs) == 1) {
                // get user data
                $user = $userIDs[key($userIDs)];
                // check user token
                if ($user->remember_token == $request['remember_token']) {
                    // refresh cookie time
                    self::setCookie($user->username, $user->remember_token);
                    // return user object
                    return $user;
                }
            }
        }
        // when username is not found or remember token is expired/replaced
        return false;
    }

    public static function register($username, $password, $role) {
        // --check username availability--
        // get saved username from database
        $userIDs = \R::find(Auth::table, 'username = ?', array($username));
        // if username is used
        if (sizeof($userIDs) != 0) return false;

        // --save user data into database--
        // init new user data
        $newUser = \R::dispense(Auth::table);
        $newUser->username = $username;
        $newUser->password = \Kiss\Utils::hash_password($password, APP_KEY);
        $newUser->role = $role;
        $newUser->created_at = date("Y-m-d H:i:s");
        $newUser->updated_at = $newUser->created_at;
        $newUser->remember_token = '';
        // save new user data into database
        \R::store($newUser);

        // return new user object
        return $newUser;
    }

    // cookie things
    private static function setCookie($username, $remember_token) {
        setcookie("username", $username, time()+30*24*60*60, '/', null, APP_SEC, true);
        setcookie("remember_token", $remember_token, time()+30*24*60*60, '/', null, APP_SEC, true);
    }
    private static function unsetCookie() {
        setcookie("username", "", time()+60, '/', null, APP_SEC, true);
        setcookie("remember_token", "", time()+60, '/', null, APP_SEC, true);
    }
}