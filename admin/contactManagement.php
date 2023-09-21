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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply some styling to the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Style the container */
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            min-width: 700px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
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
            display: inline-block;
            vertical-align: middle;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            /* Adjust the spacing between the icon and text */
            padding: 7px 10px;
            /* Add padding for better visual appearance */
            border: 1px solid #ffc107;
            /* Yellow border */
            border-radius: 5px;
            /* Add rounded corners */
            background-color: #ffc107;
            /* Yellow background color */
            transition: background-color 0.3s, color 0.3s;
        }

        .reply-link:hover {
            background-color: #d39e00;
            /* Darker yellow on hover */
            color: #fff;
            /* Change text color on hover */
            text-decoration: none;
        }

        .reply-icon {
            font-size: 16px;
            /* Adjust the icon size */
            vertical-align: middle;
        }

        .delete-btn {
            color: #fff;
            background-color: #dc3545;
            /* Red background color */
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c82333;
            /* Hover background color (a darker red) */
        }

        .delete-btn .delete-icon {
            margin-right: 5px;
            /* Adjust the spacing between icon and text */
        }
        .table-container {
                overflow-x: auto; /* Add horizontal scrollbar if necessary */
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

        <div class="table-container">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th colspan="2">Action</th> <!-- Add the Action column -->
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
                        echo '<td><button class="delete-btn" data-contactFormID="' . $row['contactFormID'] . '"><i class="uil uil-trash delete-icon"></i>Delete</button></td>';
                        echo '</tr>';
                    }
                } else {
                    // No results found, display a message
                    echo '<tr><td colspan="7">No results found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Add this script at the bottom of your HTML file -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Handle delete button click
                $('.delete-btn').click(function () {
                    var contactFormID = $(this).data('contactformid');

                    if (confirm('Are you sure you want to delete this submission?')) {
                        // Send an AJAX request to delete the submission
                        $.ajax({
                            url: 'delete_submission.php',
                            type: 'POST',
                            data: { id: contactFormID },
                            success: function (response) {
                                // Check the response from the server
                                if (response.success) {
                                    // Deletion was successful, display a message
                                    alert('Success: ' + response.message);

                                    // Reload the page or update the table as needed
                                    location.reload(); // Reload the page after deletion
                                } else {
                                    // Deletion failed, display an error message
                                    alert('Error: ' + response.message);
                                }
                            },
                            error: function () {
                                alert('Error deleting submission.');
                            }
                        });
                    }
                });
            });
        </script>

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