<?php
include("connect.php");


$sql = "SELECT profilePicture FROM Users WHERE id = 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()){
        $imageURL = '../uploads/'.$row["profilePicture"];
?>
    <img width="400px" src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php }


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
            $sql = "UPDATE `users` SET `profilePicture` = '$fileName' WHERE id = 1";
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
<!DOCTYPE html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="src/Stylesheet.css">
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
                   <!-- add php in pb--> 
                </div>
            </div>
   
        <form action="" method="post" enctype="multipart/form-data">
            <p>Select Image File to Upload:</p>
            <input type="file" name="file">
            <input type="submit" name="submit" value="Upload">
        </form>
</body>
<!--//add security //looking for user who uploaded-->



