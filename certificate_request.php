<?php 
require_once "Utilities/config.php";

require_once "admin/Models/HouseHold.php";
require_once "admin/Models/Citizen.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['brgy_household_id'])) {
    header("Location: requestAuth");
    exit();
} else {

    $houseHold = HouseHold::findById($_SESSION['brgy_household_id']);
    
    session_unset();
    session_destroy();

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
                        <div class="col-lg-10 col-md-12 m-auto d-bock">
                            <div class="custom-block bg-white shadow-lg">
                                <form id="requestCertificateForm" autocomplete="off" class="custom-form">
                                    <div class="modal-header">
                                        <h5>Request a Certificate</h5>

                                    </div>
                                    <div class="modal-body">
                                        <div class="row p-0 m-0">
                                            <div class="col-lg px-2 m-0">
                                                <div class="form-floating pt-2">
                                                    <select type="text" name="reqName" id="reqName" placeholder="Name" class="form-select">
                                                        <option value="">Select Family Member</option>
                                                        <?php foreach ($houseHold->familyMembers as $fam) { ?>
                                                            <option value="<?php echo($fam->name); ?>"><?php echo($fam->name); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!-- <label for="reqName" class="bg-white px-3 py-2">Name</label> -->
                                                </div>
                                            </div>
                                            <div class="col-lg px-2 m-0 d-none">
                                                <div class="form-floating">
                                                    <input type="text" name="reqEmail" id="reqEmail" placeholder="Email" class="form-control" value="<?php echo($houseHold->email); ?>">
                                                    <label for="reqEmail">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-lg px-2 m-0 d-none">
                                                <div class="form-floating">
                                                    <input type="text" name="reqContactNumber" id="reqContactNumber" placeholder="Contact No." class="form-control" value="<?php echo($houseHold->contactNo); ?>">
                                                    <label for="reqContactNumber">Contact No.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 d-none">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="reqAddress" id="reqAddress" placeholder="Address" value="<?php echo($houseHold->purok); ?>">
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
                                        <button class="btn custom-btn mx-1" id="requestCertificateBtn" type="submit">
                                            <span class="fas fa-paper-plane"></span> Submit
                                        </button>
                                        <a href="home" class="btn btn custom-btn mx-1">
                                            Cancel
                                        </a>
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