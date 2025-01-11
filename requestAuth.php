<?php 

require_once "Utilities/config.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['brgy_household_id'])) {
    header("Location: certificate_request");
    exit();
} else {
    



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
            <style>
                #passKeyToggleVisibilityBtn {
                    position: absolute;
                    right: 10px;
                    top: 15px;
                    z-index: 5;
                }

                .table th, .table td {
                    vertical-align: middle;
                }
            </style>
            

            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('admin/Media/images/home_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
            <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-12 col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>home">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Request Certificate</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Request Certificate</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 m-auto d-bock">
                            <div class="custom-block bg-white shadow-lg">
                                <form class="custom-form" id="requestAuthForm">
                                        
                            
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="householdNo" id="householdNo" placeholder="Enter your Household No.">
                                        <label for="householdNo">Enter your Household No.</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="householdKey" id="householdKey" placeholder="Enter your Household Key">
                                        <label for="householdKey">Enter your Household Key</label>
                                    </div>
                            
                
                                    <div class="d-flex w-100">
                                        <a href="home" class="btn btn-sm btn-secondary custom-btn fs-6 m-1 w-100" type="button">
                                            <span class="fas fa-ban"></span> Cancel
                                        </a>
                                        <button class="btn btn-sm btn-primary custom-btn fs-6 m-1 w-100" type="submit">
                                            <span class="fas fa-paper-plane"></span> Submit
                                        </button>
                                    </div>
                            
                                </form>
                            </div>
                        </div>
                    </div>

               
                  
                </div>


                

            </section>


                
            
        </main>

    
		
        <?php 
            require_once 'footer.php';
        ?>
        <script src="js/requestAuth.js<?php echo("?v=" . time().uniqid()); ?>"></script>

    </body>
</html>

<?php 
    }
?>