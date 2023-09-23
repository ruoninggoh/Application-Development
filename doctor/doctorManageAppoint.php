<?php
session_start();
include("doctorHeader.php");

?>
<!DOCTYPE html>
<html>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #F9F7F7;
        border-radius: 5px;
        padding: 20px;
        width: 600px;
        margin: 100px auto;
        max-height: 70%;

    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    button {
        margin: 5px;
    }

    header {
        position: relative;
        font-size: 23px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        margin-top: -20px;
    }

    form {
        background-color: #F9F7F7;
        margin-top: 16px;
        min-height: 17px;
        overflow: hidden;

    }

    .fields {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-right: 30px;
    }

    form .title {
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 500;
        margin: 6px 0;
        color: #333;
    }

    .fields .input-field {
        display: flex;
        width: calc(100% / 3 - 15px);
        flex-direction: column;
        margin: 4px 0;
    }

    .input-field input {
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

    .input-field label {
        font-size: 12px;
        font-weight: 500;
        color: #341111;
    }

    .input-field input:is(:focus, :valid) {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.13);
    }

    #reason {
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

    @media (max-width: 750px) {
        form {
            overflow-y: scroll;
        }

        form::-webkit-scrollbar {
            display: none;
        }

        form .fields .input-field {
            width: calc(100% / 2 - 15px);
        }
    }

    @media (max-width: 550px) {
        form .fields .input-field {
            width: 100%;
        }
    }
</style>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Manage Appointment</title>
    <link rel="stylesheet" type="text/css" href="../css/manageAppoint.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
        function toggleTab(tabText) {
            var tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(function(tabContent) {
                tabContent.style.transition = 'opacity 0.3 ease';
                tabContent.style.opacity = '0';
                tabContent.style.display = 'none';

            });

            var selectedTabContent = document.querySelector('.tab-content[data-tab="' + tabText + '"]');
            selectedTabContent.style.display = 'block';
            setTimeout(function() {
                selectedTabContent.style.opacity = '1';
            }, 10);


            var tabs = document.querySelectorAll('.tab');
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });

            var selectedTab = document.querySelector('.tab[data-tab="' + tabText + '"]');
            selectedTab.classList.add('active');
        }

        function reloadPage() {
            location.reload();
        }



        $(document).ready(function() {
            $('.pending-details-button').click(function() {
                event.preventDefault();
                var modalID = $(this).data('modal-id');
                $('#' + modalID).css('display', 'block');
            });

            $('.my-details-button').click(function() {
                event.preventDefault();
                console.log('my detial button clicked');
                var modalID = $(this).data('modal-id');
                $('#' + modalID).css('display', 'block');
            });

            $('.closeModal').click(function() {
                console.log('close button clicked');
                var modalID = $(this).data('modal-id');
                $('#' + modalID).css('display', 'none');
            });


            /* */
            $("table").on("click", ".approve", function() {
                console.log("Approved clicked");
                var appointID = $(this).data("appointid");
                //var $row = $(this).closest("tr");
                var date = $(this).closest("tr").find("td:eq(2)").text();
                var time = $(this).closest("tr").find("td:eq(3)").text();

                $.ajax({
                    type: "POST",
                    url: "updateStatus.php",
                    data: {
                        appointID: appointID,
                        status: "Approved"
                    },
                    success: function(response) {
                        if (response === "success") {
                            reloadPage();
                        }
                    }
                });

                $("table tbody tr").each(function() {
                    var $currentRow = $(this);
                    var rowDate = $currentRow.find("td:eq(2)").text();
                    var rowTime = $currentRow.find("td:eq(3)").text();

                    if (rowDate === date && rowTime === time && appointID !== $currentRow.find(".reject").data("appointid")) {
                        var rejectLink = $currentRow.find(".reject");
                        var appointIDToReject = rejectLink.data("appointid");

                        if (rejectLink.length > 0) {
                            $.ajax({
                                type: "POST",
                                url: "updateStatus.php",
                                data: {
                                    appointID: appointIDToReject,
                                    status: "Rejected"
                                },
                            });
                        }
                    }
                });
            });

            $("table").on("click", ".reject", function() {
                console.log("Reject Clicked");
                var appointID = $(this).data("appointid");

                $.ajax({
                    type: "POST",
                    url: "updateStatus.php",
                    data: {
                        appointID: appointID,
                        status: "Rejected"
                    },
                    success: function(response) {
                        if (response === "success") {
                            reloadPage();
                        }
                    }
                })
            })
        });



        $(document).ready(function() {
        var handledInsert = false; // Variable to track "Insert" button click
        var handledDownload = false; // Variable to track "Download" button click


    $("table").on("click", ".insert", function() {
        if (handledInsert) return; // If the pop-up has already been shown, do nothing
        handledInsert = true; // Mark the pop-up as shown

                console.log("Insert button clicked");
                var appointID = $(this).data("appointid");
                var confirmEdit = confirm("Do you want to edit the form?");

                if (confirmEdit) {
                    window.location.href = "insertdiagnose.php?appointID=" + appointID;
                } else {
                    toggleTab('My'); // Switch to the "My" tab


                }
                event.preventDefault(); // Prevent the default link behavior

    });



            $("table").on("click", ".download", function(e) {
            if (handledDownload) return; // If the pop-up has already been shown, do nothing
            handledDownload = true; // Mark the pop-up as shown
            var appointID = $(this).data("appointid");
            $.ajax({
            type: "POST",
            url: "checkDiagnosis.php", // Create a new PHP file for this purpose
            data: {
                appointID: appointID
            },
            success: function(response) {
                if (response === "data_found") {
                    // Data exists, allow the download action
                    window.location.href = "downloadreport.php?appointID=" + appointID;
                } else {
                    // Data does not exist, show an error pop-up
                    alert("No data found for this appointment.please insert the data first.");
                }
            }
        });

        e.preventDefault(); // Prevent the default link behavior
    });
});
    </script>
</head>

<body>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "unihealth");
    if (!$conn) {
        die("Connection failed:" . mysqli_connect_error());
    }

    $sql = "SELECT a.*, u.*
                    FROM appointment a
                    INNER JOIN user_profiles u ON a.user_id = u.user_id
                    WHERE a.requestStatus = 'Pending'";

    $result = mysqli_query($conn, $sql);
    ?>


    <div class="tabs">
        <div class="tab active" onclick="toggleTab('Pending')" data-tab="Pending">Pending</div>
        <div class="tab" onclick="toggleTab('My')" data-tab="My">My</div>
    </div>
    <div class="tab-content" data-tab="Pending" style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th colspan="2">Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . ++$index . "</td>";
                    echo "<td colspan='2'>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['_date'] . "</td>";
                    echo "<td>" . $row['_time'] . "</td>";
                    echo "<td><button style='border:none; background-color: white;' class='pending-details-button' data-modal-id='pendingModal$index'><i class='uil uil-info-circle' style='font-size: 35px'></i></button></td>";
                    echo "<td>
                                            <table>
                                                <tr>
                                                <td style='border:none;'><a href='#' class='approve' data-appointid='$row[appointID]'><i class='uil uil-check-circle' style='font-size:35px;'></i></a></td>
                                                <td style='border:none;'><a href='#' class='reject' data-appointid='$row[appointID]'><i class='uil uil-times-circle' style='font-size:35px;'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                    echo "</tr>";

                    $name = $row['full_name'];
                    $age = $row['age'];
                    $gender = $row['gender'];
                    $phone = $row['phone'];
                    $date = $row['_date'];
                    $time = $row['_time'];
                    $reason = $row['reason'];

                    echo "<div class='modal' id='pendingModal$index'>";

                    echo "<div class='modal-content'>";
                    echo "<span class='closeModal' id='closeModal' data-modal-id='pendingModal$index' style='float: right; cursor: pointer;'>&times;</span>";
                    echo "<form>";
                    echo "<div class='form first'>";
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
                    echo "<input type= 'text' name='date' value='$date' readonly>";
                    echo "</div>";

                    // <!-- Time -->
                    echo "<div class ='input-field'>";
                    echo "<label>Time</label>";
                    echo "<input type= 'text' name='time' value='$time' readonly>";
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
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </tbody>
        </table>

    </div>
    <div class="tab-content" data-tab="My" style="overflow-x: auto;">
        <!-- Testing for my approved tab -->
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th colspan="2">Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $doctor_id = $_SESSION['userID'];
                $sql2 = "SELECT a.*, u.*
                                        FROM appointment a
                                        INNER JOIN user_profiles u ON  a.user_id = u.user_id
                                        WHERE a.requestStatus = 'Approved' AND a.doctor_id = $doctor_id";
                $approvedResult = mysqli_query($conn, $sql2);
                $index = 0;
                while ($row = mysqli_fetch_assoc($approvedResult)) {
                    echo "<tr>";
                    echo "<td>" . ++$index . "</td>";
                    echo "<td colspan='2'>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['_date'] . "</td>";
                    echo "<td>" . $row['_time'] . "</td>";
                    echo "<td><button style='border:none; background-color: white;' class='my-details-button' data-modal-id='myModal$index'><i class='uil uil-info-circle' style='font-size: 35px'></i></button></td>";
                    echo "<td>
                                            <table>
                                                <tr>
                                                <td style='border:none ;'><a href='insertdiagnose.php?appointID=$row[appointID]' class='insert' data-appointid='$row[appointID]'><i class='fa fa-book fa-2x'></i></a></td>
                                                <td style='border:none;'><a href='downloadreport.php?appointID=$row[appointID]' class='download' data-appointid='$row[appointID]'><i class='fa fa-download fa-2x'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                    echo "</tr>";

                    $name = $row['full_name'];
                    $age = $row['age'];
                    $gender = $row['gender'];
                    $phone = $row['phone'];
                    $date = $row['_date'];
                    $time = $row['_time'];
                    $reason = $row['reason'];

                    echo "<div class='modal' id='myModal$index'>";

                    echo "<div class='modal-content'>";
                    echo "<span class='closeModal' id='closeModal' data-modal-id='myModal$index' style='float: right; cursor: pointer;'>&times;</span>";
                    echo "<form>";
                    echo "<div class='form second'>";
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
                    echo "<textarea id='reason' name='reason2' rows='4' value='$reason' readonly>$reason</textarea>";
                    echo "</div>";
                    echo "</div>";
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