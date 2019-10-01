<?php

class UT {

    static function notn($obj, $message = "Object is NULL") {
        if ($obj === null)
            throw new Exception($message);
    }

    static function note($obj, $message = "Object is empty") {
        if (empty($obj))
            throw new Exception($message);
    }

    static function notnm($obj, $message = "Object is empty") {
        if ($obj === null)
            throw new OmException($message);
    }

    static function notem($obj, $message = "Object is empty") {
        if (empty($obj))
            throw new OmException($message);
    }

    static function noteq($obj, $obj_or_arr_eq, $message = "Objects not equals", $strict = true) {
        if (is_string($obj_or_arr_eq)) {
            if ($strict ? $obj !== $obj_or_arr_eq : $obj != $obj_or_arr_eq)
                throw new Exception($message);
        } else if (!in_array($obj, $obj_or_arr_eq, $strict))
            throw new Exception($message);
    }

    static function on($message = "Default error") {
        throw new Exception($message);
    }

    static function om($message = "Message error") {
        throw new OmException($message);
    }

    static function ow($message = "Warning error") {
        throw new OwException($message);
    }

    static function is_om($ex) {
        return $ex instanceof OmException;
    }

    static function is_ow($ex) {
        return $ex instanceof OwException;
    }

}

/**
 * Message
 */
class OmException extends Exception {
    
}

/**
 * Warning Message
 */
class OwException extends Exception {
    
}
