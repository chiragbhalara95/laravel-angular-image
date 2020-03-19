<?php
    namespace App\Helpers;

    class StringHelper {

        public function __construct() {

        }

        public static function seoUrl($string) {
            $string = trim($string); // Trim String
            $string = strtolower($string); //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);  //Strip any unwanted characters
            $string = preg_replace("/[\s-]+/", " ", $string); // Clean multiple dashes or whitespaces
            $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash

            return $string;
        }

        public static function generateFileName($fileName, $ext)
        {
            $fileName = strtolower(rand(11111, 99999) . '' . $fileName);
            $fileName = substr($fileName, 0, 20);
            $fileName = self::seoUrl($fileName);
            $fileName = $fileName.'.'.$ext;

            return $fileName;
        }

        public static function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
            {
                $sets = [];
                if(strpos($available_sets, 'l') !== false)
                    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
                if(strpos($available_sets, 'u') !== false)
                    $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
                if(strpos($available_sets, 'd') !== false)
                    $sets[] = '23456789';
                if(strpos($available_sets, 's') !== false)
                    $sets[] = '!@#$%&*?';
                $all = '';
                $password = '';
                foreach($sets as $set)
                {
                    $password .= $set[array_rand(str_split($set))];
                    $all .= $set;
                }
                $all = str_split($all);
                for($i = 0; $i < $length - count($sets); $i++)
                    $password .= $all[array_rand($all)];
                $password = str_shuffle($password);
                if(!$add_dashes)
                    return $password;
                $dash_len = floor(sqrt($length));
                $dash_str = '';
                while(strlen($password) > $dash_len)
                {
                    $dash_str .= substr($password, 0, $dash_len) . '-';
                    $password = substr($password, $dash_len);
                }
                $dash_str .= $password;
                return $dash_str;
        }

    }
?>