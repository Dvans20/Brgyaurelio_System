


let currentPage = 1;



const violatorsFormModal = document.getElementById('violatorsFormModal')
const violatorsFormModalBS = new bootstrap.Modal(violatorsFormModal)
const violatorsForm = document.getElementById('violatorsForm')

const selectCitizenModal = document.getElementById('selectCitizenModal')
const selectCitizenModalBS = new bootstrap.Modal(selectCitizenModal)

let selectedCitizen;


selectCitizenModal.addEventListener('hidden.bs.modal', function () {
    $('#citizensList').html("");
    $('#searchCitizen').val("");
})
selectCitizenModal.addEventListener('shown.bs.modal', () => {
    getCitizens()
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

    let radio = '<input type="radio" name="selected_citizen" id="citizen'+citizen.id+'" class="form-check-input" value="'+citizen.id+'|'+citizen.name+'">';

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

        $('#citizenId').val(id);
        $('#citizenName').text(name);

        selectCitizenModalBS.hide();

    }


});





violatorsFormModal.addEventListener('hidden.bs.modal', () => {
    violatorsForm.reset()
    $('#violationDescription').html("");
    $('#citizenId').val("");
    $('#citizenName').text("Citizen's Name");
})

$('#violationId').change(function (e) { 
    
    $('#violationDescription').html("");

    let selectedId = $(this).val();

    if ($(this).val() == "") {
        $('#violationDescription').html("");
    } else {
        $.each(violationsArr, function (index, violation) { 
            if (violation.id == selectedId) {
                $('#violationDescription').append(violation.description)
                $('#violationDescription').append('<br><br>')

                $('#violationDescription').append('<div>Penalty: </div>')

                $('#violationDescription').append('<ul>')

                if (violation.payableAmount != 0) {
                    $('#violationDescription').append('<li>'+formatToPHP(violation.payableAmount)+'</li>')
                }

                if (!(violation.service == null || violation.service == "")) {
                    $('#violationDescription').append('<li>'+violation.service+'</li>')
                }

                $('#violationDescription').append('</ul>')

            }
        });
    }
    
});


$('#violatorsForm').submit(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "submits/violatorsRequests.php?action=saveViolator",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if (response.status === 3) {
                    violatorsFormModalBS.hide()
                    getViolators(1);
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

$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getViolators(1)
});
$('#violationFilter').change(function (e) { 
    e.preventDefault();
    getViolators(1)
});
let violatoRow = function (index, violator) {

    let prevBtn = '<button class="btn btn-sm text-info" onclick="previewViolatorInfo('+violator.id+')">' + 
        '<span class="fas fa-eye"></span>' +
    '</button>';
    let editBtn = '<button class="btn btn-sm text-primary" onclick="editViolatorStatus('+violator.id+')">' + 
        '<span class="fas fa-edit"></span>' +
    '</button>';
    let deleteBtn = '<button class="btn btn-sm text-danger" onclick="deleteViolator('+violator.id+')">' + 
        '<span class="fas fa-trash-alt"></span>' +
    '</button>';


    let statusCol = "";


    let noCol = '<td class="text-center text-nowrap">'+(index + 1)+'</td>';
    let purokCol = '<td class="text-start text-nowrap">'+violator.citizen.purok+'</td>';
    let nameCol = '<td class="text-start text-nowrap">'+violator.citizen.name+'</td>';
    let violationCol = '<td class="text-start text-nowrap">'+violator.violation.violation+'</td>';

    let btnCol = "";

    if (violator.status != 3 && violator.status != 2) {
        btnCol = '<td class="text-end text-nowrap">'+editBtn+prevBtn+'</td>';
    } else {
        btnCol = '<td class="text-end text-nowrap">'+prevBtn+'</td>';
    }
    

  
    if (violator.status == 0) {
        statusCol = '<td class="text-center text-muted small text-nowrap">No actions taken yet</td>';
    } else if (violator.status == 3) {
        statusCol = '<td class="text-center text-success small text-nowrap">Violation Served.</td>';
    } else if (violator.status == 1) {
        statusCol = '<td class="text-center text-info small text-nowrap">Service Required.</td>';
    } else if (violator.status == 2) {
        statusCol = '<td class="text-center text-info small text-nowrap">Missing Payment.</td>';
    }


    let row = '' +
    '<tr class="slide_in">' +
        noCol + purokCol + nameCol + violationCol + statusCol + btnCol +
    '</tr>';

    return row;

}
function getViolators(page) { 

    let data = {
        'page' : page,
        'limit' : LIMIT,
        'search' : $('#search').val(),
        'violation' : $('#violationFilter').val()
    }

    
    $.ajax({
        type: "GET",
        url: "submits/violatorsRequests.php?action=getViolators",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#violatorsList', 6)
            $('#violatorsLinks').html("");
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response);
                if (response.violators == null) {
                    displayTableMsg('violatorsList', 6, ERRMSG);
                } else if (response.violators.length <= 0) {
                    displayTableMsg('violatorsList', 6, "No Violators Found");
                } else {
                    $('#violatorsList').html("");
                    $.each(response.violators, function (index, violator) { 
                        $('#violatorsList').append(violatoRow(index, violator));
                    });
                    currentPage = page
                    displayPagination("violatorsLinks", page, "getViolators", response.totalPages)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('violatorsList', 6, ERRMSG);
            }, timeout);
        }
    });

}

getViolators(currentPage)





const violatorsPreviewModal = document.getElementById('violatorsPreviewModal')
const violatorsPreviewModalBS = new bootstrap.Modal(violatorsPreviewModal)

const violatorsStatusFormModal = document.getElementById('violatorsStatusFormModal');
const violatorsStatusFormModalBS = new bootstrap.Modal(violatorsStatusFormModal)
const violatorsStatusForm = document.getElementById(`violatorsStatusForm`);

function previewViolatorInfo(id) {
    $.ajax({
        type: "GET",
        url: "submits/violatorsRequests.php?action=getViolator",
        data: {
            'id': id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (violator) {
            setTimeout(() => {
                console.log(violator);

                $('#namePreview').text(violator.citizen.name);
                $('#purokPreview').text(violator.citizen.purok);
                $('#violationPreview').text(violator.violation.violation);


                let penalties = "";


                if (violator.violation.payableAmount != 0) {
                    penalties += formatToPHP(violator.violation.payableAmount)
                }

                if (!(violator.violation.service == "" || violator.violation.service == null)) {
                    if (penalties == "") {
                        penalties += violator.violation.service;
                    } else {
                        if (violator.violation.penaltyType == 3) {
                            penalties += " or "
                        } else if (violator.violation.penaltyType == 4) {
                            penalties += " and "
                        }
                        penalties += violator.violation.service;
                    }
                }


                $('#penaltyPreview').html(penalties);

                $('#dateOccuredPreview').text(formatDate(violator.dateOccured));
                $('#descriptionPreview').html(violator.violation.description);

                violatorsPreviewModalBS.show()
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

violatorsStatusFormModal.addEventListener('hidden.bs.modal', () => {
    violatorsStatusForm.reset();
    $('#statusViolatorId').val("")
})
function editViolatorStatus(id) {
    $.ajax({
        type: "GET",
        url: "submits/violatorsRequests.php?action=getViolator",
        data: {
            'id': id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (violator) {
            setTimeout(() => {
                // console.log(violator);

                if (violator.violation.penaltyType == 1) {
                    displayMsg(2, "Unable to update the status of payment only type of violation.")
                } else {
                    console.log(violator.violation.penaltyType)

                    if (violator.violation.penaltyType == 2) {
                        $('#status2').val(3)
                    } else if (violator.violation.penaltyType == 3) {
                        $('#status2').val(3)
                    } else if (violator.violation.penaltyType == 4 && violator.status == 0) {
                        $('#status2').val(2)
                    } else if (violator.violation.penaltyType == 4 && violator.status == 1) {
                        $('#status2').val(3)
                    }

                    $('#statusViolatorId').val(violator.id);

                    violatorsStatusFormModalBS.show()
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
$('#violatorsStatusForm').submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/violatorsRequests.php?action=updateStatusViolator",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if (response.status === 3) {
                    violatorsStatusFormModalBS.hide()
                    getViolators(1);
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

function deleteViolator(id) {

}


