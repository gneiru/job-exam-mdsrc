<?php
include_once './class/Session.php';
Session::init();
include './class/Users.php';

$users = new Users();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  // Session::set('logout', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  // <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  // <strong>Success !</strong> You are Logged Out Successfully !</div>');
  Session::destroy();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title> <?php echo $title;?> </title>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Test</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./users.php">Users</a>
        </li>
      </ul>
      <?php
      if(Session::get('logged') == TRUE){?>
      <ul class="navbar-nav ms-md-auto">
            <li class="nav-item">
            <a class="nav-link active">Welcome <strong> <?php echo Session::get('data')['firstname'] . " " . Session::get('data')['lastname'] ?></strong></a>
            </li>
            <li>
            <?php 
            if(Session::get('logged') == TRUE){?>
            <li class="nav-item">
                <a name="logout" class="nav-link" href="?action=logout">Log out</a>
            </li>
            <?php
            }?>
            </li>
      </ul>
      <?php }?>
    </div>
  </div>
</nav>
</head>
<body>

