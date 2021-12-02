<?php
session_start();
include "connect.php";

if (!empty($_SESSION["Token"])) {
    $query = "SELECT `id` FROM Users WHERE Token = ?";
    if ($statement = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($statement, 's', $_SESSION["Token"]);
        mysqli_stmt_execute($statement) or die(mysqli_error($conn));
        mysqli_stmt_bind_result($statement, $id);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);
    }
    $query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
    if ($statement = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($statement, 's', $id);
        mysqli_stmt_execute($statement) or die(mysqli_error($conn));
        mysqli_stmt_bind_result($statement, $ChannelId);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);
        echo $ChannelId;
        
        $result = mysqli_query($conn, "SELECT * FROM `Channels`") or trigger_error("Query Failed! SQL: $result - Error: ".mysqli_error($conn), E_USER_ERROR);

        while ($row = mysqli_fetch_array($result)) {
            echo $row["Name"];
        }
        mysqli_close($conn);
        die();
    }
    
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
        <h1>Feed</h1>
        <div class="post">
            <div class="post_header">
                <img src="https://memegenerator.net/img/instances/74987997.jpg">
                <a>Programming_Memes</a>
            </div>
            <div><img src="../img/post1.jpg" alt="Post"></div>
            <div class="like_section">
                <img src="../img/like.png">
                <a>142</a>
                <img src="https://cdn2.iconfinder.com/data/icons/medical-healthcare-26/28/Chat-2-512.png">
                <a>18</a>
            </div>
            <div>
                <p><b>@sahibthecreator: </b>if you know you know😗</p>
            </div>
        </div>
    </body>

    </html>


<?php
}
if (empty($_SESSION["Token"])) {
    //header('Location: http://127.0.0.1/Social_Network/code/authentication.php');
    echo "ss";
}
?>