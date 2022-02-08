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
    <h2>Create Channel</h2>
    <div class="post_type">
        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <div class="channelName">
                <input type="text" id="channelName" name="channelName" placeholder="Channel name">
            </div>
            <div class="channelDescription">
                <input type="text" id="channelDescription" name="channelDescription" placeholder="Channel description">
            </div>


            <select id="postType" name="postType" onchange="post()">
                <option value="photo" selected>Photo</option>
                <option value="video">Video</option>
                <option value="text">Text</option>
                <option value="Everything">Everything</option>
            </select>

            <div class="user-image mb-3 text-center">
                <div style="width: 100px; height: 100px; overflow: hidden; background: transparent; margin: 0 auto">
                    <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
                </div>
            </div>

            <div class="mainChannelPhoto">
                Select your main photo
                <input type="file" name="mainphoto">
            </div>
            <div class="coverChannelPhoto">
                Select your cover photo
                <input type="file" name="coverphoto">
                <input type="submit" name="submit" value="Enter">
                <style>
                    input[type=button],
                    input[type=submit],
                    input[type=reset] {
                        background-color: white;
                        border-radius: 35px;
                        color: grey;
                        width: 60%;
                    }
                </style>
            </div>


            <?php
            //checking if the submit button is pressed
            if (isset($_POST['submit'])) {

                $count_upload = 0;
                //checking if there is a channel name
                if (!empty($_POST['channelName'])) {
                    $channelName = $_POST['channelName'];
                    //Checking if the Channel name is taken
                    $sql_channelName = "SELECT * FROM Channels WHERE `Name` = ?";
                    $result_channel_name = Query($conn, $sql_channelName, "s", $_POST['channelName']);
                    if (sizeof($result_channel_name) > 0) {
                        echo '<span style="color:red;text-align:center;font-size:18px;">This name is already taken</span>';
                    } else {
                        $count_upload += 1;
                    }
                } else {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Please enter channel name</span>';
                }
                //checking if the channel description is empty
                if (!empty($_POST['channelDescription'])) {
                    $count_upload += 1;
                    $channelDescription = $_POST['channelDescription'];
                } else {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Please enter channel description</span>';
                }


                //
                //
                //
                //Checking MAIN picture

                //Changing name
                $randomno = rand(0, 100000);
                $rename = 'Picture' . date('Ymd') . $randomno;
                $target_dir = "../uploads/";
                // Get file path
                $target_file_main = $target_dir . $rename . basename($_FILES["mainphoto"]["name"]);
                $sqlMainPhoto = $rename . basename($_FILES["mainphoto"]["name"]);
                // Get file extension
                $imageExtension = strtolower(pathinfo($target_file_main, PATHINFO_EXTENSION));
                // Allowed file types
                $allowd_file_ext = array("jpg", "jpeg", "png", "gif");
                //checking if there is an uploaded file
                if (!file_exists($_FILES["mainphoto"]["tmp_name"])) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Please select main image to upload.</span>';
                } else if (!in_array($imageExtension, $allowd_file_ext)) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Allowed file formats are jpg, jpeg or png.</span>';
                } else if ($_FILES["mainphoto"]["size"] > 2097152) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">File is too large. File size should be less than 2 megabytes.</span>';
                } else {
                    if (move_uploaded_file($_FILES["mainphoto"]["tmp_name"], $target_file_main)) {
                        $count_upload += 1;
                    } else {
                        echo '<span style="color:red;text-align:center;font-size:18px;">Error uploading main picture</span>';
                    }
                }

                //
                //
                //
                // Checking COVER photo

                // Get file path
                $target_file_cover = $target_dir . $rename . basename($_FILES["coverphoto"]["name"]);
                $sqlCoverPicture = $rename . basename($_FILES["coverphoto"]["name"]);
                // Get file extension
                $imageExtension = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));
                //checking if there is an uploaded file
                if (!file_exists($_FILES["coverphoto"]["tmp_name"])) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Please select cover image to upload.</span>';
                } else if (!in_array($imageExtension, $allowd_file_ext)) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">Allowed file formats are jpg, jpeg or png.</span>';
                } else if ($_FILES["coverphoto"]["size"] > 2097152) {
                    echo '<span style="color:red;text-align:center;font-size:18px;">File is too large. File size should be less than 2 megabytes.</span>';
                } else {
                    if (move_uploaded_file($_FILES["coverphoto"]["tmp_name"], $target_file_cover)) {
                        $count_upload += 1;
                    } else {
                        echo '<span style="color:red;text-align:center;font-size:18px;">Error uploading cover picture</span>';
                    }
                }

                if ($count_upload == 4) {
                    $channel_type = $_POST['postType'];
                    $regdate = date("Y-m-d");
                    //$stmt_insert = "INSERT INTO `channels` (`CreatedByUserId`,`Name`,`MainPicture`,`CoverPicture`,`Description`,`RegDate`,`Type`) VALUES ('$id', '$channelName', '$target_file_main', '$target_file_cover', '$channelDescription', '$regdate', '$channel_type')"; 
                    $insert_info = "INSERT INTO `Channels` (`CreatedByUserId`, `Name`, `MainPicture`, `CoverPicture`, `Description`, `RegDate`, `Type`) VALUES (?,?,?,?,?,?,?)";
                    $insertQ = Query($conn, $insert_info, "issssss", $id, $channelName, $sqlMainPhoto, $sqlCoverPicture, $channelDescription, $regdate, $channel_type);
                    if ($insertQ == 1) {
                        echo "<br>";
                        echo '<span style="color:green;text-align:center;font-size:18px;">Channel created successfully</span>';
                    } else {
                        echo "ERROR: Could not able to execute. " . mysqli_error($conn);
                    }
                } else {
                    echo "<br>";
                    echo '<span style="color:red;text-align:center;font-size:18px;">An error occured</span>';
                }
            }
            ?>

        </form>


    </div>
    <?php include "footer.php"; ?>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imgPlaceholder').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#chooseFile").change(function() {
            readURL(this);
        });
    </script>
</body>

</html>