

const violationFormModal = document.getElementById('violationFormModal')
const violationFormModalBS = new bootstrap.Modal(violationFormModal)
const violationForm = document.getElementById('violationForm')

let violationsArr = null;


violationFormModal.addEventListener('hidden.bs.modal', function () {
    violationForm.reset();
    $('#serviceCont').addClass('d-none');
    $('#payableAmountCont').addClass('d-none');
    $('#id').val("")
})

$('#penaltyType').change(function (e) { 
    e.preventDefault();

    let type = $(this).val();

    if (type == 2) {
        $('#payableAmountCont').addClass('d-none');
    } else {
        $('#payableAmountCont').removeClass('d-none');
    }

    if (type == 1) {
        $('#serviceCont').addClass('d-none');
    } else {
        $('#serviceCont').removeClass('d-none');
    }

    if (type == "") {
        $('#serviceCont').addClass('d-none');
        $('#payableAmountCont').addClass('d-none');
    }

    $('#payableAmount').val("");
    $('#service').val("");
    
});

$('#violationForm').submit(function (e) { 
    e.preventDefault();
    

    $.ajax({
        type: "POST",
        url: "submits/violationsRequests.php?action=saveViolation",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if(response.status == 3) {
                    violationFormModalBS.hide();
                    getViolations()
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
});

let violationRow = function (index, violation) {

    let eidtBtn = '<button class="btn text-primary" onclick="editViolation('+violation.id+')"><span class="fas fa-edit"></span></button>';
    let prevBtn = '<button class="btn text-info" onclick="previewViolation('+violation.id+')"><span class="fas fa-eye"></span></button>';
    let deleteBtn = '<button class="btn text-danger" onclick="deleteViolation('+violation.id+')"><span class="fas fa-trash-alt"></span></button>';

    let row = '' +
    '<tr class="slide_in">' +
        '<td>'+violation.violation+'</td>' +
        '<td>'+eidtBtn+deleteBtn+'</td>' +
    '</tr>';


    return row;

}

// get violations
function getViolations() {

    $.ajax({
        type: "GET",
        url: "submits/violationsRequests.php?action=getViolations",
        // data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#violationsList', 3)
        },
        success: function (violations) {
            setTimeout(() => {
                console.log(violations)
                if (violations == null) {
                    displayTableMsg('violationsList', 3, ERRMSG)
                } else if (violations.length <= 0) {
                    displayTableMsg('violationsList', 3, "No Violations Found.")
                } else {
                    $('#violationsList').html("")

                    $('#violationFilter').html("")
                    $('#violationFilter').append('<option value="0">All</option>');


                    $("#violationId").html("");
                    $('#violationId').append('<option value="">Select Violation</option>');
                    
                    violationsArr = violations;
                    
                    $.each(violations, function (index, violation) { 
                        $('#violationsList').append(violationRow(index, violation));
                        $('#violationFilter').append('<option value="'+violation.id+'">'+violation.violation+'</option>');
                        $('#violationId').append('<option value="'+violation.id+'">'+violation.violation+'</option>');
                    });

                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('violationsList', 3, ERRMSG)
            }, timeout);
        },
    });
}

getViolations()





// edit
function editViolation(id) {
    $.ajax({
        type: "GET",
        url: "submits/violationsRequests.php?action=getViolation",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (violation) {
            setTimeout(() => {
                // console.log(violation)

                $.each(violation, function (prefix, value) { 
                     console.log(prefix + " : " + value)
                    $('#' + prefix).val(value);
                });


                let type = $('#penaltyType').val();

                $('#payableAmountCont').removeClass('d-none');
                $('#serviceCont').removeClass('d-none');


                if (type == 2) {
                    $('#payableAmountCont').addClass('d-none');
                } else {
                    $('#payableAmountCont').removeClass('d-none');
                }
            
                if (type == 1) {
                    $('#serviceCont').addClass('d-none');
                } else {
                    $('#serviceCont').removeClass('d-none');
                }


                violationFormModalBS.show();
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
}

function deleteViolation(id) {
    $.ajax({
        type: "POST",
        url: "submits/violationsRequests.php?action=deleteViolation",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if(response.status == 3) {
                    violationFormModalBS.hide();
                    getViolations()
                }
                
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
}