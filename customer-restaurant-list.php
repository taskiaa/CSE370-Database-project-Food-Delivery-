<?php
require_once '../connection_manager.php';
session_start();

if (!isset($_SESSION["username"], $_SESSION["type"]) || $_SESSION["type"] != 'customer') {
    die("Incorrect session info");
}

$conn = getConnection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Customer Homepage</h1>
    <div class="mt-5">
        <h3>List of restaurants</h3>

        <?php
        $customerId = $_SESSION["customerId"];
        $restaurant_query = "SELECT * FROM restaurant";
        $result = mysqli_query($conn, $restaurant_query);

        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $restaurant_name = $row['name'];
                    $restaurantId = $row['id'];
                    $phn_num = $row['phn_num'];
                    $location = $row['location'];
                    ?>
                    <div class="my-5">
                        <h5 class="mb-2"><?php echo $restaurant_name ?></h5>
                        <span>Phone: <?php echo $phn_num ?></span><br>
                        <span>Location: <?php echo $location ?></span><br>
                        <div class="mt-2">
                            <a href="./customer-list-foods.php?restaurantId=<?php echo $restaurantId ?>"
                               class="btn btn-primary btn-sm ml-5">See Foods</a>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No restaurant found.</div>
            <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <h3>List of Orders</h3>
        <?php
        $order_query = "SELECT o.status status,
                        o.total_amount totAmount,
                        r.name restaurantName,
                        o.delivery_man_id deliveryManId,
                        dm.name delName,
                        dm.phn_num delPhnNum,
                        (SELECT GROUP_CONCAT(CONCAT(f.name, ' (', fo.count, ')'))
                         FROM food_order fo
                                  JOIN food f on (f.id = fo.food_id)
                         WHERE fo.order_id = o.id) items
                    FROM orders o
                        JOIN restaurant r on r.id = o.restaurant_id
                    LEFT JOIN delivery_man dm on (dm.id = o.delivery_man_id)
                    WHERE o.customer_id = $customerId 
                    ORDER BY status DESC;";

        $result = mysqli_query($conn, $order_query);
        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $totAmount = $row['totAmount'];
                    $restaurantName = $row['restaurantName'];
                    $deliveryManId = $row['deliveryManId'];
                    $delName = $row['delName'];
                    $delPhnNum = $row['delPhnNum'];
                    $items = $row['items'];
                    $colorClass = '';

                    if ($status == 'Processing') {
                        $colorClass = 'text-info';
                    } else if ($status == 'Picked Up') {
                        $colorClass = 'text-success';
                    } else {
                        $colorClass = 'text-primary';
                    }

                    ?>
                    <div class="mb-5">
                        <h5 class="d-inline mb-4"><?php echo $restaurantName ?></h5>
                        <div class="mt-2">
                            <span class="<?php echo $colorClass ?> fw-semibold">Status: <?php echo $status ?></span><br>
                            <span>Items: <?php echo $items ?></span><br>
                            <span>Total Amount: <?php echo $totAmount ?></span>

                            <?php
                            if ($deliveryManId != null) {
                                ?>
                                <div class="mt-2">
                                    <span>Delivery Man's Name: <?php echo $delName ?></span><br>
                                    <span>Delivery Man's Phone: <?php echo $delPhnNum ?></span><br>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No orders found.</div>
            <?php
        }
        ?>
    </div>

    <div class="mt-5">
        <a href="./customer-logout.php" class="btn btn-outline-danger btn-sm ml-5">Log Out</a>
    </div>
</div>

</body>
</html>