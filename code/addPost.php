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
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    var id = <?php echo $id ?>;
    $(document).ready(function() {
      $('.searchChannel input[type="text"]').on("keyup input", function() {
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".searchResult");
        if (inputVal.length) {
          $.get("backend-search.php", {
            term: inputVal,
            id: id
          }).done(function(data) {
            // Display the returned data in browser
            resultDropdown.html(data);
          });
        } else {
          resultDropdown.empty();
        }
      });

      // Set search input value on click of result item
      $(document).on("click", ".searchResultBox", function() {
        $(this).parents(".searchChannel").find('input[type="text"]').val($(this).text());
        $(this).parent(".searchResult").empty();
      });
    });
  </script>
  <div class="header">
    <img src="../img/logo1.png" alt="TocTic Logo" />
    <h2>TocTic</h2>
  </div>
  <h2>Create Post</h2>
  <div class="post_type">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
      <div class="searchChannel">
        <input type="text" id="searchChannel" name="searchChannel" placeholder="Channel name">
        <div class="searchResult"></div>
      </div>
      <select id="postType" name="postType" onchange="post()">
        <option value="photo" selected>Photo</option>
        <option value="video">Video</option>
        <option value="text">Text</option>
      </select>
      <div id="postPhoto" style="display: block">
        <input type="file" id="photoUpload" name="photoUpload" class="file_upload">
        <input type="text" id="photoDescription" name="photoDescription" placeholder="Description" maxlength="500">
        <input type="submit" value="Post" id="submitPhoto" name="submitPhoto">
      </div>

      <div id="postVideo" style="display: none">
        <input type="file" id="videoUpload" name="videoUpload" class="file_upload">
        <input type="text" id="videoDescription" name="videoDescription" placeholder="Description" maxlength="500">
        <input type="submit" value="Post" id="submitVideo" name="submitVideo">
      </div>

      <div id="postText" style="display: none">
        <input type="text" id="textUpload" name="textUpload" placeholder="Your post" maxlength="500">
        <input type="submit" value="Post" id="submitText" name="submitText">
      </div>
    </form>
  </div>
  <div class="submitPost">
    <?php
    $date = date("Y-m-d");
    if (isset($_POST['submitPhoto'])) {
      if (!empty($_POST['searchChannel'])) {
        $photoDescription = $_POST["photoDescription"];
        $channelId = "SELECT Followed.`ChannelId` FROM Followed, Channels WHERE Followed.UserId = ? AND Channels.`Name` = ? AND Followed.ChannelId = Channels.id AND Channels.CreatedByUserId = ?";
        $chId = Query($conn, $channelId, "is", $id, $_POST['searchChannel']);
        if($chId != NULL) {
        if ($_FILES["photoUpload"]["size"] < 3000000) {
          $acceptedPhotoTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
          $photoinfo = finfo_open(FILEINFO_MIME_TYPE);
          $uploadedPhotoType = finfo_file($photoinfo, $_FILES["photoUpload"]["tmp_name"]);
          if (in_array($uploadedPhotoType, $acceptedPhotoTypes)) {
            if ($_FILES["photoUpload"]["error"] > 0) {
              echo "Error: " . $_FILES["photoUpload"]["error"] . "<br />";
            } else {
              $oldPhotoName = $_FILES["photoUpload"]["name"];
              $extensionPhoto = pathinfo($oldPhotoName, PATHINFO_EXTENSION);
              if (file_exists("../uploads/" . $_FILES["photoUpload"]["name"])) {
                $newPhotoName = $oldPhotoName . date('His') . '.' . $extensionPhoto;
                if (strlen($newPhotoName) > 255) {
                  $lengPhotoName = substr($newPhotoName, 0, 240);
                  $newLengPhotoName = $lengPhotoName . date('His') . $extensionPhoto;
                  if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/" . $newLengPhotoName)) {
                    $insertPhoto = "INSERT INTO Posts (`CreatedByUserId`, `ChannelId`, `ImageName`, `Caption`, `Date`) VALUES (?,?,?,?,?)";
                    $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $newLengPhotoName, $photoDescription, $date);
                    if ($insertP == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploaded.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                } else {
                  if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/" . $newPhotoName)) {
                    $insertPhoto = "INSERT INTO Posts (`CreatedByUserId`, `ChannelId`, `ImageName`, `Caption`, `Date`) VALUES (?,?,?,?,?)";
                    $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $newPhotoName, $photoDescription, $date);
                    if ($insertP == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                }
              } else {
                if (strlen($oldPhotoName) > 255) {
                  $leng2PhotoName = substr($oldPhotoName, 0, 240);
                  $newLeng2PhotoName = $leng2PhotoName . date('His') . $extensionPhoto;
                  if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/" . $newLeng2PhotoName)) {
                    $insertPhoto = "INSERT INTO Posts (`CreatedByUserId`, `ChannelId`, `ImageName`, `Caption`, `Date`) VALUES (?,?,?,?,?)";
                    $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $newLeng2PhotoName, $photoDescription, $date);
                    if ($insertP == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                } else {
                  if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/" . $_FILES["photoUpload"]["name"])) {
                    $insertPhoto = "INSERT INTO Posts (`CreatedByUserId`, `ChannelId`, `ImageName`, `Caption`, `Date`) VALUES (?,?,?,?,?)";
                    $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $_FILES["photoUpload"]["name"], $photoDescription, $date);
                    if ($insertP == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                }
              }
            }
          } else {
            echo "Invalid file type. Must be gif, jpg, png or jpeg.";
          }
        } else {
          echo "Invalid file size. Must be less than 3MB.";
        }
      } else {
          echo "No channel found.";
        }
      } else {
        echo "Please select a channel.";
      }
    }

    if (isset($_POST['submitVideo'])) {
      if (!empty($_POST['searchChannel'])) {
        $channelId = "SELECT Followed.`ChannelId` FROM Followed, Channels WHERE Followed.UserId = ? AND Channels.`Name` = ? AND Followed.ChannelId = Channels.id";
        $chId = Query($conn, $channelId, "is", $id, $_POST['searchChannel']);
        $videoDescription = $_POST["videoDescription"];
        if($chId != NULL) {
        if ($_FILES["videoUpload"]["size"] < 100000000) {
          $acceptedVideoTypes = ["video/mov", "video/swf", "video/mp4", "video/mkv", "video/flv", "video/wmv", "video/avi", "video/3gp", "video/vob", "video/aaf", "video/mod", "video/mpeg"];
          $videoinfo = finfo_open(FILEINFO_MIME_TYPE);
          $uploadedVideoType = finfo_file($videoinfo, $_FILES["videoUpload"]["tmp_name"]);
          if (in_array($uploadedVideoType, $acceptedVideoTypes)) {
            if ($_FILES["videoUpload"]["error"] > 0) {
              echo "Error: " . $_FILES["videoUpload"]["error"] . "<br />";
            } else {
              $oldVideoName = $_FILES["videoUpload"]["name"];
              $extensionVideo = pathinfo($oldVideoName, PATHINFO_EXTENSION);
              if (file_exists("../uploads/" . $_FILES["videoUpload"]["name"])) {
                $newVideoName = $oldVideoName . date('His') . '.' . $extensionVideo;
                if (strlen($newVideoName) > 255) {
                  $lengVideoName = substr($newVideoName, 0, 240);
                  $newLengVideoName = $lengVideoName . date('His') . $extensionVideo;
                  if (move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/" . $newLengVideoName)) {
                    $insertVideo = "INSERT INTO Posts (CreatedByUserId, ChannelId, VideoName, Caption, `Date`) VALUES (?,?,?,?,?)";
                    $insertV = Query($conn, $insertVideo, "iisss", $id, $chId[0]["ChannelId"], $newLengVideoName, $videoDescription, $date);
                    if ($insertV == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                } else {
                  if (move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/" . $newVideoName)) {
                    $insertVideo = "INSERT INTO Posts (CreatedByUserId, ChannelId, VideoName, Caption, `Date`) VALUES (?,?,?,?,?)";
                    $insertV = Query($conn, $insertVideo, "iisss", $id, $chId[0]["ChannelId"], $newVideoName, $videoDescription, $date);
                    if ($insertV == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                }
              } else {
                if (strlen($oldVideoName) > 255) {
                  $leng2VideoName = substr($oldVideoName, 0, 240);
                  $newLeng2VideoName = $leng2VideoName . date('His') . $extensionVideo;
                  if (move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/" . $newLeng2VideoName)) {
                    $insertVideo = "INSERT INTO Posts (CreatedByUserId, ChannelId, VideoName, Caption, `Date`) VALUES (?,?,?,?,?)";
                    $insertV = Query($conn, $insertVideo, "iisss", $id, $chId[0]["ChannelId"], $newLeng2VideoName, $videoDescription, $date);
                    if ($insertV == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                } else {
                  if (move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/" . $_FILES["videoUpload"]["name"])) {
                    $insertVideo = "INSERT INTO Posts (CreatedByUserId, ChannelId, VideoName, Caption, `Date`) VALUES (?,?,?,?,?)";
                    $insertV = Query($conn, $insertVideo, "iisss", $id, $chId[0]["ChannelId"], $_FILES["videoUpload"]["name"], $videoDescription, $date);
                    $videonotify = "INSERT INTO Notifications (UserId, ChannelId, `Date`) VALUES (?,?,?)";
                    $videon = Query($conn, $videonotify, "iis", $id, $chId[0]["ChannelId"], $date);
                    if ($insertV == 1) {
                      echo "Your post has been uploaded.";
                    } else {
                      echo "Something went wrong while uploading.";
                    }
                  } else {
                    echo "Something went wrong while uploading.";
                  }
                }
              }
            }
          } else {
            echo "Invalid file type. Must be mov, swf, mp4, mkv, flv, wmv, avi, 3gp, vob, aaf, mod or mpeg.";
          }
        } else {
          echo "Invalid file size. Must be less than 100MB.";
        }
      } else {
          echo "No channel found.";
        }
      } else {
        echo "Please select a channel.";
      }
    }

    if (isset($_POST['submitText'])) {
      if (!empty($_POST['searchChannel'])) {
        $text = $_POST["textUpload"];
        $channelId = "SELECT Followed.`ChannelId` FROM Followed, Channels WHERE Followed.UserId = ? AND Channels.`Name` = ? AND Followed.ChannelId = Channels.id";
        $chId = Query($conn, $channelId, "is", $id, $_POST['searchChannel']);
        if($chId != NULL) {
        if (!empty($_POST['textUpload'])) {
          $insertText = "INSERT INTO Posts (CreatedByUserId, ChannelId, Caption, `Date`) VALUES (?,?,?,?)";
          $insertT = Query($conn, $insertText, "iiss", $id, $chId[0]["ChannelId"], $text, $date);
          $videonotify = "INSERT INTO Notifications (UserId, ChannelId, `Date`) VALUES (?,?,?)";
          $videon = Query($conn, $videonotify, "iis", $id, $chId[0]["ChannelId"], $date);
          if($insertT == 1){
            echo "Your post has been uploaded.";
           } else{
            echo "Something went wrong while uploading.";
           }
        } else {
          echo "Please enter text.";
        }
      } else {
          echo "No channel found.";
        }
      } else {
        echo "Please select a channel.";
      }
    }
    ?>
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
