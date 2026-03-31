<?php
include("db_connect.php");
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$booking_status = "No Booking";

if ($user_id) {
    
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
<header>
        <nav class="navbar navbar-expand-lg bg-light shadow-sm p-3">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">Car Rent</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="explore_car.php">Explore Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contactus.php">Contact Us</a>
                        </li>
                        <li>
                            <a class="nav-link" href="aboutus.php">About Us</a>
                        </li>
                        <?php if ($user_id): ?>
                            <!-- Booking Status Icon -->
                            <li class="nav-item">
                                <a class="nav-link" href="booking_details.php">
                                    <?php if ($booking_status === 'confirmed'): ?>
                                        <i class="fas fa-check-circle text-success"></i> Confirmed
                                    <?php elseif ($booking_status === 'pending'): ?>
                                        <i class="fas fa-clock text-warning"></i> Pending
                                    <?php else: ?>
                                        <i class="fas fa-exclamation-circle text-danger"></i> No Booking
                                    <?php endif; ?>
                                </a>
                            </li>

                            <!-- Logout / Profile -->
                            <li class="nav-item">
                                <a href="logout.php" type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                                    Logout
                                </a>
                            </li>
                        <?php else: ?>
                            <!-- Login Button -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>