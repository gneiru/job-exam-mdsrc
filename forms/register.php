<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title></title>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            
                
            <div class="col-4">
                <h5>Create User</h5>
                <form name="userform" action="../action.php" method="POST" class="mb-5">
                    <strong>User Account</strong>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                          <label for="email-address">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="password" class="form-control" placeholder="Re-type Password" name="password2" required>
                          <label for="password2">Re-type Password</label>
                        </div>
                    </div>
                    <hr>

                    <strong>User Profile</strong>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="First Name" name="fname" required>
                            <label for="first-name">First Name</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" placeholder="Last Name" name="lname" required>
                          <label for="last-name">Last Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Middle Name" name="mname" required>
                            <label for="middle-name">Middle Name</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" placeholder="Address" name="address" required>
                          <label for="address">Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Company" name="company" required>
                            <label for="company">Company</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Contact Number" name="number" required>
                            <label for="company">Contact Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Position" name="position" required>
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
            </div>
        </div>    
    </div>
</body>
</html>