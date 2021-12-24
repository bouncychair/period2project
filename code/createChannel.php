<?php
session_start();
require "connect.php";
require "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
?>


<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Stylesheet.css">
  <title>Add post</title>
</head>


<body>
  <div class="header">
    <img src="../img/logo1.png" alt="TocTic Logo" />
    <h2>TocTic</h2>
  </div>
  <h2>Create Channel</h2>
  <div class="post_type">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="channelName">
            <input type="text" id="channelName" name="channelName" placeholder="Channel name">
        </div>
        <div class="channelDescription">
            <input type="text" id="channelDescription" name="channelDescription" placeholder="Channel description">
        </div>

        
        <select id="postType" name="postType" onchange="post()">
        <option value="photo" selected>Photo</option>
        <option value="video">Video</option>
        <option value="text">Text</option>
        </select>
      
        <div class="user-image mb-3 text-center">
        <div style="width: 100px; height: 100px; overflow: hidden; background: #cccccc; margin: 0 auto">
          <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
        </div>
      </div>

        <div class="mainChannelPhoto">
            Select your main photo
            <input type="file" name="mainphoto">
        </div>
        <div class="coverChannelPhoto">
            Select your cover photo
            <input type="file" name="coverphoto">
            <input type="submit" name="submit" value="Enter">
        </div>
      
        
        <?php
            //checking if the submit button is pressed
            if(isset($_POST['submit']))
            {
                
                $count_upload = 0;
                //checking if there is a channel name
                if(!empty($_POST['channelName']))
                {
                    $channelName = $_POST['channelName'];
                    //Checking if the Channel name is taken
                    $sql_channelName = "SELECT * FROM channels WHERE Name='$channelName'";
                    $result_channel_name = mysqli_query($conn, $sql_channelName);
                    if(mysqli_num_rows($result_channel_name) > 0)
                    {
                        echo "This name is already taken";   
                    }
                    else
                    {   
                        $count_upload += 1;
                        echo "name is free";
                    }
                   
                    
                }
                else{
                    echo "Please enter channel name";
                }
                //checking if the channel description is empty
                if(!empty($_POST['channelDescription']))
                {
                    $count_upload += 1;
                    $channelDescription = $_POST['channelDescription'];
                    
                }
                else{
                    echo "Please enter channel description";
                }


                                    //
                                    //
                                    //
                //Checking MAIN picture

                $target_dir = "../uploads//";
                // Get file path
                $target_file_main = $target_dir . basename($_FILES["mainphoto"]["name"]);   
                // Get file extension
                $imageExtension = strtolower(pathinfo($target_file_main, PATHINFO_EXTENSION));
                // Allowed file types
                $allowd_file_ext = array("jpg", "jpeg", "png");
                //checking if there is an uploaded file
                if (!file_exists($_FILES["mainphoto"]["tmp_name"])) 
                {
                    echo "Please select main image to upload.";
                }
                else if (!in_array($imageExtension, $allowd_file_ext)) 
                {
                            
                    echo "Allowed file formats are jpg, jpeg or png.";
                    echo "Please use one of them.";
                }
                else if ($_FILES["mainphoto"]["size"] > 2097152) 
                {
                    echo "File is too large. File size should be less than 2 megabytes.";
                    echo "Please compress the file and try again.";
                }
                else if (file_exists($target_file_main)) 
                {
                   echo "Main picture already exists.";
                }
                else 
                {
                    if (move_uploaded_file($_FILES["mainphoto"]["tmp_name"], $target_file_main)) 
                    {
                        //$sql = "INSERT INTO user (file_path) VALUES ('$target_file')";
                        //$stmt = $conn->prepare($sql);
                         //if($stmt->execute()){
                            //$resMessage = array(
                                //"status" => "alert-success",
                                //"message" => "Image uploaded successfully."
                            //);
                            $count_upload += 1;            
                    }
                    else 
                    {
                       echo "Main picture coudn't be uploaded.";
                    }
                }

                        //
                        //
                        //
                // Checking COVER photo

                // Get file path
                $target_file_cover = $target_dir . basename($_FILES["coverphoto"]["name"]);
                // Get file extension
                $imageExtension = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));
                //checking if there is an uploaded file
                if (!file_exists($_FILES["coverphoto"]["tmp_name"])) 
                {
                    echo "Please select cover image to upload.";
                }
                else if (!in_array($imageExtension, $allowd_file_ext)) 
                {
                            
                    echo "Allowed file formats are jpg, jpeg or png.";
                    echo "Please use one of them.";
                }
                else if ($_FILES["coverphoto"]["size"] > 2097152) 
                {
                    echo "File is too large. File size should be less than 2 megabytes.";
                    echo "Please compress the file and try again.";
                }
                else if (file_exists($target_file_cover)) 
                {   
                   echo "Cover picture already exists.";
                }
                else 
                {
                    if (move_uploaded_file($_FILES["coverphoto"]["tmp_name"], $target_file_cover)) 
                    {
                        //$sql = "INSERT INTO user (file_path) VALUES ('$target_file')";
                        //$stmt = $conn->prepare($sql);
                         //if($stmt->execute()){
                            //$resMessage = array(
                                //"status" => "alert-success",
                                //"message" => "Image uploaded successfully."
                            //);
                            $count_upload += 1;                
                    }
                    else 
                    {
                       echo "Cover picture coudn't be uploaded.";
                    }
                }

                if($count_upload == 4)
                {   
                    $channel_type = $_POST['postType'];
                    $regdate = date("Y-m-d");
                    $stmt_insert = "INSERT INTO `channels` (`CreatedByUserId`,`Name`,`MainPicture`,`CoverPicture`,`Description`,`RegDate`,`Type`) VALUES ('$id', '$channelName', '$target_file_main', '$target_file_cover', '$channelDescription', '$regdate', '$channel_type')"; 
                    

                    if(mysqli_query($conn, $stmt_insert)){
                        echo "<br>";
                        echo "Records added successfully.";
                    } else{
                        echo "ERROR: Could not able to execute. " . mysqli_error($conn);
                    }
                }   
                else
                {
                    echo "<br>";
                    echo "Sorry, there is a problem.";
                }









            }       
        ?>
            
       </form>
       
        
  </div>
  <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#imgPlaceholder').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $("#chooseFile").change(function () {
      readURL(this);
    });
  </script>
  </body>
  </html>
