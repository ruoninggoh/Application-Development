<?php
session_start();
// Include your database connection file.
include('../database/connectdb.php');

// Check if the user is logged in. Redirect to the login page if not.
if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");// Replace with your login page URL
    exit();
}

// Retrieve the user's profile information based on the user ID from the session.
$userID = $_SESSION['userID'];

$sqlUserRole = "SELECT role FROM User WHERE userID = $userID";
$resultUserRole = mysqli_query($con, $sqlUserRole);

if ($resultUserRole) {
    $userData = mysqli_fetch_assoc($resultUserRole);
    $userRole = $userData['role'];

    if ($userRole === 'Doctor') {
        // Check if the user already has a profile in user_profiles
        $sqlCheckProfile = "SELECT * FROM doctor_profiles WHERE doctor_id = $userID";
        $resultCheckProfile = mysqli_query($con, $sqlCheckProfile);

        if (!$resultCheckProfile || mysqli_num_rows($resultCheckProfile) == 0) {
            // User is a Staff and doesn't have a profile in user_profiles, so create one
            $sqlCreateProfile = "INSERT INTO doctor_profiles (doctor_id) VALUES ($userID)";
            if (mysqli_query($con, $sqlCreateProfile)) {
                // Profile created successfully or already existed
                // You can add further logic here if needed
            } else {
                echo "Error creating staff profile: " . mysqli_error($con);
            }
        }
    }
}
// Fetch user's profile data
$sqlProfile = "SELECT * FROM doctor_profiles WHERE doctor_id = $userID";
$resultProfile = mysqli_query($con, $sqlProfile);

if ($resultProfile) {
    $profileData = mysqli_fetch_assoc($resultProfile);
}

// Fetch the username from the User table.
$sqlUsername = "SELECT * FROM User WHERE userID = $userID";
$resultUsername = mysqli_query($con, $sqlUsername);

if ($resultUsername) {
    $userData = mysqli_fetch_assoc($resultUsername);
}


mysqli_close($con);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" type="text/css" href="editprofile.css">
    <?php include("./doctorHeader.html");?>
</head>

<body>
    <div class="container">
        <div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg">
            <div class="col-md-8">
                <div class="h2">Edit Profile</div>
                <form action="update_process.php" method="POST" enctype="multipart/form-data">
                    <div class="profile-picture-container">
                        <img id="preview" src="../profile-pictures/<?php echo empty($profileData['picture']) ? '../profile-pictures/profile-image.jpeg' : $profileData['picture']; ?>" alt="Profile Picture"
                            class="rounded-circle">
                    </div>
                    <div class="form-group">
                        <label for="profilePicture">Profile Picture:</label><br>
                        <input type="file" class="form-control" id="profilePicture" name="profilePicture"
                            accept="image/*" onchange="previewImage(this);">
                    </div>
                    <!-- Add hidden field for admin_id if needed -->
                    <input type="hidden" name="doctor_id"
                        value="<?php echo isset($profileData['doctor_id']) ? $profileData['doctor_id'] : ''; ?>">
                    <div class="form-group">
                        <label for="username">Username: </label><br>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Enter your username"
                            value="<?php echo isset($userData['username']) ? $userData['username'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Full Name: </label><br>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            placeholder="Enter your full name"
                            value="<?php echo isset($profileData['full_name']) ? $profileData['full_name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label><br>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email (e.g., abc@gmail.com)"
                            value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>" required>
                        <p id="email-error" style="display: none; color: red;">Invalid email format</p>
                    </div>
                    <div class="form-group">
                        <label for="contactNo">Contact No: </label><br>
                        <input type="tel" class="form-control" id="contactNo" name="contactNo"
                            placeholder="Enter your contact number (e.g., (+60)12345678)"
                            value="<?php echo isset($profileData['phone']) ? $profileData['phone'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="choose" <?php echo (isset($profileData['gender']) && $profileData['gender'] === 'choose') ? 'selected' : ''; ?>>---Choose your gender---
                            </option>
                            <option value="Male" <?php echo (!empty($profileData['gender']) && $profileData['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (!empty($profileData['gender']) && $profileData['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <!-- Age -->
                    <div class="form-group">
                        <label for="age">Age:</label><br>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age"
                            value="<?php echo isset($profileData['age']) ? $profileData['age'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label><br>
                        <input type="text" class="form-control" id="street" name="street"
                            placeholder="Enter your street address"
                            value="<?php echo isset($profileData['street']) ? $profileData['street'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label><br>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city"
                            value="<?php echo isset($profileData['city']) ? $profileData['city'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State:</label><br>
                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state"
                            value="<?php echo isset($profileData['state']) ? $profileData['state'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">Postal Code:</label><br>
                        <input type="number" class="form-control" id="zip_code" name="zip_code"
                            placeholder="Enter your zip code" maxlength="5"
                            value="<?php echo isset($profileData['zip_code']) ? $profileData['zip_code'] : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="viewprofile.php" class="btn btn-secondary" onclick="return confirm('Are you want to leave the profile?');">Back</a>
                </form>
            </div>
        </div>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>

</html>