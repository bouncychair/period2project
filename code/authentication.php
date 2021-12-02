<?php
//ob_start();
session_start();

include "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$msgBox = "";
$formChange = '';


function SelectDB($select, $from, $where, $keyword, $conn)
{
    //include "connect.php";
    $count = str_word_count($select);
    // $question = "?";
    // for ($i=0; $i < $count; $i++) { 
    //     $question = $question + ",?";
    // }
    $query = "SELECT $select FROM `$from` WHERE $where = ?";

    // Step #4.1: Prepare query as a statement
    if ($statement = mysqli_prepare($conn, $query)) {
        // Step #4.2: Fill in the ? parameters!
        mysqli_stmt_bind_param($statement, 's', $keyword);

        //Step #5: Execute statement and check success
        if (mysqli_stmt_execute($statement)) {
            echo "Query executed";
        } else {
            echo "Error executing query";
            die(mysqli_error($conn));
        }

        // Step #6.1: Bind result to variables when fetching...
        mysqli_stmt_bind_result($statement, $name, $yob);
        // Step #6.2: And buffer the result if and only if you want to check the number of rows
        mysqli_stmt_store_result($statement);

        // Step #7: Check if there are results in the statement
        if (mysqli_stmt_num_rows($statement) > 0) {
            echo "Number of rows: " . mysqli_stmt_num_rows($statement);

            // Step #8: Fetch all rows of data from the result statement
            while (mysqli_stmt_fetch($statement)) {

                // Create cells
                echo  $name;
                echo $yob;
            }
        } else {
            echo "No records found";
        }
        // Step #9: Close the statement and free memory
        mysqli_stmt_close($statement);
    }
}

if (!empty($_GET["error"])) {
    if (!empty($_GET["page"])) {
        if ($_GET["page"] == "signup") {
            switch ($_GET["error"]) {
                case ("passLength"):
                    $msgBox = "<div class='errorBox'><a>Password should contain 6-20 characters</a></div>";
                    break;
                case ("mailInvalid"):
                    $msgBox = "<div class='errorBox'><a>Please enter a valid email</a></div>";
                    break;
                case ("username"):
                    $msgBox = "<div class='errorBox'><a>Username must contain more than 2 characters and can contain only letters and underline</a></div>";
                    break;
                case ("name"):
                    $msgBox = "<div class='errorBox'><a>Name and last name can't contain symbols</a></div>";
                    break;
                case ("fields"):
                    $msgBox = "<div class='errorBox'><a>Please fill all the fields</a></div>";
                    break;
            }
        }
    } else {
        switch ($_GET["error"]) {
            case ("passInvalid"):
                $msgBox = "<div class='errorBox'><a>Invalid password</a></div>";
                break;
            case ("enterPass"):
                $msgBox = "<div class='errorBox'><a>Please enter your password</a></div>";
                break;
            case ("enterUsername"):
                $msgBox = "<div class='errorBox'><a>Please enter your username</a></div>";
                break;
        }
    }
}


$msg;


if (empty($_GET["page"])) { //----------------------------------- Sign In form
    $formChange = '<h1 id="signin">Sign in</h1>
    ' . $msgBox . '
    <input type="text" name="Username" placeholder="Username" />
    <div><?php echo $msg; ?></div>
    <input type="password" name="Password" placeholder="Password" />
    <a href="#">Forgot your password?</a>
    <button name="Sign_In">Sign In</button>
    <a href="#">Don' . 't have an account?</a>
    <a href="authentication.php?page=signup" style="margin-top:0;  cursor: pointer;" ChangePage("SignUp")">SignUp</a>';
} else if ($_GET["page"] == "google") { //----------------------------------- Sign Up Via Google form
    include("googleTest.php");
    $formChange = '<h1>Create Account</h1>
    <a href="' . $google_client->createAuthUrl() . '">
    <div class="googlebtn">
    <img src="../img/google_icon.png" alt="google logo" />
    Sign up with Google
    </div>
    </a>
    <span>or use your email for registration</span>
    ' . $msgBox . '
    <input type="text" name="Fname"  placeholder="First Name" value="' . ((!empty($_SESSION['user_first_name'])) ? $_SESSION['user_first_name'] : "") . '"  />
    <input type="text" name="Lname"  placeholder="Last Name" value="' . ((!empty($_SESSION['user_last_name'])) ? $_SESSION['user_last_name'] : "") . '"  />
    
    <input type="username" name="Username"  placeholder="Username"  />
    <input type="email" name="Email"  placeholder="Email" value="' . ((!empty($_SESSION['user_email_address'])) ? $_SESSION['user_email_address'] : "") . '" />
    <input type="password" name="Password" placeholder="Password"  />
    <input type="number" name="Age"  placeholder="Age"  />
<select id="gender" name="Gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
</select>
    <button name="Sign_Up"">Sign Up </button>';
} else if ($_GET["page"] == "signup") { //----------------------------------- Sign Up form
    include("googleTest.php");
    $formChange = '<h1>Create Account</h1>
    <a href="' . $google_client->createAuthUrl() . '">
    <div class="googlebtn" href="#">
    <img src="../img/google_icon.png" alt="google logo" />
    Sign up with Google
    </div>
    </a>
    <span>or use your email for registration</span>
    ' . $msgBox . '
    <input type="text" name="Fname"  placeholder="First Name"  />
    <input type="text" name="Lname"  placeholder="Last Name"  />
    
    <input type="username" name="Username"  placeholder="Username"  />
    <input type="email" name="Email"  placeholder="Email"  />
    <input type="password" name="Password" placeholder="Password"  />
    <input type="number" name="Age"  placeholder="Age"  />
<select id="gender" name="Gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
</select>
    <button name="Sign_Up"">Sign Up </button>';
} else if ($_SESSION['content'] == "Verify") { //----------------------------------- Verify form
    $formChange = '<h1>Verify Your Mail</h1>
    <input type="text" name="vertext" placeholder="Code" required />
    <button name="Verify">Verify</button>';
}

if (isset($_POST["Sign_Up"])) {
    $mailSent = false;
    if (!empty($_POST["Fname"]) && !empty($_POST["Lname"]) && !empty($_POST["Username"]) && !empty($_POST["Email"]) && !empty($_POST["Password"])) {
        if (strlen($_POST["Fname"]) > 1 && ctype_alpha($_POST["Fname"]) && strlen($_POST["Lname"]) > 1 && ctype_alpha($_POST["Lname"])) {
            if (strlen($_POST["Username"]) > 1 && ctype_alnum($_POST["Username"])) {
                $username = $_POST["Username"];
                $query = "SELECT * FROM `Users` WHERE Username = '$username'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $msg = "This username is already taken";
                    } else {
                        if (filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
                            if (strlen($_POST["Password"]) >= 6 && strlen($_POST["Password"]) < 50) {
                                $_SESSION['fname'] = $_POST["Fname"];
                                $_SESSION['lname'] = $_POST["Lname"];
                                $_SESSION['username'] = $_POST["Username"];
                                $_SESSION['email'] = $_POST["Email"];
                                $_SESSION['password'] = $_POST["Password"];
                                $_SESSION['age'] = $_POST["Age"];
                                $_SESSION['gender'] = $_POST["Gender"];

                                require_once __DIR__ . '/lib/phpmailer/src/Exception.php';
                                require_once __DIR__ . '/lib/phpmailer/src/PHPMailer.php';
                                require_once __DIR__ . '/lib/phpmailer/src/SMTP.php';

                                // passing true in constructor enables exceptions in PHPMailer
                                $mail = new PHPMailer(true);
                                $email = $_POST["Email"];

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
                                    $mail->addAddress($email, 'Bot');
                                    $mail->addReplyTo('example@gmail.com', 'Sender Name'); // to set the reply to

                                    // Setting the email content
                                    $_SESSION['rand'] = mt_rand(1000, 9999);
                                    $mail->IsHTML(true);
                                    $mail->Subject = "Verify your email";
                                    $mail->Body = 'Your code for verification is: ' . $_SESSION['rand'] . '';
                                    $mail->send();
                                    $mailSent = true;
                                    echo "Sent";
                                } catch (Exception $e) {
                                    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
                                }
                            } else {
?><script>
                                    location.replace(location.href + "?page=signup&error=passLength");
                                </script><?php
                                        }
                                    } else {
                                            ?><script>
                                location.replace(location.href + "?page=signup&error=mailInvalid");
                            </script><?php
                                    }
                                }
                            }
                        } else {
                                        ?><script>
                    location.replace(location.href + "?page=signup&error=username");
                </script><?php
                        }
                    } else {
                            ?><script>
                location.replace(location.href + "?page=signup&error=name");
            </script><?php
                    }
                } else {
                        ?><script>
            location.replace(location.href + "?page=signup&error=fields");
        </script><?php
                }
                if ($mailSent) {
                    $formChange = '<h1>Verify Your Mail</h1>
        <input type="text" name="vertext" placeholder="Code" required />
        <button name="Verify">Verify</button>';
                } else {
                    $_SESSION['error'] = $msgBox1;
                    ?><script>
            location.replace(location.href + "?page=signup");
        </script><?php
                }
            }
            if (isset($_POST['Verify'])) {
                if ($_POST["vertext"] == $_SESSION['rand']) {
                    $fname = $_SESSION['fname'];
                    $lname = $_SESSION['lname'];
                    $username = $_SESSION['username'];
                    $email = $_SESSION['email'];
                    $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
                    $country = $_COOKIE['country'];
                    $gender = $_SESSION['gender'];
                    $age = $_SESSION['age'];
                    $regdate = date("d-m-Y");
                    $token = uniqid("", true);

                    $stmt = $conn->prepare("INSERT INTO `Users` (`FirstName`, `LastName`, `Username`, `Email`, `Password`, `Country`, `Gender`, `Age`, `RegDate`, `Token` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssiss", $fname, $lname, $username, $email, $password, $country, $gender, $age, $regdate, $token);
                    if ($stmt->execute()) {
                        echo "Records inserted successfully.";
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                    }
                } else {
                    echo "incorrect code";
                }
            }

            if (isset($_POST['Sign_In'])) {
                if (!empty($_POST["Username"])) {
                    if (!empty($_POST["Password"])) {
                        $username = $_POST["Username"];
                        $pass = $_POST["Password"];
                        $query = "SELECT `Password`, `Token` FROM Users WHERE Username = ?";
                        if ($statement = mysqli_prepare($conn, $query)) {
                            mysqli_stmt_bind_param($statement, 's', $username);
                            mysqli_stmt_execute($statement) or die(mysqli_error($conn));
                            mysqli_stmt_bind_result($statement, $dbpass, $token);
                            mysqli_stmt_fetch($statement);
                            mysqli_stmt_close($statement);
                        }
                        // $result = mysqli_query($conn, $query);
                        // $row = mysqli_fetch_assoc($result);
                        if (password_verify($pass, $dbpass)) {
                            $_SESSION["Token"] = $token;
                            //setcookie('Token', $token, time() + 600, "/");
                            //ob_end_flush();
                    ?>
                <script>
                    window.location.href = "http://127.0.0.1/Social_Network/code/main.php";
                </script>
            <?php
                            exit();
                        } else {
            ?>
                <script>
                    location.replace(location.href + "?error=passInvalid");
                </script>
            <?php
                        }
                    } else {
            ?>
            <script>
                location.replace(location.href + "?error=enterPass");
            </script>
        <?php
                    }
                } else {
        ?>
        <script>
            location.replace(location.href + "?error=enterUsername");
        </script>
<?php
                }
            }
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Stylesheet.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body>
    <div class="header">
        <img src="../img/logo.png" alt="TocTic Logo" />
        <h2>TocTic</h2>
    </div>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <br>
                <?php echo $formChange; ?>
            </form>
        </div>
    </div>
    <script>
        function SignUp() {
            location.replace(location.href + "?id=reg");
        }

        function Verify() {
            location.replace(location.href + "?id=ver");
        }
        fetch('http://ip-api.com/json')
            .then(res => res.json())
            .then(response => {
                console.log("Country: ", response.country);
                console.log("Region: ", response.regionName);
                console.log("City: ", response.city);
                console.log("ZIP: ", response.zip);
                console.log("Timezone: ", response.timezone);
                console.log("IP:: ", response.query);


                var country = response.country;
                document.cookie = "country = " + country;
            })
            .catch((data, status) => {
                console.log('Request failed');
            })
    </script>

</body>

</html>
<?php
