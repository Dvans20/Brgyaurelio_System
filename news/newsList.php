<?php 



    if (isset( $_GET['page'])) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    if (!is_numeric($currentPage)) {
        $currentPage = 1;
    }


    $limit = 5;
    $latestNews = News::get("%%", "", $currentPage, $limit, 2);
    $totalPages = ceil( News::countAll("%%", "", 2) / $limit);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="<?php echo($web->brgy); ?>">
        <title>BRGY. <?php echo(strtoupper($web->brgy . " | news")); ?></title>
        <meta name="description" content="News page of brgy. <?php echo($web->brgy); ?>"> 
        <?php require_once "../head.php" ?>
    </head>
    
    <body class="topics-listing-page" id="top">

        <main>
            <?php include_once '../header_nav.php' ?>



            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('../admin/Media/images/news_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-5 col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">News</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">News & Updates</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h3 class="mb-4">News & Updates</h3>
                        </div>

                        <div class="col-lg-8 col-12 mt-3 mx-auto">


                            <?php if ($latestNews == null) { ?>
                                <div class="display-5 text-center text-muted py-5 mt-5">
                                    No News Found.
                                </div>
                            <?php } else { ?>
                                <?php foreach ($latestNews as $news) { ?>
                                    <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                        <div class="d-flex">
            

                                            <?php if (empty($news->featureImage)) { ?>
                                                <img src="../admin/Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" class="custom-block-image img-fluid" alt=""<?php echo($news->newsTitle); ?>>
                                            <?php } else { ?>
                                                <img src="../admin/Media/images/<?php echo($news->featureImage); ?>" class="custom-block-image img-fluid" alt=""<?php echo($news->newsTitle); ?>>
                                            <?php } ?>

                                            <div class="custom-block-topics-listing-info d-flex">
                                                <div>
                                                    <h5 class="mb-2"><?php echo($news->newsTitle); ?></h5>

                                                    <!-- <p class="mb-0">Topic Listing includes home, listing, detail and contact pages. Feel free to modify this template for your custom websites.</p> -->

                                                    <div class="custom-block-content-news mb-0 card_news_content">
                                                        <?php echo($news->newsContent); ?>
                                                    </div>

                                                    <a href="<?php echo($web->siteUrl . "/news?news=" . $news->id); ?>" class="btn custom-btn mt-3 mt-lg-4">Read More</a>
                                                </div>

                                                <!-- <span class="badge bg-design rounded-pill ms-auto">14</span> -->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            
                            

                            <!-- <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="../images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Web Design</h5>

                                            <p class="mb-0">Topic Listing includes home, listing, detail and contact pages. Feel free to modify this template for your custom websites.</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-3 mt-lg-4">Learn More</a>
                                        </div>

                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="../images/topics/undraw_online_ad_re_ol62.png" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Advertising</h5>

                                            <p class="mb-0">Visit TemplateMo website to download free CSS templates. Lorem ipsum dolor, sit amet consectetur adipisicing elit animi necessitatibus</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-3 mt-lg-4">Learn More</a>
                                        </div>

                                        <span class="badge bg-advertising rounded-pill ms-auto">30</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="../images/topics/undraw_Podcast_audience_re_4i5q.png" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Podcast</h5>

                                            <p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit animi necessitatibus</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-3 mt-lg-4">Learn More</a>
                                        </div>

                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                    </div>
                                </div>
                            </div> -->
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
                                        <a class="page-link" href="<?php echo($web->siteUrl . "/news?page=" . $prevPage); ?>" aria-label="Previous">
                                            <span aria-hidden="true">Prev</span>
                                        </a>
                                    </li>

                                    <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
                                        <?php if ($page == $currentPage) { ?>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#"><?php echo($page); ?></a>
                                            </li>
                                        <?php } else if (($currentPage >= $page - 3) && ($currentPage <= $page + 3)) { ?>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link" href="<?php echo($web->siteUrl . "/news?page=" . $page); ?>"><?php echo($page); ?></a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>

                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo($web->siteUrl . "/news?page=" . $nextPage); ?>" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
        <script>
            $('.card_news_content').find('img').remove()
        </script>

    </body>
</html>