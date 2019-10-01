<?php

define('ACPATH', '/protected/components/');

import_('u');
import_('log');

function import($class_file_path, $parent_dir = null) {
    $parent_dir = $parent_dir == null ? $_SERVER['DOCUMENT_ROOT'] : $parent_dir;
    require_once $parent_dir . $class_file_path;
}

function import_($module) {
    switch ($module) {
        case 'u':
            import(ACPATH . 'utils/UT.php');
            import(ACPATH . 'utils/US.php');
            import(ACPATH . 'utils/UC.php');
            return;
        case 'uapp':
            import(ACPATH . 'utils/UApp.php');
            return;
        case 'log':
            import(ACPATH . 'utils/ULog.php');
            return;
        case 'ugs':
            import_('ufs');
            import('/src/UGS.php');
            return;
        case 'ufs':
            import(ACPATH . 'utils/UFS.php');
            return;
        case 'search_lang_value':
            UT::om('add sourcefile to utils folder');
            return;
        default:
            UT::om("Unknown module '$module'");
    }
}

function _GETU($name, $uri = null) {
    $uri = $uri === null ? $_SERVER['REQUEST_URI'] : $uri;
    parse_str(parse_url($uri)['query'], $query);
    return _GETE($name, $query);
}

/**
 *  RETURN EMPTY IF EMPTY
 */
function _GETE($name, $arr = null, $def_val_if_null = null) {
    $arr = $arr === null ? $_GET : $arr;
    return isset($arr[$name]) ? $arr[$name] : $def_val_if_null;
}

//@DEPRECATED
//function _GETP($name) {
//    return _GETV($name, $_GET);
//}
function _GETT($name, $arr = null, $message = 'empty value') {
    if (empty($arr[$name]))
        UT::is_om($message);
    return $arr[$name];
}

/**
 *  RETURN NULL IF EMPTY
 */
function _GETV($name, $arr = null, $def_val = null) {
    $arr = $arr === null ? $_GET : $arr;
    return !empty($arr[$name]) ? $arr[$name] : $def_val;
}

function call2url($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
//    echo "<pre></pre>";
    return $output;
}

if (!function_exists('array_key_first')) {

    function array_key_first(array $arr, $i = 0) {
        $i_ = -1;
        foreach ($arr as $key => $unused) {
            if (++$i_ === $i)
                return $key;
        }
        return NULL;
    }

    function array_val_first(array $arr, $i = 0) {
        $i_ = -1;
        foreach ($arr as $key => $unused) {
            if (++$i_ === $i)
                return $unused;
        }
        return NULL;
    }

}

function getTemplateFrom($file_or_string, $context = NULL, $fileIsString = false) {

    if (!empty($context))
        extract($context);

    ob_start();
    if ($fileIsString)
        eval(' ?>' . $file_or_string . '<?php ');
    else
        include($file_or_string);

    return ob_get_clean();
}

function url_create_with_part($part_of_url, $host = null, $https = false) {
    $host = $host == null ? $_SERVER['HTTP_HOST'] : $host;
    $http = $https ? 'https' : 'http';
    $host = US::removeLastCharIfEndsAs($part_of_url, '/');
    $part_of_url = US::appendIfNotStartsAs($part_of_url, '/');
    return "$http://{$host}{$part_of_url}";
}

function pvd($obj) {
    var_dump($obj);
    echo '</br>';
    die();
}

function pv($obj) {
    var_dump($obj);
}

function pv_($obj) {
    pv($obj);
    echo '<hr>';
}

class U {

    static function p($obj) {
        print_r($obj, false);
        echo '</br>';
    }

    static function pd($obj) {
        print_r($obj, false);
        echo '</br>';
        die();
    }

    static function pv($obj) {
        pv($obj);
    }

    static $i = 0;

    static function pvd_if($obj, $i = 0) {
        if (self::$i++ === $i)
            self::pvd($obj);
    }

    static function pvd($obj) {
        pvd($obj);
    }

    static function pc($arr) {
        self::pv(count($arr));
    }

    static function pcd($arr) {
        self::pvd(count($arr));
    }

    static function ppr($obj) {
        print_r($obj, false);
    }

    static function pprd($obj, $name, $di = 'exit') {
        self::p($name);
        print_r($obj, false);
        echo '</br>';
        if ($di != null)
            die($di ? strval($di) : '');
    }

    static function pdv($key = null) { {
            if (true) {
//                $arr = get_defined_vars();
                print_r(get_defined_vars());
            } else {
                $arr = get_defined_vars();
                if ($key == null) {
                    self::pprd($arr, 'all default values');
                } else {
                    if (isset($arr[$key]))
                        self::pprd($arr[$key], 'all default values');
                    else
                        self::pprd("Key [$key] not found in def vars", '');
                }
            }
        }
    }

}

class UH {

    static function a($html, $link, $attrs = array()) {
        return '<a href="' . $link . '" >' . $html . '</a>';
    }

}

/**
 * Return array with twins
 */
function array_get_twins($array) {
    $twins = array();
    $tws = array_count_values($array);
    foreach ($tws as $k => $c)
        if ($c > 1)
            $twins[] = $k;
    return $twins;
}

class utimer {

    private static $start = .0;

    static function start() {
        self::$start = microtime(true);
    }

    static function finish() {
        $ret_val = round(microtime(true) - self::$start, 2);
        printf("<pre class='timer'>%s</pre>", print_r($ret_val, true));
        return true;
    }

}
