<?php

include 'Database.php';
include_once 'Session.php';


class Users{

  // Db Property
    private $db;

  // Db __construct Method
    public function __construct(){
      $this->db = new Database();
    }

    // Date formate Method
    public function formatDate($date){
        // date_default_timezone_set('Asia/Manila');
        $strtime = strtotime($date);
        return date('Y-m-d H:i:s', $strtime);
    }
    public function UsernameExist($username){
        $this->username = $username;
        $sql = "SELECT * FROM user WHERE username='$this->username'";
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        if($result->fetchColumn() > 0){
            // username(s) matches with param
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function EmailExist($email){
        $this->email = $email;
        $sql = "SELECT * FROM user WHERE emailaddress='$this->email'";
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        if($result->fetchColumn() > 0){
            // email(s) matches with param
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getDataFromDB($username){
        $this->username = $username;
        $sql = "SELECT * FROM user WHERE username='$this->username'";
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        if($result->fetchColumn() > 0){
            return $result->fetch(PDO::FETCH_OBJ);
        }
    }

    public function NotChar($str){
        // check if doesnt contain letters and whitespace/tab char
        if (preg_match("/^[a-zA-Z\s]+$/", $str)){
            return FALSE;
        }else{
            return TRUE;
        }  
    }

    public function NotContactNumber($number){
        // check if does not contains only '+' and numbers
        if (!preg_match('/^\+?\d+$/', $number)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function NotValidAddress($address){
        // check if contains # , . characters and space
        if (!preg_match('^[#.0-9a-zA-Z\s,-]+$', $address)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function EncryptPassword($password){
        //hashing
        return password_hash($password, PASSWORD_DEFAULT);
    }


    // Check Exist Email Address Method
    public function checkExistEmail($email){
      $sql = "SELECT email from user WHERE emailaddress = :email";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      if ($stmt->rowCount()> 0) {
        return true;
      }else{
        return false;
      }
    }

    // Check Password if Match Each Other
    public function NotValidPassword($password,$confirmPassword){
      if ($password == $confirmPassword){
        return false;
      }else{
        return true;
      }
    }  

    // User Registration Method
    public function userRegistration($data){
      $username = $data['username'];
      $email = $data['email'];
      $password = $data['password'];
      $password2= $data['password2'];
      $firstname = $data['fname'];
      $lastname = $data['lname'];
      $middlename = $data['mname'];
      $address = $data['address'];
      $number = $data['number'];
      $company = $data['company'];
      $position = $data['position'];
      $active = $data['active'];
      $registerpage = "Location: ./register.php";
      $loginpage = "Location: ./login.php?msg=Success!";
      $msg="";
      
      // exit if any field is empty
      if (empty($username) || empty($email) || empty($password) || empty($password2) || empty($firstname) || empty($lastname) || empty($middlename) || empty($address) || empty($company) || empty($number) || empty($position) || empty($active)){
        $msg = $msg . ' - Please fill out all fields!';
      }

      //  if username exist
      if (($this->UsernameExist($username))){
        $msg = $msg . '<br> - Username already exists!';
      }

      // if email exist
      if (($this->EmailExist($email))){
        $msg = $msg . '<br> - Email already exists!';
      }

      // check if passwords doesnt match each other ;
      if($this->NotValidPassword($password, $password2)){
        $msg = $msg . '<br> - Password doesn\'t match!';
      }

      // checks if list items are not char
      if($this->NotChar($firstname) || $this->NotChar($lastname) || $this->NotChar($middlename) || $this->NotChar($company) || $this->NotChar($position)){
        $msg = $msg . '<br> - Name, Company, Position fields should only contain letters!';
      }

      // checks if contact number is numerical
      if($this->NotContactNumber($number)){
        $msg = $msg . '<br> - Invalid Contact Number';
      }

      // if none of the statements above were met
      if($msg){
        Session::set('msg', $msg);
        header($registerpage . "?msg=Error");
        exit();
      }
    
      $sql = "INSERT INTO user(username, emailaddress, password, name, company, contactnumber, position, active) VALUES(:username, :emailaddress, :password, :name, :company, :contactnumber, :position, :active";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $firstname." ".$middlename." ".$lastname);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':emailaddress', $email);
      $stmt->bindValue(':password', $this->EncryptPassword($password));
      $stmt->bindValue(':company', $company);
      $stmt->bindValue(':number', $number);
      $stmt->bindValue(':position', $position);
      $stmt->bindValue(':active', $active);
      $result = $stmt->execute();
      if ($result) {
        $msg = 'You have Registered Successfully';
          return $msg;
      }else{
        $msg = 'Something went Wrong';
          return $msg;
      }


    }
    // Add New User By Admin
    public function addNewUserByAdmin($data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['emailaddress'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];
      $password = $data['password'];

      $checkEmail = $this->EmailExist($email);

      if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
        $msg = 'Input fields must not be Empty';
          return $msg;
      }elseif (strlen($username) < 3) {
        $msg = 'Username is too short, at least 3 Characters';
          return $msg;
      }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
        $msg = 'Enter only Number Characters for Mobile number field';
          return $msg;

      }elseif(strlen($password) < 5) {
        $msg = 'Password at least 6 Characters';
          return $msg;
      }elseif(!preg_match("#[0-9]+#",$password)) {
        $msg = 'Your Password Must Contain At Least 1 Number';
          return $msg;
      }elseif(!preg_match("#[a-z]+#",$password)) {
        $msg = 'Your Password Must Contain At Least 1 Number';
          return $msg;
      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = 'Invalid email address';
          return $msg;
      }elseif ($checkEmail == TRUE) {
        $msg = 'Email already Exists, please try another Email...';
          return $msg;
      }else{

        $sql = "INSERT INTO user(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', SHA1($password));
        $stmt->bindValue(':mobile', $mobile);
        $stmt->bindValue(':roleid', $roleid);
        $result = $stmt->execute();
        if ($result) {
          $msg = 'Wow, you have Registered Successfully';
            return $msg;
        }else{
          $msg = 'Something went Wrong';
            return $msg;
        }



      }

    }

    // Select All User Method
    public function selectAllUserData(){
      $sql = "SELECT * FROM user ORDER BY id DESC";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // User login Autho Method
    public function userLoginAutho($username, $password){
      $password = $this->EncryptPassword($password);
      $sql = "SELECT * FROM user WHERE username = :username and password = :password LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':password', $password);
      $stmt->execute();
      Session::set('data', $this->getDataFromDB($username));
      return $stmt->fetch(PDO::FETCH_OBJ);
    }
    // Check User Account Satatus
    public function CheckActiveUser($username){
      $sql = "SELECT * FROM user WHERE username = :username and active = :isActive LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':email', $username);
      $stmt->bindValue(':isActive', 'active');
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
    }




    // User Login Authotication Method
    public function login($data){
      $username = $data['username'];
      $password = $data['password'];
      if ($this->UsernameExist($username)){
          // check if password matches hashed password in DB
          if(password_verify($password, $this->getDataFromDB($username)->password) && $this->getDataFromDB($username)->active == "active"){
              Session::set('logged', TRUE);
              Session::set('data', $this->getDataFromDB($username));
              Session::set('msg', "Successfully logged in!");

          }elseif($this->getDataFromDB($username->active !== "active")){
              Session::set('msg', "Inactive user!");
          }else{
              Session::set('msg', "Password doesn't match!");
          }
      }else{
          Session::set('msg', "Username doesn't exist!");
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



    //Get Single User Information By Id Method
    public function updateUserByIdInfo($userid, $data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];



      if ($name == "" || $username == ""|| $email == "" || $mobile == ""  ) {
        $msg = ' Input Fields must not be Empty!';
          return $msg;
        }elseif (strlen($username) < 3) {
          $msg = ' Username is too short, at least 3 Characters!';
            return $msg;
        }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
          $msg = ' Enter only Number Characters for Mobile number field!';
            return $msg;


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = ' Invalid email address!';
          return $msg;
      }else{

        $sql = "UPDATE user SET
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile,
          roleid = :roleid
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':roleid', $roleid);
          $stmt->bindValue(':id', $userid);
        $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', ' Wow, Your Information updated Successfully!');



        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', ' Data not inserted!');


        }


      }


    }




    // Delete User by Id Method
    public function deleteUserById($remove){
      $sql = "DELETE FROM user WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = ' User account Deleted Successfully!';
            return $msg;
        }else{
          $msg = ' Data not Deleted!';
            return $msg;
        }
    }

    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive){
      $sql = "UPDATE user SET

       active=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', 'User account Deactivated Successfully!');

        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', ' Data not Deactivated!');
        }
    }


    // User Deactivated By Admin
    public function userActiveByAdmin($active){
      $sql = "UPDATE user SET
       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', 'User account activated Successfully!');
        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', ' Data not activated!');
        }
    }




    // Check Old password method
    public function CheckOldPassword($userid, $old_pass){
      $old_pass = SHA1($old_pass);
      $sql = "SELECT password FROM user WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      }else{
        return false;
      }
    }



    // Change User pass By Id
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];


      if ($old_pass == "" || $new_pass == "" ) {
        $msg = ' Password field must not be Empty!';
          return $msg;
      }elseif (strlen($new_pass) < 6) {
        $msg = ' New password must be at least 6 character!';
          return $msg;
       }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = 'Old password did not Matched!';
             return $msg;
         }else{
           $new_pass = SHA1($new_pass);
           $sql = "UPDATE user SET

            password=:password
            WHERE id = :id";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='index.php';</script>";
            Session::set('msg', 'Great news, Password Changed successfully!');

          }else{
            $msg = 'Password did not changed!';
              return $msg;
          }

         }



    }
}