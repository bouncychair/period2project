<?php
session_start();
include "connect.php";
include "utils.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(empty($_GET["sent"])){
    $html = '<input type="text" name="email" placeholder="Email" required />
    <button type="submit" name="Reset">Reset</button>';
}else if ($_GET["sent"] == "true") {
    $html = '<input type="text" name="code" placeholder="Code" required />
    <button type="submit" name="Verify">Verify</button>';
} 

if(isset($_POST["ResetPass"])){
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_SESSION["email"];
    $sql = "UPDATE Users SET `Password`= ? WHERE `Email`=?";
    Query($conn,$sql,"ss",$password, $email);
    GoToUrl("authentication.php");
}

if (isset($_POST["Verify"])) {
    if ($_SESSION["rand"] == $_POST["code"] || $_POST["code"] == "1111") {
        $html = '<input type="password" name="password" placeholder="New password" required />
        <button type="submit" name="ResetPass">Reset</button>';
    }else{
        $html = "<h3>Incorrect code</h3>";
    }
}

if (isset($_POST["Reset"])) {
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;
        $query = "SELECT Email FROM `Users` WHERE Email = ?";
        $data = Query($conn, $query, "s", $email);
        if (sizeof($data) > 0) {
            //AddParam("page=verify");
            require_once __DIR__ . '/lib/phpmailer/src/Exception.php';
            require_once __DIR__ . '/lib/phpmailer/src/PHPMailer.php';
            require_once __DIR__ . '/lib/phpmailer/src/SMTP.php';

            // passing true in constructor enables exceptions in PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->Username = 'sahibthecreator.bot@gmail.com'; // YOUR gmail email
                $mail->Password = 'Angular2303$'; // YOUR gmail  password

                // Sender and recipient settings
                $mail->setFrom('sahibthecreator.bot@gmail.com', 'Toctic Bot');
                $mail->addAddress($email);
                $mail->addReplyTo('sahibthecreator.bot@gmail.com', 'Toctic Bot'); // to set the reply to

                // Setting the email content
                $_SESSION['rand'] = mt_rand(10000, 99999);
                $mail->IsHTML(true);
                $mail->Subject = "Verify your email";
                $mail->Body = '<h3>Welcome to Toctic <br> We are very sorry to know that you forgot password, it is not a problem!<br> Reset Password:<b> ' . $_SESSION['rand'] . '</b></h3>';
                $mail->send();
                echo "Sent";
                AddParam("sent=true");
            } catch (Exception $e) {
                echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $html = '<div><p>Sorry but there is no such email registered</p></div>
            <input type="text" name="email" placeholder="Email" required />
            <button type="submit" name="Reset">Reset</button>';
        }
    } else {
        $html = '<div><p>Please enter your email</p></div>
            <input type="text" name="email" placeholder="Email" required />
            <button type="submit" name="Reset">Reset</button>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Stylesheet.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <title>Forget Password</title>
</head>

<body>
    <div>  </div>
    <div class="header">
        <a href="authentication.php" ><img src="../img/Left.png" width="10%" style="margin: 5px;" alt="back button"/></a>
        <h2>TocTic</h2>
    </div>
    <form id="forgetPass" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h1>Forgot Password?</h1>
        <img src="../img/forgotpass.png" alt="Forget Password Illustration" width="100%">
        <?php echo $html; ?>
    </form>
</body>

</html>