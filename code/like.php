<?php
include "connect.php";
include "utils.php";
$id = $_POST['UserId'];
$postId = $_POST['PostId'];
$reaction = $_POST['Reaction'];
$sql = "SELECT * FROM Likes WHERE UserId = ?";
$data = Query($conn, $sql, "i", $id);
if (sizeof($data) == 0) {
    $sql = "INSERT INTO `Likes` (UserId, PostId, Reaction) VALUES (?, ?, ?)";
    Query($conn, $sql, "iii", $id, $postId, $reaction);
}


?>