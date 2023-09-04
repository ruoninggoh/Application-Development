<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Fetch the list of users
$sqlGetUsers = "SELECT * FROM User";
$resultGetUsers = mysqli_query($con, $sqlGetUsers);

// Handle user management actions (e.g., add, edit, delete)
// Fetch the list of users based on search criteria
$searchCriteria = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sqlGetUsers = "SELECT * FROM User 
                WHERE username LIKE '%$searchCriteria%' 
                OR role LIKE '%$searchCriteria%' 
                OR userID LIKE '%$searchCriteria%'";
$resultGetUsers = mysqli_query($con, $sqlGetUsers);

mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="manageuser.css">
    <?php include("./adminHeader.html");?>
</head>

<body>
    <div class="container mt-5">
        <!-- Add a back button to return to the dashboard -->
        <a href="dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h2>User Management</h2>
        <!-- Add a search form -->
        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search by Username, Role, or ID">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <!-- Display users in a table -->
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultGetUsers)): ?>
                    <tr>
                        <td><?php echo $row['userID']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td><button class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button></td>
                        <td><button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Add a form for adding new users -->
        <h3>Add New User</h3>
        <form action="add_user.php" method="POST">
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


</html>
