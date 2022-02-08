<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include "connect.php";
include "utils.php";


$html = '<input type="text" name="email" placeholder="Email" required />
<button type="submit" name="Reset">Reset</button>';



if (isset($_POST["Reset"])) {
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $query = "SELECT Email FROM `Users` WHERE Email = ?";
        $data = Query($conn, $query, "s", $email);
        if (sizeof($data) > 0) {
            //AddParam("page=verify");
            $token = uniqid();
            require_once __DIR__ . '/lib/phpmailer/src/Exception.php';
            require_once __DIR__ . '/lib/phpmailer/src/PHPMailer.php';
            require_once __DIR__ . '/lib/phpmailer/src/SMTP.php';

            // passing true in constructor enables exceptions in PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                $mail->isSMTP();
                $mail->Host = 'smtp.mail.ru';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 465;

                $mail->Username = 'sahibthecreator.bot'; // YOUR gmail email
                $mail->Password = 'Angular2303$'; // YOUR gmail  password

                // Sender and recipient settings
                $mail->setFrom('toctic.bot@mail.ru', 'Toctic Bot');
                $mail->addAddress($email);
                $mail->addReplyTo('toctic.bot@mail.ru', 'Toctic Bot'); // to set the reply to

                // Setting the email content
                $_SESSION['rand'] = mt_rand(1000, 9999);
                $mail->IsHTML(true);
                $mail->Subject = "Verify your email";
                $mail->Body = '<h3>Welcome to Toctic <br> Reset Password:<b> ' . $token . '</b></h3>';
                $mail->send();
                echo "Sent";
                AddParam("sent=true");
            } catch (Exception $e) {
                echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            //no such email
        }
    } else {
        //fill the field
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
    <div class="header">
        <img src="../img/logo1.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h1>Forget Password</h1>
        <img src="../img/forgotpass.png" alt="Forget Password Illustration" width="130%">
        <?php echo $html; ?>
    </form>
</body>

</html>