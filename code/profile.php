<?php
session_start();
include "connect.php";
include "utils.php";
//include "upload.php";   

CheckIdentifier();
$id = GetUserId($conn);

$query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
$data = Query($conn, $query, "i", $id);
/*$query = "SELECT * FROM users WHERE id = ?"; // ? binding the operator $data
$data = Query($conn, $query, "i", 1); // i for integer 
echo $data[0]["Username"]; // gets from array 0 the needed FirstName
die();*/?>
<!DOCTYPE html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="Stylesheet.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="header">
                <img src="../img/logo1.png" alt="TocTic Logo" />
                <h2>TocTic</h2>
    </div>
            
            <div id="nickname">
                <div id="pb">
                  <?php 
                   $sql = "SELECT ProfilePicture FROM Users WHERE id = ?";
                   $data = Query($conn, $sql, "i", $id);
                   $imageURL = '../uploads/' . $data[0]["ProfilePicture"];
                   echo "<img width=400px src='$imageURL' alt='' />";
                    $statusMsg = '';
 
                       // File upload path
                        $targetDir = "../uploads/";
                        $fileName = @basename($_FILES["file"]["name"]);
                        $targetFilePath = $targetDir . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                        if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
                            // Allow certain file formats
                            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
                            if (in_array($fileType, $allowTypes)) {
                                // Upload file to server
                                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                                    // Insert image file name into database
                                    $sql = "UPDATE `users` SET `ProfilePicture` = `$fileName` WHERE id = ?"; 
                                    if (mysqli_query($conn, $sql)) {
                                        echo "Records inserted successfully.";
                                    } else {
                                        $statusMsg = "File upload failed, please try again.";
                                    }
                                } else {
                                    $statusMsg = "Sorry, there was an error uploading your file.";
                                }
                            } else {
                                $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                            }
                        } else {
                        }
                        // Display status message
                        echo $statusMsg;
                        ?>             
                </div>
               
                <div class="name">
                 <p><?php
                    $username = array_column($data,'Username');
                    $sql = "SELECT Username FROM Users WHERE id = ?";
                    $data= Query($conn, $sql, "s", $id);
                        echo "<b>Username:</b> " .  "<i>" . $data[0]["Username"] . "</i>";
                    ?></p>
                </div>
            </div>

            <div id="upload">
             <form action="" method="post" enctype="multipart/form-data">
            <p>Select Image File to Upload:</p>
            <input type="file" name="file">
            <input type="submit" name="submit" value="Upload">
                </form>
                </div>
                <div id="change">
             <form action="" method="post" enctype="multipart/form-data">
            
             <p>Change your Nickname here:</p>
            <input type="text" name="username" placeholder="New Username">
            <input type="submit" name="submit" value="Change">
                </form>

                </div>
                <br><br>
                    <div class="footer">
                        <img onClick="location.href='main.php'" id="footer_menu" src="../img/Project2_menu.png" alt="Main_menu">
                        <img onClick="location.href='search.php'" id="footer_channels" src="../img/Project2_channels.png" alt="Channels">
                        <img onClick="location.href='...'" id="footer_notifications" src="../img/Project2_notification.png" alt="Notifications">
                        <img onClick="location.href='...'" id="footer_add_post" src="../img/Project2_add_post.png" alt="Add_post">
                        <img onClick="location.href='profile.php'" id="footer_profile" src="../img/Project2_profile.png" alt="Profile">
                    </div>
                    <script>
                        url = new URL(window.location.href);
                        currentChannel = url.searchParams.get("C");
                        document.getElementById(currentChannel).style.boxShadow = "0 0 20px purple";

                        function Like(UserId, PostId, Reaction) {
                            $.ajax({
                                type: 'POST',
                                url: 'like.php',
                                dataType: "json",
                                data: ({
                                    "UserId": UserId,
                                    "PostId": PostId,
                                    "Reaction": Reaction
                                }),
                                success: function(data) {
                                    console.log(data);
                                }
                            });
                            return false;
                }
            </script>
        </body>

        </html>
<!--//add security //looking for user who uploaded-->



