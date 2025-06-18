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
        $description = $_POST['description'];
        $price = $_POST['price'];
        $type = $_POST['type'];
        $restaurantId = $_POST['restaurantId'];

        $target_dir = dirname(__FILE__, 2) . '/photos/';

        $image = $_FILES['picture']['name'];
        $imageArr = explode('.', $image); //first index is file name and second index file type
        $rand = rand(10000, 99999);
        $newImageName = $imageArr[0] . $rand . '.' . $imageArr[1];
        $uploadPath = $target_dir . $newImageName;
        $isUploaded = move_uploaded_file($_FILES["picture"]["tmp_name"], $uploadPath);
        $imgUrl = '/photos/' . $newImageName;

        $conn = getConnection();

        $sql_query = "INSERT INTO food (picture_url, name, description, type, price, restaurant_id)
                        VALUES ('$imgUrl', '$name', '$description', '$type', $price, $restaurantId);";
        $result = mysqli_query($conn, $sql_query);

        if ($result) {
            ?>
            <h4>Food Added.</h4>
            <a href="./list-foods.php?restaurantId=<?php echo $restaurantId ?>"
               class="btn btn-outline-primary btn-sm mt-4">< Go Back</a>
            <?php
        } else {
            die("Can't Add Food. Error " . $conn->error);
        }
    } else {
        die("Wrong request method.");
    }
    ?>
</div>
</body>
</html>