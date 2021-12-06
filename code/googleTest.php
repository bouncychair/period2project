<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';
require_once "utils.php";


//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('801553437171-l6cln7i1n5v7l891et07f7sb2829hf3a.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri("http://127.0.0.1/Social_Network/code/googleTest.php");
//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page



//index.php
$f = $google_client->createAuthUrl();
$f = "http://127.0.0.1/Social_Network/code/authentication.php";
?><script>
    var f = <?php $f ?>;
    console.log(f);
    window.location = f;
</script><?php

            $login_button = '';

            //This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
            if (isset($_GET["code"])) {
                //It will Attempt to exchange a code for an valid authentication token.
                $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

                //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
                if (!isset($token['error'])) {
                    //Set the access token used for requests
                    $google_client->setAccessToken($token['access_token']);

                    //Store "access_token" value in $_SESSION variable for future use.
                    $_SESSION['access_token'] = $token['access_token'];

                    //Create Object of Google Service OAuth 2 class
                    $google_service = new Google_Service_Oauth2($google_client);

                    //Get user profile data from google
                    $data = $google_service->userinfo->get();

                    //Below you can find Get profile data and store into $_SESSION variable
                    if (!empty($data['given_name'])) {
                        $_SESSION['user_first_name'] = $data['given_name'];
                    }

                    if (!empty($data['family_name'])) {
                        $_SESSION['user_last_name'] = $data['family_name'];
                    }

                    if (!empty($data['email'])) {
                        $_SESSION['user_email_address'] = $data['email'];
                    }

                    if (!empty($data['gender'])) {
                        $_SESSION['user_gender'] = $data['gender'];
                    }

                    if (!empty($data['picture'])) {
                        $_SESSION['user_image'] = $data['picture'];
                    }
                }
                GoToUrl("authentication.php?page=google");
            }

            //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
            if (!isset($_SESSION['access_token'])) {

                //Create a URL to obtain user authorization
                $login_button = '<a href="' . $google_client->createAuthUrl() . '"><img src="sign-in-with-google.png" /></a>';
            }

                ?>