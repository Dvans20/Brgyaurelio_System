<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
</head>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>





        <main class="container py-5">

            <div class="card pop_in_on_scroll">
                <div class="card-header">
                    <div class="row m-0 p-0">
                        <div class="col-md-6 p-1 pt-3">
                            <h3><span class="fas fa-user-friends"></span> Users</h3>
                        </div>
                        <div class="col-md-6 p-1">
                            <div class="row m-0 p-0">
                                <div class="col-md-8 p-1 m-0">
                                    <form action="searchUsers.php" id="searchForm" class="w-100">
                                        <div class="d-flex">
                                            <div class="form-floating w-100" style="margin-right: -25px; margin-top: -10px;">
                                                <input type="text" class="form-control" id="search" placeholder="Search"  oninput="this.value = this.value.replace(/[0-9]/g, '')" >
                                                <label for="search">Search</label>
                                            </div>
                                            <button class="btn-none">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 p-1 m-0">
                                    <div class="d-flex justify-content-end pt-2">
                                        <button class="btn btn-primary text-nowrap w-100" id="addUserBtn" data-bs-target="#userFormModal" data-bs-toggle="modal">
                                            <span class="fas fa-user-plus"></span> Add User
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody id="usersList">
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <div id="userLinks"></div>
                    </div>
                </div>
            </div>
        
        </main>



    </div>



    <div class="modal fade" id="userFormModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="userForm.php" id="userForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" oninput="this.value = this.value.replace(/[^a-zA-Z .,]/g, '')">
                            <label for="name">Full Name</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating">
                            <select name="accessType" id="accessType" class="form-select">
                                <option value="">Select User Type</option>
                                <option value="1">Administrator</option>
                                <option value="2">Secretary</option>
                                <option value="3">Treasurer</option>
                            </select>
                            <label for="accessType">Select User Type</label>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm" type="button" id="userFormTogglePasswordBtn">
                                <span class="fas fa-eye"></span> See Password
                            </button>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                            <label for="confirmPassword">Confirm Password</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAccessTypeFormModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form action="editAccessType.php" id="editAccessTypeForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="userIdToEditAccessType" name="userIdToEditAccessType">

                        <div class="form-floating my-2">
                            <select name="newAccessType" id="newAccessType" class="form-select">
                                <option value="">Select User Type</optio>
                                <option value="1">Administrator</option>
                                <option value="2">Secretary</option>
                                <option value="3">Treasurer</option>
                            </select>
                            <label for="newAccessType">Select User Type</label>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="button"> 
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                        <button class="btn btn-sm btn-primary" id="updateAccessTypeBtn">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userIdToDelete" name="userIdToDelete">
                    Are you sure you want to delete <b id="userNameToDelete"></b> accout?
                    <br>
                    <div class="alert alert-danger">
                        <small>
                            <b>Warning!</b> Deleting this User will remove all of it's access and it cannot be undone.
                        </small>
                    </div>
                   
                    <div class="form-floating">
                        <input type="password" class="form-control" name="loggedInUserPasswordForDelete" id="loggedInUserPasswordForDelete" placeholder="Password">
                        <label for="loggedInUserPasswordForDelete">Password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" id="deleteUserBtn">Yes</button>
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
        include_once 'Views/templates/foot.php';
    ?>

    <script src="Views/js/users.js<?php echo "?v" . time() . uniqid(); ?>"></script>
</body>
</html>