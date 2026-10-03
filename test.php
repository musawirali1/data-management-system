<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<?php

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
// Set session variables
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

//unset($_SESSION["favcolor"]);
session_unset();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

</body>
</html>
<?php
function getGravator($email, $size = 150)
{
    // Email ko clean karna
    $email = strtolower(trim($email));

    // Email ka hash banana
    $hash = md5($email);

    // Gravatar image URL
    return "https://www.gravatar.com/avatar/" . $hash . "?s=" . $size . "&d=mp";

}

https://www.gravatar.com/avatar/9d71f9edcaf3034dc70120becfac6bd0?s=150&d=mp

?>