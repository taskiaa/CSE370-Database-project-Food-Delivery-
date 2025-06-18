<?php
require_once '../connection_manager.php';
session_start();

if (!isset($_SESSION["username"], $_SESSION["type"]) || $_SESSION["type"] != 'admin') {
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <div class="mt-4">
        <?php
        if (isset($_GET['restaurantId'])) {
        ?>
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
                        <span>Type: <?php echo $type ?></span><br>

                        <div class="mt-2">
                            <a href="./edit-food-form.php?restaurantId=<?php echo $restaurantId ?>&foodId=<?php echo $food_id ?>"
                               class="btn btn-outline-primary btn-sm mt-1">Edit</a>
                            <a href="./delete-food.php?restaurantId=<?php echo $restaurantId ?>&foodId=<?php echo $food_id ?>"
                               class="btn btn-outline-danger btn-sm mt-1">Delete</a>
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
        <a href="./add-food-form.php?restaurantId=<?php echo $restaurantId ?>"
           class="btn btn-primary btn-sm ml-5">Add Food</a>
        <a href="../admin/admin-restaurant-list.php" class="btn btn-outline-primary btn-sm">< Go Back</a>
    </div>
</div>
</body>
</html>