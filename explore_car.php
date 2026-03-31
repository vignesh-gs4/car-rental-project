<?php
include("db_connect.php");
session_start();
$sql = "SELECT * FROM cars";
$result = mysqli_query($conn, $sql);
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$booking_status = "No Booking";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php include("header.php"); ?>

    <section class="container-fluid bg-warning text-black py-4 ps-4">
        <h1 class="fw-bold">Car Rental Service</h1>
        <h4>The best service in rental sector</h4>
    </section>

    <section class="container">
        <h2 class="text-center my-4 text-dark">Available Cars</h2>
        <div class="row">
            <?php
            // Fetch all cars from the database
            $sql = "SELECT * FROM cars";
            $result = mysqli_query($conn, $sql);

            // Debugging: Check how many cars are fetched
            echo "<p class='text-center text-info'>Total cars found: " . mysqli_num_rows($result) . "</p>";

            if (mysqli_num_rows($result) > 0) {
                while ($car = mysqli_fetch_assoc($result)) {
                    $car_id = $car["id"];
                    $is_booked = false;

                    // Check if the user is logged in and has booked this car
                    if (isset($user_id) && !empty($user_id)) {
                        $sql_check = "SELECT COUNT(*) as count FROM bookings WHERE car_id = ? AND user_id = ? AND status = 'confirmed'";
                        $stmt_check = mysqli_prepare($conn, $sql_check);
                        mysqli_stmt_bind_param($stmt_check, "ii", $car_id, $user_id);
                        mysqli_stmt_execute($stmt_check);
                        $booked_result = mysqli_stmt_get_result($stmt_check);
                        $row = mysqli_fetch_assoc($booked_result);
                        $is_booked = $row['count'] > 0;
                        mysqli_stmt_close($stmt_check); // Close the statement
                    }
            ?>
                    <div class="col-md-4"> <!-- 3 cars per row -->
                        <div class="card mb-4">
                            <img src="<?php echo "car_images/" . htmlspecialchars($car["car_image"]); ?>"
                                alt="Car Image" class="card-img-top" style="object-fit: cover; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($car["car_name"]); ?></h5>
                                <p><strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                                <p><strong>Seats:</strong> <?php echo htmlspecialchars($car['seating_capacity']); ?></p>
                                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($car['price_per_hour']); ?> per hour</p>

                                <?php if ($is_booked): ?>
                                    <button class="btn btn-danger rounded-0" onclick="alert('You have already booked this car.');">Already Booked</button>
                                <?php else: ?>
                                    <a href="book_car.php?id=<?php echo htmlspecialchars($car['id']); ?>" class="btn btn-primary rounded-0">Book Now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center text-danger'>No Cars Available</p>";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>