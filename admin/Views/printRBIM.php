<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    // require_once 'templates/head.php';

    require_once "Models/HouseHold.php";
    require_once "Models/Citizen.php";
    error_reporting(0);
    $search = $_GET['search']; 
    $grouped_by = $_GET['grouped_by']; 

    $purok = $_GET['purok']; 
    $year = $_GET['year']; 
    $qtr = $_GET['qtr']; 

    $status = $_GET['status']; 
    $houseOwnershipStatus = $_GET['houseOwnershipStatus']; 
    $electricity = $_GET['electricity']; 
    $sanitaryToilet = $_GET['sanitaryToilet']; 
    $monthLyIncome = $_GET['monthLyIncome']; 
    // $grouped_by = $_GET['grouped_by']; 
    // $grouped_by = $_GET['grouped_by']; 
    // $grouped_by = $_GET['grouped_by']; 
    // $grouped_by = $_GET['grouped_by']; 
    // $grouped_by = $_GET['grouped_by']; 


    function calculateAge($birthDate) {
         // Create a DateTime object for the birth date
        $birthDateTime = new DateTime($birthDate);
        
        // Create a DateTime object for the current date
        $currentDateTime = new DateTime();
        
        // Calculate the difference between the two dates
        $age = $currentDateTime->diff($birthDateTime);
        
        // If the age is less than 1 year, return the age in months
        if ($age->y < 1) {
            // Total months = years * 12 + months
            $totalMonths = ($age->y * 12) + $age->m;
            return $totalMonths . " mo";  // Return the age in months
        }
        
        // Otherwise, return the age in years
        return $age->y . " yo";  // Return the age in years
    }
?>

<!-- bootstrap -->
<link rel="stylesheet" href="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/css/bootstrap.min.css<?php echo "?v=" . time() . uniqid(); ?>">
<script src="<?php echo($extLink); ?>Views/libraries/bootstrap-5.2.3-dist/js/bootstrap.min.js<?php echo "?v=" . time() . uniqid(); ?>"></script>
</head>

<style>

    * {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }

    body {
        background-color: #fff !important;
        /* width: 13in !important; */
        /* height: 8.5in; */
        /* padding: .5in; */
        /* border: 1px solid rgba(0,0,0,.3) !important; */
        font-family: inherit;
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
    


    .table-bordered th, .table-bordered, td {
        border: 1px solid black;
    }

    .table th, .table td {
        vertical-align: middle; /* Vertically align content to the middle */
    }
    
    .table {
        width: 100vw !important;
    }


</style>

<body>

<?php if ($grouped_by == 1) { ?>

    <?php 
        $houseHolds = HouseHold::findAll("", $purok, $houseOwnershipStatus, $electricity, $sanitaryToilet, $monthLyIncome, 1, $year, $qtr, 1, 999999999999999999);

    ?>


    <?php foreach ($houseHolds as $houseHold) { ?>
        <div class="page-break-after">

            <h3 class="text-center text-uppercase h2 p-0 m-0 h6">
                Registry of Barangay Inhabitant - Migrants
            </h3>
            <p class="text-center text-uppercase p-0 m-0">
                <?php echo($web->address); ?>
            </p>
            <br>
            <div class="row m-0 p-0">
                <div class="col py-2 px-0 m-0">
                    <div class="text-uppercase fs-5"><?php echo($houseHold->purok); ?></div>
                </div>
                <div class="col py-2 px-0 m-0">
                    <div class="text-uppercase fs-5 d-flex justify-content-end">Household no. <?php echo($houseHold->houseHoldNo); ?></div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Last Name</th>
                        <th class="text-center">First Name</th>
                        <th class="text-center">Middle Name</th>
                        <th class="text-center">Ext. of Name</th>
                        <th class="text-center">Sex</th>
                        <th class="text-center">Age</th>
                        <th class="text-center">Birth Date</th>
                        <th class="text-center text-nowrap">Birth Place</th>
                        <th class="text-center">Highest School Attended</th>
                        <th class="text-center">Role in Family</th>
                        <th class="text-center">Civil Status</th>
                        <th class="text-center">Schooling <br> Yes/No</th>
                        <th class="text-center">Stat's of House ownership<br>Rent/Own</th>
                        <th class="text-center">Electricity <br> Yes/No</th>
                        <th class="text-center">Sources of Wataer</th>
                        <th class="text-center">Sanitary Toilet</th>
                    </tr>
                </thead>
                <tbody>

                
                    <?php $head; ?>

                    <?php foreach ($houseHold->familyMembers as $fam) { ?>

                        <?php 
                            if ($fam->isHead == 1) {
                                $head = $fam;
                            }    

                        ?>
                        
                        <tr>
                            <td class="text-nowrap"><?php echo($fam->lastName); ?></td>
                            <td class="text-nowrap"><?php echo($fam->firstName); ?></td>
                            <td class="text-nowrap"><?php echo($fam->middleName); ?></td>
                            <td class="text-nowrap"><?php echo($fam->extName); ?></td>

                            <?php if ($fam->sex == 1) { ?>
                                <td class="text-center">Male</td>
                            <?php } else if ($fam->sex == 2) { ?>
                                <td class="text-center">Female</td>
                            <?php } ?>
                            
                            <td class="text-center text-nowrap"><?php echo(calculateAge($fam->birthDate)); ?></td>
                            <td class="text-nowrap"><?php echo(date("M d, Y", strtotime($fam->birthDate))); ?></td>
                            <td><?php echo($fam->birthPlace); ?></td>
                            <td><?php echo($fam->educationalAttainment); ?></td>
                            <td><?php echo($fam->role); ?></td>
                            <td><?php echo($fam->civilStatus); ?></td>

                            <?php if ($fam->isSchooling == 1) { ?>
                                <td class="text-center"><?php echo("Yes"); ?></td>
                            <?php } else { ?>
                                <td class="text-center"><?php echo("No"); ?></td>
                            <?php } ?>

                            <?php if ($houseHold->houseOwnershipStatus == 1) { ?>
                                <td class="text-center"><?php echo("Owned"); ?></td>
                            <?php } else { ?>
                                <td class="text-center"><?php echo("Rent"); ?></td>
                            <?php } ?>

                            <?php if ($houseHold->electricity == 1) { ?>
                                <td class="text-center"><?php echo("Yes"); ?></td>
                            <?php } else { ?>
                                <td class="text-center"><?php echo("No"); ?></td>
                            <?php } ?>

                            <td>
                                

                                <?php foreach ($houseHold->waterSources as $waterSource) { ?>
                                    <div class="text-nowrap"><?php echo($waterSource); ?> </div>
                                <?php } ?>

                            </td>

                            <?php if ($houseHold->sanitaryToilet == 1) { ?>
                                <td class="text-center"><?php echo("Yes"); ?></td>
                            <?php } else { ?>
                                <td class="text-center"><?php echo("No"); ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

            <div class="py-2 d-flex w-100">
                <div class="w-100">
                    Prepared By: <br><br>
                    <u><b><?php echo($head->name); ?></b></u><br>
                    <i><small>Household Owner/Respondent</small></i>
                </div>
                <div class="w-100">
                    Certified Correct: <br><br>
                    <u><b><?php echo($web->brgySecretaryName); ?></b></u><br>
                    <i><small>Barangay Secretary</small></i>
                </div>
                <div class="w-100">
                    Certified Correct: <br><br>
                    <u><b><?php echo($web->brgyCaptainName); ?></b></u><br>
                    <i><small>Punong Barangay</small></i>
                </div>
            </div>

        </div>

        
    <?php } ?>

    
<?php } else { ?>


    <?php if (!isset($_GET['advanceFilter'])) { ?>  
        <?php 
            $citizens = Citizen::findAll("", $purok, $status, $year, $qtr, 1, 999999999999999999);
        ?>
        
    <?php } else { ?>

        <?php 

        $advanceFilter = $_GET['advanceFilter'];

        $advanceFilter = json_decode($advanceFilter);

        
        if ($advanceFilter->soloParentFilter == 1) {
            $soloParentFilter = 1;
        } else {
            $soloParentFilter = null;
        }

        if (count($advanceFilter->studentFilter) > 0) {
            $studentFilter = $advanceFilter->studentFilter;
        } else {
            $studentFilter = null;
        }

        if (count($advanceFilter->srCitizenFilter) > 0) {
            $srCitizenFilter = $advanceFilter->srCitizenFilter;
        } else {
            $srCitizenFilter = null;
        }

        if (count($advanceFilter->cyFilter) > 0) {
            $cyFilter = $advanceFilter->cyFilter;
        } else {
            $cyFilter = null;
        }
        
        if (count($advanceFilter->pwdFilter) > 0) {
            $pwdFilter = $advanceFilter->pwdFilter;
        } else {
            $pwdFilter = null;
        }

            
        $citizens = Citizen::findByAdvanceFilter(1, 999999999999999999, $purok, $status, $year, $qtr, $soloParentFilter, $studentFilter, $srCitizenFilter, $cyFilter, $pwdFilter);

        ?>
        
    <?php } ?>

    <h3 class="text-center text-uppercase h2 p-0 m-0 h6">
        barangay <?php echo($web->brgy); ?>
    </h3>
    <h3 class="text-center text-uppercase h2 p-0 m-0 h6">
        OFFICE OF THE PUNONG BARANGAY
    </h3>
    <p class="text-center text-uppercase p-0 m-0">
        <?php echo($web->address); ?>
    </p>
    
    <table class="table table-bordered">
        <thead>
            <tr>
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
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($citizens as $citizen) { ?>
                <tr>
                    <td><?php echo($count++); ?></td>
                    <td><?php echo($citizen->lastName); ?></td>
                    <td><?php echo($citizen->firstName); ?></td>
                    <td><?php echo($citizen->middleName); ?></td>
                    <td><?php echo($citizen->extName); ?></td>
                    <?php if ($citizen->sex == 1) { ?>
                        <td class="text-center">Male</td>
                    <?php } else if ($citizen->sex == 2) { ?>
                        <td class="text-center">Female</td>
                    <?php } ?>
                    <td class="text-center text-nowrap"><?php echo(date('M d, Y', strtotime($citizen->birthDate))); ?></td>
                    <td class="text-center text-nowrap"><?php echo(calculateAge($citizen->birthDate)); ?></td>
                    <td><?php echo($citizen->birthPlace); ?></td>
                    <td class="text-nowrap"><?php echo($citizen->educationalAttainment); ?></td>
                    <td class="text-nowrap"><?php echo($citizen->occupation); ?></td>
                    <td class="text-nowrap"><?php echo($citizen->role); ?></td>
                    <td class="text-nowrap"><?php echo($citizen->civilStatus); ?></td>
                    <td class="text-nowrap"><?php echo($citizen->religion); ?></td>

                    <?php if ($citizen->isSchooling == 1) { ?>
                        <td class="text-center">Yes</td>
                    <?php } else if ($citizen->isSchooling == 2) { ?>
                        <td class="text-center">No</td>
                    <?php } ?>

                    <?php if ($citizen->soloParent == 1) { ?>
                        <td class="text-center">Yes</td>
                    <?php } else { ?>
                        <td class="text-center">No</td>
                    <?php } ?>

                    <?php if ($citizen->pwdId == 0) { ?>
                        <td class="text-center" colspan="2">No</td>
                    <?php } else { ?>
                        <td class="text-nowrap">ID No.: <?php echo($citizen->pwdId); ?></td>
                        <td class="text-nowrap">
                            <?php $typeCount = 0; ?>
                            <?php foreach ($citizen->disabilityType as $type) { ?>
                                <?php if ($typeCount++ == 0) { ?>
                                    <?php echo($type); ?>
                                <?php } else { ?>
                                    , <br><?php echo($type); ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <div class="py-2 d-flex w-100">

        <div class="w-100">
            Prepared by: <br><br>
            <u><b><?php echo($web->brgySecretaryName); ?></b></u><br>
            <i><small>Barangay Secretary</small></i>
        </div>
        <div class="w-100">
            Certified Correct: <br><br>
            <u><b><?php echo($web->brgyCaptainName); ?></b></u><br>
            <i><small>Punong Barangay</small></i>
        </div>
    </div>
    
    
<?php } ?>




    


    <?php 
        // include_once 'Views/templates/foot.php';
    ?>

    <script>
        window.print();
    </script>
</body>
</html>