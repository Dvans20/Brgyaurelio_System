

let rbimPreviewModal = document.getElementById('rbimPreviewModal');
let rbimPreviewModalBS = new bootstrap.Modal(rbimPreviewModal);

let declineRBIMUpdateModal = document.getElementById('declineRBIMUpdateModal');
let declineRBIMUpdateModalBS = new bootstrap.Modal(declineRBIMUpdateModal);
let declineRBIMUpdateForm = document.getElementById('declineRBIMUpdateForm')

let householdNoModal = document.getElementById('householdNoModal');
let householdNoModalBS = new bootstrap.Modal(householdNoModal);


let currentPage = 1;


let ADVANCEFILTER = null;




 
$('#pendingRbimListBtn, #approvedRbimListBtn, #declinedRbimListBtn').click(function (e) { 
    e.preventDefault();

    $('.rbim_list_btn').removeClass('active')

    $(this).addClass('active')
    
    if ($(this).attr('id') == "pendingRbimListBtn") {
        $('#pendingRbimListRadio').click()
    } else if ($(this).attr('id') == "approvedRbimListBtn") {
        $('#approvedRbimListRadio').click()
    } else if ($(this).attr('id') == "declinedRbimListBtn") {
        $('#declinedRbimListRadio').click()
    }

    if ($(this).attr('id') == "approvedRbimListBtn") {
        $('#grouped_by option[value=""]').prop('disabled', false)
        // $('#grouped_by option[value="1"]').prop('selected', false)

        $('#printRBIM').removeClass('d-none')
    } else {
        $('#grouped_by option[value=""]').prop('disabled', true)
        $('#grouped_by option[value="1"]').prop('selected', true)

        $('#printRBIM').addClass('d-none')
    }


    if ($('#grouped_by').val() == 1) {
        $('#unGroupedFilter').addClass('d-none');
        $('#groupedFilter').removeClass('d-none');
    } else {
        $('#groupedFilter').addClass('d-none');
        $('#unGroupedFilter').removeClass('d-none');
    }
    
    ADVANCEFILTER = null;
    getRBIMs(1, "")
});  

$('#searchForm').submit(function (e) { 
    e.preventDefault();
    
    $('#purok').val("")
    ADVANCEFILTER = null;
    getRBIMs(1, $('#search').val())
});

$('#grouped_by, #purok, #year, #qtr').change(function (e) { 
    e.preventDefault();
    $('#search').val("");
    ADVANCEFILTER = null;
    getRBIMs(1, "")

    if ($(this).attr('id') == "grouped_by") {
        if ($(this).val() == 1) {
            $('#unGroupedFilter').addClass('d-none');
            $('#groupedFilter').removeClass('d-none');
        } else {
            $('#groupedFilter').addClass('d-none');
            $('#unGroupedFilter').removeClass('d-none');
        }
    }
});

$('#houseOwnershipStatusFilter, #electricityFilter, #sanitaryToiletFilter, #monthLyIncomeFilter').change(function (e) { 
    e.preventDefault();
    $('#search').val("");
    ADVANCEFILTER = null;
    getRBIMs(1, "")
});


// row/display
let groupedCitizensElem = function (index, houseHold) {

    let houseHoldNo = "Unset";
    let houseHoldHead = "";

    if (houseHold.houseHoldNo != null) {
        houseHoldNo = houseHold.houseHoldNo
    }

    $.each(houseHold.familyMembers, function (i, familyMember) { 
         if (familyMember.isHead == 1) {
            houseHoldHead = familyMember.name;
         }
    });

    console.log(houseHold);
    let previewBtn = '<button class="btn text-info" onclick="previewHouseHoldInfo('+houseHold.id+')">' +
        '<span class="fas fa-eye"></span>' +
    '</button>';

    let noCol = '<td class="text-center">'+(index+1)+'</td>';
    let purokCol = '<td class="text-start">'+houseHold.purok+'</td>';
    let numFamilyCol = '<td class="text-center">'+houseHold.numFamily+'</td>';
    let houseHoldNoCol = '<td class="text-center">'+houseHoldNo+'</td>';
    let houseHoldHeadCol = '<td class="text-dark">'+houseHoldHead+'</td>';

    let btnsCol = '<td class="text-dark">' +
        '<div class="d-flex justify-content-end">' +
            previewBtn +
        '</div>' +
    '</td>';

    let row = '<tr class="slide_in">'+noCol+purokCol+numFamilyCol+houseHoldNoCol+houseHoldHeadCol+btnsCol+'</tr>';

    return row;
}

let citizensRow = function (index, fam, isPreview) {

    let isHead = '';
    let houseHoldCol = '';

    if (fam.isHead == 1) {
        isHead = '<span class="fas fa-check"></span>';
    }

    if (isPreview == 1) {
        houseHoldCol = '<td class="text-center text-success">'+isHead+'</td>';
    } else {
        if (fam.houseHoldNo == null) {
            houseHoldCol = '<td class="text-center text-muted">Unset</td>';
        } else {
            houseHoldCol = '<td class="text-center">'+fam.houseHoldNo+'</td>';
        }
         
    }
    
    let sex;

    if (fam.sex == 1) {
        sex = "Male";
    } else {
        sex = "Female";
    }

    let isSchooling = "No";

    if (fam.isSchooling == 1) {
        isSchooling = "Yes";
    }

    let soloParent = "No";

    if (fam.soloParent == 1) {
        soloParent = "Yes";
    } 

    let noCol = '<td class="text-center text-nowrap">'+(index+1)+'</td>';
    let purokCol = '<td class="text-start text-nowrap">'+fam.purok+'</td>';
    let numFamilyCol = '<td class="text-start text-nowrap">'+fam.numFamily+'</td>';
    let lastNameCol = '<td class="text-start text-nowrap">'+fam.lastName+'</td>';
    let firstNameCol = '<td class="text-start text-nowrap">'+fam.firstName+'</td>';
    let middleNameCol = '<td class="text-start text-nowrap">'+fam.middleName+'</td>';
    let extNameCol = '<td class="text-start text-nowrap">'+fam.extName+'</td>';
    let sexCol = '<td class="text-center text-nowrap">'+sex+'</td>';
    let birthDateCol = '<td class="text-start text-nowrap">'+formatDate(fam.birthDate)+'</td>';
    let ageCol = '<td class="text-center text-nowrap">'+calculateAge(fam.birthDate)+'</td>';
    let birthPlaceCol = '<td class="text-start">'+fam.birthPlace+'</td>';
    let educationalAttainmentCol = '<td class="text-start">'+fam.educationalAttainment+'</td>';
    let occupationCol = '<td class="text-start">'+fam.occupation+'</td>';
    let roleCol = '<td class="text-start">'+fam.role+'</td>';
    let civilStatusCol = '<td class="text-start">'+fam.civilStatus+'</td>';
    let religionCol = '<td class="text-start">'+fam.religion+'</td>';
    let isSchoolingCol = '<td class="text-center">'+isSchooling+'</td>';
    let soloParentCol = '<td class="text-center">'+soloParent+'</td>';

    let pwdCol;

    if (fam.pwdId == 0 || fam.pwdId == undefined) {
        pwdCol = '<td class="text-center" colspan="2">No</td>';
    } else {
        pwdCol = '<td class="text-start text-nowrap">ID No.: '+fam.pwdId+'</td>';
        
        let disabilityTypes = "";

        $.each(fam.disabilityType, function (index, disabilityType) { 
             if (disabilityTypes == "") {
                disabilityTypes += disabilityType
             } else {
                disabilityTypes += ", " + disabilityType
             }
        });

        pwdCol += '<td class="text-start">Disability: <br>'+disabilityTypes+'</td>';
    }

    // let editBtn = '<button class="btn text-info m-1" onclick="editFamilyMemebr(\''+index+'\')">' +
    //     '<span class="fas fa-edit"></span>' +
    // '</button>';
    // let deleteBtn = '<button class="btn text-danger m-1" onclick="deleteFamilyMemebr(\''+index+'\')">' +
    //     '<span class="fas fa-trash-alt"></span>' +
    // '</button>';

    // let btnCol = '<td>' +
    //     '<div class="d-flex justify-content-end">' +
    //         editBtn + deleteBtn +
    //     '</div>' +
    // '</td>';

    let famsRow =  '<tr class="slide_in text-nowraps">' + '</tr>';

    if (isPreview == 1) {
        famsRow = '<tr class="slide_in text-nowraps">'+
            houseHoldCol+noCol+lastNameCol+firstNameCol+middleNameCol+extNameCol+sexCol+birthDateCol+ageCol+birthPlaceCol+educationalAttainmentCol+occupationCol+roleCol+civilStatusCol+religionCol+isSchoolingCol+soloParentCol+pwdCol+
        '</tr>';
    } else {
        // console.log(isPreview)
        famsRow = '<tr class="slide_in text-nowraps">'+
            noCol+purokCol+numFamilyCol+houseHoldCol+lastNameCol+firstNameCol+middleNameCol+extNameCol+sexCol+birthDateCol+ageCol+birthPlaceCol+educationalAttainmentCol+occupationCol+roleCol+civilStatusCol+religionCol+isSchoolingCol+soloParentCol+pwdCol+
        '</tr>';
    }

    return famsRow;
}





// get
function fetchRBIMs(page) { 
    getRBIMs(page,  $('#search').val())
}

function getRBIMs(page = 1, search = "") {

    let data = {
        'search' : search,
        'grouped_by' : $('#grouped_by').val(),
        'purok' : $('#purok').val(),
        'year' : $('#year').val(),
        'qtr' : $('#qtr').val(),
        'status' : $('input[name="RbimListRadio"]:checked').val(),
        'page' : page,
        'limit' : LIMIT,
        'houseOwnershipStatus' : $('#houseOwnershipStatusFilter').val(),
        'electricity' : $('#electricityFilter').val(),
        'sanitaryToilet' : $('#sanitaryToiletFilter').val(),
        'monthLyIncome' : $('#monthLyIncomeFilter').val(),
        'advanceFilter' : ADVANCEFILTER
    }

    $.ajax({
        type: "GET",
        url: "submits/RBIMRequests.php?action=getRBIM",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            $('.ungrouped_trows').remove();
            showLoadingTableContent("#rbimList", 5)
            $('#rbimLinks').html("")
        },
        success: function (response) {
            console.log(response);
            setTimeout(() => {
                currentPage = page;
                $('#rbimList').html("")
                if(response.groupedBy == 1) {
                    $('#btnCol').removeClass('d-none')
                    $('#thName').removeClass("d-none")
                    
                    $('#thName').html("Head of the Household")
                    if (response.houseHolds.length <= 0) {
                        displayTableMsg('rbimList', 5, "No Households Found.");
                    } else {
                        $.each(response.houseHolds, function (index, houseHold) { 
                            $('#rbimList').append(groupedCitizensElem(index, houseHold));
                        });
                    }
                    displayPagination("rbimLinks", currentPage, 'fetchRBIMs', response.totalPages);
                } else {
                    $('#btnCol').addClass('d-none')
                    $('#thName').addClass("d-none")

                    let theadRows = '' +
                    '<th class="text-nowrap ungrouped_trows">Last Name</th>' +
                    '<th class="text-nowrap ungrouped_trows">First Name</th>' +
                    '<th class="text-nowrap ungrouped_trows">Middle Name</th>' +
                    '<th class="text-nowrap ungrouped_trows">Ext. of Name</th>' +
                    '<th class="text-nowrap ungrouped_trows">Sex</th>' +
                    '<th class="text-nowrap ungrouped_trows">Birth Date</th>' +
                    '<th class="text-nowrap ungrouped_trows">Age</th>' +
                    '<th class="text-nowrap ungrouped_trows">Birth Place</th>' +
                    '<th class="text-nowrap ungrouped_trows">Highest School Attended</th>' +
                    '<th class="text-nowrap ungrouped_trows">Occupation</th>' +
                    '<th class="text-nowrap ungrouped_trows">Role in Family</th>' +
                    '<th class="text-nowrap ungrouped_trows">Civil Status</th>' +
                    '<th class="text-nowrap ungrouped_trows">Religion</th>' +
                    '<th class="text-nowrep ungrouped_trows">Currently Attending School</th>' +
                    '<th class="text-nowrep ungrouped_trows">Solo Parent</th>' +
                    '<th class="text-nowrap ungrouped_trows" colspan="2">PWD</th>';

                    $('#rbimTHEadRow').append(theadRows);

                    if (response.citizens.length <= 0) {
                        displayTableMsg('rbimList', 20, "No Citizens Found.");
                    } else {
                        $.each(response.citizens, function (index, citizen) { 
                            $('#rbimList').append(citizensRow(index, citizen, 0));
                        });
                        displayPagination("rbimLinks", currentPage, 'fetchRBIMs', response.totalPages);
                    }
                    
                }
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayTableMsg('rbimList', 5, ERRMSG)
            }, timeout);
        },
        complete: function () {
            // setTimeout(() => {
                // hideLoadingContent("#rbimList")
            // }, timeout);
        }
    });


}


// preview
function previewHouseHoldInfo(id) {

   

    $.ajax({
        url: "submits/RBIMRequests.php?action=getHousHold",
        type: "GET",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                let houseHold = response;

                let waterSources = "";

                if (houseHold.houseHoldNo == null) {
                    $('#houseHoldNoPreview').html('Household No.: <span class="text-muted"> Unset </span>')

                } else {
                    $('#houseHoldNoPreview').html('Household No.: ' + houseHold.houseHoldNo)
                }

                $('#purokPreview').html(houseHold.purok);

                if (houseHold.houseOwnershipStatus == 1) {
                    $('#houseOwnershipStatusPreview').html("Owned")
                } else {
                    $('#houseOwnershipStatusPreview').html("Rent Only")
                }

                if (houseHold.electricity == 1) {
                    $('#electricityPreview').html("Yes")
                } else {
                    $('#electricityPreview').html("No")
                }

                if (houseHold.sanitaryToilet == 1) {
                    $('#sanitaryToiletPreview').html("Yes")
                } else {
                    $('#sanitaryToiletPreview').html("No")
                }

                $.each(houseHold.waterSources, function (index, waterSource) { 
                     if (waterSources == "") {
                        waterSources += waterSource;
                     } else {
                        waterSources += ", " + waterSource;
                     }
                });

                $('#waterSourcesPreview').html(waterSources);

                $('#contactNoPreview').html(houseHold.contactNo)
                $('#emailPreview').html(houseHold.email)

                let monthLyIncome = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'PHP',
                  }).format(houseHold.monthLyIncome);

                $('#monthlyIncomePreview').html(monthLyIncome)

                console.log(houseHold)

                $('#houseHold_familyMembersList_Preview').html("")

                if (houseHold.status == 0) {

                    let declineBtn = '<button class="btn btn-danger" value="'+houseHold.id+'" id="declineHouseHoldUpdateBtn" onclick="declineHouseHoldUpdate('+houseHold.id+')">' +
                        '<span class="fas fa-thumbs-down"></span> Decline' +
                    '</button>';
                    let approveBtn = '<button class="btn btn-success" value="'+houseHold.id+'" id="approveHouseHoldUpdateBtn" onclick="approveHouseHoldUpdate('+houseHold.id+', \''+houseHold.houseHoldNo+'\')">' +
                        '<span class="fas fa-thumbs-up"></span> Approve' +
                    '</button>';
                    $('#rbimPreviewModalFooter').prepend(declineBtn);
                    $('#rbimPreviewModalFooter').prepend(approveBtn);

                } else if (houseHold.status == 2) {
                    
                    let deleteBtn = '<button class="btn btn-danger" value="'+houseHold.id+'" id="deleteHouseHoldUpdateBtn" onclick="deleteHouseHoldUpdate('+houseHold.id+')">' +
                        '<span class="fas fa-trash-alt"></span> Delete' +
                    '</button>';
                    $('#rbimPreviewModalFooter').prepend(deleteBtn);

                }

                $.each(houseHold.familyMembers, function (index, fam) { 
                     $('#houseHold_familyMembersList_Preview').append(citizensRow(index, fam, 1));
                });

            

                rbimPreviewModalBS.show();
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

rbimPreviewModal.addEventListener('hidden.bs.modal', function (e) {
    $(document).find('#declineHouseHoldUpdateBtn').remove();
    $(document).find('#approveHouseHoldUpdateBtn').remove();
    $(document).find('#deleteHouseHoldUpdateBtn').remove();
})



// decline
function declineHouseHoldUpdate(id) {
    rbimPreviewModalBS.hide()
    $('#idToDecline').val(id);
    declineRBIMUpdateModalBS.show()
}

$('#declineRBIMUpdateForm').submit(function (e) { 
    e.preventDefault();

    let reasons = [];

    $.each($('input[name="reason"]:checked'), function (index, elem) { 
        reasons.push($(elem).val())
    });
    
    $.ajax({
        type: "POST",
        url: "submits/RBIMRequests.php?action=declineHouseholdUpdate",
        data: { 
            'id' : $('#idToDecline').val(),
            'reasons' : reasons
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    declineRBIMUpdateModalBS.hide()
                    getRBIMs(1, "");
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(3, "Household registration/update Declined.")
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});

declineRBIMUpdateModal.addEventListener('hidden.bs.modal', function () {
    $('#idToDecline').val("")
    declineRBIMUpdateForm.reset();
})


// delete
function deleteHouseHoldUpdate(id) {
    $.ajax({
        type: "POST",
        url: "submits/RBIMRequests.php?action=deleteHouseholdUpdate",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    rbimPreviewModalBS.hide();
                    getRBIMs(1, "");
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
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

// approve
function approveHouseHoldUpdate(id, houseHoldNo) {

    if (houseHoldNo == 'null') {
        $('#id_to_approve').val(id);
        $('#house_hold_no').val("")
        rbimPreviewModalBS.hide();
        householdNoModalBS.show();
    } else {
        $.ajax({
            type: "POST",
            url: "submits/RBIMRequests.php?action=approveHouseholdUpdate",
            data: {
                'id': id,
                'houseHoldNo' : houseHoldNo
            },
            dataType: "JSON",
            beforeSend: function () { 
                showLoadingScreen();
            }, 
            success: function (response) {
                setTimeout(() => {
                    displayMsg(response.status, response.msg);
                    if (response.status == 3) {
                        rbimPreviewModalBS.hide();
                        householdNoModalBS.hide();
                        getRBIMs(1, "");
                    }
                }, timeout);
            },
            error: function (err) {
                setTimeout(() => {
                    console.log(err)
                    displayMsg(3, "Approved", "Approved the registration/update of");
                }, timeout);
            },
            complete: function () {
                setTimeout(() => {
                    hideLoadingScreen();
                }, timeout);
            }
        });
    }
    
}

$('#generateHouseHoldNoBtn').click(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: "submits/RBIMRequests.php?action=generateHouseholdNo",
        dataType: "JSON",
        beforeSend: function() {
            showLoadingScreen();
        },
        success: function (response) {
            console.log(response.householdNo)
            setTimeout(() => {
                $('#house_hold_no').val(response.householdNo);
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                displayMsg(1, ERRMSG);
            }, timeout);
        },
        complete: function () { 
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
         }
    });
});



// advance Filter
let advanceFilterModal = new bootstrap.Modal(document.getElementById('advanceFilterModal'));

$('#advanceFilterModal input[name="unGroupedGenFilter"]').click(function (e) { 

    if ($(this).is(':checked')) {
        $('#'+$(this).val() + "sCont").removeClass('d-none');
    } else {
        if (!$('#'+$(this).val() + "sCont").hasClass('d-none')) {
            $('#'+$(this).val() + "sCont").addClass('d-none');
        }

        $('input[name="'+$(this).val()+'"]').prop('checked', false);
    }
});

$('#advanceFilterModal input[name="disabilityTypeFilter"]').click(function (e) { 
    responseCheckedBox('input[name="disabilityTypeFilter"]', this);
});
$('#advanceFilterModal input[name="srCitizenFilter"]').click(function (e) { 
    responseCheckedBox('input[name="srCitizenFilter"]', this);
});
$('#advanceFilterModal input[name="studentFilter"]').click(function (e) { 
    responseCheckedBox('input[name="studentFilter"]', this);
});
$('#advanceFilterModal input[name="childrenFilter"]').click(function (e) { 
    responseCheckedBox('input[name="childrenFilter"]', this);
});
function responseCheckedBox(element, thisElem) {

    if ($(thisElem).val() == "All") {

        if ($(thisElem).is(':checked')) {
            $(element).prop('checked', true)
        } else {
            $(element).prop('checked', false)
        }

    } else {

        let checkedNum = 0;
        let uncheckedNum = 0;

        $.each($(element), function (index, elem) { 
             if ($(elem).val() != "All") {

                if ($(elem).is(':checked')) {
                    checkedNum += 1;
                } else {
                    uncheckedNum += 1;
                }

             }
        });

        if (uncheckedNum != 0) {
            $(element+'[value="All"]').prop('checked', false);
        } else if (uncheckedNum == 0){
            $(element+'[value="All"]').prop('checked', true);
        }
    }
}

$('#advanceFilterBtn').click(function (e) { 
    e.preventDefault();

    let studentFilter = [];
    let pwdFilter = [];
    let soloParentFilter = 0;
    let srCitizenFilter = [];
    let cyFilter = [];

    if ($('#isSchoolingFilter').is(':checked')) {
        $.each($('input[name="studentFilter"]:checked'), function (index, elem) { 
            studentFilter.push($(elem).val());
        });
    }

    if ($('#soloParentFilter').is(':checked')) {
        soloParentFilter = 1;
    } else {
        soloParentFilter = 0;
    }

    if ($('#pwdFilter').is(':checked')) {
        $.each($('input[name="disabilityTypeFilter"]:checked'), function (index, elem) { 
            pwdFilter.push($(elem).val());
        });
    }

    if ($('#srCitizenFilter').is(':checked')) {
        $.each($('input[name="srCitizenFilter"]:checked'), function (index, elem) { 
            srCitizenFilter.push($(elem).val());
        });
    }

    if ($('#childrensYoutFilter').is(':checked')) {
        $.each($('input[name="childrenFilter"]:checked'), function (index, elem) { 
            cyFilter.push($(elem).val());
        });
    }

    let advanceFilter = {
        'studentFilter': studentFilter,
        'pwdFilter': pwdFilter,
        'soloParentFilter': soloParentFilter,
        'srCitizenFilter': srCitizenFilter,
        'cyFilter': cyFilter
    }

    ADVANCEFILTER = advanceFilter;
    


    advanceFilterModal.hide()

    getRBIMs(1, "")
});
// advance Filter



// print
$('#printRBIM').click(function (e) { 
    e.preventDefault();

    // let data = {
    //     'search' : search,
    //     'grouped_by' : $('#grouped_by').val(),
    //     'purok' : $('#purok').val(),
    //     'year' : $('#year').val(),
    //     'qtr' : $('#qtr').val(),
    //     'status' : $('input[name="RbimListRadio"]:checked').val(),
    //     'page' : page,
    //     'limit' : 1
    // }

    let data = {
        'search' : search,
        'grouped_by' : $('#grouped_by').val(),
        'purok' : $('#purok').val(),
        'year' : $('#year').val(),
        'qtr' : $('#qtr').val(),
        'status' : $('input[name="RbimListRadio"]:checked').val(),
        'houseOwnershipStatus' : $('#houseOwnershipStatusFilter').val(),
        'electricity' : $('#electricityFilter').val(),
        'sanitaryToilet' : $('#sanitaryToiletFilter').val(),
        'monthLyIncome' : $('#monthLyIncomeFilter').val(),
    }

    let url = 'printRBIM?';

    $.each(data, function (prefix, value) { 
        //  console.log(prefix + ": " + value)
        url += prefix + "=" + value + "&";
    });

    if (ADVANCEFILTER != null) {
        let jsonStringAF = JSON.stringify(ADVANCEFILTER);
        let encodedJsonAF = encodeURIComponent(jsonStringAF);

        url += "&advanceFilter=" + encodedJsonAF + "&";
    }


    url += "activity=print";

    console.log(url)

    window.open(url, '_blank', 'width=920,height=520');
    
});


// get get
getRBIMs(currentPage, "");