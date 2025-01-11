


$('#requestAuthForm').submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "admin/submits/RBIMRequests.php?action=authenticateRequest",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend:function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)
                if (response.status == 3) {
                    location.href = "certificate_request"
                }
            }, 300);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something went wrong.")
            }, 300);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, 300);
        }
    });
});

$('#requestCertificateForm').submit(function (e) { 
    e.preventDefault();


    let certificates = [];

    $.each($('input[name="certificate"]:checked'), function (index, elem) { 
            certificates.push($(elem).val())
    });



    let data = {
        'name': $('#reqName').val(),
        'email': $('#reqEmail').val(),
        'contactNumber': $('#reqContactNumber').val(),
        'address' : $('#reqAddress').val(),
        'reptMethod': $('#reptMethod').val(),
        'description': $('#reqDescription').val(),
        'certificates':certificates
    }

    console.log(data)


    $.ajax({
        type: "POST",
        url: "admin/submits/certificationsRequests.php?action=newRequestCertificate",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    $('input, textarea').prop('disabled', true)
                    setTimeout(() => {
                        location.href = "home"
                    }, 3000);
                }
            }, 300);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something Went Wrong.")
            }, 300);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, 300);
        }
    });
    
});
