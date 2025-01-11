let resolutionFormModal = document.getElementById('resolutionFormModal');
let resolutionFormModalBS = new bootstrap.Modal(resolutionFormModal);
let resolutionForm = document.getElementById('resolutionForm');

let deleteResolutionModal = document.getElementById('deleteResolutionModal')
let deleteResolutionModalBS = new bootstrap.Modal(deleteResolutionModal)

let pdfFile = null;

currentPage = 1;


// add resolution btn is clicked to open form
$('#addResolutionsBtn').click(function (e) { 
    e.preventDefault();

    resolutionFormModalBS.show()
    
});
// pdf file btn clicked
$('#insertPdfFileBtn').click(function (e) { 
    e.preventDefault();
    $('#pdfFile').click();
});
// when pdfFile is changed
$('#pdfFile').change(function (e) { 
    e.preventDefault();

    var file = e.target.files

    var fileName = file[0].name
    var fileNameExt = fileName.substring(fileName.lastIndexOf('.')+1, fileName.length)

    if (!(fileNameExt == "PDF" || fileNameExt == "pdf")) {
        displayMsg(2, "Not a PDF File")
        $(this).val("")
        $('#pdfFileDisplay').html("")
        pdfFile = null;
    } else {
        $('#pdfFileDisplay').html('<span class="fas fa-file-pdf"></span> ' + fileName + "." + fileNameExt)
        pdfFile = file;
    }
    
});
// when resolution and pdfFile is submit
$('#resolutionForm').submit(function (e) { 
    e.preventDefault();



    var formData = new FormData(document.getElementById('resolutionForm'));

    // var pdfFile = $('#pdfFile').prop('files')[0];
    // var form_data = new FormData();
    // form_data.append('file', pdfFile)

    // let data = {
    //     'resolutionId' : $('#resolutionId').val(),
    //     'resolutionTitle' : $('#resolutionTitle').val(),
    //     'resolutionNo' : $('#resolutionNo').val(),
    //     'yearSeries' : $('#yearSeries').val(),
    //     'dateApproved' : $('#dateApproved').val(),
    //     'approvedBy' : $('#approvedBy').val(),
    //     'authors' : $('#authors').val(),
    //     'pdfFile' : $('#pdfFile').prop('files')[0],
    //     'description' : $('#description').val()
    // }

    // let data = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "submits/resolutionsRequests.php?action=addNewResolution",
        data: formData,
        contentType: false, // Important for FormData
        processData: false, // Prevent jQuery from processing the data
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                console.log(response.stat)
                console.log(response.datas)
                displayMsg(response.status, response.msg)
                

                if (response.status == 3) {
                    resolutionFormModalBS.hide();
                    getResolutions(currentPage)
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

resolutionFormModal.addEventListener('hidden.bs.modal', function (e) { 
    resolutionForm.reset()
    $('#pdfFile').val("")
    $('#pdfFileDisplay').html("")
    $('#insertPdfFileBtnText').html('Insert PDF')
    pdfFile = null;
    $('#previewPdfFileBtn').addClass('d-none')
    $('#resolutionId').val("")
})

let resolutionCard = function (index, resolution) {
    let card = '' +
    '<div class="card pop_in_on_scroll">'+
        '<div class="card-header">' +
            '<h3 class="h3 text-uppercase">'+resolution.resolutionTitle+' NO.: '+resolution.resolutionNo + ' ' +
            '<small><i class="fs-5">Series of '+resolution.yearSeries+' </i></small></h3>' +
        '</div>' +
        '<div class="card-body">' +
            '<div>'+resolution.description+'</div>' +
            '<div class="row">' +
                '<div class="col-md p-3">' +
                    '<div class="text-muted"><small>Author: <i>'+resolution.authors+'</i></small></div>' +
                '</div>' +
                '<div class="col-md p-3">' +
                    '<div class="d-flex justify-content-end">' +
                        '<div class="text-muted"><small>Approved by: <i>'+resolution.approvedBy+'</i></small></div>' +
                    '</div>' +
                    '<div class="d-flex justify-content-end">' +
                        '<div class="text-muted"><small><i>'+resolution.dateApproved+'</i></small></div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="card-footer">' +
            '<div class="d-flex justify-content-end">' +
                '<button class="btn btn-info btn-sm mx-1" onclick="previewPDF(\''+resolution.pdfFile+'\')">' +
                    '<span class="fas fa-file-pdf"></span>' +
                '</button>' +
                '<button class="btn btn-primary btn-sm mx-1" onclick="editResolution('+resolution.id+')">' +
                    '<span class="fas fa-edit"></span>' +
                '</button>' +
                '<button class="btn btn-danger btn-sm mx-1" onclick="deleteResolution('+resolution.id+')">' +
                '<span class="fas fa-trash-alt"></span>' +
            '</button>' +
                
            '</div>' +
        '</div>' +
    '</div>';

    let cardContainer = '<div class="p-2">' + card + '</div>';

    return cardContainer;
}
// search resolution
$('#searchForm').submit(function (e) { 
    e.preventDefault();
    getResolutions(1);
});
// filter resolution
$('#filterCategoriesBtn').click(function (e) { 
    e.preventDefault();
    getResolutions(1)
});
// get resolution
function getResolutions(page)
{
    let data = {
        'year' : $('#seriesFilter').val(),
        'search' : $('#search').val(),
        'resolutionTitle': $('#resolutionTitleFilter').val(),
        'page': page,
        'limit': LIMIT
    }

    $.ajax({
        type: "GET",
        url: "submits/resolutionsRequests.php?action=getResolutions",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingContent("#resolutionsList")
            $('#resolutionsLinksTop').html("")
            $('#resolutionsLinksBot').html("")
        },
        success: function (response) {
            setTimeout(() => {
                $('#resolutionsList').html("")
                if (response.resolutions == null) {
                    displayContentMsg('#resolutionsList',"No Resolutions Found")
                } else if (response.resolutions.length >= 0) {
                    $.each(response.resolutions, function (index, resolution) { 
                         $('#resolutionsList').append(resolutionCard(index, resolution));
                    });

                    popInOnScroll()

                    currentPage = page

                    displayPagination("resolutionsLinksTop", currentPage, "paginateResolution", response.totalPages)
                    displayPagination("resolutionsLinksBot", currentPage, "paginateResolution", response.totalPages)
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayContentMsg('#resolutionsList', ERRMSG)
            }, timeout);
        }
    });
}
// paginateResolution
function paginateResolution(page) {
    getResolutions(page)
}

// previewPDF
function previewPDF(pdfFIle) {
    window.open("Media/pdf/" + pdfFIle, "_blank");
}
// edit Resolution
function editResolution(id) {
    $.ajax({
        type: "GET",
        url: "submits/resolutionsRequests.php?action=getResolution&id="+id,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                if (response == null) {
                    displayMsg(2, ERRMSG);
                } else {
                    $('#resolutionId').val(response.id);
                    $('#resolutionTitle').val(response.resolutionTitle)
                    $('#resolutionNo').val(response.resolutionNo)
                    $('#yearSeries').val(response.yearSeries)
                    $('#dateApproved').val(response.dateApproved)
                    $('#approvedBy').val(response.approvedBy)
                    $('#authors').val(response.authors)
                    $('#description').val(response.description)


                    
                    $('#insertPdfFileBtnText').html('Change PDF')
                    $('#pdfFileDisplay').html('<span class="fas fa-file-pdf"></span> ' + response.pdfFile)

                    $('#previewPdfFileBtn').removeClass('d-none')
                    $('#previewPdfFileBtn').val(response.pdfFile)


                    resolutionFormModalBS.show();
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
}
$('#previewPdfFileBtn').click(function (e) { 
    e.preventDefault();
    previewPDF($(this).val())
});

// delete Resolution
function deleteResolution(id) {
    $('#resolutionIdToDelete').val(id)
    deleteResolutionModalBS.show()
}
// when delete modal is hiddem
deleteResolutionModal.addEventListener('hidden.bs.modal', function () {
    $('#resolutionIdToDelete').val("")
})
// yes delete resolution button is clicked
$('#yesDeleteResolutionBtn').click(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/resolutionsRequests.php?action=deleteResolution",
        data: {
            'id' : $('#resolutionIdToDelete').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                if (response.status == 3) {
                    deleteResolutionModalBS.hide()
                    getResolutions(1)
                }
                displayMsg(response.status, response.msg)
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

getResolutions(currentPage);