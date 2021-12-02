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
        mysqli_stmt_store_result($statement);

        //mysqli_stmt_close($statement);

        //$result = mysqli_query($conn, "SELECT * FROM `Channels`") or trigger_error("Query Failed! SQL: $result - Error: " . mysqli_error($conn), E_USER_ERROR);

        
        //mysqli_close($conn);
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
        <div class="header">
            <img src="../img/logo1.png" alt="TocTic Logo" />
            <h2>TocTic</h2>
        </div>
        <div class="scrollmenu">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `Channels` WHERE CreatedBy = $id") or trigger_error("Query Failed! SQL: $result - Error: " . mysqli_error($conn), E_USER_ERROR);
            while($row = mysqli_fetch_array($result)) {
                echo "<div id='".$row['id']."' onclick='javascript:testId(this.id)'>";
                echo "<img width='80px' src='../uploads/".$row['MainPic']."' />";
                echo "</div>";
                echo "<div>test</div>";
                echo "<div>test</div>";
                echo "<div>test</div>";
                echo "<div>test</div>";
            }
            ?>
        </div>
        <h1>Feed</h1>
        <?php   
        if(!empty($_GET["C"])){
            $currentChannelId = $_GET["C"];
        } else{
            $currentChannelId = 1;
        }
            
            $result = mysqli_query($conn, "SELECT * FROM `Posts`, Users WHERE ChannelId = $currentChannelId AND CreatedBy = $id") or trigger_error("Query Failed! SQL: $result - Error: " . mysqli_error($conn), E_USER_ERROR);
            while($row = mysqli_fetch_array($result)) {
                echo '<div class="post">';
                echo '<div class="post_header">';
                echo '<img src="../uploads/' . $row['ProfilePicture'] . '" />';
                echo '<a>'.$row["Username"].'</a>';
                echo '</div>';
                echo '<div>';
                echo '<p>'.$row['Caption'].'</p>';
                echo '</div>';
                echo '<div><img src="../uploads/'.$row['Img'].'" alt="Post"></div>';
                echo '<div class="like_section">';
                echo '<img src="../img/like.png">';
                echo '<a>'.$row["likes"].'</a>';
                echo '</div></div>';
                //echo "<div id='".$row['id']."'>";
                //echo "<img width='80px' src='../uploads/".$row['Img']."' />";
                //echo "</div>";
            }
            ?>
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
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            function testId(id){
                if(urlParams.has('C')){
                    window.history.replaceState({}, document.title, "/" + "Social_Network/code/main.php");
                }
                window.location.replace(location.href + "?C=" + id);
                
            
        }
        </script>
    </body>

    </html>


<?php
}
if (empty($_SESSION["Token"])) {
    //header('Location: http://127.0.0.1/Social_Network/code/authentication.php');
    echo "ss";
}
?>