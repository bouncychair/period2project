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
        $query = "SELECT Posts.*, Users.id UserId, Users.Username, Users.ProfilePicture FROM `Posts`, Users WHERE ChannelId = ? AND CreatedByUserId = Users.Id";
        $data = Query($conn, $query, "i", $currentChannelId);
        $following = true;
    } else {
        $query = "SELECT Channels.id ChannelID, Channels.Name, Channels.MainPicture, Posts.*, Users.id UserId, Users.Username, Users.ProfilePicture FROM Channels, `Posts`, Users WHERE Posts.CreatedByUserId = Users.id AND Posts.ChannelId = Channels.id AND ? ORDER BY (SELECT COUNT(CASE WHEN Likes.PostId = Posts.id THEN 1 ELSE NULL END) Likes FROM Likes) DESC;";
        $data = Query($conn, $query, "i", 1);
        $following = false;
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
        if (!$following)
            echo '<img src="../uploads/' . $data[$i]['MainPicture'] . '" />';
        echo   '<img src="../uploads/' . $data[$i]['ProfilePicture'] . '" />
                <div>';
        if (!$following)
            echo '<div><a>' . $data[$i]["Name"] . '</a></div>';
        echo '   <a>' . $data[$i]["Username"] . '</a>
            </div>
            </div>
            <div class="post_caption">
                <p>' . $data[$i]['Caption'] . '</p>
            </div>
            <div><img src="../uploads/' . $data[$i]['ImageName'] . '" alt="Post"></div>
            <div class="like_section" id="Post ' . $data[$i]['id'] . '">
            <div class="popup">
                <img onclick="OpenReactions(' . $data[$i]['id'] . ')" src="../img/' . $likeIconName . '">
                <div class="popuptext" id="Popup ' . $data[$i]['id'] . '">
                    <div>
                        <a class="like-gif-count">21</a>
                        <img src="../img/like.gif" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',0, ' . $likesAmount[0]["Likes"] . ' )" />
                    </div>
                    <div>
                        <a class="think-gif-count">21</a>
                        <img src="../img/think.gif" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',1, ' . $likesAmount[0]["Likes"] . ' )" />
                    </div>
                    <div>
                        <a class="laugh-gif-count">132</a>
                        <img src="../img/laugh.gif" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',2, ' . $likesAmount[0]["Likes"] . ' )" />
                    </div>
                    <div>
                        <a class="angry-gif-count">1</a>
                        <img src="../img/angry.gif" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',3, ' . $likesAmount[0]["Likes"] . ' )" />
                    </div>
                    <div>
                        <a class="sad-gif-count">1</a>
                        <img src="../img/sad.gif" onclick="Like(' . $id . ',' . $data[$i]['id'] . ',4, ' . $likesAmount[0]["Likes"] . ' )" />
                    </div>
                </div>
            </div>    
                <a class="likescount">' . $likesAmount[0]["Likes"] . '</a>
                <img src="../img/comment.png" onclick="OpenPost('.$data[$i]['id'].')">
                <a>' . $commentsAmount[0]["Comments"] . '</a>
            </div>
        </div>

        ';
    }

    ?>
    <br><br>
    <?php include "footer.php"; ?>
    <script>
        function OpenPost(id){
            location.href="post.php?PostId="+id;
        }
        url = new URL(window.location.href);
        currentChannel = url.searchParams.get("C");
        document.getElementById(currentChannel).style.boxShadow = "0 0 20px purple";



        function OpenReactions(id) {
            var popup = document.getElementById("Popup " + id);
            popup.classList.toggle("show");
        }

        function Like(UserId, PostId, Reaction, LikesCount) {
            var Like;
            var likeImage = document.getElementById("Post " + PostId).getElementsByTagName('img')[0];
            var likeText = document.getElementById("Post " + PostId).getElementsByClassName("likescount")[0];

            var likeGifText = document.getElementById("Post " + PostId).getElementsByClassName("like-gif-count")[0];
            var thinkGifText = document.getElementById("Post " + PostId).getElementsByClassName("think-gif-count")[0];
            var laughGifText = document.getElementById("Post " + PostId).getElementsByClassName("laugh-gif-count")[0];
            var angryGifText = document.getElementById("Post " + PostId).getElementsByClassName("angry-gif-count")[0];
            var sadGidText = document.getElementById("Post " + PostId).getElementsByClassName("sad-gif-count")[0];


            if (likeImage.src.substr(likeImage.src.lastIndexOf('/')) == "/like.png") {
                likeImage.src = '../img/liked.png';
                Like = "SetLike";
            } else {
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
                    console.log(data[0].all);
                    likeText.innerHTML = data[0].all;
                    likeGifText.innerHTML = data[0].like;
                    thinkGifText.innerHTML = data[0].think;
                    laughGifText.innerHTML = data[0].laugh;
                    angryGifText.innerHTML = data[0].angry;
                    sadGidText.innerHTML = data[0].sad;

                }
            });
            OpenReactions(PostId);
            return false;

        }
    </script>
</body>

</html>