<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

$recordsPerPage = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Fetch the list of users based on search criteria, filter criteria, and pagination
$searchCriteria = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$filterCriteria = isset($_GET['filter']) ? mysqli_real_escape_string($con, $_GET['filter']) : '';
$offset = ($page - 1) * $recordsPerPage;

// SQL query for filtering by role
$sqlFilter = "SELECT DISTINCT role FROM User";
$resultFilter = mysqli_query($con, $sqlFilter);

// Fetch the list of users based on search criteria, filter criteria, and pagination
$sqlGetUsers = "SELECT * FROM User WHERE (username LIKE '%$searchCriteria%' )";

if (!empty($filterCriteria)) {
    $sqlGetUsers .= " AND role = '$filterCriteria'";
}

$sqlGetUsers .= " LIMIT $offset, $recordsPerPage";

$resultGetUsers = mysqli_query($con, $sqlGetUsers);

// Count the total number of users based on the search criteria and filter criteria (without LIMIT)
$sqlCountUsers = "SELECT COUNT(*) as total FROM User WHERE (username LIKE '%$searchCriteria%' )";

if (!empty($filterCriteria)) {
    $sqlCountUsers .= " AND role = '$filterCriteria'";
}

$resultCountUsers = mysqli_query($con, $sqlCountUsers);
$rowCount = mysqli_fetch_assoc($resultCountUsers)['total'];

$totalPages = ceil($rowCount / $recordsPerPage);

mysqli_close($con);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="manageuser.css">
    <?php include("./adminHeader.html"); ?>
</head>

<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-secondary mb-3">
            <i class="uil uil-angle-left"></i>Back to Dashboard
        </a>
        <h2><br>User Management</h2>

        <form action="" method="GET" class="form-inline">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Username"
                    value="<?php echo htmlspecialchars($searchCriteria); ?>">
            </div>
            <div class="form-group mx-2">
                <select class="form-control" name="filter">
                    <option value="" <?php echo ($filterCriteria == '') ? 'selected' : ''; ?>>All Roles</option>
                    <?php while ($row = mysqli_fetch_assoc($resultFilter)): ?>
                        <option value="<?php echo $row['role']; ?>" <?php echo ($filterCriteria == $row['role']) ? 'selected' : ''; ?>>
                            <?php echo $row['role']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>

        </form>

        <div class="d-flex justify-content-end mb-3">
            <a href="../index.php?controller=UserManagementController&action=addUser" class="btn btn-success">
                <i class="uil uil-user-plus"></i> New User
            </a>
        </div>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($resultGetUsers) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($resultGetUsers)): ?>
                        <tr>
                            <td>
                                <?php echo $row['userID']; ?>
                            </td>
                            <td>
                                <?php echo $row['username']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['role']; ?>
                            </td>
                            <td><a href="../index.php?controller=UserManagementController&action=editUser&userID=<?php echo $row['userID']; ?>" class="btn btn-primary">Edit</a></td>
                            <td><button class="btn btn-danger delete-user" data-user-id="<?php echo $row['userID']; ?>">Delete</buuton></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            <?php endif; ?>
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll(".delete-user");
            deleteButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    const userID = button.getAttribute("data-user-id");
                    const confirmation = confirm("Are you sure you want to delete this user?");
                    if (confirmation) {
                        // Redirect to a PHP script to handle the deletion
                        window.location.href = `../index.php?controller=UserManagementController&action=deleteUser&userID=${userID}`;
                    }
                });
            });
        });
    </script>
</body>

</html>
