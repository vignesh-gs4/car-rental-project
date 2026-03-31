<?php
include("db_connect.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
        echo$message;
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($result) > 0) {
            $message = "<div class='alert alert-danger'>Error: Email already registered!</div>";
            echo$message;
        } else {
            
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $sql)) {
                $message = "<div class='alert alert-success'>Signup successful! <a href='login.php'>Login here</a></div>";
                echo$message;
            } else {
                $message = "<div class='alert alert-danger'>Error: Could not sign up!</div>";
                echo$message;
            }
        }
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
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include("header.php");?>
    
    <section class="card p-4 shadow-lg rounded w-25 mx-auto my-5">
        <h3 class="text-center mb-3">Sign Up</h3>
        <form action="signup.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-outline-primary w-100 rounded-0">Signup</button>
        </form>
        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Already registered?</a>
        </div>
    </section>

    <?php include("footer.php") ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>