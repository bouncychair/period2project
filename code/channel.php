<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css" type="text/css">
    <title>Channel</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic_logo">
        <h2 id="company_name">TocTic</h2>
    </div>
    <div class="channel_header">

      <div id="channel_cover_pic">
                      <?php 
                            /*$sql = "SELECT MainPicture FROM `Channels` WHERE Channels.id = ?";
                            $data = Query($conn, $sql, "i", $id);
                        if (sizeof($data) > 0) {
                            for ($i = 0; $i < sizeof($data); $i++) {
                                echo "
                                <div>
                                    <img id='" . $data[$i]['id'] . "' src='../uploads/" . $data[$i]['CoverPicture'] . "' /></a>
                                </div>
                                ";
                            }
                        } else {
                            echo "<p>Why is it not working</p>";
                        }*/
                        ?>
         <img src="../uploads/iss_4567_04174.jpeg" alt="Cover Picture"> 
      </div>

      <div class="post_header_channel">
                      <?php 
                        /*$sql = "SELECT MainPicture FROM `Channels` WHERE Channels.id = ?";
                        $data = Query($conn, $sql, "i", $id);
                    if (sizeof($data) > 0) {
                        for ($i = 0; $i < sizeof($data); $i++) {
                            echo "
                            <div>
                                <img id='" . $data[$i]['id'] . "' src='../uploads/" . $data[$i]['MainPicture'] . "' /></a>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p>Why is it not working</p>";
                    }*/
        
                    /*$query = "SELECT MainPicture FROM Channels";
                    //$result = mysqli_query($conn, $query);
                  
                    

                        //$image = '../uploads/' .$result;
                        //echo $image; */
                      ?>
           <img id="channel_pic" src="../img/DefaultProfile.png" alt="profilepic"> 
      </div>
        <div id="channel_name">
        <?php 
        mysqli_select_db($conn, "Toctic");
        $query = "SELECT * FROM Channels";
        $result = mysqli_query($conn, $query);
        while($name = mysqli_fetch_array($result)){ ?>
          <p><?php echo $name['Name']; ?> </p>
          <?php } ?>
        </div>
        
        <div id="channel_description">
          <?php 
          mysqli_select_db($conn, "Toctic");
          $query = "SELECT * FROM Channels";
          $result = mysqli_query($conn, $query);
          while($description = mysqli_fetch_array($result)){ ?>
            <p><?php echo $description['Description']; ?> </p>
          <?php } ?>
          <!-- CLOSE THE PHP CONNECTION AFTER THAT --> 
        </div>
    </div>
    <hr id="divider">
            <!-- INSERT CONTENT AFTER THAT -->
      
            
      <!-- Obiviously a footer -->        
   <?php include "footer.php"; ?>
</body>
</html>
