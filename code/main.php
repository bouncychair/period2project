<?php
session_start();
include "connect.php";
include "utils.php";

CheckToken();
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
        for ($i = 0; $i < sizeof($data); $i++) {
            echo "
            <div id='" . $data[$i]['id'] . "' onclick='javascript:testId(this.id)'>
                <img width='80px' src='../uploads/" . $data[$i]['MainPic'] . "' />
            </div>
            ";
        }
        ?>
    </div>
    <h1>Feed</h1>
    <?php
    if (!empty($_GET["C"]))
        $currentChannelId = $_GET["C"];
    else
        $currentChannelId = $data[0]["ChannelId"];

    $query = "SELECT * FROM `Posts`, Users WHERE ChannelId = ? AND CreatedBy = Users.Id";
    $data = Query($conn, $query, "i", $currentChannelId);
    for ($i = 0; $i < sizeof($data); $i++) {
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
            </div>
        </div>
        ';
    }
    ?>
    <script>
        const urlParams = new URLSearchParams(window.location.search);

        function testId(id) {
            if (urlParams.has('C')) {
                window.history.replaceState({}, document.title, "/" + "Social_Network/code/main.php");
            }
            window.location.replace(location.href + "?C=" + id);


        }
    </script>
</body>

</html>