<?php
session_start();

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/User.php';
include_once 'src/Utility.php';

$utils = new Utility();
$db = new Database($config);
$user = new User($db);

$user->setOffline($_SESSION['username']);

if (session_destroy()) {
    $utils->redirect("login.php");
}
