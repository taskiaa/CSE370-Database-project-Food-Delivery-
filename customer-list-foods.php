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
    <title>List of Foods</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" ></script>
    <script src="cart.js"></script>
</head>
<body>
<div class="container my-5">
    <div class="mt-4">
        <?php
        if (isset($_GET['restaurantId'])) {
        ?>
        <script>var restaurantId = <?php echo $_GET['restaurantId'] ?></script>
        <h1 class="display-4">Restaurants Management</h1>
        <h3>List of Food</h3>
        <?php
        $restaurantId = $_GET['restaurantId'];

        $conn = getConnection();

        $sql_query = "SELECT * FROM food WHERE restaurant_id = $restaurantId";
        $result = mysqli_query($conn, $sql_query);

        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="mt-2">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $food_id = $row['id'];
                    $food_name = $row['name'];
                    $description = $row['description'];
                    $type = $row['type'];
                    $price = $row['price'];
                    $food_picture_url = $row['picture_url'];
                    ?>
                    <div class="my-5">
                        <div class="mb-3">
                            <img src="<?php echo $food_picture_url ?>" alt="food_picture" width="200px">
                        </div>
                        <h5 class="d-inline"><?php echo $food_name ?></h5>
                        <p>Description: <?php echo $description ?></p>
                        <span>Price: <?php echo $price ?> Taka</span><br>
                        <span>Type: <?php echo $type ?></span>
                        <div class="mt-2">
                            <button class="add-to-cart btn btn-primary btn-sm"
                                    data-name="<?php echo $food_name ?>"
                                    data-price="<?php echo $price ?>"
                                    data-id="<?php echo $food_id ?>">
                                Add to Cart
                            </button>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>

            <?php
        } else {
            ?>
            <div>No foods found for this restaurant.</div>
            <?php
        }
        ?>
    </div>
    <?php
    } else {
        die("Invalid restaurant ID");
    }
    ?>

    <div class="mt-3">
        <a href="./customer-restaurant-list.php" class="btn btn-outline-primary btn-sm">< Go Back</a>
    </div>

    <nav class="navbar bg-faded">
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-primary open-cart" data-toggle="modal"
                        data-target="#cart">Cart (<span class="total-count"></span>)</button>
                <button class="clear-cart btn btn-danger">Clear Cart</button></div>
        </div>
    </nav>
</div>

<!--<form action="./order-food.php" method="post" enctype=""></form>-->

<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="show-cart table">

                </table>

                <div class="mb-2" id="no-item-msg">No item in cart.</div>

                <div>Total price: <span class="total-cart"></span> Taka</div>

                <div class="mt-2 text-danger fw-semibold" id="errorMsg">An error occurred. Can't place order.</div>
                <div class="mt-2 text-success fw-semibold" id="successMsg">Successfully placed order.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="order-btn">Order now</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>