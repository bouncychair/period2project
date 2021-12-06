<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Checks if user is logged in, Call this function in each page just right after session_start()
function CheckToken(){
    if (empty($_SESSION["Token"]))
        GoToUrl("authentication.php");
}
// Gets user id, you have to assign this function to variable to get the user id
function GetUserId($conn){
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

function Query($conn, $sql,  $datatype, ...$data){
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($datatype, ...$data);
    if ($stmt->execute()) {
        if (str_contains($sql, "SELECT") !== FALSE) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else
            return 1;
    } else
        return -1;
}

function GoToUrl($url){
?>
    <script>
        var url = "<?php echo $url ?>";
        //window.history.replaceState({}, document.title, "/Social_Network/code/" + url);
        //window.location.reload();
        //location.reload();
        window.location.href = url;
        //location.href = ''+ url;
    </script>
<?php
}

function AddParam($param){
?>
    <script>
        var param = "<?php echo $param ?>";
        location.replace(location.href + "?" + param);
    </script>
<?php
}

function SendVerificationMail($emailTo){
    require_once __DIR__ . '/lib/phpmailer/src/Exception.php';
    require_once __DIR__ . '/lib/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/lib/phpmailer/src/SMTP.php';

    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'botfortesting1234@gmail.com'; // YOUR gmail email
        $mail->Password = 'botfortesting4321'; // YOUR gmail  password

        // Sender and recipient settings
        $mail->setFrom('test@gmail.com', 'Email Verification');
        $mail->addAddress($emailTo, 'Bot');
        $mail->addReplyTo('example@gmail.com', 'Sender Name'); // to set the reply to

        // Setting the email content
        $_SESSION['rand'] = mt_rand(1000, 9999);
        $mail->IsHTML(true);
        $mail->Subject = "Verify your email";
        $mail->Body = 'Your code for verification is: ' . $_SESSION['rand'] . '';
        $mail->send();
        echo "Sent";
    } catch (Exception $e) {
        echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>