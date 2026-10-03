<?php
require_once "Auth/check_login.php";
?>
<?php 
      include('function.php');
      include("app-setting.php");
      include('header.php');

     
     $current_page = "teacher_view_content";
      include('content.php');
      include('footer.php');
?>