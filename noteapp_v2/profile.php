<?php
// Resume the session;
session_start();

// Check if there is a session of previous user, if not, redirect to the index.php;
if(!isset($_SESSION['user_id'])) {
  header("location: index.php");
}


include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
}else{
    echo "There was an error retrieving the username and email from the database";
}
 ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profile</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/onlinenotes.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
    .profile {
      display: table;
      width: 100%;
      height: 100%;
      /*position:absolute;*/
      padding: 100px 0;
      color: black;
      background: url(img/intro-bg2.jpg) repeat bottom center scroll;
      background-color: black;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      background-size: cover;
      -o-background-size: cover;
    }

    .tableRows {
      cursor: pointer;
      font-family: sans-serif;
      font-size: 16px;
      background-color: rgba(255, 255, 255, 0.4);
      border: 2px solid white;
    }

    .tableRows td {
      border: 2px solid white;
    }

    </style>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">
                    <i class="glyphicon glyphicon-pencil"></i> ONLINE NOTES
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">

                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>

                    <li>
                        <a class="page-scroll" href="profile.php">Profile</a>
                    </li>

                    <li class="current-page">
                        <a class="page-scroll" href="loggedin.php"><?php echo $_SESSION['username']; ?>'s Notes</a>
                    </li>

                    <li>
                        <a class="" href="index.php?logout=1" >Log out</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- profile section -->
    <section class="profile">
      <div class="container">
        <div class="row">
          <div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
            <h2>Edit Your Profile:</h2>

            <div class="table-responsive">
              <table class="table table-hover table-condensed " >
                <tr class="tableRows" data-target="#updateUsernameModal" data-toggle="modal">
                  <td>Username</td>
                  <td><?php echo $_SESSION['username']; ?></td>
                </tr>

                <tr class="tableRows" data-target="#updateEmailModal" data-toggle="modal">
                  <td>Email</td>
                  <td><?php echo $_SESSION['email']; ?></td>
                </tr>

                <tr class="tableRows" data-target="#updatePasswordModal" data-toggle="modal">
                  <td>Password</td>
                  <td>###hidden###</td>
                </tr>
              </table>

            </div>

          </div>
        </div>

        <!-- Update username form -->
        <form method="post" id="updateUsernameForm">
          <div class="modal" id="updateUsernameModal" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button class="close" data-dismiss="modal">&times;</button>
                      <h5 class="pull-left"> Edit New Username </h5>
                    </div>

                    <div class="modal-body">
                      <!-- Login message from PHP file -->
                      <div id="usernameMessage">

                      </div>

                      <div class="form-group">
                        <input class="form-control" type="text" name="username" id="username" maxlength="30" placeholder="Username"/>
                      </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </div>
            </div>
          </div>
        </form>

        <!-- Update Email form -->
        <form method="post" id="updateEmailForm">
          <div class="modal" id="updateEmailModal" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button class="close" data-dismiss="modal">&times;</button>
                      <h5 class="pull-left"> Edit New Email </h5>
                    </div>

                    <div class="modal-body">
                      <!-- Login message from PHP file -->
                      <div id="emailMessage">

                      </div>

                      <div class="form-group">
                        <input class="form-control" type="text" name="newemail" id="newemail" maxlength="30" placeholder="Your New Email"/>
                      </div>

                      <div class="form-group">
                        <input class="form-control" type="text" name="confirmemail" id="confirmemail" maxlength="30" placeholder="Confirm Your New Email"/>
                      </div>

                      <div class="form-group">
                        <input class="form-control" type="password" name="emailpassword" id="emailpassword" maxlength="30" placeholder="Enter Your Password"/>
                      </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </div>
            </div>
          </div>
        </form>

        <!-- Update password form -->
        <form method="post" id="updatePasswordForm">
          <div class="modal" id="updatePasswordModal" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button class="close" data-dismiss="modal">&times;</button>
                      <h5 class="pull-left"> Enter Current and New Password</h5>
                    </div>

                    <div class="modal-body">
                      <!-- Login message from PHP file -->
                      <div id="passwordMessage">

                      </div>

                      <div class="form-group">
                        <input class="form-control" type="password" name="currentPassword" id="email" maxlength="30" placeholder="Your Current Password"/>
                      </div>

                      <div class="form-group">
                        <input class="form-control" type="password" name="password1" id="password1" maxlength="30" placeholder="Choose a New Password"/>
                      </div>

                      <div class="form-group">
                        <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm Password"/>
                      </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </div>
                </div>
            </div>
          </div>
        </form>



      </div>

    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Online Notes 2017 by Hunting</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/onlinenotes.js"></script>

    <!-- Profile JavaScript -->
    <script src="js/profile.js"></script>

</body>

</html>
