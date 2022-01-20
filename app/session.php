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

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($_SESSION)) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if ($username != null) {
        if (isset($_SESSION['loggedin'])) {
            $data = $user->getUserByUsername($username);

            if ($data->is_admin) {
                $_SESSION["is_admin"] = true;
            }
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
