<?php
session_start();
include("../db_connect.php");

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("User ID not provided.");
}

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM profile_verification WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("No user found.");
}
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_GET['user_id'];
    $status = trim($_POST['status'] ?? ''); // Remove extra spaces
    echo "<pre>";
    print_r($_POST); // Show the entire POST array
    echo "Received status: '" . $_POST['status'] . "'";
    echo "</pre>";
    if (!$status) {
        die("Error: Status not received.");
    }

    // Update status in the database
    $update_sql = "UPDATE profile_verification SET status = '$status' WHERE user_id = '$user_id'";
    $_SESSION['status'] = $status;
    echo"<script>
    document.getElementById('verificationForm').onsubmit = function() {
        let selectedStatus = document.querySelector('input[name='status']:checked').value;
        console.log('Selected Status:', selectedStatus)
        localStorage.setItem('status', selectedStatus)
    };
</script>";
    if (mysqli_query($conn, $update_sql)) {
        $message = ($status == "Verified") ? "Your profile has been verified successfully!" : "Your profile verification request has been rejected.";
        echo"<div class='alert alert-primary-subtle'>alert($message)</div>";

        // Example: Sending email (commented out, requires mail setup)
        // mail($row["email"], "Profile Verification Update", $message, "From: admin@yourwebsite.com");

        echo "<div class='alert alert-success'><script>alert('Profile status updated successfully!$status'); window.location.href = 'users.php';</script></div>";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin-top: 40px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            width: 100%;
            max-width: 350px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .status-label {
            font-size: 16px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-pending {
            background-color: #ffc107;
            color: #212529;
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
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center mb-4">User Profile Verification</h3>
        
        <!-- User Info -->
        <div class="card p-3">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> <?= htmlspecialchars($row["name"]) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row["email"]) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($row["phone"]) ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($row["address"]) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Driving License No:</strong> <?= htmlspecialchars($row["license_number"]) ?></p>
                    <p>
                        <strong>Status:</strong>
                        <span class="status-label 
                            <?= $row["status"] == "Pending" ? 'status-pending' : ($row["status"] == "Approved" ? 'status-approved' : 'status-rejected') ?>">
                            <?= $row["status"] ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <h5 class="mt-4">Documents</h5>
        <div class="card p-3">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Driving License (Front):</strong></p>
                    <img src="../user_uploads/sample_license.jpg" alt="Driving License Front" class="profile-image">
                </div>
                <div class="col-md-4">
                    <p><strong>Driving License (Back):</strong></p>
                    <img src="../user_uploads/sample_license.jpg" alt="Driving License Back" class="profile-image">
                </div>
                <div class="col-md-4">
                    <p><strong>Address Proof:</strong></p>
                    <img src="../user_uploads/sample_address_proof.jpg" alt="Address Proof" class="profile-image">
                </div>
            </div>
        </div>

        <!-- Admin Verification Form -->
        <h5 class="mt-4">Admin Verification</h5>
        <form id="verificationForm" action="view_profile.php?user_id=<?= $_GET['user_id'] ?>" method="post" class="p-3 border rounded">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="Approved" id="approve" required>
            <label class="form-check-label text-success fw-bold" for="approve">✔ Approve (Verified)</label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="Rejected" id="reject" required>
            <label class="form-check-label text-danger fw-bold" for="reject">❌ Reject</label>
            </div>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
            <a href="users.php" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
