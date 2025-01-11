<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
?>
<style>
    .chartjs {
        display: flex !important;
        justify-content: center !important; /* Center horizontally */
        align-items: center !important;    /* Center vertically */
        height: 600px !important;    
        width:100%;
        z-index: 99;
    }


    .chart_container {
        position: relative;
    }
    .loader_container {
        position: absolute;
        width: 100%;
        height: 100%;
        top:0;
        left: 0;
        /* z-index: -1; */
        /* background-color: pink; */
    }
    .loader_container .loader08 {
        /* background-color: red; */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(calc(-50% + 30px), calc(-50% - 30px)) scale(1.5) rotate(45deg) !important;
        
        padding: 0 !important;
        margin: auto !important;
    }

    .dash_num .loading_content_loader {
        transform: scale(.5);
        padding: 1rem 0;
    }

    .chart_container_loader {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .chart_container_loader .loading_content_loader {
        position: absolute;
        width: 100%;
        height: 90%;
        top: 0;
        left: 0;
    }
</style>
</head>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>

        <div class="container py-5">
            <h4 class="display-6 pop_in_on_scroll">
                <span class="fas fa-tachometer-alt"></span> <?php echo ($loggedInUser->accessType == 1) ? 'Admin' :'' ?><?php echo ($loggedInUser->accessType == 2) ? 'Secretary' :'' ?><?php echo ($loggedInUser->accessType == 3) ? 'Treasurer' :'' ?> Dashboard
            </h4>

            <div class="row px-0 m-0 py-3">
                <div class="col-md-6 m-0 p-2">
                    <div class="form-floating pop_in_on_scroll">
                        <select name="year" id="year" class="form-select">
                            <?php $year = date('Y') / 1; ?>
                            <?php for ($i = $year; $i >= $year - 10; $i--) { ?>
                                <option value="<?php echo($i); ?>"><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                        <label for="year">Year</label>
                    </div>
                </div>
                <div class="col-md-6 m-0 p-2">
                    <div class="form-floating pop_in_on_scroll">
                        <select name="qtr" id="qtr" class="form-select">
                            <?php $m = date('m') / 1; ?>
                            <?php if ($m <= 6) { ?>
                                <option value="4">3rd - 4th Quarter</option>
                                <option value="2" selected>1st - 2nd Quarter</option>
                            <?php } else { ?>
                                <option value="4" selected>3rd - 4th Quarter</option>
                                <option value="2">1st - 2nd Quarter</option>
                            <?php } ?>
                        </select>
                        <label for="qtr">Quarter</label>
                    </div>
                </div>
            </div>
            <div class="row m-0 px-0 py-3">
                <div class="col-md-6 m-0 p-2">
                    <div class="card bg-dark text-white pop_in_on_scroll">
                        <div class="card-header">
                            <h5 class="h5">Number of Population</h5>
                        </div>
                        <div class="card-body fw-bolds dash_num display-3 text-center text-nowrap" id="numberOfPopulation"></div>
                    </div>
                </div>
                <div class="col-md-6 m-0 p-2">
                    <div class="card bg-secondary text-white pop_in_on_scroll">
                        <div class="card-header">
                            <h5 class="h5">Number of Household</h5>
                        </div>
                        <div class="card-body fw-bolds dash_num display-3 text-center text-nowrap" id="numberOfHouseholds"></div>
                    </div>
                </div>
            </div>

            <div class="row mx-0 px-0 py-3">
                <!-- <div class="col-sm-6 col-md-4 col-lg-3 m-0 p-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">

                        </div>
                    </div>
                </div> -->
                <div class="col-lg-12 m-0 p-2">
                    <div class="card pop_in_on_scroll" id="populationChart">
                        <div class="card position-relative chart_container p-2" id="popUlationBarContainer">
                            <canvas id="popUlationBar" class="chartjs position-relative">
                            </canvas>
                            <div class="chart_container_loader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    <script src="Views/js/dashboard.js"></script>
</body>
</html>