<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

if (isset($_GET['userID'])) {
    $userID = mysqli_real_escape_string($con, $_GET['userID']);

    // Fetch user details by userID and populate an edit form
    $sqlGetUserDetails = "SELECT * FROM User WHERE userID = '$userID'";
    $resultGetUserDetails = mysqli_query($con, $sqlGetUserDetails);
    $userDetails = mysqli_fetch_assoc($resultGetUserDetails);
}

$updateSuccess = false; // Flag to track whether the update was successful

?>
<!-- Add an HTML form for editing user details here -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <?php include("./adminHeader.html"); ?>
</head>

<body>
    <div class="container mt-5">
        <a href="userManagement.php" class="custom-link">
            <i class="uil uil-angle-left"></i> Go Back
        </a>
        <h3><br>Edit User Details</h3>
        <?php if ($updateSuccess): ?>
            <script>
                alert("User details updated successfully.");
                window.location.href = "userManagement.php"; // Redirect after showing the alert
            </script>
        <?php endif; ?>
        <form action="../index.php" method="POST">
            <div class="form-group">
                <label for="newUsername">Username:</label>
                <input type="text" class="form-control" id="newUsername" name="newUsername"
                    value="<?php echo $userDetails['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="newEmail">Email:</label>
                <input type="email" class="form-control" id="newEmail" name="newEmail"
                    value="<?php echo $userDetails['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="newRole">Role:</label>
                <select class="form-control" id="newRole" name="newRole" required>
                    <option value="select">---Select a role---</option>
                    <option value="Patient" <?php echo ($userDetails['role'] == 'Patient') ? 'selected' : ''; ?>>Patient
                    </option>
                    <option value="Doctor" <?php echo ($userDetails['role'] == 'Doctor') ? 'selected' : ''; ?>>Doctor
                    </option>
                    <option value="Staff" <?php echo ($userDetails['role'] == 'Staff') ? 'selected' : ''; ?>>Staff
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update User</button>
            <input type="hidden" name="userID" value="<?php echo $userID ?>" />
            <input type="hidden" name="action" value="editUser" />
            <input type="hidden" name="controller" value="UserManagementController" />
        </form>
    </div>

    <style>
        /* Add your CSS styles here */
        body {
            background-image: url("../images/signin.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
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
</body>

</html>