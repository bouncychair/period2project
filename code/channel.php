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
      </div>

      <div class="post_header_channel">
          <?php
          $sql = "SELECT * FROM `Channels` WHERE id = ?";
          $data = Query($conn, $sql, "i", $channelId);
          echo "<img " . $data[0]['id'] . "' src='../uploads/" . $data[0]['MainPicture'] . "' /></a>";
          ?>
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
      </div>

      <div id="follow_btn">
        <form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <?php 
            $query = "SELECT `UserId`, `ChannelId` FROM Followed WHERE ChannelId = ? AND UserId = ?";
            $data = Query($conn, $query, "ii", $channelId, $id);
              if (sizeof($data) > 0){ ?>
                  <!--<form action=" <?php //htmlentities($_SERVER['PHP_SELF']); ?>"method="POST">
                  <input type="submit" name="Unfollow" value="Unfollow"></form> --> <?php
                  if(isset($_POST['submit'])) {
                      $query = "DELETE FROM `Followed` WHERE UserId = ? AND ChannelId = ?";
                      $data = Query($conn, $query, "ii", $id, $channelId); 
                  } ?>
                  <!-- <form action=<?php //$_SERVER['PHP_SELF'] ?> method="post" name="Unfollow"> -->
                  <input type="submit" name="submit" value="Unfollow" /> <!-- </form> --> <?php
              }else{
                    if (isset($_POST['Follow'])) {
                      $UserIdFollow = $_SESSION['Identifier'];
                      $ChannelIdFollow = $_POST['ChannelId'];
                      $query = "INSERT INTO `Followed` (`ChannelId`, `UserId`) VALUES (?, ?)";
                      Query($conn, $query, "ii", $ChannelIdFollow, $UserIdFollow);
                      echo '<script type="text/javascript">alert("Youre now following this channel")</script>';
                    }
                  echo '<form action="' .$_SERVER['PHP_SELF'].  '"method="POST"><input type="submit" name="Follow" value="Follow"></form>';
              }
          ?>
        </form>      
      </div>

      <div id="channel_menu">
          <?php 
            $query = "SELECT `CreatedByUserId` `id` FROM `Channels` WHERE CreatedByUserId = ? AND id = ?";
            $data = Query($conn, $query, "ii", $id, $channelId);
              if(sizeof($data) > 0) {
                echo '<button id="channel_menu" onClick="Toggle()">Menu</button>';
              } 
          ?>
      </div>
  </div>

          <?php 
            $targetDir = "../uploads/";
            $fileName = @basename($_FILES["file"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

              if (isset($_POST["allSubmit"]) && !empty($_FILES["file"]["name"])) {
                  // Allow certain file formats
                  $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                  if (in_array($fileType, $allowTypes)) {
                      // Upload file to server
                      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                          // Insert image file name into database
                          $sql = "INSERT INTO Channels (`MainPicture`) VALUES = (?) WHERE id = ?";
                          if (Query($conn, $sql, "s", $channelId)) {
                              $statusMsg = "Records inserted successfully.";
                          } else {
                              $statusMsg = "File upload failed, please try again.";
                          }
                      } else {
                          $statusMsg = "Sorry, there was an error uploading your file.";
                      }
                  } else {
                      $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                  }
              }
          ?>

      <div id="change_channel">
<hr id="divider">

        <form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
          <div id="channel_change_name">
              <?php 
                if(isset($_POST['allSubmit'])) {
                  if(!empty($_POST['ChannelName'])){
                    if (strlen($_POST['ChannelName']) > 1 && strlen($_POST['ChannelName']) < 30 && ctype_alnum($_POST['ChannelName'])) {
                      $query = "SELECT * FROM `Channels` WHERE Name = ?";
                      $data = Query($conn, $query, "s", $_POST['ChannelName']);
                        if (sizeof($data) > 0){ 
                        }else {
                          $channelName = $_POST['ChannelName'];
                          $query = "UPDATE Channels SET `Name` = ? WHERE id = ?";
                          $data = Query($conn, $query, "si", $channelName, $channelId);
                            echo "Adding succesful!";
                        }
                    }
                  }
                } 
              ?>
              <p><u>Change content of the channel </u></p>
              <input type="text" name="ChannelName" placeholder="Change Name">
          </div> 

          <div id="channel_change_description">
              <?php 
                if(isset($_POST['allSubmit'])) {
                  if(!empty($_POST['ChannelDescription'])) {
                    if(strlen($_POST['ChannelDescription']) > 1 && strlen($_POST['ChannelDescription']) < 201   /*&& ctype_alnum($_POST['ChannelDescription'])*/  ) {
                      $query = "SELECT * FROM `Channels` WHERE Description = ?";
                      $data = Query($conn, $query, "s", $_POST['ChannelDescription']);
                        if(sizeof($data) > 0){
                        }else {
                          $channelDescription = $_POST['ChannelDescription'];
                          $query = "UPDATE Channels SET `Description` = ? WHERE id = ?";
                          $data = Query($conn, $query, "si", $channelDescription, $channelId);
                            echo "Adding succesful!";
                        }
                    }
                  }
                }
              ?>
              <!-- <p><u>Change the description</u></p> -->
              <input type="text" name="ChannelDescription" placeholder="Change Description">
          </div>

          <div id="channel_change_mainpic">
              <?php
              /*$upload = $_FILES['file']['name'];
                if(isset($_POST['allSubmit'])) {
                  if(!empty($_FILES['file']['name'])) {
                    $sql = "UPDATE Channels SET `MainPicture` = ? WHERE id = ?";
                    $data = Query($conn, $sql, "si", $upload, $channelId);
                  } else {
                    echo "You didnt select anything";
                    }
                }*/
              ?>
              <!-- <p><u>Change main picture</u></p> -->
              <label for="MainUpload">Change Main Picture</label>
              <input type="file" name="file" id="MainUpload">
          </div> 

          <div id="channel_change_cover">
              <?php
              /*$upload = $_FILES['file2']['name'];
                if(isset($_POST['allSubmit'])) {
                  if(!empty($_FILES['file']['name'])) {
                    $dir = "../uploads/".basename($upload);
                    $sql = "UPDATE Channels SET `CoverPicture` = ? WHERE id = ?";
                    $data = Query($conn, $sql, "si", $upload, $channelId);
                  } else {
                    echo "Select something else";
                        }
                }*/
              ?>
              <!-- <p><u>Change cover page</u></p> -->
              <label for="CoverUpload">Change Cover Picture</label>
              <input type="file" name="file" id="CoverUpload">
          </div>
              <input type="submit" name="allSubmit" value="Update">

          <div id="channel_delete">
              <?php
                if(isset($_POST['ChannelDeleteSubmit'])) {
                  $query = "DELETE FROM `Channels` WHERE id = ?";
                  $data = Query($conn, $query, "i", $channelId);
                }
              ?>
              <input type="submit" onClick="Delete()" value="Delete Channel" name="ChannelDeleteSubmit" />
                      <!--  <div id="channel_delete_toggle">
                          <input type="submit" name="ChannelDeleteSubmit" value="Yes">
                          <button>No</button>
                        </div>-->
          </div>  
                
        </form>
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

                        echo  '
                              <div class="post">
                                <div class="post_header">';
                        echo  '<img src="../uploads/' . $data[$i]['ProfilePicture'] . '" />
                                <div>';
                        echo  ' <a>' . $data[$i]["Username"] . '</a>
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

    /*function Delete() {
      var x = document.getElementById("channel_delete_toggle");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }*/


  </script>
</body>
</html>