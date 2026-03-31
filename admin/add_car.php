<?php
session_start();
include("../db_connect.php");

$message = "";
$alert_class = ""; // Bootstrap alert class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST["car_name"];
    $brand = $_POST["brand"];
    $fuel_type = $_POST["fuel_type"];
    $seating_capacity = $_POST["seating_capacity"];
    $price_per_hour = $_POST["price_per_hour"];

    $target_dir = "../car_images/";
    $image = $_FILES["car_image"]["name"];
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
        // Insert car details into the database
        $sql = "INSERT INTO cars (car_name, brand, fuel_type, seating_capacity, price_per_hour, car_image) 
                VALUES ('$car_name', '$brand', '$fuel_type', '$seating_capacity', '$price_per_hour', '$image')";

        if (mysqli_query($conn, $sql)) {
            $message = "Car added successfully!";
            $alert_class = "alert-success"; // Green success alert
        } else {
            $message = "Error: " . mysqli_error($conn);
            $alert_class = "alert-danger"; // Red error alert
        }
    } else {
        $message = "Failed to upload image.";
        $alert_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-white text-center">Admin Dashboard</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="booking_history.php">Booking History</a>
        <a href="view_cars.php">View Cars</a>
        <a href="add_car.php">Add Car</a>
        <a href="users.php">Users</a>
        <a href="../logout.php">Logout</a>
    </div>

    <section class="content">
        <div class="container mt-4 w-50 mx-auto">
            <h2 class="text-center">Add Car</h2>

            <!-- ✅ Bootstrap Alert Message -->
            <?php if (!empty($message)) { ?>
                <div class="alert <?= $alert_class ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <form action="cars.php" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-white">
                <div class="mb-3">
                    <label for="car_name" class="form-label">Car Name</label>
                    <input type="text" class="form-control border border-secondary" id="car_name" name="car_name" required>
                </div>
                <div class="mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" class="form-control border border-secondary" name="brand" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fuel_type">Fuel Type</label>
                    <select class="form-control border border-secondary" name="fuel_type" id="fuel_type">
                        <option value="Petrol">Petrol</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Electric">Electric</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="seating_capacity">Seating Capacity</label>
                    <input type="number" class="form-control border border-secondary" name="seating_capacity" id="seating_capacity" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="price_per_hour">Price Per Hour (Rs)</label>
                    <input type="number" class="form-control border border-secondary" name="price_per_hour" id="price_per_hour" required>
                </div>
                <div class="mb-3">
                    <label for="car_image" class="form-label">Car Image</label>
                    <input type="file" class="form-control border border-secondary" name="car_image" accept="image/*" id="car_image" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Car</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
