<?php
// Start the session to maintain user state
session_start();

// Define the path to the profiles directory and file
$profilesDir = 'profiles/';
$profileFile = $profilesDir . 'profile_' . md5($_SESSION['user_id'] ?? 'default') . '.json';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create profiles directory if it doesn't exist
    if (!file_exists($profilesDir)) {
        mkdir($profilesDir, 0755, true);
    }

    // Get form data
    $profileData = [
        'full_name' => $_POST['full_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'address' => $_POST['address'] ?? '',
        'membership' => $_POST['membership'] ?? 'Gold',
        'member_since' => $_POST['member_since'] ?? date('F Y'),
        'stays_completed' => $_POST['stays_completed'] ?? '10',
        'profile_image' => $_POST['profile_image'] ?? 'default-profile.jpg'
    ];

    // Save profile data to file
    file_put_contents($profileFile, json_encode($profileData));

    // Set response header to JSON
    header('Content-Type: application/json');

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    exit;
}

// Load existing profile data
$profileData = [];
if (file_exists($profileFile)) {
    $profileData = json_decode(file_get_contents($profileFile), true);
}

// Default values if profile doesn't exist
$profileData = array_merge([
    'full_name' => 'John Alexander Doe',
    'email' => 'johndoe@example.com',
    'phone' => '+91 98765 43210',
    'dob' => '15 June 1985',
    'address' => '123 Main Street, Apartment 4B, Rajkot, Gujarat 360005, India',
    'membership' => 'Gold',
    'member_since' => 'January 2023',
    'stays_completed' => '10',
    'profile_image' => "https://i.pravatar.cc/300"
], $profileData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - AR Hotels</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f8f9fa;
        }

        .image-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #007bff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn-save {
            min-width: 120px;
        }

        .alert {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'Header1.php'; ?>
    <div class="container">
        <div class="profile-container">
            <h2 class="text-center mb-4">Edit Profile</h2>

            <div class="alert alert-success" id="successAlert">
                Profile updated successfully!
            </div>

            <div class="alert alert-danger" id="errorAlert">
                Error updating profile. Please try again.
            </div>

            <form id="profileForm">
                <div class="profile-image-container">
                    <img src="<?php echo htmlspecialchars($profileData['profile_image']); ?>" class="profile-image" id="profileImage">
                    <label for="imageUpload" class="image-upload">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="imageUpload" style="display: none">
                    <input type="hidden" name="profile_image" id="profileImagePath" value="<?php echo htmlspecialchars($profileData['profile_image']); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" value="<?php echo htmlspecialchars($profileData['full_name']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($profileData['email']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($profileData['phone']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="text" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($profileData['dob']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($profileData['address']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="membership">Membership</label>
                            <select class="form-control" id="membership" name="membership">
                                <option value="Silver" <?php echo $profileData['membership'] === 'Silver' ? 'selected' : ''; ?>>Silver</option>
                                <option value="Gold" <?php echo $profileData['membership'] === 'Gold' ? 'selected' : ''; ?>>Gold</option>
                                <option value="Platinum" <?php echo $profileData['membership'] === 'Platinum' ? 'selected' : ''; ?>>Platinum</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="memberSince">Member Since</label>
                            <input type="text" class="form-control" id="memberSince" name="member_since" value="<?php echo htmlspecialchars($profileData['member_since']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="staysCompleted">Stays Completed</label>
                            <input type="number" class="form-control" id="staysCompleted" name="stays_completed" value="<?php echo htmlspecialchars($profileData['stays_completed']); ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle image upload preview
            $('#imageUpload').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profileImage').attr('src', e.target.result);
                        $('#profileImagePath').val(e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // jQuery validation
            $('#profileForm').submit(function(e) {
                e.preventDefault();

                let isValid = true;
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                let phonePattern = /^[+]?[0-9]{10,15}$/;

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Validate Full Name
                if ($('#fullName').val().trim() === '') {
                    isValid = false;
                    $('#fullName').addClass('is-invalid').after('<div class="invalid-feedback">Full Name is required.</div>');
                }

                // Validate Email
                if (!emailPattern.test($('#email').val().trim())) {
                    isValid = false;
                    $('#email').addClass('is-invalid').after('<div class="invalid-feedback">Enter a valid email.</div>');
                }

                // Validate Phone
                if (!phonePattern.test($('#phone').val().trim())) {
                    isValid = false;
                    $('#phone').addClass('is-invalid').after('<div class="invalid-feedback">Enter a valid phone number.</div>');
                }

                // Validate Date of Birth
                if ($('#dob').val().trim() === '') {
                    isValid = false;
                    $('#dob').addClass('is-invalid').after('<div class="invalid-feedback">Date of Birth is required.</div>');
                }

                // Validate Address
                if ($('#address').val().trim() === '') {
                    isValid = false;
                    $('#address').addClass('is-invalid').after('<div class="invalid-feedback">Address is required.</div>');
                }

                // Validate Stays Completed
                if ($('#staysCompleted').val().trim() === '' || isNaN($('#staysCompleted').val().trim())) {
                    isValid = false;
                    $('#staysCompleted').addClass('is-invalid').after('<div class="invalid-feedback">Enter a valid number.</div>');
                }

                if (isValid) {
                    $.ajax({
                        type: 'POST',
                        url: 'edit_profile.php',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#successAlert').fadeIn().delay(3000).fadeOut();
                            } else {
                                $('#errorAlert').text(response.message).fadeIn().delay(3000).fadeOut();
                            }
                        },
                        error: function() {
                            $('#errorAlert').text('An error occurred. Please try again.').fadeIn().delay(3000).fadeOut();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>