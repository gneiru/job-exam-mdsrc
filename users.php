<?php 
$title = "Users";
include 'base/head.php';
include 'class/UserAuth.php';

if (Session::get('logged') == FALSE){
    header("Location: login.php");
}
$user = new UserAuth();

$user->getAllUsers();
?>
<?php 
include 'base/foot.php';
?>