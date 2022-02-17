<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);

$query = "SELECT `ChannelId` FROM Followed WHERE UserId = ?";
$data = Query($conn, $query, "i", $id);
$errorMsg = "";
$successMsg = "";

if (isset($_POST["submit"])) {
    if (!empty($_POST["password"])) {
        if (strlen($_POST["password"]) > 1 && strlen($_POST["password"]) < 10  && ctype_alnum($_POST["password"])) {

            $password =  password_hash($_POST["password"], PASSWORD_DEFAULT);
            $sql = "UPDATE Users SET `Password` = ? WHERE id=?";
            if(Query($conn, $sql, "si", $password, $id)){
                $successMsg = "Password has been changed!";
            }else{
                $errorMsg = "Something went wrong:( Please try again";
            }    
            
        }
    } else {
        $errorMsg = 'Password can not be empty';
    }
}
if (isset($_POST["submitty"])) {
    if (!empty($_FILES['file']['name'])) {
        // File upload path
        $targetDir = "../uploads/";
        $fileName = $_FILES["file"]["name"];
        $file = $_FILES["file"]["tmp_name"];
        $targetFilePath = $targetDir . $fileName;
        $info = finfo_open(FILEINFO_MIME_TYPE);
        $uploadtype = finfo_file($info, $file);
        // Allow certain file formats

        $allowTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
        if (in_array($uploadtype, $allowTypes)) {
            // Upload file to server

            if (move_uploaded_file($file, $targetFilePath)) {
                // Insert image file name into database
                $sql = "UPDATE Users SET `ProfilePicture` = ? WHERE id=?";
                $data = Query($conn, $sql, "si", $fileName, $id);
                $successMsg = "Profile picture has been updated!";

            } else {
                $errorMsg = "File upload failed, please try again.";
            }
        } else {
            $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
        }
    } else {
        $errorMsg = "Please choose a Picture";
    }
}


?>
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
            ?></div>


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
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- does not take the uploaded files because it overwrites it with 2x submitty-->
            <p><u>Click below to choose a new Profile Picture:</u></p>
            <label for="photo-upload"> <b> Choose Photo</b></label>
            <input type="file" name="file" id="photo-upload" style="display: none">
            <input type="submit" name="submitty" value="Upload">

        </form>
    </div>

    <div id="change">
        <form action="" method="POST">
            <p><u>Change your Password below:</u></p>
            <input type="text" name="password" placeholder="Update Password">
            <input type="submit" name="submit" value="Change Password">
            <?php 
            echo'<p style="color:red">' . $errorMsg . ' </p>';
            echo'<p style="color:#2ecc71">' . $successMsg . ' </p>';
            ?>
            
        </form>
    </div>

    <div id="delete">
        <form id="del" action="" method="POST">
            <button class="delete" name="deleteUser" onclick="alert('Your Accound is now deleted! Please confirm')"> Delete Account</button>
            <?php
            if (isset($_POST['deleteUser'])) {
                $query = "DELETE FROM `Users` WHERE id = ?";
                $data = Query($conn, $query, "i", $id);
            }
            ?>
        </form>

        <div id="loggout">
            <form id="log" action="" method="POST">
                <button class="loggoutt" name="out"> Logout</button>
                <?php
                if (isset($_POST['out'])) {
                    unset($_SESSION["Identifier"]);
                    GoToUrl("authentication.php");
                }
                ?>
            </form>

        </div>

    </div>
    <br><br>
    <?php include "footer.php"; ?>

</body>

</html>