

$('#logInForm').submit(function (e) { 
    e.preventDefault();


    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=login",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)

                if (response.status == 3) {
                    setTimeout(() => {
                        location.href="dashboard"; 
                    }, timeout);
                }
                
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, err.responseText)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();    
            }, timeout);
        }

    });
});

$('#passwordEyeBtn').click(function () { 
    

    if ($('#password').attr('type') == "password") {
        $('#password').prop('type', 'text')
        $('#togglepasswordEye').removeClass('fa-eye')
        $('#togglepasswordEye').addClass('fa-eye-slash')
    } else {
        $('#password').prop('type', 'password')
        $('#togglepasswordEye').removeClass('fa-eye-slash')
        $('#togglepasswordEye').addClass('fa-eye')
    }
    
});