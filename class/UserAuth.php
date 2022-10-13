<?php
include_once 'DB.php';
session_start();

class UserAuth extends Dbh{
    private static $db;

    public function __construct(){
        $this->db = new Dbh();
    }
    public function validatePassword($password,$confirmPassword){
        $this->password = $password;
        $this->confirmpassword = $confirmPassword;

        if ($this->password == $this->confirmPassword){
            return TRUE;
        }else{
            return FALSE;
        }  
    }
    public function checkUsernameExist($username){
        $conn = $this->db->connect();
        $this->username = $username;
        $sql = "SELECT * FROM user WHERE username='$this->username'";
        $result = $this->db->connect()->query($sql);
        if($result->num_rows > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function checkEmailExist($email){
        $conn = $this->db->connect();
        $this->email = $email;
        $sql = "SELECT * FROM user WHERE emailaddress='$this->email'";
        $result = $this->db->connect()->query($sql);
        if($result->num_rows > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function checkPassword($password){
        $this->password = $password;
        $conn = $this->db->connect();
        $sql = "SELECT * FROM user WHERE password = '$this->password'";
        $result = $conn->query($sql);
        
        if($result->num_rows > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function isCharOnly($str){
        $this->str = $str;
        if (!preg_match('/^[\p{L} ]+$/u', $str)){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    public function register($username, $email, $password, $password2, $firstname, $lastname, $middlename, $address, $company, $number, $position, $active){
        $conn = $this->db->connect();

        // if passwords match each other ; TRUE
        if(!$this->validatePassword($password, $password2)){
            // if email exist ; TRUE
            if (($this->checkEmailExist($email))){
                echo "<script>alert('Email already Exist');
                window.location = './forms/register.php'; </script>";
                exit();
            }
            // if username exist; TRUE
            if (($this->checkUsernameExist($username))){
                echo "<script>alert('Username already Exist');
                window.location = './forms/register.php'; </script>";
                exit();
            }
            // inserting registered data into Database
            $sql = "INSERT INTO user (`username`, `emailaddress`, `password`, `firstname`, `middlename`, `lastname`, `address`, `company`, `contactnumber`, `position`, `active`, `super_user`) VALUES ('$username','$email', '$password', '$firstname', '$middlename', '$lastname', '$address', '$company', '$number', '$position', '$active', 0 )";
            if($conn->query($sql)){
                echo "<script>alert('Registration was successful');
                    window.location = './forms/login.php'; </script>";
            } 
            
        }else{
            echo "<script>alert('Password does not match');
                window.location = './forms/register.php'; </script>". $conn->error;
        }

        
    }
    public function login($email, $password){
        $conn = $this->db->connect();

        if ($this->checkEmailExist($email) == TRUE){
            if ($this->checkPassword($password) == TRUE){
                $_SESSION['email'] = $email;
                $this->email = $_SESSION['email'];
                echo "<script>alert('You logged in successfully');
                    window.location = './dashboard.php'; </script>";
            }else{
                echo "<script>alert('Either your Email or password is wrong');
                window.location = './forms/login.php'; </script>";
            }
        }else{
            echo "<script>alert('Either your Email or password is wrong');
                window.location = './forms/login.php'; </script>";
        }
    }
    public function getAllUsers(){
        $conn = $this->db->connect();
        $sql = "SELECT * FROM Students";
        $result = $conn->query($sql);
        echo"
        <html>
        <head>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
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
                    "</td> <td style='width: 150px'>" . $data['firstname'] . 
                    "</td> <td style='width: 150px'>" . $data['lastname'] . 
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
        $result = $this->checkEmailExist($email);

        if ($result){
            $sql = "UPDATE Students SET password = '$password' WHERE email = '$email'";
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
        $sql_one = "SELECT * FROM Students WHERE id = '$id'";
        $result = $conn->query($sql_one);
            if($result->num_rows > 0 ){
                $sql_two = "DELETE FROM Students WHERE id = '$id'";
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
