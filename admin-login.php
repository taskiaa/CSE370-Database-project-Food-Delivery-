<?php
require_once '../connection_manager.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Admin Homepage</h1>
    <?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = getConnection();

    $sql_query = "SELECT * FROM admin WHERE username='$username' and password='$password'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["type"] = "admin";
        ?>
        <h4 class="mt-4"> Login Success.</h4>
        <div class="mt-4">
            <a href="./admin-restaurant-list.php" class="btn btn-primary mb-3">Manage Restaurants</a>
        </div>
        <?php
    } else {
        ?>
        Invalid Login.
        <div class="mt-4">
            <a href="./admin-login-form.php" class="btn btn-primary mb-3">Login</a>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>