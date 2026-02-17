<?php
// Logout page.
// Clears the current session and returns the user to the homepage.

require_once(__DIR__ . "/../controller/auth_controller.php");

$inViewFolder = (strpos($_SERVER["PHP_SELF"], "/view/") !== false);
$homeHref = $inViewFolder ? "../index.php" : "index.php";
$viewPrefix = $inViewFolder ? "" : "view/";

AuthController::logoutAndRedirect($homeHref);
?>