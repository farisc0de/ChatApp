$("#message").emoji({
  place: "after",
});

LoadMessages();
LoadUsers();

function LoadMessages() {
  $.post("api/handler.php", { action: "getMessages" }, function (response) {
    var scrollpos = $("#chat").scrollTop();
    var scrollpos = parseInt(scrollpos) + 520;
    var scrollHeight = $("#chat").prop("scrollHeight");

    chat = JSON.parse(response);

    messages = ``;

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
  });
}

function LoadUsers() {
  $.post("api/handler.php", { action: "getOnlineUsers" }, function (response) {
    var scrollpos = $("#online").scrollTop();
    var scrollpos = parseInt(scrollpos) + 520;
    var scrollHeight = $("#online").prop("scrollHeight");

    users = JSON.parse(response);

    online_users = ``;

    users.forEach((online) => {
      online_users += `<ul class="list-unstyled"><li>${online["username"]}</li></ul>`;
    });

    $("#online").html(online_users);

    if (scrollpos < scrollHeight) {
    } else {
      $("#online").scrollTop($("#online").prop("scrollHeight"));
    }
  });
}

$("#message").keyup(function (e) {
  if (e.which == 13) {
    $("form").submit();
  }
});

$("form").submit(function () {
  var message = $("#message").val();

  $.post(
    "api/handler.php",
    { action: "sendMessage", message: message },
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
