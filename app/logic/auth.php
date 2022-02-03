<?php

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Users.php';
include_once 'src/Auth.php';
include_once 'src/Utils.php';
include_once 'src/Rooms.php';

$utils = new Utils();
$db = new Database($config);
$auth = new Auth($db);
$user = new Users($db);
$rooms = new Rooms($db);

/** Lock out time used for brute force protection */

$lockout_time = 10;
$room = $rooms->getRooms();

/** Check if user is already log in */

if (isset($_SESSION['loggedin'])) {
    $utils->redirect("index.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $utils->sanitize($_POST['username']);
    $password = $utils->sanitize($_POST['password']);

    $loginstatus = $auth->newLogin($username, $password);

    if ($loginstatus == 200) {
        session_regenerate_id();

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['room_id'] = ($_POST["room"] == "0") ? "1" : $_POST['room'];

        $user->setOnline($username, $_SESSION['room_id']);

        $utils->redirect("index.php");
    } elseif ($loginstatus == 401) {
        $error = "Username or Password is incorrect.";
    } elseif ($loginstatus == 403) {
        $error = "This account has been locked because of too many failed logins.
        \nIf this is the case, please try again in $lockout_time minutes.";
    } else {
        $error = "Unexpected error occurred !";
    }
}
