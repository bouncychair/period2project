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


            $targetDir = "../uploads/";
            $fileName = $_FILES["mainUpload"]["name"];
            $tmpFile1 = $_FILES["mainUpload"]["tmp_name"];
            $targetFilePath = $targetDir . $fileName;
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $whatsuploaded1 = finfo_file($fileinfo, $_FILES["mainUpload"]["tmp_name"]);
            $regdate = date("Y-m-d");
            $randnum = rand(1, 1000);
            $rename1 = 'Picture'.date("Ymd").$randnum;
            $targetFilePath = $targetDir . $rename1;
            $finalName = $rename1 . basename($_FILES["mainUpload"]["name"]);

                if (isset($_POST["fileSubmit"]) && !empty($_FILES["mainUpload"]["name"])) {
                  $allowTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
                    if (in_array($whatsuploaded1, $allowTypes)) {
                    if($_FILES["mainUpload"]["size"] < 10000000) {
                        if (move_uploaded_file($_FILES["mainUpload"]["tmp_name"], $targetFilePath . basename($_FILES["mainUpload"]["name"]))) {
                          $sql = "UPDATE Channels SET `MainPicture` = ? WHERE id = ?";
                            if (Query($conn, $sql, "si", $finalName, $channelId)) {
                              $statusMsg = "Records inserted successfully.";
                              GoToUrl("channel.php?ChannelId=$channelId");
                            } 
                        } 
                    } 
                    } 
                } 


/* CHANGE COVER PICTURE OF THE CHANNEL ----------------------------------------------------------------- */           

            $targetDir = "../uploads/";
            $fileName1 = $_FILES["coverUpload"]["name"];
            $tmpFile2 = $_FILES["coverUpload"]["tmp_name"];
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $whatsuploaded2 = finfo_file($fileinfo, $_FILES["coverUpload"]["tmp_name"]);
            $regdate = date("Y-m-d");
            $randnum = rand(1, 1000);
            $rename2 = 'Picture'.date("Y-m-d").$randnum;
            $targetFilePath1 = $targetDir . $rename2;
            $finalName1 = $rename2 . basename($_FILES["coverUpload"]["name"]);
            
                if (isset($_POST["fileSubmit"]) && !empty($_FILES["coverUpload"]["name"])) {
                  $allowTypes = ["image/gif", "image/jpg", "image/jpeg", "image/png"];
                  if (in_array($whatsuploaded2, $allowTypes)) {
                    if($_FILES["coverUpload"]["size"] < 10000000) {
                        if (move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $targetFilePath1 . basename($_FILES["coverUpload"]["name"]))) {
                          $sql = "UPDATE Channels SET `CoverPicture` = ? WHERE id = ?";
                          if (Query($conn, $sql, "si",$finalName1, $channelId)) {
                              $statusMsg = "Records inserted successfully.";
                              GoToUrl("channel.php?ChannelId=$channelId");
                          } 
                        } 
                    } 
                  } 
                }
?>

