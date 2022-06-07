<?php include_once 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghostly - Chat Private</title>
    <?php include_once 'components/style.php'; ?>
</head>

<body>

    <?php include_once 'components/navbar.php'; ?>

    <input id="to_user" value="<?php echo $_GET['user']; ?>" hidden />

    <div class="container pt-4">
        <div class="row justify-content-center pb-3">
            <button id="dispose" class="btn btn-primary">Dispose</button>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12">

                <div id="chat_private"></div>

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
    <script src="private.js"></script>
</body>

</html>