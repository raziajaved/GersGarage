<?php
session_start(); 
$_SESSION = array();
//set cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 60*60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//destroy session
unset($_SESSION['login']);
session_destroy();
header("location:index.php"); 
?>

