<link rel="stylesheet" href="<?php echo($extLink); ?>Views/css/header.css<?php echo "?v=" . time() . uniqid(); ?>">

<nav class="header w-100">

    <div class="header_container container">
        <div class="w-100">

            <h3 class="d-block text-center">
                BRGY. Management System
            </h3>

        </div>
        <div class="d-flex justify-content-end">
            <div class="dropdown">
                <button class="header_btn btn position-relative" role="button" id="settingsDropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fas fa-bell"></span>
                    <span class="notif_num_ico fade_in d-none">0</span>
                </button>
                <ul class="dropdown-menu" id="notificationsDropdown" aria-labelledby="settingsDropdownMenu">
                    <li><a class="dropdown-item text-center disabled p-5" href="#" disabled id="noNotifications">No Notifications</a></li>
                    <!-- <li><a class="dropdown-item" href="#"><span class="fas fa-server"></span> Complaints</a></li> -->
                    <!-- <li><a class="dropdown-item" href="#"><span class="fas fa-shield"></span> Feedbacks</a></li> -->
                </ul>
            </div>
            <div class="dropdown">
                <button class="header_btn btn" role="button" id="userDropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fas fa-user-cog"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdownMenu">
                    <li><a class="dropdown-item" href="#" id="editUserInfoBtn"><span class="fas fa-user-edit"></span> Edit User Info</a></li>
                    <li><a class="dropdown-item" href="#" id="cnagePasswordBtn"><span class="fas fa-user-lock"></span> Change Password</a></li>
                    <li><a class="dropdown-item" href="#" id="logOutBtn"><span class="fas fa-sign-out"></span> Log-out</a></li>
                </ul>
            </div>
        </div>
        
        
        
    </div>
  
    
</nav>

<div class="modal fade" id="userInfoFormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="updateUser.php" id="userInfoForm">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="newName" name="newName" placeholder="Full Name">
                        <label for="newName">Full Name</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="newEmail" name="newEmail" placeholder="Email">
                        <label for="newEmail">Email</label>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        <span class="fas fa-ban"></span> Cancel
                    </button>
                    <button class="btn btn-primary" id="updateUserInfo" type="submit">
                        <span class="fas fa-save"></span> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordFormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="changePassword.php" id="changePasswordForm">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating my-2">
                        <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Enter Password">
                        <label for="currentPassword">Enter Password</label>
                        <div id="newPasswordEyeBtn">
                            <span class="fas fa-eye" id="togglepasswordEye"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-1 d-flex justify-content-end">
                        <button class="btn" id="changeNewPasswordToggleBtn">
                            <span class="fas fa-eye"></span> See Password
                        </button>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter New Password">
                        <label for="newPassword">Enter New Password</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirm  New Password">
                        <label for="confirmNewPassword">Confirm New Password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                        <span class="fas fa-ban"></span> Cancel
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <span class="fas fa-lock-open"></span> Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="Views/js/header.js"></script>


<script>

    let numIco = 0

    updateNumIco(numIco)

    function updateRequestNotification() { 
        let data = {
            'status' : 0,
            'search': "",
            'page' : 1,
            'limit' : 0
        }

        $.ajax({
            type: "GET",
            url: "submits/certificationsRequests.php?action=getRequestsCount",
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                showLoadingTableContent("#requestsList", 5)
                $('#requestsLinks').html("")
            },
            success: function (count) {
                setTimeout(() => {
                    console.log(count)
                    $('#noNotifications').remove();
                    $('#notificationsDropdown').append('<li><a class="dropdown-item text-center p-2 px-4" href="requests" disabled>You have '+count+' pending requests.</a></li>');
                    updateNumIco(count)
                }, timeout);
            },
            error: function (err) {
                setTimeout(() => {
                    console.log(err)
                    displayTableMsg("requestsList", 5, ERRMSG)
                    
                }, timeout);
            },
            complete: function () { 
                setTimeout(() => {
                    
                }, timeout);
            }
        });
    }

    updateRequestNotification()

    

    function updateNumIco(num) {
        numIco += num

        if (numIco != 0) {
            if (numIco > 99) {
                $('.notif_num_ico').html(99 + "+");
            } else {
                $('.notif_num_ico').html(numIco);
            }
            $('.notif_num_ico').removeClass('d-none')
        } else {
            $('.notif_num_ico').addClass('d-none')
        }
     
    }


</script>