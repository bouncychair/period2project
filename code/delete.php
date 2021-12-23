<?php
session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);


$user = $_GET['id']; 

$delete = mysqli_query($db,"delete from tblemp where id = '$user'"); // delete query

if($delete)
{
    mysqli_close($conn); // Close connection
    header("authentication.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>