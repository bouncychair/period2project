<?php

use Google\Service\AIPlatformNotebooks\Location;

session_start();
include "connect.php";
include "utils.php";
$id = GetUserId($conn);

if (isset($_POST["submit"])) {
    if (!empty($_POST["password"])) {
        if (strlen($_POST["password"]) > 1 && strlen($_POST["password"]) < 10  && ctype_alnum($_POST["password"])) {
            $query = "SELECT * FROM `Users` WHERE Username = ?";
            $data = Query($conn, $query, "s", $_POST["password"]);
            if (sizeof($data) > 0)
                echo "Sorry this password is already taken";
            else {
                $password =  $_POST["password"];
                $sql = "UPDATE Users SET `Password` = ? WHERE id=?";
                $data = Query($conn, $sql, "si", $password, $id);
            }
        }
    }
} else
    echo "Please insert new Password";
    function GoToUrl($url){
        ?>
            <script>
                var url = "<?php echo $url ?>";
                window.location.href = url;
            </script>
        <?php
        }
?>
<?php
$upload= $_FILES["file"]["name"];
if (isset($_POST["submitty"])) {
    if (!empty($_FILES["file"]["name"])) {
        $sql = "UPDATE Users SET `ProfilePicture` = ? WHERE id=?";
        $data = Query($conn, $sql, "si", $upload, $id);
    }else
    echo "Please select new Pb";
}

//change function url
//new pages for delete and logout

?>