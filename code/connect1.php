<?php 

$pdo = new PDO("mysql:host=local;dbname=TocTic",'root','');
if ($pdo){
    echo "Connected";
}

?>