<?php
session_start();
include("db_connect.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Car not found.");
}
$id = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id = $id";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $car = mysqli_fetch_assoc($result);
} else {
    die("car not found");
}

$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$booking_status = "No Booking";

$isLoggedIn = isset($_SESSION["user_id"]);

$status = "Not Verified";

if ($isLoggedIn) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT status FROM profile_verification WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row["status"];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        img {
            width: 600px;
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <?php include("header.php");?>
    
    <section class="container my-4 mx-auto">
        <div class="row justify-content-center">
            <div class="col">
                <img src="<?php echo "car_images/" . $car["car_image"] ?>" class="shadow-none p-3 mb-5">
            </div>
            <div class="col bg-light p-3 align-self-start mt-3">
                <h3 class="text-center">Book Car</h3>
                <div class="row">
                    <div class="row">
                        <div class="col">
                            <p class="text-center"><strong>Price Per hour</strong></p>
                        </div>
                        <div class="col"><?php echo$car["price_per_hour"];?></div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-center"><strong>Convenience Fee:</strong></p>
                        </div>
                        <div class="col">Rs.50</div>
                        <hr>
                    </div>  
                    <div class="row">
                        <button class="btn btn-primary rounded-0 text-center" onclick="checkLogin()">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php") ?>

    <script>
    function checkLogin() {
        console.log("Checking user login and verification status...");

        // PHP variables converted to JavaScript
        var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
        var userStatus = <?php echo json_encode($status); ?>;
        var carId = <?php echo isset($id) ? json_encode($id) : "null"; ?>;
        console.log(userStatus);

        if (!isLoggedIn) {
            console.log("User not logged in. Redirecting to login page...");
            window.location.href = "login.php";
            return;
        }

        if (userStatus !== "Approved") {
           window.location.href = "profile-not-verify.php";
        } else if(userStatus === "Rejected") {
            window.location.href = "profile-not-verify.php";

        }else {
            window.location.href = "book_car_action.php?id=" + carId;
        }
    }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>