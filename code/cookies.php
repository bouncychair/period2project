<?php
session_start();

$sa = "new message";
setcookie('Token', $sa, time() + 600, "/"); // expires in 1 minute
echo $_COOKIE['ero2r'];


//$_SESSION["sahib"] = "Hi this is session";
//echo $_SESSION["sahib"];

?>