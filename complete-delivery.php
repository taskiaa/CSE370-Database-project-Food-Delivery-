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
    <title>Delivery Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <?php
    if (!isset($_GET['orderId'])) {
        die("Wrong request method.");
    }

    $orderId = $_GET['orderId'];

    $conn = getConnection();

    $sql_query = "UPDATE orders SET status = 'Delivered' WHERE id = $orderId";
    $result = mysqli_query($conn, $sql_query);

    if ($result) {
        ?>
        <h4>Order successfully delivered.</h4>
        <a href="./delivery-order-list.php" class="btn btn-primary mt-4">< Go back</a>
        <?php
    } else {
        die("Can't book order for delivery. Error " . $conn->error);
    }

    ?>
</div>
</body>
</html>