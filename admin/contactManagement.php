<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

$recordsPerPage = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Fetch the list of contact form submissions based on search criteria, filter criteria, and pagination
$searchCriteria = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$offset = ($page - 1) * $recordsPerPage;

// SQL query for filtering by name or subject
$sqlGetSubmissions = "SELECT * FROM contactForm WHERE (Name LIKE '%$searchCriteria%' OR Subject LIKE '%$searchCriteria%') LIMIT $offset, $recordsPerPage";
$resultGetSubmissions = mysqli_query($con, $sqlGetSubmissions);

// Count the total number of contact form submissions based on the search criteria (without LIMIT)
$sqlCountSubmissions = "SELECT COUNT(*) as total FROM contactForm WHERE (Name LIKE '%$searchCriteria%' OR Subject LIKE '%$searchCriteria%')";
$resultCountSubmissions = mysqli_query($con, $sqlCountSubmissions);
$rowCount = mysqli_fetch_assoc($resultCountSubmissions)['total'];

$totalPages = ceil($rowCount / $recordsPerPage);

mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <?php include("./adminHeader.html"); ?>
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            min-width: 900px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #555;
        }

        .table {
            background-color: #fff;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 25px;
        }

        .thead-dark th {
            background-color: #343a40;
            text-align: center;
            color: #fff;
        }

        /* Style for the Reply link */
        .reply-link {
            color: #007bff;
            text-decoration: none;
        }

        .reply-link:hover {
            text-decoration: underline;
        }

        /* Pagination styles */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            color: #007BFF;
            border: 1px solid #007BFF;
        }

        .page-link:hover {
            background-color: #007BFF;
            color: #fff;
            border: 1px solid #007BFF;
        }

        .page-item.active .page-link {
            background-color: #007BFF;
            color: #fff;
            border: 1px solid #007BFF;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input[type="text"] {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .input-group input[type="text"]:focus {
            border-color: #007BFF;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .reply-link {
            color: #fff;
            /* Text color */
            background-color: #ffc107;
            /* Yellow background color */
            text-decoration: none;
            border: 1px solid #ffc107;
            /* Border color */
            padding: 8px 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .reply-link:hover {
            background-color: #d39e00;
            /* Hover background color (a darker yellow) */
            color: #fff;
            /* Hover text color */
            text-decoration: none;
        }

        .reply-link .reply-icon {
            margin-right: 5px;
            /* Adjust the spacing between icon and text */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-secondary mb-5"><i class="uil uil-angle-left"></i> Back to Dashboard</a>
        <h2>Contact Management</h2>

        <!-- Search form -->
        <form action="" method="GET" class="mb-5">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name or Subject">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>


        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Action</th> <!-- Add the Action column -->
                </tr>
            </thead>
            <tbody>
    <?php
    // Check if there are search results
    if (mysqli_num_rows($resultGetSubmissions) > 0) {
        // Display the table headers and results
        while ($row = mysqli_fetch_assoc($resultGetSubmissions)) {
            echo '<tr>';
            echo '<td>' . $row['contactFormID'] . '</td>';
            echo '<td>' . $row['Name'] . '</td>';
            echo '<td>' . $row['Email'] . '</td>';
            echo '<td>' . $row['phoneNo'] . '</td>';
            echo '<td>' . $row['Subject'] . '</td>';
            echo '<td>' . $row['Description'] . '</td>';
            echo '<td><a href="mailto:' . $row['Email'] . '?subject=Re: ' . $row['Subject'] . '" class="reply-link"><i class="uil uil-message reply-icon"></i>Reply</a></td>';
            echo '</tr>';
        }
    } else {
        // No results found, display a message
        echo '<tr><td colspan="7">No results found.</td></tr>';
    }
    ?>
</tbody>

        </table>

        <!-- Pagination -->
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link"
                        href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchCriteria); ?>">Previous</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchCriteria); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link"
                        href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchCriteria); ?>">Next</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>