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
    <title>Delivery Man Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"
            integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Delivery Man Homepage</h1>
    <?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = getConnection();

    $sql_query = "SELECT * FROM delivery_man WHERE username='$username' and password='$password'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $name = $row['name'];
        $id= $row['id'];

        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["deliveryId"] = $id;
        $_SESSION["type"] = "delivery";
        ?>
        <h4 class="mt-4"> Login Success. Welcome back <?php echo $name ?>.</h4>
        <div class="mt-4">
            <a href="./delivery-order-list.php" class="btn btn-primary mb-3">See Orders</a>
        </div>
        <?php
    } else {
        ?>
        Invalid Login.
        <div class="mt-4">
            <a href="./delivery-login-form.php" class="btn btn-primary mb-3">Login</a>
        </div>
        <?php
    }
    ?>
</div>

</body>
</html>