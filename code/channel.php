<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
$channelId = $_GET['ChannelId'];
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
                            $sql = "SELECT CoverPicture FROM `Channels` WHERE id = ?";
                            $data = Query($conn, $sql, "i", $channelId);
                        if (sizeof($data) > 0) {
                            for ($i = 0; $i < sizeof($data); $i++) {
                                echo "
                                <div>
                                    <img id='" . $data[0]['id'] . "' src='../uploads/" . $data[0]['CoverPicture'] . "' /></a>
                                </div>
                                ";
                            }
                        } else {
                            echo "<p>Why is it not working</p>";
                        }
                        ?>
         <!-- <img src="../uploads/iss_4567_04174.jpeg" alt="Cover Picture"> -->
      </div>

      <div class="post_header_channel">
                      <?php 
                        $sql = "SELECT MainPicture FROM `Channels` WHERE Channel.id = ?";
                        $data = Query($conn, $sql, "i", $channelId);
                    if (sizeof($data) > 0) {
                        for ($i = 0; $i < sizeof($data); $i++) {
                            echo "
                            <div>
                                <img id='" . $data[0]['Channel.id'] . "' src='../uploads/" . $data[0]['MainPicture'] . "' /></a>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p>Why is it not working</p>";
                    }
        
                      ?>
           <!-- <img id="channel_pic" src="../img/DefaultProfile.png" alt="profilepic"> -->
      </div>
      
        <div id="channel_name">
        <?php 
        $query = "SELECT `Name` FROM Channels WHERE id = ?";
        $result = Query($conn, $query, "i", $channelId);
           echo "<h3>" . $result [0]['Name'] . "</h3>"; 
           ?>
        </div>
        
        <div id="channel_description">
          <?php 
          $query = "SELECT `Description` FROM Channels WHERE id = ?";
          $result = Query($conn, $query, "i", $channelId);
             echo "<p>" . $result [0]['Description'] . "</p>"; 
           ?>
          <!-- CLOSE THE PHP CONNECTION AFTER THAT --> 
        </div>
         
    </div>
    <hr id="divider">
            <!-- INSERT CONTENT AFTER THAT -->
      
            
      <!-- Obiviously a footer -->        
   <?php include "footer.php"; ?>
</body>
</html>
