<?php
namespace App\Util;
class HKT
{
    public static function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die;
    }
}
