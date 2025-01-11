<?php 

require_once "Utilities/config.php";


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

                                    <li class="breadcrumb-item active" aria-current="page">RBBO</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Registry of Barangay Business Owners</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                
                <div class="container">
                    <div class="custom-block bg-white shadow-lg custom-form">

                        <div class="row">
                            <div class="col-md-4">
                                <!-- <div class="h4 text-uppercase py-2 m-0">purok: purok 0</div> -->
                                 <div class="form-floating">
                                    <select name="purok" id="purok" class="form-select">
                                        <option value="">Select a Purok</option>
                                        <?php if ($web->puroks != null) { ?>
                                            <?php foreach ($web->puroks as $purok) { ?>
                                                <option value="<?php echo($purok); ?>"><?php echo($purok); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <!-- <label for="purok">Select a Purok</label> -->
                                 </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <h5 id="busNoText" class="p-2"></h5>
                                <input type="hidden" id="rbbo_in" name="rbbo_in" value="0">
                            </div>
                        </div>
                        <hr>


                        




                        <div class="row p-0 m-0">


                            <div class="col-md-4 p-2 m-0">    
                                <div class="form-floating">
                                    <input type="text" class="form-control" oninput="this.value=this.value.replace(/[0-9]/g, '')" name="name" id="name" placeholder="Enter Name">
                                    <label for="name">Enter Name</label>
                                </div>
                            </div>
                            <div class="col-md-8 p-2 m-0">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="residenceAddress" id="residenceAddress" placeholder="Residence Address">
                                    <label for="residenceAddress">Residence Address</label>
                                </div>
                            </div>

                            <div class="col-md-12 m-0 p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="businessName" id="businessName" placeholder="Business Name">
                                    <label for="businessName">Business Name</label>
                                </div>
                            </div>

                            <div class="col-md-6 p-0 m-0">
                                <div class="p-2">
                                    <div class="my-1 form-floating">
                                        <select name="businessCategory" id="businessCategory" class="form-select">
                                            <option value="">Business Category</option>
                                        </select>
                                        <!-- <label for="businessType">Business Type</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <div class="p-2">
                                    <div class="my-1 form-floating">
                                        <select name="businessType" id="businessType" class="form-select" disabled>
                                            <option value="">Business Type</option>
                                        </select>
                                        <!-- <label for="businessType">Business Type</label> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        


                        

                        <!-- Contact Info -->
                        <div class="row m-0 p-0 on_new_only">
                            <div class="col-md p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="contactNo" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);" id="contactNo" placeholder="Business Contact No.">
                                    <label for="contactNo">Business Contact No.</label>
                                </div>
                            </div>
                            <div class="col-md p-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Business Email">
                                    <label for="email">Business Email</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        

                        <div class="row p-0 m-0 on_new_only" id="generatePassKeyCont">
                            <div class="col-sm m-0 px-2 py-0 position-relative">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="passKey" id="passKey" placeholder="Create a Pass Key">
                                    <label for="passKey">Create a Pass Key</label>
                                </div>
                                <button class="btn" id="passKeyToggleVisibilityBtn">
                                    <span class="fas fa-eye"></span>
                                </button>
                            </div>
                            <div class="col-sm m-0 p-0 pt-3">
                                <button id="generatePassKey" class="btn text-nowrap" style="line-height: 12px;">Generate Pass Key</button>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="w-100 py-2 d-flex">
                            <button class="btn custom-btn btn-primary btn-lg w-100 text-center my-2 mx-1" id="saveRBBOBtn">
                                <span class="fas fa-paper-plane"></span> Submit
                            </button>
                            <a href="<?php echo($web->siteUrl); ?>" class="btn custom-btn btn-secondary bg-secondary w-100 text-center my-2 mx-1" id="cancelForm">
                                <span class="fas fa-ban"></span> Cancel
                            </a>
                        </div>
                    </div>
                </div>


                

            </section>


                
            
        </main>

    

        <div class="modal fade" data-bs-backdrop="static" id="askStatusModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="alert alert-info small text-muted p-2">
                            If this is your first time registering in this portal then click New.
                        </div>
                        <div class="p-1">
                            <button class="btn custom-btn w-100" data-bs-dismiss="modal" type="button">
                                New Business Owner
                            </button>
                        </div>
                        <div class="p-1">
                            <button class="btn custom-btn w-100" id="existingBO">
                                Existing Business Owner
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="existingBOFormModal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <form class="custom-form" id="existingBOForm">
                        <div class="modal-header">
                            <button class="btn-close" data-bs-dismiss="modal" type="button" id="xExistingBOFormModal"></button>
                        </div>
                        <div class="modal-body py-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="existingBONo" id="existingBONo" placeholder="Enter your Bus. ID. No.">
                                <label for="existingBONo">Enter your Bus. ID. No.</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" name="existingPassKey" id="existingPassKey" placeholder="Enter your Pass Key">
                                <label for="existingPassKey">Enter your Pass Key</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex w-100">
                                <button class="btn btn-sm btn-secondary custom-btn fs-6 m-1 w-100" id="cancelExistingBOFormModal" data-bs-dismiss="modal" type="button">
                                    <span class="fas fa-ban"></span> Cancel
                                </button>
                                <button class="btn btn-sm btn-primary custom-btn fs-6 m-1 w-100" type="submit">
                                    <span class="fas fa-paper-plane"></span> Submit
                                </button>
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
        <?php 
            require_once 'footer.php';
        ?>
        <script src="js/rbbo.js<?php echo("?v=" . time().uniqid()); ?>"></script>

    </body>
</html>