<?php 

    $news = News::findById($newsId);
?>


<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="<?php echo($news->newsTitle); ?>">
        <title><?php echo($news->newsTitle); ?></title>
        <meta name="description" content="<?php echo($news->newsTitle); ?>"> 
        <?php require_once "../head.php" ?>
    </head>
    
    <body id="top">

        <main>

            <?php include_once '../header_nav.php' ?>
            
            

            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('../admin/Media/images/news_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
                <div class="container">
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-3 col-12">
                            <div class="topics-detail-block">
                                <?php if (empty($news->featureImage)) { ?>
                                    <img src="../admin/Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?>" class="topics-detail-block-image img-fluid shadow-lg m-auto d-block" alt="<?php echo($news->newsTitle); ?>">
                                <?php } else { ?>
                                    <img src="../admin/Media/images/<?php echo($news->featureImage); ?>" class="topics-detail-block-image img-fluid shadow-lg m-auto d-block" alt="<?php echo($news->newsTitle); ?>">
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-lg-9 col-12 mt-5">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>">Home</a></li>

                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl . "news"); ?>">News</a></li>
                                </ol>
                            </nav>

                            <h2 class="text-white"><?php echo($news->newsTitle); ?></h2>

                            <!-- <div class="d-flex align-items-center mt-5">
                                <a href="#topics-detail" class="btn custom-btn custom-border-btn smoothscroll me-4">Read More</a>

                                <a href="#top" class="custom-icon bi-bookmark smoothscroll"></a>
                            </div> -->
                        </div>

                        

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 m-auto">
                            <!-- <h3 class="mb-4">Introduction to Web Design</h3>

                            <p>So how can you stand out, do something unique and interesting, build an online business, and get paid enough to change life. Please visit TemplateMo website to download free website templates.</p>

                            <p><strong>There are so many ways to make money online</strong>. Below are several platforms you can use to find success. Keep in mind that there is no one path everyone can take. If that were the case, everyone would have a million dollars.</p>

                            <blockquote>
                                Freelancing your skills isn’t going to make you a millionaire overnight.
                            </blockquote>

                            <div class="row my-4">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <img src="../images/businesswoman-using-tablet-analysis.jpg" class="topics-detail-block-image img-fluid">
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0 mt-md-0">
                                    <img src="../images/colleagues-working-cozy-office-medium-shot.jpg" class="topics-detail-block-image img-fluid">
                                </div>
                            </div>

                            <p>Most people start with freelancing skills they already have as a side hustle to build up income. This extra cash can be used for a vacation, to boost up savings, investing, build business.</p> -->


                            <?php echo($news->newsContent); ?>
                        </div>

                    </div>
                </div>
            </section>


            <!-- <section class="section-padding section-bg">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-5 col-12">
                            <img src="../images/rear-view-young-college-student.jpg" class="newsletter-image img-fluid" alt="">
                        </div>

                        <div class="col-lg-5 col-12 subscribe-form-wrap d-flex justify-content-center align-items-center">
                            <form class="custom-form subscribe-form" action="#" method="post" role="form">
                                <h4 class="mb-4 pb-2">Get Newsletter</h4>

                                <input type="email" name="subscribe-email" id="subscribe-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email Address" required="">

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control">Subscribe</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section> -->
        </main>
		
        <?php 
            require_once '../footer.php';
        ?>

    </body>
</html>