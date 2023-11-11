<?php
session_start();

if (isset($_COOKIE['login']) && isset($_COOKIE['key'])) {
    if ($_COOKIE['login'] == 'true') {
        $_SESSION['login'] = true;
        $_SESSION['email'] = $_COOKIE['key'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://cdn1.iconfinder.com/data/icons/basic-ui-169/32/Login-256.png"
        type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card login-content shadow-lg border-0">
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
                            <?= $_SESSION['error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php }
                        session_destroy(); ?>
                        <div class="text-center">
                            <img class="logo"
                                src="https://cdn1.iconfinder.com/data/icons/space-travel-flat/340/space_astronomy_system_planet_universe_galaxy_star_pluto-512.png">
                        </div>
                        <h3 class="text-logo">Masuk</h3>
                        <br>
                        <form class="text-center" action="proses.php" method="post">
                            <input class="form-control border-0" type="email" name="email"
                                placeholder="Masukkan Email Anda">
                            <br>
                            <input class="form-control border-0" type="password" name="passwd"
                                placeholder="Masukkan Password Anda">
                            <br>
                            <div class="remember-me">
                                <input type="checkbox" name="remember_me" value="1">
                                <label for="remember_me">Ingat Saya</label>
                            </div>
                            <br>
                            <button class="btn btn-primary btn-sm border-0" type="submit" name="submit">Masuk</button>
                        </form>
                    </div>
                    <div class="footer">
                        <p class="text-center">© 2023 Hand-crafted by D112121057</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
    <!-- Bootstrap 5 Alpha JavaScript Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>