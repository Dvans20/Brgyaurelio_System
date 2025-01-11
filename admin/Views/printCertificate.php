
<!-- popperjs -->
<script src="<?php echo($extLink); ?>Views/libraries/popper.min.js"></script>

<!-- bootstrap -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/css/bootstrap.min.css<?php echo "?v=" . time() . uniqid(); ?>">
<script src="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/js/bootstrap.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script>


<style>

    body {
        background-color: #fff !important;
    }

    .cert_paper {
        width: 8.27in;
        max-width: 8.27in;
        min-width: 8.27in;
        padding: .3in;
        height: 11.69in;
        position: relative;
        margin: 2rem auto;
        display: block;
        box-shadow: 1px 1px 20px 0 rgba(0,0,0,.5);
    } 

    .cert_content {
        width: 100%;
        height: 100%;
        border: 1px dashed rgba(0,0,0,.3) !important;
        position: relative;
        padding: 0 .3in;
    }

    .cert_logo_bg {
        background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url("<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?><?php echo "?v=" . time(). uniqid(); ?>");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 6in;
    }

    .cert-responsive {
        overflow: scroll;
    }

    .cert_header {
        padding: 12px;
        position: relative;
    }
    .cert_logo {
        width: .85in;
        height:auto;
        display: block;
        position: absolute;
        top: 12px;
        left: 1.3in;
    }

    .cert_logo img {
        width: .85in;
        height:auto;
    }

    .cert_white_box {
        background-color: #fff;
        border: 1px solid #000;
        width: 1in;
        height: 1in;
        position: absolute;
        top: .5in;
        right: 0;
    }

    .cert_title {
        text-align: center;
        margin: 0;
        padding: 5px;
        font-weight: bolder;
        text-shadow: 0 0 1px 2px black;
    }

    p {
        text-align: justify;
        z-index: 2;
    }

    .thumbmark_box {
        position: relative;
        display: block;
        width: 110px;
        height: 90px;
        border: 1px solid #000;
    }


    * #brgyBusClearanceCertificate, * #brgyClearance {
        font-size: 14px;
    }

    .scroller {
        font-size: 12px;

    }

    .lh-small {
        line-height: 14px;
    }

    
    .white_scroll_bg_top {
        position: absolute;
        top: 0;
        left: -1px;
        width: 2.47in;
        height: 40px;
        z-index: 0;
    }
    .white_scroll_bg_bot {
        position: absolute;
        bottom: 0;
        right: -1px;
        width: 2.48in;
        height: 40px;
        z-index: -0;
    }
    .white_scroll_bg {
        width: 3in;
        background-color: #fff;
        border-left: .5px solid #000;
        border-right: .5px solid #000;
        padding: .3in 10px .2in 10px;
        border-radius: 25px;
        color: green !important;
    }



    .blue_scroll_bg_top {
        position: absolute;
        top: 0;
        left: -1px;
        width: 2.47in;
        height: 40px;
        z-index: 0;
    }
    .blue_scroll_bg_bot {
        position: absolute;
        bottom: 0;
        right: -1px;
        width: 2.48in;
        height: 40px;
        z-index: -0;
    }
    .blue_scroll_bg {
        width: 3in;
        background-color: #fff;
        border-left: .5px solid #000;
        border-right: .5px solid #000;
        padding: .3in 10px .2in 10px;
        border-radius: 25px;
        color: white !important;
        background-color: #0D6EFD;
    }


    .left_spacer {
        width: 15px;
    }

    .cert_ribbon {
        width: 6in;
        height: .7in;
        position: absolute;
        left: 50%;
        top: 1.6in;
        transform: translateX(-50%);
        z-index: -1;
    }

    @media print {
        /* Force a page break before an element */
        .page-break {
            page-break-before: always; /* or 'avoid' to prevent breaking */
        }

        /* Force a page break after an element */
        .page-break-after {
            page-break-after: always; /* or 'avoid' to prevent breaking */
        }

        /* For a page break within an element (like a long paragraph) */
        .page-break-inside {
            page-break-inside: avoid; /* This will prevent breaking inside the element */
        }
    }
</style>

<?php 

    require_once "Models/Citizen.php";
    require_once "Models/RBBO.php";

    $date = date('d')/1;

    $sup = "th";

    switch ($date) {
        case 1: 
            $sup = "st";
            break;
        case 2: 
            $sup = "nd";
            break;
        case 3: 
            $sup = "rd";
            break;
        case 4: 
            $sup = "th";
            break;
    }

    if (!isset($_GET['certificate'])) {
        exit();
    } else {



    foreach ($_GET as $k => $v) {
        $$k = $v;
    }

    
?>



<?php if ($certificate == "brgyClearance") { ?>

    <!-- Barangay CLEARANCE -->
    <?php 
    $citizen = Citizen::findById($citizenId);
    ?>
        <div class="cert_content page-break-inside">

            <div class="cert_header">
                
                <div class="cert_logo">
                    <img src="<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?><?php echo "?v=" . time(). uniqid(); ?>" alt="Brgy. <?php echo($web->brgy); ?>">
                </div>
                <h3 class="p-0 m-0 fs-6 text-center">Republic of the Philippines</h3>
                <h3 class="p-0 m-0 fs-6 text-center">Province of Dinagat Islands</h3>
                <h3 class="p-0 m-0 fs-6 text-center">Municipality of San Jose</h3>
                <h3 class="p-0 m-0 fs-5 text-center text-uppercase">Barangay <?php echo($web->brgy); ?></h3>

                <h3 class="p-0 m-0 fs-4 text-center text-uppercase"><strong>OFFICE OF THE PUNONG BARANGAY</strong></h3>

                <div class="cert_white_box"></div>
            </div>

            <h2 class="cert_title text-primary fs-3">BARANGAY CLEARANCE</h2>
    

            <div class="d-flex">
                <div class="left_spacer"></div>
                <div class="w-4in text-center d-block position-relative white_scroll_bg scroller">

                    <img src="Media/images/white_scroll_top.png" alt="" class="white_scroll_bg_top">



                    <?php if (strpos($web->brgyCaptainName, "Hon.") !== false) { ?>
                        <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgyCaptainName); ?></div>
                    <?php } else { ?>
                        <div class="fw-bold lh-small text-uppercase pt-3">Hon. <?php echo($web->brgyCaptainName); ?></div>
                    <?php } ?>  
                    <i><small class="lh-small">Punong Barangay</small></i>

                    <!-- <br> &nbsp; -->
                    <div class="pt-3"></div>

                    <?php if (is_array($web->councilors)) { ?>
                        <?php foreach ($web->councilors as $councilor) { ?>
                            <?php if (strpos($councilor['name'], "Hon.") !== false) { ?>
                                <div class="fw-bold lh-small text-uppercase pt-1"><?php echo($councilor['name']); ?></div>
                            <?php } else { ?>
                                <div class="fw-bold lh-small text-uppercase pt-1">Hon. <?php echo($councilor['name']); ?></div>
                            <?php } ?>  
                            <div class="pb-1">
                                <i><small class="lh-small"><?php echo($councilor['designation']); ?></small></i>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if (strpos($web->skChairmanName, "Hon.") !== false) { ?>
                        <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->skChairmanName); ?></div>
                    <?php } else { ?>
                        <div class="fw-bold lh-small text-uppercase pt-3">Hon. <?php echo($web->skChairmanName); ?></div>
                    <?php } ?>  
                    <i><small class="lh-small">SK Chairman</small></i>

                    <!-- <br> &nbsp; -->

                    <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgySecretaryName); ?></div>
                    <i><small class="lh-small">Barangay Secretary</small></i>
                    <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgyTreasurerName); ?></div>
                    <i><small class="lh-small">Barangay Treasurer</small></i>

                    <img src="Media/images/white_scroll_bot.png" alt="" class="white_scroll_bg_bot">


                </div>

                <div class="w-100 pt-5 ps-3">

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="pt-2 pb-1">NAME</div> &emsp; &emsp; &emsp;&emsp; <div id="brgyClearanceApplicantName" class="fs-5"> : <?php echo($citizen->name); ?></div>
                    </div>

                    <!-- <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">NICK NAME</div> &emsp;&emsp; <div id="brgyClearanceApplicantNickName" class="py-1">: "Nick Name"</div>
                    </div> -->

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">STATUS</div> &emsp;&emsp; &emsp;&emsp; <div id="brgyClearanceApplicantCicilStatus" class="text-uppercase py-1">: <?php echo($citizen->civilStatus); ?></div>
                    </div>

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">DATE OF BIRTH</div> &emsp; <div id="brgyClearanceApplicantBirthDate" class="text-uppercase py-1">: <?php echo(date("M d, Y", strtotime($citizen->birthDate))); ?></div>
                    </div>

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">SEX</div> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <div id="brgyClearanceApplicantSex" class="text-uppercase py-1">: 
                            <?php if ($citizen->sex == 1) { ?>
                                Male
                            <?php } else if ($citizen->sex == 2) { ?>
                                Female
                            <?php } ?>
                        </div>
                    </div>

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">PLACE OF BIRTH</div> &emsp; <div id="brgyClearanceApplicantBirthPlace" class="text-uppercase py-1">: 
                            <?php echo($citizen->birthPlace); ?>
                        </div>
                    </div>

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">PRESENT ADDRESS</div> &emsp; <div id="brgyClearanceApplicantPresentAddress" class="text-uppercase py-1">: 
                            <?php echo(ucwords($citizen->purok)); ?> <?php echo(ucwords($web->brgy)); ?>, San Jose, Dinagat Islands
                        </div>
                    </div>

                    <div class="d-flex fw-bold" style="vertical-align: top;">
                        <div class="py-1">PURPOSE</div> &emsp;&emsp;&emsp; <div id="brgyClearanceApplicantPurpose" class="text-uppercase py-1 text-decoration-underline">: <?php echo($purpose); ?></div>
                    </div>

                    <p class="text-uppercase fw-bold pt-2">To Whom it may concern:</p>

                    <p>
                        <strong class="text-uppercase">i hereby confirm</strong> that <strong class="text-uppercase" id="brgyClearanceApplicantNameContent"><?php echo($citizen->name); ?></strong> a resident of <span id="brgyClearanceApplicantPurokContent"><?php echo($citizen->purok); ?></span> <?php echo(ucwords($web->brgy)); ?>, San Jose , Dinagat Islands. As far as this office is concern, per records available for the period covering from the year <span id="brgyClearanceApplicantYearFromContent"><?php echo($coveringYear); ?></span> up to the present, he is known to me a person of good moral character and social standing in the community.
                    </p>
                    <p>
                        <strong class="text-uppercase">CONFIRMED FUTHER</strong> that he is living in this barangay, and he never been convicted against any ordinance or crime involving moral turpitude as born out in records of this barangay.
                    </p>

                    <?php 
                        $date = date('d')/1;

                        $sup = "th";

                        switch ($date) {
                            case 1: 
                                $sup = "st";
                                break;
                            case 2: 
                                $sup = "nd";
                                break;
                            case 3: 
                                $sup = "rd";
                                break;
                            case 4: 
                                $sup = "th";
                                break;
                        }
                    ?>

                    <p>
                        Issued this <span id="brgyClearanceApplicantIssuedDateContent"><strong><?php echo($date); ?><sup><?php echo($sup); ?></sup></strong> day of <strong class="text-uppercase"><?php echo(date('F')); ?> <?php echo(date('Y')); ?></strong></span> at the office of Punong Barangay, <?php echo(ucwords($web->brgy)); ?>, San Jose, Dinagat Islands.
                    </p>

                </div>

            </div>

                        <br>
            <!-- footer -->
            <div class="d-flex fw-bold">

                <div class="pe-2">


                    <table class="">
                        <tr>
                            <td class="text-center fw-bold"><small>Left Thumbmark</small></td>
                            <td class="text-center fw-bold"><small>Right Thumbmark</small></td>
                        </tr>
                        
                        <tr>
                            <td class="p-1"><div class="thumbmark_box"></div></td>
                            <td class="p-1"><div class="thumbmark_box"></div></td>
                        </tr>
                        <tr>
                            <td><b>CTC NO</b></td><td class="text-nowrap">: <span id="brgyClearanceCertificateCTCNO"> <?php echo($ctcNo); ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Issued on</b></td><td class="text-nowrap">: <span id="brgyClearanceCertificateIssuedOn"> <?php echo(date("M d, Y", strtotime($issuedOn))); ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Issued at</b></td><td class="text-nowrap">: <span id="brgyClearanceCertificateIssuedAt"> <?php echo($issuedAt); ?></span></td>
                        </tr>
                        <tr>
                            <td><b>O.R. No.</b></td><td class="text-nowrap">: <span id="brgyClearanceCertificateORNot"> <?php echo($orNo); ?></span></td>
                        </tr>
                        
                    </table>

                
                    

                </div>

                <div class="w-100 ps-3">

                    <div class="d-flex justify-content-end ">
                        <div class="d-block text-center">
                            <div id="brgyClearanceApplicantNameSign" class="text-decoration-underline text-uppercase"><?php echo($citizen->name); ?></div>
                            <div class="">Applicant</div>
                        </div>
                    </div>

                
                    <!-- secretary -->

                    <div>
                        <div>Prepared By:</div>
                        <br>
                        <div class="text-uppercase">
                            <?php echo($web->brgySecretaryName); ?>
                        </div>
                        <div>Barangay Secretary</div>
                    </div>

                    <!-- punong barangay -->
                
                    <div class="d-flex justify-content-end">
                        <div class="d-block text-center">
                            <div>Approved By:</div>
                            <br>
                            <div class="text-uppercase">
                                <?php echo($web->brgyCaptainName); ?>
                            </div>
                            <div>Punong Barangay</div>
                        </div>
                        
                    </div>

                </div>


            </div>


        <!-- end of papaer content -->
        </div>


    <!-- Barangay CLEARANCE -->

<?php } else if ($certificate == "residencyCertificate") { ?>


    <?php 
        $citizen = Citizen::findById($citizenId);
        $citizens = Citizen::findById(id: $citizen2Id);

        if ($thirdId == 1) {
            $citizen2 = $citizen;
            $citizen3 = $citizens;
        } else if ($thirdId == 2) {
            $citizen2 = $citizens;
            $citizen3 = $citizen;
        }
    ?>
    
    <div class="cert_content page-break-inside">
        <div class="cert_header">
            
            <div class="cert_logo">
                <img src="<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?><?php echo "?v=" . time(). uniqid(); ?>" alt="Brgy. <?php echo($web->brgy); ?>">
            </div>
            <h3 class="p-0 m-0 fs-6 text-center">Republic of the Philippines</h3>
            <h3 class="p-0 m-0 fs-6 text-center">Province of Dinagat Islands</h3>
            <h3 class="p-0 m-0 fs-6 text-center">Municipality of San Jose</h3>
            <h3 class="p-0 m-0 fs-5 text-center text-uppercase">Barangay <?php echo($web->brgy); ?></h3>

            <h3 class="p-0 m-0 fs-4 text-center text-uppercase"><strong>OFFICE OF THE PUNONG BARANGAY</strong></h3>

            <!-- <div class="cert_white_box"></div> -->
        </div>

        <img src="Media/images/blue-ribbon.png" alt="" class="cert_ribbon">
        <h2 class="cert_title text-white text-uppercase fs-3" style="padding: .45in;">Certification</h2>

        <div class="d-flex">
            <div class="left_spacer"></div>
            <div class="w-4in text-center d-block position-relative blue_scroll_bg scroller">

                <img src="Media/images/blue_scroll_top.png" alt="" class="blue_scroll_bg_top">



                <?php if (strpos($web->brgyCaptainName, "Hon.") !== false) { ?>
                    <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgyCaptainName); ?></div>
                <?php } else { ?>
                    <div class="fw-bold lh-small text-uppercase pt-3">Hon. <?php echo($web->brgyCaptainName); ?></div>
                <?php } ?>  
                <i><small class="lh-small">Punong Barangay</small></i>

                <!-- <br> &nbsp; -->
                 <div class="pt-3"></div>

                <?php if (is_array($web->councilors)) { ?>
                    <?php foreach ($web->councilors as $councilor) { ?>
                        <?php if (strpos($councilor['name'], "Hon.") !== false) { ?>
                            <div class="fw-bold lh-small text-uppercase pt-1"><?php echo($councilor['name']); ?></div>
                        <?php } else { ?>
                            <div class="fw-bold lh-small text-uppercase pt-1">Hon. <?php echo($councilor['name']); ?></div>
                        <?php } ?>  
                        <div class="pb-1">
                            <i><small class="lh-small"><?php echo($councilor['designation']); ?></small></i>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if (strpos($web->skChairmanName, "Hon.") !== false) { ?>
                    <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->skChairmanName); ?></div>
                <?php } else { ?>
                    <div class="fw-bold lh-small text-uppercase pt-3">Hon. <?php echo($web->skChairmanName); ?></div>
                <?php } ?>  
                <i><small class="lh-small">SK Chairman</small></i>

                <!-- <br> &nbsp; -->

                <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgySecretaryName); ?></div>
                <i><small class="lh-small">Barangay Secretary</small></i>
                <div class="fw-bold lh-small text-uppercase pt-3"><?php echo($web->brgyTreasurerName); ?></div>
                <i><small class="lh-small">Barangay Treasurer</small></i>

                <img src="Media/images/blue_scroll_bot.png" alt="" class="white_scroll_bg_bot">


            </div>

            <div class="w-100 pt-5 ps-3">
                
                <p class="text-uppercase fw-bold pt-2">To Whom it may concern:</p>

                <p>
                    <strong class="text-uppercase">This is to certify</strong> that, <strong class="text-uppercase" id="brgyResidencyApplicantNameContent"><?php echo($citizen->name); ?></strong> legal age, Filipino, a resident of <span id="brgyResidencyApplicantPurokContent"><?php echo(ucwords($citizen->purok)); ?></span> <?php echo(ucwords($web->brgy)); ?>, San Jose , Dinagat Islands.
                </p>
                <p>
                    <strong class="text-uppercase">CERTIFIES FUTHER</strong> that <strong class="text-uppercase" id="brgyResidencyApplicantNameContent2"><?php echo($citizen2->name); ?></strong>, <span id="brgyResidencyDescription"><?php echo($citaition); ?></span>
                </p>
                <p>
                    <strong>This certification</strong> is issued upon the request of  <strong class="text-uppercase" id="brgyResidencyApplicantNameContent3"><?php echo($citizen3->name); ?></strong> in connection as supporting documents for <span id="brgyResidencyApplicantPurpose"><?php echo($purpose); ?></span>.
                </p>

                <?php 
                    $date = date('d')/1;

                    $sup = "th";

                    switch ($date) {
                        case 1: 
                            $sup = "st";
                            break;
                        case 2: 
                            $sup = "nd";
                            break;
                        case 3: 
                            $sup = "rd";
                            break;
                        case 4: 
                            $sup = "th";
                            break;
                    }
                ?>

                <p>
                    Issued this <span id="brgyResidencyApplicantIssuedDateContent"><strong><?php echo($date); ?><sup><?php echo($sup); ?></sup></strong> day of <strong class="text-uppercase"><?php echo(date('F')); ?> <?php echo(date('Y')); ?></strong></span> at the office of Punong Barangay, <?php echo(ucwords($web->brgy)); ?>, San Jose, Dinagat Islands.
                </p>

            </div>

        </div>

        <div class="row">
    <div class="col-md-4">
        <div class="d-flex" style="justify-content: center;align-items: middle;">
            <div class="text-center text-nowrap">
                <h6 style="margin-top:20px;">Not<br>valid<br>without seal</h6> <!-- Corrected closing tag for h6 -->
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex">
            <div class="text-center text-nowrap">
                <!-- punong barangay -->
                <div>Approved By:</div>
                <div class="form-group w-100">
                    <input type="text" name="na" class="form-control" style="border:transparent; border-bottom: 2px solid black;text-align: center;">
                </div>
                <input type="text" name="na" class="form-control" style="border:transparent;text-align: center;">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="d-flex">
            <div class="text-center text-nowrap">
                <!-- punong barangay -->
                <div>Approved By:</div>
                <br> &nbsp;
                <div class="text-uppercase">
                    <?php echo($web->brgyCaptainName); ?>
                </div>
                <div>Punong Barangay</div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-0 mt-4">
    <div class="col-md-4">
        <h6 style="text-center;font-style: italic;font-family:Brush Script MT,sans-serif;font-size:14px;color:red">Certification <?php echo date('Y') ?></h6>
    </div>
    <div class="col-md-4"><h6 style="text-center;font-style: italic;font-family:Brush Script MT,sans-serif;font-size:14px;color:red">Office Of The Barangay Secretary</h6></div>
    <div class="col-md-4">
        <h6 style="text-center;font-style: italic;font-family:Brush Script MT,sans-serif;font-size:14px;color:red">Office of the Barangay Captain</h6>
    </div>
</div>
    </div>


<?php } else if ($certificate == "brgyBusClearanceCertificate") { ?>

    <?php 
        $rbbo = RBBO::findById($busId);
    ?>

    <div class="cert_content cert_logo_bg" style="border:red 1px dashed">

        <div class="cert_header">
            
            <div class="cert_logo">
                <img src="<?php echo($extLink); ?>Media/images/<?php echo(strtolower(str_replace(" ", "-", $web->brgy . ".png"))); ?><?php echo "?v=" . time(). uniqid(); ?>" alt="Brgy. <?php echo($web->brgy); ?>">
            </div>
            <h3 class="p-0 m-0 fs-6 text-center">Republic of the Philippines</h3>
            <h3 class="p-0 m-0 fs-6 text-center">Province of Dinagat Islands</h3>
            <h3 class="p-0 m-0 fs-6 text-center">Municipality of San Jose</h3>
            <h3 class="p-0 m-0 fs-5 text-center text-uppercase">Barangay <?php echo($web->brgy); ?></h3>

            <h3 class="p-0 m-0 fs-4 text-center text-uppercase"><strong>OFFICE OF THE PUNONG BARANGAY</strong></h3>

            <div class="cert_white_box"></div>
        </div>

        <h2 class="cert_title text-primary fs-3">BARANGAY CLEARANCE</h2>

        <br>

        <p>
            &emsp; <b>TO WHOM IT MAY CONCNERN:</b>
        </p>
        <P>
            &emsp; 
            This is to certify that the name, thumb mark and signature appear hereon has requested a CLEARANCE from this office.
        </P>

        <p>
            <div id="brgyBusClearanceCertificateApplicantName" class="text-uppercase text-underlime text-center fs-5 p-0 m-0 text-decoration-underline fw-bold"><?php echo($rbbo->onwnersName); ?></div>
            <div class="text-center p-0 m-0">
                <small>Name of Applicant</small>
            </div>
        </p>
        <p>
            <div id="brgyBusClearanceCertificateApplicantResidenceAddress" class="text-uppercase text-underlime text-center p-0 m-0 text-decoration-underline"><?php echo($rbbo->residenceAddress); ?></div>
            <div class="text-center p-0 m-0">
                <small>Residence Address</small>
            </div>
        </p>
        <p>
            <div id="brgyBusClearanceCertificateApplicantBusinessName" class="text-danger text-uppercase text-underlime text-center fs-5 p-0 m-0 text-decoration-underline fw-bold"><?php echo($rbbo->businessName); ?></div>
            <div class="text-center p-0 m-0">
                <small>Name of Business</small>
            </div>
        </p>
        <p>
            <div id="brgyBusClearanceCertificateApplicantBusinessAddress" class="text-uppercase text-underlime text-center p-0 m-0 text-decoration-underline"><?php echo($rbbo->purok . " " . $web->brgy . ", San Jose, Dinagat Islands"); ?></div>
            <div class="text-center p-0 m-0">
                <small>Address of Business</small>
            </div>
        </p>

        <P class="text-center">
            <!-- &emsp;  -->
            <b>THIS CLEARANCE</b> is hereby granted to the above-named person to support his/her application for <b class="text-uppercase">NEW BUSINESS PERMIT.</b>
        </P>
        <P class="text-center">
            <!-- &emsp;  -->
            This is to certify further that as of this date, the above-named person has no derogatory record/s in the barangay.
        </P>
        <P class="text-center">
            <!-- &emsp;  -->
            <b>ISSUED</b> <span id="brgyBusClearanceCertificateDateIssued"><b><?php echo($date); ?><sup><?php echo($sup); ?></sup> day</b> of <b><?php echo(date('F Y')); ?></b></span> at Barangay <?php echo(ucwords($web->brgy)); ?>, San Jose, Dinagat Islands, Philippines.
        </P>


        <div class="d-flex fw-bold">

            <div class="w-100">


                <table class="">
                    <tr>
                        <td><b>CTC NO</b></td><td>: <span id="brgyBusClearanceCertificateCTCNO"> <?php echo($ctcNo); ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Issued on</b></td><td>: <span id="brgyBusClearanceCertificateIssuedOn"> <?php echo(date('M d, Y', strtotime($issuedOn))); ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Issued at</b></td><td>: <span id="brgyBusClearanceCertificateIssuedAt"> <?php echo($issuedAt); ?></span></td>
                    </tr>
                    <tr>
                        <td><b>O.R. No.</b></td><td>: <span id="brgyBusClearanceCertificateORNo"> <?php echo($orNo); ?></span></td>
                    </tr>
                    <tr>
                        <td class="text-center fw-bold"><small>Left Thumbmark</small></td>
                        <td class="text-center fw-bold"><small>Right Thumbmark</small></td>
                    </tr>
                    
                    <tr>
                        <td class="p-1"><div class="thumbmark_box"></div></td>
                        <td class="p-1"><div class="thumbmark_box"></div></td>
                    </tr>
                </table>

                <br> &nbsp;
                <br> &nbsp;

                <div>______________________ </div>
                <div>Applicant Signature</div>
                

            </div>

            <div class="w-100">
                <br> &nbsp;
                <br> &nbsp;
                <br> &nbsp;

                <!-- secretary -->
                <div>
                    <div>Prepared By:</div>
                    <br> &nbsp;
                    <div class="text-uppercase">
                        <?php echo($web->brgySecretaryName); ?>
                    </div>
                    <div>Barangay Secretary</div>
                </div>

                <!-- punong barangay -->
                <br> &nbsp;
                <div class="text-center">
                    <div>Approved By:</div>
                    <br> &nbsp;
                    <div class="text-uppercase">
                        <?php echo($web->brgyCaptainName); ?>
                    </div>
                    <div>Punong Barangay</div>
                </div>

            </div>


        </div>


        <!-- end of papaer content -->
    </div>

<?php } ?>




<!-- toclose -->
<?php 
    }

?>

<script>
    window.print()
</script>