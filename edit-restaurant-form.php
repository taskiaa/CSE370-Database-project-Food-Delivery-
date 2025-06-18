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
    <title>Add Restaurant Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <?php
    if (isset($_GET['id'])) {
        $restaurantId = $_GET['id'];

        $conn = getConnection();

        $sql_query = "SELECT * FROM restaurant WHERE id = $restaurantId";
        $result = mysqli_query($conn, $sql_query);

        if ($row = mysqli_fetch_assoc($result)) {
            $phnNum = $row['phn_num'];
            $name = $row['name'];
            $location = $row['location'];
        } else {
            die("Invalid food id.");
        }
        ?>

        <h1 class="display-4">Restaurant Info</h1>

        <div class="mt-4">
            <form action="./edit-restaurant.php" class="w-25" method="post">
                <input type="hidden" name="restaurantId" value="<?php echo $restaurantId ?>">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input class="form-control" name="name"
                           value="<?php echo $name ?>"
                           id="exampleFormControlInput1" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phnNum"
                           value="<?php echo $phnNum ?>"
                           id="exampleFormControlTextarea1" required>
                </div>
                <div class="mb-3">
                    <label for="exampleText2" class="form-label">Location</label>
                    <input type="text" maxlength="90" class="form-control"
                           value="<?php echo $location ?>"
                           name="location" id="exampleText2" required>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                </div>
            </form>

            <div>
                <a href="../admin/admin-restaurant-list.php" class="btn btn-outline-primary btn-sm mt-4">< Go Back</a>
            </div>
        </div>

        <?php
    } else {
        die("Invalid restaurant ID");
    }
    ?>
</div>
</body>
</html>