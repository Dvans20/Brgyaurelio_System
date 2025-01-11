

let currentPage = 1;

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

$.each(BusinessesCategories, function (index, category) { 
     $('#category').append('<option value="'+category+'">'+category+'</option>');
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


$('#category').change(function (e) { 

    $('#type').html('<option value="">All</option>');
    $('#type').prop('disabled', false);

    e.preventDefault();
    
    switch ($(this).val()) {

        case "Retail & Consumer Goods" :
            $.each(RetailAndConsumerGoods, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Service-Oriented Businesses" :
            $.each(ServiceOrientedBusinesses, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Manufacturing & Industrial" :
            $.each(ManufacturingAndIndustrial, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Healthcare & Wellness" :
            $.each(HealthcareAndWellness, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Agriculture & Farming" :
            $.each(AgricultureAndFarming, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Franchise Business" :
            $.each(FranchiseBusiness, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Real Estate & Property" :
            $.each(RealEstateAndProperty, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Transportation & Logistics" :
            $.each(TransportationAndLogistics, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Education & Training" :
            $.each(EducationAndTraining, function (index, val) { 
                 $('#type').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        default:
            $('#type').prop('disabled', true);
            break;
    }
});

$('input[name="RbboListRadio"]').click(function (e) { 

    $('.rbbo_list_btn').removeClass('active')
    
    let id = $(this).attr('id');

    id = id.replace("Radio", "Btn");

    $('#' + id).addClass('active')
    
    getRBBO(1)
});




let rbboRow = function (index, rbbo) {

    let busNo = "unset";
    let busNoClass = "text-muted";

    if (rbbo.busNo != 0) {
        busNo = rbbo.busNo;
        busNoClass = ""
    }

    let noCol = '<td class="text-center text-nowrap">'+(index + 1)+'</td>';
    let purokCol = '<td class="text-center text-nowrap">'+rbbo.purok+'</td>';
    let busNoCol = '<td class="text-center '+busNoClass+'">'+busNo+'</td>';
    let onwnersNameCol = '<td class="text-start text-nowrap">'+rbbo.onwnersName+'</td>';
    let residenceAddressCol = '<td class="text-start">'+rbbo.residenceAddress+'</td>';
    let businessNameCol = '<td class="text-start">'+rbbo.businessName+'</td>';
    let categoryCol = '<td class="text-start">'+rbbo.category+'</td>';
    let typeCol = '<td class="text-start">'+rbbo.type+'</td>';
    let contactNoCol = '<td class="text-center">'+rbbo.contactNo+'</td>';
    let emailCol = '<td class="text-start">'+rbbo.email+'</td>';


    let btns = "";

    if (rbbo.status == 0) {
        let approveBtn = '<button class="btn btn-sm btn-success m-1" onclick="approveRBBO('+rbbo.id+', '+rbbo.busNo+')">'+
            '<span class="fas fa-thumbs-up"></span>' +
        '</button>';

        let declineBtn = '<button class="btn btn-sm btn-danger m-1" onclick="declineRBBO('+rbbo.id+')">'+
            '<span class="fas fa-thumbs-down"></span>' +
        '</button>';

        btns += approveBtn;
        btns += declineBtn;

    } else if (rbbo.status == 2) {
        let deleteBtn = '<button class="btn btn-sm btn-danger m-1" onclick="deleteRBBO('+rbbo.id+')">'+
            '<span class="fas fa-trash-alt"></span>' +
        '</button>';
        btns += deleteBtn;
    }

    let btnCol = '<td><div class="">'+btns+'</div></td>';



    let row = '<tr class="slide_in">' +
        noCol + purokCol + busNoCol + onwnersNameCol + residenceAddressCol + businessNameCol +
        categoryCol + typeCol + contactNoCol + emailCol + btnCol +
    '</tr>';

    return row;
}

$('.filter_change').change(function (e) { 
    e.preventDefault();
    getRBBO(1)
});
function fetchRBBO(page) {
    getRBBO(page)
}
$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getRBBO(1)
});
function getRBBO(page) {
    
    let data = {
        'page' : page,
        'limit' : LIMIT,
        'search' : $('#search').val(),
        'purok' : $('#purok').val(),
        'year' : $('#year').val(),
        'qtr' : $('#qtr').val(),
        'category' : $('#category').val(),
        'type' : $('#type').val(),
        'status' : $('input[name="RbboListRadio"]:checked').val()
    }

    $.ajax({
        type: "GET",
        url: "submits/RBBORequests.php?action=getRBBO",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#rbboList', 11)
            $('#rbboLinks').html("")
        },
        success: function (response) {
            setTimeout(() => {
                if (response.rbbos == null) {
                    displayTableMsg("rbboList", 11, ERRMSG)
                } else if (response.rbbos.length <= 0) {
                    displayTableMsg("rbboList", 11, "No RBBO's Found.")
                } else {
                    $('#rbboList').html("")
                    $.each(response.rbbos, function (index, rbbo) { 
                         $('#rbboList').append(rbboRow(index, rbbo));
                    });
                    currentPage = page
                    displayPagination("rbboLinks", page, "fetchRBBO", response.totalPages);
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg("rbboList", 11, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }
    });
}

// to approve RBBO
let busNoModal = document.getElementById('busNoModal')
let busNoModalBS = new bootstrap.Modal(busNoModal);
busNoModal.addEventListener('hidden.bs.modal', function () { 
    $('#id_to_approve').val("")
    $('#bus_no').val("");
})
function approveRBBO(id, busNo) { 
    $('#id_to_approve').val(id)
    if (busNo == 0) {
        busNoModalBS.show()
    } else {
        approveRBBOUpdate(id, busNo);
    }
}
$('#generateBusNoBtn').click(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "GET",
        url: "submits/RBBORequests.php?action=generateBusNo",
        // data: "data",
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                $('#bus_no').val(response)
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
function approveRBBOUpdate(id, busNo)
{
    let data = {
        id : id,
        busNo : busNo,
    }

    $.ajax({
        type: "POST",
        url: "submits/RBBORequests.php?action=approveRBBO",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    busNoModalBS.hide()
                    getRBBO(1);
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(3, "RBBO registration/update approved");
            }, timeout);
             setInterval(function () {
                window.location.reload();
            }, 3000); // 2000 milliseconds = 2 seconds
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
}

// to decline RBBO
let declineRBBOUpdateModal = document.getElementById('declineRBBOUpdateModal')
let declineRBBOUpdateModalBS = new bootstrap.Modal(declineRBBOUpdateModal)
declineRBBOUpdateModal.addEventListener('hidden.bs.modal', function () {
    $('#idToDecline').val("")
    document.getElementById('declineRBBOUpdateForm').reset();
})
function declineRBBO(id) { 
    $('#idToDecline').val(id)
    declineRBBOUpdateModalBS.show()
}
$('#declineRBBOUpdateForm').submit(function (e) { 
    e.preventDefault();

    let reasonsElem = $('input[name="reason"]:checked');

    let reasons = [];

    $.each(reasonsElem, function (index, reason) { 
        reasons.push($(reason).val())
    });

    let data = {
        id : $('#idToDecline').val(),
        reasons : reasons
    }

    console.log(data)

    $.ajax({
        type: "POST",
        url: "submits/RBBORequests.php?action=declineRBBO",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)
                if (response.status == 3) {
                    declineRBBOUpdateModalBS.hide()
                    getRBBO(1);
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayMsg(3, "RBBO registration/update Declined.");
            }, timeout);
            setInterval(function () {
                window.location.reload();
            }, 3000); // 2000 milliseconds = 2 seconds
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen();
            }, timeout);
        }
    });
    
});





// to delete RBBO
function deleteRBBO(id) { 
    $.ajax({
        type: "POST",
        url: "submits/RBBORequests.php?action=deleteRBBO",
        data: {
            id: id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    getRBBO(1)
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

getRBBO(1)