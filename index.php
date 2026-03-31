<?php
 include("db_connect.php");
session_start();
$sql = "SELECT * FROM cars LIMIT 3";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <style>
        .banner {
            width: 100%;
            display: flex;
            background-color: rgb(41, 32, 170)
        }
    </style>
</head>
<style>
    .ul-details {
        list-style-type: none;
    }
</style>

<body>
   <?php include("header.php");?>

    <section class="container-fluid text-white bg-primary d-flex align-items-center justify-content-center text-center py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4">Car Rental Service</h2>
                <a href="explore_car.php" class="btn btn-light btn-lg">Book Now</a>
            </div>
            <div class="col-md-6">
                <img src="car_images/banner_img.webp" alt="Car Rental" class="img-fluid rounded shadow-lg" style="max-width: 100%; height: auto; max-height: 400px;">
            </div>
        </div>
    </section>
    <section class="container bg-light my-4">
        <div class="row justify-content-center">
            <div class="col p-5">
                Car-Rental in india's leading mobility Company with services ranging
                from chauffeur drive and self-drive car rentals
                <ul class="fw-bold ul-details pt-5">
                    <li>Choose Car</li>
                    <li>Rental Date</li>
                    <li>Book Your car</li>
                </ul>
            </div>
            <div class="col">
                <img src="car_images/index_img.avif" alt="" style="height: 400px">
            </div>
    </section>
    <section class="container">
        <h2 class="text-center my-4 text-dark">Available Cars</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($car = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo "car_images/" . $car["car_image"] ?>" alt="car_image" class="card-img-top" style="object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $car["car_name"] ?></h5>
                                <p class="card-text"><strong>Fuel type:</strong><?php echo $car['fuel_type']; ?></p>
                                <p class="card-text"><strong>Seats: <?php echo $car['seating_capacity']; ?></strong></p>
                                <p class="card-text"><strong>Price:</strong> ₹<?php echo $car['price_per_hour']; ?> per hour</p>
                                <a href="book_car.php?id=<?php echo $car['id']; ?>" class="btn btn-primary rounded-0">Book Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>No Cars Available</p>";
            }
            ?>
        </div>
    </section>
   <?php include("footer.php") ?>
    <div class="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Logout when clicking the user icon
            document.getElementById("logoutIcon")?.addEventListener("click", function() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href = "logout.php";
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>