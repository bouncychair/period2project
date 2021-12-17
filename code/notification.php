<?php include_once 'connect.php';
include_once 'utils.php';
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
      <div class="box-notifications">
      <?php
         $id = GetUserId($conn);
         $query = "SELECT notifications.* FROM notifications, followed WHERE Notifications.ChannelId = followed.ChanelId AND followed.UserId = ? GROUP BY date";
         $data = Query($conn, $query, "i", $id);
         if ("SELECT Users.Id, Posts.id FROM `followed`, `Posts` WHERE Followed.UserId = ? AND Channels.UserId = Followed.UserId AND Post.id = ?"){
           echo $data . "is created a post";
         }
         for ($i=0; $i < sizeof($data); $i++) { 
          echo $data[$i]["Posts.id"];
       }
    ?> 
    <?php
    include "footer.php";
    ?>
  </body>
</html>
