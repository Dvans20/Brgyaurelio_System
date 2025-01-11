

let transparencyDocumentFormModal = document.getElementById('transparencyDocumentFormModal')
let transparencyDocumentFormModalBS = new bootstrap.Modal(transparencyDocumentFormModal)
let transparencyDocumentForm = document.getElementById('transparencyDocumentForm')

let deleteTransparencyModal = document.getElementById('deleteTransparencyModal')
let deleteTransparencyModalBS = new bootstrap.Modal(deleteTransparencyModal)

let currentPage = 1;



// document type content template
let documentTypeContent = function (index, documentType) {
    let content = '' +
    '<div class=" alert alert-info p-1 mx-0 my-1 d-flex slide_in" id="documentTypeContent'+documentType.id+'">' + 
        '<div class="w-100">'+documentType.name+'</div>' +
        '<div class="d-flex justify-content-end">' +
            '<button class="btn btn-sm btn-cursor p-0 text-primary" onclick="editDocumentType('+documentType.id+', \''+documentType.name+'\')">'+
                '<span class="fas fa-edit"></span>'+
            '</button>' +
            '<button class="btn btn-sm btn-cursor p-0 text-danger" onclick="deleteDocumentType('+documentType.id+')">'+
                '<span class="fas fa-trash-alt"></span>'+
            '</button>' +
        '</div>' +
    '</div>' 

    return content;
}

// show add document type form when clicked
$('#addDocumentTypeBtn').click(function (e) { 
    e.preventDefault();
    $('#addDocumentTypeForm').removeClass('d-none');
});
// hide add document type form when clicked
$('#cancelAddDocumentTypeBtn').click(function (e) { 
    e.preventDefault();
    $('#addDocumentTypeForm').addClass('d-none');
    $('#documentTypeName').val("");
    $('#documentTypeId').val("");
});
// submit document type
$('#addDocumentType').submit(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "submits/documentTypesRequests.php?action=newDocumentType",
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                // console.log(response);

                displayMsg(response.status, response.msg);

                if (response.status == 3) {
                    $('#documentTypeName').val("")
                    $('#documentTypeId').val("")
                    $('#addDocumentTypeForm').addClass('d-none');
                    getDocumentTypes();
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
// search document type
$('#documentTypeSearchForm').submit(function (e) { 
    e.preventDefault();
    getDocumentTypes()
});
// get document Types
function getDocumentTypes() {  
    let data = {
        'search' : $('#documentTypeSearch').val()
    }
    $.ajax({
        type: "GET",
        url: "submits/documentTypesRequests.php?action=getDocumentTypes",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingContent('#documentTypesList')
        },
        success: function (documentTypes) {
            setTimeout(() => {
                $('#documentTypesList').html("");
                $('#documentTypeFilter').html("");
                $('#documentTypeFilter').append('<option value="">Select document type</option>');

                $('#documentType').html("");
                $('#documentType').append('<option value="">Select document type</option>');

                if (documentTypes == null) {
                    displayContentMsg("#documentTypesList", "No Document Types Found.")
                } else {
                    $.each(documentTypes, function (index, documentType) { 
                        $('#documentTypesList').append(documentTypeContent(index, documentType));
                        $('#documentTypeFilter').append('<option value="'+documentType.id+'">'+documentType.name+'</option>');
                        $('#documentType').append('<option value="'+documentType.id+'">'+documentType.name+'</option>');
                    });
                }
               
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayContentMsg("#documentTypesList", ERRMSG)
            }, timeout);
        }
    });
}
getDocumentTypes()

function editDocumentType(id, name) {
    displayMsg(2, "<b>Warning!</b> Changing the name of the Document Type will also change the document types of it's documents.");

    $('#documentTypeId').val(id)
    $('#documentTypeName').val(name)
    $('#addDocumentTypeForm').removeClass('d-none');
}
function deleteDocumentType(id) {
    $.ajax({
        type: "POST",
        url: "submits/documentTypesRequests.php?action=deleteDocumentType",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () { 
            $('#documentTypesList')
            showLoadingContent('#documentTypesList')
        },
        success: function (response) {
            setTimeout(() => {
                // getDocumentTypes();
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
                getDocumentTypes();
            }, timeout);
        }
    });
}




// when add document transparency button is clicked [open form modal]
$('#addTransparencyBtn').click(function (e) { 
    e.preventDefault();
    transparencyDocumentFormModalBS.show();
});
// when pdfFile is changed
$('#pdfFile').change(function (e) { 
    e.preventDefault();

    var file = e.target.files

    if (file.length > 0) {
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
    } else {
        $('#pdfFileDisplay').html("")
    }
    
});
// when form modal is hidden
transparencyDocumentFormModal.addEventListener('hidden.bs.modal', function () {
    transparencyDocumentForm.reset();
    $('#id').val("")
    $('#pdfFileDisplay').html("")
    $('#selectPdfFileBtnText').html('Select File')
    $('#preiviewPdfFileBtn').addClass('d-none');
    $('#preiviewPdfFileBtn').val('');

})
// submit transparency document
$('#transparencyDocumentForm').submit(function (e) { 
    e.preventDefault();

    var formData = new FormData(document.getElementById('transparencyDocumentForm'));

    // console.log(formData);
    
    $.ajax({
        type: "POST",
        url: "submits/transparenciesRequests.php?action=saveTransparency",
        data: formData,
        contentType: false, // Important for FormData
        processData: false, // Prevent jQuery from processing the data
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                // console.log(response)
                displayMsg(response.status, response.msg)

                if (response.status == 3) {
                    transparencyDocumentFormModalBS.hide();
                    getTransparencies(1)
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
});






let transparencyDocumentRow = function (index, transparency, documentTypes) {

    let exts = ['1<sup>st</sup>', '2<sup>nd</sup>', '3<sup>rd</sup>', '4<sup>th</sup>'];

    if (transparency.quarter != 5) {
        transparency.quarter = "[" + exts[transparency.quarter-1] +"qtr.]";
    } else {
        transparency.quarter = "";
    }

    let documentType = "";

    if (documentTypes != null) {
        if (documentTypes.length > 0) {
            $.each(documentTypes, function (i, dt) { 
                if (dt.id == transparency.documentType) {
                    documentType = dt.name;
                }
            });
        }
    }
    

    let noCol = '<td class="text-center">'+(index + 1)+'</td>';
    let docTitleCol = '<td class="text-start">'+transparency.documentTitle+'</td>';
    let detailsCol = '<td class="text-start">Type: '+ documentType + '<br>Year: '+transparency.calendarYear+ ' ' +transparency.quarter+ '</td>';

    let = pdfBtn = '<a href="Media/pdf/'+transparency.pdfFile+'" target="_blank" class="btn btn-info btn-sm p-1 mx-1"><span class="fas fa-file-pdf"></span></a>';

    let = editBtn = '<button class="btn btn-primary btn-sm p-1 mx-1" onclick="editTransparency('+transparency.id+')"><span class="fas fa-edit"></span></button>';

    let = deleteBtn = '<button class="btn btn-danger btn-sm p-1 mx-1" onclick="deleteTransparency('+transparency.id+')"><span class="fas fa-trash-alt"></span></button>';

    let btnsCol = '<td><div class="d-flex justify-content-end">'+pdfBtn+editBtn+deleteBtn+'</div></td>';

    let documentRow = '<tr class="slide_in">'+noCol+docTitleCol+detailsCol+btnsCol+'</tr>';

    return documentRow;
}


// search Transparencies
$('#searchBtn').click(function (e) { 
    e.preventDefault();
    getTransparencies(1)
});
// filter Transparencies
$('#filterBtn').click(function (e) { 
    e.preventDefault();
    getTransparencies(1)
});
// get Transparencies
function getTransparencies(page) {

    let data = {
        'page' : page,
        'limit' : LIMIT,
        'search' : $('#search').val(),
        'documentType' : $('#documentTypeFilter').val(),
        'calendarYear' : $('#yearFilter').val(),
        'quarter' : $('#quarterFilter').val()
    }

    $.ajax({
        type: "GET",
        url: "submits/transparenciesRequests.php?action=getTransparencies",
        data: data,
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingTableContent('#transparenciesList', 5);
            $('#transparenciesLinks').html("")
        },
        success: function (response) {
            setTimeout(() => {
                currentPage = page;
                $('#transparenciesList').html("")
                if (response.transparencies == null) {
                    displayTableMsg('transparenciesList', 5, ERRMSG)
                } else if (response.transparencies.length <= 0) {
                    displayTableMsg('transparenciesList', 5, "No Documents Found.")
                } else {
                    $.each(response.transparencies, function (index, transparency) { 
                         $('#transparenciesList').append(transparencyDocumentRow(index, transparency, response.documentTypes));
                    });

                    displayPagination('transparenciesLinks', currentPage, "getTransparencies", response.totalPages);
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg('transparenciesList', 5, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }
    });
}
getTransparencies(currentPage);





// when edit transparency button is clicked fetche transparency data
// and show edit form modal
function editTransparency(id) {
    
    $.ajax({
        type: "GET",
        url: "submits/transparenciesRequests.php?action=getTransparency&id=" + id,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (transparency) {
            setTimeout(() => {
                $('#id').val(transparency.id);
                $('#documentTitle').val(transparency.documentTitle);
                $('#documentType').val(transparency.documentType);
                $('#year').val(transparency.calendarYear);
                $('#quarter').val(transparency.quarter);
                $('#pdfFileDisplay').html(transparency.pdfFile);

                $('#selectPdfFileBtnText').html('Change File')
                $('#preiviewPdfFileBtn').removeClass('d-none');
                $('#preiviewPdfFileBtn').val(transparency.pdfFile);

                transparencyDocumentFormModalBS.show();
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
                hideLoadingScreen()
            }, timeout);
        }
    });
}
// preview pdf file on form when clicked
$('#preiviewPdfFileBtn').click(function (e) { 
    e.preventDefault();
    window.open('Media/pdf/' + $(this).val(), '_blank');
});


// when delete transparency button is clicked show ask question to delete modal
function deleteTransparency(id) {
    $('#transparencyIdToDelete').val(id)
    deleteTransparencyModalBS.show()
}
// when delete transparency modal is hidden
deleteTransparencyModal.addEventListener('hidden.bs.modal', function () {
    $('#transparencyIdToDelete').val("")
})
// delete transparency when yes is clicked
$('#yesDeleteTransparency').click(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/transparenciesRequests.php?action=deleteTransparency",
        data: {
            'id' : $('#transparencyIdToDelete').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            deleteTransparencyModalBS.hide();
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                getTransparencies(1);
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
});