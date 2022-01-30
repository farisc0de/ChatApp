$("#message").emoji({
  place: "after",
});

LoadMessages();
LoadUsers();

function LoadMessages() {
  var room_id = $("#room_id").val();

  $.get(
    "api/handler.php",
    { action: "getMessages", room: room_id },
    function (response) {
      var scrollpos = parseInt($("#chat").scrollTop()) + 520;
      var scrollHeight = $("#chat").prop("scrollHeight");

      chat = JSON.parse(response);

      messages = "";

      chat.forEach((message) => {
        messages += `<div class="single-message ${message["align"]}">
						<strong>${message["username"]}: </strong>
            <br />
            <p>${message["message"]}</p>
						<br />
						<span>${message["time"]}</span>
						</div>
						<div class="clear"></div>`;
      });

      $("#chat").html(messages);

      if (scrollpos < scrollHeight) {
      } else {
        $("#chat").scrollTop($("#chat").prop("scrollHeight"));
      }
    }
  );
}

function LoadUsers() {
  var room_id = $("#room_id").val();

  $.get(
    "api/handler.php",
    { action: "getOnlineUsers", room: room_id },
    function (response) {
      users = JSON.parse(response);

      online_users = "";

      users.forEach((online) => {
        code_color = "";

        if (online["is_admin"] == 1) {
          code_color = "text-danger";
        }

        online_users += `<ul class="list-unstyled"><li class="${code_color}">${online["username"]}</li></ul>`;
      });

      $("#online").html(online_users);
    }
  );
}

$("#message").keyup(function (e) {
  if (e.which == 13) {
    $("form").submit();
  }
});

$("form").submit(function () {
  var message = $("#message").val();
  var room_id = $("#room_id").val();

  $.post(
    "api/handler.php",
    { action: "sendMessage", message: message, room: room_id },
    function (response) {
      if (JSON.parse(response)["response"] == true) {
        LoadMessages();
        document.getElementById("Messagebox").reset();
      }
    }
  );

  return false;
});

setInterval(function () {
  LoadMessages();
  LoadUsers();
}, 1000);
