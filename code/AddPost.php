<?php
session_start();
require "connect.php";
require "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css">
    <title>Add post</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
    <h2>Create Post</h2>
    <div class="post_type">
        <form action="<?= htmlentities($_SERVER['PHP_SELF']);?>" method="post">
            <div id="searchChannel"><input type="text" id="searchChannel" name="searchChannel" placeholder="Channel name"></div>
            <select id="postType" name="postType" onchange="post()">
                <option value="photo" selected>Photo</option>
                <option value="video">Video</option>
                <option value="text">Text</option>
               </select>
            <div id="postPhoto" style="display: block">
            <input type="file" id="photo" name="photo" class="file_upload">
            <input type="text" id="photoDescription" name="photoDescripion" placeholder="Description" maxlength="500">
            <input type="submit" value="Post" id="submitPost"></div>
            <div id="postVideo" style="display: none">
            <input type="file" id="video" name="video" class="file_upload">
            <input type="text" id="videoDescription" name="videoDescripion" placeholder="Description" maxlength="500">
            <input type="submit" value="Post" id="submitPost"></div>
            <div id="postText" style="display: none">
            <input type="text" id="text" name="text" placeholder="Your post" maxlength="500">
            <input type="submit" value="Post" id="submitPost"></div>
        </form>
    </div>
    <?php
    include "footer.php";
    ?>
    <script>
        function post() {
            if (document.getElementById("postType").value == "photo") {
                document.getElementById("postPhoto").style.display = "block";
                document.getElementById("postVideo").style.display = "none";
                document.getElementById("postText").style.display = "none";
            }
            if (document.getElementById("postType").value == "video") {
                document.getElementById("postVideo").style.display = "block";
                document.getElementById("postPhoto").style.display = "none";
                document.getElementById("postText").style.display = "none";
            }
            if (document.getElementById("postType").value == "text") {
                document.getElementById("postText").style.display = "block";
                document.getElementById("postPhoto").style.display = "none";
                document.getElementById("postVideo").style.display = "none";
            }
        }
    </script>
</body>
</html>
