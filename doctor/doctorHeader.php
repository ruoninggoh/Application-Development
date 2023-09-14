<?php 
if(session_status()===PHP_SESSION_NONE){
  session_start();
}

include('../database/connectdb.php');

if(!isset($_SESSION['userID'])){
  header("Location:../database/signin_form.php");
  exit();
}
$userID=$_SESSION['userID'];

$sqlProfile = "SELECT * FROM doctor_profiles WHERE doctor_id = $userID";
$resultProfile = mysqli_query($con, $sqlProfile);

if($resultProfile){
  $profileData = mysqli_fetch_assoc($resultProfile);
}

$sqlDoc = "SELECT full_name, picture FROM doctor_profiles WHERE doctor_id =$userID";
$resultDoc = mysqli_query($con, $sqlDoc);

$defaultUserName = "Doctor";
$defaultProfilePicture = "../images/patients.png";

if(!empty($profileData)){
  $userName = "Dr." ." ". $profileData['full_name'];
  $profilePicture = $profileData['picture'];
} else{
  $userName = $defaultUserName;
  $profilePicture = $defaultProfilePicture;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
*{
  margin:0;
  padding: 0;
  font-family:'Poppins', sans-serif;
  box-sizing:border-box;
  
}




nav{
  background:#DBE2EF;
  width:100%;
  padding:10px 10%;
  display:flex;
  align-items:center;
  justify-content: space-between;
  position: relative;
  line-height: 1.5;
  
}

.logo{
  width:150px;
}

.user-pic{
  width:40px;
  border-radius:150%;
  cursor:pointer;
  margin-left:30px;
}

nav ul{
  width:100%;
  text-align: right;
  margin-top: 10px;
}

nav ul li{
  display: inline-block;
  list-style:none;
  margin:10px 20px;
}

nav ul li a{
  color: rgb(0, 0, 0);
  text-decoration:none !important;
}

.sub-menu-wrap{
  position:absolute;
  top:100%;
  right:10%;
  width:320px;
  max-height: 0px;
  overflow:hidden;
  transition:max-height 0.5s;
}

.sub-menu-wrap.open-menu{
  max-height: 400px;

}
.sub-menu{
  background:#fff;
  padding:20px;
  margin:10px;
  position: relative !important;
  z-index: 9999 !important; 
}



nav ul li a:hover {
  color: blue; /* Change to your desired hover color */
  
}


.user-info{
  display:flex;
  align-items:center;
}

.user-info h3{
  font-weight:500;
}

.user-info img{
  width:50px;
  height:50px;
  border-radius:50%;
  margin-right:15px;
}

.sub-menu hr{
  border:0;
  height:1px;
  width:100%;
  background:#ccc;
  margin:15px 0 10px; 

}

.sub-menu-link{
  display:flex;
  align-items:center;
  text-decoration: none !important;
  color:#525252 !important;
  margin:12px 0;
}

.sub-menu-link p{
  width:100%;
  margin-bottom:0rem;
}

.sub-menu-link img{
  width:40px;
  background:#e5e5e5;
  border-radius: 50%;
  padding:8px;
  margin-right:15px;
}

.sub-menu-link span{
  font-size:20px;
  transition:transform 0.5s;
}

.sub-menu-link:hover span{
  transform:translateX(5px);
}

.sub-menu-link:hover p{
  font-weight:600;
}




  </style>
</head>
<body>

    <nav>
      <img src="../images/LOGO.png" class="logo">
      <ul>
        <li><a href="./dashboard.php">Home</a> </li>
        <li><a href="#">About Us</a></li>
        <li><a href="doctorManageAppoint.php"> Appointment</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
      <img src="../images/patients.png" class="user-pic" onclick="toggleMenu()">

      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
            <img src="<?php echo $profilePicture; ?>">
            <h3 style="font-size:22px; padding-top:5px;"><?php echo $userName; ?></h3>
            </div>
            <hr>

            <a href="viewprofile.php" class="sub-menu-link">
              <img src="../images/profile.png">
              <p>Edit Profile</p>
              <span>></span>
            </a>

            <a href="#" class="sub-menu-link">
              <img src="../images/setting.png">
              <p>Settings & Privacy</p>
              <span>></span>

            </a>

            <a href="#" class="sub-menu-link">
              <img src="../images/help.png">
              <p>Help & Support</p>
              <span>></span>
            </a>

            <a href="../sign_out.php" class=sub-menu-link onclick="return confirm('Are you sure you want to log out?');">
              <img src="../images/logout.png">
              <p>Logout</p>
              <span>></span>
            </a>

          
        </div>
      </div>
    
 
    </nav>

   

  <script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
      subMenu.classList.toggle("open-menu");
    }
  </script>
