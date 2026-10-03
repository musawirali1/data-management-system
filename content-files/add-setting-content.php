<?php

// ==========================================
// KONSA TAB ACTIVE HAI (URL SE)
// Example: add-setting-form.php?tab=user-setting
// ==========================================

$allowed_tabs = ['general', 'datetime', 'system', 'user-setting'];

$active_tab = isset($_GET['tab']) && in_array($_GET['tab'], $allowed_tabs, true)
    ? $_GET['tab']
    : 'general';

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- ===============================
         Page Heading
    ================================= -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <h2 class="text-primary">
            <b>Application Settings</b>
        </h2>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" >
          <h5 class="text-muted">Welcome to the Application Settings 👋</h5>
        </div>
    </div>


    <!-- ===============================
         Settings Main Card
    ================================= -->
    <div class="card shadow-sm p-4">

        <h4 class="mb-4">
             Settings Management
        </h4>


        <!-- ===============================
             Navigation Tabs
             Yeh ab normal <a> links hain.
             Click karne se page reload hogi
             aur URL me ?tab=xxx set ho jayega.
             AJAX ki koi zarurat nahi.
        ================================= -->
        <ul class="nav nav-tabs">


         <!-- General -->
            <li class="nav-item">
                <a href="add-setting-form.php?tab=general"
                   class="nav-link <?= $active_tab === 'general' ? 'active' : ''; ?>">
                    General
                </a>
            </li>

            <!-- Date & Time -->
            <li class="nav-item">
                <a href="add-setting-form.php?tab=datetime"
                   class="nav-link <?= $active_tab === 'datetime' ? 'active' : ''; ?>">
                    Date & Time
                </a>
            </li>

            <!-- System -->
            <li class="nav-item">
                <a href="add-setting-form.php?tab=system"
                   class="nav-link <?= $active_tab === 'system' ? 'active' : ''; ?>">
                    System
                </a>
            </li>

            <!-- User Setting -->
            <li class="nav-item">
                <a href="add-setting-form.php?tab=user-setting"
                   class="nav-link <?= $active_tab === 'user-setting' ? 'active' : ''; ?>">
                    User Setting
                </a>
            </li>

        </ul>


        <br>


        <!-- ===============================
             Yahan PHP seedha sahi file
             include karta hai, $active_tab
             ke hisab se. Koi AJAX / JS
             load() istemal nahi ho raha.

             Default:
             general-setting.php

             tab=datetime:
             datetime-setting.php

             tab=system:
             system-setting.php

             tab=user-setting:
             user-setting.php
        ================================= -->

        <div id="setting_content">

            <?php

            switch ($active_tab) {

                case 'datetime':
                    include(__DIR__ . '/settings/datetime-setting.php');
                    break;

                case 'system':
                    include(__DIR__ . '/settings/system-setting.php');
                    break;

                case 'user-setting':
                    include(__DIR__ . '/settings/user-setting.php');
                    break;

                default:
                    include(__DIR__ . '/settings/general-setting.php');
                    break;
            }

            ?>

        </div>

    </div>

</main>