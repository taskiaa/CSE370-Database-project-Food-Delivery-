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
    <h3 class="mt-3 mb-2">Login</h3>

    <div class="mt-4">
        <form action="./admin-login.php" class="w-25" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Username</label>
                <input class="form-control" name="username" id="exampleFormControlInput1" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleFormControlTextarea1" required>
            </div>

            <div>
                <button type="submit" class="btn btn-primary mb-3">Login</button>
            </div>
            <div class="mt-3">
                <a href="../index.php" class="btn btn-outline-primary mb-3">< Home</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>