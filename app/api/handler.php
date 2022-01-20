<?php
session_start();

include_once '../config.php';
include_once '../src/Database.php';
include_once '../src/Messages.php';
include_once '../src/Users.php';
include_once '../src/Utils.php';
include_once '../src/Rooms.php';

$db = new Database($config);
$message = new Messages($db);
$users = new Users($db);
$utils = new Utils();
$rooms = new Rooms($db);

switch ($_REQUEST['action']) {
	case "sendMessage":
		$user_id = $users->getUserByUsername($_SESSION['username'])->id;

		if ($message->sendMessage(
			$user_id,
			$utils->sanitize($_REQUEST['message']),
			$_REQUEST['room']
		)) {
			echo json_encode(["response" => true]);
		}
		break;

	case "getMessages":
		$rs = $message->getMessages($_REQUEST['room']);

		$chat = [];

		foreach ($rs as $message) {
			$username = $users->getUser($message->user)->username;

			array_push($chat, [
				"align" => ($_SESSION['username'] == $username) ? 'right' : 'left',
				"username" => $username,
				"message" => $message->message,
				"time" => date('h:i a', strtotime($message->date))
			]);
		}

		echo json_encode($chat);
		break;

	case "getOnlineUsers":
		$users = $users->getOnline($_REQUEST['room']);

		echo json_encode($users);
		break;

	case "addRoom":
		if ($rooms->createRoom($_REQUEST['room_name'])) {
			echo json_encode(['response' => true]);
		}
		break;

	case "changeRoomName":
		if ($rooms->updateRoom($_REQUEST['id'], $_REQUEST['room_name'])) {
			echo json_encode(['response' => true]);
		}
		break;
}
