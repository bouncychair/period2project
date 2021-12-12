<?php
include "connect.php";
include "utils.php";
$id = $_POST['UserId'];
$postId = $_POST['PostId'];
$reaction = $_POST['Reaction'];
$like = $_POST['Like'];
if($like == "SetLike"){
    $sql = "SELECT * FROM Likes WHERE UserId = ? AND PostId = ?";
    $data = Query($conn, $sql, "ii", $id, $postId);
    if (sizeof($data) == 0) {
        $sql = "INSERT INTO `Likes` (UserId, PostId, Reaction) VALUES (?, ?, ?)";
        Query($conn, $sql, "iii", $id, $postId, $reaction);
    }
}else if($like == "RemoveLike"){
    $sql = "DELETE FROM Likes WHERE UserId = ? AND PostId = ?";
    Query($conn, $sql, "ii", $id, $postId);
}


?>