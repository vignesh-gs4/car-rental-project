<?php
session_start();
include("../db_connect.php");
$message = ""; // Message placeholder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Check if email exists
    $sql = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    


    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo $user["password"];
        echo $user["email"];
        // Verify password
        if ($password == 1234) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["email"];
            // Redirect to dashboard (using absolute path)
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Invalid password!</div>";
            echo $message;
        }
    } else {
        $message = "<div class='alert alert-danger'>Email Not found</div>";
        echo $message;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<section class="card p-4 shadow-lg rounded container w-25 mx-auto my-5">
    <h3 class="text-center mb-3">Admin Login</h3>
    <form action="adminlogin.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100 rounded-0">Login</button>
    </form>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>