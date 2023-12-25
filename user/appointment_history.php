<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../database/signin_form.php");
    exit();
}

$userID = $_SESSION['userID'];
?>


<!DOCTYPE html>
<html>

<head>
    <title>Appointment History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            border: 2px solid #ccc;
            text-align: center;
        }

        th {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            padding: 20px;
            border: 2px solid #ccc;
            background-color: #465981;
            font-weight: bold;
            color: white;
        }

        

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
            
        }

        .modal-content {
            background-color: #F9F7F7;
            border-radius: 5px;
            padding: 20px;
            width: 600px;
            margin: 100px auto;
            max-height: 70%;
            
        }
        header{
            position: relative;
            font-size: 23px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            margin-top: -20px;
        }
        .form.second.secActive{
            margin-top: -50px;
        }
        form{
            background-color: #F9F7F7;
            margin-top: 16px;
            min-height: 17px;
            overflow: hidden;
            
        }
        form .form{
            position: absolute;
            background-color: #fff;
            transition:0.3s ease;
        }
        .form.first{
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }
        .fields{
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-right: 30px;
        }
        form .title{
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 500;
            margin:  6px 0;
            color: #333;
        }
        .fields .input-field{
            display: flex;
            width: calc(100% / 3 - 15px);
            flex-direction: column;
            margin: 4px 0;
        }
        .input-field input{
            outline: none;
            font-size: 14px;
            font-weight: 400;
            color: #333;
            border-radius: 5px;
            border: 1px solid #ffffff;
            padding: 0 15px;
            height: 42px;
            margin: 8px 0;
        }
        .input-field label{
            font-size:12px;
            font-weight:500;
            color:#341111;
        }
        form button{
            font-size: 14px;
            font-weight: 400;
        }
        .editBtn, .saveBtn{
            margin-top: 20px;
            background-color: #112D4E;
            transition: 0.3s linear;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            max-width: 150px;
            color: #fff;
            cursor: pointer;
            height: 30px;
            justify-content: center;
            
        }

        .editBtn:hover, .saveBtn:hover{
            background-color: #3F72AF;
        }
        form button i{
            margin: 0 6px;
        }
        .input-field input:is(:focus, :valid){
            box-shadow: 0 3px 6px rgba(0,0,0,0.13);
        }
        #reason{
            height: 100px;
            font-size: 14px;
            padding: 20px 15px;
            width: 500px;
            margin-top: 10px;
            text-align: left;
            outline: none;
            border-radius: 5px;
            border: 1px solid #aaa;
            min-width: 300px;
        }
        .form.second{
            opacity: 0;
            pointer-events: none;
            transform: translateX(100%);
        }
        @media (max-width: 750px){
            form{
                overflow-y: scroll;
            }
            form::-webkit-scrollbar{
                display: none;
            }
            form .fields .input-field{
                width: calc(100% / 2 - 15px);
            }
        }
        @media (max-width: 550px){
            form .fields .input-field{
                width: 100%;
            }
        }
        .form.secActive{
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }
        .form.first.hidden{
            display: none;
        }
        .form.second .input-field{
            width: calc(50% -15px);
            margin: 4px 0;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
        $(document).ready(function() {
            $('.details-button').click(function() {
                var reason = $(this).data('reason');
                var modalID = $(this).data('modal-id');
                //$('#reasonText').text(reason);
                //$('.modal').css('display', 'none');
                $('#' + modalID).css('display', 'block');
                $('.editBtn').click(function(){
                    console.log("Edit button clicked");
                    $('.form.first').removeClass('secActive');
                    $('.form.second').addClass('secActive');
                    $('.form.first').addClass('hidden');
                });
                    }
                );

            $('.closeModal').click(function() {
                console.log("close button pressed");
                var modalID = $(this).data('modal-id');
                $('#' + modalID).css('display', 'none');
                $('.form.first').removeClass('hidden');
                $('.form.second').removeClass('secActive');
            });

            $(document).ready(function() {
            var handledDownload = false; // Variable to track "Download" button click

            $('.report-button').click(function(){
                var appointID = $(this).data('appointID');
                var modalID = $(this).data('modal-id');
                console.log("Download report button clicked");
                $.ajax({
            type: "POST",
            url: "checkDiagnosis.php", // Create a new PHP file for this purpose
            data: {
                appointID: appointID
            },
            success: function(response) {
                if (response === "data_found") {
                    // Data exists, allow the download action
                    window.location.href = "../doctor/downloadreport.php?appointID=" + appointID;
                } else {
                    // Data does not exist, show an error pop-up
                    alert("No data found for this appointment.please insert the data first.");
                }
            }
        });
        e.preventDefault(); // Prevent the default link behavior


            })
                
        });
                        
    });

    function showErrorMessage() {
        alert("You can only download the report for approved appointments.");
    }

    </script>
    
</head>

<body>
    <?php
    include("userHeader.php");
    $conn = mysqli_connect("localhost", "root", "", "unihealth");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $userID = $_SESSION['userID'];
    $sql = "SELECT a.*, u.*
            FROM appointment AS a
            INNER JOIN user AS u ON a.user_id = u.userID
            WHERE a.user_id = $userID";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        $error = "Error: ". mysqli_error($conn);
    }

    
    ?>

    <div class="userHistory" style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Report</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . ++$index . "</td>";
                    echo "<td>" . $row['_date'] . "</td>";
                    echo "<td>" . $row['_time'] . "</td>";
                    echo "<td><button style='border:none; background-color: white;' class='details-button' data-reason='" . $row['reason'] . "' data-modal-id='reasonModal$index'><i class='uil uil-info-circle' style='font-size:35px'></i></button></td>";
                    echo "<td>" . $row['requestStatus'] . "</td>";
                    if ($row['requestStatus'] === "Approved") {
                        echo "<td><a href='../doctor/downloadreport.php?appointID=" . $row['appointID'] . "' style='text-decoration:none;'><button style='border:none; background-color: white;' class='report-button' data-appointID='" . $row['appointID'] . "' data-modal-id='reasonModal$index'><i class='uil uil-file-download-alt' style='font-size: 35px'></i></button></a></td>";
                    } else {
                        echo "<td><button style='border:none; background-color: white;' class='report-button' data-appointID='" . $row['appointID'] . "' data-modal-id='reasonModal$index' onclick='showErrorMessage()'><i class='uil uil-file-download-alt' style='font-size: 35px'></i></button></td>";
                    }
                                        echo "</tr>";

                    
                    $name = $row['full_name'];
                    $age = $row['age'];
                    $gender = $row['gender'];
                    $phone = $row['phone'];
                    $date = $row['_date'];
                    $time = $row['_time'];
                    $reason = $row['reason'];
                    
                    echo "<div class='modal' id='reasonModal$index' style='display: none;'>";
                    echo "<div class='modal-content'>";
                    echo "<span class='closeModal' id='closeModal' data-modal-id='reasonModal$index' style='float: right; cursor: pointer;'>&times;</span>";
                    
                    echo "<form>";
                    echo "<div class='form first'>";
                    echo "<header>Appointment Details</header>";
                    echo "<span class='title'><b>Personal Details</b></span>";
                    echo "<div class ='fields'>";
                        // <!-- Name -->
                    echo "<div class ='input-field'>";
                    echo "<label>Full Name</label>";
                    echo "<input type= 'text' name='name1' value='$name' readonly>";
                    echo "</div>";
                
                        // <!-- Age -->
                    echo "<div class ='input-field'>";
                    echo "<label>Age</label>";
                    echo "<input type= 'text' name='age1' value='$age' readonly>";
                    echo "</div>";
                
                    // <!-- Phone Number -->
                    echo "<div class ='input-field'>";
                    echo "<label>Phone Number</label>";
                    echo "<input type= 'text' name='phone1' value='$phone' readonly>";
                    echo "</div>";
                
                    // <!-- Gender -->
                    echo "<div class ='input-field'>";
                    echo "<label>Gender</label>";
                    echo "<input type= 'text' name='gender1' value='$gender' readonly>";
                    echo "</div>";
                    
                
                    
                    // <!-- Date -->
                    echo "<div class ='input-field'>";
                    echo "<label>Date</label>";
                    echo "<input type= 'text' name='date1' value='$date' readonly>";
                    echo "</div>";
                
                    // <!-- Time -->
                    echo "<div class ='input-field'>";
                    echo "<label>Time</label>";
                    echo "<input type= 'text' name='time1' value='$time' readonly>";
                    echo "</div>";
                    echo "</div>";
                    
                    // <!-- Reason -->
                    echo "<div><span class='title'><b>Appointment Details</b></span></div>";
                    echo "<div class ='fields'>";
                    echo "<div class ='input-field'>";
                    echo "<label>Reason</label>";
                    echo "<textarea id='reason' name='reason1' rows='4' value='$reason' readonly>$reason</textarea>";
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='button'>";
                    echo "<button type='button' class='editBtn'>";
                    echo "<i class='uil uil-edit'></i>";
                    echo "<span class='btnText'>Edit</span>";
                    echo "</button>";
                    echo "</div>";
                    echo "</div>"; 
                    echo "</form>";

                    // editing page
                    echo "<form action='update_appointment.php' method='POST'>";
                    echo "<div class='form second'>";
                    echo "<header>Appointment Details</header>";
                    echo "<span class='title'><b>Personal Details</b></span>";
                    echo "<div class ='fields'>";
                        // <!-- Name -->
                    echo "<div class ='input-field'>";
                    echo "<label>Full Name</label>";
                    echo "<input type= 'text' name='name' value='$name' readonly>";
                    echo "</div>";
                
                        // <!-- Age -->
                    echo "<div class ='input-field'>";
                    echo "<label>Age</label>";
                    echo "<input type= 'text' name='age' value='$age' readonly>";
                    echo "</div>";
                
                    // <!-- Phone Number -->
                    echo "<div class ='input-field'>";
                    echo "<label>Phone Number</label>";
                    echo "<input type= 'text' name='phone' value='$phone' readonly>";
                    echo "</div>";
                
                    // <!-- Gender -->
                    echo "<div class ='input-field'>";
                    echo "<label>Gender</label>";
                    echo "<input type= 'text' name='gender' value='$gender' readonly>";
                    echo "</div>";
                    
                
                    
                    // <!-- Date -->
                    echo "<div class ='input-field'>";
                    echo "<label>Date</label>";
                    echo "<input type= 'text' name='date' value='$date' >";
                    echo "</div>";
                
                    // <!-- Time -->
                    echo "<div class ='input-field'>";
                    echo "<label>Time</label>";
                    echo "<input type= 'text' name='time' value='$time' >";
                    echo "</div>";
                    echo "</div>";
                    
                    // <!-- Reason -->
                    echo "<div><span class='title'><b>Appointment Details</b></span></div>";
                    echo "<div class ='fields'>";
                    echo "<div class ='input-field'>";
                    echo "<label>Reason</label>";
                    echo "<textarea id='reason' name='reason' rows='4' value='$reason'>$reason</textarea>";
                    echo "<input type='hidden' name='appointment_id' value='" . $row['appointID'] . "'>";
                    echo "<input type='hidden' name='requestStatus' value='" . $row['requestStatus'] . "'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='button'>";
                    echo "<button type='submit' class='saveBtn'>";
                    echo "<i class='uil uil-check-circle'></i>";
                    echo "<span class='btnText'>Save</span>";
                    echo "</button>";
                    echo "</div>";

                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                }
                ?>
            </tbody>
        </table>
                
            
    </div>
</body>
</html>