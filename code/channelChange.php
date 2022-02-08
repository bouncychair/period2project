<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css" type="text/css">
    <title>Upload Document</title>
</head>
<body>
    
</body>
</html>
<?php
include "connect.php";
include "utils.php";
$id = GetUserId($conn);
$channelId = $_GET['ChannelId'];


/* CHANGE MAIN PICTURE OF THE CHANNEL ----------------------------------------------------------------- */


$upload = $_FILES['mainUpload']['name'];
if(isset($_POST['fileSubmit'])) {
    if(!empty($_FILES['mainUpload']['name'])) {
        $sql = "UPDATE Channels SET `MainPicture` = ? WHERE id = ?";
        $data = Query($conn, $sql, "si", $upload, $channelId); ?> <script>
        window.location = 'channel.php?ChannelId=<?php echo $channelId ?>'; 
        </script> <?php
    } else {
        ?> <script>
        window.setTimeout(function() {
        window.location = 'channel.php?ChannelId=<?php echo $channelId ?>';
        } , 4000);
        </script> <?php
    }
}


            $targetDir = "../uploads/";
            $fileName = $_FILES["mainUpload"]["name"];
            $tmpFile1 = $_FILES["mainUpload"]["tmp_name"];
            $targetFilePath = $targetDir . $fileName;
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);

              if (isset($_POST["fileSubmit"]) && !empty($_FILES["mainUpload"]["name"])) {
                  $allowTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
                  if (in_array($fileinfo, $allowTypes)) {
                    if($_FILES["mainUpload"]["size"] < 10000000) {
                      if (move_uploaded_file($_FILES["mainUpload"]["tmp_name"], $targetFilePath)) {
                          $sql = "INSERT INTO Channels (`MainPicture`) VALUES = (?) WHERE id = ?";
                          if (Query($conn, $sql, "i", $channelId)) {
                              $statusMsg = "Records inserted successfully.";
                          } else {
                              $statusMsg = "File upload failed, please try again.";
                          }
                      } else {
                          $statusMsg = "Sorry, there was an error uploading your file.";
                      }
                    } else {
                        $statusMsg = "Sorry, your file too big";
                    }
                  } else {
                      $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                  }
              } 


/* CHANGE COVER PICTURE OF THE CHANNEL ----------------------------------------------------------------- */           

$upload1 = $_FILES['coverUpload']['name'];
if(isset($_POST['fileSubmit'])) {
    if(!empty($_FILES['coverUpload']['name'])) {
        $sql = "UPDATE Channels SET `CoverPicture` = ? WHERE id = ?";
        $data = Query($conn, $sql, "si", $upload1, $channelId); ?> <script>
        window.location = 'channel.php?ChannelId=<?php echo $channelId ?>'; 
        </script> <?php
    } else {
        ?> <script> alert("Please, select a file");
        window.setTimeout(function() {
        window.location = 'channel.php?ChannelId=<?php echo $channelId ?>';
        } , 4000);
        </script> <?php
    }
}

            $targetDir = "../uploads/";
            $fileName = $_FILES["coverUpload"]["name"];
            $tmpFile2 = $_FILES["coverUpload"]["tmp_name"];
            $targetFilePath = $targetDir . $fileName;
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);

              if (isset($_POST["fileSubmit"]) && !empty($_FILES["coverUpload"]["name"])) {
                  $allowTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
                  if (in_array($fileinfo, $allowTypes)) {
                    if($_FILES["coverUpload"]["size"] < 10000000) {
                        if (move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $targetFilePath)) {
                          $sql = "INSERT INTO Channels (`CoverPicture`) VALUES = (?) WHERE id = ?";
                          if (Query($conn, $sql, "i", $channelId)) {
                              $statusMsg = "Records inserted successfully.";
                          } else {
                              $statusMsg = "File upload failed, please try again.";
                          }
                      } else {
                          $statusMsg = "Sorry, there was an error uploading your file.";
                      }
                    } else {
                        $statusMsg = "Sorry, your file too big";
                    }
                  } else {
                      $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                  }
              } 
?>

