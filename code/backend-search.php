<?php
include "connect.php";

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM Channels WHERE `Name` LIKE ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term ='%'. $_REQUEST["term"] . '%';

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<div><a href ='channel.php?ChannelId=".$row['id']."' ><img width='100px' src='../uploads/" . $row["MainPicture"] . "' ></img><h4> ".$row["Name"]."</h4></a></div>";
                }
            } else{
                echo "<center><img width='200px' src='../img/no-results.png' /></center>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    //mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($conn);
?>
