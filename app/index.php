<?php include_once 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ghostly - Home</title>
	<?php include_once 'components/style.php'; ?>
</head>

<body>

	<?php include_once 'components/navbar.php'; ?>

	<input id="room_id" value="<?php echo $_SESSION['room_id']; ?>" hidden />
	<input id="user" value="<?php echo $_SESSION['username']; ?>" hidden />

	<div class="container pt-4">
		<div class="row justify-content-center">
			<div class="col-lg-10 col-md-12 col-sm-12">
				<div id="online"></div>

				<div id="chat"></div>

				<div class="pt-3">
					<form method="POST" id="Messagebox">
						<textarea id="message" class="form-control" placeholder="Please Type a message to send"></textarea>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="pt-3"></div>

	<?php include_once 'components/script.php'; ?>
	<script src='inputEmoji.js'></script>
	<script src="script.js"></script>
</body>

</html>