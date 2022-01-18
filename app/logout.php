<?php
session_start();

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Users.php';
include_once 'src/Utils.php';

$utils = new Utils();
$db = new Database($config);
$user = new Users($db);

$user->setOffline($_SESSION['username']);

if (session_destroy()) {
    $utils->redirect("login.php");
}
