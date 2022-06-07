<?php
session_start();
include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/User.php';
include_once 'src/Auth.php';
include_once 'src/Utility.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);

$utils = new Utility();
$db = new Database($config);
$user = new User($db);
$auth = new Auth($db);

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($_SESSION)) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if ($username != null) {
        if (isset($_SESSION['loggedin'])) {
            $data = $user->getByUsername($username);
            $_SESSION["is_admin"] = $data->is_admin;
        }
    }


    if (strpos($current_url, "rooms.php")) {
        if (!($_SESSION['is_admin'])) {
            $utils->redirect(('index.php'));
        }
    }

    if (!isset($_SESSION['loggedin'])) {
        $utils->redirect("login.php");
    }
}

$page = 'session';
