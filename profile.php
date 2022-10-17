<?php
$title = "Profile";
include 'base/head.php';
Session::CheckSession();

 ?>

<?php
// Redirect to index page if not Super User nor the User itself

if (isset($_GET['id'])) {
    $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
    ?> 
     <center>
     <div class="alert alert-dismissible alert-info col-4">
         <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         <strong><?php echo $updateUser?></strong>
     </div></center>
 
 <?php
 } 

$getUinfo = $users->getUserInfoById($userid);
if ($getUinfo) {
?>
    <div class="container-fluid">
    <div class="row justify-content-center mt-4">        
        <div class="col-4">
        <div class="card border-dark m-3" style="max-width: 30rem;">
            <div class="card-header d-flex justify-content-center">Edit User</div>
            <div class="card-body">
            <form method="POST">
                <strong>User Account</strong>
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="<?php echo $getUinfo->emailaddress; ?>" >
                        <label for="email-address">Email Address</label>
                    </div>
                </div>
                <hr>

                <strong>User Profile</strong>
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $getUinfo->firstname; ?>" >
                        <label for="first-name">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $getUinfo->lastname; ?>" >
                        <label for="last-name">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Middle Name" name="middlename" value="<?php echo $getUinfo->middlename; ?>" >
                        <label for="middle-name">Middle Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Address" name="address" value="<?php echo $getUinfo->address; ?>" >
                        <label for="address">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Company" name="company" value="<?php echo $getUinfo->company; ?>" >
                        <label for="company">Company</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Contact Number" name="number" value="<?php echo $getUinfo->contactnumber; ?>">
                        <label for="company">Contact Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Position" name="position" value="<?php echo $getUinfo->position; ?>">
                        <label for="company">Position</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="update">Submit</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
    
<?php
}
include 'base/foot.php';
