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
                    echo "<div style='background-color:white;'><a style = 'text-decoration: none; color:black' href ='#".$row['Name']."' ><img width='100px' src='../uploads/" . $row["MainPic"] . "' ></img><p>".$row["Name"]."</p></a></div>";
                }
            } else{
                echo "<p>No matches found</p>";
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
