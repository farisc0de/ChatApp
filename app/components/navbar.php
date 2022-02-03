  <nav class="navbar navbar-light bg-light navbar-expand-lg">
      <div class="container">
          <a class="navbar-brand" href="index.php">Ghostly</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                  <?php if (!isset($_SESSION['loggedin'])) : ?>
                      <li class="nav-item">
                          <a class="nav-link" href="register.php">Register</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="login.php">Login</a>
                      </li>
                  <?php endif; ?>

                  <?php if (isset($_SESSION['loggedin'])) : ?>
                      <?php if ($_SESSION['is_admin']) : ?>
                          <li class="nav-item">
                              <a class="nav-link" href="rooms.php">Manage Rooms</a>
                          </li>
                      <?php endif; ?>
                      <li class="nav-item">
                          <a class="nav-link" href="logout.php">Logout</a>
                      </li>
                  <?php endif; ?>
              </ul>
          </div>
      </div>
  </nav>