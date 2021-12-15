<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Notification</title>
        <link href="css.css" rel="stylesheet" typt="text/css">
   <meta chsrset="utf-8">
    </head>
    <body>
      <div class="header">
        <img src="Your_paragraph_text__2_-removebg-preview.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
      </div>
       <div class="clearfix">
       </div>
       <div class="main">
         <h3>Latest notification</h3>
         <div class="box">
 	   <p>17-11-2021 22:00 <b>Channel Name</b></p>
	   <p>New post from Nickname</p>
	 </div>
	 <div class="box">
 	   <p>17-11-2021 22:00 <b>Channel Name</b></p>
	   <p>New post from Nickname</p>
	 </div>
       </div>
       <div class="footer">
      <img onClick="location.href='main.php'" id="footer_menu" src="../img/Project2_menu.png" alt="Main_menu">
      <img onClick="location.href='search.php'" id="footer_channels" src="../img/Project2_channels.png" alt="Channels">
      <img onClick="location.href='...'" id="footer_notifications" src="../img/Project2_notification.png" alt="Notifications">
      <img onClick="location.href='...'" id="footer_add_post" src="../img/Project2_add_post.png" alt="Add_post">
      <img onClick="location.href='profile.php'" id="footer_profile" src="../img/Project2_profile.png" alt="Profile">
    </div>
   </div>
        <?php
        session_start();
        include "connect.php";
        include "utils.php";

        CheckToken();
        $id = GetUserId($conn);

        $query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
        $data = Query($conn, $query, "i", $id);

        ?>
        
    </body>
</html>
