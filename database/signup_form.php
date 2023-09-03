<?php

include("connectdb.php");

// Get user input from POST
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$confirmPassword = mysqli_real_escape_string($con, $_POST['confirmPassword']); // Add this line
$email = mysqli_real_escape_string($con, $_POST['email']);

// Check if the passwords match
if ($password !== $confirmPassword) {
    // Passwords don't match, redirect to signup page with error message
    header("Location: ../signup.php?error=password_mismatch");
    exit();
}
// Hash the password using password_hash
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$checkUsernameQuery = "SELECT username FROM User WHERE username = '$username'";
$checkUsernameResult = mysqli_query($con, $checkUsernameQuery);

if (!$checkUsernameResult) {
    die('Error: ' . mysqli_error($con));
}

if (mysqli_num_rows($checkUsernameResult) > 0) {
    // Username already exists, set a flag
    $usernameTaken = true;
} else {
    // Check if the email already exists
    $checkEmailQuery = "SELECT email FROM User WHERE email = '$email'";
    $checkEmailResult = mysqli_query($con, $checkEmailQuery);

    if (!$checkEmailResult) {
        die('Error: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($checkEmailResult) > 0) {
        // Email already exists, set a flag
        $emailTaken = true;
    } else {
        // Username and email are both unique, proceed with registration
        $defaultRole = "Patient"; // Set default role to "Patient"
        $insertQuery = "INSERT INTO User(username, password, email, role)
                        VALUES ('$username', '$hashedPassword', '$email', '$defaultRole')";

        if (!mysqli_query($con, $insertQuery)) {
            die('Error: ' . mysqli_error($con));
        } else {
            $signupSuccessful = true;
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <script>
        window.onload = function() {
            <?php if (isset($usernameTaken) && $usernameTaken) { ?>
                alert("Username '<?php echo $username; ?>' is already taken. Please choose another username.");
                window.location.href = '../signup.php';
            <?php } else if (isset($emailTaken) && $emailTaken) { ?>
                alert("Email '<?php echo $email; ?>' is already registered. Please use a different email.");
                window.location.href = '../signup.php';
            <?php } else if (isset($signupSuccessful) && $signupSuccessful) { ?>
                var promptMessage = 'Sign up successful. Please sign in again.';
                var signInAgain = confirm(promptMessage);

                if (signInAgain) {
                    // Redirect to the sign-in page
                    window.location.href = '../signin.php';
                }
            <?php } ?>
        }
    </script>
</head>
<body>
</body>
</html>
