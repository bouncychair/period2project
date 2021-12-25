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
    var id = <?php echo $id?>;
      $(document).ready(function() {
        $('.searchChannel input[type="text"]').on("keyup input", function() {
          /* Get input value on change */
          var inputVal = $(this).val();
          var resultDropdown = $(this).siblings(".searchResult");
          if (inputVal.length) {
            $.get("searchChannel.php", {
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
  $photoDescription = $_POST["photoDescription"];
    if (!empty($_POST['searchChannel'])) {
      if ($_FILES["photoUpload"]["size"] < 3000000) {
        $acceptedPhotoTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
        $photoinfo = finfo_open(FILEINFO_MIME_TYPE);
        $uploadedPhotoType = finfo_file($photoinfo, $_FILES["photoUpload"]["tmp_name"]);
          if(in_array($uploadedPhotoType, $acceptedPhotoTypes)) {
            if ($_FILES["photoUpload"]["error"] > 0) {
              echo "Error: " . $_FILES["photoUpload"]["error"] . "<br />";
                }else{
                  $oldPhotoName = $_FILES["photoUpload"]["name"];
                  $extensionPhoto = pathinfo($oldPhotoName, PATHINFO_EXTENSION);
                   if (file_exists("../uploads/" . $_FILES["photoUpload"]["name"])) {
                     $newPhotoName = $oldPhotoName . date('His') . '.' . $extensionPhoto;
                       if (strlen($newPhotoName) > 255) {
                         $lengPhotoName = substr($newPhotoName, 0, 240);
                         $newLengPhotoName = $lengPhotoName . date('His') . $extensionPhoto;
                         if(move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/". $newLengPhotoName)) {
                           $insertPhoto = "INSERT INTO Posts ('ImageName') VALUES (?) WHERE CreatedByUserId = ?";
                           $insertP = Query($conn, $insertPhoto,"si",$uploadPhoto, $id);
                           if (mysqli_query($conn, $insertPhoto)) {
                               echo "Your post has been sent.";
                           } else {
                               echo "Something went wrong while uploading.";
                           }
                             }else{
                               echo "Something went wrong while uploading.";
                                 }
                               }else{
                                 if(move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/". $newPhotoName)) {
                                   $channelId = "SELECT `ChannelId` FROM Followed, Channels WHERE UserId = ? AND Name = ?";
                                   $chId = Query($conn, $channelId, "is", $id, $_POST['searchChannel']);
                                   $insertPhoto = "INSERT INTO Posts ('CreatedByUserId','ChannelId','ImageName','Caption','Date') VALUES (?,?,?,?,?)";
                                   $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $newPhotoName, $photoDescription, $date);
                                   if (mysqli_query($conn, $insertPhoto)) {
                                       echo "Your post has been sent.";
                                   } else {
                                       echo "Something went wrong while uploading.";
                                   }
                                     }else{
                                       echo "Something went wrong while uploading.";
                                         }
                                           }
                                             }else{
                                               if (strlen($oldPhotoName) > 255) {
                                                 $leng2PhotoName = substr($oldPhotoName, 0, 240);
                                                 $newLeng2PhotoName = $leng2PhotoName . date('His') . $extensionPhoto;
                                                 if(move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/". $newLeng2PhotoName)) {
                                                   $insertPhoto3 = "INSERT INTO Posts ('ImageName') VALUES (?) WHERE CreatedByUserId = ?";
                                                   $insertP3 = Query($conn, $insertPhoto3,"si", $uploadPhoto3, $id);
                                                   if (mysqli_query($conn, $insertPhoto3)) {
                                                       echo "Your post has been sent.";
                                                   } else {
                                                       echo "Something went wrong while uploading.";
                                                   }
                                                     }else{
                                                       echo "Something went wrong while uploading.";
                                                         }
                                                           }else{
                                                             if(move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/". $_FILES["photoUpload"]["name"])) {
                                                               $channelId = "SELECT `ChannelId` FROM Followed, Channels WHERE UserId = ? AND Name = ?";
                                                               $chId = Query($conn, $channelId, "is", $id, $_POST['searchChannel']);
                                                               $insertPhoto = "INSERT INTO Posts ('CreatedByUserId','ChannelId','ImageName','Caption','Date') VALUES (?,?,?,?,?)";
                                                               $insertP = Query($conn, $insertPhoto, "iisss", $id, $chId[0]["ChannelId"], $_FILES["photoUpload"]["name"], $photoDescription, $date);
                                                               if (1) {
                                                                   echo "Your post has been sent.";
                                                               } else {
                                                                   echo "Something went wrong while uploading.";
                                                               }
                                                                 }else{
                                                                   echo "Something went wrong while uploading.";
                                                                     }
                                                                       }
                                                                         }
                                                                           }
                                                                             }else{
                                                                               echo "Invalid file type. Must be gif, jpg, png or jpeg.";
                                                                                 }
                                                                                   }else{
                                                                                     echo "Invalid file size. Must be less than 3MB.";
                                                                                       }
                                                                                         }else{
                                                                                           echo "Please select a channel.";
                                                                                             }
                                                                                               }

if (isset($_POST['submitVideo'])) {
  if (!empty($_POST['searchChannel'])) {
    $videoDescription = $_POST["videoDescription"];
    if ($_FILES["videoUpload"]["size"] < 100000000) {
      $acceptedVideoTypes = ["video/mov", "video/swf", "video/mp4", "video/mkv", "video/flv", "video/wmv", "video/avi", "video/3gp", "video/vob", "video/aaf", "video/mod", "video/mpeg"];
      $videoinfo = finfo_open(FILEINFO_MIME_TYPE);
      $uploadedVideoType = finfo_file($videoinfo, $_FILES["videoUpload"]["tmp_name"]);
        if(in_array($uploadedVideoType, $acceptedVideoTypes)) {
          if ($_FILES["videoUpload"]["error"] > 0) {
            echo "Error: " . $_FILES["videoUpload"]["error"] . "<br />";
              }else{
                $oldVideoName = $_FILES["videoUpload"]["name"];
                $extensionVideo = pathinfo($oldVideoName, PATHINFO_EXTENSION);
                  if (file_exists("../uploads/" . $_FILES["videoUpload"]["name"])) {
                    $newVideoName = $oldVideoName . date('His') . '.' . $extensionVideo;
                      if (strlen($newVideoName) > 255) {
                        $lengVideoName = substr($newVideoName, 0, 240);
                        $newLengVideoName = $lengVideoName . date('His') . $extensionVideo;
                          if(move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/". $newLengVideoName)) {
                            $insertVideo = "INSERT INTO Posts ('VideoName') VALUES (?) WHERE CreatedByUserId = ?";
                            $insertV = Query($conn, $insertVideo,"si", $uploadVideo, $id);
                            if (mysqli_query($conn, $insertVideo)) {
                                echo "Your post has been sent.";
                            } else {
                                echo "Something went wrong while uploading.";
                            }
                              }else{
                                echo "Something went wrong while uploading.";
                                  }
                                    }else{
                                      if(move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/". $newVideoName)) {
                                        $insertVideo2 = "INSERT INTO Posts ('VideoName') VALUES (?) WHERE CreatedByUserId = ?";
                                        $insertV2 = Query($conn, $insertVideo2,"si", $uploadVideo2, $id);
                                        if (mysqli_query($conn, $insertVideo2)) {
                                            echo "Your post has been sent.";
                                        } else {
                                            echo "Something went wrong while uploading.";
                                        }
                                          }else{
                                            echo "Something went wrong while uploading.";
                                              }
                                                }
                                                  }else{
                                                    if (strlen($oldVideoName) > 255) {
                                                      $leng2VideoName = substr($oldVideoName, 0, 240);
                                                      $newLeng2VideoName = $leng2VideoName . date('His') . $extensionVideo;
                                                        if(move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/". $newLeng2VideoName)) {
                                                          $insertVideo3 = "INSERT INTO Posts ('VideoName') VALUES (?) WHERE CreatedByUserId = ?";
                                                          $insertV3 = Query($conn, $insertVideo3,"si", $uploadVideo3, $id);
                                                          if (mysqli_query($conn, $insertVideo3)) {
                                                              echo "Your post has been sent.";
                                                          } else {
                                                              echo "Something went wrong while uploading.";
                                                          }
                                                            }else{
                                                              echo "Something went wrong while uploading.";
                                                                }
                                                                  }else{
                                                                    if(move_uploaded_file($_FILES["videoUpload"]["tmp_name"], "../uploads/". $_FILES["videoUpload"]["name"])) {
                                                                      $insertVideo4 = "INSERT INTO Posts ('VideoName') VALUES (?) WHERE CreatedByUserId = ?";
                                                                      $insertV4 = Query($conn, $insertVideo4,"si", $uploadVideo4, $id);
                                                                      if (mysqli_query($conn, $insertVideo4)) {
                                                                          echo "Your post has been sent.";
                                                                      } else {
                                                                          echo "Something went wrong while uploading.";
                                                                      }
                                                                        }else{
                                                                          echo "Something went wrong while uploading.";
                                                                            }
                                                                              }
                                                                                }
                                                                                  }
                                                                                    }else{
                                                                                      echo "Invalid file type. Must be mov, swf, mp4, mkv, flv, wmv, avi, 3gp, vob, aaf, mod or mpeg.";
                                                                                        }
                                                                                          }else{
                                                                                            echo "Invalid file size. Must be less than 100MB.";
                                                                                              }
                                                                                                }else{
                                                                                                  echo "Please select a channel.";
                                                                                                    }
                                                                                                      }

  if(isset($_POST['submitText'])) {
    if(!empty($_POST['searchChannel'])) {
      $text = $_POST["textUpload"];
      if(!empty($_POST['textUpload'])) {
        echo "Your post has been uploaded.";
      }else{
        echo "Please enter text.";
      }
    }else{
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
