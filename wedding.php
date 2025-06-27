<?php 
// session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Weddings - AR HOTELS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('wedd.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .hero {
            background: url('wedding-banner.jpg') no-repeat center center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
        }

        .wedding-section {
            padding: 50px 0;
            text-align: center;
        }

        .wedding-section h1,
        .wedding-section h2,
        .wedding-section p {
            color: black;
        }

        .gallery img {
            width: 100%;
            height: 250px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <?php include 'Header.php'; ?>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Make Your Wedding Unforgettable at AR HOTELS</h1>
    </div>

    <!-- Wedding Services Section -->
    <div class="container wedding-section">
        <h1>Celebrate Your Love in Luxury</h1>
        <p>At AR HOTELS, we provide elegant wedding venues, customized catering, and top-tier services to make your wedding day truly special.</p>

        <h2 class="mt-4">Our Wedding Services</h2>
        <ul class="list-unstyled">
            <li>🌟 Stunning Indoor & Outdoor Venues</li>
            <li>🍽️ Gourmet Catering & Custom Menus</li>
            <li>🎶 Live Music & Entertainment</li>
            <li>💐 Beautiful Floral Arrangements</li>
            <li>📸 Professional Photography & Videography</li>
            <li>🏨 Luxury Accommodation for Guests</li>
        </ul>


    </div>

    <!-- Wedding Gallery Section -->
    <div class="container wedding-section">
        <h2>Our Wedding Gallery</h2>
        <div class="row">
            <div class="col-md-4">
                <img src="beach.jpg" alt="Wedding Venue" class="img-fluid">
            </div>
            <div class="col-md-4">
                <img src="banqt.jpg" alt="Wedding Banquet" class="img-fluid">
            </div>
            <div class="col-md-4">
                <img src="event.jpg" alt="Wedding Ceremony" class="img-fluid">
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include 'Footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>