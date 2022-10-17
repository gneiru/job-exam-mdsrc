<?php

class Session{

  public static function init(){

    session_start();

  }

  // Session Set Method
  public static function set($key, $val){
    $_SESSION[$key] = $val;
  }

  // Session Get Method
  public static function get($key){
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }else{
      return false;
    }
  }

  // User logout Method
  public static function destroy(){
    session_destroy();
    session_unset();
    header('Location:login.php');
  }

  // Check Session Method
  public static function CheckSession(){
    if (self::get('logged') == FALSE) {
      session_destroy();
      header('Location:login.php');
    }
  }

  // Check Login Method
  public static function CheckLogin(){
    if (self::get("logged") == TRUE) {
      header('Location:index.php');
    }
  }

  // Check Edit User Permission Method
  public static function PermissionToEdit(){
    if (Session::get('super_user') != 1) {
      if(Session::get('id')!=$_GET['id']){
        header("Location: index.php");
      }
  }
  }
}
?>