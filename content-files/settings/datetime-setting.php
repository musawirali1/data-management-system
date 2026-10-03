<?php

include_once(__DIR__ . "/../../db-connection.php");
include_once(__DIR__ . "/../../config/app-setting.php");

$timezone = "";
$date_format = "";
$time_format = "";

$success = 0;


/* =========================
   SAVE DATE & TIME SETTINGS
   ========================= */

if (isset($_POST['save_datetime'])) {

    $timezone = $_POST['timezone'];
    $date_format = $_POST['date_format'];
    $time_format = $_POST['time_format'];


    /* Create Associative Array */
    $datetime_setting_arr = array(
        "timezone"    => $timezone,
        "date_format" => $date_format,
        "time_format" => $time_format
    );


    /* Convert Array into String */
    $datetime_setting_str = serialize($datetime_setting_arr);

    /* Check if datetime_setting already exists */
    $check = $conn->query("
        SELECT id 
        FROM settings 
        WHERE setting_name = 'datetime_setting'
        LIMIT 1
    ");


    if ($check->num_rows > 0) {

        /* Existing Setting → UPDATE */
        $row = $check->fetch_assoc();
        $id = $row['id'];
        $sql = "UPDATE settings SET
                setting_value = '$datetime_setting_str'
                WHERE id = '$id'";


    } else {

        /* Setting does not exist → INSERT */

        $sql = "INSERT INTO settings
                (setting_name, setting_value)
                VALUES
                ('datetime_setting', '$datetime_setting_str')";
    }


    /* Execute Query */

    if ($conn->query($sql)) {

        $success = 1;

    } else {

        echo "<div class='alert alert-danger'>"
            . $conn->error .
            "</div>";
    }
}


/* =========================
   GET DATE & TIME SETTINGS
   ========================= */

$result = $conn->query("
    SELECT setting_value
    FROM settings
    WHERE setting_name = 'datetime_setting'
    LIMIT 1
");


if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();


    /* Convert String back into Array */

    $datetime_setting_arr = unserialize($row['setting_value']);


    /* Get Values from Array */

    $timezone = $datetime_setting_arr['timezone'] ?? "";
    $date_format = $datetime_setting_arr['date_format'] ?? "";
    $time_format = $datetime_setting_arr['time_format'] ?? "";
}

?>


<div class="card mt-4 shadow-sm">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">
            Date & Time Settings
        </h5>

    </div>


    <div class="card-body">


        <?php if ($success) { ?>

            <div class="alert alert-success">

                Settings Saved Successfully

            </div>

        <?php } ?>


        <form id="datetimeForm" method="POST">


            <!-- =========================
                 TIMEZONE
            ========================== -->

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Timezone
                </label>


                <select
                    name="timezone"
                    class="form-control"
                >

                    <option
                        value="Asia/Karachi"
                        <?= ($timezone == "Asia/Karachi") ? "selected" : ""; ?>
                    >
                        Asia/Karachi
                    </option>


                    <option
                        value="Asia/Dubai"
                        <?= ($timezone == "Asia/Dubai") ? "selected" : ""; ?>
                    >
                        Asia/Dubai
                    </option>


                    <option
                        value="Europe/London"
                        <?= ($timezone == "Europe/London") ? "selected" : ""; ?>
                    >
                        Europe/London
                    </option>


                    <option
                        value="America/New_York"
                        <?= ($timezone == "America/New_York") ? "selected" : ""; ?>
                    >
                        America/New_York
                    </option>

                </select>

            </div>


            <hr>


            <!-- =========================
                 DATE FORMAT
            ========================== -->

            <label class="fw-bold">
                Date Format
            </label>


            <div>

                <input
                    type="radio"
                    name="date_format"
                    value="F j, Y"
                    <?= ($date_format == "F j, Y") ? "checked" : ""; ?>
                >

                June 30, 2026

            </div>


            <div>

                <input
                    type="radio"
                    name="date_format"
                    value="Y-m-d"
                    <?= ($date_format == "Y-m-d") ? "checked" : ""; ?>
                >

                2026-06-30

            </div>


            <div>

                <input
                    type="radio"
                    name="date_format"
                    value="d/m/Y"
                    <?= ($date_format == "d/m/Y") ? "checked" : ""; ?>
                >

                30/06/2026

            </div>


            <hr>


            <!-- =========================
                 TIME FORMAT
            ========================== -->

            <label class="fw-bold">
                Time Format
            </label>


            <div>

                <input
                    type="radio"
                    name="time_format"
                    value="g:i a"
                    <?= ($time_format == "g:i a") ? "checked" : ""; ?>
                >

                7:32 pm

            </div>


            <div>

                <input
                    type="radio"
                    name="time_format"
                    value="g:i A"
                    <?= ($time_format == "g:i A") ? "checked" : ""; ?>
                >

                7:32 PM

            </div>


            <div>

                <input
                    type="radio"
                    name="time_format"
                    value="H:i"
                    <?= ($time_format == "H:i") ? "checked" : ""; ?>
                >

                19:32

            </div>


            <!-- =========================
                 SAVE BUTTON
            ========================== -->

            <button
                type="submit"
                name="save_datetime"
                value="1"
                class="btn btn-primary mt-4"
            >

                Save Changes

            </button>


        </form>

    </div>

</div>