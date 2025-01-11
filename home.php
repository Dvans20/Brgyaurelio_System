

<?php 
    $linkExt =  "";
    include "Utilities/config.php";

    require_once "admin/Models/News.php";
    require_once "admin/Models/Resolution.php";
    require_once "admin/Models/Transparency.php";
    require_once "admin/Models/DocumentType.php";

    $latestNews = News::get("%%", "", 1, 3, 2);

    $resolutions = Resolution::find("", "", "", 1, 3);

    $transparencies = Transparency::find(1, 5, "", "", "", "");

?>

<!doctype html>
<html lang="en">
    <head>
    <meta name="author" content="<?php echo($web->brgy); ?>">
    <title>BRGY. <?php echo(strtoupper($web->brgy)); ?></title>
    <meta name="description" content="Official Web page of Brgy. <?php echo($web->brgy); ?>">   
        <?php 
            require_once "head.php";
        ?>

    
    </head>
    
    <body id="top">

        <main>
    
            

            <?php include_once 'header_nav.php' ?>
            

            <section class="hero-section d-flex justify-content-center align-items-center custom-section-bg-image fixed" id="section_1" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('admin/Media/images/home_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Welcome to BRGY. <?php echo($web->brgy); ?></h1>

                            <h6 class="text-center text-white text-shadow"><?php echo($web->tagline); ?></h6>

                            <!--<form method="get" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">-->
                            <!--    <div class="input-group input-group-lg">-->
                            <!--        <span class="input-group-text bi-search" id="basic-addon1">-->
                                        
                            <!--        </span>-->

                            <!--        <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Search Anything..." aria-label="Search">-->

                            <!--        <button type="submit" class="form-control">Search</button>-->
                            <!--    </div>-->
                            <!--</form>-->
                        </div>

                    </div>
                </div>
            </section>


            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">

                        

                        <div class="col-lg-6 col-12">
                            <div class="custom-block custom-block-overlay shadow-lg">
                                <div class="d-flex flex-column h-100 custom-block-bg-image" style="background-image: url('admin/Media/images/about_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">About Us</h5>

                                            <div id="aboutText" class="text-white custom-block-inner-h my-2">
                                                <?php echo($web->about); ?>
                                            </div>

                                        </div>


                                        <!-- <span class="badge bg-finance rounded-pill ms-auto">25</span> -->
                                    </div>


                                    <div class="social-share d-flex py-2">
                                        <a href="about" class="btn custom-btn my-2" id="aboutReadMore">Read More</a>
                                    </div>

                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <!-- <a href="topics-detail.html"> -->
                                <div class="d-block btn_bgs">
                                    <div>
                                        <!-- <h5 class="mb-2">Web Design</h5> -->

                                        <p class="mb-0">Quick and Easy Document Requests: Get Your Barangay Clearances and Certifications with Just a Few Clicks!</p>
                                    </div>

                                    <div class="pb-2 pt-5">
                                        <a href="requestAuth" href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3 w-100">Request a Certificate</a>

                                        <!-- <button href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3 w-100" data-bs-target="#fileComplaintFormModal" data-bs-toggle="modal">Submit Your Concerns</button> -->

                                        <!-- <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3 w-100" data-bs-target="#provideFeedbackFormModal" data-bs-toggle="modal">Provide Feedback</a> -->
                                    </div>


                                    <!-- <span class="badge bg-design rounded-pill ms-auto">14</span> -->
                                </div>

                                <!-- <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt=""> -->
                                <!-- </a> -->
                            </div>
                        </div>
            

                        <div class="col-lg-5">
                            <a href="<?php echo($web->siteUrl); ?>rbim" class="btn btn-lg custom-btn-2 my-2 py-3 fw-2 px-4 mt-lg-3 m-auto d-block" style="width: 150px;">
                                RBIM
                            </a>
                            <div class="container">
                                <p class="small">
                                    Click the button above to register or update. This will guide you through the registration/update process, allowing you to provide essential information. <i>Join us in fostering inclusivity and support for all residents!</i>
                                </p>
                            </div>
                           
                        </div>
                        <div class="col-lg-5">
                            <a href="<?php echo($web->siteUrl); ?>rbbo" class="btn btn-lg custom-btn-2 my-2 py-3 fw-2 px-4 mt-lg-3 m-auto d-block" style="width: 150px;">
                                RBBO
                            </a>
                            <div class="container">
                                <p class="small">
                                    Click the button above to register or update Your Business. This will guide you through the registration/update process, allowing you to provide essential information. <i>Join us in fostering inclusivity and support for all Business Owners!</i>
                                </p>
                            </div>
                           
                        </div>
                        
                    </div>

                    </div>

                    
                </div>
            </section>


            <section class="explore-section section-padding" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Latest Updates</h1>
                        </div>

                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news-tab-pane" type="button" role="tab" aria-controls="news-tab-pane" aria-selected="true">Latest News</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="resolutions-tab" data-bs-toggle="tab" data-bs-target="#resolutions-tab-pane" type="button" role="tab" aria-controls="resolutions-tab-pane" aria-selected="false">Transparency</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transparency-tab" data-bs-toggle="tab" data-bs-target="#transparency-tab-pane" type="button" role="tab" aria-controls="transparency-tab-pane" aria-selected="false">Issuances</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="program-tab" data-bs-toggle="tab" data-bs-target="#program-tab-pane" type="button" role="tab" aria-controls="transparency-tab-pane" aria-selected="false">Programs</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">

                                <!-- News Content -->
                                <div class="tab-pane fade show active" id="news-tab-pane" role="tabpanel" aria-labelledby="news-tab" tabindex="0">
                                    <div class="row">


                                    <?php foreach ($latestNews as $news) { ?>
                                        
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="<?php echo($web->siteUrl . "news?news=" . $news->id); ?>">
                                                    <div class="d-flex overflow-hidden">
                                                        <div>
                                                            <h5 class="my-2 text-nowrap"><?php echo($news->newsTitle); ?></h5>

                                                            <div class="custom-block-content mb-3 card_news_content"><?php echo($news->newsContent); ?></div>
                                                        </div>
                                                        
                                                        

                                                        <!-- <span class="badge bg-design rounded-pill ms-auto">14</span> -->
                                                    </div>
                                                    <?php if (empty($news->featureImage)) { ?>
                                                        <img src="admin/Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" class="custom-block-image m-0 img-fluid" alt=""<?php echo($news->newsTitle); ?>>
                                                    <?php } else { ?>
                                                        <img src="admin/Media/images/<?php echo($news->featureImage); ?>" class="custom-block-image m-0 img-fluid" alt=""<?php echo($news->newsTitle); ?>>
                                                    <?php } ?>
                                                    
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>




                                        <!-- <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Web Design</h5>

                                                            <p class="mb-0">Topic Listing Template based on Bootstrap 5</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Graphic</h5>

                                                                <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Redesign_feedback_re_jvm0.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Logo Design</h5>

                                                                <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">100</span>
                                                    </div>

                                                    <img src="images/topics/colleagues-working-cozy-office-medium-shot.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <!-- Transparencies Tabbed Pane -->
                                <div class="tab-pane fade" id="resolutions-tab-pane" role="tabpanel" aria-labelledby="resolutions-tab" tabindex="0">
                                    <div class="custom-block bg-white shadow-lg table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Document Title</th>
                                                    <th>Document Details</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($transparencies) <= 0) { ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="my-5 py-5 text-center fs-5 text-muted">
                                                                No Documents have been posted yet.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <?php foreach ($transparencies as $transparency) { ?>
                                                        <tr>
                                                            <td><?php echo($transparency->documentTitle); ?></td>
                                                            <td>
                                                                Type: <?php echo(DocumentType::findById($transparency->documentType)->name); ?>
                                                                <br>
                                                                Year: <?php echo($transparency->calendarYear); ?> 
                                                                <?php 

                                                                    switch ($transparency->quarter) {
                                                                        case 1:
                                                                            echo "[1<sup>st</sup>]";
                                                                            break;
                                                                        case 2:
                                                                            echo "[2<sup>nd</sup>]";
                                                                            break;
                                                                        case 3:
                                                                            echo "[3<sup>rd</sup>]";
                                                                            break;
                                                                        case 4:
                                                                            echo "[4<sup>th</sup>]";
                                                                            break;
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <div class="w-100 d-flex justify-content-end">
                                                                    <a href="<?php echo($web->siteUrl); ?>admin/Media/pdf/<?php echo($transparency->pdfFile); ?>" target="_blank" class="custom-btn btn">
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

                                </div>
                                <div class="tab-pane fade" id="program-tab-pane" role="tabpanel" aria-labelledby="resolutions-tab" tabindex="0">
                                    <div class="custom-block bg-white shadow-lg table-responsive">
                                        <h4>List Of Barangay Programs</h4>
                                        <div class="row">
                                            <?php 
                                            $query = $con->query("SELECT * FROM `programs` WHERE `program_status`=0");
                                            $i = 0;
                                            while ($row = $query->fetch_array()) {
                                                $i++;
                                            ?>
                                            <div class="col-md-4 d-flex p-2">
                                                <div class="card d-flex flex-column w-100 program_list_btn" data-program-id="<?php echo $row[0] ?>" style="height: 100%;background-image: linear-gradient(15deg, #13547a 0%, #80d0c7 100%);cursor:pointer">
                                                    <div class="card-header" style="background-color:transparent;">
                                                        <h4 class="card-title" style="color:white"><?php echo $row['program_name'] ?></h4>
                                                    </div>
                                                    <div class="card-body" style="flex-grow: 1;">
                                                        <p style="color:white;"><?php echo $row['program_desc'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                                  <!-- Resolutions Content -->
                                <div class="tab-pane fade" id="transparency-tab-pane" role="tabpanel" aria-labelledby="transparency-tab" tabindex="0">   <div class="row">

                                    <?php if ($resolutions == null) { ?>
                                        <div class="col-lg-12 col-md-6 col-12 p-3">
                                            <div class="custom-block custom-block-overlay">
                                                <div class="d-flex flex-column h-100">

                                                    <div class="custom-block-overlay-text d-flex mt-5 pt-5">
                                                        <div class="w-100 overflow-hidden">
                                                            <div class="display-6 text-center text-muted">
                                                                No Issuances have been posted.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <?php foreach ($resolutions as $resolution) { ?>
                                            <div class="col-lg-4 col-md-6 col-12 p-3">
                                                <div class="custom-block custom-block-overlay">
                                                    <div class="d-flex flex-column h-100">

                                                        <div class="custom-block-overlay-text d-flex">
                                                            <div class="w-100 overflow-hidden">
                                                                <h5 class="text-white mb-2"><?php echo($resolution->resolutionTitle); ?> No: <?php echo($resolution->resolutionNo); ?> <br><i class="fs-6"><small>Series of <?php echo($resolution->yearSeries); ?></small></i></h5>

                                            
                                                                
                                                                <div class="custom-block-content text-white">
                                                                    <?php echo($resolution->description); ?>
                                                                </div>


                                                                <?php if (!empty($resolution->author)) { ?>
                                                                    <small>
                                                                        <i>
                                                                            Author: <?php echo($resolution->author); ?>
                                                                        </i>
                                                                    </small>
                                                                <?php } ?>

                                                                <a href="admin/Media/pdf/<?php echo($resolution->pdfFile); ?>" target="_blank" class="btn custom-btn mt-2 mt-lg-3">
                                                                    <span class="fas fa-file-pdf"></span> Read More
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="section-overlay"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                </div>
                            </div>

                            <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                        <div class="custom-block bg-white shadow-lg">
                                            <a href="topics-detail.html">
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-2">Composing Song</h5>

                                                        <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                    </div>

                                                    <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                </div>

                                                <img src="images/topics/undraw_Compose_music_re_wpiw.png" class="custom-block-image img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                        <div class="custom-block bg-white shadow-lg">
                                            <a href="topics-detail.html">
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-2">Online Music</h5>

                                                        <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                    </div>

                                                    <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                </div>

                                                <img src="images/topics/undraw_happy_music_g6wc.png" class="custom-block-image img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="custom-block bg-white shadow-lg">
                                            <a href="topics-detail.html">
                                                <div class="d-flex">
                                                    <div>
                                                        <h5 class="mb-2">Podcast</h5>

                                                        <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                    </div>

                                                    <span class="badge bg-music rounded-pill ms-auto">20</span>
                                                </div>

                                                <img src="images/topics/undraw_Podcast_audience_re_4i5q.png" class="custom-block-image img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                    </div>
                </div>
            </section>


            <!-- transparency section -->
            <section class="timeline-section section-padding" id="section_3">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <!-- <img src="admin/Media/images/home_cover.jpg" width="240px" height="auto" alt="Transparency Seal"> -->
                            <h2 class="text-white mb-4">BRGY. OFFICIALS</h1>
                        </div>

                        <div class="col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline row py-4" id="vertical-scrollable-timeline-2">
                                    <li class="col-md-6 m-auto d-block">
                                        <?php if (strpos($web->brgyCaptainName, "Hon.") !== false) { ?>
                                            <h4 class="text-white mb-3"><?php echo($web->brgyCaptainName); ?></h4>
                                        <?php } else { ?>
                                            <h4 class="text-white mb-3">Hon. <?php echo($web->brgyCaptainName); ?></h4>
                                        <?php } ?>

                                        <p class="text-white text-uppercase">PUNONG Barangay</p>

                                        <div class="icon-holder">
                                        <i class="bi-person"></i>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="vertical-scrollable-timeline row" id="vertical-scrollable-timeline">
                                    <!-- <div class="list-progress">
                                        <div class="inner"></div>
                                    </div> -->

                                    

                                    <?php foreach ($web->councilors as $councilor) { ?>
                                        
                                       
                                        <li class="col-md-6">
                                            <?php if (strpos($councilor['name'], "Hon.") !== false) { ?>
                                                <h4 class="text-white mb-3"><?php echo($councilor['name']); ?></h4>
                                            <?php } else { ?>
                                                <h4 class="text-white mb-3">Hon. <?php echo($councilor['name']); ?></h4>
                                            <?php } ?>

                                            <p class="text-white text-uppercase"><?php echo($councilor['designation']); ?></p>

                                            <div class="icon-holder">
                                            <i class="bi-person"></i>
                                            </div>
                                        </li>

                                    <?php } ?>

                                    <li class="col-md-6">
                                        <?php if (strpos($web->skChairmanName, "Hon.") !== false) { ?>
                                            <h4 class="text-white mb-3"><?php echo($web->skChairmanName); ?></h4>
                                        <?php } else { ?>
                                            <h4 class="text-white mb-3">Hon. <?php echo($web->skChairmanName); ?></h4>
                                        <?php } ?>

                                        <p class="text-white text-uppercase">SK Chairman</p>

                                        <div class="icon-holder">
                                          <i class="bi-person"></i>
                                        </div>
                                    </li>





                                    <li class="col-md-6 my-4">

                                        <h4 class="text-white mb-3"><?php echo($web->brgySecretaryName); ?></h4>

                                        <p class="text-white text-uppercase">Secretary</p>

                                        <div class="icon-holder">
                                          <i class="bi-person"></i>
                                        </div>
                                    </li>
                                    <li class="col-md-6 my-4">

                                        <h4 class="text-white mb-3"><?php echo($web->brgyTreasurerName); ?></h4>

                                        <p class="text-white text-uppercase">Treasurer</p>

                                        <div class="icon-holder">
                                          <i class="bi-person"></i>
                                        </div>
                                    </li>

                                    
                                    

                                    <!-- <li>
                                        <h4 class="text-white mb-3">Read &amp; Enjoy</h4>

                                        <p class="text-white">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi vero quisquam, rem assumenda similique voluptas distinctio, iste est hic eveniet debitis ut ducimus beatae id? Quam culpa deleniti officiis autem?</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                        </div>

                        <!-- <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Want to learn more?
                                <a href="#" class="btn custom-btn custom-border-btn ms-3">Check out Youtube</a>
                            </p>
                        </div> -->
                    </div>
                </div>
            </section>


            <!-- FAQ Question -->
            <!-- <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Frequently Asked Questions</h2>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-lg-5 col-12">
                            <img src="images/faq_graphic.jpg" class="img-fluid" alt="FAQs">
                        </div>

                        <div class="col-lg-6 col-12 m-auto">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is Topic Listing?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Topic Listing is free Bootstrap 5 CSS template. <strong>You are not allowed to redistribute this template</strong> on any other template collection website without our permission. Please contact TemplateMo for more detail. Thank you.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How to find a topic?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            You can search on Google with <strong>keywords</strong> such as templatemo portfolio, templatemo one-page layouts, photography, digital marketing, etc.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Does it need to paid?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section> -->


            <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">Contact Us</h2>
                        </div>

                        <div class="col-lg-8 col-12 mb-4 mb-lg-0">
                            <style>
                                iframe {
                                    width: 100% !important;
                                    height: 100% !important;
                                }
                            </style>
                            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1846.4857697666534!2d125.57672271530565!3d10.010161618733278!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3306b7f005d8ae8d%3A0xe87cf0a819a1c12a!2sAurello%20Gym!5e1!3m2!1sen!2sph!4v1729239793370!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->

                            <?php echo($web->embeddedMap); ?>
                            
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">BRGY. OFFICE</h4>

                            <p><?php echo($web->address); ?></p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 305-240-9671" class="site-footer-link">
                                    <?php echo($web->contactNo); ?>
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    <?php echo($web->email); ?>
                                </a>
                            </p>
                        </div>

                        <!-- <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Dubai office</h4>

                            <p>Burj Park, Downtown Dubai, United Arab Emirates</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 110-220-3400" class="site-footer-link">
                                    110-220-3400
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    info@company.com
                                </a>
                            </p>
                        </div> -->

                    </div>
                </div>
            </section>



        </main>

        <div class="modal fade" id="requestCertificateFormModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="requestCertificateForm" autocomplete="off" class="custom-form">
                        <div class="modal-header">
                            <h5>Request a Certificate</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row p-0 m-0">
                                <div class="col-lg px-2 m-0">
                                    <div class="form-floating">
                                        <input type="text" name="reqName" id="reqName" placeholder="Name" class="form-control">
                                        <label for="reqName">Name</label>
                                    </div>
                                </div>
                                <div class="col-lg px-2 m-0">
                                    <div class="form-floating">
                                        <input type="text" name="reqEmail" id="reqEmail" placeholder="Email" class="form-control">
                                        <label for="reqEmail">Email</label>
                                    </div>
                                </div>
                                <div class="col-lg px-2 m-0">
                                    <div class="form-floating">
                                        <input type="text" name="reqContactNumber" id="reqContactNumber" placeholder="Contact No." class="form-control">
                                        <label for="reqContactNumber">Contact No.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="reqAddress" id="reqAddress" placeholder="Address">
                                    <label for="reqAddress">Address</label>
                                </div>
                            </div>
                            
                            <div class="py-2">

                                <b>Certificates</b>
                                <small>Select the certificate you want to request</small>
                                <div class="row p-0 m-0">
                                    <div class="col-md-6 py-2">
                                        <label for="brgyClearance" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="brgyClearance" value="Barangay Clearance"> Barangay Clearance
                                        </label>
                                    </div>
                                    <!-- <div class="col-md-6 py-2">
                                        <label for="indigency" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="indigency" value="Indigency Certification"> Indigency Certification
                                        </label>
                                    </div> -->
                                    <div class="col-md-6 py-2">
                                        <label for="residency" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="residency" value="Residency Certification"> Residency Certification
                                        </label>
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label for="lowIncome" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="lowIncome" value="Low Income Certification"> Low Income Certification
                                        </label>
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label for="brgyBusClearance" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="brgyBusClearance" value="Barangay Business Clearance"> Barangay Business Clearance 
                                        </label>
                                    </div>
                                    <div class="col-md-6 py-2">
                                        <label for="brgyCedula" class="cursor-pointer">
                                            <input type="checkbox" class="form-check-input" name="certificate" id="brgyCedula" value="Cedula"> Cedula 
                                        </label>
                                    </div>
                                    

                                </div>
                            </div>

                            <input type="text" value="Pick-Up at Brgy. Office" name="reptMethod" id="reptMethod" class="d-none">

                            <div class="form-floating my-2">
                                <input type="text" name="reqPurpose" id="reqPurpose" class="form-control" placeholder="State Your Purpose">
                                <label for="reqPurpose">State Your Purpose</label>
                            </div>

                            <div class="p-2">
                                <label for="reqDescription">Description <small>Please describe the important details of your request including it's purpose</small></label>
                                <textarea name="reqDescription" id="reqDescription" class="form-control" rows="5"></textarea>
                            </div>
                            
                        </div>
                        <div class="modal-footer">

                            <button class="btn btn custom-btn" data-bs-dismiss="modal" type="button">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fileComplaintFormModal" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="fileComplaintForm" class="custom-form">
                        <div class="modal-header">
                            <h3>Make a Complaint</h3>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">


                            <div class="row m-0 p-0">
                                <div class="col-md-12 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="compName" id="compName" placeholder="Name" class="form-control">
                                        <label for="compName">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="compEmail" id="compEmail" placeholder="Email" class="form-control">
                                        <label for="compEmail">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="compContactNo" id="compContactNo" placeholder="Contact No." class="form-control">
                                        <label for="compContactNo">Contact No.</label>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            
                            
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain1">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain1" value="Service Delivery">
                                            Service Delivery: <small>(Poor or inefficient services provided by the barangay, such as delays in processing documents or inadequate service delivery.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain2">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain2" value="Administrative Inefficiency">
                                            Administrative Inefficiency: <small>(Bureaucratic delays, poor management of records, or unresponsiveness from barangay officials.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain3">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain3" value="Public Safety">
                                            Public Safety: <small>(Inadequate measures for community safety, such as ineffective patrols, lack of security lighting, or slow response to emergencies.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain4">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain4" value="Cleanliness and Maintenance">
                                            Cleanliness and Maintenance: <small>(Problems with the upkeep of public areas, including cleanliness of streets, parks, and public facilities.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain5">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain5" value="Discrimination and Favoritism">
                                            Discrimination and Favoritism: <small>(Unfair treatment or favoritism in the delivery of services or allocation of resources.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain6">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain6" value="Noise Pollution">
                                            Noise Pollution: <small>(Excessive noise from community events, public markets, or other sources, impacting the quality of life.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain7">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain7" value="Illegal Activities">
                                            Illegal Activities: <small>(Illegal activities or violations of local ordinances, such as illegal gambling, unauthorized vendors, or unlicensed businesses.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain8">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain8" value="Health and Sanitation">
                                            Health and Sanitation: <small>(Public health issues, such as improper waste disposal, sanitation problems, or lack of health services.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain9">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain9" value="Health and Sanitation">
                                            Community Relations: <small>(Conflicts between residents, inadequate conflict resolution, or lack of community engagement and support.)</small>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label class="cursor-pointer" for="complain10">
                                            <input type="checkbox" class="form-check-input" name="complain" id="complain10" value="Health and Sanitation">
                                            Zoning and Land Use: <small>(Zoning regulations, land use disputes, or improper land development.)</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <label for="description">Description <small>(Explain the details of your Complaints)</small></label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary custom-btn" id="fileComplaintBtn" type="submit">
                                Submit
                            </button>
                            <button class="btn btn-secondary custom-btn" data-bs-dismiss="modal" type="button">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="provideFeedbackFormModal">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <form id="provideFeedbackForm" autocomplete="off" class="custom-form">
                        <div class="modal-header">
                            <h5>Provide Feedback</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">

                            <div class="p-2">
                                <div class="form-floating">
                                    <input type="text" name="pvName" id="pvName" placeholder="Name" class="form-control">
                                    <label for="pvName">Name</label>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="form-floating">
                                    <input type="text" name="pvEmail" id="pvEmail" placeholder="Email" class="form-control">
                                    <label for="pvEmail">Email</label>
                                </div>
                            </div>

                            <div class="p-2">
                                <label for="feedback">Description <small>(Explain the details of your feedack)</small></label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary custom-btn" id="provideFeedbackBtn" type="button">
                                Submit
                            </button>
                            <button class="btn btn-secondary custom-btn" data-bs-dismiss="modal" type="button">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
<div class="modal fade" id="program_list">
    <div class="modal-dialog modal-lg modal-dialog-centered" id="program_content"

    </div>
</div>

        <?php 
            require_once 'footer.php';
        ?>
        <script src="js/home.js"></script>
        <script>
            $('.card_news_content').find('img').remove()
        </script>
        <script>
            $('.program_list_btn').click(function(){
              Pid =   $(this).attr('data-program-id');
                    $.ajax({
                        type:'GET',
                        url:'admin/submits/program_list_modal.php',
                        data:{
                            program_id:Pid
                        },
                        dataType:'html'
                    }).done(function(data){
                        $('#program_content').html('');
                        $('#program_content').html(data);
                        $("#program_list").modal('show');
                    })
            })
        </script>
    </body>
</html>
