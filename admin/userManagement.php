<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

$recordsPerPage = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Fetch the list of users based on search criteria and pagination
$searchCriteria = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$offset = ($page - 1) * $recordsPerPage;
$sqlGetUsers = "SELECT * FROM User 
                WHERE username LIKE '%$searchCriteria%' 
                OR role LIKE '%$searchCriteria%'
                LIMIT $offset, $recordsPerPage";
$resultGetUsers = mysqli_query($con, $sqlGetUsers);

// Count the total number of users based on the search criteria (without LIMIT)
$sqlCountUsers = "SELECT COUNT(*) as total FROM User 
                  WHERE username LIKE '%$searchCriteria%' 
                  OR role LIKE '%$searchCriteria%'";
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
    <link rel="stylesheet" href="manageuser.css">
    <?php include("./adminHeader.html"); ?>
</head>

<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <h2>User Management</h2>
        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search by Username, Role"
                    value="<?php echo htmlspecialchars($searchCriteria); ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
            <input type="hidden" name="page" value="<?php echo $page; ?>">
        </form>
        <div class="d-flex justify-content-end mb-3">
            <a href="add_user.php" class="btn btn-success"><i class="fas fa-plus"></i> New User</a>
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
                        <td><a href="edit_user.php?userID=<?php echo $row['userID']; ?>" class="btn btn-primary"><i
                                    class="fas fa-edit"></i> Edit</a></td>
                        <td><button class="btn btn-danger delete-user" data-user-id="<?php echo $row['userID']; ?>"><i
                                    class="fas fa-trash"></i> Delete</button></td>
                    </tr>
                <?php endwhile; ?>
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
                        window.location.href = `delete_user.php?userID=${userID}`;
                    }
                });
            });
        });
    </script>
</body>

</html>