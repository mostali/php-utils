<?php

$__TRACE = array();
$__ERROR = array();

function trace($message, $doEcho = false) {
    if ($doEcho) {
        echo($message . '<br>');
    } else {
        global $__TRACE;
        $__TRACE[] = $message;
    }
}

function error($message, $doEcho = false) {
    if ($doEcho) {
        echo($message . '<br>');
    } else {
        global $__ERROR;
        $__ERROR[] = $message;
    }
}

function doprintTrace() {
    global $__TRACE;
    if (empty($__TRACE))
        echo"<hr>PRINTTRACE is EMPTY<hr>";
    else {
        echo"<hr>PRINTTRACE<hr>";
        foreach ($__TRACE as $key => $value) {
            U::pv("$key:$value");
            echo"</br>";
        }
    }
}

class ULog {

    static function trace($message, $doEcho = true) {
        global $__TRACE;
        $__TRACE[] = $message;

        $m = '<b style="color:black">' . $message . '</b><br>';
        if ($doEcho)
            echo($m);
    }

    static function info($message) {
        echo('<b style="color:green">' . $message . '</b><br>');
    }

    static function debug($message) {
        echo('<b style="color:red">' . $message . '</b><br>');
    }

    static function warn($message) {
        echo('<b style="color:coral">' . $message . '</b><br>');
    }

    static function error($message) {
        echo('<b style="color:red">' . $message . '</b><br>');
    }

    static function success($message) {
        echo('<b style="color:blue">' . $message . '</b><br>');
    }

}
