<?php

include 'header.php';

if (!isset($_SESSION['userEmail'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['userEmail'];

$q = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($q);
$row = mysqli_fetch_assoc($result);

// Handle form submission to save review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Basic validation
    if (empty($name) || empty($rating) || empty($review)) {
        $error_message = "All fields are required.";
    } else {
        // Insert the review into the database
        $query = "INSERT INTO reviews (name, email, rating, review) VALUES ('$name', '$email', '$rating', '$review')";
        if (mysqli_query($conn, $query)) {
            $success_message = "Review submitted successfully!";
        } else {
            $error_message = "Error submitting review. Please try again later.";
        }
    }
}

// Get reviews from the database
$query_reviews = "SELECT * FROM reviews ORDER BY id DESC";
$reviews_result = mysqli_query($conn, $query_reviews);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Reviews - AR Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inline CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/review.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            padding-top: 200px;
        }

        .container {
            max-width: 800px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-family: 'Merienda', cursive;
            color: #333;
        }

        .alert {
            margin-top: 20px;
        }

        .form-control,
        .form-select {
            margin-bottom: 15px;
        }

        .review-card {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-footer {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .review-footer img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .star-rating {
            color: #FFA500;
            font-size: 16px;
        }

        .error-message {
            color: red;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Guest Reviews</h2>

        <!-- Review Form -->
        <form method="POST" id="reviewForm">
            <!-- Display success or error message -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?= $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message; ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>" readonly />
            </div>

            <div class="mb-3">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" readonly />

            </div>

            <div class="mb-3">
                <label for="rating">Rating</label>
                <select id="rating" name="rating" class="form-select">
                    <option value="">Select Rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                    <option value="4">⭐⭐⭐⭐ (Very Good)</option>
                    <option value="3">⭐⭐⭐ (Good)</option>
                    <option value="2">⭐⭐ (Fair)</option>
                    <option value="1">⭐ (Poor)</option>
                </select>
                <div class="error-message" id="ratingError">Please select a rating.</div>
            </div>

            <div class="mb-3">
                <label for="review">Your Review</label>
                <textarea id="review" name="review" class="form-control"></textarea>
                <div class="error-message" id="reviewError">Please write your review.</div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>

        <hr>


        <h3>Latest Reviews</h3>
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
                        <p class="star-rating">
                            <?php
                            for ($i = 1; $i <= $row['rating']; $i++) {
                                echo "⭐";
                            }
                            ?>
                        <p>"<?= $row['review']; ?>"</p>
                        </p>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#reviewForm").submit(function(e) {

                $(".error-message").hide();
                $("input, textarea, select").removeClass("error");

                let rating = $("#rating").val();
                if (rating === "") {
                    $("#rating").addClass("error");
                    $("#ratingError").show();
                    valid = false;
                }

                let review = $("#review").val().trim();
                if (review === "") {
                    $("#review").addClass("error");
                    $("#reviewError").show();
                    valid = false;
                }

                // Prevent form submission if invalid
                if (!valid) e.preventDefault();
            });

            $("input, textarea, select").on("input change", function() {
                $(this).removeClass("error");
                $(this).next(".error-message").hide();
            });
        });
    </script>
</body>

</html>