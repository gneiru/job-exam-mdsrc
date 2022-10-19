<?php

include 'Database.php';
include_once 'Session.php';


class Users{


  // Db Property
  private $db;

  private $msg;
  private $perPage = 5;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Check Letters and Space method
  public function isNotChar($list){
    $isTrue = false;
    foreach($list as $str){ 
      // Not (!) Matching whether consists of all letters 
      if(!ctype_alpha(str_replace(" ","",$str))){
        return true;
        exit();
      } 
    }
    return $isTrue;    
  }
  
  // Check Address Method
  public function invalidAddress($address){
    // Strip additional characters
    $address = str_replace(" ","",$address);
    $addres = str_replace("#","",$address);
    $addre = str_replace(",","",$addres);
    $addr = str_replace(".","",$addre);
    if(ctype_alnum($addr)){
      // String consists of alphanumeric characters
      return true;
    }else{
      false;
    }
  }

  // Check Exist Email Address Method
  public function checkExistEmail($email){
    $sql = "SELECT emailaddress from user WHERE emailaddress = :emailaddress";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':emailaddress', $email);
    $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }

  // Check if Username exists Method
  public function UsernameExist($username){
    $sql = "SELECT username from  user WHERE username = :username";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }

  // User Registration Method
  public function userRegistration($data){
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $password2 = $data['password2'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $middlename = $data['middlename'];
    $address = $data['address'];
    $company = $data['company'];
    $number = $data['number'];
    $position = $data['position'];
    $active = $data['isActive'];

    $CantRegister = false;
    $checkEmail = $this->checkExistEmail($email);
    $checkUsername = $this->UsernameExist($username);
    $checkChar = $this->isNotChar(array($firstname,$lastname,$middlename,$company,$position));
    $checkAddress = $this->invalidAddress($address);

    // VALIDATIONS ; returns True if invalid
    if ($checkEmail == TRUE) {
      $this->msg = $this->msg . "Email Already Exists!<br>";
      $CantRegister = true;
    }if ($checkUsername == TRUE) {
      $this->msg = $this->msg . "Username already exists!<br>";
      $CantRegister = true;
    }if ($password !== $password2) {
      $this->msg = $this->msg . "Passwords doesn't match!<br>";
      $CantRegister = true;
    }if ($username == "" || $email == "" || $number == "" || $password == "" || $password2 == "" || $firstname == "" || $lastname == "" || $middlename == "" ||$company == "" || $address == "" || $position == "") {
      $this->msg = $this->msg . "All fields must not be empty!<br>";
      $CantRegister = true;
    }if ($checkAddress == false && strlen($address) > 0) {
      $this->msg = $this->msg . "Address should only contain characters, numbers and special characters such as '#,.' <br>";
      $CantRegister = true;
    }if ($checkChar == true && $firstname != "" && $middlename != ""  && $lastname != ""  && $company != "" && $position != "") {
      $this->msg = $this->msg . "Name, Company, Position fields should only contain characters!<br>";
      $CantRegister = true;
    }if (filter_var($number,FILTER_SANITIZE_NUMBER_INT) == FALSE  && $number != "") {
      $this->msg = $this->msg . "Enter only Number Characters for Mobile number field! <br>";
      $CantRegister = true;
    }
    
    if ($CantRegister== false) {
      // Nothing met the if-else stamements before this statement
      $sql = "INSERT INTO user(username, emailaddress, password, firstname, middlename, lastname, address, company, contactnumber, position, active) VALUES(:username, :emailaddress, :password, :firstname, :middlename, :lastname, :address, :company, :contactnumber, :position, :active)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':emailaddress', $email);
      $stmt->bindValue(':password', sha1($password));
      $stmt->bindValue(':firstname', $firstname);
      $stmt->bindValue(':middlename', $middlename);
      $stmt->bindValue(':lastname', $lastname);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':company', $company);
      $stmt->bindValue(':contactnumber', $number);
      $stmt->bindValue(':position', $position);
      $stmt->bindValue(':active', $active);
      $result = $stmt->execute();
      if ($result) {
        $this->msg = $this->msg . "Registered Successfully!";
      }else{
        $this->msg = $this->msg . "Something went wrong!";
      }

    }
    Session::set('msg', $this->msg);
    return;

  }
  // Select User Method By Page
  public function selectAllUserData(){
    $sql = "SELECT * FROM user ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // User login Autho Method
  public function userLoginAutho($username, $password){
    $passw = sha1($password);
    $sql = "SELECT * FROM user WHERE username = :username and password = :password";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passw);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      return $stmt->fetch(PDO::FETCH_OBJ);
    }else{
      return false;
    }
    
  }
  // Check User Account Satatus, returns true if found one
  public function CheckActiveUser($username){
    $sql = "SELECT * FROM user WHERE username = :username and active = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':isActive', 'active');
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
      return true;
    }else{
      return false;
    }
  }

  // User Login Authotication Method
  public function userLoginAuthotication($data){
    $username = $data['username'];
    $password = $data['password'];

    $checkUsername = $this->UsernameExist($username);

    if ($username == "" || $password == "" ) {
      Session::set('msg', "Username and Password must not be empty!");
      return;

    }elseif($checkUsername == false){
      Session::set('msg',  "Username not found!");
      return;

    }else{

      $logResult = $this->userLoginAutho($username, $password);
      $chkActive = $this->CheckActiveUser($username);

      if ($chkActive == false) {
        Session::set('msg', 'Your account is inactive!');
        return;
      }elseif($logResult == false){
        Session::set('msg', 'Email or Password did not Matched');
        return;
      }elseif($logResult !== false){
        Session::set('logged', TRUE);
        Session::set('id', $logResult->id);
        Session::set('super_user', $logResult->super_user);
        Session::set('firstname', $logResult->firstname);
        Session::set('middlename', $logResult->middlename);
        Session::set('lastname', $logResult->lastname);
        Session::set('email', $logResult->emailaddress);
        Session::set('address', $logResult->address);
        Session::set('company', $logResult->company);
        Session::set('contactnumber', $logResult->contactnumber);
        Session::set('position', $logResult->position);
        Session::set('username', $logResult->username);
        header("Location: index.php");
      }else{
        Session::set('msg', 'Can\'t login!');
        return;
      }
    }
  }
  // Get Single User Information By Id Method
  public function getUserInfoById($userid){
    $sql = "SELECT * FROM user WHERE id = :id LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $userid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result;
    }else{
      return false;
    }
  }

  // Get Single User Information By Id Method
  public function updateUserByIdInfo($userid, $data){
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $middlename = $data['middlename'];
    $address = $data['address'];
    $company = $data['company'];
    $number = $data['number'];
    $position = $data['position'];

    $sql = "UPDATE user SET
      emailaddress = :emailaddress,
      contactnumber = :contactnumber,
      firstname = :firstname,
      middlename = :middlename,
      lastname = :lastname,
      company = :company,
      address = :address,
      position = :position
      WHERE id = :id";
      $stmt= $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->bindValue(':emailaddress', $email);
      $stmt->bindValue(':contactnumber', $number);
      $stmt->bindValue(':firstname', $firstname);
      $stmt->bindValue(':middlename', $middlename);
      $stmt->bindValue(':lastname', $lastname);
      $stmt->bindValue(':company', $company);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':position', $position);
      $result =   $stmt->execute();

    if ($result) {
      Session::set('msg', 'Updated Successfully!');
    }else{
      Session::set('msg', 'Update Failed!');
    }
    header("Location: index.php");
  }

  // Delete User by Id Method
  public function deleteUserById($remove){
    $sql = "DELETE FROM user WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $remove);
      $result =$stmt->execute();
      if ($result) {
        $msg = 'User account Deleted Successfully';
      }else{
        $msg = 'Data not Deleted! Due to some error. ';
      }
      Session::set('msg', $msg);
      header("Location: index.php");
  }
  
  // User Deactivate
  public function userDeactiveByAdmin($deactive){
    $sql = "UPDATE user SET active=:isActive WHERE id = :id";

      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':isActive', 'inactive');
      $stmt->bindValue(':id', $deactive);
      $result =   $stmt->execute();
      if ($result) {
        Session::set('msg', 'User account Deactivated Successfully!');
      }else{
        Session::set('msg', 'Data not Deactivated!');
      }
      header("Location: index.php");
  }


  // User Activate
  public function userActiveByAdmin($active){
    $sql = "UPDATE user SET active=:isActive WHERE id = :id";

      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':isActive', 'active');
      $stmt->bindValue(':id', $active);
      $result = $stmt->execute();
      if ($result) {
        Session::set('msg', 'User account Activated Successfully!');
      }else{
        Session::set('msg', 'Data not Activated!');
      }
      header("Location: index.php");
  }

  // Total Page Method
  public function totalPage()    {
    $this->sql = $this->db->pdo->prepare('SELECT * FROM user');
      try
      {
          $this->sql->execute();

          $data = $this->sql->rowCount();

          $totalPageNo = ceil($data/$this->perPage);
          
          return $totalPageNo;
          
      }
      catch(PDOException $Exception)
      {
          // Set error message on SESSION
          $this->msg = $Exception->getMessage();
          $msg = "Unexpected Error Occured. Please try again Later.<br> Error: ". $this->msg;
          Session::set('msg',$msg);
          return false;
      } 
  }

  // Select User Method By Page
  public function selectUsersByPage($pageNum){
    $offset = (int) ($pageNum-1) * $this->perPage;
    if($offset < 0){
      $offset=0;
    }
    $sql = "SELECT * FROM user LIMIT $offset, $this->perPage";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

}
