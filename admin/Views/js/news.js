
let newsFormModal = document.getElementById('newsFormModal')
let newsFormModalBS = new bootstrap.Modal(newsFormModal);

let featureImageCropperModal = document.getElementById('featureImageCropperModal')
let featureImageCropperModalBS = new bootstrap.Modal(featureImageCropperModal)

let previewNewsModal = document.getElementById('previewNewsModal')
let previewNewsModalBS = new bootstrap.Modal(previewNewsModal)

let askDeleteNewsModal = document.getElementById('askDeleteNewsModal')
let askDeleteNewsModalBS = new bootstrap.Modal(askDeleteNewsModal)

let featureImageCropper = null;

let encryptedFeatureImg = null;

let currentPage = 1;



$(document).ready(function(){
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
// when news form modal is shown
newsFormModal.addEventListener('shown.bs.modal', function () {
    $('#postEditor').summernote({
        height: 400
    });

    
})
// close news form modal
$('#cancelNewsFormModalBtn, #xNewsFormModalBtn').click(function (e) { 
    e.preventDefault();
     $('#postEditor').summernote('code', '');
     $('#news_title').val('');
    destroyFeatureImageCropper();
    newsFormModalBS.hide()
    $('#news_id').val("")
    $('#image_feature').prop('src', "Media/images/" + WEB.brgy.toLowerCase().replaceAll(" ", "-") + ".png");

});

// open news form modal
$('#addNewNewsBtn').click(function (e) { 
    e.preventDefault();


    $.ajax({
        type: "GET",
        url: "submits/categoriesRequests.php?action=getCategories",
        data: {
            'type' : "news"
        },
        dataType: "JSON",
        beforeSend: function () { 
            if (fetchCATEGORIESattempts == 0)
            {
                showLoadingScreen();
            }
            fetchCATEGORIESattempts++;
            CATEGORIES = [];
        },
        success: function (categories) {
            
           setTimeout(() => {
                categories = categories.categories.split("|");

                categories.forEach(category => {
                    CATEGORIES.push(category)
                });
                
                fetchCATEGORIESattempts = 0;

                hideLoadingScreen();

                newsFormModalBS.show()

                $('#newsFormCategoriesContainer').html("")
                $.each(CATEGORIES, function (index, category) { 
                    $('#newsFormCategoriesContainer').append(
                        '<div class="col-md-4 p-2">' +
                        '<label for="cat_f'+category+'" class="cursor-pointer slide_in">' +
                            '<input type="checkbox" name="cat_f" id="cat_f'+category+'" value="'+category+'" class="form-check-input"> ' +
                                category +
                            '</label>' +
                ' </div>'
                    )
                });

           }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);

                if (fetchCATEGORIESattempts <= 5) {
                    getCategories(type)
                } else{
                    fetchCATEGORIESattempts = 0;
                    hideLoadingScreen();
                    displayMsg(1, ERRMSG)
                }
            }, timeout);
        },
    });
});
// publish news form modal
$('#postNewsBtn').click(function (e) { 
    e.preventDefault();

    let selectedCategories = [];

    $.each($('input[name="cat_f"]:checked'), function (index, cat) { 
        selectedCategories.push($(cat).val())
    });
    
    let data = {
        'id': $('#news_id').val(),
        'featureImage' : encryptedFeatureImg,
        'newsTitle': $('#news_title').val(),
        'newsContent' : $('#postEditor').summernote('code'),
        'categories': selectedCategories,
        'status': 2
    }


   
    saveNews(data, "saveNewNews");
    
    
});
// save to draft news form modal
$('#draftNewsBtn').click(function (e) { 
    e.preventDefault();

    e.preventDefault();

    let selectedCategories = [];

    $.each($('input[name="cat_f"]:checked'), function (index, cat) { 
        selectedCategories.push($(cat).val())
    });
    
    let data = {
        'id': $('#news_id').val(),
        'featureImage' : encryptedFeatureImg,
        'newsTitle': $('#news_title').val(),
        'newsContent' : $('#postEditor').summernote('code'),
        'categories': selectedCategories,
        'status': 1
    }
    saveNews(data, "saveNewNews");
    
});
// save news
function saveNews(data, action)
{
    $.ajax({
        type: "POST",
        url: "submits/newsRequests.php?action=" + action,
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)

                if (response.status == 3) {
                    $('#xNewsFormModalBtn').click()

                    getNews(currentPage)
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
}

// news card/content
let newsCard = function (index, news) { 

    if (news.featureImage == "") {
        news.featureImage = WEB.brgy.toLowerCase().replaceAll(" ", "-") + ".png";
    }

    news.featureImage += "?v=" + Math.round(Math.random() * 999999999);

    if (news.status == 2) {
        news.status = '<span class="badge bg-success">Published</span>';
    } else if (news.status == 1) {
        news.status = '<span class="badge bg-secondary">Draft</span>';
    }


    let card = '' +
    '<div class="custom_card_block p-2">'+
        '<div class="card pop_in_on_scroll w-100 custom_card">' +
            '<div class="card-header">' +
                '<img src="Media/images/'+news.featureImage+'" class="card-img-top" alt="'+news.newsTitle+'">' +
            '</div>' +
            '<div class="card-body position-relative">' +
                '<h5 class="card-title">'+news.newsTitle+'</h5>' +
                '<div class="d-block">' +
                    news.newsContent +
                '</div>' +
                '<div class="card-body-overlay"></div>' +
                '<div class="card-body-status">'+news.status+'</div>' +
            '</div>' +
            '<div class="card-footer d-flex justify-content-end">' +
                '<button class="mx-1 btn btn-primary btn-sm" onclick="previewNews('+news.id+')">' +
                    '<span class="fas fa-eye"></span> Preview' +
                '</button>' +
                '<button class="mx-1 btn btn-info btn-sm" onclick="editNews('+news.id+')">' +
                    '<span class="fas fa-edit"></span> Edit' +
                '</button>' +
                '<button class="mx-1 btn btn-danger btn-sm" onclick="deleteNews('+news.id+')">' +
                    '<span class="fas fa-trash-alt"></span> Delete' +
                '</button>' +
            '</div>' +
        '</div>' +
    '</div>'

    return card;
}

// search news
$('#searchForm').submit(function (e) { 
    e.preventDefault();
    $('input[name="cat_in"]:checked').prop('checked', false)
    getNews(1);
});
// filter news
$('#filterCategoriesBtn').click(function (e) { 
    e.preventDefault();

    let categoriesElem = $('input[name="cat_in"]:checked')
    let selectedCategories = [];

    $.each(categoriesElem, function (index, elem) { 
        selectedCategories.push($(elem).val())
    });

    $('#search').val("")


    if (selectedCategories.length <= 0) {
        getNews(1, null)
    } else {
        getNews(1, selectedCategories)
    }



});
// get news
function getNews(page, filter = null)
{
    let data = {
        'search': $('#search').val(),
        'page': page,
        'limit': CARD_BLOCK_LIMIT,
        'filter': filter
    }

    $.ajax({
        type: "POST",
        url: "submits/newsRequests.php?action=getNews",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingContent("#newsesList")
            $('#newsesLinksTop').html("")
            $('#newsesLinksBot').html("")
        },
        success: function (response) {
            setTimeout(() => {
                hideLoadingContent("#newsesList")
                currentPage = page
                // console.log(newses)

                
                if (response.news.length <= 0) {
                    displayContentMsg("#newsesList", "No news found.")
                } else {
                    $('#newsesList').html("")

                    $.each(response.news, function (index, news) { 
                       $('#newsesList').append(newsCard(index, news));
                    });

                    popInOnScroll()
                }

                displayPagination("newsesLinksTop", currentPage, "paginateNews", response.totalPages)
                displayPagination("newsesLinksBot", currentPage, "paginateNews", response.totalPages)
            }, timeout);
        },
        error: function (err) { 
            setTimeout(() => {
                console.log(err)
                displayContentMsg("#newsesList", ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
            }, timeout);
        }
    });
}
getNews(currentPage); // get news

// paginate news
function paginateNews(page) {
    getNews(page)
}


// destroy cropper
function destroyFeatureImageCropper()
{
    if (featureImageCropper != null ) {
        featureImageCropper.destroy();
        featureImageCropper = null;
        featureImageCropper = null;
    }
}

$('#setFeatureImgBtn').click(function (e) { 
    e.preventDefault();

   $('#feature_image_file').val("")
   $('#feature_image_file').click()
    
});

$('#feature_image_file').change(function (e) { 
    e.preventDefault();

    encryptedFeatureImg = null;

    destroyFeatureImageCropper();

    let image = document.getElementById("imageFeature")

    let acceptableExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG']

    var file = e.target.files

    var fileName = file[0].name
    var fileNameExt = fileName.substring(fileName.lastIndexOf('.')+1, fileName.length)


    if (!isExist(acceptableExtensions, fileNameExt)) {

        var err = {
            'status': 'File not supported!',
            'statusText': 'Only images with jpg, jpeg, or png extensions are acceptable.'
        }
        displayMsg(2, err.status + " " + err.statusText)
        
    } else {
        var done = function(url) {
            image.src = url
            featureImageCropperModalBS.show()
        }

        if (file && file.length > 0) {
            reader = new FileReader()
            reader.onload = function (e) {
                done(reader.result)
            }
            reader.readAsDataURL(file[0])
        }
    }
   
    
});

featureImageCropperModal.addEventListener('shown.bs.modal', function () {
    destroyFeatureImageCropper()

    featureImageCropper = new Cropper(imageFeature, {
        aspectRatio: 1,
        viewMode: 2,
        preview: '.feature_image_preview'
    });
})

featureImageCropperModal.addEventListener('hidden.bs.modal', function () {
    if (featureImageCropper != null) {


        try {
            canvas = featureImageCropper.getCroppedCanvas({
                width: 500,
                height: 500
            })
            canvas.toBlob(function (blob) {
                var reader = new FileReader();
                reader.readAsDataURL(blob)
                reader.onload = function () {
                    encryptedFeatureImg = reader.result
                }
            })
        } catch(error) {

            var err = {
                'status': ERRMSG,
                'statusText': "Please contact the developer if this message occurs."
            }

            displayMsg(1, err.status + " " + err.statusText);

        }
    }
})




// categories
$('#addCategoryBtn').click(function (e) { 
    e.preventDefault();
    
    $('#addNewCategoryCol').removeClass('d-none')
});

$('#cancelAddCategoryBtn').click(function (e) { 
    e.preventDefault();
    $('#new_cateory').val("")
    $('#addNewCategoryCol').addClass('d-none')
});

$('#saveNewCategoryBtn').click(function (e) { 
    e.preventDefault();

    let data = {
        'type': "news",
        'category': $('#new_cateory').val()
    }
    
    $.ajax({
        type: "POST",
        url: "submits/categoriesRequests.php?action=saveNewsCategory",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {

                if (response.status == 3) {
                    $('#new_cateory').val("")


                    $('#addNewCategoryCol').before(
                        '<div class="col-md-3 p-2" id="'+data.category+'Col">' +
                            '<label for="cat_in_'+data.category+'" class="cursor-pointer slide_in">' +
                                '<input type="checkbox" name="cat_in" id="cat_in_'+data.category+'" value="'+data.category+'" class="form-check-input"> ' +
                                    data.category +
                                '</label>' +
                       ' </div>'
                    )



                    $('#addNewCategoryCol').addClass('d-none')

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

$('#deleteCategoriesBtn').click(function (e) { 
    e.preventDefault();
    
    let selectedCategories = []
    $.each($('input[name="cat_in"]:checked'), function (index, cat) { 
        selectedCategories.push($(cat).val())
    });

    let data = {
        'type' : 'news',
        'categories' : selectedCategories
    }

    $.ajax({
        type: "POST",
        url: "submits/categoriesRequests.php?action=deleteCategories",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg)

                if (response.status == 3) {
                    $.each(data.categories, function (index, category) { 
                         $(document).find('#' + category + "Col").addClass('fade_out')
                         setTimeout(() => {
                            $(document).find('#' + category + "Col").remove()
                         }, timeout);
                    });
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                displayMsg(1, ERRMSG);
                console.log(err)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});





// prevew News
function previewNews(id) {
    $.ajax({
        type: "GET",
        url: "submits/newsRequests.php?action=getSingleNews&id="+id,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
            $('#newsTitlePreview').text("");
            $('#categoriesListPreview').html("")
            $('#newsIdPreview').val("")
        },
        success: function (news) {
            setTimeout(() => {
                previewNewsModalBS.show()
    
                

                $('#newsTitlePreview').text(news.newsTitle);

                if (news.featureImage == "") {
                    $('#featureImagePreview').prop('src', "Media/images/" + WEB.brgy.toLowerCase().replaceAll(" ", "-") + ".png?v=" + "" + Math.round(Math.random() * 9999));
                    $('#featureImagePreview').prop('alt', news.newsTitle);
                } else {
                    $('#featureImagePreview').prop('src', "Media/images/" + news.featureImage + "?v=" + Math.round(Math.random() * 9999));
                    $('#featureImagePreview').prop('alt', news.newsTitle);
                }

                
                if (!(news.categories == "" || news.categories == null)) {
                    $.each(news.categories.split("|"), function (index, category) { 
                        if (!(category == "" || category == null)) {
                           $('#categoriesListPreview').append('<li>'+category+'</li>')
                        }
                    });
                }
                

                $('#newsContentPreview').html(news.newsContent);

                $('#newsDatesPreview').html("Date saved: " + news.dateSaved + "&emsp; ---- &emsp;" + "Date published: " + news.datePublished);

                $('#newsIdPreview').val(news.id)

                
                if (news.status == 2) {
                    $('#newsStatusPreview').html('<span  class="badge bg-success">Published</span >')
                } else if (news.status == 1) {
                    $('#newsStatusPreview').html('<span  class="badge bg-secondary">Draft</span >')
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

// edit news preview btn click
$('#previewEditBtn').click(function (e) { 
    e.preventDefault();
    previewNewsModalBS.hide()
    editNews($('#newsIdPreview').val())
});
// edit news
function editNews(id) {
    $.ajax({
        type: "GET",
        url: "submits/newsRequests.php?action=getSingleNewsWithCategories&id="+id,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
            
        },
        success: function (response) {
            setTimeout(() => {
    
                let news = response.news
                
                $('#news_id').val(news.id)

                $('#news_title').val(news.newsTitle);

                if (news.featureImage == "") {
                    $('#image_feature').prop('src', "Media/images/" + WEB.brgy.toLowerCase().replaceAll(" ", "-") + ".png" + "?v=" + Math.round(Math.random() * 99999999));
                } else {
                    $('#image_feature').prop('src', "Media/images/" + news.featureImage + "?v=" + Math.round(Math.random() * 99999999));
                }

                let checkedCategories = [];

                if (!(news.categories == "" || news.categories == null)) {
                    $.each(news.categories.split("|"), function (index, category) { 
                        if (!(category == "" || category == null)) {
                            checkedCategories.push(category);
                        }
                    });
                }



                let categories = response.categories.categories.split("|");
                CATEGORIES = [];
                categories.forEach(category => {
                    CATEGORIES.push(category)
                });



                $('#newsFormCategoriesContainer').html("")
                $.each(CATEGORIES, function (index, category) { 

                    let checked;

                    if (isExist(checkedCategories, category)) {
                        checked = " checked";
                    } else {
                        checked = "";
                    }
                    
                    $('#newsFormCategoriesContainer').append(
                        '<div class="col-md-4 p-2">' +
                        '<label for="cat_f'+category+'" class="cursor-pointer slide_in">' +
                            '<input type="checkbox" name="cat_f" id="cat_f'+category+'" value="'+category+'" class="form-check-input"'+checked+'> ' +
                                category +
                            '</label>' +
                    ' </div>'
                    )
                });

                
                // if (!(news.categories == "" || news.categories == null)) {
                //     $.each(news.categories.split("|"), function (index, category) { 
                //         if (!(category == "" || category == null)) {
                //            $('#categoriesListPreview').append('<li>'+category+'</li>')
                //         }
                //     });
                // }
                

                $('#postEditor').summernote('code', news.newsContent);

                // $('#newsDatesPreview').html("Date saved: " + news.dateSaved + "&emsp; ---- &emsp;" + "Date published: " + news.datePublished);


                newsFormModalBS.show()

               
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

// delete news preview btn click
$('#previewDeleteBtn').click(function (e) { 
    e.preventDefault();
    previewNewsModalBS.hide()
    deleteNews($('#newsIdPreview').val())
});
// delete news
function deleteNews(id) {
    askDeleteNewsModalBS.show()
    $('#newsIdToDelete').val(id);
}
// yes delete news on click
$('#yesDeleteNews').click(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/newsRequests.php?action=deleteNews",
        data: {
            'id' : $('#newsIdToDelete').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
            askDeleteNewsModalBS.hide()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                getNews(1)
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
//  when askDeleteNewsModal is hidden
askDeleteNewsModal.addEventListener('hidden.bs.modal', function () { 
    $('#newsIdToDelete').val("")
})