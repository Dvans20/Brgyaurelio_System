
let familyMemberFormModal = document.getElementById('familyMemberFormModal')
let familyMemberFormModalBS = new bootstrap.Modal(familyMemberFormModal)
let familyMemberForm = document.getElementById('familyMemberForm')

let existingHouseHoldFormModal = document.getElementById('existingHouseHoldFormModal')
let existingHouseHoldFormModalBS = new bootstrap.Modal(existingHouseHoldFormModal);
let existingHouseHoldForm = document.getElementById('existingHouseHoldForm')

let askStatusModal = document.getElementById('askStatusModal')
let askStatusModalBS = new bootstrap.Modal(askStatusModal);
askStatusModalBS.show();


let familyMembers = [];

let existency = 2;

let existencyHouseholdKey = "";


familyMemberFormModal.addEventListener('hidden.bs.modal', function () {
    familyMemberForm.reset();
    if (!$('#role_in_cont').hasClass('d-none')) {
        $('#role_in_cont').addClass('d-none');
    }
    $('#index').val("");

    if (!$('#disabilityTypesContainer').hasClass('d-none')) {
        $('#disabilityTypesContainer').addClass('d-none');
    }
})

$('#familyMemberForm').submit(function (e) { 
    e.preventDefault();

    let disabilityTypes = [];

    $.each($('input[name="disabilityType"]:checked'), function (index, val) { 
        disabilityTypes.push($(val).val());
    });

    console.log();

    if ($('#lastName').val() == "" || 
        $('#firstName').val() == "" || 
        $('#sex').val() == "" || 
        $('#civilStatus').val() == "" || 
        $('#religion').val() == "" || 
        $('#educationalAttainment').val() == "" || 
        $('#birthDate').val() == "" || 
        $('#birthPlace').val() == "" || 
        $('#occupation').val() == "" ||
        $('#role').val() == ""
    ) {
        
        displayMsg(2, "All fields are required.")
    
    } else if ($('#role').val() == "others" && $('#role_in').val() == "") {

        displayMsg(2, "All fields are required.")
        
    } else if ($('#isPwd').is(':checked') && $('#pwdId').val() == "") {

        displayMsg(2, "PWD Id is requiered.")

    } else if ($('#isPwd').is(':checked') && disabilityTypes.length <= 0) {

        displayMsg(2, "Disability Type is required.")

    } else {

        let isSchooling = 2;
        let isPWD = 0;
        let soloParent = 0;


        if ($('#isSchooling').is(':checked')) {
            isSchooling = 1;
        }

        if ($('#soloParent').is(':checked')) {
            soloParent = 1;
        }

        if ($('#isPwd').is(':checked')) {
            isPWD = $('#pwdId').val()
        } else {
            disabilityTypes = null;
        }

        let familyInfo = {
            'isHead' : 0,
            'lastName': $('#lastName').val(),
            'firstName': $('#firstName').val(),
            'middleName': $('#middleName').val(),
            'extName': $('#extName').val(),
            'sex': $('#sex').val(),
            'civilStatus': $('#civilStatus').val(),
            'religion': $('#religion').val(),
            'educationalAttainment': $('#educationalAttainment').val(),
            'birthDate': $('#birthDate').val(),
            'birthPlace': $('#birthPlace').val(),
            'occupation': $('#occupation').val(),
            'role': $('#role').val(),
            'isSchooling' : isSchooling,
            'soloParent' : soloParent,
            'isPWD' : isPWD,
            'disabilityTypes' : disabilityTypes
        }

        if (familyInfo.role == "others") {
            familyInfo.role = $('#role_in').val();
        }
    
        if ($('#index').val() == "") {
            familyMembers.push(familyInfo);
        } else {
            familyMembers[$('#index').val()] = familyInfo;
        }


        familyMemberFormModalBS.hide()

        displayFamilies()
    }
    

    
});

let familiesRow = function (index, fam) {
    let houseHoldCol = '<td class="text-center"><input type="radio" name="household_head" id="householdHead'+(index)+'" value="'+(index)+'" class="form-check-input cursor-pointer"></td>';
    
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

    

    let noCol = '<td class="text-center">'+(index+1)+'</td>';
    let lastNameCol = '<td class="text-nowrap text-start">'+fam.lastName+'</td>';
    let firstNameCol = '<td class="text-nowrap text-start">'+fam.firstName+'</td>';
    let middleNameCol = '<td class="text-nowrap text-start">'+fam.middleName+'</td>';
    let extNameCol = '<td class="text-nowrap text-start">'+fam.extName+'</td>';
    let sexCol = '<td class="text-nowrap text-center">'+sex+'</td>';
    let birthDateCol = '<td class="text-nowrap text-start">'+formatDate(fam.birthDate)+'</td>';
    let ageCol = '<td class="text-nowrap text-center">'+calculateAge(fam.birthDate)+'</td>';
    let birthPlaceCol = '<td class="text-nowrap text-start">'+fam.birthPlace+'</td>';
    let educationalAttainmentCol = '<td class="text-start">'+fam.educationalAttainment+'</td>';
    let occupationCol = '<td class="text-start">'+fam.occupation+'</td>';
    let roleCol = '<td class="text-start">'+fam.role+'</td>';
    let civilStatusCol = '<td class="text-start">'+fam.civilStatus+'</td>';
    let religionCol = '<td class="text-start">'+fam.religion+'</td>';
    let isSchoolingCol = '<td class="text-center">'+isSchooling+'</td>';
    let soloParentCol = '<td class="text-center">'+soloParent+'</td>';

    let pwdCol;

    if (fam.isPWD == 0) {
        pwdCol = '<td class="text-center" colspan="2">No</td>';
    } else {
        pwdCol = '<td class="text-start">ID No.: '+fam.isPWD+'</td>';
        
        let disabilityTypes = "";

        $.each(fam.disabilityTypes, function (index, disabilityType) { 
             if (disabilityTypes == "") {
                disabilityTypes += disabilityType
             } else {
                disabilityTypes += ", " + disabilityType
             }
        });

        pwdCol += '<td class="text-start">Disability: <br>'+disabilityTypes+'</td>';
    }

    let editBtn = '<button class="btn text-info m-1" onclick="editFamilyMemebr(\''+index+'\')">' +
        '<span class="fas fa-edit"></span>' +
    '</button>';
    let deleteBtn = '<button class="btn text-danger m-1" onclick="deleteFamilyMemebr(\''+index+'\')">' +
        '<span class="fas fa-trash-alt"></span>' +
    '</button>';

    let btnCol = '<td>' +
        '<div class="d-flex justify-content-end">' +
            editBtn + deleteBtn +
        '</div>' +
    '</td>';


    let famsRow = '<tr class="slide_in">'+houseHoldCol+noCol+lastNameCol+firstNameCol+middleNameCol+extNameCol+sexCol+birthDateCol+ageCol+birthPlaceCol+educationalAttainmentCol+occupationCol+roleCol+civilStatusCol+religionCol+isSchoolingCol+pwdCol+soloParentCol+btnCol+'</tr>';

    return famsRow;
}

function displayFamilies() {

    $('#familyMembersList').html("")

    $.each(familyMembers, function (index, famMember) { 
         $('#familyMembersList').append(familiesRow(index, famMember));
    });
    
}

function formatDate(dateString) {
    // Create a new Date object from the input string
    const date = new Date(dateString);
    
    // Options for formatting
    const options = { year: 'numeric', month: 'long', day: 'numeric' };

    // Return the formatted date
    return date.toLocaleDateString('en-US', options);
}

function calculateAge(birthDate) {
    const birth = new Date(birthDate);
    const today = new Date();
    
    let age = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();

    // Adjust age if the birth date hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age;
}

$('#role').change(function (e) { 
    e.preventDefault();

    if ($(this).val() == 'others') {
        $('#role_in_cont').removeClass('d-none');
    } else {
        $('#role_in_cont').addClass('d-none');
    }
    
});

$('#isPwd').click(function (e) { 
   
    if ($(this).is(':checked')) {
        $('#disabilityTypesContainer').removeClass('d-none')
    } else {
        $('#disabilityTypesContainer').addClass('d-none');
    }
    
});



function editFamilyMemebr(index)
{
    let familyMember = familyMembers[index]

    $('#index').val(index)

    $('#lastName').val(familyMember.lastName);
    $('#firstName').val(familyMember.firstName);
    $('#middleName').val(familyMember.middleName);
    $('#extName').val(familyMember.extName);

    $('#sex').val(familyMember.sex);
    $('#civilStatus').val(familyMember.civilStatus);
    $('#religion').val(familyMember.religion);
    $('#educationalAttainment').val(familyMember.educationalAttainment);

    $('#birthDate').val(familyMember.birthDate);
    $('#birthPlace').val(familyMember.birthPlace);
    $('#occupation').val(familyMember.occupation);
    $('#role').val(familyMember.role);

    if (familyMember.isSchooling == 1) {
        $('#isSchooling').prop('checked', true);
    }

    if (familyMember.soloParent == 1) {
        $('#soloParent').prop('checked', true);
    }

    if (familyMember.isPWD != 0) {
        $('#isPwd').prop('checked', true);

        if ($('#disabilityTypesContainer').hasClass('d-none')) {
            $('#disabilityTypesContainer').removeClass('d-none')
        }

        $('#pwdId').val(familyMember.isPWD)

        $.each(familyMember.disabilityTypes, function (index, disabilityType) { 
            $('#disabilityTypesContainer').find('input[value="'+disabilityType+'"]').prop('checked', true);
        });
        
    }

    
    

    familyMemberFormModalBS.show()
}

function deleteFamilyMemebr(index)
{
    familyMembers.splice(index, 1);
    displayFamilies();
}



$('#source_of_water_others').click(function (e) { 

    if ($(this).is(':checked')) {
        $('#source_of_water_others_in_cont').removeClass('d-none')
    } else {
        $('#source_of_water_others_in_cont').addClass('d-none')
    }
    
});

$('#passKeyToggleVisibilityBtn').click(function (e) { 
    e.preventDefault();
    if ($('#passKey').attr('type') == "password") {
        $('#passKey').prop('type', "text")
        $(this).html('<span class="fas fa-eye-slash"></span>')
    } else {
        $('#passKey').prop('type', "password")
        $(this).html('<span class="fas fa-eye"></span>')
    }
});

$('#generatePassKey').click(function (e) { 
    e.preventDefault();
    let uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    let lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
    let numbers = '0123456789';

    
    let allCharacters =  uppercaseLetters + lowercaseLetters + numbers;
    let password = '';

    for (let i = 0; i < 12; i++) {

        if (i == 3) {
            let randomIndex = Math.floor(Math.random() * uppercaseLetters.length);
            password += uppercaseLetters[randomIndex];
        } else if (i == 5) {
            let randomIndex = Math.floor(Math.random() * lowercaseLetters.length);
            password += lowercaseLetters[randomIndex];
        } else if (i == 8) {
            let randomIndex = Math.floor(Math.random() * numbers.length);
            password += numbers[randomIndex];
        } else {
            let randomIndex = Math.floor(Math.random() * allCharacters.length);
            password += allCharacters[randomIndex];
        }
    }

    $('#passKey').val(password + "@!");

    if ($('#passKey').attr('type') == "password") {
        $('#passKeyToggleVisibilityBtn').click();
    }
    
    displayMsg(4, "Please copy and save your passkey. You will need it later when updating your household information.")
});

$('#saveRBIMBtn').click(function (e) { 
    e.preventDefault();

    let waterSources = [];

    $.each($('input[name="source_of_water"]:checked'), function (index, waterSource) { 
         if ($(waterSource).val() != "others") {
            waterSources.push($(waterSource).val());
         }
    });

    if ($('#source_of_water_others').is(':checked')) {
        let water_sources = $('#source_of_water_others_in').val();
        water_sources = water_sources.split(',');

        if (water_sources.length > 0) {
            $.each(water_sources, function (index, waterSource) { 
                waterSources.push(waterSource.trim());
            });
        }


    }

    let hhHeadIndex = $('input[name="household_head"]:checked').val();

    let isHeasdSet = "";



    $.each(familyMembers, function (index, familyMember) { 
        if (index != hhHeadIndex) {
            familyMember.isHead = 0;
        } else {
            familyMember.isHead = 1;
            isHeasdSet = 1;
        }
    });
    


    let data;

    if (existency == 2) {
        data = {
            'head' : isHeasdSet,
            'numFamily' : $('#numFamily').val(),
            'purok' : $('#purok').val(),
            'status_of_house_ownership' : $('input[name="status_of_house_ownership"]:checked').val(),
            'electricity' : $('input[name="electricity"]:checked').val(),
            'source_of_water' : waterSources,
            'sanitary_toilet' : $('input[name="sanitary_toilet"]:checked').val(),
            'contactNo' : $('#contactNo').val(),
            'email' : $('#email').val(),
            'monthLyIncome' : $('#monthLyIncome').val(),
            'familyMembers' : familyMembers,
            'existency' : existency,
            'passKey' : $('#passKey').val()
        }; 
    } else if (existency == 1) {
        data = {
            'head' : isHeasdSet,
            'houseHoldNo' : $('#householdNoText').text(),
            'numFamily' : $('#numFamily').val(),
            'purok' : $('#purok').val(),
            'status_of_house_ownership' : $('input[name="status_of_house_ownership"]:checked').val(),
            'electricity' : $('input[name="electricity"]:checked').val(),
            'source_of_water' : waterSources,
            'sanitary_toilet' : $('input[name="sanitary_toilet"]:checked').val(),
            'contactNo' : $('#contactNo').val(),
            'email' : $('#email').val(),
            'monthLyIncome' : $('#monthLyIncome').val(),
            'familyMembers' : familyMembers,
            'existency' : existency,
            'passKey' : existencyHouseholdKey
        }; 
    }
    

    console.log(data);

    $.ajax({
        type: "POST",
        url: "admin/submits/RBIMRequests.php?action=saveInfo",
        data: data, 
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                if (response.status == 3) {
                    location.href = "rbim_status?msg=" + response.msg;
                } else {
                    displayMsg(response.status, response.msg)
                }
            }, 1000);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(1, "Something Went Wrong.")
            }, 1000);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, 1000);
        }
    });
    
});



// existing Click

$('#existingIMBtn').click(function (e) { 
    e.preventDefault();
    askStatusModalBS.hide();
    existingHouseHoldFormModalBS.show();
});

existingHouseHoldFormModal.addEventListener('hidden.bs.modal', function () {
    $('#existingHouseholdNo').val("")
    $('#existingHouseholdKey').val("")
})

$('#cancelExistingHouseHoldFormModal, #xExistingHouseHoldFormModal').click(function (e) { 
    e.preventDefault();
    if (existency == 2) {
        askStatusModalBS.show();
    }
});

$('#existingHouseHoldForm').submit(function (e) { 
    e.preventDefault();
    hnum = $('#existingHouseholdNo').val();
    hkey = $('#existingHouseholdKey').val();
    $.ajax({
        type: "GET",
        url: "admin/submits/RBIMRequests.php?action=getHouseholdNoAndKey",
        data: {
            'householdNo' : $('#existingHouseholdNo').val(),
            'householdKey' : $('#existingHouseholdKey').val()
        },
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                if (response.status <= 4) {
                    displayMsg(response.status, response.msg)
                    if (response.status == 4) {
                        $('#householdNoTextCont').removeClass('d-none')
                        $('#householdNoText').text(response.household.houseHoldNo)

                        existingHouseHoldFormModalBS.hide()
                        askStatusModalBS.hide()

                        existency = 1;

                        $('#generatePassKeyCont').remove()

                        existencyHouseholdKey = response.household.houseHoldKey;
                    }
                } else {
                    location.href = "rbim_status?msg=" + response.msg +"&householdNo="+hnum+"&householdKey="+hkey;
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
                hideLoadingScreen()
            }, 300);
        }
    });
    
});