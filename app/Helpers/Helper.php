<?php

namespace App\Helpers;

class Helper
{
    public function printArray(array $arr)
    {
        echo "<pre>";
        echo print_r($arr);
        echo "</pre>";
    }

    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
