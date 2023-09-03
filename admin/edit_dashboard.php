<?php
ob_start(); // Start output buffering
session_start();
include("adminHeader.html");
include("../database/connectdb.php");
?>

<html>
<title>Manage Dashboard Form</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/editStyle.css"/>

</head>
<body>
  <?php



  if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql2="SELECT * FROM dashboard where id=$id";
    $res2=mysqli_query($con, $sql2);
    $row=mysqli_fetch_array($res2);

    $dashboardTitle=$row['title'];
    $dashboardDescription=$row['description'];
    $currentImg=$row['image'];

  }
  else {
    header("location:dashboard.php");
}
  ?>


  <form action="" method="post" class="editDashboardForm" enctype="multipart/form-data">
    <div class="form-content">
      <h1>Edit Dashboard Information</h1>
        <table>
          <tr>
            <td><label for="title">Title: </label></td>
            <td><input type="text" name="title" id="dashboardTitle" value="" required/></td>
          </tr>

          <tr>
            <td><label for="description">Description:</label></td>
            <td><textarea name="description" id="description" rows="4" required></textarea></td>
          </tr>

          <tr>
            <td>Current Image: </td>
            <td>
              <?php
              if($currentImg==""){
                echo"<div class='imgerror'>Image Not Available.</div>";
              }else{
                echo"<img src='../images/dashboard/$currentImg' alt='$dashboardTitle' width='100px'/>";

              }
              ?>
            </td>
          </tr>

          <tr>
            <td><label for="image">New Image:</label></td>
            <td><input type="file" name="image" id="image" accept="image/*"/></td>
          </tr>

         
        </table>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
       <input type="hidden" name="currentImg" value="<?php echo $currentImg; ?>">


        <div class="submitbtnStyle"><button type="submit" name="submit" id="submit" class="submitbtn">Submit</button></div>
    </div>
    </form>

    <?php
    if(isset($_POST['submit'])){
      $id=$_POST['id'];
      $dashboardTitle=$_POST['title'];
      $dashboardDescription=$_POST['description'];
      $currentImg=$_POST['currentImg'];

      if(isset($_FILES['image']['name'])){
        $dashboardImg=$_FILES['image']['name'];

        if($dashboardImg!=""){
          //upload new image
          $dashboardImg=explode('.',$dashboardImg);
          $ext=end($dashboardImg);
          $dashboardImg="Dashboard-".rand(0000,9999).'.'.$ext;
          $src_path=$_FILES['image']['tmp_name'];
          $des_path="../images/dashboard/".$dashboardImg;

          $upload=move_uploaded_file($src_path, $des_path);

          if($upload==false){
            $_SESSION['upload']="<div class='error'><img src='../images/cross.png' width='16px' alt='cross icon'/>Failed to upload new Image.</div>";
            echo $_SESSION['upload'];
            header('location:dashboard.php');
        
            die();
          }

          //remove current image
          if($currentImg!=""){
            $path="../images/dashboard/$currentImg";
            $remove=unlink($path);

            if($remove==false){
              $_SESSION['remove-failed']="<div class='error'><img src='../images/cross.png' width='16px' alt='cross icon'/>Failed to remove current image.</div>";
              echo "<script>window.location.href='dashboard.php';</script>";
              die();
            }
          }
        }else{
          $dashboardImg=$currentImg;
        }
      }else{
        $dashboardImg=$currentImg;
      }

      $sql3 = "UPDATE dashboard SET
      title = '$dashboardTitle',
      description = '$dashboardDescription',
      image = '$dashboardImg'
      WHERE id = $id";
    
  $res3 = mysqli_query($con, $sql3);

  if ($res3) {
    echo "<script>alert('Dashboard Updated Successfully'); window.location.href='dashboard.php';</script>";

} else {
    echo "<script>alert('Failed to Update Dashboard.'); window.location.href='dashboard.php';</script>";
}


  }
  
  
  

      
    ?>
    <?php
    ob_end_flush(); // Send the buffered output to the browser

    ?>



</body>
</html>


  
  
  

  

