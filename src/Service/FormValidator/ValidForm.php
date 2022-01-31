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
        if ((isset($data) && ($data != '  ')) && !is_null($data) && strlen($data) > 5) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

            return $data;
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
        if ((isset($data) && ($data !== "")) && !is_null($data) && strlen(trim($data)) > 0 && !empty($data)) {
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
        if (isset($data) && !is_null($data) && ($data != "")) {
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
}
