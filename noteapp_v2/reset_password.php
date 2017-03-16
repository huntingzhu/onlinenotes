<?php
// The user is redirected to this file after clicking the reset password link;
// Signup link contains two GET parameters: email and actication key;
session_start();
include('connection.php');
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>
      Reset Your Password
    </title>
    <style>
      h1{
        color:purple;
      }

      .container-fluid {
        border: 1px solid purple;
        margin-top: 50px;
        margin-left: 20px;
        margin-right: 20px;
        border-radius:15px;
        padding-bottom: 20px;
      }

      .btn-success {
          border-radius: 4px;
      }
    </style>

  </head>
  <body>
    <div class="container-fluid">
      <div class="row">

        <div class="col-sm-offset-1 col-sm-10 contactForm">
          <h1>Reset Your Password</h1>
          <div id="resetpasswordMessage">

          </div>
<?php
// If email or activation key is missing, show an error;
if(!isset($_GET['user_id']) || !isset($_GET['key'])) {
  echo '<div class="alert alert-danger"><p>Error occurs during running reset-password process!</p></div>';
  exit;
}
// else
// Store them in two variables
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400; // This reset-password page is only valid for 24h;

// Prepare variables for the query;
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

// Run query: Check combination of user_id &key exists and less than 24h old;
$sql = "SELECT user_id FROM forgotpassword WHERE (resetkey = '$key' AND user_id = '$user_id' AND time > '$time' AND status='pending')";

// Check the result;
$result = mysqli_query($link, $sql);
if(!$result) {
  echo '<div class="alert alert-danger"><p>Error occurs during running the SELECT query to forgotpassword table!</p></div>';
  exit;
}

$count = mysqli_num_rows($result);
if($count !== 1) {
  echo '<div class="alert alert-danger"><p>Reset Password failed! Maybe the link is expired! Please try it again later!</p></div>';
  exit;
}

echo "
<form method='post' id='passwordreset'>
<input type='hidden' name='key' value='$key' />
<input type='hidden' name='user_id' value='$user_id' />
<div class='form-group'>
  <label for='password1'>Enter your new Password</label>
  <input type='password' name='password1' id='password1' placeholder='Enter Password' class='form-control' />
  <label for='password2'>Re-enter Password</label>
  <input type='password' name='password2' id='password2' placeholder='Confirm Password' class='form-control' />
</div>
<input type='submit' name='resetpassword' class='btn btn-success' value = 'Reset Password' />
</form>
";

 ?>

        </div>
      </div>
    </div>


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- AJAX call to submit the above form -->
    <script>
    // Ajax Call for the Forgot form
    // Once the form is submitted
    $("#passwordreset").submit(function(event){
      // Prevent default php processing
      event.preventDefault();
      // Collect user inputs
      var dataToPost = $(this).serializeArray();
      // console.log(dataToPost);
      // Send the info of the form to signup.php using AJAX;
      $.ajax({
        type: "POST",
        url: "store_reset_password.php",
        data: dataToPost,
        success: function(data) {
          $("#resetpasswordMessage").html(data);
        },
        error: function() {
          $("#resetpasswordMessage").html("<div class='alert alert-danger'><p>There was an error with the ajax call during reset-password process.</p></div>");
        }
      });

    });

    </script>

  </body>
</html>
