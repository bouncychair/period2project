<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);

$query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
$data = Query($conn, $query, "i", $id);
/*$query = "SELECT * FROM users WHERE id = ?"; // ? binding the operator $data
$data = Query($conn, $query, "i", 1); // i for integer 
echo $data[0]["Username"]; // gets from array 0 the needed FirstName
die();*/ ?>
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
            echo "<img max-width=400px src='$imageURL' alt='' />";
            $statusMsg = '';
        ?></div> 
        <?php
            

            // File upload path
            $targetDir = "../uploads/";
            $fileName = $_FILES["file"]["name"];
            $file= $_FILES["file"]['tmp_name'];
            $targetFilePath = $targetDir . $fileName;
            $info= finfo_open(FILEINFO_MIME_TYPE);

            if (isset($_POST["submitty"]) && !empty($fileName)) {
                // Allow certain file formats
                $allowTypes =["image/jpg", "image/jpeg", "image/png", "image/gif"];
                if (in_array($info, $allowTypes)) {
                    // Upload file to server
                    if (move_uploaded_file($file, $targetFilePath)) {
                        // Insert image file name into database
                        $sql = "INSERT INTO Users (`ProfilePicture`) VALUES = (?) WHERE id = ?";
                        if (mysqli_query($conn, $sql)) {
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
            } else {
            
            // Display status message
            echo $statusMsg;
            }
            ?>
         

        <div class="name">
            <p><?php
                $username = array_column($data, 'Username');
                $sql = "SELECT Username FROM Users WHERE id = ?";
                $data = Query($conn, $sql, "s", $id);
                echo "<b>Username:</b> " . "<br>"  . $data[0]["Username"];
                ?></p>
        </div>
    </div>

    <div id="upload">
        <form action="upload.php" method="POST" enctype="multipart/form-data"> <!-- does not take the uploaded files because it overwrites it with 2x submitty-->
            <p><u>Choose a new Profile Picture:</u></p>
            <label for="photo-upload"> <b> Choose Photo</b></label> 
            <input type="file" name="file" id="photo-upload" style="display: none">
            <input type="submit" name="submitty" value="Upload">
            
        </form>
    </div>

    <div id="change">
        <form action="upload.php" method="POST" >
            <p><u>Change your Password here:</u></p>
           <input type="text" name="password" placeholder="Update Password">
           <input type="submit" name="submit" value="Change Password">
        </form>
    </div>

    <div id="delete">
            <form id="del" action="" method="POST">
            <button class="delete" name="deleteUser" onclick="alert('Your Accound is now deleted! Please confirm')"> Delete Account</button>
                <?php
                    if(isset($_POST['deleteUser'])) {
                        $query = "DELETE FROM `Users` WHERE id = ?";
                        $data = Query($conn, $query, "i", $id);
                   
                }
              ?>
            </form>
    
    <div id="loggout">
            <form id="log" action="" method="POST">
            <button class="loggoutt" name="out"> Logout</button>
           <?php
            if(isset($_POST['out'])) {
                unset($_SESSION["id"]);
                unset($_SESSION["name"]);
                header("Location:authentication.php");
            }
            ?>
            </form>

    </div>

    </div>
    <br><br>
    <?php include "footer.php"; ?>
   
</body>

</html>