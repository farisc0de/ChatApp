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
    <?php include_once 'style.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-light bg-light navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Ghostly</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <script>
        function getRooms() {
            $.get(
                "api/handler.php", {
                    action: "getRooms",
                },
                function(response) {
                    res = JSON.parse(response);

                    room = "";

                    res.forEach((rooms) => {
                        room += `<tr>
      <th scope="row">${rooms['id']}</th>
      <td>${rooms['room_name']}</td>
      <td>
        <a href="" onclick="edit('${rooms['id']}')"><span class="fas fa-edit"></span></a>
        <a href="" onclick="deleteR('${rooms['id']}')"><span class="fas fa-trash"></span></a>
      </td>
    </tr>`;
                    });

                    console.log(room);

                    $("#rooms").html(room);
                }
            );
        }

        function edit(room_id) {
            let newName = prompt("Please enter room new name");

            if (newName != null) {
                $.post(
                    "api/handler.php", {
                        action: "changeRoomName",
                        room_name: newName,
                        id: room_id
                    },
                    function(response) {
                        if (JSON.parse(response)["response"] == true) {
                            location.reload();
                        }
                    }
                );
            }
        }

        function add() {
            let roomName = prompt("Please enter new room name");

            if (roomName != null) {
                $.post(
                    "api/handler.php", {
                        action: "addRoom",
                        room_name: roomName,
                    },
                    function(response) {
                        if (JSON.parse(response)["response"] == true) {
                            location.reload();
                        }
                    }
                );
            }

            return;
        }

        function deleteR(r_id) {
            $.post(
                "api/handler.php", {
                    action: "deleteRoom",
                    room_id: r_id,
                },
                function(response) {
                    if (JSON.parse(response)["response"] == true) {
                        location.reload();
                    }
                }
            );
        }

        window.onload = getRooms();
    </script>
</body>

</html>