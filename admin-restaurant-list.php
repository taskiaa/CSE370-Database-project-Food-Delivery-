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
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="display-4">Admin Homepage</h1>
    <?php
    $conn = getConnection();

    $sql_query = "SELECT * FROM restaurant";
    $result = mysqli_query($conn, $sql_query);
    ?>
    <div class="mt-4">
        <h3>List of restaurants</h3>

        <?php
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
                        <h5 class="d-inline mb-4"><?php echo $restaurant_name ?></h5>
                        <p>Phone: <?php echo $phn_num ?></p>
                        <p>Location: <?php echo $location ?></p>
                        <a href="../food/list-foods.php?restaurantId=<?php echo $restaurantId ?>"
                           class="btn btn-primary btn-sm ml-5">See Foods</a>
                        <a href="../restaurant/edit-restaurant-form.php?id=<?php echo $restaurantId ?>"
                           class="btn btn-outline-primary btn-sm ml-5">Edit</a>
                        <a href="../restaurant/delete-restaurant.php?id=<?php echo $restaurantId ?>"
                           class="btn btn-danger btn-sm ml-5">Delete</a>
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

    <div class="mt-3">
        <a href="../restaurant/add-restaurant-form.php" class="btn btn-outline-primary btn-sm ml-5">Add Restaurant</a>
        <a href="./admin-logout.php" class="btn btn-outline-danger btn-sm ml-5">Log Out</a>
    </div>
</div>
</body>
</html>