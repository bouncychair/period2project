<?php
session_start();
require "connect.php";
require "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
?>

<?php
//if (isset($_POST['submit'])) {
/*  $targetDir = "../uploads/";
  $fileName = @basename($_FILES["photoUpload"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if (isset($_POST["submitPhoto"]) && !empty($_FILES["photoUpload"]["name"])) {
      // Allow certain file formats
      $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
      if (in_array($fileType, $allowTypes)) {
          // Upload file to server
          if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '../uploads/' . $_FILES["photoUpload"]["name"])) {
              // Insert image file name into database
              /*$sql = "INSERT INTO Users (`ProfilePicture`) VALUES = (?) WHERE id = ?";
              if (mysqli_query($conn, $sql)) {
                  $statusMsg = "Records inserted successfully.";
              } else {
                  $statusMsg = "File upload failed, please try again.";
              }
              echo "uploaded";
          } else {
              $statusMsg = "Sorry, there was an error uploading your file.";
          }
      } else {
          $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
      }
  }// else {

  // Display status message
  //echo $statusMsg;

  /*if (!empty($_POST['searchChannel'])) {
    if ($_POST['postType'] == 'photo') {
      if (!empty($_POST['photo'])) {
        if ($_FILES['photo']['size'] < 2000000) {
          $acceptedFileTypes = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
          $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
          $uploadedFileType = finfo_file($fileinfo, $_FILES['photo']['tmp_name']);
          if (in_array($uploadedFileType, $acceptedFileTypes)) {
            if ($_FILES['photo']['error'] = 0) {
              $oldPhotoName = $_FILES['photo']['name'];
              $extensionPhoto = pathinfo($oldPhotoName, PATHINFO_EXTENSION);
              if (file_exists("../uploads/" . $_FILES['photo']['name'])) {
                $newPhotoName = $oldPhotoName . date('Ymd') . '.' . $extensionPhoto;
                if (strlen($newPhotoName) > 255) {
                  $lengPhotoName = substr($newPhotoName, 0, 240);
                  $newLengPhotoName = $lengPhotoName . date('Ymd') . $extensionPhoto;
                  if (move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $newLengPhotoName)) {
                    $_SESSION['channelName'] = $_POST['searchChannel'];
                    $_SESSION['photoDescription'] = $_POST['photoDescription'];
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                } else {
                  if (move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $newPhotoName)) {
                    $_SESSION['channelName'] = $_POST['searchChannel'];
                    $_SESSION['photoDescription'] = $_POST['photoDescription'];
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                }
              } else {
                if (strlen($newPhotoName) > 255) {
                  $leng2PhotoName = substr($oldPhotoName, 0, 240);
                  $newLeng2PhotoName = $leng2PhotoName . $extensionPhoto;
                  if (move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $newLeng2PhotoName)) {
                    $_SESSION['channelName'] = $_POST['searchChannel'];
                    $_SESSION['photoDescription'] = $_POST['photoDescription'];
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                } else {
                  if (move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $_FILES['photo']['name'])) {
                    $_SESSION['channelName'] = $_POST['searchChannel'];
                    $_SESSION['photoDescription'] = $_POST['photoDescription'];
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                }
              }
            } else {
              echo "An error occurred while uploading a file. Please try again";
            }
          } else {
            echo "File must be gif, jpg, jpeg, png";
          }
        } else {
          echo "File must be less than 2MB";
        }
      } else {
        echo "Choose a file to upload";
      }
    }
    if ($_POST['postType'] == 'video') {
      if (!empty($_POST['video'])) {
        if ($_FILES['video']['size'] < 100000000) {
          $acceptedFileTypes = ['video/mov', 'video/swf', 'video/mp4', 'video/mkv', 'video/flv', 'video/wmv', 'video/avi', 'video/3gp', 'video/vob', 'video/aaf', 'video/mod', 'video/mpeg'];
          $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
          $uploadedFileType = finfo_file($fileinfo, $_FILES['video']['tmp_name']);
          if (in_array($uploadedFileType, $acceptedFileTypes)) {
            if ($_FILES['video']['error'] = 0) {
              $oldVideoName = $_FILES['video']['name'];
              $extensionVideo = pathinfo($oldVideoName, PATHINFO_EXTENSION);
              if (file_exists("../uploads/" . $_FILES['video']['name'])) {
                $newVideoName = $oldVideoName . date('Ymd') . '.' . $extensionVideo;
                if (strlen($newVideoName) > 255) {
                  $lengVideoName = substr($newVideoName, 0, 240);
                  $newLengVideoName = $lengVideoName . date('Ymd') . $extensionVideo;
                  if (move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/" . $newLengVideoName)) {
                    //uploaded
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                } else {
                  if (move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/" . $newVideoName)) {
                    $_SESSION['channelName'] = $_POST['searchChannel'];
                    $_SESSION['videoDescription'] = $_POST['videoDescription'];
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                }
              } else {
                if (strlen($newVideoName) > 255) {
                  $leng2VideoName = substr($oldVideoName, 0, 240);
                  $newLeng2VideoName = $leng2VideoName . $extensionVideo;
                  if (move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/" . $newLeng2VideoName)) {
                    //uploaded
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                } else {
                  if (move_uploaded_file($_FILES['video']['tmp_name'], "../uploads/" . $_FILES['video']['name'])) {
                    //uploaded
                  } else {
                    echo "An error occurred while uploading a file. Please try again";
                  }
                }
              }
            } else {
              echo "An error occurred while uploading a file. Please try again";
            }
          } else {
            echo "File must be mov, swf, mp4, mkv, flv, wmv, avi, 3gp, vob, aaf, mod, mpeg";
          }
        } else {
          echo "File must be less than 100MB";
        }
      } else {
        echo "Choose a file to upload";
      }
    }
    if ($_POST['postType'] == 'text') {
      if (!empty($_POST['text'])) {
        //db text
      } else {
        echo "Please enter text";
      }
    }
  } else {
    echo "Enter the name of the channel";
  }*/
//}
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
  <?php
  if (isset($_POST['submitPhoto'])) {
  if ($_FILES["photoUpload"]["size"] < 60000)
  {
      //The user may only upload .gif or .jpeg files
      $acceptedFileTypes = ["image/gif", "image/jpg", "image/jpeg"];
      $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
      $uploadedFileType = finfo_file($fileinfo, $_FILES["photoUpload"]["tmp_name"]);
      //A shorter version of line 9 - 11
      //$uploadedFileType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES["uploadedFile"]["tmp_name"]);

      //If the type is in the array, proceed
      if(in_array($uploadedFileType, $acceptedFileTypes))
      {
          if ($_FILES["photoUpload"]["error"] > 0)
          {
              echo "Error: " . $_FILES["photoUpload"]["error"] . "<br />";
          }else{
              echo "Upload: " . $_FILES["photoUpload"]["name"] . "<br />";
              echo "Type: " . $uploadedFileType . "<br />";
              echo "Size: " . ($_FILES["photoUpload"]["size"] / 1024) . " Kb<br />";
              echo "Stored in: " . $_FILES["photoUpload"]["tmp_name"];

              //Check if the file exists on the server (as we want to upload it with the original name)
              if (file_exists("../uploads/" . $_FILES["photoUpload"]["name"])){
                  echo $_FILES["photoUpload"]["name"] . " already exists. ";
              }else{
                  //If the file does not exist, transfer the file from the temporary folder to the upload folder using the original upload name
                  if(move_uploaded_file($_FILES["photoUpload"]["tmp_name"], "../uploads/". $_FILES["photoUpload"]["name"])){
                      echo "Stored";
                  }else{
                      echo "Something went wrong while uploading.";
                  }
              }
          }
      }else{
          echo "Invalid file type. Must be gif, jpg or jpeg.";
      }
  }else{
      echo "Invalid file size. Must be less than 60kb.";
  }
  }
  ?>
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
        <input type="file" id="photoUpload" name="photoUpload">
        <input type="text" id="photoDescription" name="photoDescripion" placeholder="Description" maxlength="500">
        <input type="submit" value="Post" id="submitPhoto" name="submitPhoto">
      </div>

      <div id="postVideo" style="display: none">
        <input type="file" id="videoUpload" name="videoUpload">
        <input type="text" id="videoDescription" name="videoDescripion" placeholder="Description" maxlength="500">
        <input type="submit" value="Post" id="submitVideo" name="submitVideo">
      </div>

      <div id="postText" style="display: none">
        <input type="text" id="textUpload" name="textUpload" placeholder="Your post" maxlength="500">
        <input type="submit" value="Post" id="submitText" name="submitText">
      </div>
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
