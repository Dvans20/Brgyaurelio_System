
const userInfoFormModal= document.getElementById('userInfoFormModal')
const userInfoFormModalBS = new bootstrap.Modal(userInfoFormModal)
const userInfoForm = document.getElementById('userInfoForm')

const changePasswordFormModal = document.getElementById('changePasswordFormModal')
const changePasswordFormModalBS = new bootstrap.Modal(changePasswordFormModal)
const constchangePasswordForm = document.getElementById('changePasswordForm')


userInfoFormModal.addEventListener('hidden.bs.modal', function () {
    userInfoForm.reset();
})

changePasswordFormModal.addEventListener('hidden.bs.modal', function () {
    constchangePasswordForm.reset();
})

$("#editUserInfoBtn").click(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "GET",
        url: "submits/usersRequests.php?action=getLOggedInUser",
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (user) {
            setTimeout(() => {
                $('#newName').val(user.name)
                $('#newEmail').val(user.email)
                userInfoFormModalBS.show()
            }, timeout);
        },
        error: function (err) {
            console.log(err)
            setTimeout(() => {
                displayMsg(1, "Something Went Wrong")
            }, timeout);
        },
        complete: function () { 
            setTimeout(() => {
               hideLoadingScreen() 
            }, timeout);
         }
    });

    
});

$('#cnagePasswordBtn').click(function (e) { 
    e.preventDefault();
    changePasswordFormModalBS.show()
});

$('#changeNewPasswordToggleBtn').click(function (e) { 
    e.preventDefault();
    

    if ($('#newPassword').attr('type') == "password") {
        $('#newPassword').prop('type', 'text')
        $('#confirmNewPassword').prop('type', 'text')
        $(this).html('<span class="fas fa-eye-slash"></span> Hide Password')
    } else {
        $('#newPassword').prop('type', 'password')
        $('#confirmNewPassword').prop('type', 'password')
        $(this).html('<span class="fas fa-eye"></span> See Password')
    }
});

$('#newPasswordEyeBtn').click(function (e) { 
    e.preventDefault();
    
    if ($('#currentPassword').attr('type') == "password") {
        $('#currentPassword').prop('type', 'text')
        $(this).html('<span class="fas fa-eye-slash"></span>')
    } else {
        $('#currentPassword').prop('type', 'password')
        $(this).html('<span class="fas fa-eye"></span>')
    }
});

$('#changePasswordForm').submit(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=changePassword",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)
                if (response.status != 2) {
                    changePasswordFormModalBS.hide();
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something went Wrong.")
                changePasswordFormModalBS.hide()
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen(); 
            }, timeout);
        }
    });
    
});

// $('#updateUserInfo').click(function (e) { 
//     e.preventDefault();
//     $('#userInfoForm').submit();
// });

$('#userInfoForm').submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=updateUser",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)
                if (response.status != 2) {
                    userInfoFormModalBS.hide();
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something went wrong")
                userInfoFormModalBS.hide();
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});

$('#logOutBtn').click(function (e) { 
    e.preventDefault();
    

    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=logOut",
        dataType: "JSON",
        beforeSend:function() {
            showLoadingScreen();
        },
        success: function (response) {
            displayMsg(response.status, response.msg)
            setTimeout(() => {
                location.href = "dashboard";
            }, timeout);
        },
        error: function (err) {
            console.log(err)
            displayMsg(1, err.responseText);
        },
        complete: function () {
            hideLoadingScreen();
        }
    });
});

