<?php
require_once "../../functions/autoload.php";
require_once "../../class/Authentication.php";

$postData = $_POST;

$username = $postData['username'] ?? '';
$password = $postData['password'] ?? '';

$loginRole = (new Authentication())->log_in($username, $password);

if ($loginRole) {
    if ($loginRole === "user") {
        header('Location: ../../index.php?s=home');
        exit;
    }

    header('Location: ../index.php?a=dashboard');
    exit;
}

// El error queda en $_SESSION['login_error']
header('Location: ../../index.php?s=login&err=1');
exit;