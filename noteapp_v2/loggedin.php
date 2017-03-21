<?php
// Check if there is a session of previous user, if not, redirect to the index.php;
session_start(); // This could also be resuming current session
if(!isset($_SESSION['user_id'])) {
  header("location: index.php");
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

    <title>My notes</title>

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
    .notes {
      display: table;
      width: 100%;
      height: 100%;
      /*position:absolute;*/
      padding: 100px 0;
      color: white;
      background: url(img/intro-bg2.jpg) repeat bottom center scroll;
      background-color: black;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      background-size: cover;
      -o-background-size: cover;
    }

    #allNotes, #done, #doneEdit {
      display: none;
    }

    #notePadRow {
      margin-top: 20px;
      display: none;
    }

    #alert{
      margin-top: 20px;
      display: none;
    }

    #notesRow {
      color: black;
      margin-top: 20px;
    }

    .note-text {
      font-size: 18px;
      font-family: "Comic Sans MS", cursive, sans-serif;
    }

    .note-time {
      margin-top: 10px;
      font-size: 12px;
      font-family: Tahoma, Geneva, sans-serif;
    }

    .note-header {
      border: 2px solid white;
      border-radius: 8px;
      margin-bottom: 10px;
      background-color: rgba(255, 255, 255, 0.6);
      cursor: pointer;
      padding: 0 10px;
    }

    .note-header .note-text {
      height: 40px;
      overflow: hidden;
    }

    .note-div {
      display: inline-block;
      width: 100%;
    }

    .delete {
      height: 90px;
      margin-top: 10px;
      display: none;
    }

    @media (min-width: 768px) {
      .notes .container {
        margin-top: 60px;
      }

      #notePad textarea {
        width: 100%;
        max-width: 100%;
        font-size: 16px;
        font-family: "Comic Sans MS", cursive, sans-serif;
        color: black;
        border-left-width:10px;
        border-color: #0c67b1;
        border-radius: 8px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8)
      }

    }

    @media (max-width: 768px) {
      .notes .container {
        margin-top: 40px;
      }


      #notePad textarea {
        width: 100%;
        max-width: 100%;
        font-size: 16px;
        font-family: "Comic Sans MS", cursive, sans-serif;
        color: black;
        border-left-width:10px;
        border-color: #0c67b1;
        border-radius: 8px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8)
      }
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
                        <a class="page-scroll" href="https://huntingzhu.github.io" target="_blank" >Contact</a>
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


    <!-- notes section -->
    <section class="notes">
      <div class="container">
        <div class="row" id="buttonRow">
          <div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
            <div id='buttons'>
              <button id="addNote" type="button" class="btn btn-primary pull-left">Add Note</button>
              <button id="edit" type="button" class="btn btn-primary pull-right">Edit</button>
              <button id="done" type="button" class="btn btn-success pull-right">Done</button>
              <button id="doneEdit" type="button" class="btn btn-success pull-right">Done</button>
              <button id="allNotes" type="button" class="btn btn-primary pull-left">All Notes</button>
            </div>
          </div>
        </div>

        <div class="row alertRow" id="alertRow" >
          <div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
            <!-- Show alert message here -->
            <div id="alert" class="alert alert-danger alert-dismissable">
              <a class="close" onclick="hideItem('#alert');">&times;</a>
              <p id="alertMessage"></p>
            </div>

          </div>
        </div>

        <div class="row" id="notePadRow">
          <div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
            <div id="notePad">
                <textarea rows="10" class="pull-left"></textarea>
            </div>
          </div>
        </div>

        <div class="row" id="notesRow">
          <div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
            <div id="notesList" class="notesList">

            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
          <p>Copyright &copy; Online Notes
            <br /> Designed by Hunting</p>
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

    <!-- My-notes JavaScript -->
    <script src="js/mynotes.js"></script>

</body>

</html>
