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
    <title>Restaurant Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <?php
    if (isset($_GET['foodId'], $_GET['restaurantId'])) {
        $foodId = $_GET['foodId'];
        $restaurantId = $_GET['restaurantId'];

        $conn = getConnection();

        try {
            $sql_query = "DELETE FROM food WHERE id = $foodId";
            $result = mysqli_query($conn, $sql_query);

            if ($result) {
                ?>
                <h4>Food Deleted.</h4>
                <a href="./list-foods.php?restaurantId=<?php echo $restaurantId ?>"
                   class="btn btn-outline-primary btn-sm mt-4">< Go Back</a>
                <?php
            } else {
                die("Can't delete food. Error " . $conn->error);
            }
        } catch(Exception $e) {
            ?>
            <h4>Cannot delete foods already added to an Order.</h4>
            <a href="./list-foods.php?restaurantId=<?php echo $restaurantId ?>" class="btn btn-primary mt-4">< Go Back</a>
            <?php
        }
    }
    ?>
</div>
</body>
</html>