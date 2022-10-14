<?php 
$title = "Register";
include 'base/head.php';

if (Session::get('logged') == TRUE){
    header("Location: index.php");
}
?>

<div class="container-fluid">
    <div class="row justify-content-center mt-4">        
        <div class="col-4">
        <?php 
            if(!empty($_GET['msg'])){?>
                <div class="alert alert-dismissible alert-primary">
                    <button type="button" class="btn-close" data-dismiss="alert" onclick="location.href='register.php'"></button>
                    <strong><?php echo Session::get('msg')?></strong>
                </div>

            <?php
            }
        ?>
        <div class="card border-dark m-3" style="max-width: 30rem;">
            <div class="card-header d-flex justify-content-center">Create User</div>
            <div class="card-body">
            <form name="userform" action="action.php" method="POST">
                <strong>User Account</strong>
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username" >
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" >
                        <label for="email-address">Email Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" >
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Re-type Password" name="password2" >
                        <label for="password2">Re-type Password</label>
                    </div>
                </div>
                <hr>

                <strong>User Profile</strong>
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="First Name" name="fname" >
                        <label for="first-name">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Last Name" name="lname" >
                        <label for="last-name">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Middle Name" name="mname" >
                        <label for="middle-name">Middle Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Address" name="address" >
                        <label for="address">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Company" name="company" >
                        <label for="company">Company</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Contact Number" name="number" >
                        <label for="company">Contact Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Position" name="position" >
                        <label for="company">Position</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radio" value="active" checked>
                        <label class="form-check-label" for="inlineRadio1">Activate</label>
                        </div>
                    <div class="form-check form-check-inline mb-4">
                        <input class="form-check-input" type="radio" name="radio" value="inactive">
                        <label class="form-check-label" for="inlineRadio2">Deactivate</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="register">Submit</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
            <div class="card-footer text-center">
                <div class="small">
                    Have an account already? <a href="login.php"> Login </a><br>
                </div>
            </div>
            </div>
            
        </div>
        </div>
    </div>    
</div>

<?php include 'base/foot.php'?>