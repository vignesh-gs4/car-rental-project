<?php
    session_start();
    include("db_connect.php");
    $message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
            $address = mysqli_real_escape_string($conn, $_POST["address"]);
            $license_number = mysqli_real_escape_string($conn, $_POST["license_no"]);
            $id_proof_number = mysqli_real_escape_string($conn, $_POST["id_no"]);

            $license_front = $_FILES["license_front_img"]["name"];
            $license_back = $_FILES["license_back_img"]["name"];
            $address_proof = $_FILES["address_proof_img"]["name"];

            $target_dir = "user_uploads/";
            $license_front_path = $target_dir . basename($license_front);
            $license_back_path = $target_dir . basename($license_back);
            $address_proof_path = $target_dir . basename($address_proof);

            move_uploaded_file($_FILES["license_front_img"]["tmp_name"], $license_front_path);
            move_uploaded_file($_FILES["license_back_img"]["tmp_name"], $license_back_path);
            move_uploaded_file($_FILES["address_proof_img"]["tmp_name"], $address_proof_path);

            $sql = "INSERT INTO profile_verification (user_id, name, email, phone, address, license_number, 
            license_front, license_back, id_proof_number, address_proof, status) 
            VALUES ('{$_SESSION["user_id"]}', '$name', '$email', '$phone', '$address', 
            '$license_number', '$license_front', '$license_back', '$id_proof_number', '$address_proof', 'Pending')";

            if (mysqli_query($conn, $sql)) {
                $message = "<div class='alert alert-success'>Profile verification request sent successfully!</div>";
                echo $message;
            } else {
                $message = "<div class='alert alert-danger'>Error: Could not send request!</div>";
                echo $message;
            }
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger'>Error: Could not send request!</dvi>";
            echo $message;
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: rgb(222, 228, 238);
        }
        .form-section {
            margin-bottom: 10%;
        }
    </style>
</head>
<body>

    <?php include("header.php");?>
    <section>
        <div class="container ps-5 mt-2">
            <span class="fs-4 text-secondary">Verification</span>
            <button class="btn btn-danger p-0 fw-medium">Pending</button>
        </div>
    </section>
    <section class="container mx-auto my-2 bg-light pt-3 pb-5">
        <h2>Upload Document for Verification</h2>
        <p>Please fill out details below</p>
    </section>
    <section class="container mx-auto bg-light py-4 form-section">
        <form action="profile.php" method="post" enctype="multipart/form-data" class="container bg-white p-4">
            <div class="row">
                <div class="col mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control border-3" name="name" id="name" placeholder="Enter Name" required>
                </div>
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control border-3" name="email" id="email" placeholder="example@gmail.com" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control border-3" name="phone" id="phone" placeholder="8870024561" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control border-3" name="address" id="address" placeholder="Apartment, studio, or floor" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="license_no" class="form-label">Driving License Number</label>
                    <input type="text" class="form-control border-3" name="license_no" id="license_no" placeholder="Application NO" required>
                </div>
                <div class="col mb-3">
                    <label for="license_front_img" class="form-label">Driving License Front Image</label>
                    <input type="file" class="form-control border-3" name="license_front_img" required>
                </div>
                <div class="col mb-3">
                    <label for="license_back_img" class="form-label">Driving License Back Image</label>
                    <input type="file" class="form-control border-3" name="license_back_img" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="id_no" class="form-label">ID Proof Number</label>
                    <input type="tel" class="form-control border-3" name="id_no" id="id_no" placeholder="Application NO" required>
                </div>
                <div class="col mb-3">
                    <label for="address_proof" class="form-label">Address Proof Image</label>
                    <input type="file" id="address_proof" name="address_proof_img" class="form-control border-3" required>
                </div>
            </div>
            <div class="row">
                <button class="btn btn-primary px-5 col-4 rounded-0 offset-8">Submit</button>
            </div>
        </form>
    </section>

    <?php include("footer.php") ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>