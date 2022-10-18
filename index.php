<?php
$title = "Users";
include 'base/head.php';

// Check Session, Login if not Logged 
Session::CheckSession();

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
// Unset ErrorMsg Session after Display
Session::set("msg", NULL);

// Get page index from url, if nothing found, set it to 1
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

?>
<?php

// Call Delete User Method
if (isset($_GET['remove'])) {
    $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
    $removeUser = $users->deleteUserById($remove);
    header("Location: index.php"); 
}
// Call Deactivate / Activate User Method
    if (isset($_GET['deactive'])) {
        $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
        $deactiveId = $users->userDeactiveByAdmin($deactive);
    }
    elseif (isset($_GET['active'])) {
        $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
        $activeId = $users->userActiveByAdmin($active);
    }
    ?>
<!-- Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for name, username..">
            </div>
            <div class="card ">
                <div class="card-header">
                    <h3>User List</h3>
                </div>
                <div class="card-body pr-2 pl-2 " id="pagination_data">
                        <?php
                        // Call the viewUsers() method to display data from the database
                        if(isset($_GET['page']) == True){
                            // paginated
                            $allUser = $users->selectUsersByPage($page);
                            // Call the totalPage() method to find total page on pagination
                            $totalPage = $users->totalPage();
                        }else{
                            // non- paginated
                            $allUser = $users->selectAllUserData();
                        }
                        if ($allUser) {
                            $i = 0;
                            ?><table id="myTable" class="table-responsive table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Date Created</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th width='25%'>Control</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            foreach ($allUser as  $value) {
                                $i++;
                            ?>
                            <tr class="text-center"
                            
                            <?php 
                            // Highlight logged in Data's Column
                            if (Session::get("id") == $value->id) {
                                echo "style='background:pink' ";
                            } ?>
                            <td></td>
                            <td><?php echo $value->id; ?></td>
                            <td><?php echo $value->username; ?></td>
                            <td><?php echo $value->lastname . ", " . $value->firstname . " " . $value->middlename; ?> <br>
                            <td><?php echo date("m-d-Y",strtotime($value->added));  ?></td>
                            <td><?php echo $value->position; ?></td>
                            <td><?php echo $value->active;?></td>
                            <td>
                                <!--view button-->
                                <button class="btn btn-success btn-sm" href="?id=<?php echo $value->id;?>" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $value->id;?>">✓</button>

                                <!-- View user modal -->
                                <div class="modal" id="myModal<?php echo $value->id;?>" tabindex="-1" arialabelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Name: <strong><?php echo $value->lastname . ", " . $value->firstname . " " . $value->middlename;?></strong> </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"></span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <ul class="list-unstyled">
                                            <li>Username: <strong><?php echo $value->username;?></strong></li> 
                                            <li>First Name: <strong><?php echo $value->firstname;?></strong></li></li>
                                            <li>Middle Name: <strong><?php echo $value->middlename;?></strong></li></li>
                                            <li>Last Name: <strong><?php echo $value->lastname;?></strong></li></li>
                                            <li>Email: <strong><?php echo $value->emailaddress;?></strong></li>
                                            <li>Address: <strong><?php echo $value->address;?></strong></li>
                                            <li>Company: <strong><?php echo $value->company;?></strong></li>
                                            <li>Contact Number: <strong><?php echo $value->contactnumber;?></strong></li>
                                            <li>Position: <strong><?php echo $value->position;?></strong></li>
                                        </ul>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                        <?php   if ( Session::get("super_user") == '1') {?>
                                    <!--edit button-->
                                    <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>

                                    <!--delete button-->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete<?php echo $value->id;?>">
                                        Delete
                                    </button>

                                    <!-- Activate or Deativate Buttons -->
                                    <?php if ($value->active == 'active') {  ?>
                                        <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-warning
                                        <?php
                                        if (Session::get("id") == $value->id) {
                                            echo "disabled";
                                        } ?>
                                        btn-sm " href="?deactive=<?php echo $value->id;?>">Deact</a>
                                    <?php }elseif($value->active == 'inactive'){?>
                                        <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-secondary
                                        <?php
                                        if (Session::get("id") == $value->id) {
                                            echo "disabled";
                                        } ?>
                                        btn-sm " href="?active=<?php echo $value->id;?>">Activate</a>
                                        <?php } ?>

                        <?php  }elseif(Session::get("id") == $value->id  && Session::get("super_user") !== '0'){ ?>
                                    <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                                    <?php  
                                } ?>

                            <!-- MODEL DELETE USER -->
                            <div class="modal" id="delete<?php echo $value->id;?>" tabindex="-1" arialabelledby="myModalLabel2" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">
                                        Username: <?php echo $value->username;?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"></span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <p>Are you sure you want to delete the user?</p>
                                    </div>
                                    <div class="modal-footer">
                                    <form action="?remove=<?php echo $value->id;?>" method="POST">
                                        <input type="submit" class="btn btn-primary" value="Delete">
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </td>
                            </tr>
                        <?php }}else{ ?>
                            <tr class="text-center">
                            <td>No user availabe now !</td>
                        </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <?php
                        if(isset($_GET['page'])){?>
                            <ul class="pagination mt-4">
                                <!-- $page is the page number of pagination. if it is 1 or less, disable the Previous button  -->
                                <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                    <a class="page-link" href="index.php?page=<?=$page-1?>">Previous</a>
                                </li>
                                <?php
                                    for($i = 1; $i <= $totalPage; $i++)
                                    {
                                        ?>
                                        <!-- Add active effect if page number on URL is equal to current page link  -->
                                        <li class="page-item <?php if($i == $page){echo 'active';}?>"> 
                                            <a class="page-link" href="index.php?page=<?=$i?>"><?=$i?></a>
                                        </li>
                                        <?php
                                    }
                                ?>
                            
                                <!-- $page is the page number of pagination. if it is Equal to last page, disable the Next button  -->
                                <li class="page-item <?php if($page >= $totalPage){ echo 'disabled'; } ?>"> 
                                    <a class="page-link" href="index.php?page=<?=$page+1?>">Next</a>
                                </li>
                                <!-- Disable Pagination Button -->
                                <li class="page-item"> 
                                    <a class="btn btn-outline-dark" href="index.php">Disable Pagination</a>
                                </li>
                            </ul>
                        <?php }else{?>
                           <a class="btn btn-outline-dark mt-4" href="index.php?page=1">Enable Pagination</a>
                        <?php
                        }?>
                    </nav>
                    

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function filterTable(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#myTable tbody").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var firstCol = rows[i].cells[2].textContent.toUpperCase();
        var secondCol = rows[i].cells[1].textContent.toUpperCase();
        if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
}

document.querySelector('#myInput').addEventListener('keyup', filterTable, false);
</script>
<?php
// FOOTER
include 'base/foot.php';

?>
