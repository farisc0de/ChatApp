<?php

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Users.php';
include_once 'src/Auth.php';
include_once 'src/Utils.php';

$utils = new Utils();
$db = new Database($config);
$user = new Users($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $utils->sanitize($_POST['username']);
    $email = $utils->sanitize($_POST['email']);
    $password = $utils->sanitize($_POST['password']);

    if (!$user->checkUser($email) && !$user->checkUser($username)) {
        $user->createUser([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'is_admin' => 0
        ]);

        $msg = "Account created";
    } else {
        $error = "User already exist";
    }
}

$page = "signupPage";
