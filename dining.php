<?php 
// session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dining - AR HOTELS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('food.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
        }

        .hero {
            background: url('dining-banner.jpg') no-repeat center center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
        }

        .menu-section {
            padding: 50px 0;
            text-align: center;
            color: white;
        }

        .menu-item {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .menu-item img {
            width: 100%;
            height: 250px;
            border-radius: 10px;
        }

        h1,
        h2,
        h3,
        p {
            color: white;
        }
    </style>
</head>

<body>
    <?php include 'Header.php'; ?>



    <div class="hero">
        <h1>Experience Fine Dining at AR HOTELS</h1>
    </div>

    <div class="container menu-section">
        <h1>Experience Fine Dining at AR HOTELS</h1>
        <br>
        <h2 class="text-center mb-4">Our Signature Dishes</h2>
        <div class="row">
            <div class="col-md-4 menu-item">
                <img src="pizza.jpg" alt="Gourmet Steak">
                <h3>Pizza</h3>
                <p>The Magic Of 9 Kind Of Cheese On Your Pizza Long Stands Of Stringy Mozzarella, Cheddar. It Is A Cheesy Experience Even Angels Fall For</p>
            </div>
            <div class="col-md-4 menu-item">
                <img src="pasta.jpg" alt="Italian Pasta">
                <h3>Italian Pasta</h3>
                <p>Authentic homemade pasta with rich and creamy sauce.</p>
            </div>
            <div class="col-md-4 menu-item">
                <img src="desert.jpg" alt="Luxury Dessert">
                <h3>Luxury Dessert</h3>
                <p>Indulgent chocolate cake with a molten lava center.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>