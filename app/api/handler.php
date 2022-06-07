<?php
session_start();

ini_set("display_errors", 1);
error_reporting(E_ALL);

include_once '../config.php';
include_once '../src/Database.php';
include_once '../src/Message.php';
include_once '../src/User.php';
include_once '../src/Utility.php';
include_once '../src/Room.php';
include_once '../vendor/autoload.php';

use phpseclib3\Crypt\AES;

$db = new Database($config);
$message = new Message($db);
$users = new User($db);
$utils = new Utility();
$rooms = new Room($db);

$cipher = new AES('cbc');
$cipher->setKeyLength(256);
$cipher->setIV($key['IV']);

switch ($_REQUEST['action']) {
	case "sendMessage":
		$user_id = $users->getByUsername($_SESSION['username'])->id;

		$key = $utils->random_str(32);

		$cipher->setKey($key);

		if ($message->send(
			$user_id,
			base64_encode($cipher->encrypt($utils->sanitize($_REQUEST['message']))),
			base64_encode($key),
			$_REQUEST['room'],
			0
		)) {
			echo json_encode(["response" => true]);
		}
		break;

	case "sendPrivateMessage":
		$user_id = $users->getByUsername($_SESSION['username'])->id;

		$key = $utils->random_str(32);

		$cipher->setKey($key);

		if ($message->sendPrivate(
			$user_id,
			base64_encode($cipher->encrypt($utils->sanitize($_REQUEST['message']))),
			base64_encode($key),
			$_REQUEST['to']
		)) {
			echo json_encode(["response" => true]);
		}
		break;

	case "getMessages":
		$rs = $message->getAll($_REQUEST['room']);

		$chat = [];

		if (is_array($rs)) {
			foreach ($rs as $message) {
				if ($message->room_id != null) {
					$username = $users->get($message->user)->username;

					$cipher->setKey(base64_decode($message->encryption_key));

					array_push($chat, [
						"align" => ($_SESSION['username'] == $username) ? 'right' : 'left',
						"username" => $username,
						"message" => $cipher->decrypt(base64_decode($message->message)),
						"time" => date('h:i a', strtotime($message->date))
					]);
				}
			}
		}

		echo json_encode($chat);
		break;

	case "getPrivateMessages":
		$user_id = $users->getByUsername($_SESSION['username'])->id;
		$reciver_id = $_REQUEST['to'];

		$rs = $message->getPrivate($user_id, $reciver_id);

		$chat = [];

		if (is_array($rs)) {
			foreach ($rs as $message) {
				$username = $users->get($message->user)->username;

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

	case 'dispose':
		$user_id = $users->getByUsername($_SESSION['username'])->id;
		$reciver_id = $_REQUEST['to'];

		$message->delete($user_id, $reciver_id);

		echo json_encode(["response" => true]);
		break;

	case "getOnlineUsers":
		$users = $users->getOnline($_REQUEST['room']);

		echo json_encode($users);
		break;

	case "getRooms":
		echo json_encode($rooms->getAll());
		break;

	case "addRoom":
		if ($rooms->create($_REQUEST['room_name'])) {
			echo json_encode(['response' => true]);
		}
		break;

	case "changeRoomName":
		if ($rooms->update($_REQUEST['id'], $_REQUEST['room_name'])) {
			echo json_encode(['response' => true]);
		}
		break;

	case "deleteRoom":
		if ($rooms->delete($_REQUEST['room_id'])) {
			echo json_encode(['response' => true]);
		}
		break;
}
