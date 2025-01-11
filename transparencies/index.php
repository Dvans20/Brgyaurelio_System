<?php 

$linkExt = "../";
require_once "../Utilities/config.php";

require_once "../admin/Models/DocumentType.php";
require_once "../admin/Models/Transparency.php";





// 

?>

<?php 
    $documentTypes = DocumentType::findBySearch("");


    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        $search = "";
    }

    if (isset($_GET['documentType'])) {
        $documentTypeId = $_GET['documentType'];
    } else {
        $documentTypeId = "";
    }
    
    if (isset($_GET['calendarYear'])) {
        $calendarYear = $_GET['calendarYear'];
    } else {
        $calendarYear = "";
    }

    if (isset($_GET['quarter'])) {
        $quarter = $_GET['quarter'];
    } else {
        $quarter = "";
    }

   



    if (isset( $_GET['page'])) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    if (!is_numeric(value: $currentPage)) {
        $currentPage = 1;
    }
    
    $limit = 10;

    $transparencies = Transparency::find($currentPage, $limit, $search, $documentTypeId, $calendarYear, $quarter);

    $totalPages = ceil(Transparency::countAll($search, $documentTypeId, $calendarYear, $quarter) / $limit);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="<?php echo($web->brgy); ?>">
        <title>BRGY. <?php echo(strtoupper($web->brgy . " | resolutions")); ?></title>
        <meta name="description" content="Resoluions page of brgy. <?php echo($web->brgy); ?>"> 
        <?php require_once "../head.php" ?> 
    </head>
    
    <body class="topics-listing-page" id="top">

        <main>
            <?php include_once '../header_nav.php' ?>



            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('../admin/Media/images/transparencies_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-5 col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Transparencies</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Transparencies</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h3 class="mb-4">Transparencies</h3>
                        </div>

                        <div class="col-12 p-2">

                            <form action="" class="custom-form" id="filterForm">
                                <div class="row p-0 m-0">
                                    <div class="col-lg-4 m-0 p-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" id="search" placeholder="Search" value="<?php echo($search); ?>">
                                            <button class="btn btn-primary input-group-text custom-btn" id="searchBtn" type="submit">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 m-0 p-1">
                                    <select name="documentType" id="documentType" class="form-select">
                                            <option value="">Select document type</option>
                                            <?php foreach ($documentTypes as $documentType) { ?>
                                                <?php if ($documentTypeId == $documentType->id) { ?>
                                                    <option value="<?php echo($documentType->id); ?>" selected><?php echo($documentType->name); ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo($documentType->id); ?>"><?php echo($documentType->name); ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                    </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 m-0 p-1">
                                    <select name="calendarYear" id="calendarYear" class="form-select">
                                            <option value="">Select Year</option>
                                            <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--) { ?>
                                                <?php if ($year == $calendarYear) { ?>
                                                    <option value="<?php echo($year); ?>" selected><?php echo($year); ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo($year); ?>"><?php echo($year); ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                    </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 m-0 p-1">
                                    <select name="quarter" id="quarter" class="form-select">
                                            <option value="">All</option>
                                            <option value="5" <?php if ($quarter == 5) echo("selected") ?>>Whole Year</option>
                                            <option value="1" <?php if ($quarter == 1) echo("selected") ?>>1st Quarter</option>
                                            <option value="2" <?php if ($quarter == 2) echo("selected") ?>>2nd Quarter</option>
                                            <option value="3" <?php if ($quarter == 3) echo("selected") ?>>3rd Quarter</option>
                                            <option value="4" <?php if ($quarter == 4) echo("selected") ?>>4th Quarter</option>
                                    </select>
                                    </div>
                                </div>
                                <input type="hidden" name="page" id="page">
                                <div class="d-flex justify-content-end px-1">
                                    <button class="btn btn-primary btn-sm w-100 custom-btn" type="submit" id="filterBtn">
                                        <span class="fas fa-filter"></span> Filter
                                    </button>
                                </div>

                            </form>

                            
                        </div>

                        <div class="col-lg-12 p-2"> 
                            <table class="table table-responsive table-hover table-striped table-lg">
                                <thead>
                                    <tr>
                                        <th>Document Title</th>
                                        <th>Details</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($transparencies) <= 0) { ?>
                                        <tr>
                                            <td colspan="3">
                                                <div class="p-4 text-muted text-center fs-4">
                                                    No Documents Found.
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <?php foreach ($transparencies as $transparency) { ?>
                                            <tr>
                                                <td><?php echo($transparency->documentTitle); ?></td>
                                                <td>
                                                    <?php 
                                                        $dT = DocumentType::findById($documentType->id);
                                                    ?>
                                                    Type: <?php echo($dT->name); ?>
                                                    <br>
                                                    Year: <?php echo($transparency->calendarYear); ?>
                                                    <?php if ($transparency->quarter != 5) { ?>
                                                        <?php echo("["); ?>
                                                            <?php 

                                                                switch ($transparency->quarter) {
                                                                    case 1:
                                                                        echo "1<sup>st</sup>";
                                                                        break;
                                                                    case 2:
                                                                        echo "2<sup>nd</sup>";
                                                                        break;
                                                                    case 3:
                                                                        echo "3<sup>rd</sup>";
                                                                        break;
                                                                    case 4:
                                                                        echo "4<sup>th</sup>";
                                                                        break;
                                                                }

                                                            ?>
                                                        <?php echo("]"); ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class=" d-flex justify-content-end">
                                                        <a class="btn bnt-sm custom-btn fs-6" href="../admin/Media/pdf/<?php echo($transparency->pdfFile); ?>" target="_blank">
                                                            <span class="fas fa-file-pdf"></span> Read Document
                                                        </a>
                                                    </div>
                                                   
                                                </td>
                                            </tr>
                                        <?php } ?>  
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                     

                        <?php if ($totalPages > 1 && !empty($currentPage)) { ?>

                            <?php if ($currentPage <= 1) { ?>
                                <?php $prevPage = 1; ?>
                            <?php } else { ?>
                                <?php $prevPage = ($currentPage - 1); ?>
                            <?php } ?>

                            <?php if ($currentPage >= $totalPages) { ?>
                                <?php $nextPage = $currentPage; ?>
                            <?php } else { ?>
                                <?php $nextPage = ($currentPage + 1); ?>
                            <?php } ?>



                            <div class="col-lg-12 col-12">
                                <ul class="pagination justify-content-center mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo($prevPage); ?>" aria-label="Previous">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>

                                    <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
                                        <?php if ($page == $currentPage) { ?>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link active" href="#"><?php echo($page); ?></a>
                                            </li>
                                        <?php } else if (($currentPage >= $page - 3) && ($currentPage <= $page + 3)) { ?>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link" href="<?php echo($page); ?>"><?php echo($page); ?></a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo($nextPage); ?>" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <script>
                                $('.pagination a.page-link').click(function (e) { 
                                    e.preventDefault();
                                    if (!$(this).hasClass('active')) {
                                        $('#page').val($(this).attr('href'))
                                        $('#filterForm').submit()
                                    }
                                });
                            </script>
                        <?php } ?>

                        <!-- <div class="col-lg-12 col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>

                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div> -->

                    </div>
                </div>
            </section>


            <!-- <section class="section-padding section-bg">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <h3 class="mb-4">Trending Topics</h3>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12 mt-3 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <a href="topics-detail.html">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Investment</h5>

                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">30</span>
                                    </div>

                                    <img src="images/topics/undraw_Finance_re_gnv2.png" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12 mt-lg-3">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="images/businesswoman-using-tablet-analysis.jpg" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">Finance</h5>

                                            <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint animi necessitatibus aperiam repudiandae nam omnis</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3">Learn More</a>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                    </div>

                                    <div class="social-share d-flex">
                                        <p class="text-white me-4">Share:</p>

                                        <ul class="social-icon">
                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                            </li>
                                        </ul>

                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                    </div>

                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section> -->
        </main>

		<!-- <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="index.html">
                            <i class="bi-back"></i>
                            <span>Topic</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resources</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">How it works</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">FAQs</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Information</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 305-240-9671" class="site-footer-link">
                                305-240-9671
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:info@company.com" class="site-footer-link">
                                info@company.com
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            English</button>

                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Thai</button></li>

                                <li><button class="dropdown-item" type="button">Myanmar</button></li>

                                <li><button class="dropdown-item" type="button">Arabic</button></li>
                            </ul>
                        </div>

                        <p class="copyright-text mt-lg-5 mt-4">Copyright © 2048 Topic Listing Center. All rights reserved.
                        <br><br>Design: <a rel="nofollow" href="https://templatemo.com" target="_blank">TemplateMo</a></p>
                        
                    </div>

                </div>
            </div>
        </footer> -->

        <!-- JAVASCRIPT FILES -->
        <!-- <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script> -->

        <?php 
            require_once '../footer.php';
        ?>
  

    </body>
</html>