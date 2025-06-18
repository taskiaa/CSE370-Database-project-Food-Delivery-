<?php
require_once '../connection_manager.php';
session_start();

if (!isset($_SESSION["username"], $_SESSION["type"]) || $_SESSION["type"] != 'customer') {
    die("Incorrect session info");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Customer Homepage</h1>
    <?php
    session_destroy();
    ?>

    <h4 class="mt-4"> Log Out Success.</h4>
    <div class="mt-4">
        <a href="./customer-login-form.php" class="btn btn-primary mb-3">Login</a>
    </div>
    <div class="mt-3">
        <a href="../index.php" class="btn btn-outline-primary mb-3">< Home</a>
    </div>
</div>

</body>
</html>