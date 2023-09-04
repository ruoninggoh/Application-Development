<!DOCTYPE html>
<html>
    <head>
        <title>Manage Appointment</title>
        <link rel="stylesheet" type="text/css" href="manageAppoint.css">
    </head>
    <body>
        <?php
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
                                    echo "++$index";
                                    echo "<td colspan='2'>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['_date'] . "</td>";
                                    echo "<td>" . $row['_time'] . "</td>";
                                    echo "<td><button class='details-button' data-reason='" . $row['reason'] . "'><img src='details.png' alt='Details'></button></td>";
                                    echo "<td></td>";
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
                <div class="tab-content" data-tab="My">
                    <p>
                        Testing for my approved tab
                    </p>
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

            $(document).ready(function(){
                $('.details-button').click(function(){
                    var reason = $(this).data('reason');
                    $('#reasonText').text(reason);
                    $('#reasonModal').css('display', 'block');
                });

                $('#closeModal').click(function(){
                    $('#reasonModal').css('display', 'none');
                });
            });
        </script>
    </body>
</html>