<?php 

// require_once "Utilities/config.php";


?>


<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="<?php echo($web->brgy); ?>">
        <title><?php echo($web->brgy); ?></title>
        <meta name="description" content="<?php echo($web->brgy); ?>"> 
        <?php require_once "head.php" ?>
    </head>
    
    <body id="top">

        <main>
            
            <?php include_once 'header_nav.php' ?>
            
            

            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('admin/Media/images/home_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
            <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-5 col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>home">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">404</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Not Found</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container d-block position-relative">
                    <div class="display-4 text-muted text-center">
                        <strong>
                            Page Not Found.
                        </strong>
                    </div>
                </div>
            </section>


                
            
        </main>
		
        <?php 
            require_once 'footer.php';
        ?>

    </body>
</html>