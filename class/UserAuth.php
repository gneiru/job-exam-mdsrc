<?php
include_once 'DB.php';
include_once 'Session.php';

Session::init();

class UserAuth extends Dbh{

    public function __construct(){
        $this->db = new Dbh();

    }

    public function NotValidPassword($password,$confirmPassword){
        if ($password == $confirmPassword){
            // passwords match each other
            return FALSE;
        }else{
            return TRUE;
        }  
    }

    public function UsernameExist($username){
        $this->username = $username;
        $sql = "SELECT * FROM user WHERE username='$this->username'";
        $result = $this->db->connect()->query($sql);
        if($result->num_rows > 0){
            // username(s) matches with param
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function EmailExist($email){
        $this->email = $email;
        $sql = "SELECT * FROM user WHERE emailaddress='$this->email'";
        $result = $this->db->connect()->query($sql);

        if($result->num_rows > 0){
            // email(s) matches with param
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getDataFromDB($username){
        $this->username = $username;
        $sql = "SELECT * FROM user WHERE username='$this->username'";
        $result = $this->db->connect()->query($sql);
        if($result->num_rows > 0){
            // username(s) matches with param
            return $result->fetch_assoc();
        }else{
            return null;
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

    public function register($username, $email, $password, $password2, $firstname, $lastname, $middlename, $address, $company, $number, $position, $active){
        $registerpage = "Location: ./register.php";
        $loginpage = "Location: ./login.php?msg=Success!";
        $msg = "";
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
       
        // inserting registered data into Database
        $password = $this->EncryptPassword($password);
        $sql = "INSERT INTO user (`username`, `emailaddress`, `password`, `firstname`, `middlename`, `lastname`, `address`, `company`, `contactnumber`, `position`, `active`, `super_user`) VALUES ('$username','$email', '$password', '$firstname', '$middlename', '$lastname', '$address', '$company', '$number', '$position', '$active', 0 )";
        if($this->db->connect()->query($sql)){
            Session::set('msg', "Successfully ADDED!");
            header($loginpage);
            exit();
            
        }       
    }

    public function login($username, $password){
        if ($this->UsernameExist($username)){
            // check if password matches hashed password in DB
            if(password_verify($password, $this->getDataFromDB($username)['password']) && $this->getDataFromDB($username)['active'] == "active"){
                Session::set('logged', TRUE);
                Session::set('data', $this->getDataFromDB($username));
                
                Session::set('msg', "Successfully added!");

            }elseif($this->getDataFromDB($username)['active'] != "active"){
                Session::set('msg', "Inactive user!");
            }else{
                Session::set('msg', "Password doesn't match!");
            }
        }else{
            Session::set('msg', "Username doesn't exist!");
        }
        header("Location: ./login.php?msg=Error");
        
    }

    public function getAllUsers(){
        $conn = $this->db->connect();
        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);
        echo"<html>
        <head>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
        </head>
        <body>
        <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
        <table class='table table-bordered' border='0.5' style='width: 80%; background-color: smoke; border-style: none'; >
        <tr style='height: 40px'>
            <thead class='thead-dark'> <th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th>
        </thead></tr>";
        if($result->num_rows > 0){
            while($data = $result->fetch_assoc()){
                //show data
                echo "<tr style='height: 20px'>".
                    "<td style='width: 50px; background: gray'>" . $data['id'] . "</td>
                    <td style='width: 150px'>" . $data['name'] .
                    "</td> <td style='width: 150px'>" . $data['email'] .
                    "</td> <td style='width: 150px'>" . $data['gender'] . 
                    "</td> <td style='width: 150px'>" . $data['country'] . 
                    "</td>
                    <td style='width: 150px'> 
                    <form action='action.php' method='post'>
                    <input type='hidden' name='id'" .
                     "value=" . $data['id'] . ">".
                    "<button class='btn btn-danger' type='submit', name='delete'> DELETE </button> </form> </td>".
                    "</tr>";
            }
            echo "</table></table></center></body></html>";
        }
    }

    public function updateUser($email, $password){
        $conn = $this->db->connect();
        $result = $this->EmailExist($email);

        if ($result){
            $sql = "UPDATE user SET password = '$password' WHERE email = '$email'";
                if($conn->query($sql) === TRUE){
                    echo "<script>alert('Password has been changed');
                        window.location = 'forms/login.php'; </script>";
                } 
        
            }else{
                echo "<script>alert('Email does not exist');
                    window.location = 'forms/resetpassword.php'; </script>";
        
            }
    }

    public function deleteUser($id){
        $conn = $this->db->connect();
        $sql_one = "SELECT * FROM user WHERE id = '$id'";
        $result = $conn->query($sql_one);
            if($result->num_rows > 0 ){
                $sql_two = "DELETE FROM user WHERE id = '$id'";
                if($conn->query($sql_two) == TRUE){
                    echo "<script>alert('Deleted the record');
                        window.location = 'dashboard.php'; </script>";  
                }else{
                    echo "<script>alert('Could not delete this record');
                        window.location = 'dashboard.php'; </script>";  
                    }
                }
    }

    public function logout($email){
        $this->email = $_SESSION['email'];
        if ($this->email){
            session_unset();
            session_destroy();
            header('Location: ./forms/login.php');
        }
        
    }
}
