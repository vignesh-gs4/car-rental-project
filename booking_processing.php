<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

if (!isset($_GET['id'])) {
    die("Invalid request. Car ID missing.");
}

$car_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup_date = $_POST['pickup_date'];
    $pickup_hour = $_POST['pickup_hour'];
    $drop_date = $_POST['drop_date'];
    $drop_hour = $_POST['drop_hour'];
    $total_fare = $_POST["total_fare"];

    if (!$pickup_date || !$pickup_hour || !$drop_date || !$drop_hour) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    $pickup_datetime = strtotime("$pickup_date $pickup_hour:00");
    $drop_datetime = strtotime("$drop_date $drop_hour:00");

    if ($drop_datetime <= $pickup_datetime) {
        echo "<script>alert('Drop time must be after pickup time.'); window.history.back();</script>";
        exit();
    }

    $sql = "SELECT price_per_hour FROM cars WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $car_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $car = mysqli_fetch_assoc($result);

    if (!$car) {
        echo "<script>alert('Car not found.'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO bookings (user_id, car_id, pickup_date, pickup_hour, drop_date, drop_hour, total_fare, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Confirmed')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iissssd", $user_id, $car_id, $pickup_date, $pickup_hour, $drop_date, $drop_hour, $total_fare);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Booking Confirmed!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Booking Failed: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }

    mysqli_stmt_close($stmt);
}
?>
