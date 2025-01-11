
let currentPage = 1;

const paymentFormModal = document.getElementById('paymentFormModal')
const paymentFormModalBS = new bootstrap.Modal(paymentFormModal)
const paymentForm = document.getElementById('paymentForm')

paymentFormModal.addEventListener('hidden.bs.modal', function () {
    paymentForm.reset()
    $('#amount').prop('disabled', false)
})
paymentFormModal.addEventListener('shown.bs.modal', function () {
    
})

$('#natureOfCollection').change(function (e) { 
    
    $('#natureOfCollectionIn').val("");
    $('#description').val("");

    $('#payorsName').val("");
    $('#citizenId').val("");

    $('#orNo').val("");
    // $('#date').val("");
    $('#amount').val("");


    $('input[name="paymentType"]:checked').val("checked", false);

    if ($(this).val() == 99) {
        $('#natureOfCollectionIn').removeClass('d-none')
    } else {
        $('#natureOfCollectionIn').addClass('d-none')
    }

    if ($(this).val() == 2) {
        $('#amount').prop('disabled', true)
    } else {
        $('#amount').prop('disabled', false)
    }

    
});


$('#selectCitizenBtn').click(function (e) { 
    e.preventDefault();

    if ($('#natureOfCollection').val() == 2) {
        selectCitizenWPenaltyModalBS.show()
    } else if ($('#natureOfCollection').val() != "") {
        selectCitizenModalBS.show()
    }
    
});


const selectCitizenModal = document.getElementById('selectCitizenModal')
const selectCitizenModalBS = new bootstrap.Modal(selectCitizenModal)

const selectCitizenWPenaltyModal = document.getElementById('selectCitizenWPenaltyModal')
const selectCitizenWPenaltyModalBS = new bootstrap.Modal(selectCitizenWPenaltyModal);

selectCitizenModal.addEventListener('hidden.bs.modal', function () {
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

    let radio = '<input type="radio" name="selected_citizen[]" id="citizen'+citizen.id+'" class="form-check-input" value="'+citizen.id+'|'+citizen.name+'">';

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









$('#searchCitizenWPenaltyForm').submit(function (e) { 
    e.preventDefault();
    getCitizensWithPenalties();
});
selectCitizenWPenaltyModal.addEventListener('hidden.bs.modal', function () {
    $('#citizensWPenaltyList').html("");
    $('#searchCitizenWPenlaty').val("");
})
selectCitizenWPenaltyModal.addEventListener('shown.bs.modal', function () {
    getCitizensWithPenalties();
})
let citizensWithPenaltyRow = function (index, violator) {


    let citizen = violator.citizen;
    let violation = violator.violation;

    let sex;

    if (citizen.sex == 1) {
        sex = "Male";
    } else {
        sex = "Female";
    }


    let radio = '<input type="checkbox" name="selected_citizen[]" id="citizen'+citizen.id+'" class="form-check-input" value="'+citizen.id+'|'+citizen.name+'|'+violation.payableAmount+'|'+violator.id+'">';


    let radioCol = '<td class="text-center">'+radio+'</td>';
    let violationCol = '<td class="text-start">'+violation.violation+'</td>';
    let amountCol = '<td class="text-start">'+formatToPHP(violation.payableAmount)+'</td>';
    let nameCol = '<td class="text-start">'+citizen.name+'</td>';
    let purokCol = '<td class="text-start">'+citizen.purok+'</td>';
    let bDateCol = '<td class="text-start">'+formatDate(citizen.birthDate)+'</td>';
    let ageCol = '<td class="text-start">'+calculateAge(citizen.birthDate)+'</td>';
    let sexCol = '<td class="text-start">'+sex+'</td>';

    let row = '' +
    '<tr class="slide_in">' +
        radioCol + violationCol + amountCol + purokCol + nameCol + bDateCol + ageCol + sexCol +
    '</tr>';

    return row;
}
function getCitizensWithPenalties() {
    let data = {
        'search' : $('#searchCitizenWPenlaty').val(),
        'violation' : "",
        'page' : 1,
        'limit': LIMIT
    }

    $.ajax({ 
        type: "GET",
        url: "submits/violatorsRequests.php?action=getViolatorsWithpay",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#citizensWPenaltyList', 8)
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                if (response.violators == null) {
                    displayTableMsg('citizensWPenaltyList', 8, ERRMSG)
                } else if (response.violators.length <= 0) {
                    displayTableMsg('citizensWPenaltyList', 9, "No Citizens Found.");
                } else {
                    $('#citizensWPenaltyList').html("");
                    selectCitizenWPenaltyModalBS.show()
                    $.each(response.violators, function (index, violator) { 
                        $('#citizensWPenaltyList').append(citizensWithPenaltyRow(index, violator));
                    });
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('citizensWPenaltyList', 8, ERRMSG)
            }, timeout);
        }
    });
}




function selectCitizen() {
    let selectedCitizens = $('input[name="selected_citizen[]"]:checked'); // Get all selected citizens
    let totalPenalty = 0; // Initialize a variable to sum the penalties
    let violatorIds = ""; // This will store the concatenated violatorIds

    if (selectedCitizens.length <= 0) {
        displayMsg(2, "Please select a citizen.");
    } else {
        selectedCitizens.each(function() {
            let selectedValue = $(this).val(); // Get the value of each selected citizen
            let valueParts = selectedValue.split("|"); // Split by "|"

            let id = valueParts[0];
            let name = valueParts[1];
            let penalty = parseFloat(valueParts[2]); // Get the penalty amount and convert to a number
            let violatorId = valueParts[3] || ""; // Get violatorId, or set empty if not present

            // Add the penalty to the total sum
            totalPenalty += penalty;

            // Concatenate violatorIds with commas, if violatorId is not empty
            if (violatorId !== "") {
                if (violatorIds === "") {
                    violatorIds = violatorId; // First violatorId
                } else {
                    violatorIds += "," + violatorId; // Add the rest of the violatorIds
                }
            }

            // Optionally update the fields with the citizen details
            $('#citizenId').val(id);
            $('#payorsName').val(name);
        });

        // Check if violatorIds is not empty before setting the amount
        if (violatorIds !== "") {
            $('#amount').val(totalPenalty.toFixed(2)); // Sum of penalties, formatted to 2 decimal places
            $('#violatorId').val(violatorIds); // Set concatenated violatorIds
        }

        // Optionally hide the modal or take further actions
        if ($('#natureOfCollection').val() == 2) {
            selectCitizenWPenaltyModalBS.hide(); // Hide modal if necessary
        } else {
            selectCitizenModalBS.hide();
        }
    }
}



$(document).ready(function() {
    // Get today's date
    let currentDate = new Date();
    
    // Calculate the minimum and maximum allowed dates (1 week before and after current date)
    let minDate = new Date(currentDate);
    minDate.setDate(currentDate.getDate() - 7); // Subtract 7 days for minDate
    
    let maxDate = new Date(currentDate);
    maxDate.setDate(currentDate.getDate() + 7); // Add 7 days for maxDate
    
    // Format dates as 'YYYY-MM-DD'
    let minDateFormatted = minDate.toISOString().split('T')[0];
    let maxDateFormatted = maxDate.toISOString().split('T')[0];
    
    // Apply min and max date to all inputs with the class 'date-input'
    $('.date-input').each(function() {
        $(this).attr('min', minDateFormatted);
        $(this).attr('max', maxDateFormatted);
    });

    // Change event to alert if the selected date is outside the range
    $('.date-input').on('change', function() {
        let selectedDate = $(this).val();
        
        // Check if the selected date is within the min/max range
        if (selectedDate < minDateFormatted || selectedDate > maxDateFormatted) {
            alert("The date must be within 1 week before or after today's date.");
            $(this).val(''); // Clear the input if the date is out of range
        }
    });
});






// submit 
$('#paymentForm').submit(function (e) { 
    e.preventDefault();


    if ($('#natureOfCollection').val() == 2) {
        $('#amount').prop('disabled', false)
    } 

    $.ajax({
        type: "POST",
        url: "submits/paymentsRequests.php?action=newPayment",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                displayMsg(response.status, response.msg)
                if ($('#natureOfCollection').val() == 2) {
                    $('#amount').prop('disabled', true)
                }
                if (response.status == 3) { 
                    paymentFormModalBS.hide()
                    getPayments(1)
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



$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getPayments(1)
});
$('#collectionFilter').change(function (e) { 
    getPayments(1)
});

function getPayments(page) {
    let data = {
        'search' : $('#search').val(),
        'natureOfCollection' : $('#collectionFilter').val(),
        'page' : page,
        'limit': LIMIT
    }

    $.ajax({
        type: "GET",
        url: "submits/paymentsRequests.php?action=gePayments",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent('#paymentsList', 5)
            $('#paymentsLinks').html("");
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response)
                if (response.payments == null) {
                    displayTableMsg('paymentsList', 5, ERRMSG)
                } else if (response.payments.length <= 0) {
                    displayTableMsg('paymentsList', 5, "No Payments Found.")
                } else {
                    $('#paymentsList').html("");
                    $.each(response.payments, function (index, payment) { 


                        let prevBtn = '<button class="btn text-info btn-sm" onclick="previewPayment('+payment.id+')"><i class="fas fa-eye"></i></button>';

                    

                        let certBtn = "";

                        if (payment.natureOfCollection == "Certification" || payment.natureOfCollection == "Brgy. Clearance" || payment.natureOfCollection == "Brgy. Clearance for Businesses") {
                            certBtn = '<button class="btn text-[info] btn-sm" onclick="printPreviewPayment('+payment.id+')"><i class="fas fa-print"></i></button>';
                        }

                        
                         

                        let noCol = '<td class="text-center">'+(index + 1)+'</td>';
                        let nameCol = '<td class="text-start">'+payment.payor.name+'</td>';
                        let orCol = '<td class="text-start">'+payment.orNo+'</td>';
                        let dateCol = '<td class="text-start">'+formatDate(payment.date)+'</td>';

                        let btnCol = '<td class="text-end">'+certBtn+prevBtn+'</td>';

                        let row = '' + 
                        '<tr class="slide_in">' +
                            noCol + nameCol + orCol + dateCol + btnCol +
                        '</tr>';


                        $('#paymentsList').append(row);
                    });
                    displayPagination("paymentsLinks", page, "getPayments", response.totalPages)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('paymentsList', 5, ERRMSG)
            }, timeout);
        }
    });
}



getPayments(1)

const previewPaymentModal = document.getElementById('previewPaymentModal')
const previewPaymentModalBS = new bootstrap.Modal(previewPaymentModal)


function previewPayment(id) {
    

    $.ajax({
        type: "GET",
        url: "submits/paymentsRequests.php?action=gePayment",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (payment) {
            setTimeout(() => {
                console.log(payment)

                $('#datePreview').html(formatDate(payment.date));
                $('#orNoPreview').html(payment.orNo);
                $('#natureOfCollectionPreview').html(payment.natureOfCollection);
                $('#descriptionPreview').html(payment.description);
                $('#namePreview').html(payment.payor.name);
                $('#amountPreview').html(formatToPHP(payment.amount));
                $('#paymentTypePreview').html(payment.paymentType);
                previewPaymentModalBS.show()
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

function printPreviewPayment(id) {

    location.href = "certificate?paymentId="
}














