<?php
session_start();
include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Users.php';
include_once 'src/Auth.php';
include_once 'src/Utils.php';

$utils = new Utils();
$db = new Database($config);
$user = new Users($db);
$auth = new Auth($db);

if (isset($_SESSION)) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if ($username != null) {
        if (isset($_SESSION['loggedin'])) {
            $data = $user->getUserByUsername($username);
        }
    }

    if (!isset($_SESSION['loggedin'])) {
        $utils->redirect("login.php");
    }
}

$page = 'session';
