<?php
namespace App;
class Utils {
    /**
     * @param $request = data to check
     * @param $keys = list of key to be checked in request
     * @param string $type = type of request want to be checked
     * @return bool false mean keys is declared in request with request type is parameter type
     */
    public static function check_request($request, $keys, $type = '') {
        $res = false;

        // check request type
        if ($type != '') $res = $res || $_SERVER['REQUEST_METHOD'] != $type;

        // check each keys
        foreach ($keys as $key) {
            $res = $res || !isset($request[$key]);
        }

        return $res;
    }
    public static function redirect($url) {
        header("Location: /".$url);
        exit();
    }

    // dev
    public static function dd($data, $json = false) {
        if (!is_array($data)) die($data);
        if ($json) {
            die(json_encode($data));
        } else {
            var_dump($data);
            exit;
        }
    }
}