<?php

//http://live-code.ru/page/metody-keshirovanija-dannyh-na-php
class UC {

    static function pvd($key) {
        U::p("UC[$key]");
        U::pvd(UC::get($key));
    }

    static function set($key, $value = null, $time_sec = 0) {
        apc_store($key, $value, $time_sec > 0 ? $time_sec : 0);
    }

    static function fetch($key) {
        return apc_fetch($key);
    }

    static function get($key, $def = null) {
        $v = self::fetch($key);
        return $v === null ? $def : $v;
    }

    static function getv($key, $key_arr, $def_arr_value = null) {
        $arr = self::fetch($key);
        if (!is_array($arr))
            return $def_arr_value;
        return isset($arr[$key_arr]) ? $arr[$key_arr] : $def_arr_value;
    }

    static function clear($key, $full_user = false) {
        if ($full_user)
            apc_clear_cache('user');
        else
            apc_delete($key);
    }

}
