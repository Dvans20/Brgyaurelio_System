<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
</head>
<style>
    #pdfFileDisplay {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
</style>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>


        <div class="container-fluid p-0 body_container">

            <?php include_once "Views/templates/header.php" ?>

            <main class="container py-5">
            
                <div class="row m-0 px-2 py-2">
                    <div class="col-md m-0 p-0">
                        <h2 class="p-2 pop_in_on_scroll">
                            <span class="fas fa-gavel"></span> Issuances
                        </h2>
                    </div>
                    <div class="col-md m-0 p-0">
                        <div class="d-flex justify-content-end pop_in_on_scroll">
                            <button class="btn btn-primary btn-lg" id="addResolutionsBtn">
                                Add Document
                            </button>
                        </div>
                    </div>
                </div>

                <div class="py-2 px-2">
                    <div class="card pop_in_on_scroll">
                        <div class="row p-0 m-0">
                            <div class="col-sm-6 col-md-3 p-2">
                                
                                <form action="search.php" id="searchForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control" name="search" id="search" autocomplete="off" placeholder="Search">
                                        <button class="btn btn-primary btn-sm">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </div>
                                </form>
                            

                            </div>
                            <div class="col-sm-6 col-md-3 p-2 m-0">
                                <select name="seriesFilter" id="seriesFilter" class="form-select">
                                    <option value="">Select Year</option>
                                    <?php for ($year = (date('Y') / 1); $year >= (date('Y') / 1) - 10; $year--) { ?>
                                        <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2 m-0">
                                <select name="resolutionTitleFilter" id="resolutionTitleFilter" class="form-select">
                                    <option value="">All</option>
                                    <option value="Resolution">Resolution</option>
                                    <option value="Ordinance">Ordinance</option>
                                    <option value="Executive Order (EO)">Executive Order (EO)</option>
                                    <option value="Proclamation">Proclamation</option>
                                    <option value="Memorandum">Memorandum</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <div class="d-flex justify-content-end w-100">
                                    <!-- <button class="btn-sm btn btn-primary mx-1" id="addCategoryBtn">
                                        <span class="fas fa-plus"></span> Add Category
                                    </button> -->
                                    <button class="btn btn btn-info mx-1" id="filterCategoriesBtn">
                                        <span class="fas fa-filter"></span> Filter
                                    </button>
                                    <!-- <button class="btn btn-sm btn-danger mx-1" id="deleteCategoriesBtn">
                                        <span class="fas fa-trash-alt"></span> Delete
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="accordion pop_in_on_scroll px-2" id="accordionCategories">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategoires">
                        <button class="accordion-button text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                            <strong>Filter</strong>
                        </button>
                        </h2>
                        <div id="collapseCategories" class="accordion-collapse collapse" aria-labelledby="headingCategoires" data-bs-parent="#accordionCategories">
                        <div class="accordion-body p-2">
                        
              
                        

                            

                            


                        </div>
                        </div>
                    </div>
                </div> -->

                <div class="pt-5 px-2 d-flex justify-content-end" id="resolutionsLinksTop"></div>
                <div class="pb-5 pt-2 w-100 custom_card_container" id="resolutionsList"></div>
                <div class="pb-5 px-2 d-flex justify-content-end" id="resolutionsLinksBot"></div>

                
            </main>
        
        </div>





    </div>




    <div class="modal fade" data-bs-backdrop="static"" id="resolutionFormModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="resolution.php" id="resolutionForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button class="btn btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="resolutionId" name="resolutionId">
                        <div class="p-2">
                            <div class="form-floating ">
                                <!-- <input type="text" name="resolutionTitle" id="resolutionTitle" class="form-control" placeholder="Document Title"> -->
                                 <select name="resolutionTitle" id="resolutionTitle" class="form-select">
                                    <option value=""> Select Title</option>
                                    <option value="Resolution">Resolution</option>
                                    <option value="Ordinance">Ordinance</option>
                                    <option value="Executive Order (EO)">Executive Order (EO)</option>
                                    <option value="Proclamation">Proclamation</option>
                                    <option value="Memorandum">Memorandum</option>
                                 </select>
                                <label for="resolutionTitle">Document Title</label>
                            </div>
                        </div>
            
                        <div class="row p-0 m-0">
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" name="resolutionNo" id="resolutionNo" class="form-control" placeholder="No." oninput="this.value=this.value.replace(/[a-z,A-Z]/g, '')">
                                    <label for="resolutionNo">No.</label>
                                </div>
                            </div>
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <select name="yearSeries" id="yearSeries" class="form-control">
                                        <option value="">Select Year</option>
                                        <?php for ($year = (date('Y') / 1); $year >= (date('Y') / 1) - 10; $year--) { ?>
                                            <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="yearSeries">Year</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="date" name="dateApproved" id="dateApproved" class="form-control" placeholder="Date Approved">
                                    <label for="dateApproved">Date Approved</label>
                                </div>
                            </div>
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" name="approvedBy" id="approvedBy" class="form-control" placeholder="Approved by">
                                    <label for="approvedBy">Approved by</label>
                                </div>
                            </div>

                        </div>
                        <div class="p-2">
                            <div class="form-floating">
                                <input type="text" name="authors" id="authors" class="form-control" placeholder="Authors">
                                <label for="authors">Authors</label>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-3 m-0 p-2">
                                <div class="">
                                    <button class="btn btn-info w-100 m-1" type="button" id="insertPdfFileBtn">
                                        <span class="fas fa-file-pdf"></span> <span id="insertPdfFileBtnText">Insert PDF</span> 
                                    </button>
                                    <button class="btn btn-info w-100 m-1 d-none" type="button" id="previewPdfFileBtn">
                                        <span class="fas fa-eye"></span> <span id="insertPdfFileBtnText">Preview PDF</span> 
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-9 m-0 p-2">
                                <div class="form-control disabled w-100 h-100 text-start" id="pdfFileDisplay"></div>
                                <input type="file" class="d-none" name="pdfFile" id="pdfFile">
                            </div>
                        </div>

                        <div class="p-2">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            <span class="fasf a-ban"></span> Cancel
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteResolutionModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="resolutionIdToDelete" name="resolutionIdToDelete">
                    <div class="alert alert-danger small">
                        <strong>Warning!</strong> Deleting this resolution will delete all of its data and information and it cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">No</button>
                    <button class="btn btn-danger" type="button" id="yesDeleteResolutionBtn">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" data-bs-backdrop="static"" id="resolutionFormModalEdit">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="resolution.php" id="resolutionFormEdit" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button class="btn btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="resolutionId" name="resolutionId">
                        <div class="p-2">
                            <div class="form-floating ">
                                <input type="text" name="resolutionTitleEdit" id="resolutionTitleEdit" class="form-control" placeholder="Resolution Title">
                                <label for="resolutionTitleEdit">Resolution Title</label>
                            </div>
                        </div>
            
                        <div class="row p-0 m-0">
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" name="resolutionNoEdit" id="resolutionNoEdit" class="form-control" placeholder="Resolution No">
                                    <label for="resolutionNoEdit">Resolution No</label>
                                </div>
                            </div>
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <select name="yearSeriesEdit" id="yearSeriesEdit" class="form-control">
                                        <option value="">Select Year</option>
                                        <?php for ($year = (date('Y') / 1); $year >= (date('Y') / 1) - 10; $year--) { ?>
                                            <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="yearSeriesEdit">Year</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="date" name="dateApprovedEdit" id="dateApprovedEdit" class="form-control" placeholder="Date Approved">
                                    <label for="dateApprovedEdit">Date Approved</label>
                                </div>
                            </div>
                            <div class="col-md m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" name="approvedByEdit" id="approvedByEdit" class="form-control" placeholder="Approved by">
                                    <label for="approvedByEdit">Approved by</label>
                                </div>
                            </div>

                        </div>
                        <div class="p-2">
                            <div class="form-floating">
                                <input type="text" name="authorsEdit" id="authorsEdit" class="form-control" placeholder="Authors">
                                <label for="authorsEdit">Authors</label>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-3 m-0 p-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info w-100" type="button" id="insertPdfFileBtnEdit">
                                        <span class="fas fa-file-pdf"></span> Insert PDF
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-9 m-0 p-2">
                                <div class="form-control disabled w-100 h-100 text-start" id="pdfFileDisplayEdit"></div>
                                <input type="file" class="d-none" name="pdfFileEdit" id="pdfFileEdit">
                            </div>
                        </div>

                        <div class="p-2">
                            <label for="descriptionEdit">Description</label>
                            <textarea name="descriptionEdit" id="descriptionEdit" class="form-control" rows="5"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            <span class="fasf a-ban"></span> Cancel
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>

    <script src="Views/js/resolutions.js<?php echo("?v=" . time() . uniqid()); ?>"></script>
</body>
</html>