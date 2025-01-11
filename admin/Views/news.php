<?php 
    require_once 'Models/Categories.php';

    $categories = Categories::findByType('news');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
<link rel="stylesheet" href="Views/css/news.css?v=<?php echo(time().uniqid()); ?>">
</head>


<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>

        <main class="container py-5">
        
            <div class="row m-0 px-2 py-2">
                <div class="col-md m-0 p-0">
                    <h2 class="p-2 pop_in_on_scroll">
                        <span class="fas fa-newspaper"></span> News & Updates
                    </h2>
                </div>
                <div class="col-md m-0 p-0">
                    <div class="d-flex justify-content-end pop_in_on_scroll">
                        <button class="btn btn-primary btn-lg" id="addNewNewsBtn">
                            Create New News/Updates
                        </button>
                    </div>
                </div>
            </div>

            <div class="accordion pop_in_on_scroll px-2" id="accordionCategories">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingCategoires">
                    <button class="accordion-button text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                        <strong>Categories</strong>
                    </button>
                    </h2>
                    <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategoires" data-bs-parent="#accordionCategories">
                    <div class="accordion-body p-2">
                       
                        <div class="row m-0 p-0" id="categoriesContainer">
                            <?php if ($categories->categories == null) { ?>
                                <div class="py-5 col-md-12 p-0 m-0">
                                    <div class="text-center text-muted shake_in">
                                        No Categories Found.
                                    </div>
                                </div>
                            <?php } else { ?>

                                <?php foreach (explode( "|", $categories->categories) as $category)  { ?>
                                    <div class="col-md-3 p-2" id="<?php echo($category); ?>Col">
                                        <label for="cat_in_<?php echo($category); ?>" class="cursor-pointer slide_in">
                                            <input type="checkbox" name="cat_in" id="cat_in_<?php echo($category); ?>" value="<?php echo($category); ?>" class="form-check-input">
                                        <?php echo($category); ?></label>
                                    </div>
                                <?php } ?>

                                
                                
                                    
                            <?php } ?>
                            <div class="col-md-3 p-2 d-none" id="addNewCategoryCol">
                                <div class="input-group slide_in">
                                    <input type="text" name="new_cateory" id="new_cateory" placeholder="Category Name" class="form-control">
                                    <div class="btn-group input-group-text p-0" role="group">
                                        <button type="button" class="input-group-text btn btn-sm btn-primary m-0" id="saveNewCategoryBtn">
                                            <span class="fas fa-save"></span>
                                        </button>
                                        <button type="button" class="input-group-text btn btn-sm btn-secondary m-0" id="cancelAddCategoryBtn">
                                            <span class="fas fa-ban"></span>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <hr>

                        <div class="row p-0 m-0">
                            <div class="col-md py-1">
                                
                                <form action="search.php" id="searchForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="search" id="search" autocomplete="off" placeholder="Search">
                                        <button class="btn btn-primary btn-sm">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </div>
                                </form>
                               

                            </div>
                            <div class="col-md py-1">
                                <div class="d-flex justify-content-end w-100">
                                    <button class="btn-sm btn btn-primary mx-1" id="addCategoryBtn">
                                        <span class="fas fa-plus"></span> Add Category
                                    </button>
                                    <button class="btn btn-sm btn-info mx-1" id="filterCategoriesBtn">
                                        <span class="fas fa-filter"></span> Filter
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-1" id="deleteCategoriesBtn">
                                        <span class="fas fa-trash-alt"></span> Delete
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                    </div>
                </div>
            </div>

            <div class="pt-5 px-2 d-flex justify-content-end" id="newsesLinksTop"></div>
            <div class="pb-5 pt-2 w-100 custom_card_container" id="newsesList"></div>
            <div class="pb-5 px-2 d-flex justify-content-end" id="newsesLinksBot"></div>

            
        </main>
       
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="newsFormModal">
        <div class="modal-dialog modal-xl  modal-dialog-centered">
            <div class="modal-content">
                <!-- <form action="newsSubmit.php" id="newsForm"> -->

                    <div class="modal-header">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" id="xNewsFormModalBtn"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="news_id" name="news_id" value="">
                        <div class="p-1">
                            <div class="position-relative feature_image_container">
                                <img src="Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy.'.png'))); ?>" alt="" class="feature_image" id="image_feature">
                                <div class="feature_image_preview"></div>
                            </div>
                            
                            <btn class="btn btn-primary btn-sm feature_image_btn mt-1" id="setFeatureImgBtn">
                                Set Feature Image
                            </btn>
                            <input type="file" id="feature_image_file" class="d-none">

                        </div>

                        <div class="form-floating my-1">
                            <input type="text" class="form-control" name="news_title" id="news_title" placeholder="News Title">
                            <label for="news_title" class="news_title_label">News Title</label>
                        </div>


                        <hr>

                        <div id="postEditor"></div>
                        <hr>

                        <div id="newsFormCategoriesContainer" class="row m-0 p-0">

                        </div>
                            

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button" id="cancelNewsFormModalBtn">
                             Cancel
                        </button>
                        <button class="btn btn-primary" type="button" id="postNewsBtn">
                             Post & Publish
                        </button>
                        <button class="btn btn-info" type="button" id="draftNewsBtn">
                             Save as Draft
                        </button>
                    </div>
                <!-- </form> -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="featureImageCropperModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div> -->
                <div class="modal-body position-relative">
                    <div class="w-100 overflow-hidden position-relative">
                        <img src="" alt="" id="imageFeature" class="cropper_prev_css">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-block w-100" type="button" data-bs-dismiss="modal">
                        <span class="fas fa-crop"></span> Crop
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewNewsModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="newsTitlePreview"></h3>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-0m-0">
                        <div class="col-md-4 m-0">
                            <img id="featureImagePreview" class="feature_image">
                        </div>
                        <div class="col-md-8 m-0">
                            <b>Categories: </b>
                            <ul class="ps-2" id="categoriesListPreview"></ul>
                        </div>
                    </div>
                    <hr>
                    <div class="float-end" id="newsStatusPreview"></div>

                    <div id="newsContentPreview"></div>
                    <hr>
                    <div id="newsDatesPreview" class="text-muted small"></div>
                    <input type="hidden" id="newsIdPreview" name="newsIdPreview">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" type="button" id="previewEditBtn">
                        <span class="fas fa-edit"></span> Edit
                    </button>
                    <button class="btn btn-danger" type="button" id="previewDeleteBtn">
                        <span class="fas fa-trash-alt"></span> Delete
                    </button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        <span class="fas fa-times"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="askDeleteNewsModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="newsIdToDelete" name="newsIdToDelete">
                    <div class="alert alert-danger small">
                        <strong>Warning!</strong> Deleting this news will delete all of its data and information and it cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" id="yesDeleteNews">Yes</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Views/js/news.js<?php echo("?v=" .time() . uniqid()); ?>"></script>

    <?php 
        include_once 'Views/templates/foot.php';
    ?>
</body>
</html>