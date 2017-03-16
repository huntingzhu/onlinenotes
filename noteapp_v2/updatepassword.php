<?php
// Set the time Zone;
date_default_timezone_set('America/Los_Angeles');
//start session and connect
session_start();
include ('connection.php');

//define error messages
$missingCurrentPassword = '<p><strong>Please enter your Current Password!</strong></p>';
$incorrectCurrentPassword = '<p><strong>The password entered is incorrect!</strong></p>';
$missingPassword = '<p><strong>Please enter a new Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long!</strong></p>';
$differentPassword = '<p><strong>New passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';

//check for errors
if(empty($_POST["currentPassword"])){
    $errors .= $missingCurrentPassword;

}else{
    $currentPassword = $_POST["currentPassword"];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string ($link, $currentPassword);
    $currentPassword = hash('sha256', $currentPassword);
    //check if given password is correct
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($currentPassword != $row['password']){
            $errors .= $incorrectCurrentPassword;
        }
    }

}

if(empty($_POST["password1"])) {
    $errors .= $missingPassword;
}elseif(!(strlen($_POST["password1"]) > 6)) {
    $errors .= $invalidPassword;
}else{
    $password1 = filter_var($_POST["password1"], FILTER_SANITIZE_STRING);
    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    }else{
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password1 !== $password2){
            $errors .= $differentPassword;
        }
    }
}

//if there is an error print error message
if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
}else{
    $password1 = mysqli_real_escape_string($link, $password1);
    $password1 = hash('sha256', $password1);
    //else run query and update password
    $sql = "UPDATE users SET password='$password1' WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "<div class='alert alert-danger'>The password could not be reset. Please try again later.</div>";
    }else{
        session_destroy();
        setcookie("rememberme", "", time() - 3600); // Delete the cookie;
        $_COOKIE['rememberme'] = NULL;    // Deleting cookie is different from $_COOKIE == NULL;

        // Send user an email;
        $message = "Your password has been changed! This email is just for security purpose.\n\n";
        // Set the headers to prevent from going to spam folder;
        $headers .= "Reply-To: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
        $headers .= "Return-Path: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
        $headers .= "From: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
        $headers .= "Organization: Online Notes by Hunting\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

        mail($_SESSION['email'], 'Password Changed', $message, $headers);

        echo 'success';
    }
}


?>
