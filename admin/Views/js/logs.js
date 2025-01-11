let currentPage = 1;

let logsRow = (index, log) => {
    

    let noCol = '<td class="text-center">'+ (index + 1) +'</td>';
    let nameCol = '<td class="">'+ log.userInfo +'</td>';
    let descriptionCol = '<td class="">'+ log.actionDescription +'</td>';
    let browserCol = '<td class="">'+ log.device.browser +'</td>';
    let osCol = '<td class="">'+ log.device.os +'</td>';
    let dateTimeCol = '<td class="">'+ log.dateTime +'</td>';

    let row = '<tr class="slide_in">'+noCol+nameCol+descriptionCol+browserCol+osCol+dateTimeCol+'</tr>';

    return row
}

function paginateLogs(page) {
    getLogs(page)
}

function getLogs(page)
{
    let data = {
        'page' : page,
        'limit' : LIMIT,
        'search' : $('#search').val(),
        'dateTimeFrom' : $('#dateTimeFrom').val(),
        'dateTimeTo' : $('#dateTimeTo').val(),
    }

    $.ajax({
        type: "GET",
        url: "submits/logsRequests.php?action=get",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent("#logsList", 7)
            $('#logsLinks').html("")
        },
        success: function (response) {
            setTimeout(() => {
                
                $('#logsList').html("")

                if (response.logs == null) {
                    displayTableMsg("logsList", 7, "No Activities Found");
                } else if (response.logs.length < 1) {
                    displayTableMsg("logsList", 7, "No Activities Found");
                } else {
                    $.each(response.logs, function (index, log) { 
                        $('#logsList').append(logsRow(index, log));
                    }); 


                }

                currentPage = page

                displayPagination("logsLinks", page, "paginateLogs", response.totalPages);


            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg("logsList", 7, "Something went wrong")
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }
    });
}

$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getLogs(1)
});

getLogs(currentPage)