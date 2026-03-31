<?php 
session_start();
include("db_connect.php");

$success_message = $error_message = "";
$booking_details = [];

if (!isset($_SESSION['user_id'])) {
    $error_message = "You must be logged in to view your bookings.";
} else {
    $user_id = $_SESSION['user_id'];

    // Fetch all bookings for the logged-in user
    $sql = "SELECT bookings.id AS booking_id, bookings.*, cars.car_name, cars.car_image 
            FROM bookings 
            JOIN cars ON bookings.car_id = cars.id 
            WHERE bookings.user_id = ? 
            ORDER BY bookings.id DESC"; 

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $booking_details[] = $row; // Store all bookings in an array
        }
    } else {
        $error_message = "No bookings found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 750px;
            margin-top: 50px;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .alert {
            text-align: center;
        }
        .car-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        .booking-info {
            font-size: 18px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="text-center mb-4">
            <h3 class="text-primary">Booking Confirmation</h3>
        </div>

        <?php if (!empty($error_message)): ?>
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
                        <p><strong>Status:</strong> <span class="badge bg-<?= $booking['status'] === 'Cancelled' ? 'danger' : 'success' ?>"><?= htmlspecialchars($booking['status']); ?></span></p>
                    </div>

                    <?php if ($booking['status'] !== 'Cancelled'): ?>
                        <form action="cancel_booking.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']); ?>">
                            <button type="submit" class="btn btn-danger w-100">Cancel Booking</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100" disabled>Booking Cancelled</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="explore_car.php" class="btn btn-secondary mt-3">Back to Cars</a>
    </div>

</body>
</html>
  