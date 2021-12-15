<?php
//if($_SERVER["Request_Method"] == "POST"){
    
    if(isset($_POST['submit'])){
        $sql= "UPDATE SET `ProfilePicture = $imageURL , `Username` = $username WHERE id=?";
        $data= Query($conn, $sql, "s", $id);  
    }else
    echo "Please insert new username";

?>