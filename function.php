<?php

if (!defined('APP_DATE_FORMAT')) {
    require_once __DIR__ . '/config/app-setting.php';
}

// Converts timestamp value into the configured display format.
function custom_time_convert($value, $type = "datetime") {
    if (empty($value)) {
        return "";
    }

    $timestamp = strtotime($value);

    if ($timestamp === false) {
        return $value;
    }

    if ($type === "date") {
        return date(APP_DATE_FORMAT, $timestamp);
    }

    if ($type === "time") {
        return date(APP_TIME_FORMAT, $timestamp);
    }

    return date(APP_DATE_FORMAT . " " . APP_TIME_FORMAT, $timestamp);
}

function getGravator($email, $size = 150)
{
    // Email ko clean karna
    $email = strtolower(trim($email));

    // Email ka hash banana
    $hash = md5($email);

    // Gravatar image URL
    return "https://www.gravatar.com/avatar/" . $hash . "?s=" . $size . "&d=mp";

}