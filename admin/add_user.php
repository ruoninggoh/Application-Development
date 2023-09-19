<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to add a new user
    $newUsername = mysqli_real_escape_string($con, $_POST['newUsername']);
    $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
    $newRole = mysqli_real_escape_string($con, $_POST['newRole']);

    // You should hash the password before storing it in the database for security
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sqlAddUser = "INSERT INTO User (username, email, password, role) 
                   VALUES ('$newUsername', '$newEmail', '$hashedPassword', '$newRole')";

    if (mysqli_query($con, $sqlAddUser)) {
        // User added successfully, you can redirect to the user management page
        header("Location: userManagement.php");
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
<!-- Add an HTML form for adding a new user here -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php include("./adminHeader.html"); ?>
    <style>
        /* Style for the Add New User form */
        body {
            background-image: url("../images/signin.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Center the form in the middle of the page */
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Responsive styles for smaller screens */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3>Add New User</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="newUsername">Username:</label>
                <input type="text" class="form-control" id="newUsername" name="newUsername" required>
            </div>
            <div class="form-group">
                <label for="newEmail">Email:</label>
                <input type="email" class="form-control" id="newEmail" name="newEmail" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Password:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="newRole">Role:</label>
                <input type="text" class="form-control" id="newRole" name="newRole" required>
            </div>
            <button type="submit" class="btn btn-success">Add User</button>
        </form>
    </div>
</body>

</html>