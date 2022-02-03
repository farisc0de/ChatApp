<?php include_once 'logic/install.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghostly - Software Installer</title>
    <?php include_once 'components/style.php' ?>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Ghostly</a>
    </nav>

    <div class="container pt-3">

        <?php if (isset($error)) : ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check"></i> Ghostly has been installed, Enjoy
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                Installer
            </div>
            <div class="card-body">
                <h5 class="card-title">Welcome to Ghostly</h5>
                <p class="card-text">Use this page to install Ghostly database with default values.</p>
                <form method="POST">
                    <button class="btn btn-primary">Run Installer</button>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'components/script.php'; ?>
</body>

</html>