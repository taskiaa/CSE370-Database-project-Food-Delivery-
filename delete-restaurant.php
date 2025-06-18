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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn = getConnection();

        try {
            $sql_query = "DELETE FROM restaurant WHERE id = $id";
            $result = mysqli_query($conn, $sql_query);

            if ($result) {
                ?>
                <h2>Restaurant Deleted.</h2>
                <a href="../admin/admin-restaurant-list.php" class="btn btn-primary mt-4">< Go Back</a>
                <?php
            } else {
                die("Can't delete restaurant. Error " . $conn->error);
            }
        } catch(Exception $e) {
            ?>
            <h4>Cannot delete Restaurant already having an Order or Food.</h4>
            <a href="../admin/admin-restaurant-list.php" class="btn btn-primary mt-4">< Go Back</a>
            <?php
        }

    }
    ?>
</div>
</body>
</html>