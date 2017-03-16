<?php
//start session and connect
session_start();
include ('connection.php');

//get user_id and new email sent through Ajax
$user_id = $_SESSION['user_id'];

// Error messages;
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invaildEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingEmail2 = '<p><strong>Please confirm your new email!</strong></p>';
$differentEmail = '<p><strong>Emails don\'t match!</strong></p>';
$missingPassword = '<p><strong>Please enter your password!</strong></p>';
$incorrectPassword = '<p><strong>Incorrect Password!</strong></p>';

// Get email;
if(empty($_POST['newemail'])) {
  $errors .= $missingEmail;
} else {
  $newemail = filter_var($_POST['newemail'], FILTER_SANITIZE_EMAIL);
  if(!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
    $errors .= $invaildEmail;
  } elseif(empty($_POST['confirmemail'])) {   // If the second email is empty;
    $errors .= $missingEmail2;
  } else {
    $confirmemail = filter_var($_POST['confirmemail'], FILTER_SANITIZE_EMAIL);
    if($confirmemail !== $newemail) {  // If the emails don't match;
      $errors .= $differentEmail;
    }
  }
}

//check for password;
if(empty($_POST['emailpassword'])){
    $errors .= $missingPassword;
}else{
    $emailpassword = $_POST['emailpassword'];
    $emailpassword = filter_var($emailpassword, FILTER_SANITIZE_STRING);
    $emailpassword = mysqli_real_escape_string ($link, $emailpassword);
    $emailpassword = hash('sha256', $emailpassword);
    //check if given password is correct
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($emailpassword != $row['password']){
            $errors .= $incorrectPassword;
        }
    }

}

// If there are any errors, then print them out;
if($errors) {
  $resultMessage = '<div class="alert alert-danger">'. $errors . '</div>';
  echo $resultMessage;
  exit;
}

//check if new email exists
$sql = "SELECT * FROM users WHERE email='$newemail'";
$result = mysqli_query($link, $sql);
$count = $count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'>There is already as user registered with that email! Please choose another one!</div>";
    exit;
}

//else run query and update email
$sql = "UPDATE users SET email='$newemail' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>The email could not be reset. Please try again later.</div>";
}else{
    session_destroy();
    setcookie("rememberme", "", time() - 3600); // Delete the cookie;
    $_COOKIE['rememberme'] = NULL;    // Deleting cookie is different from $_COOKIE == NULL;

    // Send user an email;
    $message = "Your email has been changed! This email is just for security purpose.\n\n";
    // Set the headers to prevent from going to spam folder;
    $headers .= "Reply-To: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
    $headers .= "Return-Path: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
    $headers .= "From: Online Notes <onlinenotes@hunting.thecompletewebhosting.com>\r\n";
    $headers .= "Organization: Online Notes by Hunting\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

    mail($_SESSION['email'], 'Email Changed', $message, $headers);

    echo 'success';
}

?>
