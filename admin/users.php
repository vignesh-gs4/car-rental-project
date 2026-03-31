<?php
session_start();
include("../db_connect.php");
// Fetch all user verification requests
$sql = "SELECT * FROM profile_verification";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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

        .status-rejected {
            padding: 5px 10px;
            border-radius: 5px;
            background-color: red;
            color: white;
        }
        .status-approved {
            padding: 5px 10px;
            border-radius: 5px;
            background-color: green;
            color: white;
        }
        .action-icons a {
            margin-right: 5px;
            text-decoration: none;
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
    <div class="content">
        <h5>Dashboard / Users</h5>
        <div class="card mt-4">
            <div class="card-body">
                <h6>User Table</h6>
                <table id="userTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl_no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = $row["status"];
    
                        ?>
                            <tr>
                                <td><?= $sl_no++ ?></td>
                                <td><?= htmlspecialchars($row["name"]) ?></td>
                                <td><?= htmlspecialchars($row["email"]) ?></td>
                                <td><?= htmlspecialchars($row["phone"]) ?></td>
                                <td><span class="<?= ($status == 'Approved')?'status-approved':'status-rejected' ?>"><?= $status ?></span></td>
                                <td class="action-icons">
                                    <a href="view_profile.php?user_id=<?= $row['user_id'] ?>" class="btn btn-info btn-sm">👁 View</a>
                                    <a href="verify_profile.php?delete=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this request?')">🗑 Delete</a>
                                </td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>