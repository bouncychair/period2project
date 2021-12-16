<?php

use Google\Service\AIPlatformNotebooks\Location;

session_start();
include "connect.php";
include "utils.php";
$id = GetUserId($conn);

if (isset($_POST["submit"])) {
    if (!empty($_POST["username"])) {
        if (strlen($_POST["username"]) > 1 && strlen($_POST["username"]) < 30  && ctype_alnum($_POST["username"])) {
            $query = "SELECT * FROM `Users` WHERE Username = ?";
            $data = Query($conn, $query, "s", $_POST["username"]);
            if (sizeof($data) > 0)
                echo "tAKEN";
            else {
                $username =  $_POST["username"];
                $sql = "UPDATE Users SET `Username` = ? WHERE id=?";
                $data = Query($conn, $sql, "si", $username, $id);
            }
        }
    }
} else
    echo "Please insert new username";
    header("Location:profile.php");
