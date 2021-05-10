<?php
if (!function_exists('normalize')) {
    function normalize($line)
    {
        return str_replace(array("\r\n", "\r", "\n"), '', $line);
    }
}

if (!function_exists('getUniqueLogKey')) {
    function getUniqueLogKey()
    {
        return date(DATETIME_FORMAT ?? 'Ymd_Hi_s');
    }
}
