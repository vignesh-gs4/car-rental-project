<?php
session_start();
include("db_connect.php"); // Include database connection

if (!isset($_GET['id'])) {
    die("Invalid request. Car ID missing.");
}

$car_id = $_GET['id'];

$sql = "SELECT * FROM cars WHERE id = $car_id";
$result = mysqli_query($conn, $sql);
$car = mysqli_fetch_assoc($result);

if (!$car) {
    die("Car not found.");
}

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car - <?= htmlspecialchars($car['car_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .car-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }

        .btn-primary {
            width: 100%;
            font-weight: bold;
            padding: 10px;
        }

        .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3 class="text-center text-primary"><i class="bi bi-car-front"></i> Confirm Your Booking</h3>

        <!-- Car Image -->
        <img src="<?php echo "car_images/".$car["car_image"] ?>" alt="Car Image" class="car-image mb-3">

        <!-- Car Details -->
        <div class="card p-3">
            <h4 class="card-title"><?= htmlspecialchars($car['car_name']); ?></h4>
            <p><strong>Fuel Type:</strong> <?= htmlspecialchars($car['fuel_type']); ?></p>
            <p><strong>Seats:</strong> <?= htmlspecialchars($car['seating_capacity']); ?></p>
            <p class="price">₹ <span id="price"><?= htmlspecialchars($car['price_per_hour']); ?></span> / hour</p>
        </div>

        <!-- Booking Form -->
        <form method="POST" action="booking_processing.php?id=<?php echo$_GET['id'];?>" class="mt-3">
            <input type="hidden" name="car_id" value="<?= $car_id; ?>">

            <div class="mb-3">
                <label class="form-label">Pickup Date</label>
                <input type="date" class="form-control" name="pickup_date" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pickup Hour</label>
                <input type="time" class="form-control" name="pickup_hour" id="pickup_hour" min="0" max="23" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Drop Date</label>
                <input type="date" class="form-control" name="drop_date" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Drop Hour</label>
                <input type="time" class="form-control" name="drop_hour" id="drop_hour" min="0" max="23" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Fare (₹)</label>
                <input type="text" name="total_fare" class="form-control" id="total_fare" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </form>

        <a href="explore_car.php" class="btn btn-secondary">Back to Cars</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function calculateFare() {
                var pickupDate = document.querySelector("input[name='pickup_date']").value;
                var dropDate = document.querySelector("input[name='drop_date']").value;
                var pickupHour = document.querySelector("input[name='pickup_hour']").value;
                var dropHour = document.querySelector("input[name='drop_hour']").value;
                var pricePerHour = <?= $car['price_per_hour']; ?>;

                if (pickupDate && dropDate && pickupHour && dropHour) {
                    var pickupDateTime = new Date(`${pickupDate}T${pickupHour}`);
                    var dropDateTime = new Date(`${dropDate}T${dropHour}`);

                    if (dropDateTime > pickupDateTime) {
                        var totalHours = Math.ceil((dropDateTime - pickupDateTime) / (1000 * 60 * 60)); // Convert milliseconds to hours

                        if (totalHours < 1) {
                            totalHours = 1; // Ensure at least 1 hour is billed
                        }

                        var totalFare = totalHours * pricePerHour;
                        document.getElementById("total_fare").value = "₹ " + totalFare;
                    } else {
                        document.getElementById("total_fare").value = "Invalid time selection";
                    }
                } else {
                    document.getElementById("total_fare").value = "";
                }
            }

            document.querySelector("input[name='pickup_date']").addEventListener("change", calculateFare);
            document.querySelector("input[name='drop_date']").addEventListener("change", calculateFare);
            document.querySelector("input[name='pickup_hour']").addEventListener("change", calculateFare);
            document.querySelector("input[name='drop_hour']").addEventListener("change", calculateFare);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>