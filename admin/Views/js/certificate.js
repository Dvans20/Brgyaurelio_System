

let selectCitizenModal = document.getElementById('selectCitizenModal')
let selectCitizenModalBS = new bootstrap.Modal(selectCitizenModal)

let selectBusModal = document.getElementById('selectBusModal')
let selectBusModalBS = new bootstrap.Modal(selectBusModal);

let citizenSelected = 0;
let citizenSelected2 = 0;

let currentPage = 0;

selectCitizenModal.addEventListener('hidden.bs.modal', function () { 
    $('#searchCitizen').val("");
})

selectCitizenModal.addEventListener('shown.bs.modal', function () { 
    $('#searchCitizen').val("");
    $('#isSecondPerson').val("");
})

$('#certificate').change(function (e) { 
    e.preventDefault();


    $.each($('.cert_paper'), function (index, val) { 
        if (!$(val).hasClass('d-none')) {
            $(val).addClass('d-none')
        }
    }); 

    $.each($('.cert_form'), function (index, val) { 
        if (!$(val).hasClass('d-none')) {
            $(val).addClass('d-none')
        }
    }); 

    if ($(this).val() != "") {
        $('#' + $(this).val()).removeClass('d-none')
        $('#' + $(this).val() + "Form").removeClass('d-none')
    }
    citizenSelected = 0
    citizenSelected2 = 0
});


$('#openSelectCitizenModalBtn').click(function (e) { 
    e.preventDefault();

    
    selectCitizenModalBS.show()

    getCitizens(1)  
    
});
$('#openSelectCitizenModalBtn2').click(function (e) { 
    e.preventDefault();
    selectCitizenModalBS.show()

    getCitizens(1)  
});
$('#openSelectSecondCitizenModalBtn2').click(function (e) { 
    e.preventDefault();

    if ($('#householdId').val() == "") {
        displayMsg(2, "Please Select a citizen first.");
    } else {
        selectCitizenModalBS.show()

        $.ajax({
            type: "GET",
            url: "submits/certificatesRequests.php?action=getCitizensByHouseholdId",
            data: {
                'search': $('#searchCitizen').val(),
                'houseHoldId': $('#householdId').val()
            },
            dataType: "JSON",
            beforeSend: function () {
                showLoadingTableContent('#citizensList', 11)
                $('#citizensLinks').html("");
            },
            success: function (response) {
                setTimeout(() => {
                    $('#citizensList').html("");
                    $('#isSecondPerson').val(1);
                    if (response.citizens == null) {
                        displayTableMsg('citizensList', 11, ERRMSG)
                    } else if (response.citizens.length <= 0) {
                        displayTableMsg('citizensList', 11, "No Citizens Found")
                    } else {
                        $.each(response.citizens, function (index, citizen) { 
                             $('#citizensList').append(citizensRow(index, citizen));
                        });
                    }
                }, timeout);
            },
            error: function (err) { 
                setTimeout(() => {
                    console.log(err)
                    displayTableMsg('citizensList', 11, ERRMSG)
                }, timeout);
            }
        }); 
    }

   

     
});


$('#second_person').click(function (e) { 
    
    if ($(this).is(':checked')) {
        
        $('#certification2ndNameDisplay').val($('#certification1stNameDisplay').val());
    } else {
        $('#certification2ndNameDisplay').val("");
    }
    
});
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

    let radio = '<input type="radio" name="selected_citizen" id="citizen'+citizen.id+'" class="form-check-input" value="'+citizen.id+'">';

    let radioCol = '<td class="text-center">'+radio+'</td>';
    let yearCol = '<td class="text-center">'+citizen.year+'</td>';
    let qtrCol = '<td class="text-center text-nowrap">'+citizen.qtr+'</td>';
    let purokCol = '<td class="text-start text-nowrap">'+citizen.purok+'</td>';
    let lastNameCol = '<td class="text-start text-nowrap">'+citizen.lastName+'</td>';
    let firstNameCol = '<td class="text-start text-nowrap">'+citizen.firstName+'</td>';
    let middleNameCol = '<td class="text-start text-nowrap">'+citizen.middleName+'</td>';
    let extNameCol = '<td class="text-start text-nowrap">'+citizen.extName+'</td>';
    let bDateCol = '<td class="text-start text-nowrap">'+formatDate(citizen.birthDate)+'</td>';
    let ageCol = '<td class="text-center text-nowrap">'+calculateAge(citizen.birthDate)+'</td>';
    let sexCol = '<td class="text-center text-nowrap">'+sex+'</td>';

    let row = '<tr class="slide_in">'+radioCol+yearCol+qtrCol+purokCol+lastNameCol+firstNameCol+middleNameCol+extNameCol+bDateCol+ageCol+sexCol+'</tr>';

    return row;
}


$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getCitizens(1)
});
function fetchCitizens(page) {
    getCitizens(page)
}
function getCitizens(page) {
    $.ajax({
        type: "GET",
        url: "submits/certificatesRequests.php?action=getCitizens",
        data: {
            'search': $('#searchCitizen').val(),
            'limit': LIMIT,
            'page': 1
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#citizensList', 11)
            $('#citizensLinks').html("");
        },
        success: function (response) {
            setTimeout(() => {
                $('#citizensList').html("");

                if (response.citizens == null) {
                    displayTableMsg('citizensList', 11, ERRMSG)
                } else if (response.citizens.length <= 0) {
                    displayTableMsg('citizensList', 11, "No Citizens Found")
                } else {
                    currentPage = page
                    $.each(response.citizens, function (index, citizen) { 
                         $('#citizensList').append(citizensRow(index, citizen));
                    });
                }
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayTableMsg('citizensList', 11, ERRMSG)
            }, timeout);
        }
    });
}

$('#selectCitizenBtn').click(function (e) { 
    e.preventDefault();

    let id = $('input[name="selected_citizen"]:checked');

    if (id.length == 0) {
        displayMsg(2, "Please select a citizen");
    } else {

        console.log()
        
        $.ajax({
            type: "GET",
            url: "submits/certificatesRequests.php?action=getCitizen",
            data: {
                'id' : id.val()
            },
            dataType: "JSON",
            beforeSend: function () {
                selectCitizenModalBS.hide();
                showLoadingScreen();
            },
            success: function (citizen) {
                setTimeout(() => {

                    if ($('#isSecondPerson').val() == "") {

                        if ($('#certificate').val() == "brgyClearance") {
                            setupBrgyClearanceCert(citizen)
                        } else if ($('#certificate').val() == "residencyCertificate") {
                            $('#certification1stNameDisplay').val(citizen.name)

                            if ($('#second_person').is(':checked')) {
                                $('#certification2ndNameDisplay').val(citizen.name)
                            } else {
                                $('#certification2ndNameDisplay').val("")
                            }
                            $('#householdId').val(citizen.houseHoldId)

                            if (citizen.pwdId == 0) {
                                if ($('#certification_pwd').is(':checked')) {
                                    $('#certification_pwd').prop('checked', false);
                                }
                                $('#certification_pwd').prop('disabled', true)
                            } else {
                                $('#certification_pwd').prop('disabled', false)
                            }

                            if (citizen.soloParent == 0) {
                                if ($('#certification_solo_parent').is(':checked')) {
                                    $('#certification_solo_parent').prop('checked', false)
                                }
                                $('#certification_solo_parent').prop('disabled', true)
                            } else {
                                $('#certification_solo_parent').prop('disabled', false)
                            }
                        }
                        citizenSelected = citizen;
                        // console.log("1")


                    } else {
                        citizenSelected2 = citizen

                        $('#certification2ndNameDisplay').val(citizen.name);
                        $('#second_person').prop('checked', false);

                        // if (citizen.pwdId == 0) {
                        //     if ($('#certification_pwd').is(':checked')) {
                        //         $('#certification_pwd').prop('checked', false);
                        //     }
                        //     $('#certification_pwd').prop('disabled', true)
                        // } else {
                        //     $('#certification_pwd').prop('disabled', false)
                        // }

                        // if (citizen.soloParent == 0) {
                        //     if ($('#certification_solo_parent').is(':checked')) {
                        //         $('#certification_solo_parent').prop('checked', false)
                        //     }
                        //     $('#certification_solo_parent').prop('disabled', true)
                        // } else {
                        //     $('#certification_solo_parent').prop('disabled', false)
                        // }

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
});






function setupBrgyClearanceCert(citizen) {

    if (citizen.sex == 1) {
        citizen.sex = "Male";
    } else {
        citizen.sex = "Female";
    }

    $('#brgyClearanceApplicantName').text(": "+citizen.name);
    $('#brgyClearanceApplicantCicilStatus').text(": "+citizen.civilStatus);
    $('#brgyClearanceApplicantBirthDate').text(": "+formatDate(citizen.birthDate));
    $('#brgyClearanceApplicantSex').text(": "+citizen.sex);
    $('#brgyClearanceApplicantBirthPlace').text(": "+citizen.birthPlace);
    $('#brgyClearanceApplicantPresentAddress').text(": " + ucwords(citizen.purok) + " " + ucwords(WEB.brgy) + ", San Jose, Dinagat Islands");
    // console.log(WEB)
    $('#brgyClearanceApplicantNameContent').text(citizen.name);
    $('#brgyClearanceApplicantPurokContent').text(ucwords(citizen.purok));
    $('#brgyClearanceApplicantNameSign').text(citizen.name);
}

function setupBrgyCertification() {

    $('#brgyResidencyApplicantNameContent').text(citizenSelected.name)
    $('#brgyResidencyApplicantPurokContent').text(citizenSelected.purok)

    if (!$('#second_person').is(':checked')) {
        if ($('#third_person').is(':checked')) {
            $('#brgyResidencyApplicantNameContent2').text(citizenSelected.name)
            $('#brgyResidencyApplicantNameContent3').text(citizenSelected2.name)
        } else {
            $('#brgyResidencyApplicantNameContent2').text(citizenSelected2.name)
            $('#brgyResidencyApplicantNameContent3').text(citizenSelected.name)
        }
    } else {
        $('#brgyResidencyApplicantNameContent2').text(citizenSelected.name)
        $('#brgyResidencyApplicantNameContent3').text(citizenSelected.name)
    }

    

    if ($('#certification_custom').is(':checked')) {
        $('#brgyResidencyDescription').text($('#certification_input_custom').val())
    } else {

        let citation ="";

        let issppwd = 0;

        if (citizenSelected2 == 0) {
            citizenSelected2 = citizenSelected;
        }

        let age = calculateAge(citizenSelected2.birthDate)

        if (!$('#third_person').is(':checked') && !$('#second_person').is(':checked')) {
            if (age >= "18") {
                citation += "legal age, a resident of " + (citizenSelected2.purok) + " " + ucwords(WEB.brgy) + " San Jose, Dinagat Islands ";
            } else {
                citation += "a resident of " + (citizenSelected2.purok) + " " + ucwords(WEB.brgy) + " San Jose, Dinagat Islands ";
            }

            issppwd = 1;
        }

        

        if ($('#certification_solo_parent').is(':checked')) {
            if (issppwd == 0) {
                citation += "is a solo parent";
            } else {
                citation += ", a solo parent";
            }
            
            issppwd = 1;
        }

        if ($('#certification_pwd').is(':checked')) {
            if (issppwd == 0) {
                citation += "is a person with disability (PWD)";
            } else {
                citation += ", a person with disability (PWD)";
            }
            issppwd = 1;
        }

        let income = citizenSelected.monthlyIncome;

        let incomeNum = formatToPHP(citizenSelected.monthlyIncome);

        if ($('#certification_monthly_income').is(':checked')) {
            if (issppwd == 0) {
                citation += "has an income of " + numberToWords(income) + " pesos a month (" + incomeNum + ") ";
            } else {
                citation += ", and has an income of " + numberToWords(income) + " pesos a month (" + incomeNum + ") ";
            }
        }


        citation = citation.trim();

        citation += ".";


        $('#brgyResidencyDescription').text(citation)

        $('#brgyResidencyApplicantPurpose').text($('#certificationPurpose').val())
    }
}

$('#updateBrgyClearanceInfo').click(function (e) { 
    e.preventDefault();
    $('#brgyClearanceApplicantPurpose').text(": "+$('#brgyClearancePurpose').val())
    $('#brgyClearanceApplicantYearFromContent').text($('#brgyClearanceCoveringYear').val())
    $('#brgyClearanceCertificateCTCNO').html($('#brgyClearanceCTCNo').val())
    $('#brgyClearanceCertificateIssuedOn').html(formatDate($('#brgyClearanceIssuedOn').val()))
    $('#brgyClearanceCertificateIssuedAt').html($('#brgyClearanceIssuedAt').val())
    $('#brgyClearanceCertificateORNot').html($('#brgyClearanceORNo').val())
});

$('#updateCertificationBtn').click(function (e) { 
    e.preventDefault();

    showLoadingScreen()

    setTimeout(() => {
        hideLoadingScreen()
        if (citizenSelected == 0) {
            displayMsg(2, "Please Select a Citizen");
        } else {
            setupBrgyCertification()
        }
    }, timeout + 1000);
});



$('#certification_custom').click(function (e) { 

    if ($(this).is(':checked')) {
        $('input[name="certification_check_input"]:checked').prop('checked', false);
        $('input[name="certification_check_input"]').prop('disabled', true);
        $('#certification_input_custom_cont').removeClass('d-none')
    } else {
        $('input[name="certification_check_input"]').prop('disabled', false);
        $('#certification_input_custom_cont').addClass('d-none')

        if  (citizenSelected != 0) {
            if (citizenSelected.pwdId == 0) {
                if ($('#certification_pwd').is(':checked')) {
                    $('#certification_pwd').prop('checked', false);
                }
                $('#certification_pwd').prop('disabled', true)
            } else {
                $('#certification_pwd').prop('disabled', false)
            }
    
            if (citizenSelected.soloParent == 0) {
                if ($('#certification_solo_parent').is(':checked')) {
                    $('#certification_solo_parent').prop('checked', false)
                }
                $('#certification_solo_parent').prop('disabled', true)
            } else {
                $('#certification_solo_parent').prop('disabled', false)
            }
        }

        
    }
    
});




// brgy bus clearance
let selectedBusOwner = null;
$('#selectBusOwnerBtn').click(function (e) { 
    e.preventDefault();

    
    getBusinessOwners()
    selectBusModalBS.show()
});
$('#searchBusForm').submit(function (e) { 
    e.preventDefault();
    getBusinessOwners();
});
let busOwnerRow = function (index, busOwner) {

    if (busOwner.qtr == 2) {
        busOwner.qtr = "1<sup>st</sup> qtr - 2<sup>nd</sup> qtr";
    } else if (busOwner.qtr == 4) {
        busOwner.qtr = "3<sup>rd</sup> qtr - 4<sup>th</sup> qtr";
    }

    let radio = '<input type="radio" name="selected_bus_owner" id="bus_owner'+busOwner.id+'" class="form-check-input" value="'+busOwner.id+'">';

    let radioCol = '<td class="text-center">'+radio+'</td>';
    let yearCol = '<td class="text-center">'+busOwner.year+'</td>';
    let qtrCol = '<td class="text-center">'+busOwner.qtr+'</td>';
    let purokCol = '<td class="text-center">'+busOwner.purok+'</td>';
    let nameCol = '<td class="text-center">'+busOwner.onwnersName+'</td>';
    let busNameCol = '<td class="text-center">'+busOwner.businessName+'</td>';

    let row = '' +
    '<tr class="slide_in">' +
        radioCol + yearCol + qtrCol + purokCol + nameCol + busNameCol +
    '</tr>'

    return row;
}
function getBusinessOwners() {
    $.ajax({
        type: "GET",
        url: "submits/certificatesRequests.php?action=getBusinessOwners",
        data: {
            'page': 1,
            'limit': LIMIT,
            'search': $('#searchBus').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#busList', 6)
        },
        success: function (response) {
            setTimeout(() => {
                if (response == null) {
                    displayTableMsg('busList', 6, ERRMSG)
                } else if (response.length <= 0) {
                    displayTableMsg('busList', 6, "No Business Owners Found.")
                } else {
                    $('#busList').html("")
                    $.each(response, function (index, busOwner) { 
                         $('#busList').append(busOwnerRow(index, busOwner));
                    });
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('busList', 6, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }
    });
}
$('#selectBusBtn').click(function (e) { 
    e.preventDefault();

    let id = 0;

    let checkedBus = $('input[name="selected_bus_owner"]:checked')
    
    if (checkedBus.length <= 0) {
        id = 0
    } else {
        id = $('input[name="selected_bus_owner"]:checked').val();
    }
 
    $.ajax({
        type: "GET",
        url: "submits/certificatesRequests.php?action=getBusinessOwner",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (rbbo) {
            setTimeout(() => {
                selectedBusOwner = rbbo
                citizenSelected = rbbo
                $('#brgyBusClearanceOwnersName').val(rbbo.onwnersName)
                $('#brgyBusClearanceBusinessName').val(rbbo.businessName)
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                selectedBusOwner = null
                console.log(err)
                displayMsg(1, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
                selectBusModalBS.hide();
            }, timeout);
        }
    });
});
$('#genBrgyBusCertInfoBtn').click(function (e) { 
    e.preventDefault();
    

    showLoadingScreen()

    $('#brgyBusClearanceCertificateApplicantName').text(selectedBusOwner.onwnersName);
    $('#brgyBusClearanceCertificateApplicantResidenceAddress').text(selectedBusOwner.residenceAddress);
    $('#brgyBusClearanceCertificateApplicantBusinessName').text(selectedBusOwner.businessName);

    let busAddress = selectedBusOwner.purok + " " + WEB.brgy + ", San Jose, Dinagat Islands";

    $('#brgyBusClearanceCertificateApplicantBusinessAddress').text(ucwords(busAddress));

    $('#brgyBusClearanceCertificateCTCNO').text($('#brgyBusClearanceCTCNo').val());
    $('#brgyBusClearanceCertificateORNo').text($('#brgyBusClearanceORNo').val());
    $('#brgyBusClearanceCertificateIssuedOn').text(formatDate($('#brgyBusClearanceIssuedOn').val()));
    $('#brgyBusClearanceCertificateIssuedAt').text($('#brgyBusClearanceIssuedAt').val());

    setTimeout(() => {
        hideLoadingScreen();
    }, timeout + timeout);
});



// print
$('#printCertificateBtn').click(function (e) { 
    e.preventDefault();


    if ($('#certificate').val() == "") {
        displayMsg(4, "Please select a certificate");
    } else if (citizenSelected == 0) {
        displayMsg(4, "Please select a citizen.");
    } else {

        let url = 'printCertificate';

        if ($('#certificate').val() == "brgyClearance") {

            url += '?certificate=' + $('#certificate').val() +
            '&purpose=' + $('#brgyClearancePurpose').val() +
            '&citizenId=' + citizenSelected.id +
            '&coveringYear=' + $('#brgyClearanceCoveringYear').val() +
            '&ctcNo=' + $('#brgyClearanceCTCNo').val() +
            '&issuedOn=' + $('#brgyClearanceIssuedOn').val() +
            '&issuedAt=' + $('#brgyClearanceIssuedAt').val() +
            '&orNo=' + $('#brgyClearanceORNo').val();

        } else if ($('#certificate').val() == "residencyCertificate") {

            if (citizenSelected2 == 0) {
                citizenSelected2 = citizenSelected;
            }

            let thirdId = 0

            if ($('#third_person').is(':checked')) {
                thirdId = 1
            } else {
                thirdId = 2
            }

            url += '?certificate=' + $('#certificate').val() +
            '&purpose=' + $('#certificationPurpose').val() +
            '&citizenId=' + citizenSelected.id +
            '&citizen2Id=' + citizenSelected2.id +
            '&purpose=' + $('#certificationPurpose').val() +
            '&citaition=' + $('#brgyResidencyDescription').text() +
            '&thirdId=' + thirdId

        } else if ($('#certificate').val() == "brgyBusClearanceCertificate"){


            url += '?certificate=' + $('#certificate').val() +
            '&busId=' + selectedBusOwner.id +
            '&ctcNo=' + $('#brgyBusClearanceCTCNo').val() +
            '&issuedOn=' + $('#brgyBusClearanceIssuedOn').val() +
            '&issuedAt=' + $('#brgyBusClearanceIssuedAt').val() +
            '&orNo=' + $('#brgyBusClearanceORNo').val();

        }

        


        window.open(url, "_blank", 'width=920,height=520');
    }
    
    
});
