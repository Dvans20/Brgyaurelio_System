

let currentPage = 1


const complaintsFormModal = document.getElementById('complaintsFormModal')
const complaintsFormModalBS = new bootstrap.Modal(complaintsFormModal)
const complaintsForm = document.getElementById('complaintsForm');


let complainantsLength = 0
let currentSelectComplainantLength = 0

let defendantsLength = 0
let currentSelectDefendantLength = 0

let dc = 0;

complaintsFormModal.addEventListener('hidden.bs.modal', function () {
    complaintsForm.reset()
    $('#complainantsList').html("")
    $('#defendantsList').html("")

    complainantsLength = 0
    currentSelectComplainantLength 
    defendantsLength = 0
    currentSelectDefendantLength 
    dc = 0;
})

// add complainant
$('#addComplainantBtn').click(function (e) { 
    e.preventDefault();
    
    $('#complainantsList').append(

        '<tr id="complainant'+complainantsLength+'" class="complainantsRow slide_in">' +
            '<td>' +
               ' <input type="text" class="form-control complainantName" id="complainantName'+complainantsLength+'" placeholder="Complainant\'s Name">' +
               ' <input type="text" class="d-none complainantId" id="complainantId'+complainantsLength+'" value="0">' +
           '</td>' +
            '<td>' +
                '<input type="text" class="form-control complainantAddress" id="complainantAddress'+complainantsLength+'" placeholder="Complainant\'s Address">' +
            '</td>' +
            '<td class="text-end">' +
                '<button class="btn text-primary" type="button" onclick="selectCitizen('+complainantsLength+')">' +
                    'Search Citizen' +
                '</button>' +
                '<button class="btn text-danger" type="button" onclick="removeCitizen('+complainantsLength+')">' +
                    '<span class="fas fa-trash-alt"></span>' +
                '</button>' +
            '</td>' +
        '</tr>'

        

    );

    complainantsLength += 1;
});
//  remove complainant
function removeCitizen(num) {
    $('#complainant' + num).remove()
}



const selectCitizenModal = document.getElementById('selectCitizenModal')
const selectCitizenModalBS = new bootstrap.Modal(selectCitizenModal)
selectCitizenModal.addEventListener('hidden.bs.modal', function () {
    currentSelectComplainantLength = 0;
    dc = 0;
    $('#citizensList').html("");
    $('#searchCitizen').val("");
})
selectCitizenModal.addEventListener('shown.bs.modal', function () {
    getCitizens();
})
let citizensRow = function(index, citizen) {
    let sex;

    if (citizen.sex == 1) {
        sex = "Male";
    } else {
        sex = "Female";
    }

    if (citizen.qtr == 2) {
        citizen.qtr = "1<sup>st</sup> qtr - 2<sup>nd</sup> qtr";
    } else if (citizen.qtr == 4) {
        citizen.qtr = "3<sup>rd</sup> qtr - 4<sup>th</sup> qtr";
    }

    let radio = '<input type="radio" name="selected_citizen" id="citizen'+citizen.id+'" class="form-check-input" value="'+citizen.id+'|'+citizen.name+'|'+citizen.purok+'">';

    let radioCol = '<td class="text-center">'+radio+'</td>';
    // let yearCol = '<td class="text-center">'+citizen.year+'</td>';
    // let qtrCol = '<td class="text-center text-nowrap">'+citizen.qtr+'</td>';
    let purokCol = '<td class="text-start text-nowrap">'+citizen.purok+'</td>';
    let lastNameCol = '<td class="text-start text-nowrap">'+citizen.lastName+'</td>';
    let firstNameCol = '<td class="text-start text-nowrap">'+citizen.firstName+'</td>';
    let middleNameCol = '<td class="text-start text-nowrap">'+citizen.middleName+'</td>';
    let extNameCol = '<td class="text-start text-nowrap">'+citizen.extName+'</td>';
    let bDateCol = '<td class="text-start text-nowrap">'+formatDate(citizen.birthDate)+'</td>';
    let ageCol = '<td class="text-center text-nowrap">'+calculateAge(citizen.birthDate)+'</td>';
    let sexCol = '<td class="text-center text-nowrap">'+sex+'</td>';

    let row = '<tr class="slide_in">'+radioCol+purokCol+lastNameCol+firstNameCol+middleNameCol+extNameCol+bDateCol+ageCol+sexCol+'</tr>';

    return row;
}
$('#searchCitizenForm').submit(function (e) { 
    e.preventDefault();
    
    getCitizens()
});
function getCitizens() {
    let data = {
        'search' : $('#searchCitizen').val(),
        'page' : 1,
        'limit': LIMIT
    }

    $.ajax({
        type: "GET",
        url: "submits/certificatesRequests.php?action=getCitizens",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#citizensList', 9)
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                if (response.citizens == null) {
                    displayTableMsg('citizensList', 9, ERRMSG)
                } else if (response.citizens.length <= 0) {
                    displayTableMsg('citizensList', 9, "No Citizens Found.");
                } else {
                    $('#citizensList').html("");
                    $.each(response.citizens, function (index, citizen) { 
                        $('#citizensList').append(citizensRow(index, citizen));
                    });
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('citizensList', 9, ERRMSG)
            }, timeout);
        }
    });
}


function selectCitizen(num) {
    currentSelectComplainantLength = num;
    dc = 1;
    selectCitizenModalBS.show()
}
$('#selectCitizenBtn').click(function (e) { 
    e.preventDefault();

    
    let selectedCitizen = $('input[name="selected_citizen"]:checked');


    if (selectedCitizen.length <= 0) {
        displayMsg(2, "Please select a citizen.");
    } else {
        // displayMsg(2, "Please select a citizen.");

        selectedCitizen = selectedCitizen[0].value;

        let id = selectedCitizen.split('|')[0]
        let name = selectedCitizen.split('|')[1]
        let purok = selectedCitizen.split('|')[2]

        if (dc == 1) {
            $('#complainantId' + currentSelectComplainantLength).val(id)
            $('#complainantName' + currentSelectComplainantLength).val(name)
            $('#complainantAddress' + currentSelectComplainantLength).val(purok + " " + WEB.brgy)
    
            $('#complainantId' + currentSelectComplainantLength).prop('disabled', true)
            $('#complainantName' + currentSelectComplainantLength).prop('disabled', true)
            $('#complainantAddress' + currentSelectComplainantLength).prop('disabled', true)
            
        } else  {
            $('#defendantId' + currentSelectComplainantLength).val(id)
            $('#defendantName' + currentSelectComplainantLength).val(name)
            $('#defendantAddress' + currentSelectComplainantLength).val(purok + " " + WEB.brgy)
    
            $('#defendantId' + currentSelectComplainantLength).prop('disabled', true)
            $('#defendantName' + currentSelectComplainantLength).prop('disabled', true)
            $('#defendantAddress' + currentSelectComplainantLength).prop('disabled', true)
        }

        

        selectCitizenModalBS.hide();

    }

});









// defendant
$('#addDefendantBtn').click(function (e) { 
    e.preventDefault();

    
    $('#defendantsList').append(

        '<tr id="defendants'+defendantsLength+'" class=defendantsRow slide_in">' +
            '<td>' +
               ' <input type="text" class="form-control defendantName" id="defendantName'+defendantsLength+'" placeholder="Defendant\'s Name">' +
               ' <input type="text" class="d-none defendantId" id="defendantId'+defendantsLength+'" value="0">' +
           '</td>' +
            '<td>' +
                '<input type="text" class="form-control defendantAddress" id="defendantAddress'+defendantsLength+'" placeholder="Defendant\'s Address">' +
            '</td>' +
            '<td class="text-end">' +
                '<button class="btn text-primary" type="button" onclick="selectDefCitizen('+defendantsLength+')">' +
                    'Search Citizen' +
                '</button>' +
                '<button class="btn text-danger" type="button" onclick="removeDefCitizen('+defendantsLength+')">' +
                    '<span class="fas fa-trash-alt"></span>' +
                '</button>' +
            '</td>' +
        '</tr>'

        

    );

    defendantsLength += 1;
});

function removeDefCitizen(num) {
    $('#defendants' + num).remove()
}

function selectDefCitizen(num) {
    currentSelectComplainantLength = num;
    dc = 2;
    selectCitizenModalBS.show()
}






// submit Form


$('#complaintsForm').submit(function (e) { 
    e.preventDefault();

    let complainants = [];
    let defendants = [];

    $.each($('#complainantsList .complainantsRow'), function (index, elem) { 
        let complainant = {
            id : $(elem).find('.complainantId').val(),
            name : $(elem).find('.complainantName').val(),
            address : $(elem).find('.complainantAddress').val(),
        }

        if (complainant.name != "" && complainant.address != "") {
            complainants.push(complainant)
        } 

    });

    $.each($('#defendantsList .defendantsRow'), function (index, elem) { 
        let defendant = {
            id : $(elem).find('.defendantId').val(),
            name : $(elem).find('.defendantName').val(),
            address : $(elem).find('.defendantAddress').val(),
        }

        if (defendant.name != "" && defendant.address != "") {
            defendants.push(defendant)
        } 
    });


    let data = {
        id : $('#id').val(),
        complainants : complainants,
        defendants : defendants,
        complaints : $('#complaints').val(),
        dateFiled : $('#dateFiled').val(),
        hearingSchedule : $('#hearingSchedule').val(),
    }

    // console.log(data)

    $.ajax({
        type: "POST",
        url: "submits/complaintsRequests.php?action=newComplaints",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if (response.status == 3) {
                    complaintsFormModalBS.hide();
                    getComplaints(1)
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
                hideLoadingScreen()
            }, timeout);
        }
    });
    
});




















// get complaints

$('input[name="schedule"]').click(function (e) { 

    $('.complaints_btn').removeClass('active')
    
    $('label[for="'+$(this).attr('id')+'"]').addClass('active')

    if ($(this).val() == 2) {
        $('#statusFilterCont').removeClass('d-none')
    } else {
        $('#statusFilter').val("")
        if (!$('#statusFilterCont').hasClass('d-none')) {
            $('#statusFilterCont').addClass('d-none')
        }
    }
    
    getComplaints(1)
});

let complaintRow = function (index, complaint) {

    btns = "";


    let prevBtn = '<button class="btn text-info btn-sm" data-toggle="tooltip" title="Preview Complaint" onclick="previewComplaint('+complaint.id+')"><i class="fas fa-eye"></i></button>';

    let editBtn = '<button class="btn text-primary btn-sm" data-toggle="tooltip" title="Reschedule Hearing" onclick="rescheduleHearing('+complaint.id+', \''+complaint.hearingSchedule+'\')"><i class="fas fa-calendar-alt"></i></button>';

    let editStatBtn = '<button class="btn text-primary btn-sm" data-toggle="tooltip" title="Update Status" onclick="editStatus('+complaint.id+', \''+complaint.status+'\')"><i class="fas fa-edit"></i></button>';

    btns += prevBtn;

    btns += editBtn;

    btns += editStatBtn;

    let noCol = '<td class="text-center">'+(index+1)+'</td>';
    
    let complaintsCol = '<td class="text-start">'+complaint.complaints+'</td>';
    let dateFiledCol = '<td class="text-start">'+formatDate(complaint.dateFiled)+'</td>';
    let scheduleCol = '<td class="text-start">'+formatDateTime(complaint.hearingSchedule)+'</td>';
    let statusCol = '<td class="text-start">'+complaint.status+'</td>';

    
    let btnsCol = '<td class="text-start"><div class="d-flex justify-content-center">'+btns+'</div></td>';


    let row = '' +
    '<tr class="slide_in">' +
        noCol+ complaintsCol + dateFiledCol + scheduleCol + statusCol + btnsCol +
    '</tr>';

    return row;
}

function fetchComplaints(page) {
    getComplaints(page);
}
function getComplaints(page) {

    let data = {
        'status' : $('#statusFilter').val(),
        'search' : $('#search').val(),
        'page' : page,
        'limit' : LIMIT
    }

    $.ajax({
        type: "GET",
        url: "submits/complaintsRequests.php?action=getComplaints",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#complaintsList', 6)
            $('#complaintsLinks').html("");
        },
        success: function (response) {
            setTimeout(() => {
                if (response.complaints == null) {
                    displayTableMsg('complaintsList', 6, ERRMSG)
                } else if (response.complaints.length <= 0) {
                    displayTableMsg('complaintsList', 6, "No Complaints Found.")
                } else {
                    currentPage = page
                    $('#complaintsList').html("")
                    $.each(response.complaints, function (index, complaint) { 
                         $('#complaintsList').append(complaintRow(index, complaint));
                    });
                    displayPagination('complaintsLinks', page, 'fetchComplaints', response.totalPages)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('complaintsList', 6, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }
    });
}

$(document).ready(function(){
    // Initialize all tooltips on page load
    $('[data-toggle="tooltip"]').tooltip();
});


$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getComplaints(1)
});
$('#statusFilter').change(function (e) { 
    e.preventDefault();
    getComplaints(1)
});


// set schedule
 
let setScheduleFormModal = document.getElementById('setScheduleFormModal')
let setScheduleFormModalBS = new bootstrap.Modal(setScheduleFormModal);
let setScheduleForm = document.getElementById('setScheduleForm')

setScheduleFormModal.addEventListener('hidden.bs.modal', function () {
    setScheduleForm.reset()
})

function rescheduleHearing(id, schedule = 0) {
    setScheduleFormModalBS.show();
    $('#idToUpdate').val(id)
    if (schedule != 0) {
        $('#schedule_in').val(schedule)
    }
}

$('#setScheduleForm').submit(function (e) { 
    e.preventDefault();
    
    let data = {
        'id' : $('#idToUpdate').val(),
        'schedule' : $('#schedule_in').val()
    }

    $.ajax({
        type: "POST",
        url: "submits/complaintsRequests.php?action=setScheduleComplaints",
        data: data,
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response);
                displayMsg(response.status, response.msg)
                if (response.status == 3) {
                    getComplaints(1)
                    setScheduleFormModalBS.hide()
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





// update status
let setStatusFormModal = document.getElementById('setStatusFormModal');
let setStatusFormModalBS = new bootstrap.Modal(setStatusFormModal);
let setStatusForm = document.getElementById('setStatusForm')

setStatusFormModal.addEventListener('hidden.bs.modal', function () { 
    setStatusForm.reset();
})

function editStatus(id, status) { 
    setStatusFormModalBS.show();
    $('#idToUpdateStatus').val(id)
    $('#status').val(status);
}

$('#setStatusForm').submit(function (e) { 
    e.preventDefault();

    let data = {
        'id' : $('#idToUpdateStatus').val(),
        'status' : $('#status').val()
    }
    
    $.ajax({
        type: "POST",
        url: "submits/complaintsRequests.php?action=setStatusComplaints",
        data: data,
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response);
                displayMsg(response.status, response.msg)
                if (response.status == 3) {
                    getComplaints(1)
                    setStatusFormModalBS.hide()
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

const complaintsPreviewModal = document.getElementById('complaintsPreviewModal')
const complaintsPreviewModalBS = new bootstrap.Modal(complaintsPreviewModal)

complaintsPreviewModal.addEventListener('hidden.bs.modal', function() {
    $('#defendantsListPreview').html("");
    $('#complainantsListPreview').html("");
})

function previewComplaint(id) {
    $.ajax({
        type: "GET",
        url: "submits/complaintsRequests.php?action=getComplaint",
        data: {
            id : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (complaint) {
            setTimeout(() => {
                console.log(complaint)

                $.each(complaint.complainants, function (index, complainant) { 

                    let complainantRow = ''+
                    '<tr class="slide_in">' +
                        '<td>'+complainant.name+'</td>' +
                        '<td>'+complainant.address+'</td>' +
                    '</tr>'


                    $('#complainantsListPreview').append(complainantRow);
                });

                $.each(complaint.defendants, function (index, defendant) { 

                    let defendantRow = ''+
                    '<tr class="slide_in">' +
                        '<td>'+defendant.name+'</td>' +
                        '<td>'+defendant.address+'</td>' +
                    '</tr>'


                    $('#defendantsListPreview').append(defendantRow);
                });

                $('#complaintsPreview').html(complaint.complaints);
                $('#dateFiledPreview').html(formatDate(complaint.dateFiled));
                $('#hearingSchedulePreview').html(formatDateTime(complaint.hearingSchedule));
                

                complaintsPreviewModalBS.show();
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
                hideLoadingScreen()
            }, timeout);
        }
    });
}



getComplaints(currentPage)