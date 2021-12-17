<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);
$post= $_GET["PostId"];
if (isset($_POST["submit"])) {
    $date = date("Y-m-d");
    $comments = $_POST["comments"];
    if (!empty($comments)) {
    if(strlen($comments) < 201){
            $comments = filter_var($comments, FILTER_SANITIZE_STRING);
        $sql = "INSERT INTO `Comments` (PostId, UserId,`Text`, `Date`) VALUES (?, ?, ?, ?)";
        Query($conn, $sql, "iiss", $post, $id, $comments, $date);
    } else {
        echo "<p>Comments must be less then 200 charecters</p>";
    }
    } else {
        echo "<p>Comments cannot be empty</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet.css">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <title>Post</title>
</head>
<body>
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
<style>
 		.box{border: 3px ;margin: 0px auto 0;padding: 15px;max-width: 100%;height: auto;overflow: scroll;}
 		.box li{display: block;border-bottom: 20px;margin-bottom: 5px;padding: 10px;padding-bottom: 10px;box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25);}
 		.box li:last-child{border-bottom: 0 dashed #ddd;margin-bottom:40px}
 		.box span{color: #888;}      
</style>
<div class="post">
<div class="post_header">
<?php
   $sql = "SELECT * FROM `Users` WHERE id=?";
    $row = Query($conn, $sql, "i", $id);  
        echo "<img src='../uploads/".$row[0]['ProfilePicture']."'>";
        ?>
        <p><?php echo $row[0]['Username'];?></p>  
</div>
<div class="post_caption">
<?php
    $sql = "SELECT * FROM `Posts` WHERE id=?";
    $row = Query($conn, $sql, "i", $post);
        ?>
        <p><?php echo $row[0]['Caption'];?></p>
</div>
<div>
<?php
    $sql = "SELECT * FROM `Posts` WHERE id=?";
    $row = Query($conn, $sql, "i", $post);
    echo "<img src='../uploads/".$row[0]['ImageName']."' >";
?>
</div>
 	<div class="box">
         <?php
         $sql = "SELECT * FROM `Comments` c, Users u WHERE PostId=? && c.UserId=u.id ORDER BY `Date` DESC";
         $row = Query($conn, $sql, "i", $post);     
         if (sizeof($row) == 0) {
            echo "<h3>No comments yet!</h3>";
         }
         else {         
         for ($i=0; $i < sizeof($row); $i++){
             echo "<li><b style='color:white'>" . $row[$i]['Username'] . "<b>  -  " . $row[$i]['Date'] . " <br>	<h3> " . $row[$i]['Text'] . "<br></h3></li>";
         }
        }
        ?>
 	</div><br><br>
         </div>
         <div class="add_comment">
             <form action="post.php?PostId=<?php echo $post ?>" class="add_comment_form" method="POST">
                <input class="insert_comment" type="text" id="comment" name="comments" placeholder="Comment here">
                <input class="submit_button" type="submit" src='../img/Project2_submit_btn.png' alt="Submit" name="submit">
             </form>
         </div>

</body>
</html>
