<?php
session_start();
include_once 'logic/auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ghostly - Login</title>
  <?php include_once 'components/style.php'; ?>
</head>

<body>
  <?php include_once 'components/navbar.php'; ?>

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
              <div class="mb-2 row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                <div class="col-md-6">
                  <input type="text" id="username" class="form-control" name="username" required autofocus />
                </div>
              </div>

              <div class="mb-2 row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input type="password" id="password" class="form-control" name="password" required />
                </div>
              </div>

              <div class="mb-2 row">
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

  <?php include_once 'components/script.php'; ?>

</body>

</html>