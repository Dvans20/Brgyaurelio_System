<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>



<link rel="stylesheet" href="Views/css/webSetting.css<?php echo( "?v=" . time() . uniqid() ); ?>">

</head>
<style>

    #resCoverContainer, #resLogoContainer {
        position: relative;
    }

    #resCoverContainer {
        overflow: hidden;
        width: 100%;
    }

    #resCoverContainer #coverImage {
        overflow: hidden;
        position: absolute;
        top: 50%;
        width: 100%;
        transform: translateY(-50%);
        height: auto;
        z-index: 0;
    } 
    
    #changeCoverPictureBtn {
        position: absolute;
        right: 1rem;
        bottom: 1rem;
    }

    #resLogoContainer {
        height: calc(150px + 1rem);
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    #resLogoContainer #logoImage {
        z-index: 1;
        position: absolute;
        height: 150px;
        width: 150px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #resLogoContainer .card {
        border-radius: 50% !important;
    }

    .cover_image_preview {
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background-color: rgba(0, 0, 0, .5); */
        z-index: 0;
    }

    .logo_image_preview {
        z-index: 1;
        position: absolute;
        height: 150px;
        width: 150px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* background-color: rgba(0, 0, 0, .5); */
        overflow: hidden;
    }

    .cropper_prev_css {
        width: 100%;
        overflow: hidden;
        height: 400px;
    }
</style>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>


        <!-- <main> -->
            


            <main class="container py-4 mb-5 pb-5">

                <h2 class="p-2 pop_in_on_scroll">
                    <span class="fas fa-cogs"></span> Website Settings <buttton class="btn btn-md btn-primary backup_database"> <i class="fa fa-database"></i> Back up Database</buttton>
                </h2>

                <div class="row p-0 m-0">
                    <div class="col-md-4 col-sm-12 p-2 m-0">
                        <div class="card pop_in_on_scroll">
                            <div class="card-header">
                                <h5 class="line_text">
                                    About BRGY.
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-block web_setting_cont_info">
                                    <small>
                                        <i>
                                            (Describe your Barangay consider including key details like its location, community features, culture, and any unique aspects.)
                                        </i>
                                    </small>
                                </div>
                                <hr>
                                <div class="d-block position-relative">
                                    <div id="aboutText" class="web_setting_cont"></div>
                                    <textarea name="aboutTextArea" id="aboutTextArea" class="web_setting_cont_textarea form-control d-none"></textarea>
                                    <div id="aboutLoadingCont" class="d-none"></div>

                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end" id="toEditFooter">
                                    <button class="btn btn-primary" id="editAbout">
                                        <span class="fas fa-edit"></span> Edit
                                    </button>
                                </div>
                                <div class="d-flex justify-content-end d-none" id="onEditFooter">
                                    <button class="btn btn-primary ms-1" id="updateAbout">
                                        <span class="fas fa-save"></span> Update
                                    </button>
                                    <button class="btn btn-secondary ms-1" id="cancelEditAbout">
                                        <span class="fas fa-ban"></span> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 m-0 p-0">
                        <div class="p-2">
                            <div class="card pop_in_on_scroll">
                                <div class="card-header">
                                    <h5>
                                        Site Logo
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- <img src="Media/images/logo.png" alt="" class=""> -->
                                    <div id="resLogoContainer" class="card-body position-relative">
                                    
                                        <img src="Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" alt="<?php echo($web->brgy); ?>" id="logoImage">
                                
                                        <!-- <div class="logo_image_preview" id="logo_image_preview"></div> -->
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" type="button" id="logoImgBtn">
                                            <span class="fas-fa-change"></span> Change Site Logo
                                        </button>
                                        <input type="file" name="site_logo_in" id="site_logo_in" class="d-none">
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-2">
                            <div class="card pop_in_on_scroll">
                                <div class="card-header">
                                    <h5>Site URL</h5>
                                </div>
                                <div class="card-body">
                                    <input type="text" placeholder="http://enteryoursirehere.com.ph" class="form-control" disabled name="site_url" id="site_url">
                                    <!-- <label for="site_url">Site URL</label> -->
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary mx-1" id="editSiteUrlBtn">
                                            <span class="fas fa-edit"></span> Edit
                                        </button>
                                        <button class="btn btn-primary mx-1 d-none" id="saveSiteUrlBtn">
                                            <span class="fas fa-save"></span> Save
                                        </button>
                                        <button class="btn btn-secondary mx-1 d-none" id="cancelSiteUrlBtn">
                                            <span class="fas fa-ban"></span> Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-4 col-sm-6 m-0 p-2">
                        <div class="card pop_in_on_scroll">
                            <div class="card-header">
                                <h5 class="line_text">
                                    Brgy. Info.
                                </h5>
                            </div>
                            <div class="card-body">
                                <form id="brgyInfoForm">
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" name="brgy" id="brgy" placeholder="Name of Brgy." disabled>
                                        <label for="brgy">Name of Brgy.</label>
                                    </div>
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Office Address" disabled>
                                        <label for="address">Office Address</label>
                                    </div>
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Contact No." disabled>
                                        <label for="contact_no">Contact No.</label>
                                    </div>
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" disabled>
                                        <label for="email">Email</label>
                                    </div>
                                    <hr>
                                    <div class="form-floating my-2">
                                        <input type="text" class="form-control" name="tagline" id="tagline" placeholder="Tagline" disabled>
                                        <label for="tagline">Tagline</label>
                                    </div>
                                </form>
                                

                                <!-- <div class="m-0">
                                    <label for="embeded_map">Embed a Map</label>
                                    <textarea name="embeded_map" id="embeded_map" class="form-control" rows="3" disabled></textarea>
                                </div> -->
                                
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary mx-1" id="editContactInfoBtn">
                                        <span class="fas fa-edit"></span> Edit
                                    </button>

                                    <button class="btn btn-primary mx-1 d-none" id="saveContactInfoBtn">
                                        <span class="fas fa-save"></span> Save
                                    </button>
                                    <button class="btn btn-secondary mx-1 d-none" id="cancelContactInfoBtn">
                                        <span class="fas fa-ban"></span> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-0 m-0">
                    <div class="col-lg-3 m-0 p-2">
                        <div class="card pop_in_on_scroll">
                            <div class="card-header">
                                <h4 class="fs-5">
                                    Purok Settings
                                </h4>
                            </div>
                            <div class="card-body overflow-auto" style="height: 240px;" id="purokistCardBody">
                                <ul id="purokist" class="m-0 p-0">

                                </ul>
                                <div class="input-group slide_in d-none" id="purokInputContainer">
                                    <input type="text" class="form-control" name="purok" id="purok" placeholder="Purok #">
                                    <span class="input-group-text btn-group p-0 m-0">
                                        <button class="btn btn-sm btn-primary" id="savePurokBtn">
                                            <span class="fas fa-save"></span>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" id="cancelAddPurokBtn">
                                            <span class="fas fa-ban"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" id="addPurokBtn">
                                        Add Purok
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 m-0 p-2">
                        <div class="card pop_in_on_scroll">
                            <div class="card-header">
                                <h5 class="line_text">
                                    Embedded Map
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row m-0 p-0">
                                    <div class="col-md">
                                        <label for="embedded_map">Paste Your Emedded map Here</label>
                                        <textarea name="embedded_map" id="embedded_map" class="form-control" rows="7" disabled style="resize: none;"></textarea>

                                    </div>
                                    <div class="col-md">
                                        <style>
                                            iframe {
                                                width: 100% !important;
                                                height: 100% !important;
                                            }
                                        </style>
                                        <br>
                                        <div class="d-block position-relative p-0 pb-4 m-0 h-100" id="embeddedMapDisplayContainer">

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary mx-1" id="editEmbeddedMapBtn">
                                        <span class="fas fa-edit"></span> Edit
                                    </button>

                                    <button class="btn btn-primary d-none mx-1" id="updateEmbeddedMapBtn">
                                        <span class="fas fa-save"></span> Update
                                    </button>
                                    <button class="btn btn-secondary d-none mx-1" id="cancelEditEmbeddedMapBtn">
                                        <span class="fas fa-ban"></span> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="p-2">   
                    <div class="pop_in_on_scroll">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" id="editAboutPageBtn">
                                <span class="fas fa-edit"></span> Edit About Page Content
                            </button>
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <form id="designaturiesForm">

                            <div class="card-body">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-6 col-md-3 p-2 m-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="brgySecretaryName" id="brgySecretaryName" placeholder="Secretary" disabled>
                                                <label for="brgySecretaryName">Secretary</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3 p-2 m-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="brgyTreasurerName" id="brgyTreasurerName" placeholder="Treasurer" disabled>
                                                <label for="brgyTreasurerName">Treasurer</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3 p-2 m-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="brgyCaptainName" id="brgyCaptainName" placeholder="Punong Barangay" disabled>
                                                <label for="brgyCaptainName">Punong Barangay</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3 p-2 m-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="skChairmanName" id="skChairmanName" placeholder="SK Chairman" disabled>
                                                <label for="skChairmanName">SK Chairman</label>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary mx-1" type="button" id="editDesignaturiesFormBtn">
                                        <span class="fas fa-edit"></span> Edit
                                    </button>
                                    <button class="btn btn-secondary mx-1 d-none" type="button" id="cancelDesignaturiesFormBtn">
                                        <span class="fas fa-ban"></span> Cancel
                                    </button>
                                    <button class="btn btn-primary mx-1 d-none" type="submit" id="saveDesignaturiesFormBtn">
                                            <span class="fas fa-save"></span> Save
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <h4>Brgy. Councilor's</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th><th>Designation</th><th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="councilorList"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" id="addCouncilorBtn">
                                    Add Councilor
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- cover images -->
                
                <h4 class="p-2 pop_in_on_scroll">
                    <span class="fas fa-images"></span> Cover Images
                </h4>

            
                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 p-0">
                                <div class="col-md py-2">
                                    <h4>Home Page</h4>
                                </div>
                                <div class="col-md py-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="changeHomeCoverImageBtn">
                                            Change Home Page Cover Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="Media/images/home_cover.jpg<?php echo("?v=" . time() . uniqid()); ?>" class="w-100 h-auto" alt="" id="homeCoverImagePrev">
                        </div>
                    </div>
                </div>
               
                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 p-0">
                                <div class="col-md py-2">
                                    <h4>About Page</h4>
                                </div>
                                <div class="col-md py-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="changeAboutCoverImageBtn">
                                            Change About Page Cover Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="Media/images/about_cover.jpg<?php echo("?v=" . time() . uniqid()); ?>" class="w-100 h-auto" alt="" id="aboutCoverImagePrev">
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 p-0">
                                <div class="col-md py-2">
                                    <h4>News Page</h4>
                                </div>
                                <div class="col-md py-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="changeNewsCoverImageBtn">
                                            Change News Page Cover Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="Media/images/news_cover.jpg<?php echo("?v=" . time() . uniqid()); ?>" class="w-100 h-auto" alt="" id="newsCoverImagePrev">
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 p-0">
                                <div class="col-md py-2">
                                    <h4>Transparency Page</h4>
                                </div>
                                <div class="col-md py-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="changeTransparencyCoverImageBtn">
                                            Change Transparency Page Cover Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="Media/images/transparencies_cover.jpg<?php echo("?v=" . time() . uniqid()); ?>" class="w-100 h-auto" alt="" id="transparenciesCoverImagePrev">
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 p-0">
                                <div class="col-md py-2">
                                    <h4>Resolutions Page</h4>
                                </div>
                                <div class="col-md py-2">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="changeResolutionsCoverImageBtn">
                                            Change Resolutions Page Cover Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="Media/images/resolutions_cover.jpg<?php echo("?v=" . time() . uniqid()); ?>" class="w-100 h-auto" alt="" id="resolutionsCoverImagePrev">
                        </div>
                    </div>
                </div>

               

               
                
            
                <div>
                    <br> &nbsp;
                    <input type="file" id="homeCoverImageFileIn" name="homeCoverImageFileIn" class="d-none">
                    <input type="file" id="coverImageFileIn" name="coverImageFileIn" class="d-none">

                </div>
            </main>
            


        <!-- </main> -->

    </div>



    <div class="modal fade" id="logoImageCropperModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body position-relative">
                    <div class="w-100 overflow-hidden position-relative">
                        <img src="" alt="" id="imageLogo" class="cropper_prev_css">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-block w-100" type="button" id="cropSaveSiteImage">
                        <span class="fas fa-crop"></span> Crop & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAboutPageModal">
        <div class="modal-dialog modal-xl modal-dialog centered">
            <div class="modal-content">
                <form id="editAboutPageModalForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button" id="xEditAboutPage"></button>
                    </div>
                    <div class="modal-body">
                        <div id="editAboutPageContent">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" id="cancelEditAboutPage">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="homeCoverImageCropperModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body position-relative">
                    <div class="w-100 overflow-hidden position-relative">
                        <img src="" alt="" id="homeCoverImage" class="cropper_prev_css">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-block w-100" type="button" id="cropSaveHomeCoverImage">
                        <span class="fas fa-crop"></span> Crop & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="coverImagesCropperModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body position-relative">
                    <div class="w-100 overflow-hidden position-relative">
                        <img src="" alt="" id="coverImages" class="cropper_prev_css">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-block w-100" type="button" id="cropSaveCoverImages">
                        <span class="fas fa-crop"></span> Crop & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="councilorFormModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="councilorForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="councilorId" id="councilorId">
                        <div class="form-floating my-1">
                            <input type="text" class="form-control" name="councilorName" id="councilorName" placeholder="Councilor's Name">
                            <label for="councilorName">Councilor's Name</label>
                        </div>
                        <div class="form-floating my-1">
                            <input type="text" class="form-control" name="councilorDesignation" id="councilorDesignation" placeholder="Councilor's Designation">
                            <label for="councilorDesignation">Councilor's Designation</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" type="button">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                        <button class="btn btn-primary btn-sm" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    

    <!-- <script src="Views/js/cropper.js<?php echo "?v" . time() . uniqid(); ?>"></script> -->
    <script src="Views/js/websiteSettings.js<?php echo "?v" . time() . uniqid(); ?>"></script>
    <script>
$('.backup_database').click(function() {

    // Construct the URL with the GET parameter
    const url = 'submits/queries.php?backup_database=true';

    // Create a hidden link element
    const link = document.createElement('a');
    link.href = url;
    link.download = ''; // Optional, but you can specify a filename if needed
    document.body.appendChild(link);
    link.click(); // Trigger the download
    document.body.removeChild(link); // Clean up
});


    </script>
</body>
</html>