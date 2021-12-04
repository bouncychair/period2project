<?php

// Checks if user is logged in, Call this function in each page just right after session_start()
function CheckToken()
{
    if (empty($_SESSION["Token"])) 
        GoToUrl("authentication.php");
}
// Gets user id, you have to assign this function to variable to get the user id
function GetUserId($conn)
{
    $query = "SELECT `id` FROM Users WHERE Token = ?";
    if ($statement = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($statement, 's', $_SESSION["Token"]);
        mysqli_stmt_execute($statement) or die(mysqli_error($conn));
        mysqli_stmt_bind_result($statement, $id);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);
        return $id;
    }
}

function Query($conn, $sql,  $datatype, ...$data)
{
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($datatype, ...$data);
    if($stmt->execute()){
        if(str_contains($sql, "SELECT") !== FALSE){
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }else
            return 1;
    }else
        return -1;
}
function GoToUrl($url)
{
?>
    <script>
        var url = "<?php echo $url ?>";
        window.history.replaceState({}, document.title, "/Social_Network/code/" + url);
        window.location.reload();
    </script>
<?php
}
?>
