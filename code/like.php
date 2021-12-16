<?php
include "connect.php";
include "utils.php";


$id = $_POST['UserId'];
$postId = $_POST['PostId'];
$reaction = $_POST['Reaction'];
$like = $_POST['Like'];
if ($like == "SetLike") {
    $sql = "SELECT * FROM Likes WHERE UserId = ? AND PostId = ?";
    $data = Query($conn, $sql, "ii", $id, $postId);
    if (sizeof($data) == 0) {
        $sql = "INSERT INTO `Likes` (UserId, PostId, Reaction) VALUES (?, ?, ?)";
        Query($conn, $sql, "iii", $id, $postId, $reaction);
    }
} else if ($like == "RemoveLike") {
    $sql = "DELETE FROM Likes WHERE UserId = ? AND PostId = ?";
    Query($conn, $sql, "ii", $id, $postId);
}
$sql = 'SELECT COUNT(CASE WHEN Likes.PostId = ? THEN 1 ELSE NULL END) "All",
COUNT(CASE WHEN Likes.PostId = ? AND Likes.Reaction = 0 THEN 1 ELSE NULL END) "Like",
COUNT(CASE WHEN Likes.PostId = ? AND Likes.Reaction = 1 THEN 1 ELSE NULL END) "Think",
COUNT(CASE WHEN Likes.PostId = ? AND Likes.Reaction = 2 THEN 1 ELSE NULL END) "Laugh",
COUNT(CASE WHEN Likes.PostId = ? AND Likes.Reaction = 3 THEN 1 ELSE NULL END) "Angry",
COUNT(CASE WHEN Likes.PostId = ? AND Likes.Reaction = 4 THEN 1 ELSE NULL END) "Sad"
FROM Likes;';
$data = Query($conn, $sql, "iiiiii", $postId, $postId, $postId, $postId, $postId, $postId);


$likesCount[] = array(
    "all" => $data[0]["All"],
    "like" => $data[0]["Like"],
    "think" => $data[0]["Think"],
    "laugh" => $data[0]["Laugh"],
    "angry" => $data[0]["Angry"],
    "sad" => $data[0]["Sad"]
);
echo json_encode($likesCount);
