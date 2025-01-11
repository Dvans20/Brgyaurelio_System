var timeout = 500;

let updateSesstionTimeErr = 0;

let CATEGORIES = [];
let fetchCATEGORIESattempts = 0;

const ERRMSG = "Something went wrong";

const LIMIT = 10;
const CARD_BLOCK_LIMIT = 12;

let WEB = null;

function updateSesstionTime() {

    $.ajax({
        type: "POST",
        url: "submits/usersRequests.php?action=updateSessionTime",
        dataType: "JSON",
        success: function (response) {
            // console.log(response.msg)
            updateSesstionTimeErr = 0
            WEB = response.web;
        },
        error: function (err) {
            updateSesstionTimeErr++
            if (updateSesstionTimeErr > 5) {
                displayMsg(1, "No Internet Connection");
                updateSesstionTimeErr = 0
            }
            console.log(err.responseText)
        },
        complete: function () {
            setTimeout(() => {
                updateSesstionTime()
            }, 120000);
        }
    });
}


let paginateBtn = function (num, funcName) {
    let btn = '<button class="btn-outline-primary paginate_btn bg-white" onclick="'+funcName+'('+num+')">' +
        num +
    '</button>'

    return btn;
}

let activePaginateBtn = function (num, funcName) {
    let btn = '<button class="bg-info btn-outline-primary disabled paginate_btn" disabled onclick="'+funcName+'('+num+')">' +
        num +
    '</button>'

    return btn;
}

let nextPaginateBtn = function(num, funcName, maxPage) {
    let disabled = "";
    let outline = "btn-outline-primary";

    if (num  > maxPage) {
        disabled = "disabled";
        outline = "bg-info btn-outline-primary disabled";
    } else {
        outline = "bg-white"
    }
    
    let btn = '<button class="'+outline+' paginate_btn paginate_btn_next" '+disabled+' onclick="'+funcName+'('+num+')">' +
        '<span class="fas fa-angle-right"></span>' +
    '</button>'

    return btn;
}

let prevPaginateBtn = function(num, funcName) {
    let disabled = "";
    let outline = "btn-outline-primary";

    if (num == 0) {
        disabled = "disabled";
        outline = "bg-info btn-outline-primary disabled";
    } else {
        outline = "bg-white"
    }
    
    let btn = '<button class="'+outline+' paginate_btn paginate_btn_prev" '+disabled+' onclick="'+funcName+'('+num+')">' +
        '<span class="fas fa-angle-left"></span>' +
    '</button>'

    return btn;
}


function displayPagination(elementId, currentPage, funcName, totalPages)
{
    let screenWidth = screen.width;
    let toNum = 0;
    // screenWidth = screenWidth.replace("px", "") / 1;
    
    if (screenWidth >= 769) {
        toNum = 3;
    } else {
        toNum = 1
    }


    if (totalPages > 1) {
        $('#' + elementId).append(prevPaginateBtn(currentPage - 1, funcName))
        for (let page = 1; page <= totalPages; page++) {
            if (page == currentPage) {
                $('#' + elementId).append(activePaginateBtn(page, funcName))
            } else if (page <= toNum || page >= (totalPages + 1) - toNum) {
                $('#' + elementId).append(paginateBtn(page, funcName))
            }
        }
        $('#' + elementId).append(nextPaginateBtn(currentPage + 1, funcName, totalPages))
    }
}

function isExist(array, value)
{
    let isExist = false;
    for (let i = 0; i < array.length; i++) {

        if (array[i] == value) {
            isExist = true;
            break;
        }

    }

    return isExist;
}

// function getCategories(type)
// {
//     $.ajax({
//         type: "GET",
//         url: "submits/categoriesRequests.php?action=getCategories",
//         data: {
//             'type' : type
//         },
//         dataType: "JSON",
//         beforeSend: function () { 
//             if (fetchCATEGORIESattempts == 0)
//             {
//                 showLoadingScreen();
//             }
//             fetchCATEGORIESattempts++;
//             CATEGORIES = [];
//         },
//         success: function (categories) {
            
//            setTimeout(() => {
//                 categories = categories.categories.split("|");

//                 categories.forEach(category => {
//                     CATEGORIES.push(category)
//                 });
                
//                 fetchCATEGORIESattempts = 0;

//                 hideLoadingScreen();
//            }, timeout);
//         },
//         error: function (err) {
//             setTimeout(() => {
//                 console.log(err);

//                 if (fetchCATEGORIESattempts <= 5) {
//                     getCategories(type)
//                 } else{
//                     fetchCATEGORIESattempts = 0;
//                     hideLoadingScreen();
//                 }
//             }, timeout);
//         },
//     });
// }

function formatDate(dateString) {
    // Create a new Date object from the input string
    const date = new Date(dateString);
    
    // Options for formatting
    const options = { year: 'numeric', month: 'long', day: 'numeric' };

    // Return the formatted date
    return date.toLocaleDateString('en-US', options);
}

function formatDateTime(dateTimeString) {
     // Create a new Date object from the input string
     const date = new Date(dateTimeString);
    
     // Options for formatting
     const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: `numeric` };
 
     // Return the formatted date
     return date.toLocaleDateString('en-US', options);
}

function calculateAge(birthDate) {
    const birth = new Date(birthDate);
    const today = new Date(currentDate);
    
    let ageInYears = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();
    
    // Adjust age if the birth date hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        ageInYears--;
    }

    // If the age is less than 1 year, calculate age in months
    if (ageInYears < 1) {
        let ageInMonths = (today.getFullYear() - birth.getFullYear()) * 12 + today.getMonth() - birth.getMonth();
        
        // If today's day is before the birthday day in the current month, subtract a month
        if (today.getDate() < birth.getDate()) {
            ageInMonths--;
        }
        
        return `${ageInMonths} mo`;  // Return age in months if under 1 year
    }
    
    // Return age in years if 1 year or more
    return `${ageInYears} yo`;
}
function ucwords(str) {
    return str.replace(/\b\w/g, function(char) {
      return char.toUpperCase();
    });
  }

function numberToWords(num) {
    if (num === 0) return "Zero";

    const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
    const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
    const thousands = ["", "Thousand", "Million", "Billion", "Trillion"];

    let words = "";
    let groupIndex = 0; // To track which power level (Thousand, Million, etc.)

    // Loop through each group of 3 digits (thousands, millions, etc.)
    while (num > 0) {
        if (num % 1000 !== 0) {
            words = convertHundreds(num % 1000) + (thousands[groupIndex] ? " " + thousands[groupIndex] : "") + (words ? " " + words : "");
        }
        num = Math.floor(num / 1000);
        groupIndex++;
    }

    return words.trim();

    function convertHundreds(num) {
        let result = "";

        if (num >= 100) {
            result += ones[Math.floor(num / 100)] + " Hundred ";
            num %= 100;
        }

        if (num >= 20) {
            result += tens[Math.floor(num / 10)] + " ";
            num %= 10;
        }

        if (num > 0) {
            result += ones[num] + " ";
        }

        return result.trim();
    }
}

function formatToPHP(number) {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(number);
}


updateSesstionTime()