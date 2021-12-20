<?php



session_start();
include "connect.php";
include "utils.php";

CheckIdentifier();
$id = GetUserId($conn);




if(isset($_POST['NameSubmit'])) {
    if(!empty($POST['ChannelName'])){
        if (strlen($_POST['ChannelName']) > 1 && strlen($_POST['ChannelName']) < 30 && ctype_alnum($_POST['ChannelName'])) {
            $query = "SELECT * FROM `Channels` WHERE id = ?";
            $data = Query($conn, $query, "s", $_POST['ChannelName']);
            if (sizeof($data) > 0){ 
            echo '<p>Sorry this channel name is already taken</p>';
            }else {
                $channelName = $_POST['ChannelName'];
                $query = "UPDATE Channels SET `Name` = ?";
                $data = Query($conn, $query, "s", $channelName,);
                echo "adding succesful";
            }
        }
    }
} else {
    function GoToUrl($url){
        ?>
        <script>
            var url = "<?php echo $url ?>";
            window.location.href = url;
        </script>
        <?php
    }
}



?>