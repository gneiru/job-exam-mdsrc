<?php
include_once './class/Session.php';
Session::init();
include './class/Users.php';

$users = new Users();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  Session::destroy();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title> <?php echo $title;?> </title>

  <!-- NAVBAR MENU -->
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Test APP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Users</a>
        </li>
      </ul>
      <?php
      // Show Add User, Welcome Text, Logout IF LOGGED IN
      if(Session::get('logged') == TRUE){?>
      <ul class="navbar-nav ms-md-auto">
        <li class="nav-item">
          <a class="nav-link" href="register.php">Add User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active">Welcome <strong> <?php echo Session::get('username')?></strong></a>
        </li>
        <li>
        <li class="nav-item">
          <a name="logout" class="nav-link" href="?action=logout">Log out</a>
        </li>
      </ul>
      <?php
      }?>
    </div>
  </div>
</nav>
</head>
<body>

