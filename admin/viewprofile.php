<?php
session_start();

// Include your database connection file.
include('../database/connectdb.php');

// Check if the user is logged in. Redirect to the login page if not.
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Replace with your login page URL
    exit();
}

// Retrieve the user's profile information based on the user ID from the session.
$userID = $_SESSION['userID'];

// Fetch user's profile data
$sqlProfile = "SELECT * FROM admin_profiles WHERE admin_id = $userID";
$resultProfile = mysqli_query($con, $sqlProfile);

if ($resultProfile) {
    $profileData = mysqli_fetch_assoc($resultProfile);
}

// Fetch the username and email from the User table.
$sqlUser = "SELECT username, email FROM User WHERE userID = $userID";
$resultUser = mysqli_query($con, $sqlUser);

if ($resultUser) {
    $userData1 = mysqli_fetch_assoc($resultUser);
}

// Check if the user's role is Staff
$sqlUserRole = "SELECT role FROM User WHERE userID = $userID";
$resultUserRole = mysqli_query($con, $sqlUserRole);

if ($resultUserRole) {
    $userData = mysqli_fetch_assoc($resultUserRole);
    $userRole = $userData['role'];

    if ($userRole === 'Staff') {
        // Check if the user already has a profile in admin_profiles
        $sqlCheckProfile = "SELECT * FROM admin_profiles WHERE admin_id = $userID";
        $resultCheckProfile = mysqli_query($con, $sqlCheckProfile);

        if (!$resultCheckProfile || mysqli_num_rows($resultCheckProfile) == 0) {
            // User is a Staff and doesn't have a profile in admin_profiles, so create one
            $sqlCreateProfile = "INSERT INTO admin_profiles (admin_id) VALUES ($userID)";
            if (mysqli_query($con, $sqlCreateProfile)) {
                // Profile created successfully or already existed
                // You can add further logic here if needed
            } else {
                echo "Error creating staff profile: " . mysqli_error($con);
            }
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Profile</title>
    <!-- Link to your custom CSS file -->
    <link rel="stylesheet" type="text/css" href="profile.css">
    <?php include("./adminHeader.html");?>
</head>

<body>
    <div class="container mt-5">
    <a href="dashboard.php" class="btn btn-back">Back</a>
        <?php if (!empty($profileData)): ?>
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-image">
                    <?php if (!empty($profileData['picture'])): ?>
                    <!-- Display user profile picture here -->
                    <img src="<?php echo $profileData['picture']; ?>" class="profile-image img-fluid rounded"
                        alt="Profile Picture">
                <?php else: ?>
                    <!-- Display default profile picture here -->
                    <img src="../profile-pictures/profile-image.jpeg" class="profile-image img-fluid rounded"
                        alt="Default Profile Picture">
                <?php endif; ?>
                    </div>
                    <div class="profile-name">
                        <?= $userData1['username'] ?>
                    </div>
                </div>
                <div class="profile-details">
                    <h3 class="section-title">Profile Details</h3>
                    <table class="table table-striped">
                        <tr>
                            <th>Full Name</th>
                            <td>
                                <?= !empty($profileData['full_name']) ? $profileData['full_name'] : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <?= !empty($userData1['email']) ? $userData1['email'] : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>
                                <?= !empty($profileData['phone']) ? $profileData['phone'] : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td>
                                <?= !empty($profileData['age']) ? $profileData['age'] : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>
                                <?= !empty($profileData['gender']) ? $profileData['gender'] : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>
                                <?= !empty($profileData['street']) ? $profileData['street'] : '-' ?><br>
                                <?= !empty($profileData['city']) ? $profileData['city'] . ', ' . $profileData['zip_code']. ' '. $profileData['state'] : '-' ?>
                            </td>
                        </tr>

                        <!-- Add more profile fields here -->
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p>No profile information found for this user.</p>
        <?php endif; ?>

        <div class="profile-actions">
            <a href="profile-edit.php" class="btn btn-edit">Edit Profile</a>
        </div>
    </div>

</body>

</html>
