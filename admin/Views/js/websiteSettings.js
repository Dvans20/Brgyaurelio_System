let getAttempt = 0;
let updateAttempt = 0;

let logoImageCropperModal = document.getElementById('logoImageCropperModal');
let logoImageCropperModalBS = new bootstrap.Modal(logoImageCropperModal);

let editAboutPageModal = document.getElementById('editAboutPageModal');
let editAboutPageModalBS = new bootstrap.Modal(editAboutPageModal);

let homeCoverImageCropperModal = document.getElementById('homeCoverImageCropperModal');
let homeCoverImageCropperModalBS = new bootstrap.Modal(homeCoverImageCropperModal);

let coverImagesCropperModal = document.getElementById('coverImagesCropperModal');
let coverImagesCropperModalBS = new bootstrap.Modal(coverImagesCropperModal);

let siteUrlIn;

let brgyInfos;

let embeddedMap;


let siteLogoCropper = null;

let homeCoverImageCropper = null;

let coverImageCropper = null;

$(document).ready(function(){
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});

function getWebSetting() { 

    $.ajax({
        type: "Get",
        url: "submits/webSettingRequests.php?action=get",
        dataType: "JSON",
        beforeSend: function () {
            if (getAttempt == 0) {
                showLoadingContent(".web_setting_cont")
            }
        },
        success: function (webSetting) {
            setTimeout(() => {
                getAttempt = 0
                console.log(webSetting.about)
                // about
                $('#aboutText').html(webSetting.about)
                $('#aboutTextArea').val(webSetting.about.replaceAll("<br />", ""))

                $('#site_url').val(webSetting.siteUrl)

                $('#brgy').val(webSetting.brgy)
                $('#contact_no').val(webSetting.contactNo)
                $('#email').val(webSetting.email)
                $('#address').val(webSetting.address)
                $('#tagline').val(webSetting.tagline)
                

                $('#embedded_map').val(webSetting.embeddedMap)
                $('#embeddedMapDisplayContainer').html(webSetting.embeddedMap)

                $('#purokist').html("")
                $.each(webSetting.puroks, function (index, purok) { 
                    $('#purokist').append('<li class="d-flex alert alert-info my-1 mx-0 slide_in">' +
                        '<div class="w-100 text-nowrap">'+purok+'</div>' +
                        '<div class="d-flex justify-content-end w-100">' +
                            '<button class="btn p-0 m-0 text-danger" onclick="deletePurok(\''+purok+'\')">' +
                                '<span class="fas fa-trash-alt"></span>' +
                            '</button>' +
                        '</div>' +
                    '</li>');
                });

                $('#brgySecretaryName').val(webSetting.brgySecretaryName);
                $('#brgyTreasurerName').val(webSetting.brgyTreasurerName);
                $('#brgyCaptainName').val(webSetting.brgyCaptainName);
                $('#skChairmanName').val(webSetting.skChairmanName);

                // console.log(webSetting)
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                if (getAttempt > 3) {
                    getAttempt = 0;
                    $('.web_setting_cont').html('<div class="shake_in my-5 py-5 text-center text-muted">Something went wrong.</div>')
                } else {
                    getWebSetting();
                    getAttempt++;
                }
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingContent('.web_setting_cont')
            }, timeout);
        }
    });
}

// about
$('#editAbout').click(function (e) { 
    e.preventDefault();
    

    $('#aboutText').addClass('d-none')
    $('#aboutTextArea').removeClass('d-none')
    
    $('#onEditFooter').removeClass('d-none')
    $('#toEditFooter').addClass('d-none')
});

$('#cancelEditAbout').click(function (e) { 
    e.preventDefault();
    
    $('#aboutText').removeClass('d-none')
    $('#aboutTextArea').addClass('d-none')
    
    $('#onEditFooter').addClass('d-none')
    $('#toEditFooter').removeClass('d-none')

    $('#aboutTextArea').val($('#aboutText').text())
});

$('#updateAbout').click(function (e) { 
    e.preventDefault();

    let data = {
        'about' : $('#aboutTextArea').val()
    }

    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=updateAbout",
        data: data,
        dataType: "JSON",
        beforeSend: function () {

            $('#aboutLoadingCont').removeClass('d-none')

            $('#aboutTextArea').prop('disabled', true)
            $('#onEditFooter button').prop('disabled', true)
            showLoadingContent("#aboutLoadingCont")

        },
        success: function (response) {
            setTimeout(() => {


                displayMsg(response.status, response.msg)

                if (response.status == 3) {
                    $('#aboutText').html(response.webSetting.about)
                    $('#aboutTextArea').val(response.webSetting.about.replaceAll("<br />", ""))

                    $('#cancelEditAbout').click();
                }
            }, timeout + 300);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
                displayMsg(1, "Something Went Wrong.")

            }, timeout);
        },
        complete: function () {
            setTimeout(() => {

                hideLoadingContent('#aboutLoadingCont')
                $('#aboutLoadingCont').addClass('d-none')
                $('#aboutTextArea').removeAttr('disabled')
                $('#onEditFooter button').prop('disabled', false)
            
            }, timeout);
        }
    });
    
});


// logo
$('#logoImgBtn').click(function (e) { 
    e.preventDefault();
    
    $('#site_logo_in').click();
});

$('#site_logo_in').change(function (e) { 
    e.preventDefault();
    
    if (siteLogoCropper != null) {
        destroyLogoCropper()
    }


    let image = document.getElementById("imageLogo")

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
            logoImageCropperModalBS.show()
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

logoImageCropperModal.addEventListener('shown.bs.modal', function (e) {

    destroyLogoCropper()

    siteLogoCropper = new Cropper(imageLogo, {
        aspectRatio: 1,
        viewMode: 2,
        // preview: '.logo_image_preview'
    });

    // $('#logoImage').addClass('d-none');
})

logoImageCropperModal.addEventListener('hidden.bs.modal', function () { 

    destroyLogoCropper()

    $('#site_logo_in').val("");

 })

function destroyLogoCropper()
{
    if (siteLogoCropper != null ) {
        siteLogoCropper.destroy();
        siteLogoCropper = null;
        siteLogoCropper = null;
    }
}

$('#cropSaveSiteImage').click(function (e) { 
    e.preventDefault();

    if (siteLogoCropper != null) {
        try {
            canvas = siteLogoCropper.getCroppedCanvas({
                width: 300,
                height: 300
            })


            canvas.toBlob(function (blob) {
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onload = function () {
                    let encryptedLogo = reader.result

                    $.ajax({
                        type: "POST",
                        url: "submits/webSettingRequests.php?action=updateSiteLogo",
                        data: {
                            'image' : encryptedLogo
                        },
                        dataType: "JSON",
                        beforeSend: function () {
                            showLoadingScreen()
                        },
                        success: function (response) {
                            setTimeout(() => {

                                
                                displayMsg(3, response.msg)

                                $('#logoImage').attr('src', 'Media/images/'+response.logo+'?v=' + Math.random())
                                
                            }, timeout);
                        },
                        error: function (err) {
                            setTimeout(() => {
                                displayMsg(1, err.responseText)
                            }, timeout);
                        },
                        complete: function () {
                            setTimeout(() => {
                                hideLoadingScreen()
                                logoImageCropperModalBS.hide()
                            }, timeout);
                        }
                    });
                }
            })

        } catch (error) {
            var err = {
                'status': "Something went wrong!",
                'statusText': "Please contact the developer if this message occurs."
            }

            displayMsg(1, err.status + " " + err.statusText);

            logoImageCropperModalBS.hide();

        }
    }
    
});


// url
$('#editSiteUrlBtn').click(function (e) { 
    e.preventDefault();

    $(this).addClass('d-none')
    $('#saveSiteUrlBtn').removeClass('d-none')
    $('#cancelSiteUrlBtn').removeClass('d-none')

    $('#site_url').prop('disabled', false)

    siteUrlIn = $('#site_url').val()
    
});

$('#cancelSiteUrlBtn').click(function (e) { 
    e.preventDefault();
    
    $('#site_url').val(siteUrlIn)

    $('#editSiteUrlBtn').removeClass('d-none')
    $('#saveSiteUrlBtn').addClass('d-none')
    $('#cancelSiteUrlBtn').addClass('d-none')

    $('#site_url').prop('disabled', true)

});

$('#saveSiteUrlBtn').click(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=updateSiteUrl",
        data: {
            'siteUrl' : $('#site_url').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {

                siteUrlIn = $('#site_url').val()

                $('#editSiteUrlBtn').removeClass('d-none')
                $('#saveSiteUrlBtn').addClass('d-none')
                $('#cancelSiteUrlBtn').addClass('d-none')
            
                $('#site_url').prop('disabled', true)
                displayMsg(3, response.msg)

            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                displayMsg(1, err.responseText)
            }, timeout);
        },
        complete:function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});


// info
$('#editContactInfoBtn').click(function (e) { 
    e.preventDefault();

    $(this).addClass('d-none')
    $('#saveContactInfoBtn').removeClass('d-none')
    $('#cancelContactInfoBtn').removeClass('d-none')

    $('#brgyInfoForm input').prop('disabled', false);

    brgyInfos = {
        brgy: $('#brgy').val(),
        address: $('#address').val(),
        contact_no: $('#contact_no').val(),
        email: $('#email').val(),
        tagline: $('#tagline').val(),
    }
    
});

$('#cancelContactInfoBtn').click(function (e) { 
    e.preventDefault();

    $('#editContactInfoBtn').removeClass('d-none')
    $('#saveContactInfoBtn').addClass('d-none')
    $('#cancelContactInfoBtn').addClass('d-none')

    $('#brgy').val(brgyInfos.brgy)
    $('#address').val(brgyInfos.address)
    $('#contact_no').val(brgyInfos.contact_no)
    $('#email').val(brgyInfos.email)
    $('#tagline').val(brgyInfos.tagline)

    $('#brgyInfoForm input').prop('disabled', true);

});

$('#saveContactInfoBtn').click(function (e) { 
    e.preventDefault();
    
    $('#brgyInfoForm').submit();
    
});

$('#brgyInfoForm').submit(function (e) { 
    e.preventDefault();
    

    let data = {
        'brgy': $('#brgy').val(),
        'address': $('#address').val(),
        'contact_no': $('#contact_no').val(),
        'email': $('#email').val(),
        'tagline': $('#tagline').val(),
    }

    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=updateBrgyInfo",
        data: data,
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {

                displayMsg(response.status, response.msg);

                if (response.status == 3)
                {
                    $('#editContactInfoBtn').removeClass('d-none')
                    $('#saveContactInfoBtn').addClass('d-none')
                    $('#cancelContactInfoBtn').addClass('d-none')

                    $('#brgyInfoForm input').prop('disabled', true);

                }
                
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                displayMsg(1, err.responseText)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
});

$('#addPurokBtn').click(function (e) { 
    e.preventDefault();
    $('#purokInputContainer').removeClass('d-none')

    let purokCardBody = document.getElementById('purokistCardBody')
    purokCardBody.scrollTop = purokCardBody.scrollHeight;
});

$('#cancelAddPurokBtn').click(function (e) { 
    e.preventDefault();
    $('#purokInputContainer').addClass('d-none')
    $('#purok').val("")
});

$('#savePurokBtn').click(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=addPurok",
        data: {
            'purok' : $('#purok').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                
                displayMsg(response.status, response.msg);
                
                if (response.status == 3) {
                    $('#cancelAddPurokBtn').click()
                    $('#purokist').html("")
                    $.each(response.puroks, function (index, purok) { 
                        $('#purokist').append('<li class="d-flex alert alert-info my-1 mx-0 slide_in">' +
                            '<div class="w-100 text-nowrap">'+purok+'</div>' +
                            '<div class="d-flex justify-content-end w-100">' +
                                '<button class="btn p-0 m-0 text-danger" onclick="deletePurok(\''+purok+'\')">' +
                                    '<span class="fas fa-trash-alt"></span>' +
                                '</button>' +
                            '</div>' +
                        '</li>');
                    });
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

function deletePurok(purok) {
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=deletePurok",
        data: {
            'purok' : purok
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                
                displayMsg(response.status, response.msg);
                
                if (response.status == 3) {
                    $('#purokist').html("")
                    $.each(response.puroks, function (index, purok) { 
                        $('#purokist').append('<li class="d-flex alert alert-info my-1 mx-0 slide_in">' +
                            '<div class="w-100 text-nowrap">'+purok+'</div>' +
                            '<div class="d-flex justify-content-end w-100">' +
                                '<button class="btn p-0 m-0 text-danger" onclick="deletePurok(\''+purok+'\')">' +
                                    '<span class="fas fa-trash-alt"></span>' +
                                '</button>' +
                            '</div>' +
                        '</li>');
                    });
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

$('#editEmbeddedMapBtn').click(function () {
    $(this).addClass('d-none')
    $('#updateEmbeddedMapBtn').removeClass('d-none')
    $('#cancelEditEmbeddedMapBtn').removeClass('d-none')

    $('#embedded_map').prop('disabled', false);

    embeddedMap = $('#embedded_map').val()
});

$('#cancelEditEmbeddedMapBtn').click(function (e) { 
    e.preventDefault();

    $('#editEmbeddedMapBtn').removeClass('d-none')
    $('#updateEmbeddedMapBtn').addClass('d-none')
    $('#cancelEditEmbeddedMapBtn').addClass('d-none')

    $('#embedded_map').prop('disabled', true);

    $('#embedded_map').val(embeddedMap)
    
});

$('#updateEmbeddedMapBtn').click(function (e) { 
    e.preventDefault();


    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=updateEmbeddedMap",
        data: {
            'embeddedMap' : $('#embedded_map').val()
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen()
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);

                if (response.status == 3) {
                    $('#editEmbeddedMapBtn').removeClass('d-none')
                    $('#updateEmbeddedMapBtn').addClass('d-none')
                    $('#cancelEditEmbeddedMapBtn').addClass('d-none')

                    $('#embedded_map').prop('disabled', true);

                    $('#embeddedMapDisplayContainer').html($('#embedded_map').val())
                }
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err.responseText)
                displayMsg(3, "Something went wrong.")
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
    
});



// about page
$('#editAboutPageBtn').click(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "Get",
        url: "submits/webSettingRequests.php?action=get",
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (webSetting) {
            setTimeout(() => {
                editAboutPageModalBS.show()
                $('#editAboutPageContent').summernote({
                    height: 400
                })
                $('#editAboutPageContent').summernote('code', webSetting.aboutPage)
            }, timeout);
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err);
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

$('#cancelEditAboutPage, #xEditAboutPage').click(function (e) { 
    e.preventDefault();

    $('#editAboutPageContent').summernote('code', "");
    
});

$('#editAboutPageModalForm').submit(function (e) { 
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=editAboutPage",
        data: {
            'content': $('#editAboutPageContent').summernote('code')
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {

                if (response.status == 3) {
                    editAboutPageModalBS.hide();
                }

                displayMsg(response.status, response.msg);

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


getWebSetting();
















// COVER IMAGES
// when home cover image button is clicked
// select an image
$('#changeHomeCoverImageBtn').click(function (e) { 
    e.preventDefault();
    $('#homeCoverImageFileIn').click()
});

$('#homeCoverImageFileIn').change(function (e) { 
    e.preventDefault();
    
    e.preventDefault();
    
    destroyHomeCoverImageCropper()


    let image = document.getElementById("homeCoverImage")

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
            homeCoverImageCropperModalBS.show()
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
function destroyHomeCoverImageCropper() {
    if (homeCoverImageCropper != null) {
        homeCoverImageCropper.destroy();
        homeCoverImageCropper = null;
    }
}
homeCoverImageCropperModal.addEventListener('shown.bs.modal', function () {
    destroyHomeCoverImageCropper()

    homeCoverImageCropper = new Cropper(homeCoverImage, {
        aspectRatio: 1920/1080,
        viewMode: 2
    });
})
homeCoverImageCropperModal.addEventListener('hidden.bs.modal', function () {
    destroyHomeCoverImageCropper();
    $('#homeCoverImageFileIn').val("");
})
$('#cropSaveHomeCoverImage').click(function (e) { 
    e.preventDefault();
    
    if (homeCoverImageCropper != null) {
        try {
            canvas = homeCoverImageCropper.getCroppedCanvas({
                width: 1920,
                height: 1080
            })


            canvas.toBlob(function (blob) {
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onload = function () {
                    let encryptedHomeCoverImage = reader.result

                    $.ajax({
                        type: "POST",
                        url: "submits/webSettingRequests.php?action=updateCoverImage",
                        data: {
                            'image' : encryptedHomeCoverImage,
                            'cover' : "home"
                        },
                        dataType: "JSON",
                        beforeSend: function () {
                            showLoadingScreen()
                        },
                        success: function (response) {
                            setTimeout(() => {

                                
                                displayMsg(3, response.msg)

                                $('#homeCoverImagePrev').attr('src', 'Media/images/'+response.cover_file+'?v=' + Math.random())
                                
                            }, timeout);
                        },
                        error: function (err) {
                            setTimeout(() => {
                                displayMsg(1, err.responseText)
                            }, timeout);
                        },
                        complete: function () {
                            setTimeout(() => {
                                hideLoadingScreen()
                                homeCoverImageCropperModalBS.hide()
                            }, timeout);
                        }
                    });
                }
            })

        } catch (error) {
            var err = {
                'status': "Something went wrong!",
                'statusText': "Please contact the developer if this message occurs."
            }

            displayMsg(1, err.status + " " + err.statusText);

            homeCoverImageCropperModalBS.hide();

        }
    }
});


// about page change cover
let coverImageToChange = null;


// when button change about cover is clicked
$('#changeAboutCoverImageBtn').click(function (e) { 
    e.preventDefault();
    $('#coverImageFileIn').click()
    coverImageToChange = "about";
});
$('#changeNewsCoverImageBtn').click(function (e) { 
    e.preventDefault();
    $('#coverImageFileIn').click()
    coverImageToChange = "news";
});
$('#changeTransparencyCoverImageBtn').click(function (e) { 
    e.preventDefault();
    $('#coverImageFileIn').click()
    coverImageToChange = "transparencies";
});
$('#changeResolutionsCoverImageBtn').click(function (e) { 
    e.preventDefault();
    $('#coverImageFileIn').click()
    coverImageToChange = "resolutions";
});




$('#coverImageFileIn').change(function (e) { 
    e.preventDefault();
    
    e.preventDefault();
    
    destroyCoverImageCropper()


    let image = document.getElementById("coverImages")

    let acceptableExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG']

    var file = e.target.files

    if (file.length > 0) {
        
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
                coverImagesCropperModalBS.show()
            }
    
            if (file && file.length > 0) {
                reader = new FileReader()
                reader.onload = function (e) {
                    done(reader.result)
                }
                reader.readAsDataURL(file[0])
            }
        }
    }

    
});
function destroyCoverImageCropper() {
    if (coverImageCropper != null) {
        coverImageCropper.destroy()
        coverImageCropper = null;
        coverImageToChange = null;
    }
}
coverImagesCropperModal.addEventListener('shown.bs.modal', function () {
    destroyHomeCoverImageCropper()

    coverImageCropper = new Cropper(coverImages, {
        aspectRatio: 1920/720,
        viewMode: 2
    });
})
coverImagesCropperModal.addEventListener('hidden.bs.modal', function () {
    destroyCoverImageCropper()
    $('#coverImageFileIn').val("")
})
$('#cropSaveCoverImages').click(function (e) { 
    e.preventDefault();
    
    if (coverImageCropper != null) {
        try {
            canvas = coverImageCropper.getCroppedCanvas({
                width: 1920,
                height: 720
            })


            canvas.toBlob(function (blob) {
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onload = function () {
                    let encryptedCoverImage = reader.result

                    $.ajax({
                        type: "POST",
                        url: "submits/webSettingRequests.php?action=updateCoverImage",
                        data: {
                            'image' : encryptedCoverImage,
                            'cover' : coverImageToChange
                        },
                        dataType: "JSON",
                        beforeSend: function () {
                            showLoadingScreen()
                        },
                        success: function (response) {
                            setTimeout(() => {

                                
                                displayMsg(3, response.msg)

                                $('#'+coverImageToChange+'CoverImagePrev').attr('src', 'Media/images/'+response.cover_file+'?v=' + Math.random())
                                
                            }, timeout);
                        },
                        error: function (err) {
                            setTimeout(() => {
                                displayMsg(1, err.responseText)
                            }, timeout);
                        },
                        complete: function () {
                            setTimeout(() => {
                                hideLoadingScreen()
                                coverImagesCropperModalBS.hide()
                            }, timeout);
                        }
                    });
                }
            })

        } catch (error) {
            var err = {
                'status': "Something went wrong!",
                'statusText': "Please contact the developer if this message occurs."
            }

            displayMsg(1, err.status + " " + err.statusText);

            coverImagesCropperModalBS.hide();

        }
    }
});





// signaturies
let brgySecretaryName = ""
let brgyTreasurerName = ""
let brgyCaptainName = ""
let skChairmanName = ""

$('#editDesignaturiesFormBtn').click(function (e) { 
    e.preventDefault();
    $('#cancelDesignaturiesFormBtn').removeClass('d-none');
    $('#saveDesignaturiesFormBtn').removeClass('d-none');
    $('#editDesignaturiesFormBtn').addClass('d-none');

    $('#brgySecretaryName').prop('disabled', false);
    $('#brgyTreasurerName').prop('disabled', false);
    $('#brgyCaptainName').prop('disabled', false);
    $('#skChairmanName').prop('disabled', false);

    
    brgySecretaryName = $('#brgySecretaryName').val();
    brgyTreasurerName = $('#brgyTreasurerName').val();
    brgyCaptainName = $('#brgyCaptainName').val();
    skChairmanName = $('#skChairmanName').val();
});

$('#cancelDesignaturiesFormBtn').click(function (e) { 
    e.preventDefault();
    $('#editDesignaturiesFormBtn').removeClass('d-none');
    $('#cancelDesignaturiesFormBtn').addClass('d-none');
    $('#saveDesignaturiesFormBtn').addClass('d-none');

    $('#brgySecretaryName').prop('disabled', true);
    $('#brgyTreasurerName').prop('disabled', true);
    $('#brgyCaptainName').prop('disabled', true);
    $('#skChairmanName').prop('disabled', true);

    $('#brgySecretaryName').val(brgySecretaryName);
    $('#brgyTreasurerName').val(brgyTreasurerName);
    $('#brgyCaptainName').val(brgyCaptainName);
    $('#skChairmanName').val(skChairmanName);
});

$('#designaturiesForm').submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=editDesignaturies",
        data: {
            'brgySecretaryName': $('#brgySecretaryName').val(),
            'brgyTreasurerName' : $('#brgyTreasurerName').val(),
            'brgyCaptainName': $('#brgyCaptainName').val(),
            'skChairmanName': $('#skChairmanName').val(),
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (response) {
            setTimeout(() => {
                displayMsg(response.status, response.msg);
                if (response.status == 3) {
                    $('#editDesignaturiesFormBtn').removeClass('d-none');
                    $('#cancelDesignaturiesFormBtn').addClass('d-none');
                    $('#saveDesignaturiesFormBtn').addClass('d-none');
                
                    $('#brgySecretaryName').prop('disabled', true);
                    $('#brgyTreasurerName').prop('disabled', true);
                    $('#brgyCaptainName').prop('disabled', true);
                    $('#skChairmanName').prop('disabled', true);
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
    
});




// councilors
let councilorFormModal = document.getElementById('councilorFormModal')
let councilorFormModalBS = new bootstrap.Modal(councilorFormModal)
let councilorForm = document.getElementById('councilorForm')

$('#addCouncilorBtn').click(function (e) { 
    e.preventDefault();
    councilorFormModalBS.show();
});

councilorFormModal.addEventListener('hidden.bs.modal', function () {
    councilorForm.reset();
    $('#councilorId').val("")
})

$('#councilorForm').submit(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=saveCouncilor",
        data: {
            'name' : $('#councilorName').val(),
            'designation' : $('#councilorDesignation').val(),
            'id' : $('#councilorId').val()
        },
        dataType: "JSON",
        beforeSend: function () { 
            showLoadingScreen();
        },
        success: function (response) { setTimeout(() => {
            displayMsg(response.status, response.msg);
            if (response.status == 3) {
                councilorFormModalBS.hide();
                getCouncilors()
            }
        }, timeout); },
        error: function (err) { setTimeout(() => {
            console.log(err)
            displayMsg(1, ERRMSG)
        }, timeout); },
        complete: function () { setTimeout(() => {
            hideLoadingScreen();
        }, timeout); }
    });
});

let councilorsRow = function (index, councilor) {

    let editBtn = '' +
    '<button class="btn btn-sm text-primary" onclick="editCouncilor(\''+councilor.id+'\')">' +
        '<span class="fas fa-edit"></span>' +
    '</button>';
    let deleteBtn = '' +
    '<button class="btn btn-sm text-danger" onclick="deleteCouncilor(\''+councilor.id+'\')">' +
        '<span class="fas fa-trash-alt"></span>' +
    '</button>';

    let nameCol = '<td>'+councilor.name+'</td>';
    let designationCol = '<td>'+councilor.designation+'</td>';
    let btnCol = '<td class="d-flex justify-content-end">'+editBtn+deleteBtn+'</td>';

    let row = '<tr class="slide_in">'+nameCol+designationCol+btnCol+'</tr>';

    return row;
}

function getCouncilors() {
    $.ajax({
        type: "GET",
        url: "submits/webSettingRequests.php?action=getCouncilors",
        dataType: "JSON",
        beforeSend: function () {
            showLoadingTableContent("#councilorList", 3);
        },
        success: function (councilors) {
            setTimeout(() => {
                if (councilors == null) {
                    displayTableMsg('councilorList', 3, "No Councilor's Found.")
                } else {
                    $('#councilorList').html("");
                    $.each(councilors, function (index, councilor) { 
                         $('#councilorList').append(councilorsRow(index, councilor));
                    });
                }
            }, timeout); 
        },
        error: function (err) {
            setTimeout(() => {
                console.log(err)
                displayTableMsg("councilorList", 3, ERRMSG)
            }, timeout);
        },
        complete: function () {
            setTimeout(() => {
                
            }, timeout);
        }

    });
}

function editCouncilor(id) {
    
    $.ajax({
        type: "GET",
        url: "submits/webSettingRequests.php?action=getOneCouncilor",
        data: {
            'id' : id
        },
        dataType: "JSON",
        beforeSend: function () {
            showLoadingScreen();
        },
        success: function (councilor) {
            setTimeout(() => {
                if (councilor != null) {
                    $('#councilorName').val(councilor.name);
                    $('#councilorDesignation').val(councilor.designation);
                    $('#councilorId').val(councilor.id);
                    councilorFormModalBS.show();
                } else {
                    displayMsg(2, ERRMSG);
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
                hideLoadingScreen() 
            }, timeout);
        }
    });
}

function deleteCouncilor(id) {
    $.ajax({
        type: "POST",
        url: "submits/webSettingRequests.php?action=deleteCouncilor",
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
                    getCouncilors();
                }
            }, timeout);
        },
        error : function (err) { 
            setTimeout(() => {
                console.log(err)
                displayMsg(1, ERRMSG);
            }, timeout);
        },
        complete: function (err) {
            setTimeout(() => {
                hideLoadingScreen()
            }, timeout);
        }
    });
}
getCouncilors();