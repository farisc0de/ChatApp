function getRooms() {
  $.get(
    "api/handler.php",
    {
      action: "getRooms",
    },
    function (response) {
      res = JSON.parse(response);

      room = "";

      res.forEach((rooms) => {
        room += `<tr>
      <th scope="row">${rooms["id"]}</th>
      <td>${rooms["room_name"]}</td>
      <td>
        <a href="" onclick="edit('${rooms["id"]}')"><span class="fas fa-edit"></span></a>
        <a href="" onclick="deleteR('${rooms["id"]}')"><span class="fas fa-trash"></span></a>
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
      "api/handler.php",
      {
        action: "changeRoomName",
        room_name: newName,
        id: room_id,
      },
      function (response) {
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
      "api/handler.php",
      {
        action: "addRoom",
        room_name: roomName,
      },
      function (response) {
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
    "api/handler.php",
    {
      action: "deleteRoom",
      room_id: r_id,
    },
    function (response) {
      if (JSON.parse(response)["response"] == true) {
        location.reload();
      }
    }
  );
}

window.onload = getRooms();
