<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
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
    <link rel="stylesheet" href="Stylesheet.css">
    <title>Main</title>
</head>

<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
    <div class="scrollmenu">
        <?php

        $query = "SELECT * FROM `Channels`, Followed WHERE Followed.UserId = ? AND Followed.ChannelId = Channels.id";
        $data = Query($conn, $query, "i", $id);
        if (sizeof($data) > 0) {
            for ($i = 0; $i < sizeof($data); $i++) {
                echo "
                <div>
                    <a href='?C=" . $data[$i]['id'] . "' ><img id='" . $data[$i]['id'] . "' src='../uploads/" . $data[$i]['MainPic'] . "' /></a>
                    <p>" . $data[$i]['Name'] . "</p>
                </div>
                ";
            }
        } else {
            echo "<p>Channels you are following will appear here</p>";
        }
        ?>
    </div>
    <?php
    if (sizeof($data) > 0) {
        if (!empty($_GET["C"]))
            $currentChannelId = $_GET["C"];
        else
            $currentChannelId = $data[0]["ChannelId"];

        $query = "SELECT * FROM `Posts`, Users WHERE ChannelId = ? AND CreatedBy = Users.Id";
        $data = Query($conn, $query, "i", $currentChannelId);
        for ($i = 0; $i < sizeof($data); $i++) {
            $query = "SELECT COUNT(Comments.PostId) FROM `Comments`, Posts WHERE Posts.id = ?";
            $commentAmount = Query($conn, $query, "i", $data[$i]["likes"]);
            echo '
        <div class="post">
            <div class="post_header">
                <img src="../uploads/' . $data[$i]['ProfilePicture'] . '" />
                <a>' . $data[$i]["Username"] . '</a>
            </div>
            <div>
                <p>' . $data[$i]['Caption'] . '</p>
            </div>
            <div><img src="../uploads/' . $data[$i]['Img'] . '" alt="Post"></div>
            <div class="like_section">
                <img src="../img/like.png">
                <a>' . $data[$i]["likes"] . '</a>
                <img src="../img/comment.png">
                <a>' . $commentAmount[0]["COUNT(Comments.PostId)"] . '</a>
            </div>
        </div>
        ';
        }
    } else {
        echo '<h3>Recommended</h3>';
        $query = "SELECT * FROM Channels, `Posts`, Users, Likes WHERE Posts.CreatedByUserId = Users.id AND Posts.ChannelId = Channels.id AND Likes.PostId = Posts.id AND ? ORDER BY COUNT(Likes.PostId) DESC";
        $data = Query($conn, $query, "i", 1);
        var_dump($data);die();
        for ($i = 0; $i < sizeof($data); $i++) {
            $query = "SELECT COUNT(Comments.PostId) FROM `Comments`, Posts WHERE Posts.id = ?";
            $commentsAmount = Query($conn, $query, "i", $data[$i]["PostId"]);
            $query = "SELECT COUNT(Likes.PostId) FROM `Likes`, Posts WHERE Posts.id = ?";
            $likesAmount = Query($conn, $query, "i", $data[$i]["PostId"]);
            echo '
        <div class="post">
            <div class="post_header">
                <img src="../img/' . $data[$i]['ProfilePicture'] . '" />
                <a>' . $data[$i]["Username"] . '</a>
            </div>
            <div>
                <p>' . $data[$i]['Caption'] . '</p>
            </div>
            <div><img src="../uploads/' . $data[$i]['ImageName'] . '" alt="Post"></div>
            <div class="like_section">
                <img src="../img/like.png">
                <a>' . $likesAmount[$i]["COUNT(Likes.PostId)"] . '</a>
                <img src="../img/comment.png">
                <a>' . $commentsAmount[$i]["COUNT(Comments.PostId)"] . '</a>
            </div>
        </div>
        ';
        }
    }
    ?>
    <div class="footer">
        <img onClick="location.href='main.php'" id="footer_menu" src="../img/Project2_menu.png" alt="Main_menu">
        <img onClick="location.href='search.php'" id="footer_channels" src="../img/Project2_channels.png" alt="Channels">
        <img onClick="location.href='...'" id="footer_notifications" src="../img/Project2_notification.png" alt="Notifications">
        <img onClick="location.href='...'" id="footer_add_post" src="../img/Project2_add_post.png" alt="Add_post">
        <img onClick="location.href='profile.php'" id="footer_profile" src="../img/Project2_profile.png" alt="Profile">
    </div>
    <script>
        url = new URL(window.location.href);
        currentChannel = url.searchParams.get("C");
        document.getElementById(currentChannel).style.boxShadow = "0 0 20px purple";
    </script>
</body>

</html>