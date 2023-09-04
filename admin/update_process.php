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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle profile picture upload if a new picture is selected
    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] == 0) {
        $targetDirectory = "../profile-pictures/";
        $targetFile = $targetDirectory . basename($_FILES["profilePicture"]["name"]);
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            // Update the profile picture in the database
            $sqlUpdatePicture = "UPDATE admin_profiles SET picture = '$targetFile' WHERE admin_id = $userID";
            mysqli_query($con, $sqlUpdatePicture);
        } else {
            echo "Failed to upload profile picture.";
        }
    }

    // Handle other profile information
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $contactNo = $_POST["contactNo"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip_code = $_POST["zip_code"];

    // Validate and sanitize input
    $username = mysqli_real_escape_string($con, $username);
    $fullname = mysqli_real_escape_string($con, $fullname);
    $email = mysqli_real_escape_string($con, $email);
    $contactNo = mysqli_real_escape_string($con, $contactNo);
    $gender = mysqli_real_escape_string($con, $gender);
    $age = (int) $age; // Ensure age is an integer
    if (strpos($email, "@graduate.utm.my") === false) {
        echo '<script>';
        echo 'alert("Email must end with @graduate.utm.my");';
        echo 'window.location.href = "profile-edit.php";'; // Change the URL as needed
        echo '</script>';
        exit(); // Exit the script
    }
    
    $emailExistsQuery = "SELECT COUNT(*) FROM User WHERE email = '$email' AND userID != $userID";
    $usernameExistsQuery = "SELECT COUNT(*) FROM User WHERE username = '$username' AND userID != $userID";

    $emailExistsResult = mysqli_query($con, $emailExistsQuery);
    $usernameExistsResult = mysqli_query($con, $usernameExistsQuery);

    if (!$emailExistsResult || !$usernameExistsResult) {
        echo "Error checking email and username existence: " . mysqli_error($con);
        exit(); // Exit the script
    }

    $emailExists = mysqli_fetch_row($emailExistsResult)[0];
    $usernameExists = mysqli_fetch_row($usernameExistsResult)[0];


    if ($emailExists > 0) {
        echo '<script>';
        echo 'alert("Email already exists. Please choose a different one.");';
        echo 'window.location.href = "profile-edit.php";'; // Change the URL as needed
        echo '</script>';
        exit(); // Exit the script
    } elseif ($usernameExists > 0) {
        echo '<script>';
        echo 'alert("Username already exists. Please choose a different one.");';
        echo 'window.location.href = "profile-edit.php";'; // Change the URL as needed
        echo '</script>';
        exit(); // Exit the script
    }
    // Check for empty values and construct the update queries
    $updateProfile = "UPDATE admin_profiles 
                      SET full_name = '$fullname', phone = '$contactNo', gender = '$gender',
                          age = $age, street = '$street', city = '$city', state = '$state',
                          zip_code = '$zip_code'
                      WHERE admin_id = $userID";

    $updateUser = "UPDATE User SET username = '$username', email = '$email' WHERE userID = $userID";

    // Execute the update queries
    if (mysqli_query($con, $updateProfile) && mysqli_query($con, $updateUser)) {
        echo '<script>';
        echo 'alert("Profile updated successfully!");';
        echo 'window.location.href = "viewprofile.php";';
        echo '</script>';
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>