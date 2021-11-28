<?php
$sa = "new message";
setcookie('ero2r', $sa, time() + 30, "/"); // expires in 1 minute
echo $_COOKIE['ero2r'];

?>