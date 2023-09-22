<?php
include('../database/connectdb.php');

$response = array(); // Initialize a response array

if (isset($_POST['id'])) {
    $contactFormID = $_POST['id'];

    // SQL query to delete the submission
    $sqlDeleteSubmission = "DELETE FROM contactForm WHERE contactFormID = $contactFormID";

    if (mysqli_query($con, $sqlDeleteSubmission)) {
        // Deletion successful
        $response['success'] = true;
        $response['message'] = 'Submission deleted successfully';
    } else {
        // Deletion failed
        $response['success'] = false;
        $response['message'] = 'Error deleting submission: ' . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request';
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
