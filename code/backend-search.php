<?php
include "connect.php";
include "utils.php";


if (isset($_REQUEST["term"]) && isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    // Prepare a select statement
    $sql = "SELECT Channels.* FROM Channels, Followed WHERE Channels.Name LIKE ? AND Channels.Id = Followed.ChannelId AND Followed.UserId = ?";
    $param_term = '%' . $_REQUEST["term"] . '%';
    $data = Query($conn, $sql, "ss", $param_term, $id);


    // Check number of rows 
    if (sizeof($data) > 0) {
        for ($i=0; $i < sizeof($data); $i++) { 
            echo "<div class='searchResultBox'><a style = 'text-decoration: none; color:white'><img width='100px' src='../uploads/" . $data[$i]["MainPicture"] . "' ></img><h4>" . $data[$i]["Name"] . "</h4></a></div>";
        }
    }else{
        echo "<center><div>No results found</div></center>";
    }
}else if (isset($_REQUEST["term"]) && !isset($_REQUEST["id"])) {

    // Prepare a select statement
    $sql = "SELECT * FROM Channels WHERE `Name` LIKE ?";
    $param_term = '%' . $_REQUEST["term"] . '%';
    $data = Query($conn, $sql, "s", $param_term);


    // Check number of rows
    if (sizeof($data) > 0) {
        for ($i=0; $i < sizeof($data); $i++) { 
            echo "<div><a href ='channel.php?ChannelId=" . $data[$i]['id'] . "' ><img width='100px' src='../uploads/" . $data[$i]["MainPicture"] . "' ></img><h4> " . $data[$i]["Name"] . "</h4></a></div>";
        }
    } else {
        echo "<center><img width='200px' src='../img/no.png' /></center>";
    }
}


// close connection
mysqli_close($conn);
