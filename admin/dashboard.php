<?php
session_start();
include("../db_connect.php");

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}

// Fetch Total Bookings
$sql_booking = "SELECT COUNT(*) AS total_bookings FROM bookings";
$result_booking = mysqli_query($conn, $sql_booking);
$booking_data = mysqli_fetch_assoc($result_booking);
$total_bookings = $booking_data['total_bookings'];

// Fetch Total Cars
$sql_cars = "SELECT COUNT(*) AS total_cars FROM cars";
$result_cars = mysqli_query($conn, $sql_cars);
$car_data = mysqli_fetch_assoc($result_cars);
$total_cars = $car_data['total_cars'];

// Fetch Total Customers (Users)
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = mysqli_query($conn, $sql_users);
$user_data = mysqli_fetch_assoc($result_users);
$total_users = $user_data['total_users'];

// Fetch Total Brands
$sql_brands = "SELECT COUNT(DISTINCT brand) AS total_brands FROM cars";
$result_brands = mysqli_query($conn, $sql_brands);
$brand_data = mysqli_fetch_assoc($result_brands);
$total_brands = $brand_data['total_brands'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s ease-in-out;
        }

        .sidebar a {
            padding: 15px;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
            padding-left: 20px;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .card {
            border: none;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            text-align: center;
            padding: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .card p {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
        <a href="dashboard.php">Dashboard</a>
        <a href="booking_history.php">Booking History</a>
        <a href="view_cars.php">View Cars</a>
        <a href="add_car.php">Add Car</a>
        <a href="users.php">Users</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="content">
        <h5 class="dashboard-title">Dashboard / Overview</h5>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white rounded-3">
                    <div class="card-body">
                        <i class="bi bi-calendar-check card-icon"></i>
                        <h5>Total Bookings</h5>
                        <p><?php echo $total_bookings; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white rounded-3">
                    <div class="card-body">
                        <i class="bi bi-car-front card-icon"></i>
                        <h5>Total Cars</h5>
                        <p><?php echo $total_cars; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white rounded-3">
                    <div class="card-body">
                        <i class="bi bi-people card-icon"></i>
                        <h5>Customers</h5>
                        <p><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white rounded-3">
                    <div class="card-body">
                        <i class="bi bi-tags card-icon"></i>
                        <h5>Total Brands</h5>
                        <p><?php echo $total_brands; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
