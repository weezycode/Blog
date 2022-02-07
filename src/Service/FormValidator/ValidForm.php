<?php

declare(strict_types=1);

namespace  App\Service\FormValidator;

final class ValidForm
{
    /**
     * Check if is not empty and purify
     *
     * @param mixed $param
     *
     * @return mixed $param
     */
    public static function purify($data)
    {
        if ((isset($data) && ($data != '  ')) && !is_null($data) && strlen($data) >= 2) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

            return $data;
        }
    }
    public static function purifyPass($data)
    {
        if ((isset($data) && ($data != '  ')) && strlen($data) >= 6) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

            return true;
        }
    }

    public static function purifyPassword($value)
    {
        if (!is_null($value) && preg_match('/^[[:alnum:][:punct:]]+$/', $value) && !empty($value)) {
            return true;
        }
    }

    public static function purifyAll($data)
    {
        if ((isset($data) && ($data !== "")) && strlen(trim($data)) >= 5 && !empty($data)) {
            //$data = trim($data);
            $data = is_array($data) ?
                array_map("stripslashes_deep", $data) :
                stripslashes($data);
            $data = htmlspecialchars($data);
            $data = html_entity_decode($data, ENT_QUOTES, "UTF-8");
            return $data;
        }
    }
    /** * Check if is not empty * * @param $data * * @return bool */
    public static function purifyContent($data)
    {
        if (isset($data) && !is_null($data) && ($data != " ")) {
            return $data;
        }
    }
    /** * Check if is alpha * * @param $value * * @return bool */
    public static function is_alpha($value)
    {
        if (!is_null($value) && preg_match("/^[a-zA-Z-']/", $value) && !empty($value)) {
            return true;
        }
    }
    /** * Check if alphanumeric * * @param $value * * @return bool */
    public static function is_alphanum($value)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $value) && !empty($value)) {
            return true;
        }
    }
    /** * Check if is email * * @param $value * * @return bool */
    public static function is_email($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) && !empty($value)) {
            return true;
        }
    }
    /** * Check if is email * * @param $value * * @return bool */
    public static function isMail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) && empty($value)) {
            return false;
        }
    }
    /** * Check if lower * * @param $value * * @return bool */
    public function is_lowercase($value)
    {
        if (preg_match('/[a-z]/', $value)) {
            return true;
        }
    }
    /** * Check if uppser * * @param $value * * @return bool */
    public function is_uppercase($value)
    {
        if (preg_match('/[A-Z]/', $value)) {
            return true;
        }
    }

    /** * Check if number * * @param $value * * @return bool */
    public  function is_number($value)
    {
        if (preg_match('/[0-9]/', $value)) {
            return true;
        }
    }

    /** * Check if carac * * @param $value * * @return bool */
    public function is_carak($value)
    {
        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $value)) {
            return true;
        }
    }
    /** * Check if ok * * @param $data * * @return bool */
    public static function purifyMe($data)
    {
        if (($data) && strlen($data) > 5) {
            return true;
        }
    }

    /** * Check if is alpha * * @param $value * * @return bool */
    public static function is_alphAll($data)
    {

        if ((isset($data) && ($data != '  ')) && !is_null($data) && strlen($data) >= 2 && preg_match("/^[a-zA-Z-é']/", $data) && !empty($data)) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

            return $data;
        }
    }
}
