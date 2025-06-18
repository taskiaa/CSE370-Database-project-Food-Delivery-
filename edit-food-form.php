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
    <title>Add Food Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <?php
    if (isset($_GET['restaurantId'], $_GET['foodId'])) {
        $foodId = $_GET['foodId'];
        $restaurantId = $_GET['restaurantId'];

        $conn = getConnection();

        $sql_query = "SELECT * FROM food WHERE id = $foodId";
        $result = mysqli_query($conn, $sql_query);

        if ($row = mysqli_fetch_assoc($result)) {
            $food_name = $row['name'];
            $description = $row['description'];
            $type = $row['type'];
            $price = $row['price'];
            $food_picture_url = $row['picture_url'];
        } else {
            die("Invalid food id.");
        }

        ?>
        <h1 class="display-4">Food Info</h1>

        <div class="mt-4">
            <form action="./edit-food.php" class="w-50" method="post">
                <input type="hidden" name="foodId" value="<?php echo $foodId ?>">
                <input type="hidden" name="restaurantId" value="<?php echo $restaurantId ?>">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input class="form-control" name="name" id="exampleFormControlInput1"
                           value="<?php echo $food_name ?>" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea maxlength="500" class="form-control"
                              name="description" id="exampleFormControlTextarea1"
                              required><?php echo $description ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleText2" class="form-label">Price</label>
                    <input type="text" maxlength="5" class="form-control"
                           name="price"
                           value="<?php echo $price ?>"
                           id="exampleText2" required>
                </div>

                <div class="form-group mb-5">
                    <label for="exampleFormControlSelect1" class="form-label">Select a type</label>
                    <select class="form-control"
                            id="exampleFormControlSelect1"
                            name="type" required>
                        <option <?php if ($type == 'Bengali') echo "selected" ?>>Bengali</option>
                        <option <?php if ($type == 'Japanese') echo "selected" ?>>Japanese</option>
                        <option <?php if ($type == 'Chinese') echo "selected" ?>>Chinese</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                </div>
            </form>

            <div>
                <a href="./list-foods.php?restaurantId=<?php echo $restaurantId ?>"
                   class="btn btn-outline-primary btn-sm mt-4">< Go Back</a>
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