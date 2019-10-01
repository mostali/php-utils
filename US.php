<?php

class US {

    public static function contains($str, $token) {
        $tok = strpos($str, $token);
        return $tok === false ? false : true;
    }

    public static function firstTok($str, $del) {
        $tok = strtok($str, $del);
        if ($tok === false)
            return null;
        return $tok;
    }

    public static function lastTok($str, $del) {
        $m = explode($del, $str);
        $size = sizeof($m);
        if ($size > 1)
            return $m[$size - 1];
        return null;
    }

    public static function matches($pattern, $str) {
        $matches = preg_match("/$pattern/", $str);
//        echo $regs[1];
//        fclose($fp);
        return $matches === 1;
    }

    public static function fixUTF8($text) {
        $current_encoding = mb_detect_encoding($text, 'auto');
        try {
            $text = iconv($current_encoding, 'UTF-8', $text);
        } catch (Exception $e) {
            
        }
        return $text;
    }

    public static function utf8_str_split($str) {
        // place each character of the string into and array 
        $split = 1;
        $array = array();
        for ($i = 0; $i < strlen($str);) {
            $value = ord($str[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223)
                    $split = 2;
                elseif ($value >= 224 && $value <= 239)
                    $split = 3;
                elseif ($value >= 240 && $value <= 247)
                    $split = 4;
            } else {
                $split = 1;
            }
            $key = NULL;
            for ($j = 0; $j < $split; $j++, $i++) {
                $key .= $str[$i];
            }
            array_push($array, $key);
        }
        return $array;
    }

    /**
     * Функция вырезки
     * @param <string> $str 
     * @return <string> 
     */
    public static function clearstr($str) {
        $sru = 'ёйцукенгшщзхъфывапролджэячсмитьбю';
        $s1 = array_merge(self::utf8_str_split($sru), self::utf8_str_split(strtoupper($sru)), range('A', 'Z'), range('a', 'z'), range('0', '9'), array('&', '@', ' ', '#', ';', '%', '?', ':', '(', ')', '-', '_', '=', '+', '[', ']', ',', '.', '/', '\\', PHP_EOL));
        $codes = array();
        for ($i = 0; $i < count($s1); $i++) {
            $codes[] = ord($s1[$i]);
        }
        $str_s = self::utf8_str_split($str);
        for ($i = 0; $i < count($str_s); $i++) {
            if (!in_array(ord($str_s[$i]), $codes)) {
                $str = str_replace($str_s[$i], '', $str);
            }
        }
        return $str;
    }

    public static function getShortName($text, $len = 40) {
        if (count_chars($text) <= $len - 1)
            return $text;

        return mb_substr($text, 0, $len - 1);
    }

    public static function substr($text, $len = 40) {
        if (mb_strlen($text) <= $len - 1)
            return $text;
        return mb_substr($text, 0, $len - 1);
    }

    public static function substrFrom($text, $startIndex) {

        if ($startIndex >= strlen($text))
            return $text;

        return mb_substr($text, $startIndex, strlen($text) - 1);
    }

    public static function ru2lat_hard_table($flip = false) {
        $tr = array(
            "А" => "A", "В" => "B", "Е" => "E",
            "К" => "K", "М" => "M", "Н" => "H",
            "О" => "O", "Р" => "P", "С" => "C", "Т" => "T",
            "У" => "Y", "Х" => "X",
            "а" => "a",
            "е" => "e", "к" => "k",
            "о" => "o", "р" => "p", "с" => "c", "у" => "y",
            "х" => "x"
        );
        return $flip ? array_flip($tr) : $tr;
    }

    public static function ru2lat_hard($str) {
        return strtr($str, self::ru2lat_hard_table(false));
    }

    public static function lat2ru_hard($str) {
        return strtr($str, self::ru2lat_hard_table(true));
    }

    public static function ru2lat($str) {
        $tr = array(
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d",
            "Е" => "e", "Ё" => "yo", "Ж" => "zh", "З" => "z", "И" => "i",
            "Й" => "j", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
            "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "kh", "Ц" => "ts", "Ч" => "ch",
            "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "y", "Ь" => "",
            "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo",
            "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
            "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p",
            "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f",
            "х" => "kh", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch",
            "ъ" => "", "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu",
            "я" => "ya", " " => "-", "." => "", "," => "", "/" => "-",
            ":" => "", ";" => "", "—" => "", "–" => "-"
        );
        return strtr($str, $tr);
    }

    public static function rand($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function split($string, $delimetr = ' ', $filter = true) {
        $array = explode(' ', $string);
        return $filter ? array_filter($array) : $array;
    }

    public static function startsWithIgnoreCase($haystack, $start) {
        $haystack = strtolower($haystack);
        $start = strtolower($start);
        return $start === "" || strrpos($haystack, $start, -strlen($haystack)) !== false;
    }

    public static function startsWith($haystack, $start) {
        return $start === "" || strrpos($haystack, $start, -strlen($haystack)) !== false;
    }

    public static function endsWith($haystack, $end) {
        $result = $end === "" || (($temp = strlen($haystack) - strlen($end)) >= 0 && strpos($haystack, $end, $temp) !== false);
//        JPC1::m("US::endsWith:: string ($haystack) endsWith ($end) [" . UP::br($result) . "]");
        return $result;
    }

    public static function removeLastCharIfEndsAs($string, $char = '') {
        if (empty($string) || $char == '' || !self::endsWith($string, $char))
            return $string;
        return ($string = mb_substr($string, 0, -1));
    }

    public static function removeFirstCharIfStartsAs($string, $char = '') {
        if (empty($string) || $char == '' || !self::startsWith($string, $char))
            return $string;
        return ltrim($str, $char);
    }

    public static function appendIfNotStartsAs($string, $char = '') {
        if (!self::startsWith($string, $char))
            return $char . $string;
        return $string;
    }

    public static function appendIfNotEndsAs($string, $char = '') {
        if (!self::endsWith($string, $char))
            return $string . $char;
        return $string;
    }

    public static function removeAllChar($string, $chars = '') {
        if (empty($string) || $chars === '')
            return $string;
        return $string = str_replace($chars, '', $string);
    }

}
