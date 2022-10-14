<?php 
$title = "Login";
include 'base/head.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   $userLog = $users->login($_POST);
}
if (isset($userLog)) {
  echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
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
                                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="username" class="form-label mt-2">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
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