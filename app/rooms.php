<?php
include_once "session.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ghostly - Manage Rooms</title>
    <?php include_once 'components/style.php'; ?>
</head>

<body>

    <?php include_once 'components/navbar.php'; ?>

    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Manage Rooms</div>
                    <div class="card-body">
                        <?php if (isset($error)) : ?>
                            <?php echo $utils->alert($error, "danger", "times-circle"); ?>
                        <?php endif; ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Settings</th>
                                </tr>
                            </thead>
                            <tbody id="rooms"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a onclick="add()" class="btn btn-primary">Add room</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'components/script.php'; ?>
    <script src="rooms.js"></script>
</body>

</html>