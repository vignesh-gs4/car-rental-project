<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel=stylesheet href="style.css">
    <style>
        .team-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
        .icon-box {
            font-size: 40px;
            color: #ff8c00;
        }
        .ul-details {
        list-style-type: none;
    }
    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <!-- Hero Section -->
    <section class="bg-warning text-black text-center py-5">
        <h1 class="fw-bold">About Our Car Rental Service</h1>
        <p class="lead">Your trusted partner for hassle-free car rentals.</p>
    </section>

    <!-- About Content -->
    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="car_images/index_img.avif" class="img-fluid rounded" alt="About Us">
            </div>
            <div class="col-md-6">
                <h2>Who We Are</h2>
                <p>We are a leading car rental company dedicated to providing top-quality vehicles at affordable rates. Our mission is to ensure a smooth and convenient car rental experience for our customers.</p>
                <p>With a wide range of vehicles, flexible rental plans, and exceptional customer service, we make traveling easier for everyone.</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">Why Choose Us?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="icon-box"><i class="fas fa-car"></i></div>
                    <h4>Variety of Cars</h4>
                    <p>Choose from a wide selection of economy, luxury, and SUV cars.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon-box"><i class="fas fa-hand-holding-usd"></i></div>
                    <h4>Affordable Prices</h4>
                    <p>Enjoy competitive rates and transparent pricing with no hidden fees.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon-box"><i class="fas fa-headset"></i></div>
                    <h4>24/7 Support</h4>
                    <p>Our customer support team is available round the clock to assist you.</p>
                </div>
            </div>
        </div>
    </section>    
    <?php include("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
