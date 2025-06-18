<?php
require_once '../connection_manager.php';
session_start();

if (!isset($_SESSION["username"], $_SESSION["type"]) || $_SESSION["type"] != 'delivery') {
    die("Incorrect session info");
}

$conn = getConnection();
$deliveryManId = $_SESSION["deliveryId"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Man Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Delivery Man Homepage</h1>

    <div class="mt-5">
        <h3>List of Current Orders</h3>
        <?php
        $current_order_query = "SELECT o.id id,
                        o.status status,
                        o.total_amount totAmount,
                        r.name restaurantName,
                        c.name customerName,
                        c.phn_num customerPhn,
                        c.location customerLocation,
                        (SELECT GROUP_CONCAT(CONCAT(f.name, ' (', fo.count, ')'))
                         FROM food_order fo
                                  JOIN food f on (f.id = fo.food_id)
                         WHERE fo.order_id = o.id) items
                    FROM orders o                        
                        JOIN customer c on o.customer_id = c.id
                        JOIN restaurant r on r.id = o.restaurant_id
                    LEFT JOIN delivery_man dm on (dm.id = o.delivery_man_id)
                    WHERE o.delivery_man_id = $deliveryManId AND status != 'Delivered';";

        $result = mysqli_query($conn, $current_order_query);
        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $orderId = $row['id'];
                    $totAmount = $row['totAmount'];
                    $restaurantName = $row['restaurantName'];
                    $customerName = $row['customerName'];
                    $customerPhn = $row['customerPhn'];
                    $customerLocation = $row['customerLocation'];
                    $items = $row['items'];
                    ?>
                    <div class="my-5">
                        <h5 class="d-inline mb-4"><?php echo $restaurantName ?></h5>
                        <div class="mt-3">
                            <span>Status: <?php echo $status ?></span><br>
                            <span>Items: <?php echo $items ?></span><br>
                            <span>Total Amount: <?php echo $totAmount ?></span>

                            <div class="mt-2">
                                <a href="./complete-delivery.php?orderId=<?php echo $orderId ?>"
                                   class="btn btn-success btn-sm">Mark Delivered</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No current orders found.</div>
            <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <h3>List of Available Orders</h3>
        <?php
        $available_order_query = "SELECT o.id id,
                        o.total_amount totAmount,
                        r.name restaurantName,
                        c.name customerName,
                        c.phn_num customerPhn,
                        c.location customerLocation,
                        (SELECT GROUP_CONCAT(CONCAT(f.name, ' (', fo.count, ')'))
                         FROM food_order fo
                                  JOIN food f on (f.id = fo.food_id)
                         WHERE fo.order_id = o.id) items
                    FROM orders o
                        JOIN customer c on o.customer_id = c.id
                        JOIN restaurant r on r.id = o.restaurant_id
                    WHERE o.delivery_man_id IS NULL;";

        $result_available_order = mysqli_query($conn, $available_order_query);
        if (mysqli_num_rows($result_available_order) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result_available_order)) {
                    $orderId = $row['id'];
                    $restaurantName = $row['restaurantName'];
                    $customerName = $row['customerName'];
                    $customerPhn = $row['customerPhn'];
                    $totAmount = $row['totAmount'];
                    $customerLocation = $row['customerLocation'];
                    $items = $row['items'];
                    ?>
                    <div class="my-3">
                        <h5 class="d-inline mb-4"><?php echo $restaurantName ?></h5>
                        <div class="mt-3">
                            <span>Items: <?php echo $items ?></span><br>
                            <span>Total Amount: <?php echo $totAmount ?></span>

                            <div class="mt-2">
                                <span>Customer Name: <?php echo $customerName?></span><br>
                                <span>Customer Phone: <?php echo $customerPhn?></span><br>
                                <span>Customer Location: <?php echo $customerLocation?></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="./book-delivery.php?orderId=<?php echo $orderId ?>&deliveryId=<?php echo $deliveryManId ?>"
                               class="btn btn-primary btn-sm">Deliver</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No available orders found.</div>
            <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <h3>List of Completed Orders</h3>
        <?php
        $current_order_query = "SELECT o.id id,
                        o.status status,
                        o.total_amount totAmount,
                        r.name restaurantName,
                        c.name customerName,
                        c.phn_num customerPhn,
                        c.location customerLocation,
                        (SELECT GROUP_CONCAT(CONCAT(f.name, ' (', fo.count, ')'))
                         FROM food_order fo
                                  JOIN food f on (f.id = fo.food_id)
                         WHERE fo.order_id = o.id) items
                    FROM orders o                        
                        JOIN customer c on o.customer_id = c.id
                        JOIN restaurant r on r.id = o.restaurant_id
                    LEFT JOIN delivery_man dm on (dm.id = o.delivery_man_id)
                    WHERE o.delivery_man_id = $deliveryManId AND status = 'Delivered';";

        $result = mysqli_query($conn, $current_order_query);
        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $orderId = $row['id'];
                    $totAmount = $row['totAmount'];
                    $restaurantName = $row['restaurantName'];
                    $customerName = $row['customerName'];
                    $customerPhn = $row['customerPhn'];
                    $customerLocation = $row['customerLocation'];
                    $items = $row['items'];
                    ?>
                    <div class="my-5">
                        <h5 class="d-inline mb-4"><?php echo $restaurantName ?></h5>
                        <div class="mt-3">
                            <span class="text-primary fw-semibold">Status: <?php echo $status ?></span><br>
                            <span>Items: <?php echo $items ?></span><br>
                            <span>Total Amount: <?php echo $totAmount ?></span>
                            <div class="mt-2">
                                <span>Customer Name: <?php echo $customerName?></span><br>
                                <span>Customer Phone: <?php echo $customerPhn?></span><br>
                                <span>Customer Location: <?php echo $customerLocation?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No current orders found.</div>
            <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <a href="./delivery-logout.php" class="btn btn-outline-danger btn-sm ml-5">Log Out</a>
    </div>
</div>

</body>
</html>