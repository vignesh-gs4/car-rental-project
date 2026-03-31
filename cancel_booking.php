<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id'];
$success_message = $error_message = "";

// Fetch only active bookings (not cancelled)
$sql = "SELECT bookings.id AS booking_id, bookings.*, cars.car_name, cars.car_image 
        FROM bookings 
        JOIN cars ON bookings.car_id = cars.id 
        WHERE bookings.user_id = ? AND bookings.status != 'Cancelled' 
        ORDER BY bookings.id DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$booking_details = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $booking_details[] = $row;
    }
} else {
    $error_message = "No active bookings found.";
}

// Handle cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Check if the booking exists and belongs to the user
    $sql_check = "SELECT * FROM bookings WHERE id = ? AND user_id = ? AND status != 'Cancelled'";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $booking_id, $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Update the status to 'Cancelled'
        $sql_update = "UPDATE bookings SET status = 'Cancelled' WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "i", $booking_id);

        if (mysqli_stmt_execute($stmt_update)) {
            $success_message = "Booking cancelled successfully!";
            // Refresh the page to reflect changes
            header("Location: cancel_booking.php");
            exit();
        } else {
            $error_message = "Cancellation failed. Try again later.";
        }
    } else {
        $error_message = "Invalid booking or already cancelled.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 750px; margin-top: 50px; }
        .card { padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        .alert { text-align: center; }
        .car-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; }
        .booking-info { font-size: 18px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="text-center mb-4">
            <h3 class="text-danger">Cancel Booking</h3>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php if (!empty($booking_details)): ?>
            <?php foreach ($booking_details as $booking): ?>
                <div class="card">
                    <h5 class="text-center text-muted">Booking ID: <strong>#<?= htmlspecialchars($booking['booking_id']); ?></strong></h5>

                    <div class="text-center">
                        <img src="car_images/<?= htmlspecialchars($booking['car_image']); ?>" alt="Car Image" class="car-image">
                        <h4 class="mt-3"><?= htmlspecialchars($booking['car_name']); ?></h4>
                    </div>

                    <hr>

                    <div class="booking-info">
                        <p><strong>Pickup Date & Time:</strong> <?= htmlspecialchars($booking['pickup_date']); ?> at <?= htmlspecialchars($booking['pickup_hour']); ?></p>
                        <p><strong>Drop Date & Time:</strong> <?= htmlspecialchars($booking['drop_date']); ?> at <?= htmlspecialchars($booking['drop_hour']); ?></p>
                        <p><strong>Total Fare:</strong> ₹<?= htmlspecialchars($booking['total_fare']); ?></p>
                    </div>

                    <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']); ?>">
                        <button type="submit" class="btn btn-danger w-100">Cancel Booking</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center">No active bookings found.</div>
        <?php endif; ?>

        <a href="booking_confirmation.php" class="btn btn-secondary mt-3">Back to Bookings</a>
    </div>

</body>
</html>
