<?php
session_start();
include "connect.php";
include "utils.php";

$id = GetUserId($conn);
$channelId = $_GET['ChannelId'];


if (isset($_POST['Unfollow'])) {
    $query = "DELETE FROM `Followed` WHERE UserId=? AND ChannelId = ?";
    $data = Query($conn, $query, "ii", $id, $channelId);
    header("location: channel.php?ChannelId=$channelId");
}

if (isset($_POST['Follow'])) {
    //$UserIdFollow = $_POST['id'];
    //$ChannelIdFollow = $_POST['ChannelId'];
    $query = "INSERT INTO `Followed` (`ChannelId`, `UserId`) VALUES (?, ?)";
    Query($conn, $query, "ii", $channelId, $id);
    header("location: channel.php?ChannelId=$channelId");
                    }

?>