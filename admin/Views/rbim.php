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
        
            <div class="card pop_in_on_scroll">
                <div class="card-header p-0 m-0 =">
                    <div class="btn-group w-100 table-responsive">
                        <label class="btn btn-lg btn-primary rbim_list_btn" id="pendingRbimListBtn" for="pendingRbimListRadio">
                            Pendings
                        </label>
                        <label class="btn btn-lg btn-primary rbim_list_btn active" id="approvedRbimListBtn" for="approvedRbimListRadio">
                            RBIM
                        </label>
                        <label class="btn btn-lg btn-primary rbim_list_btn" id="declinedRbimListBtn" for="declinedRbimListRadio">
                            Declined
                        </label>
                    </div>
                    <input type="radio" class="d-none" name="RbimListRadio" id="pendingRbimListRadio" value="0">
                    <input type="radio" class="d-none" name="RbimListRadio" id="approvedRbimListRadio" value="1" checked>
                    <input type="radio" class="d-none" name="RbimListRadio" id="declinedRbimListRadio" value="2">

                    <div class="px-3 pt-3">
                        <form action="search.php" id="searchForm">
                            <div class="input-group">
                                <input oninput="this.value = this.value.replace(/[^a-z,A-Z]/g, '')" type="text" class="form-control" name="search" id="search" placeholder="Search">
                                <button class="input-group-text btn btn-primary" type="submit">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="p-1 row m-0">
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="grouped_by">Grouped by:</label>
                            <select name="grouped_by" id="grouped_by" class="form-select">
                                <option value="">Ungrouped</option>
                                <option value="1" selected>Household</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="purok">Purok:</label>
                            <select name="purok" id="purok" class="form-select">
                                <option value="">All</option>
                                <?php foreach ($web->puroks as $purok) { ?>
                                    <option value="<?php echo($purok); ?>"><?php echo($purok); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="year">Year:</label>
                            <select name="year" id="year" class="form-select">
                                <?php for ($i = date('Y'); $i >= date('Y') - 10; $i--) { ?>
                                    <option value="<?php echo($i); ?>"><?php echo($i); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="qtr">Quarter:</label>
                            <select name="qtr" id="qtr" class="form-select">
                                <?php if ((date('m') / 1) <= 6) { ?>
                                    <option value="2" selected>1st & 2nd Quarter</option>
                                    <option value="4">3rd & 4th Quarter</option>
                                <?php } else { ?>
                                    <option value="2">1st & 2nd Quarter</option>
                                    <option value="4" selected>3rd & 4th Quarter</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="unGroupedFilter" class="m-0 p-0 d-none fade_in">
                        
                        <div class="px-3 pb-2 d-flex justify-content-end">
                            <button id="ungroupedFilterBtn" class="btn btn-primary" data-bs-target="#advanceFilterModal" data-bs-toggle="modal">
                                <span class="fas fa-filter"></span> Advance Filter
                            </button>
                        </div>
                        <br>
                        
                    </div>
                    <div id="groupedFilter" class="row m-0 p-0 fade_in">
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="houseOwnershipStatusFilter">House Ownership Status</label>
                            <select name="houseOwnershipStatusFilter" id="houseOwnershipStatusFilter" class="form-select">
                                <option value="">All</option>
                                <option value="1">Owned</option>
                                <option value="2">Rent Only</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="electricityFilter">Electricity</label>
                            <select name="electricityFilter" id="electricityFilter" class="form-select">
                                <option value="">All</option>
                                <option value="1">With Electricity</option>
                                <option value="2">With-out Electricity</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="sanitaryToiletFilter">Sanitary Toilet</label>
                            <select name="sanitaryToiletFilter" id="sanitaryToiletFilter" class="form-select">
                                <option value="">All</option>   
                                <option value="1">With Sanitary Toilet</option>
                                <option value="2">With-out Sanitary Toilet</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 p-2">
                            <label for="monthLyIncomeFilter">Economic Status</label>
                            <select name="monthLyIncomeFilter" id="monthLyIncomeFilter" class="form-select">
                                <option value="0-9999999999999999">All</option>
                                <option value="219140-9999999999999999">Rich: ₱ 219,140 – ₱ 219,140</option>
                                <option value="131484-219140">High: ₱ 131,484 – ₱ 219,140</option>
                                <option value="76669-131484">Upper Middle: ₱ 76,669 – ₱ 131,484</option>
                                <option value="43828-76669">Middle: ₱ 43,828 – ₱ 76,669</option>
                                <option value="21194-43828">Lower middle: ₱ 21,194 – ₱ 43,828</option>
                                <option value="10957-21194">Low income: ₱ 10,957 – ₱ 21,194
                                </option>
                                <option value="0-10957">Poor: Less than ₱ 10,957
                                </option>
                            </select>
                        </div>
                    </div>

                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr id="rbimTHEadRow">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Purok</th>
                                    <th class="text-center">Family Number</th>
                                    <th class="text-center">Household No.</th>
                                    <th class="text-center" id="thName">Head of the Household</th>
                                    
                                    <th id="btnCol"></th>
                                </tr>
                            </thead>
                            <tbody id="rbimList">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row p-0 m-0">
                        <div class="col-md p-0">
                            <button class="btn btn-primary" id="printRBIM">
                                <span class="fas fa-print"></span> Print
                            </button>
                        </div>
                        <div class="col-md p-0">
                            <div class="d-flex justify-content-end" id="rbimLinks"></div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>

        </div>

    </div>



    <div class="modal fade" id="rbimPreviewModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <div class="row m-0 p-0 w-100">
                        <div class="col-lg-5 m-0 p-0">
                            <h4 class="h5 text-nowrap" id="houseHoldNoPreview"></h4>
                        </div>
                        <div class="col-lg-5 m-0 p-0">
                            <div class="d-flex justify-content-end">
                                <h4 class="h5 text-nowrap" id="purokPreview"></h4>
                            </div>
                        </div>
                    </div>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                    
                </div>
                <div class="modal-body">

                    <ul class="previewList">
                        <li>
                            Status of House Ownership : <strong id="houseOwnershipStatusPreview"></strong>
                        </li>
                        <li>
                            Electricity : <strong id="electricityPreview"></strong>
                        </li>
                        <li>
                            Water Source : <strong id="waterSourcesPreview"></strong>
                        </li>
                        <li>
                            Sanitary Toilet : <strong id="sanitaryToiletPreview"></strong>
                        </li>
                        <li>
                            Contact No.: <strong id="contactNoPreview"></strong>
                        </li>
                        <li>
                            Email: <strong id="emailPreview"></strong>
                        </li>
                        <li>
                            Monthly Income: <strong id="monthlyIncomePreview"></strong>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped tabe-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Head of the Household</th>
                                    <th class="text-nowrap">No.</th>
                                    <th class="text-nowrap">Last Name</th>
                                    <th class="text-nowrap">First Name</th>
                                    <th class="text-nowrap">Middle Name</th>
                                    <th class="text-nowrap">Ext. of Name</th>
                                    <th class="text-nowrap">Sex</th>
                                    <th class="text-nowrap">Birth Date</th>
                                    <th class="text-nowrap">Age</th>
                                    <th class="text-nowrap">Birth Place</th>
                                    <th class="text-nowrap">Highest School Attended</th>
                                    <th class="text-nowrap">Occupation</th>
                                    <th class="text-nowrap">Role in Family</th>
                                    <th class="text-nowrap">Civil Status</th>
                                    <th class="text-nowrap">Religion</th>
                                    <th class="text-nowrep">Currently Attending School</th>
                                    <th class="text-nowrep">Solo Parent</th>
                                    <th class="text-nowrap" colspan="2">PWD</th>
                                </tr>
                            </thead>
                            <tbody id="houseHold_familyMembersList_Preview">

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer" id="rbimPreviewModalFooter">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <span class="fas fa-ban"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="declineRBIMUpdateModal" data-bs-backdrop="modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="declineRBIMUpdateForm">
                    <div class="modal-header">
                        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idToDecline" name="idToDecline">

                        <p>
                            Reasons for declining update: 
                        </p>

                        <ul class="list-style-none p-0 mx-0 py-2">
                            
                            <li class="p-2">
                                <label for="reason1" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="reason" id="reason1" value="<b>Incomplete Information: </b>Required fields not filled out or missing necessary data."> 
                                    <b>Incomplete Information: </b>Required fields not filled out or missing necessary data.
                                </label>
                            </li>
                            <li class="p-2">
                                <label for="reason2" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="reason" id="reason2" value="<b>Inconsistent Data: </b>New information doesn’t match existing records."> 
                                    <b>Inconsistent Data: </b>New information doesn’t match existing records.
                                </label>
                            </li>
                            <li class="p-2">
                                <label for="reason3" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="reason" id="reason3" value="<b>Verification Issues: </b>Difficulty verifying the identity of the person making the update."> 
                                    <b>Verification Issues: </b>Difficulty verifying the identity of the person making the update.
                                </label>
                            </li>
                            <li class="p-2">
                                <label for="reason4" class="cursor-pointer">
                                    <input type="checkbox" class="form-check-input" name="reason" id="reason4" value="<b>Suspicious Activity: </b> Detection of potential fraudulent activity associated with the account."> 
                                    <b>Suspicious Activity: </b> Detection of potential fraudulent activity associated with the account.
                                </label>
                            </li>

                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">
                            <span class="fas fa-thumbs-down"></span> Decline
                        </button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
   

    <div class="modal fade" id="householdNoModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_to_approve" id="id_to_approve">
                    <div class="form-floating">
                        <input type="text" name="house_hold_no" id="house_hold_no" class="form-control" placeholder="Household No.">
                        <label for="house_hold_no">Household No.</label>
                    </div>

                    <div class="p-1 d-flex justify-content-end">
                        <button class="btn-sm btn-primary btn" id="generateHouseHoldNoBtn" type="button">
                            Generate Household No.
                        </button>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" type="submit" onclick="approveHouseHoldUpdate(document.getElementById('id_to_approve').value, document.getElementById('house_hold_no').value)">
                        <span class="fas fa-thumbs-up"></span> Approve
                    </button>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="button">
                        <span class="fas fa-ban"></span> Cancel 
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="advanceFilterModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="h5">
                        Advance Filter
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row p-0 m-0">
                        <!-- <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="unGroupedGenFilterAll" class="cursor-pointer">
                                <input type="checkbox" id="unGroupedGenFilterAll" name="unGroupedGenFilter" class="form-check-input"> All
                            </label>
                        </div> -->
                        <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="isSchoolingFilter" class="cursor-pointer">
                                <input type="checkbox" id="isSchoolingFilter" name="unGroupedGenFilter" class="form-check-input" value="studentFilter"> Student
                            </label>
                        </div>
                        <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="pwdFilter" class="cursor-pointer">
                                <input type="checkbox" id="pwdFilter" name="unGroupedGenFilter" class="form-check-input" value="disabilityTypeFilter"> PWD
                            </label>
                        </div>
                        <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="soloParentFilter" class="cursor-pointer">
                                <input type="checkbox" id="soloParentFilter" name="unGroupedGenFilter" class="form-check-input" value="1"> Solo Parent
                            </label>
                        </div>
                        <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="srCitizenFilter" class="cursor-pointer">
                                <input type="checkbox" id="srCitizenFilter" name="unGroupedGenFilter" class="form-check-input" value="srCitizenFilter"> Sr. Citizen
                            </label>
                        </div>
                        <div class="col-lg-3 py-1 px-3 col-sm-6">
                            <label for="childrensYoutFilter" class="cursor-pointer">
                                <input type="checkbox" id="childrensYoutFilter" name="unGroupedGenFilter" class="form-check-input" value="childrenFilter"> Childrens & Youth
                            </label>
                        </div>
                        
                    </div>
                    <div class="fade_in d-none" id="disabilityTypeFiltersCont">
                        <div class="px-3 pt-2">
                            <hr> PWD 
                        </div>
                        <div class="row px-2 m-0">
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="disabilityType0" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType0" class="form-check-input" value="All"> 
                                    All
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="disabilityType1" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType1" class="form-check-input" value="Speech Impairment"> 
                                    Speech Impairment
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="disabilityType2" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType2" class="form-check-input" value="Orthopedic"> 
                                    Orthopedic
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType3" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType3" class="form-check-input" value="Learning"> 
                                    Learning
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType4" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType4" class="form-check-input" value="Intellectual"> 
                                    Intellectual
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType5" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType5" class="form-check-input" value="Mental"> 
                                    Mental
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType6" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType6" class="form-check-input" value="Visual"> 
                                    Visual
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType7" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType7" class="form-check-input" value="Psychosocial"> 
                                    Psychosocial
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType8" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType8" class="form-check-input" value="Physical"> 
                                    Physical
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType9" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType9" class="form-check-input" value="Hearing Impairment"> 
                                    Hearing Impairment
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 p-2">
                                <label for="disabilityType10" class="cursor-pointer">
                                    <input type="checkbox" name="disabilityTypeFilter" id="disabilityType10" class="form-check-input" value="Chronic Illness"> 
                                    Chronic Illness
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="fade_in d-none" id="srCitizenFiltersCont">
                        <div class="px-3 pt-2">
                            <hr> Sr. Citizen 
                        </div>
                        <div class="row px-2 m-0">
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter0" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter0" class="form-check-input" value="All"> 
                                    All
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter1" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter1" class="form-check-input" value="60-69"> 
                                    60-69 Years Old
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter2" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter2" class="form-check-input" value="70-79"> 
                                    70-79 Years Old
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter3" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter3" class="form-check-input" value="80-89"> 
                                    80-89 Years Old
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter4" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter4" class="form-check-input" value="90-99"> 
                                    90-99 Years Old
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="srCitizenFilter5" class="cursor-pointer">
                                    <input type="checkbox" name="srCitizenFilter" id="srCitizenFilter5" class="form-check-input" value="100-999999999"> 
                                    100 Years Old and Above
                                </label>
                            </div>
                            
                            
                        </div>
                    </div>
                    
                    <div class="fade_in d-none" id="studentFiltersCont">
                        <div class="px-3 pt-2">
                            <hr> Student
                        </div>
                        <div class="row px-2 m-0">
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter0" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter0" class="form-check-input" value="All"> 
                                    All
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter1" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter1" class="form-check-input" value="Pre School"> 
                                    Pre School
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter2" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter2" class="form-check-input" value="Kinder-Garten"> 
                                    Kinder-Garten
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter3" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter3" class="form-check-input" value="Elementary"> 
                                    Elementary
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter4" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter4" class="form-check-input" value="High School"> 
                                    High School
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="studentFilter5" class="cursor-pointer">
                                    <input type="checkbox" name="studentFilter" id="studentFilter5" class="form-check-input" value="College"> 
                                    College
                                </label>
                            </div>
                        </div>
                    </div>

                
                    <div class="fade_in d-none" id="childrenFiltersCont">
                        <div class="px-3 pt-2">
                            <hr> Childrens & Youth
                        </div>
                        <div class="row px-2 m-0">
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter0" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter0" class="form-check-input" value="All"> 
                                    All
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter1" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter1" class="form-check-input" value="0-0.999"> 
                                    0-11 Months (Infant)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter2" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter2" class="form-check-input" value="1-2"> 
                                    1-2 Years Old (Toodler)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter3" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter3" class="form-check-input" value="3-5"> 
                                    3-5 Years Old (Pre-Schooler)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter4" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter4" class="form-check-input" value="6-12"> 
                                    6-12 Years Old (School Age)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter5" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter5" class="form-check-input" value="6-17"> 
                                    13-17 Years Old (Teenager)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter6" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter6" class="form-check-input" value="18-25"> 
                                    18-24 Years Old (Core Youth)
                                </label>
                            </div>
                            <div class="col-sm-6 col-md-3 px-2 py-1">
                                <label for="childrenFilter7" class="cursor-pointer">
                                    <input type="checkbox" name="childrenFilter" id="childrenFilter7" class="form-check-input" value="25-30"> 
                                    25-30 Years Old (Adult Youth)
                                </label>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="modal-footer">
                    <button class="btn-secondary btn mx-1" data-bs-dismiss="modal" type="button">
                        <span class="fas fa-ban"></span> Cancel
                    </button>
                    <button class="btn-primary btn mx-1" id="advanceFilterBtn">
                        <span class="fas fa-filter"></span> Filter
                    </button>
                </div>
                
            </div>
        </div>
    </div>
    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    
    <script src="Views/js/rbim.js<?php echo("?v=".time().uniqid()); ?>"></script>
</body>
</html>