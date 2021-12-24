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
    <h3>Latest Notifications</h3>
    <div class="main-notifications">
      
      <?php
         //$postid = $_GET['Postsid'];
         $query = "SELECT Channels.Name,Notifications.* FROM Notifications, Followed, Channels WHERE Channels.id = Notifications.ChannelId AND Notifications.ChannelId = Followed.ChannelId AND Followed.UserId = ? GROUP BY `date`";
         $data = Query($conn, $query, "i", $id);
         if ("SELECT Users.Id, Posts.id FROM `followed`, `Posts` WHERE Followed.UserId = ? AND Channels.UserId = Followed.UserId AND Post.id = ?"){
          echo "<div class='box-notifications'>";
          echo "<p>" . $data[0]["Name"] . " is created a post </p>
          </div>";

         }
     
    ?> 
    <?php
    include "footer.php";
    ?>
  </body>
</html>
      
