<?php
session_start();

include_once '../config.php';
include_once '../src/Database.php';
include_once '../src/Messages.php';
include_once '../src/Users.php';
include_once '../src/Utils.php';
include_once '../src/Rooms.php';
include_once '../vendor/autoload.php';

use phpseclib3\Crypt\AES;

$db = new Database($config);
$message = new Messages($db);
$users = new Users($db);
$utils = new Utils();
$rooms = new Rooms($db);

$cipher = new AES('cbc');
$cipher->setKeyLength(256);
$cipher->setIV($key['IV']);

switch ($_REQUEST['action']) {
	case "sendMessage":
		$user_id = $users->getUserByUsername($_SESSION['username'])->id;

		$key = $utils->random_str(32);

		$cipher->setKey($key);

		if ($message->sendMessage(
			$user_id,
			base64_encode($cipher->encrypt($utils->sanitize($_REQUEST['message']))),
			base64_encode($key),
			$_REQUEST['room']
		)) {
			echo json_encode(["response" => true]);
		}
		break;

	case "getMessages":
		$rs = $message->getMessages($_REQUEST['room']);

		$chat = [];

		if (is_array($rs)) {
			foreach ($rs as $message) {
				$username = $users->getUser($message->user)->username;

				$cipher->setKey(base64_decode($message->encryption_key));

				array_push($chat, [
					"align" => ($_SESSION['username'] == $username) ? 'right' : 'left',
					"username" => $username,
					"message" => $cipher->decrypt(base64_decode($message->message)),
					"time" => date('h:i a', strtotime($message->date))
				]);
			}
		}

		echo json_encode($chat);
		break;

	case "getOnlineUsers":
		$users = $users->getOnline($_REQUEST['room']);

		echo json_encode($users);
		break;

	case "getRooms":
		echo json_encode($rooms->getRooms());
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

	case "deleteRoom":
		if ($rooms->deleteRoom($_REQUEST['room_id'])) {
			echo json_encode(['response' => true]);
		}
		break;
}
