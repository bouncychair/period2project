<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
$channelId = $_GET['ChannelId'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Stylesheet.css" type="text/css">
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  

  <title>Channel</title>
</head>

<body>
  <div class="header">
    <img src="../img/logo1.png" alt="TocTic_logo">
    <h2 id="company_name">TocTic</h2>
  </div>
  <div class="channel_header">
    <div id="channel_cover_pic">
      <?php
      $sql = "SELECT * FROM `Channels` WHERE id = ?";
      $data = Query($conn, $sql, "i", $channelId);
      echo "<img " . $data[0]['id'] . "' src='../uploads/" . $data[0]['CoverPicture'] . "' /></a>";
      ?>
      <!-- <img src="../uploads/iss_4567_04174.jpeg" alt="Cover Picture"> -->
    </div>

    <div class="post_header_channel">
      <?php
      $sql = "SELECT * FROM `Channels` WHERE id = ?";
      $data = Query($conn, $sql, "i", $channelId);
      echo "<img " . $data[0]['id'] . "' src='../uploads/" . $data[0]['MainPicture'] . "' /></a>";
      ?>
      <!-- <img id="channel_pic" src="../img/DefaultProfile.png" alt="profilepic"> -->
    </div>

    <div id="channel_name">
      <?php
      $query = "SELECT `Name` FROM Channels WHERE id = ?";
      $result = Query($conn, $query, "i", $channelId);
      echo "<h3>" . $result[0]['Name'] . "</h3>";
      ?>
    </div>

    <div id="channel_description">
      <?php
      $query = "SELECT `Description` FROM Channels WHERE id = ?";
      $result = Query($conn, $query, "i", $channelId);
      echo "<p>" . $result[0]['Description'] . "</p>";
      ?>
      <!-- CLOSE THE PHP CONNECTION AFTER THAT -->
    </div>
    <div id="follow_btn">
      <?php 
        $query = "SELECT `UserId`, `ChannelId` FROM Followed WHERE ChannelId = ? AND UserId = ?";
        $data = Query($conn, $query, "ii", $channelId, $id);
        if (sizeof($data) > 0){ 
            echo '<input type="submit" name="Followed" value="Unfollow">';
            echo '<script type="text/javascript">alert("You already follow this channel")</script>';
        }else {
            echo '<input type="submit" name="Follow" value="Follow">';
            if (isset($_POST['Follow'])) {
                $query = "INSERT INTO `Followed` (UserId, ChannelId) VALUES (?, ?)";
                Query($conn, $query, "ii", $channelId, $id);
                echo '<script type="text/javascript">alert("Youre now following this channel")</script>';
            }
            //echo '<input type="submit" name="Followed" value="Unfollow">';
        }
      ?>


       <!-- <input type="submit" name="Follow" value="Follow"> -->
      
    </div>
    <div id="channel_menu">
        <?php 
          $query = "SELECT `CreatedByUserId` FROM `Channels` WHERE id = ?";
          $data = Query($conn, $query, "i", $id);
          if("SELECT Channels.id FROM `Channels` WHERE Channels.CreatedByUserId = ?") {
            echo '<button id="channel_menu" onClick="Toggle()">Menu</button>';
            } 
        ?>
    </div>
  </div>


          <div id="change_channel">
<hr id="divider">
             <div id="channel_change_name">
                <form action="channelChange.php" method="POST" enctype="multipart/form-data">
                  <p><u>Change name of the channel </u></p>
                  <input type="text" name="ChannelName" placeholder="Change Name">
                  <input type="submit" name="NameSubmit" value="Update">
                </form>
             </div> 

              <div id="channel_change_description">
                <form action="channelChange.php" method="POST" enctype="multipart/form-data">
                  <p><u>Change the description</u></p>
                  <input type="text" placeholder="Change Description">
                  <input type="submit" name="DescriptionSubmit" value="Update"> 
                </form>
              </div>

              <div id="channel_change_mainpic">
                <p><u>Change main picture</u></p>
                <input type="file" id="picUpload">
                <input type="submit" name="MainPictureSubmit" value="Update">
              </div>

              <div id="channel_change_cover">
                <p><u>Change cover page</u></p>
                <input type="file" id="coverUpload">
                 <input type="submit" name="CoverSubmit" value="Update">
              </div>

              <div id="channel_delete">
                <input type="submit" name="ChannelDeleteSubmit" value="Delete Channel">
              </div>  

          </div>
  
  <hr id="divider">
  <!-- INSERT CONTENT AFTER THAT -->
  <?php
  $query = "SELECT Posts.*, Users.id UserId, Users.Username, Users.ProfilePicture FROM `Posts`, Users WHERE ChannelId = ? AND CreatedByUserId = Users.Id";
  $data = Query($conn, $query, "i", $channelId);
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
    echo   '<img src="../uploads/' . $data[$i]['ProfilePicture'] . '" />
                <div>';
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
                <img src="../img/comment.png">
                <a>' . $commentsAmount[0]["Comments"] . '</a>
            </div>
        </div>

        ';
  }
  ?>





  <!-- Obiviously a footer -->
  <?php include "footer.php"; ?>
  <script>
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

    function Toggle(){
      var x = document.getElementById("change_channel");
       if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
      }
    }
  </script>
</body>

</html>