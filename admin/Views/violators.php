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

        
        <div class="container w-100 py-5">
        
            <h3 class="w-100">
                <span class="fas fa-uset-times"></span> Offenders
            </h3>

            <div class="row p-0 m-0">
                <div class="col-lg-8 m-0 p-2">



                    <div class="card pop_in_on_scroll">

                        <div class="card-header p-2">
                            <div class="row p-0 m-0">
                                <div class="col-md-5 p-1">
                                    <form id="searchForm">
                                        <div class="input-group p-0">
                                            <input type="text" class="form-control" name="search" id="search" placeholder="Search" oninput="this.value = this.value.replace(/[^a-z,A-Z]/g, '')">
                                            <button class="btn btn-primary" type="submit">
                                                <span class="fas fa-search"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-5 p-1">
                                    <select name="violationFilter" id="violationFilter" class="form-select"></select>
                                </div>
                                <div class="col-md-2 p-1">
                                    <button class="btn btn-primary text-nowrap float-end" data-bs-toggle="modal" data-bs-target="#violatorsFormModal">
                                        <span class="fas fa-user-plus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Purok</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Violation</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="violatorsList"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end" id="violatorsLinks"></div>
                        </div>

                    </div>

                </div>




                <div class="col-lg-4 m-0 p-2">
                    <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <strong>Violations</strong>
                            <button class="btn-sm btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#violationFormModal">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" >
                                <tbody id="violationsList"></tbody>
                            </table>
                        </div>
                        
                    </div>
                    
                </div>
            </div>

        </div>


    </div>


   

    <div class="modal fade" id="violationFormModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="violationForm">
                    <div class="modal-header">
                        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="p-1">
                            <label for="violation">Violation</label>
                            <input type="text" class="form-control" name="violation" id="violation" placeholder="Violation">
                        </div>
                        <div class="p-1">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                        </div>
                        <div class="p-1">
                            <label for="penaltyType">Penalty Resolution</label>
                            <select class="form-select" name="penaltyType" id="penaltyType">
                                <option value="">Select Penalty Resolution</option>
                                <option value="1">Payment Only</option>
                                <option value="2">Service Only</option>
                                <option value="3">Either Payment or Service</option>
                                <option value="4">Both Payment and Service</option>
                            </select>   
                        </div>

                        <div class="p-1 fade_in d-none" id="payableAmountCont">
                            <label for="payableAmount">Payable Amount</label>
                            <input type="text" class="form-control" name="payableAmount" id="payableAmount" placeholder="00.00">
                        </div>
                        <div class="p-1 fade_in d-none" id="serviceCont">
                            <label for="service">Service Description</label>
                            <input type="text" class="form-control" name="service" id="service" placeholder="Service Description">
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" type="submit">
                            Save
                        </button>
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>
                </form>
                
            </div>
        </div>

    </div>

    <div class="modal fade" id="violatorsFormModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="violatorsForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="d-none" id="citizenId" name="citizenId">
                        <div class="input-group p-1">
                            <button class="btn btn-primary input-group-text" type="button" id="searchCitizenModalBtn" onclick="selectCitizenModalBS.show()">
                                Search Citizen
                            </button>
                            <div class="form-control disabled" name="citizenName" id="citizenName" disabled>Citizen's Name</div>
                        </div>
                        <div class="p-1">
                            <label for="violationId">Violation</label>
                            <select name="violationId" id="violationId" class="form-select">

                            </select>
                        </div>
                        <div id="violationDescription" class="p-1">

                        </div>
                        <br>
                        <div class="p-1">
                            <label for="dateOccured">Date Occured</label>
                            <input type="date" name="dateOccured" id="dateOccured" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span>
                        </button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            <span class="fas fa-times"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="selectCitizenModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5">
                        Select a Citizen
                    </h5>
                    <button class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-block w-100">
                        <form id="searchCitizenForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchCitizen" id="searchCitizen" placeholder="Search">
                                <button class="btn btn-primary input-group-text" type="submit" id="searchCitizenBtn">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <!-- <th class="text-nowrap">Year</th> -->
                                    <!-- <th class="text-nowrap">Qtr</th> -->
                                    <th class="text-nowrap">Purok</th>
                                    <th class="text-nowrap">Last Name</th>
                                    <th class="text-nowrap">First Name</th>
                                    <th class="text-nowrap">Middle Name</th>
                                    <th>Name Extension</th>
                                    <th>Birt Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                </tr>
                            </thead>
                            <tbody id="citizensList"></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end" id="citizensLinks"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="selectCitizenBtn">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="violatorsPreviewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Name</td><td>:</td><td id="namePreview"></td>
                        </tr>
                        <tr>
                            <td>Purok</td><td>:</td><td id="purokPreview"></td>
                        </tr>
                        <tr>
                            <td>Violation</td><td>:</td><td id="violationPreview"></td>
                        </tr>
                        <tr>
                            <td>Penalty</td><td>:</td><td id="penaltyPreview"></td>
                        </tr>
                        <tr>
                            <td>Date Occured</td><td>:</td><td id="dateOccuredPreview"></td>
                        </tr>
                    </table>

                    <div id="descriptionPreview" class="p-1">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="violatorsStatusFormModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="violatorsStatusForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="d-none" name="statusViolatorId" id="statusViolatorId">
                        
                        <!-- <label for="status0" class="cursor-pointer">
                            <input type="radio" class="form-check-input" name="status" id="status0" value="0">
                            No Action yet
                        </label> -->
                        
                        <label for="status2" class="cursor-pointer">
                            <input type="checkbox" class="form-check-input" name="status" id="status2" value="2">
                            <strong>Finished performing the service.</strong>
                        </label>
                        <br>
                        <small>
                            By checking the box above, this confirms that the person has completed their service.
                        </small>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            Save
                        </button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>

    <script src="Views/js/violations.js<?php echo("?v=" . time() . uniqid()); ?>"></script>
    <script src="Views/js/violators.js<?php echo("?v=" . time() . uniqid()); ?>"></script>

</body>
</html>