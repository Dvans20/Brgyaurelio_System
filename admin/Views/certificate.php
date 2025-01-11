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
            <h3 class="py-2">
                <span class="fas fa-scroll"></span> Certificates/Clearance
            </h3>
            <div class="card pop_in_on_scroll">
                <div class="card-header">
                    <div class="row m-0 p-0">
                        <div class="col-sm-6 p-2 m-0">
                            <div class="form-floating">
                                <select name="certificate" id="certificate" class="form-select">
                                    <option value="">Select Certificate</option>
                                    <option value="brgyClearance">Barangay Clearance</option>
                                    <!-- <option value="lowIncomeCertificate">Low Income Certification</option> -->
                                    <option value="residencyCertificate">Certification</option>
                                    <option value="brgyBusClearanceCertificate">Barangay Business Clearance</option>
                                </select>
                                <label for="certificate">Certificate</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="brgyClearanceForm" class="cert_form d-none fade_in p-2 px-4">
                        <!-- <form id="brgyClearanceFormf"> -->
                            <!-- <h5 class="h5">Brgy. Clearance Form</h5> -->
                            <button class="btn btn-primary m-auto d-block" type="button" id="openSelectCitizenModalBtn">
                                Select Citizen
                            </button>
                            <br>

                            <div class="row m-0 p-0">
                                <div class="col-lg-9 col-md-8 p-0 m-0 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="brgyClearancePurpose" name="brgyClearancePurpose" placeholder="Purpose">
                                        <label for="brgyClearancePurpose">Purpose</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 p-0 m-0 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="brgyClearanceCoveringYear" name="brgyClearanceCoveringYear" placeholder="Record period covering from year">
                                        <label for="brgyClearanceCoveringYear">Record period covering from year</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="brgyClearanceCTCNo" name="brgyClearanceCTCNo" placeholder="CTC No.">
                                        <label for="brgyClearanceCTCNo">CTC No.</label>
                                    </div>
                                </div>  
                                <div class="col-lg-3 col-md-6 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="brgyClearanceORNo" name="brgyClearanceORNo" placeholder="OR No.">
                                        <label for="brgyClearanceORNo">OR No.</label>
                                    </div>
                                </div> 
                                <div class="col-lg-3 col-md-6 p-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="brgyClearanceIssuedOn" name="brgyClearanceIssuedOn" placeholder="Issued on">
                                        <label for="brgyClearanceIssuedOn">Issued on</label>
                                    </div>
                                </div>  
                                <div class="col-lg-3 col-md-6 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="brgyClearanceIssuedAt" name="brgyClearanceIssuedAt" placeholder="Issued at">
                                        <label for="brgyClearanceIssuedAt">Issued at</label>
                                    </div>
                                </div> 
                            </div>
                            <br>
                            <button class="btn btn-primary m-auto d-block" type="button" id="updateBrgyClearanceInfo">
                                Generate Info
                            </button>
                            
                        <!-- </form> -->
                    </div>

                    <div id="residencyCertificateForm" class="cert_form d-none fade_in p-2">

                        <div class="row m-0 p-2">
                            <div class="col-md-2 col-sm-3 p-2">
                                <input type="hidden" name="householdId" id="householdId">
                                <button class="btn btn-primary mx-1 my-auto d-block w-100" type="button" id="openSelectCitizenModalBtn2">
                                    Select Citizen
                                </button>
                            </div>
                           <div class="col-md-10 col-sm 3 p-2">
                                <div class="d-flex w-100">
                                    <div class="px-2 w-100">
                                        <input type="text" id="certification1stNameDisplay" class="form-control" disabled placeholder="1st Person">
                                    </div>
                                    <div class="px-2 w-100">
                                        <input type="text" id="certification2ndNameDisplay" class="form-control" disabled placeholder="2nd Person">
                                    </div>
                                </div>
                           </div>
                           <div class="col-12">
                                <label for="second_person" class="cursor-pointer">
                                    <input type="checkbox" name="second_person" id="second_person" class="form-check-input" checked>
                                    2nd Person will be save as selected above
                                </label>
                                 or <a href="#" id="openSelectSecondCitizenModalBtn2">Select another person from the member of the household.</a>
                           </div>
                           <div class="col-12">
                                <label for="third_person" class="cursor-pointer">
                                    <input type="checkbox" name="third_person" id="third_person" class="form-check-input">
                                    2nd Person is the person who requested.
                                </label>
                           </div>
                        </div>

                        <div id="residencyCertificateFormCitizenChecks" class="row p-2 m-0">
                            <div class="col-12 p-2">
                                <small>Check the information you want to include on certificate</small>
                            </div>
                            <div class="col-md-3 col-sm-6" id="certification_monthly_income_cont">
                                <label for="certification_monthly_income" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="certification_check_input" id="certification_monthly_income">
                                     Monthly Income
                                </label>
                            </div>
                            <div class="col-md-3 col-sm-6" id="certification_solo_parent_cont">
                                <label for="certification_solo_parent" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="certification_check_input" id="certification_solo_parent">
                                     Solo Parent
                                </label>
                            </div>
                            <div class="col-md-3 col-sm-6" id="certification_pwd_cont">
                                <label for="certification_pwd" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="certification_check_input" id="certification_pwd">
                                     Person with Disability (PWD)
                                </label>
                            </div>
                            
                            <div class="col-md-3 col-sm-6" id="certification_custom_cont">
                                <label for="certification_custom" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="certification_check_input_custom" id="certification_custom">
                                     Custom Citation
                                </label>
                                
                            </div>
                            <div class="col-12 p-2 pt-3 d-none fade_in" id="certification_input_custom_cont">
                                <label for="certification_input_custom">Custom Citation</label>
                                <textarea name="certification_input_custom" id="certification_input_custom" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row p-2 m-0">
                            <div class="col-lg-9 col-md-8 m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" name="certificationPurpose" id="certificationPurpose" class="form-control" placeholder="Purpose">
                                    <label for="certificationPurpose">Purpose</label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 m-0 p-2">
                                <div class="d-flex">
                                    
                                    <button class="btn btn-primary mx-1 my-auto d-block w-100" type="button" id="updateCertificationBtn">
                                        Update <br> Certificate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="brgyBusClearanceCertificateForm" class="cert_form d-none fade_in p-2">
                        
                        <div class="row p-0 m-0">
                            <div class="col-lg-2 col-sm-4 p-2" id="selectBusOwnerBtn">
                                <button class="btn btn-primary w-100">Select Business Owner</button>
                            </div>
                            <div class="col-lg-5 col-sm-4 p-2">
                                <div class="form-floating">
                                    <input type="text" name="brgyBusClearanceOwnersName" id="brgyBusClearanceOwnersName" placeholder="Owner's Name" class="form-control" disabled>
                                    <label for="brgyBusClearanceOwnersName">Owner's Name</label>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-4 p-2">
                                <div class="form-floating">
                                    <input type="text" name="brgyBusClearanceBusinessName" id="brgyBusClearanceBusinessName" placeholder="Business Name" class="form-control" disabled>
                                    <label for="brgyBusClearanceBusinessName">Business Name</label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="brgyBusClearanceCTCNo" name="brgyBusClearanceCTCNo" placeholder="CTC No.">
                                    <label for="brgyBusClearanceCTCNo">CTC No.</label>
                                </div>
                            </div>  
                            <div class="col-lg-3 col-md-6 p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="brgyBusClearanceORNo" name="brgyBusClearanceORNo" placeholder="OR No.">
                                    <label for="brgyBusClearanceORNo">OR No.</label>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-6 p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="brgyBusClearanceIssuedAt" name="brgyBusClearanceIssuedAt" placeholder="Issued at">
                                    <label for="brgyBusClearanceIssuedAt">Issued at</label>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-6 p-2">
                                <div class="form-floating">
                                    <input type="hidden" class="form-control" id="brgyBusClearanceIssuedOn" name="brgyBusClearanceIssuedOn" value="<?php echo date('Y-m-d') ?>" placeholder="Issued on">
                                    <!--<label for="brgyBusClearanceIssuedOn">Issued on</label>-->
                                </div>
                            </div> 
                        </div>
                        <br>
                        <button class="btn-primary btn d-block m-auto btn-lg" id="genBrgyBusCertInfoBtn">
                            Generate Info
                        </button>
                    </div>
                    
                    <?php require_once "Views/certificates.php"; ?>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" id="printCertificateBtn">
                            <span class="fas fa-print"></span> Print
                        </button>
                    </div>
                </div>



            </div>  
        </div>

       


        <div class="py-2"></div>

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
                        <form id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchCitizen" id="searchCitizen" placeholder="Search">
                                <button class="btn btn-primary input-group-text" id="searchCitizenBtn">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                        <input type="hidden" id="isSecondPerson" name="isSecondPerson">
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-nowrap">Year</th>
                                    <th class="text-nowrap">Qtr</th>
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

    <div class="modal fade" data-bs-backdrop="static" id="selectBusModal">
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
                        <form id="searchBusForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchBus" id="searchBus" placeholder="Search">
                                <button class="btn btn-primary input-group-text" id="searchBusBtn">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                        <input type="hidden" id="isSecondPerson" name="isSecondPerson">
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-nowrap text-center">Year</th>
                                    <th class="text-nowrap text-center">Qtr</th>
                                    <th class="text-nowrap text-center">Purok</th>
                                    <th class="text-nowrap text-center">Owner's Name</th>
                                    <th class="text-nowrap text-center">Business Name</th>
                                </tr>
                            </thead>
                            <tbody id="busList"></tbody>
                        </table>
                    </div>
                    <!-- <div class="d-flex justify-content-end" id="citizensLinks"></div> -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="selectBusBtn">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    <script src="Views/js/certificate.js<?php echo("?v=" . time().uniqid()); ?>"></script>
</body>
</html>