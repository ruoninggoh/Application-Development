<!DOCTYPE html>
<html>
    <head>
        <title>Manage Appointment</title>
        <link rel="stylesheet" type="text/css" href="manageAppoint.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <body>
        <?php
            session_start();
            include("userHeader.html");
            $conn = mysqli_connect("localhost", "root", "", "unihealth");
            if(!$conn){
                die("Connection failed:" . mysqli_connect_errno());
            }

            $sql = "SELECT a.appointID, u.username, a._date, a._time, a.reason
                    FROM appointment a
                    INNER JOIN user u ON a.user_id = u.userID
                    WHERE a.requestStatus = 'Pending'";

            $result = mysqli_query($conn, $sql);
        ?>
        <div class="menu-bar">
            <div class="bus-selector">
                <div class="tabs">
                    <div class="tab active" onclick="toggleTab('Pending')" data-tab="Pending">Pending</div>
                    <div class="tab" onclick="toggleTab('My')" data-tab="My">My</div>
                </div>
                <div class="tab-content active" data-tab="Pending">
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
                                while ($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>";
                                    echo ++$index;
                                    echo "<td colspan='2'>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['_date'] . "</td>";
                                    echo "<td>" . $row['_time'] . "</td>";
                                    echo "<td><button class='details-button' data-reason='" . $row['reason'] . "'><img src='details.png' alt='Details'></button></td>";
                                    echo "<td>
                                            <table style='border:none;'>
                                                <tr>
                                                    <td><a href='#' class='approve' data-appointid='$row[appointID]'><i class='fas fa-check-circle'></i></a></td>
                                                    <td><a href='#' class='reject' data-appointid='$row[appointID]'><i class='fas fa-times-circle'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <!-- <div class="modal" id="reasonModal">
                        <div class="modal-content">
                            <span id="closeModal" style="float: right; cursor: pointer;">&times;</span>
                            <p id="reasonText"></p>
                        </div>
                    </div> -->
                </div>
                <div class="tab-content" data-tab="My">
                        <!--Testing for my approved tab-->
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
                                session_start();
                                $doctor_id = $_SESSION['doctor_id'];
                                $sql2 = "SELECT a.apoinyID, u.username, a._date, a._time, a.reason
                                        FROM appointment a
                                        INNER JOIN user u ON  a.user_id = u.userID
                                        WHERE a.requestStatus = 'Approved' AND a.doctor_id = $doctor_id";
                                $approvedResult = mysqli_query($conn, $sql2);
                                $index = 0;
                                while ($row = mysqli_fetch_assoc($approvedResult)){
                                    echo "<tr>";
                                    echo ++$index;
                                    echo "<td colspan='2'>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['_date'] . "</td>";
                                    echo "<td>" . $row['_time'] . "</td>";
                                    echo "<td><button class='details-button' data-reason='" . $row['reason'] . "'><img src='details.png' alt='Details'></button></td>";
                                    echo "<td>
                                            <table style='border:none;'>
                                                <tr>
                                                    <td><a href='#' class='insert' data-appointid='$row[appointID]'><i class='fa fa-pencil-square-o'></i></a></td>
                                                    <td><a href='#' class='download' data-appointid='$row[appointID]'><i class='fa fa-download'></i></a></td>
                                                </tr>
                                            </table>
                                        </td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            function toggleTab(tabText){
                var tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(function(tabContent){
                    //tabContent.classList.remove('active');
                    tabContent.style.transition = 'opacity 0.3 ease';
                    tabContent.style.opacity = '0';
                    tabContent.style.display = 'none';
                    
                });

                var selectedTabContent = document.querySelector('.tab-content[data-tab="' + tabText + '"]');
                selectedTabContent.style.display = 'block';
                setTimeout(function(){
                    selectedTabContent.style.opacity ='1';
                    //selectedTabContent.classList.add('active');
                }, 10);
                

                var tabs = document.querySelectorAll('.tab');
                tabs.forEach(function(tab){
                    tab.classList.remove('active');
                });

                var selectedTab = document.querySelector('.tab[data-tab="' + tabText + '"]');
                selectedTab.classList.add('active');
            }
        </script>
        <script>

            // $(document).ready(function(){
            //     $('.details-button').click(function(){
            //         var reason = $(this).data('reason');
            //         $('#reasonText').text(reason);
            //         $('#reasonModal').css('display', 'block');
            //     });

            //     $('#closeModal').click(function(){
            //         $('#reasonModal').css('display', 'none');
            //     });
            // });

            // $("table").on("click", ".approve", function () {
            //     var appointID = $(this).data("appointid");
            //     //var $row = $(this).closest("tr");
            //     var date = $(this).closest("tr").find("td:eq(3)").text();
            //     var time = $(this).closest("tr").find("td:eq(4)").text();

            //     $.ajax({
            //         type: "POST",
            //         url: "update_status.php",
            //         data: {appointID: appointID, status: "Approved"},
            //         success: function(response){
            //             if (response === "success"){
            //                 $("table tbody tr").each(function (){
            //                     var $currentRow = $(this);
            //                     var rowDate = $currentRow.find("td:eq(3)").text();
            //                     var rowTime = $currentRow.find("td:eq(4)").text();
                                
            //                     if(rowDate === date && rowTime === time){
            //                         var rejectLink = $currentRow.find(".reject");
            //                         var appointIDToReject = rejectLink.data("appointid");

            //                         if(rejectLink.length > 0){
            //                             $.ajax({
            //                                 type:"POST",
            //                                 url:"update_status.php",
            //                                 data: {appointID: appointIDToReject, status: "Rejected"},
            //                             });
            //                         }
            //                     }
            //                 });
            //             }
            //         }
            //     });             
            // });

            // $("table").on("click", ".insert", function(){
            //     // var appointID = $(this).data("appointid");
            //     window.locaion.href = "";
            // });

            // $("table").on("click", ".downlaod", function(){
            //     // var appointID = $(this).data("appointid");
            //     window.location.href = "";
            // })
        </script>
    </body>
</html>