<?php
session_start();
include("db_connect.php");

$booking_status = "No Booking";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql2 = "SELECT status FROM bookings WHERE user_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result2)) {
        $booking_status = $row["status"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include("header.php"); ?>

    <section class="container my-5">
        <h2 class="text-center mb-4">Contact Us</h2>
        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-6">
                <h4>Get in Touch</h4>
                <form action="send_message.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="col-md-6">
                <h4>Contact Information</h4>
                <p><i class="fas fa-map-marker-alt"></i>Paramakudi-623707, Ramanathapuram</p>
                <p><i class="fas fa-phone"></i> +91 8822677188</p>
                <p><i class="fas fa-envelope"></i>vigneshgs297@gmail.com</p>

                <!-- Google Map Embed -->
                <div class="ratio ratio-16x9 mt-3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31476.169195509025!2d78.56442204691555!3d9.55026451536996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b010617efde0787%3A0x1dd74f186a6c43ce!2sParamakudi%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1743555346636!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php") ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>