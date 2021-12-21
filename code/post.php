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
            echo $msgBox = "<div class='error_comments'><a>Comment cannot exceed 200 characters</a></div>";
        }
    } else {
        echo "<div class='error_comments'><a>Comment cannot be empty</a></div>";
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
    .comments{border: 3px ;margin: 0px auto 0px;padding: 15px 15px 5px 15px;max-width: 100%;height: auto;overflow: scroll;}
    .comments li{display: block;margin-bottom: 5px;padding: 10px;padding-bottom: 10px;box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25);}
    .comments li:last-child{border-bottom: 0 dashed #ddd;margin-bottom:0px}
    .comments span{color: #888;}
    .insert_comment{width: 100%;
        height:60px;
    border: 1px solid white;
    background: none;
    padding: 5px 10px;
    border-radius:5px;
    color: white;
    margin-top: 15px;
    resize: none;
}
    .insert_comment ::placeholder{color:white;}  
    .error_comments {
    background-color: rgb(241, 74, 74);
    padding: 10px;
    margin: 10px;
    text-align: center;
}   
    
    .comments_button{
    margin-top: 15px;
    margin-bottom: 15px;
    border-radius: 20px;
    border: 1px solid #FF4B2B;
    background-color: #FF4B2B;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
}
    .comments_form{
    background-color: #182952;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 20px;
    text-align: center;
}
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
    <div class="comments">
       <?php
       $sql = "SELECT * FROM `Comments` c, Users u WHERE PostId=? && c.UserId=u.id ORDER BY `Date` DESC";
       $row = Query($conn, $sql, "i", $post);     
       if (sizeof($row) == 0) {
        echo "<h3>No comments yet!</h3>";
    }
    else {         
       for ($i=0; $i < sizeof($row); $i++){
           echo "<li><b style='color:white'>" .$row[$i]['Username'] . "<b>  -  " .$row[$i]['Date'] . " <br><h3> " .$row[$i]['Text'] . "</h3></li>";
       }
   }
   ?>
</div>
<br>
<br>
</div>
<div class="add_comment">
    <form action="post.php?PostId=<?php echo $post ?>" class="comments_form" method="POST">
    <textarea class="insert_comment" type="text" id="comment" name="comments" placeholder="Comment here"></textarea>
    <button type="submit" name="submit" class="comments_button">Add Comment</button>   
</form>
</div>
</body>
</html>
