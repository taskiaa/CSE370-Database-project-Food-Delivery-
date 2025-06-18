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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phnNum = $_POST['phnNum'];
        $location = $_POST['location'];
        $restaurantId = $_POST['restaurantId'];

        $conn = getConnection();

        $sql_query = "UPDATE restaurant SET name = '$name', phn_num = '$phnNum', 
                location = '$location' WHERE id = $restaurantId";
        $result = mysqli_query($conn, $sql_query);

        if ($result) {
            ?>
            <h4>Restaurant Updated.</h4>
            <a href="../admin/admin-restaurant-list.php" class="btn btn-primary mt-4">< Go Back</a>
            <?php
        } else {
            die("Can't Update food. Error " . $conn->error);
        }
    } else {
        die("Wrong request method.");
    }
    ?>
</div>
</body>
</html>