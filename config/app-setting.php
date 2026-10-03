<?php

require_once __DIR__ . '/../db-connection.php'; // db-connection.php file ko sirf ek hi baar load karega.
                                                // __DIR__ current folder ko represent karta hai.

//$result = $conn->query("SELECT * FROM datetime_settings LIMIT 1");

$result = $conn->query("SELECT * FROM settings 
        where setting_name = 'datetime_setting'");


if ($result && $result->num_rows > 0) {
    $setting = $result->fetch_assoc();
    //print_r($setting);
    //echo '<hr>';
   
    $setting_arr = unserialize($setting['setting_value']);
    //print_r($setting_arr);
    //echo '<hr>';
    $timezone = $setting_arr['timezone'];
    $date_format = $setting_arr['date_format'];
    $time_format = $setting_arr['time_format'];


    //echo 'this is value for $timezone:'.$timezone . "<br>";
     //echo 'this is value for $date_format:'.$date_format . "<br>";
      //echo 'this is value for $time_format:'.$time_format . "<br>";

    date_default_timezone_set($timezone);

    if (!defined('APP_DATE_FORMAT')) {
        define('APP_DATE_FORMAT', $date_format);
    }

    if (!defined('APP_TIME_FORMAT')) {
        define('APP_TIME_FORMAT', $time_format);
    }
} else {
    date_default_timezone_set('Asia/Karachi');

    if (!defined('APP_DATE_FORMAT')) {
        define('APP_DATE_FORMAT', 'd/m/Y');
    }

    if (!defined('APP_TIME_FORMAT')) {
        define('APP_TIME_FORMAT', 'g:i A');
    }
}
