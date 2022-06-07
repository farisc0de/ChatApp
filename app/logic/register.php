<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/User.php';
include_once 'src/Auth.php';
include_once 'src/Utility.php';

$utils = new Utility();
$db = new Database($config);
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $utils->sanitize($_POST['username']);
    $email = $utils->sanitize($_POST['email']);
    $password = $utils->sanitize($_POST['password']);

    print_r($username);

    if (!$user->check($email) && !$user->check($username)) {
        $user->create([
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
