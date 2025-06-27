<?php include 'Header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .h-font {
            font-family: "Merienda", cursive;
        }

        .hero {
            background: url('1.jpg') no-repeat center center/cover;
            height: 80vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        @media (min-width: 768px) {
            .hero h1 {
                font-size: 4rem;
            }
        }

        footer {
            background: #343a40;
            color: white;
            padding: 2rem 0;
        }

        .hotel-images img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .hotel-images img:hover {
            transform: scale(1.05);
        }

        .overlay-img {
            width: 60%;
            bottom: -30px;
            right: -20px;
        }

        .overlay-img img {
            width: 100%;
            border-radius: 10px;
            border: 5px solid white;
        }

        .experience-section {
            background: url('1.jpg') no-repeat center center/cover;
            position: relative;
            padding: 80px 0;
            color: #fff;
        }

        .experience-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .experience-section .container {
            position: relative;
            z-index: 2;
        }

        .review-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        .review-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .review-card .star-rating {
            font-size: 1.2rem;
            color: #FFA500;
        }

        .main-img img {
            width: 100%;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .overlay-img {
                width: 80%;
                bottom: -20px;
                right: -10px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Welcome to AR Hotels</h1>
            <p class="fs-4">Where Opulence Meets Sustainability</p>
        </div>
    </div>

    <!-- Luxury Hotel Section -->
    <section class="py-5 luxury-section">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-md-6 text-center text-md-start">
                    <h5 class="text-muted fst-italic">Epitome Of Luxury In Rajkot</h5>
                    <h2 class="h-font fw-bold">AR HOTELS</h2>
                    <p>
                        Indulge in the epitome of luxury at AR HOTELS Rajkot, a premier hotel that offers an exceptional blend of comfort and sophistication...
                    </p>
                    <button class="btn btn-outline-dark mt-3">VIEW FACTSHEET</button>
                </div>
                <div class="col-md-6 position-relative">
                    <div class="main-img">
                        <img src="2.jpg" alt="Hotel Exterior" class="img-fluid rounded shadow">
                    </div>
                    <div class="overlay-img position-absolute d-none d-md-block">
                        <img src="3.jpg" alt="Hotel Interior" class="img-fluid shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="experience-section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-5 text-center text-md-start">
                    <h2 class="h-font fw-bold">EXPERIENCE THE EXCELLENCE</h2>
                    <p>Discover the excellence and luxury of Sayaji Rajkot...</p>
                </div>
                <div class="col-md-7">
                    <div class="row g-4">
                        <div class="col-12 col-sm-6">
                            <img src="8.jpg" class="img-fluid rounded shadow" alt="Elegance">
                            <h5 class="mt-3">MODERN ELEGANCE</h5>
                        </div>
                        <div class="col-12 col-sm-6">
                            <img src="9.jpg" class="img-fluid rounded shadow" alt="Amenities">
                            <h5 class="mt-3">WORLD-CLASS AMENITIES</h5>
                        </div>
                        <div class="col-12 col-sm-6">
                            <img src="10.jpg" class="img-fluid rounded shadow" alt="Service">
                            <h5 class="mt-3">EXCEPTIONAL SERVICE</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <?php
    $query_reviews = "SELECT * FROM reviews ORDER BY id DESC LIMIT 3";
    $reviews_result = mysqli_query($conn, $query_reviews);
    ?>
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="h-font text-center mb-4">Guest Reviews</h2>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($reviews_result)): ?>
                    <div class="col-md-4">
                        <div class="review-card">
                            <div class="review-footer">
                                <div>
                                    <strong><?= $row['name']; ?></strong><br>
                                    <small><?= $row['email']; ?></small>
                                </div>
                            </div>
                            <p>"<?= $row['review']; ?>"</p>
                            <p class="star-rating">
                                <?php for ($i = 1; $i <= $row['rating']; $i++) echo "⭐"; ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="hotel-gallery py-5">
        <div class="container text-center">
            <h2 class="h-font mb-4">Our Hotel Gallery</h2>
            <div class="row g-4">
                <?php
                $images = ['2.jpg', '3.jpg', '4.jpg', '11.jpg', '6.jpg', '7.jpg'];
                foreach ($images as $img): ?>
                    <div class="col-6 col-md-4 hotel-images">
                        <img src="<?= $img ?>" alt="Hotel Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Reserve Your Stay -->
    <section class="reserve-stay py-5">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?...your-map-link..."
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-6 text-center text-md-start">
                    <h2 class="fw-bold">RESERVE YOUR STAY</h2>
                    <p class="text-muted fst-italic">"A Symphony of Elegance & Comfort"</p>
                    <p>Vrindavan Society, Kalavad Rd, Rajkot, Gujarat</p>
                    <a href="Booking.php" class="btn btn-outline-dark btn-lg mt-3">CHECK YOUR AVAILABILITY</a>
                    <p class="mt-3"><strong>Mobile:</strong> +91-63565*****/ +91-94094****</p>
                    <p><strong>Email:</strong> <a href="mailto:reservations.ar@arhotels.com">reservations.ar@arhotels.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>