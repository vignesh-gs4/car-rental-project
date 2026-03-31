<?php
session_start();
include("../db_connect.php");

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}

// Fetch all bookings with pickup and drop-off time
$sql = "SELECT b.id, c.car_name, u.name AS user_name, 
               b.pickup_date, b.pickup_hour, 
               b.drop_date, b.drop_hour, b.status 
        FROM bookings b
        JOIN cars c ON b.car_id = c.id
        JOIN users u ON b.user_id = u.id
        ORDER BY b.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
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
        }

        .sidebar a {
            padding: 15px;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 16px;
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

        .table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-approved {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
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
        <h5 class="dashboard-title">Booking History</h5>
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Car Name</th>
                        <th>User</th>
                        <th>Pickup Date & Time</th>
                        <th>Drop-off Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td class="text-center"><?php echo $row['car_name']; ?></td>
                            <td class="text-center"><?php echo $row['user_name']; ?></td>
                            <td class="text-center"><?php echo $row['pickup_date'] . " - " . $row['pickup_hour']; ?></td>
                            <td class="text-center"><?php echo $row['drop_date'] . " - " . $row['drop_hour']; ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <span class="status-pending">Pending</span>
                                <?php } elseif ($row['status'] == 'Approved') { ?>
                                    <span class="status-approved">Approved</span>
                                <?php } elseif ($row['status'] == 'Cancelled') { ?>
                                    <span class="status-cancelled">Cancelled</span>
                                <?php } else { ?>
                                    <span><?php echo $row['status']; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
