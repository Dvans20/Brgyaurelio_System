
let askStatusModal = document.getElementById('askStatusModal')
let askStatusModalBS = new bootstrap.Modal(askStatusModal);

let existingBOFormModal = document.getElementById('existingBOFormModal')
let existingBOFormModalBS = new bootstrap.Modal(existingBOFormModal);

let Existency = 0;
let RBBONo = 0;

let timeout = 300;

let ERRMSG = "Something went wrong;";

const BusinessesCategories = [
    "Retail & Consumer Goods",
    "Service-Oriented Businesses",
    "Manufacturing & Industrial",
    "Healthcare & Wellness",
    "Agriculture & Farming",
    "Franchise Business",
    "Real Estate & Property",
    "Transportation & Logistics",
    "Education & Training"
];

$.each(BusinessesCategories, function (index, val) { 
     $('#businessCategory').append('<option value="'+val+'">'+val+'</option>');
});

const RetailAndConsumerGoods = [
    "Sari-Sari",
    "General Merchandise",
    "Hardware",
    "Grocery",
    "Convenience Store",
    "Electronics and Appliances",
    "Department",
    "Clothing and Apparel",
    "Bakery",
    "Pharmacy/Drugstore",
    "Restaurant",
    "Carinderia",
    "Fast Food Chain",
    "Food Stall/ Food Cart",
    "Catering Services",
    "Coffee Shop/Café",
    "Beverage Stand/Shake Shop"
];

const ServiceOrientedBusinesses = [
    "Salon/Barbershop",
    "Laundry",
    "Printing",
    "Event Planning and Coordination",
    "Travel Agency",
    "Courier/Delivery Services",
    "Tech Support & Services",
];

const ManufacturingAndIndustrial = [
    "Furniture Manufacturing",
    "Garment Manufacturing",
    "Construction and Building Supplies",
    "Packaging Services",
    "Food Processing"
];

const HealthcareAndWellness = [
    "Medical Clinic",
    "Dental Clinic",
    "Fitness Center/Gym",
    "Spa and Wellness Center",
];

const AgricultureAndFarming = [
    "Farm-to-Market Business",
    "Livestock Farming",
    "Aquaculture/Fish Farming",
    "Agri-Tourism",
    "Organic Farming",
];

const FranchiseBusiness = [
    "Food Franchises",
    "Retail Franchises",
    "Service Franchises",
];

const RealEstateAndProperty = [
    "Real Estate Agency",
    "Property Management",
    "Construction and Development"
];

const TransportationAndLogistics = [
    "Transportation Services (e.g., Jeepney, Tricycle)",
    "Car Rental Services",
    "Shipping and Freight Services",
    "Trucking and Hauling Services"
];

const EducationAndTraining = [
    "Tutorial Center",
    "Vocational Training Center",
    "School",
];





$('#businessCategory').change(function (e) { 

    $('#businessType').html('<option value="">Business Type</option>');
    $('#businessType').prop('disabled', false);

    e.preventDefault();
    
    switch ($(this).val()) {

        case "Retail & Consumer Goods" :
            $.each(RetailAndConsumerGoods, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Service-Oriented Businesses" :
            $.each(ServiceOrientedBusinesses, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Manufacturing & Industrial" :
            $.each(ManufacturingAndIndustrial, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Healthcare & Wellness" :
            $.each(HealthcareAndWellness, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Agriculture & Farming" :
            $.each(AgricultureAndFarming, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Franchise Business" :
            $.each(FranchiseBusiness, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Real Estate & Property" :
            $.each(RealEstateAndProperty, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Transportation & Logistics" :
            $.each(TransportationAndLogistics, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Education & Training" :
            $.each(EducationAndTraining, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        default:
            $('#businessType').prop('disabled', true);
            break;
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
    let specialCharacters = '!@';
    
    let allCharacters =  uppercaseLetters +  lowercaseLetters + numbers;
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

    $('#passKey').val(password+specialCharacters);

    if ($('#passKey').attr('type') == "password") {
        $('#passKeyToggleVisibilityBtn').click();
    }
    
    displayMsg(4, "Please copy and save your passkey. You will need it later when updating your household information.")
});






// save
$('#saveRBBOBtn').click(function (e) { 
    e.preventDefault();

    let data = {
        'existency' : Existency,
        'busNo' : RBBONo,
        'purok' : $('#purok').val(),
        'onwnersName' : $('#name').val(),
        'residenceAddress' : $('#residenceAddress').val(),
        'businessName' : $('#businessName').val(),
        'category' : $('#businessCategory').val(),
        'type' : $('#businessType').val(),
        'contactNo' : $('#contactNo').val(),
        'email' : $('#email').val(),
        'passKey' : $('#passKey').val()
    }

    

    $.ajax({
        type: "POST",
        url: "admin/submits/RBBORequests.php?action=saveRBBO",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            console.log(response)
            setTimeout(() => {
                if (response.status != 3) {
                    displayMsg(response.status, response.msg);
                } else {
                    console.log(response)
                    location.href = "rbbo_status?msg=" + response.msg;
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




// existing
$('#existingBO').click(function (e) { 
    e.preventDefault();
    askStatusModalBS.hide();

    existingBOFormModalBS.show()
});

$('#existingBOForm').submit(function (e) { 
    e.preventDefault();
    busno = $('#existingBONo').val();
     buskey = $('#existingPassKey').val();
    $.ajax({
        type: "POST",
        url: "admin/submits/RBBORequests.php?action=getRBBOByKey",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function (response) {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {

                if (response.status >= 5) {

                    location.href = "rbbo_status?msg=" + response.msg + "&busNo=" + busno + "&passKey=" + buskey ;
                } else if (response.status != 3) {
                    displayMsg(response.status, response.msg);
                } else {
                    displayMsg(response.status, response.msg);

                    let rbbo = response.rbbo;
                    

                    RBBONo = rbbo.busNo;
                    Existency = 1;

                    $('#busNoText').text("Bus. No.: " + RBBONo);

                    $('#purok').val(rbbo.purok)
                    $('#name').val(rbbo.onwnersName)
                    $('#residenceAddress').val(rbbo.residenceAddress)
                    $('#businessName').val(rbbo.businessName)
                    $('#businessCategory').val(rbbo.category)
                    $('#businessCategory').trigger('change')

                    setTimeout(() => {
                        $('#businessType').val(rbbo.type)
                    }, timeout);
                    $('#contactNo').val(rbbo.contactNo)
                    $('#email').val(rbbo.email)


                    $('#generatePassKeyCont').addClass('d-none');
                    $('#passKey').val(rbbo.passKey)

                    existingBOFormModalBS.hide()
                    
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

askStatusModalBS.show();