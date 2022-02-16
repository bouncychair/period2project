<?php 
session_start();
include_once 'connect.php';
include_once 'utils.php';
CheckIdentifier();
$id = GetUserId($conn);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="Stylesheet.css" rel="stylesheet">
    <title>Notification</title>
  </head>
  <body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
</div>
    <div class "texth3">Latest Notifications</div>
    <div class="main-notifications">
      
      <?php
         //$postid = $_GET['Postsid'];
         $query = "SELECT Channels.Name,Notifications. * FROM Notifications, Followed, Channels WHERE Channels.id = Notifications.ChannelId AND Notifications.ChannelId = Followed.ChannelId AND Followed.UserId = ? ORDER BY `date`";
         $data = Query($conn, $query, "i", $id);
         if(sizeof($data) > 0){
           for ($i=0; $i < sizeof($data); $i++) { 
            echo "<div class='box-notifications'>";
            echo "<p>There is a new post in " . $data[$i]['Name']. "</p>
            </div>";
           }
         }else{
          echo "<div class='box-notifications'>";
          echo "<p>There is no new notifications</p>
          </div>";
         }
            
    
     
    ?> 
    <?php
    include "footer.php";
    ?>
  </body>
</html>
      
