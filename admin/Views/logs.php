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

        <div class="container py-5">


            <div class="card pop_in_on_scroll">
                <div class="card-header">
                    <div class="row m-0 p-0">
                        <div class="col-lg-4 m-0 p-0">
                            <h4 class="h4 py-2">
                                <span class="fas fa-history"></span> Logs
                            </h4>
                        </div>
                        <div class="col-lg-8 m-0 p-0">

                                <form action="searchUsers.php" id="searchForm" class="w-100">
                                    <div class="row m-0 p-0">
                                        <div class="col-md-5 m-0 p-0">
                                            <div class="d-flex">
                                                <div class="form-floating w-100" style="margin-right: -25px; margin-top: 0;">
                                                    <input type="text" class="form-control" id="search" placeholder="Search" oninput="this.value = this.value.replace(/[^a-z,A-Z]/g, '')">
                                                    <label for="search">Search</label>
                                                </div>
                                                <button class="btn-none" type="submit">
                                                    <span class="fas fa-search"></span>
                                                </button>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-7 m-0 p-0">
                                            <div class="row m-0 p-0">
                                                <div class="col-sm-4 p-0 m-0">
                                                    <div class="form-floating w-100">
                                                        <input type="date" name="dateTimeFrom" id="dateTimeFrom" class="form-control">
                                                        <label for="dateTimeFrom">From</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 p-0 m-0">
                                                    <div class="form-floating w-100">
                                                        <input type="date" name="dateTimeTo" id="dateTimeTo" class="form-control">
                                                        <label for="dateTimeTo">To</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 p-0 m-0">
                                                    <button class="btn btn-primary mt-3 w-100 line_text" type="submit">
                                                        <span class="fas fa-filter"></span> Filter
                                                    </button>
                                                </div>
                                                
                                               
                                            </div>
                                        </div>

                                    </div>
                                </form>

                        </div>
                        
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>User's Name</th>
                                    <th>Description</th>
                                    <th>Browser</th>
                                    <th>Operating System</th>
                                    <th>Date & Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="logsList"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end w-100">
                        <div id="logsLinks"></div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>

    <script src="Views/js/logs.js"></script>
</body>
</html>