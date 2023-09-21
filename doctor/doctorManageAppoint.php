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
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
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
</style>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Manage Appointment</title>
    <link rel="stylesheet" type="text/css" href="../css/manageAppoint.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            $('.details-button').click(function() {
                var reason = $(this).data('reason');
                $('#reasonText').text(reason);
                $('#reasonModal').css('display', 'block');
            });

            $('#closeModal').click(function() {
                $('#reasonModal').css('display', 'none');
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

    $sql = "SELECT a.appointID, u.username, a._date, a._time, a.reason
                    FROM appointment a
                    INNER JOIN user u ON a.user_id = u.userID
                    WHERE a.requestStatus = 'Pending'";

    $result = mysqli_query($conn, $sql);
    ?>

    <div class="tabs">
        <div class="tab active" onclick="toggleTab('Pending')" data-tab="Pending">Pending</div>
        <div class="tab" onclick="toggleTab('My')" data-tab="My">My</div>
    </div>
    <div class="tab-content active" data-tab="Pending" style="overflow-x: auto;">
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
                    echo "<td colspan='2'>" . $row['username'] . "</td>";
                    echo "<td>" . $row['_date'] . "</td>";
                    echo "<td>" . $row['_time'] . "</td>";
                    echo "<td><button style='border:none; background-color: white;' class='details-button' data-reason='" . $row['reason'] . "'><img class= 'detail-images' src='../images/details.png' alt='Details'></button></td>";
                    echo "<td>
                                            <table>
                                                <tr >
                                                <td style='border:none;'><a href='#' class='approve' data-appointid='$row[appointID]'><i class='fas fa-check-circle' style= 'font-size: 35px;'></i></a></td>
                                                <td style='border:none;'><a href='#' class='reject' data-appointid='$row[appointID]'><i class='fas fa-times-circle' style= 'font-size: 35px;'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="modal" id="reasonModal">
            <div class="modal-content">
                <span id="closeModal" style="float: right; cursor: pointer;">&times;</span>
                <p id="reasonText"></p>
            </div>
        </div>
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
                $sql2 = "SELECT a.appointID, u.username, a._date, a._time, a.reason
                                        FROM appointment a
                                        INNER JOIN user u ON  a.user_id = u.userID
                                        WHERE a.requestStatus = 'Approved' AND a.doctor_id = $doctor_id";
                $approvedResult = mysqli_query($conn, $sql2);
                $index = 0;
                while ($row = mysqli_fetch_assoc($approvedResult)) {
                    echo "<tr>";
                    echo "<td>" . ++$index . "</td>";
                    echo "<td colspan='2'>" . $row['username'] . "</td>";
                    echo "<td>" . $row['_date'] . "</td>";
                    echo "<td>" . $row['_time'] . "</td>";
                    echo "<td><button style='border:none; background-color: white;' class='details-button' data-reason='" . $row['reason'] . "'><img class= 'detail-images' src='../images/details.png' alt='Details'></button></td>";
                    echo "<td>
                                            <table>
                                                <tr>
                                                <td style='border:none ;'><a href='insertdiagnose.php?appointID=$row[appointID]' class='insert' data-appointid='$row[appointID]'><i class='fa fa-book fa-2x'></i></a></td>
                                                
                                                <td style='border:none;'><a href='downloadreport.php?appointID=$row[appointID]' class='download' data-appointid='$row[appointID]'><i class='fa fa-download fa-2x'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>