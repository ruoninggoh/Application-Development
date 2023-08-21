<?php

include("connectdb.php");

// Hash the password using password_hash
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Register as a user with default role "Patient"
$defaultRole = "Patient"; // Set default role to "Patient"
$sql = "INSERT INTO User(username, password, email, role)
        VALUES ('$_POST[username]', '$hashedPassword', '$_POST[email]', '$defaultRole')";

if (!mysqli_query($con, $sql)) {
    die('Error' . mysqli_connect_error());
} else {
    $javascriptCode = "
        <script>
            var promptMessage = 'Sign up successful. Please sign in again.';
            var signInAgain = confirm(promptMessage);

            if (signInAgain) {
                // Redirect to the sign-in page
                window.location.href = '../signin.php';
            }
        </script>
    ";

    echo $javascriptCode;
    exit();
}
?>
