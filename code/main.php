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
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
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
                    <a href='?C=" . $data[$i]['id'] . "' ><img id='" . $data[$i]['id'] . "' src='../uploads/" . $data[$i]['MainPicture'] . "' /></a>
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
    $following = false;

    if (sizeof($data) > 0) {
        if (!empty($_GET["C"]))
            $currentChannelId = $_GET["C"];
        else
            $currentChannelId = $data[0]["ChannelId"];
        $following = true;
    } else
        $following = false;


    if ($following) {
        $query = "SELECT Posts.*, Users.id UserId, Users.Username, Users.ProfilePicture FROM `Posts`, Users WHERE ChannelId = ? AND CreatedByUserId = Users.Id";
        $data = Query($conn, $query, "i", $currentChannelId);
    } else {
        $query = "SELECT Channels.id ChannelID, Channels.Name, Channels.MainPicture, Posts.*, Users.id UserId, Users.Username, Users.ProfilePicture FROM Channels, `Posts`, Users WHERE Posts.CreatedByUserId = Users.id AND Posts.ChannelId = Channels.id AND ? ORDER BY (SELECT COUNT(CASE WHEN Likes.PostId = Posts.id THEN 1 ELSE NULL END) Likes FROM Likes) DESC;";
        $data = Query($conn, $query, "i", 1);
        echo '<h2>Recommended</h2>';
    }
    for ($i = 0; $i < sizeof($data); $i++) {
        $query = "SELECT COUNT(CASE WHEN Comments.PostId = ? THEN 1 ELSE NULL END) Comments FROM Comments";
        $commentsAmount = Query($conn, $query, "i", $data[$i]["id"]);
        $query = "SELECT COUNT(CASE WHEN Likes.PostId = ? THEN 1 ELSE NULL END) Likes FROM Likes";
        $likesAmount = Query($conn, $query, "i", $data[$i]["id"]);
        $query = "SELECT * FROM Likes WHERE UserId = ? AND PostId = ?";
        $likeCheck = Query($conn, $query, "ii", $id, $data[$i]["id"]);
        (sizeof($likeCheck) == 0) ? $likeIconName = "like.png" : $likeIconName = "liked.png";

        echo '
        <div class="post">
            <div class="post_header">';
            if(!$following) 
                echo '<img src="../uploads/' . $data[$i]['MainPicture'] . '" />';
        echo   '<img src="../img/' . $data[$i]['ProfilePicture'] . '" />';
            if(!$following)
                echo '<a>' . $data[$i]["Name"] . '</a>';
        echo'   <a>' . $data[$i]["Username"] . '</a>
            </div>
            <div class="post_caption">
                <p>' . $data[$i]['Caption'] . '</p>
            </div>
            <div><img src="../uploads/' . $data[$i]['ImageName'] . '" alt="Post"></div>
            <div class="like_section" id="Post ' . $data[$i]['id'] . '">
                <img src="../img/' . $likeIconName . '" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',1, ' . $likesAmount[0]["Likes"] . ' )">
                <a class="likescount">' . $likesAmount[0]["Likes"] . '</a>
                <img src="../img/comment.png">
                <a>' . $commentsAmount[0]["Comments"] . '</a>
            </div>
        </div>
        ';
    }

    ?>
    <br><br>
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

        function Like(UserId, PostId, Reaction, LikesCount) {
            var Like;
            var likeText = document.getElementById("Post " + PostId).getElementsByClassName("likescount")[0];
            var likeImage = document.getElementById("Post " + PostId).getElementsByTagName('img')[0];
            if (likeImage.src.substr(likeImage.src.lastIndexOf('/')) == "/like.png") {
                (likeText.innerHTML == LikesCount) ? likeText.innerHTML = LikesCount + 1: likeText.innerHTML = LikesCount;
                likeImage.src = '../img/liked.png';
                Like = "SetLike";
            } else {
                (likeText.innerHTML == LikesCount) ? likeText.innerHTML = LikesCount - 1: likeText.innerHTML = LikesCount;
                likeImage.src = '../img/like.png';
                Like = "RemoveLike";
            }
            $.ajax({
                type: 'POST',
                url: 'like.php',
                dataType: "json",
                data: ({
                    "UserId": UserId,
                    "PostId": PostId,
                    "Reaction": Reaction,
                    "Like": Like
                }),

                success: function(data) {
                    console.log(data);
                }
            });
            return false;
        }
    </script>
</body>

</html>