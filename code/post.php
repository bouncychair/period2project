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
    <link rel="stylesheet" href="Stylesheet.css">
    <title>Post</title>
</head>

<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
    <div>
    <?php
    $profile = mysqli_query($conn,"SELECT * FROM `users` WHERE Id=6");

    while($row = mysqli_fetch_array($profile))
    {
        echo "<img src='../img/".$row['ProfilePicture']."'>";
        echo $row['Username'];
    }
    ?>
    </div>
    <div>
    <?php
    $post_image = mysqli_query($conn,"SELECT * FROM `posts` WHERE Id=3");

    while($row = mysqli_fetch_array($post_image))
    {
        echo "<img src='../uploads/".$row['ImageName']."' >";
    }
    
    ?>
    </div>
    <?php
    $comments = mysqli_query($conn,"SELECT * FROM `comments` WHERE PostId=3");
   
    while($row = mysqli_fetch_array($comments))
    {
        echo $row['Text'];
    }
    ?>
<!--    
     <div class="post_page">
        <img class="post_image" src="../img/post2.jpg">
        <img class="post_like" src="../img/like.png">
        <p>
        </p>
        <body>
            ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque imperdiet, urna eget fermentum bibendum, leo sapien volutpat massa, a sagittis diam nibh et erat. In hac habitasse platea dictumst. Fusce nec lorem tortor. Maecenas vitae arcu id neque rutrum auctor. Phasellus quis dapibus dolor. Quisque ut semper neque. Quisque vulputate.ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque imperdiet, urna eget fermentum bibendum, leo sapien volutpat massa, a sagittis diam nibh et erat. In hac habitasse platea dictumst. Fusce nec lorem tortor. Maecenas vitae arcu id neque rutrum auctor. Phasellus quis dapibus dolor. Quisque ut semper neque. Quisque vulputate.
        </body>
    </div>
-->
    <div class="footer">
      <img onClick="location.href='main.php'" id="footer_menu" src="../img/Project2_menu.png" alt="Main_menu">
      <img onClick="location.href='search.php'" id="footer_channels" src="../img/Project2_channels.png" alt="Channels">
      <img onClick="location.href='...'" id="footer_notifications" src="../img/Project2_notification.png" alt="Notifications">
      <img onClick="location.href='...'" id="footer_add_post" src="../img/Project2_add_post.png" alt="Add_post">
      <img onClick="location.href='profile.php'" id="footer_profile" src="../img/Project2_profile.png" alt="Profile">
    </div>
</body>

</html>
