<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

?>
<!-- Add an HTML form for adding a new user here -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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

        .custom-link {
            text-decoration: none;
            color: #007bff;
            /* Change the color to your preferred color */
            font-size: 18px;
            /* Adjust the font size as needed */
            padding: 5px 10px;
            /* Add padding to the link */
            background-color: #f8f9fa;
            /* Change the background color if necessary */
            border: 1px solid #ccc;
            /* Add a border if desired */
            border-radius: 4px;
            /* Add rounded corners */
        }

        .custom-link:hover {
            background-color: #e2e6ea;
            /* Change the background color on hover */
            color: #0056b3;
            /* Change the text color on hover */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <a href="userManagement.php" class="custom-link">
            <i class="uil uil-angle-left"></i> Go Back
        </a>
        <h3><br>Add New User</h3>
        <form action="../index.php" method="post">
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
                <input type="password" class="form-control" id="newPassword" name="newPassword" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="newRole">Role:</label>
                <select class="form-control" id="newRole" name="newRole" required>
                    <option value="select">---Select a role---</option>
                    <option value="Patient">Patient</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Staff">Staff</option>
                    <!-- Add more role options as needed -->
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add User</button>
            <input type="hidden" name="action" value="addUser" />
            <input type="hidden" name="controller" value="UserManagementController" />
        </form>
    </div>
</body>

</html>