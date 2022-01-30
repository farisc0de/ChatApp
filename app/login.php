<?php
session_start();

include_once 'config.php';
include_once 'src/Database.php';
include_once 'src/Users.php';
include_once 'src/Auth.php';
include_once 'src/Utils.php';
include_once 'src/Rooms.php';

$utils = new Utils();
$db = new Database($config);
$auth = new Auth($db);
$user = new Users($db);
$rooms = new Rooms($db);

/** Lock out time used for brute force protection */

$lockout_time = 10;
$room = $rooms->getRooms();

/** Check if user is already log in */

if (isset($_SESSION['loggedin'])) {
  $utils->redirect("index.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = $utils->sanitize($_POST['username']);
  $password = $utils->sanitize($_POST['password']);

  $loginstatus = $auth->newLogin($username, $password);

  if ($loginstatus == 200) {
    session_regenerate_id();

    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['room_id'] = ($_POST["room"] == "0") ? "1" : $_POST['room'];

    $user->setOnline($username, $_SESSION['room_id']);

    $utils->redirect("index.php");
  } elseif ($loginstatus == 401) {
    $error = "Username or Password is incorrect.";
  } elseif ($loginstatus == 403) {
    $error = "This account has been locked because of too many failed logins.
        \nIf this is the case, please try again in $lockout_time minutes.";
  } else {
    $error = "Unexpected error occurred !";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ghostly - Login</title>

  <!-- Bootstrap CSS -->
  <?php include_once 'style.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <nav class="navbar navbar-light bg-light navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">Ghostly</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container pt-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <?php if (isset($error)) : ?>
              <?php echo $utils->alert($error, "danger", "times-circle"); ?>
            <?php endif; ?>
            <form action="" method="POST">
              <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                <div class="col-md-6">
                  <input type="text" id="username" class="form-control" name="username" required autofocus />
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input type="password" id="password" class="form-control" name="password" required />
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Room</label>
                <div class="col-md-6">
                  <select class="form-control" name="room">
                    <option value="0">Select a Room</option>
                    <?php foreach ($room as $r) : ?>
                      <option value="<?php echo $r->id; ?>"><?php echo $r->room_name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</body>

</html>