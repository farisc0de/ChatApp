var to = $("#to_user").val();

$("#message").emoji({
  place: "after",
});

LoadMessages();

function LoadMessages() {
  $.get(
    "api/handler.php",
    { action: "getPrivateMessages", to: to },
    function (response) {
      var scrollpos = parseInt($("#chat_private").scrollTop()) + 520;
      var scrollHeight = $("#chat_private").prop("scrollHeight");

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

      $("#chat_private").html(messages);

      if (!(scrollpos < scrollHeight)) {
        $("#chat_private").scrollTop($("#chat_private").prop("scrollHeight"));
      }
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
  var to = $("#to_user").val();

  $.post(
    "api/handler.php",
    { action: "sendPrivateMessage", message: message, to: to },
    function (response) {
      if (JSON.parse(response)["response"] == true) {
        LoadMessages();
        document.getElementById("Messagebox").reset();
      }
    }
  );

  return false;
});

$("#dispose").click(function () {
  $.get(
    "api/handler.php",
    {
      action: "dispose",
      to: to,
    },
    function (response) {
      console.log(response);
    }
  );
});

setInterval(function () {
  LoadMessages();
}, 1000);
