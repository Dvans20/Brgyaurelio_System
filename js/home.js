
const timeout = 300;

let requestCertificateFormModal = document.getElementById('requestCertificateFormModal')
let requestCertificateFormModalBS = new bootstrap.Modal(requestCertificateFormModal)
let requestCertificateForm = document.getElementById('requestCertificateForm')


requestCertificateFormModal.addEventListener('hidden.bs.modal', function () { 
    requestCertificateForm.reset()
})


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
                    requestCertificateFormModalBS.hide()
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




let fileComplaintFormModal = document.getElementById('fileComplaintFormModal')
let fileComplaintFormModalBS = new bootstrap.Modal(fileComplaintFormModal);
let fileComplaintForm = document.getElementById('fileComplaintForm')

fileComplaintFormModal.addEventListener('hidden.bs.modal', function () {
    fileComplaintForm.reset()
})
$('#fileComplaintForm').submit(function (e) { 
    e.preventDefault();

    let complaints = [];

    $.each($('input[name="complain"]:checked'), function (index, val) { 
        complaints.push($(val).val())
    });

    let data = {
        'name' : $('#compName').val(),
        'email' : $('#compEmail').val(),
        'contactNo' : $('#compContactNo').val(),
        'complaints' : complaints,
        'description' : $('#description').val()
    }

    $.ajax({
        type: "POST",
        url: "admin/submits/complaintsRequests.php?action=newComplaints",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response);
                if (response.status == 3) {
                    fileComplaintFormModalBS.hide();
                }
                displayMsg(response.status, response.msg);
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                displayMsg(1, "Something Went Wrong.")
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });

    console.log($(this).serialize());
    
});