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
    <h1 class="display-4">Restaurant Info</h1>

    <div class="mt-4">
        <form action="./add-restaurant.php" class="w-25" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input class="form-control" name="name" id="exampleFormControlInput1" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phnNum" id="exampleFormControlTextarea1" required>
            </div>
            <div class="mb-3">
                <label for="exampleText2" class="form-label">Location</label>
                <input type="text" maxlength="90" class="form-control" name="location" id="exampleText2" required>
            </div>

            <div>
                <button type="submit" class="btn btn-primary mb-3">Add</button>
            </div>
        </form>

        <div>
            <a href="../admin/admin-restaurant-list.php" class="btn btn-outline-primary btn-sm mt-4">< Go Back</a>
        </div>
    </div>
</div>
</body>
</html>