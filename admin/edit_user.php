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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update user details in the database
    $newUsername = mysqli_real_escape_string($con, $_POST['newUsername']);
    $newEmail = mysqli_real_escape_string($con, $_POST['newEmail']);
    $newRole = mysqli_real_escape_string($con, $_POST['newRole']);

    $sqlUpdateUser = "UPDATE User SET username = '$newUsername', email = '$newEmail', role = '$newRole' WHERE userID = '$userID'";
    if (mysqli_query($con, $sqlUpdateUser)) {
        $updateSuccess = true; // Update was successful
        //header("Location: userManagement.php"); // Comment this line to show the JavaScript alert
    } else {
        echo "Error updating user: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
<!-- Add an HTML form for editing user details here -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php include("./adminHeader.html"); ?>
</head>

<body>
    <div class="container mt-5">
        <h3>Edit User Details</h3>
        <?php if ($updateSuccess) : ?>
            <script>
                alert("User details updated successfully.");
                window.location.href = "userManagement.php"; // Redirect after showing the alert
            </script>
        <?php endif; ?>
        <form action="" method="POST">
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
                <input type="text" class="form-control" id="newRole" name="newRole"
                    value="<?php echo $userDetails['role']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update User</button>
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
    </style>
</body>

</html>
