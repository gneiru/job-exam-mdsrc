<?php 
$title = "Login";
include 'base/head.php';

Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userLog = $users->userLoginAuthotication($_POST);
 }

// Session Error Message
$msg = Session::get('msg');
if ($msg !== false) {
    ?> 
    <center>
    <div class="alert alert-dismissible alert-info col-4">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong><?php echo $msg?></strong>
    </div></center>

<?php
}
Session::set("msg", NULL);

?>

<div class="form-content my-3 p-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card border-dark m-3" style="max-width: 30rem;">
                        <div class="card-header d-flex justify-content-center">Sign In
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="username" class="form-label mt-2">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" name="username">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="username" class="form-label mt-2">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group mt-0 mb-1 mt-2">
                                        <button type="submit" name="login" class="btn btn-primary">Log in</button>
                                        <button type="reset" class="btn btn-warning" >Reset</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">
                                Don't have an account yet? <a href="register.php"> Register </a><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
<?php include 'base/foot.php'?>