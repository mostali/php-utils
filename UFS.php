<?php

class UFS {

    static function wo($fn, $obj, $mkdir = false) {
        if ($mkdir)
            @mkdir(dirname($fn), 0755, true);

        $string_data = serialize($obj);
        file_put_contents($fn, $string_data);
    }

    static function ro($fn) {
        $string_data = file_get_contents($fn);
        return unserialize($string_data);
    }

    static function writeArray($to_file, $array, $mkdir = false) {
        if ($mkdir && !file_exists(dirname($to_file)))
            @mkdir(dirname($to_file), 0755, true);

        $string_data = "<?php  return " . var_export($array, true) . ';';

        file_put_contents($to_file, $string_data);
    }

    static function readArray($fn) {
        return include $fn;
    }

    static function writeFile($file, $content, $flags = LOCK_EX, $mkdir = false) {
        if ($mkdir && !file_exists(dirname($file)))
            @mkdir(dirname($file), 0755, true);
        file_put_contents($file, $content, $flags);
    }

    static function removeFile($filename) {
        if (file_exists($filename))
            unlink($filename);
    }

    static function removeFileByMask($filename_mask) {
        $i = 0;
        foreach (glob($filename_mask) as $filename) {
            unlink($filename);
            $i++;
        }
        return $i;
    }

    static function readFile($file) {
        return file_get_contents($file);
    }

    static function files($file = './*') {
//        foreach (glob("./*.php") as $filename) {
//            echo "$filename размер " . filesize($filename) . "\n";
//        }
        return glob($file);
    }

//    function file_put_contents_force($file, $contents) {
//        $dir = self::mkdirs(dirname($fn));
//        file_put_contents($file, $contents);
//    }
//    function mkdirs($dir) {
//        if (file_exists($dir))
//            return;
//
//        $parts = explode('/', $dir);
//        $file = array_pop($parts);
//        $dir = '';
//        foreach ($parts as $part)
//            if (!is_dir($dir .= "/$part"))
//                mkdir($dir);
//        return $dir;
//    }
}
