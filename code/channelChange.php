<?php
session_start();
include "connect.php";
include "utils.php";
$id = GetUserId($conn);
$channelId = $_GET['ChannelId'];


/* CHANGE NAME OF THE CHANNEL -------------------------------------------------------------------- */



/* CHANGE DESCRIPTION OF THE CHANNEL --------------------------------------------------------- */



/* CHANGE MAIN PICTURE OF THE CHANNEL ----------------------------------------------------------------- */


$upload = $_FILES['mainUpload']['name'];
if(isset($_POST['fileSubmit'])) {
    if(!empty($_FILES['mainUpload']['name'])) {
        $sql = "UPDATE Channels SET `MainPicture` = ? WHERE id = ?";
        $data = Query($conn, $sql, "si", $upload, $channelId);
        header("location: channel.php?ChannelId=$channelId");
    } else {
        echo "Select something else";
    }
}

            $targetDir = "../uploads/";
            $fileName = @basename($_FILES["mainUpload"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

              if (isset($_POST["fileSubmit"]) && !empty($_FILES["mainUpload"]["name"])) {
                  // Allow certain file formats
                  $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                  if (in_array($fileType, $allowTypes)) {
                      // Upload file to server
                      if (move_uploaded_file($_FILES["mainUpload"]["tmp_name"], $targetFilePath)) {
                          // Insert image file name into database
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
                      $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                  }
              } 


/* CHANGE COVER PICTURE OF THE CHANNEL ----------------------------------------------------------------- */           

$upload1 = $_FILES['coverUpload']['name'];
if(isset($_POST['fileSubmit'])) {
    if(!empty($_FILES['coverUpload']['name'])) {
        $sql = "UPDATE Channels SET `CoverPicture` = ? WHERE id = ?";
        $data = Query($conn, $sql, "si", $upload1, $channelId);
        header("location: channel.php?ChannelId=$channelId");
    } else {
        echo "Select something else";
    }
}

            $targetDir = "../uploads/";
            $fileName = @basename($_FILES["coverUpload"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

              if (isset($_POST["fileSubmit"]) && !empty($_FILES["coverUpload"]["name"])) {
                  // Allow certain file formats
                  $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                  if (in_array($fileType, $allowTypes)) {
                      // Upload file to server
                      if (move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $targetFilePath)) {
                          // Insert image file name into database
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
                      $statusMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                  }
              } 

?>

