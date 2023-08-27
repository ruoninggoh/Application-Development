<?php
include("connectdb.php");

$sql="CREATE TABLE dashboard(
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  title VARCHAR(100) NOT NULL,
  description TEXT NOT NULL
  )";

  if(mysqli_query($con, $sql)){
    echo 'Table created successfully';

  }else{
    echo 'Error creating table: '.mysqli_error($con);
  };

  $dashboard=array(
    array(
      'title' => 'STEPS TO PREVENT ILLNESS',
      'description' => 'The spread of respiratory diseases like COVID-19 can be alarming, but you can help minimize their impact. By following these simple guidelines from the Centers for Disease Control and Prevention (CDC), you’ll help keep more people in our community safe and healthy:
        <br><br>
        
        -->>Avoid close contact with people who are sick<br>
        -->>Wash your hands regularly with soap and water for a least 20 seconds<br>
        -->>Avoid touching your eyes, nose and mouth<br>
        -->>Stay home if you are sick, unless you need medical care<br>
        -->>Wear a facemask if you are ill and in contact with others<br>
        -->>Cover your nose and mouth with a tissue or inside of your elbow when you cough and sneeze, then dispose of the tissue immediately and wash your hands<br>
        -->>Clean and disinfect frequently touched surfaces daily including doorknobs, light switches, countertops, handles, desks, phones, keyboards, toilets, faucets, sinks, etc.<br>
        ',
        'image'=>'info1.png'
      )
      );

      foreach ($dashboard as $item) {
        $title = mysqli_real_escape_string($con, $item['title']);
        $description = mysqli_real_escape_string($con, $item['description']);
        $image = mysqli_real_escape_string($con, $item['image']);
      
        $sql = "INSERT INTO dashboard (title, description, image) VALUES ('$title', '$description', '$image')";
      
        if (mysqli_query($con, $sql)) {
          echo 'Data inserted successfully<br>';
        } else {
          echo 'Error inserting data: ' . mysqli_error($con) . '<br>';
        }
      }

  mysqli_close($con);
?>