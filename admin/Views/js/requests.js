let currentPage = 1;


// get requests

$('input[name="statusFilter"]').click(function (e) { 

    $('.requests_status_btn').removeClass('active');

    $('.requests_status_btn[value="'+$(this).val()+'"]').addClass('active')
    
    getRequests(1)
});

$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getRequests(1)
});

let requestsRow = function (index, req) {

    let contactInfo = "";


    if (!(req.email == "" || req.email == null)) {
        contactInfo += '<div>Email: '+req.email+'</div>';
    }

    if (!(req.contactNumber == "" || req.contactNumber == null)) {
        contactInfo += '<div>Contact No.: '+req.contactNumber+'</div>';
    }

    let previewBtn = '<button class="btn btn-sm text-info" onclick="previewRequests('+req.id+')"><i class="fas fa-eye"></i></button>';


    let noCol = '<td class="text-center">'+(index + 1)+'</td>';
    let nameCol = '<td class="text-start">'+req.name+'</td>';
    let addressCol = '<td class="text-start">'+req.address+'</td>';
    let contactInfoCol = '<td class="text-start">'+contactInfo+'</td>';
    let btnCol = '<td class="text-start">'+previewBtn+'</td>';


    let row = '' +
    '<tr class="slide_in">' +
        noCol + nameCol + addressCol + contactInfoCol + btnCol +
    '</tr>' ;

    return row;
}

function getRequests(page) {

    let data = {
        'status' : $('input[name="statusFilter"]:checked')[0].value,
        'search': $('#search').val(),
        'page' : page,
        'limit' : LIMIT
    }

    $.ajax({
        type: "GET",
        url: "submits/certificationsRequests.php?action=getRequests",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent("#requestsList", 5)
            $('#requestsLinks').html("")
        },
        success: function (response) {
            setTimeout(() => {
                // console.log(response)
                if (!Array.isArray(response.requests)) {
                    displayTableMsg("requestsList", 5, ERRMSG)
                } else if (response.requests.length <= 0) {
                    displayTableMsg("requestsList", 5, "No Requests Found");
                } else {
                    $('#requestsList').html("");
                    $.each(response.requests, function (index, request) { 
                         $('#requestsList').append(requestsRow(index, request));
                    });
                    currentPage = page
                    displayPagination("requestsLinks", page, "getRequests", response.totalPages)
                }
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

getRequests(1)


let requestPreviewed = null;
const previewRequestModal = document.getElementById('previewRequestModal')
const previewRequestModalBS = new bootstrap.Modal(previewRequestModal)


const approveRequestModal = document.getElementById('approveRequestModal')
const approveRequestModalBS = new bootstrap.Modal(approveRequestModal)

const rescheduleRequestModal = document.getElementById('rescheduleRequestModal');
const rescheduleRequestModalBS = new bootstrap.Modal(rescheduleRequestModal)


previewRequestModal.addEventListener('hidden.bs.modal', function () {
    requestPreviewed = null;
})

function previewRequests(id) {

    console.log(id)

    $.ajax({
        type: "GET",
        url: "submits/certificationsRequests.php?action=getRequest",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function (param) {
            showLoadingScreen();
        },
        success: function (request) {
            setTimeout(() => {




                $('#namePreview').html(request.name);
                $('#addressPreview').html(request.address);
                $('#contactNumberPreview').html(request.contactNumber);
                $('#emailPreview').html(request.email);
                $('#dateTimeRequestedPreview').html(formatDateTime(request.dateTimeRequested));
                
                let certificates = "";

                $.each(request.certificate, function (index, certificate) { 
                    if (certificates == "") {
                        certificates += certificate;
                    } else {
                        certificates += ", " + certificate;
                    }
                });

                $('#certificatePreview').html(certificates);

                $('#descriptionPreview').html(request.description)

                $('#previewRequestModal').find('#dateTimeAppointedRow').remove();
                $('#previewRequestModal').find('.update_status_btn').remove();


                if (request.status == 0) {
                    let approveBtn = '<button class="btn btn-success update_status_btn" onclick="approveRequests('+request.id+')"><i class="fas fa-thumbs-up"></i></button>'; 
                    let declineBtn = '<button class="btn btn-danger update_status_btn" onclick="declineRequests('+request.id+')"><i class="fas fa-thumbs-down"></i></button>'; 


                    $('#previewRequestModal .modal-footer').prepend(declineBtn);
                    $('#previewRequestModal .modal-footer').prepend(approveBtn);

                } else  if (request.status == 1) {

                    let dateTimeAppointedRow = '<tr id="dateTimeAppointedRow"><td>Schedule of Appointment</td><td>:</td><td>'+formatDateTime(request.dateTimeAppointed)+'</td></tr>';

                    let rescheduleBtn = '<button class="btn btn-info update_status_btn" onclick="rescheduleRequests('+request.id+')"><i class="fas fa-calendar-alt"></i></button>';

                    $('#previewRequestModal .modal-footer').prepend(rescheduleBtn);

                    $('#reqPreviewTable').append(dateTimeAppointedRow);

                } else if (request.status == 2) {

                    let deleteBtn = '<button class="btn btn-danger update_status_btn" onclick="deleteRequests('+request.id+')"><i class="fas fa-trash-alt"></i></button>';
                    
                    $('#previewRequestModal .modal-footer').prepend(deleteBtn);

                }

                requestPreviewed = request;
                previewRequestModalBS.show();


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

approveRequestModal.addEventListener('hidden.bs.modal', function () {
    $('#dateTimeAppointed').val("")
})

function rescheduleRequests(id) {
    rescheduleRequestModalBS.show()
}

function approveRequests(id) {
    $.ajax({
        type:'GET',
        url:'submits/approve_requests.php',
        data:{
            request_id:id
        },
        dataType:'html'
    })
    window.location.reload();
}

function declineRequests(id) {
    let data = {
        id : requestPreviewed.id,
        dateTimeAppointed : $('#dateTimeAppointed').val(),
        status: 2
    }

    updateStatus(data)
    window.location.reload();
}

$('#updateReqStatusBtn').click(function (e) { 

    e.preventDefault();

    let data = {
        id : requestPreviewed.id,
        dateTimeAppointed : $('#dateTimeAppointed').val(),
        status: 1
    }

    updateStatus(data);
});

function updateStatus(data) {
    $.ajax({
        type: "POST",
        url: "submits/certificationsRequests.php?action=updateRequestStatus",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if(response.status == 3) {
                    approveRequestModalBS.hide()
                    previewRequestModalBS.hide()
                    updateRequestNotification()
                    getRequests(1)
                }
                
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG);
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
}



$('#rescheduleReqStatusBtn').click(function (e) { 
    e.preventDefault();


    let data = {
        id : requestPreviewed.id,
        dateTimeAppointed : $('#dateTimeReAppointed').val()
    }



    $.ajax({
        type: "POST",
        url: "submits/certificationsRequests.php?action=rescheduleRequest",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg);
                if(response.status == 3) {
                    rescheduleRequestModalBS.hide()
                    previewRequestModalBS.hide()
                    getRequests(1)
                }
                
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG);
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
});


function deleteRequests(id) {
    $.ajax({
        type: "POST",
        url: "submits/certificationsRequests.php?action=deleteRequest",
        data: {
            'id' : id,
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg);
                if(response.status == 3) {
                    previewRequestModalBS.hide()
                    getRequests(1)
                }
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG);
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
}

