<?php
session_start();

// Include your database connection file.
include('../database/connectdb.php');

// Check if the user is logged in. Redirect to the login page if not.
if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

// Retrieve the user's profile information based on the user ID from the session.
$userID = $_SESSION['userID'];

// Fetch user's profile data
$sqlProfile = "SELECT * FROM user WHERE userID = $userID";
$resultProfile = mysqli_query($con, $sqlProfile);

if ($resultProfile) {
    $profileData = mysqli_fetch_assoc($resultProfile);
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
    <?php include("userHeader.php");?>
</head>

<body>
    <div class="container mt-5">
    <a href="userdashboard.php" class="btn btn-back"><i class="arrow left"></i> Back</a>
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
                                <?= !empty($profileData['zip_code']) ? $profileData['zip_code'] . ' ' . $profileData['city']. ', '. $profileData['state'] : ' ' ?>
                            </td>
                        </tr>

                        <!-- Add more profile fields here -->
                    </table>
                </div>
            </div>

        <div class="profile-actions">
            <a href="profile-edit.php" class="btn btn-edit">Edit Profile</a>
        </div>
    </div>

</body>

</html>
