<?php

class formController extends UserAuth
{
     public $fullname;
     public $email;
     public $password;
     public $confirmPassword;
     public $country;
     public $gender;

     public function __construct(){
        $this->db = new Dbh();
    }

    public function handleForm(){

        switch(true) {
            case isset($_POST['register']):
                // unpack user account data
                $this->username = $_POST['username'];
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->password2 = $_POST['password2'];
                // unpack user info data
                $this->firstname = $_POST['fname'];
                $this->lastname = $_POST['lname'];
                $this->middlename = $_POST['mname'];
                $this->address = $_POST['address'];
                $this->company = $_POST['company'];
                $this->number = $_POST['number'];
                $this->position = $_POST['position'];
                $this->active = $_POST['radio'];
                $this->register($this->username, $this->email, $this->password, $this->password2, $this->firstname, $this->lastname, $this->middlename, $this->address, $this->company, $this->number, $this->position, $this->active);
                break;
            case isset($_POST['login']):
                //unpack all data for login
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->login($this->email, $this->password);
                break;
            case isset($_POST['logout']):
                //unpack all data for logout
                $this->email = $_SESSION['email'];
                $this->logout($this->email);
                break;
            case isset($_POST['delete']):
                //unpack all data for deleting
                $this->id = $_POST['id'];
                $this->deleteUser($this->id);
                break;
            case isset($_POST['reset']):
                //unpack all data for updating password
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->updateUser($this->email, $this->password);
                break;
            case isset($_POST['all']):
                //unpack all data for getting all users
                $this->getAllUsers();
                break;
            default:
                echo 'No form was submitted';
                break;
        }
    }
    }