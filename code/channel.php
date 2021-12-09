<?php

use Google\Service\Genomics\CheckInRequest;

session_start();
include "connect.php";
include "utils.php";

CheckIdentifier($conn);
$id = GetUserId($conn);

$query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
$data = Query($conn, $query, "i", $id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css" rel="text/css">
    <title>Channel</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic_logo">
        <h2 id="company_name">TocTic</h2>
    </div>
    <div class="channel_header">
        <div class="post_header">
          <img id="channel_pic" src="../img/profileDef.png" alt="profilepic"> <?php // echo $_POST['MainPic'] ?>
        </div>
        <div id="channel_name">
            <h3>Channel Name</h3>        <?php //echo $_POST['CName'] ?>
        </div>
        <div id="channel_description">
          <p>Description</p>          <?php //echo $_POST['Description'] ?>
        </div>
    </div>
    <hr id="divider">
    <div class="footer">
      <img onClick="location.href='main.php'" id="footer_menu" src="../img/Project2_menu.png" alt="Main_menu">
      <img onClick="location.href='search.php'" id="footer_channels" src="../img/Project2_channels.png" alt="Channels">
      <img onClick="location.href='...'" id="footer_notifications" src="../img/Project2_notification.png" alt="Notifications">
      <img onClick="location.href='...'" id="footer_add_post" src="../img/Project2_add_post.png" alt="Add_post">
      <img onClick="location.href='profile.php'" id="footer_profile" src="../img/Project2_profile.png" alt="Profile">
    </div>
</body>
</html>
