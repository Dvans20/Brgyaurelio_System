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

            <h2 class="display-6 pop_in_on_scroll"> 
                <span class="fas fa-money-bill-wave"></span> Payments
            </h2>

            <div class="card pop_in_on_scroll my-2">
                <div class="card-header">
                    <div class="row p-0 m-0">
                        <div class="col-md-5 p-1">
                            <form id="searchForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Search" oninput="this.value = this.value.replace(/[^a-z,A-Z]/g, '')">
                                    <button class="btn btn-primary input-group-text" type="submit">
                                        <span class="fas fa-search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 p-1">
                            <select name="collectionFilter" id="collectionFilter" class="form-select">
                                <option value="">All</option>
                                <option value="Cedula">Cedula</option>
                                <option value="Penalty">Penalty</option>
                                <option value="Certification">Certification</option>
                                <option value="Brgy. Clearance">Brgy. Clearance</option>
                                <option value="Brgy. Clearance for Businesses">Brgy. Clearance for Businesses</option>
                            </select>
                        </div>
                        <div class="col-md-3 p-1">
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#paymentFormModal">
                                Add New Payment
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">OR. No.</th>
                                    <th class="text-center">Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="paymentsList"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end" id="paymentsLinks"></div>
                </div>
            </div>


            
        </div>


    </div>









    <div class="modal fade" id="paymentFormModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="paymentForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-1">
                            <label for="natureOfCollection">Payment For</label>
                            <select name="natureOfCollection" id="natureOfCollection" class="form-select">
                                <option value="">Select Nature of Collection</option>
                                <option value="1">Cedula</option>
                                <option value="2">Penalty</option>
                                <option value="3">Certification</option>
                                <option value="4">Brgy. Clearance</option>
                                <option value="5">Brgy. Clearance for Businesses</option>
                                <option value="99">Others</option>
                            </select>
                            <input type="text" class="form-control form-control-underline fade_in d-none" name="natureOfCollectionIn" id="natureOfCollectionIn" placeholder="Type payment for here">
                        </div>
                        <div class="p-1">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="Description">
                        </div>
                        <div class="p-1">
                            <label for="payorsNamessss">Name</label>
                            <div class="input-group">
                                <button class="btn input-group-text btn-primary" id="selectCitizenBtn" type="button">
                                    Select Citizen
                                </button>
                                <input type="text" class="form-control" name="payorsName" id="payorsName" placeholder="Name" disabled>
                                <input type="text" name="citizenId" id="citizenId" class="d-none">
                                <input type="text" name="violatorId" id="violatorId" class="d-none">
                            </div>
                        </div>
                        <div class="p-1">
                            <label for="orNo">OR Number</label>
                            <input type="text" class="form-control" name="orNo" id="orNo" placeholder="OR Number">
                        </div>

                        <div class="row p-0 m-0">
                            <div class="p-1 col-sm">
                                <label for="date">Date</label>
                                <input type="date" class="form-control date-input" name="date" id="date" value="<?php echo(date("Y-m-d")); ?>">
                            </div>
                            <div class="p-1 col-sm">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="00.00">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-sm p-1 px-3">
                                <label for="cash">
                                    <input type="radio" class="form-check-input" name="paymentType" id="cash" value="cash">
                                    Cash
                                </label>
                            </div>
                            <div class="col-sm p-1 px-3">
                                <label for="check">
                                    <input type="radio" class="form-check-input" name="paymentType" id="check" value="check">
                                    Check
                                </label>
                            </div>
                            <div class="col-sm p-1 px-3">
                                <label for="moneyOrder">
                                    <input type="radio" class="form-check-input" name="paymentType" id="moneyOrder" value="moneyOrder">
                                    Money Order
                                </label>
                            </div>
                        </div>
                        
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
                    <button class="btn btn-primary" type="button" id="selectCitizenBtn" onclick="selectCitizen()">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="selectCitizenWPenaltyModal">
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
                        <form id="searchCitizenWPenaltyForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchCitizenWPenlaty" id="searchCitizenWPenlaty" placeholder="Search">
                                <button class="btn btn-primary input-group-text" type="submit" id="searchCitizenWPenlatyBtn">
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
                                    <th class="text-nowrap">Violation</th>
                                    <th class="text-nowrap">Amount</th>
                                    <th class="text-nowrap">Purok</th>
                                    <th class="text-nowrap">Name</th>
                                    <th>Birt Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                </tr>
                            </thead>
                            <tbody id="citizensWPenaltyList"></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end" id="citizensLinks"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="selectWPenaltyCitizenBtn" onclick="selectCitizen()">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewPaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">

                    <div class="row p-0 m-0">
                        <div class="p-2 col-md">
                            <b>Date</b>
                            <div id="datePreview"></div>
                        </div>
                        <div class="p-2 col-md">
                            <b>OR No.</b>
                            <div id="orNoPreview"></div>
                        </div>
                    </div>

                    <div class="p-2">
                        <b>Nature of Collection</b>
                        <div id="natureOfCollectionPreview"></div>
                    </div>
                    <div class="p-2">
                        <b>Description</b>
                        <div id="descriptionPreview"></div>
                    </div>
                    <div class="p-2">
                        <b>Name</b>
                        <div id="namePreview"></div>
                    </div>
                    <div class="row p-0 m-0">
                        <div class="p-2 col-md">
                            <b>Amount</b>
                            <div id="amountPreview"></div>
                        </div>
                        <div class="p-2 col-md">
                            <b>&nbsp;</b>
                            <div id="paymentTypePreview"></div>
                        </div>
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

   <input type="hidden" id="currentDate" value="<?php echo(date("Y-m-d")); ?>">

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    <script src="Views/js/payments.js"></script>

</body>
</html>