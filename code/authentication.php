<?php
session_start();
include "connect.php";
include_once "utils.php";

$msgBox = "";
$formChange = '';


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
                case ("usernameTaken"):
                    $msgBox = "<div class='errorBox'><a>This username is already taken</a></div>";
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
    <input type="password" name="Password" placeholder="Password" />
    <a href="forgetPass.php">Forgot your password?</a>
    <button name="Sign_In">Sign In</button>
    <a href="#">Don' . 't have an account?</a>
    <a href="authentication.php?page=signup" style="margin-top:0;  cursor: pointer;">SignUp</a>';
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
    <input type="number" name="Age"  placeholder="Age" />
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
    <input type="number" name="Age"  placeholder="Age" />
<select id="gender" name="Gender">
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
</select>
    <button name="Sign_Up"">Sign Up </button>';
}

if (isset($_POST["Sign_Up"])) {
    $mailSent = false;
    if (!empty($_POST["Fname"]) && !empty($_POST["Lname"]) && !empty($_POST["Username"]) && !empty($_POST["Email"]) && !empty($_POST["Password"]) && !empty($_POST["Age"])) {
        if (strlen($_POST["Fname"]) > 1 && ctype_alpha($_POST["Fname"]) && strlen($_POST["Lname"]) > 1 && ctype_alpha($_POST["Lname"])) {
            if (strlen($_POST["Username"]) > 1 && strlen($_POST["Username"]) < 30  && ctype_alnum($_POST["Username"])) {
                $query = "SELECT * FROM `Users` WHERE Username = ?";
                $data = Query($conn, $query, "s", $_POST["Username"]);
                if (sizeof($data) > 0)
                    AddParam("page=signup&error=usernameTaken");
                else {
                    if (filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
                        if (strlen($_POST["Password"]) >= 6 && strlen($_POST["Password"]) < 50) {
                            $_SESSION['fname'] = $_POST["Fname"];
                            $_SESSION['lname'] = $_POST["Lname"];
                            $_SESSION['username'] = $_POST["Username"];
                            $_SESSION['email'] = $_POST["Email"];
                            $_SESSION['password'] = $_POST["Password"];
                            $_SESSION['age'] = $_POST["Age"];
                            $_SESSION['gender'] = $_POST["Gender"];
                            SendVerificationMail($_POST["Email"]);
                            $mailSent = true;
                        } else
                            AddParam("page=signup&error=passLength");
                    } else
                        AddParam("page=signup&error=mailInvalid");
                }
            } else
                AddParam("page=signup&error=username");
        } else
            AddParam("page=signup&error=name");
    } else
        AddParam("page=signup&error=fields");

    if ($mailSent) {
        $formChange = '
        <h1>Verify Your Mail</h1>
        <img width="70%" src="../img/plane.gif" alt="Flying Paper Plane" />
        <input type="text" name="vertext" placeholder="Code" required />
        <button name="Verify">Verify</button>';
    } else
        AddParam("page=signup");
}
if (isset($_POST['Verify'])) {
        $url = 'https://ip-api.io/json';
        $json = file_get_contents($url);
        $obj = json_decode($json);

        $country = $obj->country_name;
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
        $gender = $_SESSION['gender'];
        $age = $_SESSION['age'];
        $regdate = date("Y-m-d");
        $identifier = uniqid("", true);

        $sql = "INSERT INTO `Users` (`FirstName`, `LastName`, `Username`, `Email`, `Password`, `Country`, `Gender`, `Age`, `RegDate`, `Identifier` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        Query($conn, $sql,"sssssssiss",$fname, $lname, $username, $email, $password, $country, $gender, $age, $regdate, $identifier); 
}

if (isset($_POST['Sign_In'])) {
    if (!empty($_POST["Username"])) {
        if (!empty($_POST["Password"])) {
            $username = $_POST["Username"];
            $pass = $_POST["Password"];
            $query = "SELECT `Password`, `Identifier` FROM Users WHERE Username = ?";
            $data = Query($conn, $query, "s", $username);
            if (password_verify($pass, $data[0]["Password"])) {
                $_SESSION["Identifier"] = $data[0]["Identifier"];
                GoToUrl("main.php");
            } else
                AddParam("error=passInvalid");
        } else
            AddParam("error=enterPass");
    } else
        AddParam("error=enterUsername");
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
        <img src="../img/logo1.png" alt="TocTic Logo" />
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
</body>

</html>
<?php
