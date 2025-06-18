<?php
require_once '../connection_manager.php';
$conn = getConnection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Man Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phn = $_POST['phnNum'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = getConnection();

        $sql_query = "INSERT INTO delivery_man(phn_num, name, username, password) 
                        VALUES ('$phn', '$name', '$username', '$password');";
        $result = mysqli_query($conn, $sql_query);

        if ($result) {
            ?>
            <h2>Delivery Man successfully registered.</h2>
            <a href="./delivery-login-form.php" class="btn btn-primary mt-4">Login</a>
            <?php
        } else {
            die("Can't Add Delivery Man. Error " . $conn->error);
        }
    } else {
        die("Wrong request method.");
    }
    ?>
</div>
</body>
</html>