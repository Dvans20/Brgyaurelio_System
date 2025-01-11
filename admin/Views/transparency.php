<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
</head>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>


    

        <main class="container py-5">




            

            <div class="row m-0 p-1">
                <div class="col-lg-9 p-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <div class="row m-0 px-2 py-2">
                                <div class="col-md m-0 p-0">
                                    <h2 class="p-0 text-nowrap">
                                        <span class="fas fa-balance-scale"></span> Transparency
                                    </h2>
                                </div>
                                <div class="col-md m-0 p-0">
                                    <div class="d-flex justify-content-end w-100 p-0">
                                        <button class="btn btn-primary btn-lg w-100" id="addTransparencyBtn">
                                            <span class="fas fa-file"></span> Add Document
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="row p-0 m-0">
                                <div class="col-lg-4 m-0 p-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Search" oninput="this.value = this.value.replace(/[^a-z,A-Z]/g, '')">
                                        <button class="btn btn-primary input-group-text" id="searchBtn">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 m-0 p-1">
                                   <select name="documentTypeFilter" id="documentTypeFilter" class="form-select">
                                        <option value="">Select document type</option>
                                   </select>
                                </div>
                                <div class="col-lg-2 col-md-6 m-0 p-1">
                                   <select name="yearFilter" id="yearFilter" class="form-select">
                                        <option value="">Select Year</option>
                                        <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--) { ?>
                                            <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                        <?php } ?>
                                   </select>
                                </div>
                                <div class="col-lg-2 col-md-6 m-0 p-1">
                                   <select name="quarterFilter" id="quarterFilter" class="form-select">
                                        <option value="">All</option>
                                        <option value="5">Whole Year</option>
                                        <option value="1">1st Quarter</option>
                                        <option value="2">2nd Quarter</option>
                                        <option value="3">3rd Quarter</option>
                                        <option value="4">4th Quarter</option>
                                   </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end px-1">
                                <button class="btn btn-primary btn-sm w-100" id="filterBtn">
                                    <span class="fas fa-filter"></span> Filter
                                </button>
                            </div>
                            <hr>
                            <table class="table table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Document Title</th>
                                        <th>Details</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="transparenciesList"></tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div id="transparenciesLinks" class="d-flex justify-content-end"></div>
                        </div>
                    </div>
                </div>


                <!-- document types -->
                <div class="col-lg-3 p-2">
                    <div class="accordion pop_in_on_scroll" id="accordionDocumentTypes">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="documentTypes-headingOne">
                            <button class="accordion-button text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#documentTypes-collapseOne" aria-expanded="true" aria-controls="documentTypes-collapseOne">
                                Document Types
                            </button>
                            </h2>
                            <div id="documentTypes-collapseOne" class="accordion-collapse collapse show" aria-labelledby="documentTypes-headingOne">
                                <div class="accordion-body">
                                    
                                    <form action="search.php" id="documentTypeSearchForm">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="documentTypeSearch" name="documentTypeSearch" placeholder="Search">
                                            <button class="input-group-text btn btn-primary" type="submit">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </div>
                                    </form>
                                    
                                    <hr>
                                    <div id="documentTypesList"></div>
                                    <div class="d-flex w-100 slide_in d-none" id="addDocumentTypeForm">
                                        <form action="submit.php" class="w-100" id="addDocumentType">
                                            <input type="hidden" id="documentTypeId" name="documentTypeId">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="documentTypeName" id="documentTypeName" placeholder="Document Type">
                                                <div class="input-group-text btn-group p-0">
                                                    <button class="btn btn-primary btn-sm h-100" type="submit">
                                                        <span class="fas fa-save"></span>
                                                    </button>
                                                    <button class="btn btn-secondary btn-sm h-100" type="button" id="cancelAddDocumentTypeBtn">
                                                        <span class="fas fa-ban"></span>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary btn-sm" id="addDocumentTypeBtn">
                                            <span class="fas fa-plus"></span> Add Document Type
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    if (screen.width <= 991) {
                        $('#documentTypes-collapseOne').removeClass('show');
                    }
                </script>
            </div>




        </main>
        <br>

    </div>


    <div class="modal fade" id="transparencyDocumentFormModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form action="submit.php" id="transparencyDocumentForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="form-floating m-1">
                            <input type="text" class="form-control" name="documentTitle" id="documentTitle" placeholder="Document Title">
                            <label for="documentTitle">Document Title</label>
                        </div>
                        <div class="form-floating m-1">
                            <select type="text" class="form-select" name="documentType" id="documentType" placeholder="Document Type">
                                <option value="">Select Document Type</option>
                            </select>   
                            <label for="documentType">Document Type</label>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-sm p-1 m-0">
                                <div class="form-floating my-1">
                                    <select name="year" id="year" class="form-select">
                                        <option value="">Select Year</option>
                                        <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--) { ?>
                                            <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="year">Year</label>
                                </div>
                            </div>
                            <div class="col-sm p-1 m-0">
                                <div class="form-floating my-1">
                                    <select name="quarter" id="quarter" class="form-select">
                                        <option value="">Select Quarter</option>
                                        <option value="5">Whole Year</option>
                                        <option value="1">1st Quarter</option>
                                        <option value="2">2nd Quarter</option>
                                        <option value="3">3rd Quarter</option>
                                        <option value="4">4th Quarter</option>
                                        
                                    </select>
                                    <label for="quarter">Quarter</label>
                                </div>
                            </div>
                        </div>

                        <div class="row m-0 p-0">
                            <div class="col-sm-4 p-1">
                                <input type="file" name="pdfFile" id="pdfFile" class="d-none">

                                <button class="btn btn-primary w-100 my-1" type="button" id="selectPdfFileBtn" onclick="document.getElementById('pdfFile').click()">
                                    <span class="fas fa-file-pdf"></span> <span id="selectPdfFileBtnText"> Select File</span>
                                </button>

                                <button class="btn btn-primary w-100 my-1 d-none" type="button" id="preiviewPdfFileBtn">
                                    <span class="fas fa-eye"></span> Preview File
                                </button>
                            </div>
                            <div class="col-sm-8 p-1">
                                <div class="form-control p-2 w-100 h-100 overflow-hidden" id="pdfFileDisplay"></div>
                            </div>

                        </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteTransparencyModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <butto class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="transparencyIdToDelete" id="transparencyIdToDelete">
                    <div class="alert alert-danger">
                        <strong>Warning! </strong> Deleting this document will be permanent and cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        No
                    </button>
                    <button class="btn btn-danger btn-sm" id="yesDeleteTransparency">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    <script src="Views/js/transparency.js<?php echo("?v=" . time() . uniqid()); ?>"></script>

</body>
</html>