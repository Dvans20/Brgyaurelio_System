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
            
            <?php include_once 'header_nav.php'; 
extract($_GET);
            if (isset($householdNo)) {
             // $conx = new mysqli("localhost", "root", "", "brgyaurelio");
             $conx = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
                $conx -> set_charset("utf8");
                extract($_GET);
                $ghinfo = "SELECT * FROM `households` WHERE `houseHoldNo`='$householdNo' AND `houseHoldKey`='$householdKey' ";
                $gh = $conx->query($ghinfo);
                $ghr = $gh->fetch_array();  
                $hid = $ghr[0];
            }
            ?>
            
            

            <header class="site-header d-flex flex-column justify-content-center align-items-center custom-section-bg-image" style="background-image: linear-gradient(0deg, 
    rgba(255,255,255,0), #13547a), url('admin/Media/images/home_cover.jpg?v=<?php echo(time().uniqid()); ?>');">
            <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-12 col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo($web->siteUrl); ?>home">Home</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">RBIM</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Registry of Barangay Inhabitant - Migrants</h2>
                        </div>

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container d-block position-relative">
                    <div class="fs-4 text-muted text-center">
                        <strong>
                            <?php if (isset($_GET['msg'])) { ?>
                                <?php echo($_GET['msg']); ?>
                            <?php } ?>
                            
                        </strong>
                    </div>
                </div>
                <?php
                 if (isset($householdNo)): ?>
                    <div class="container">
                    <div class="custom-block bg-white shadow-lg custom-form mt-5">

                        <div class="row">
                            <div class="col-md-4">
                                <!-- <div class="h4 text-uppercase py-2 m-0">purok: purok 0</div> -->
                                 <div class="form-floating">
                                    <select name="purok" id="purok" class="form-select" disabled>
                                        <option value="">Select a Purok</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 1' ) ? 'selected' : '' ?> value="Purok 1">Purok 1</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 2' ) ? 'selected' : '' ?> value="Purok 2">Purok 2</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 3' ) ? 'selected' : '' ?> value="Purok 3">Purok 3</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 4' ) ? 'selected' : '' ?> value="Purok 4">Purok 4</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 5' ) ? 'selected' : '' ?> value="Purok 5">Purok 5</option>
                                        <option <?php echo ($ghr['purok'] == 'Purok 6' ) ? 'selected' : '' ?> value="Purok 6">Purok 6</option>
                                                                    </select>
                                    <!-- <label for="purok">Select a Purok</label> -->
                                 </div>
                            </div>
                            <div class="col-md">
                                <div class="h4 text-uppercase mt-2 m-0 d-flex justify-content-end d-none" id="householdNoTextCont"><div>Household No.: </div> <div id="householdNoText"></div></div>
                            </div>
                        </div>
                        <hr>


                        <!-- Status of House Ownership -->
                        <div class="py-2">
                            <b>Status of House Ownership</b>
                            <small>Does the household owned the ownership of the house?</small>
                            <br>
                            <input disabled <?php echo ($ghr['houseOwnershipStatus']==1)? 'checked':'' ?> type="radio" class="form-check-input" name="status_of_house_ownership" id="status_of_house_ownership-owned" value="1"> <label class="cursor-pointer" for="status_of_house_ownership-owned">Yes/Owned</label> 
                             
                            <input disabled <?php echo ($ghr['houseOwnershipStatus']==2)? 'checked':'' ?> type="radio" class="form-check-input" name="status_of_house_ownership" id="status_of_house_ownership-rent" value="2"> <label class="cursor-pointer" for="status_of_house_ownership-rent">Rent Only</label> 
                        </div>

                        <!-- Electricity -->
                        <div class="py-2">
                            <b>Electricity</b>
                            <small>Does the household currently have an installed electricity on their premises?</small>
                            <br>
                            
                            <input disabled <?php echo ($ghr['electricity']==1)? 'checked':'' ?> type="radio" class="form-check-input" name="electricity" id="electricity-yes" value="1"> <label class="cursor-pointer" for="electricity-yes">Yes</label> 
                             
                            <input disabled <?php echo ($ghr['electricity']==1)? 'checked':'' ?> type="radio" class="form-check-input" name="electricity" id="electricity-no" value="2"> <label class="cursor-pointer" for="electricity-no">No</label> 
                        </div>

                        <!-- Water Source -->
                        <div class="py-2">
                            <b>Water Source</b>
                            <small>Select any sources of water that your household uses.</small>
                            <br>
                            <?php 

                               $wordsToCheck = ["Rainwater Harvesting", "River or Stream", "Nearby Well", "Nearby Spring", "Reservoir"];
                                $wordis = []; // Initialize as an array
                                $waterSources = $ghr['waterSources'] ?? ""; // Example: Assuming waterSources is fetched from $ghr

                                foreach ($wordsToCheck as $word) {
                                    if (strpos($waterSources, $word) !== false) {
                                        $wordis[] = $word; // Add matching word to the array
                                    }
                                }

                             ?>
                            <div class="row p-0 m-0">
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
    <input type="checkbox" 
           class="form-check-input" 
           name="source_of_water" 
           id="source_of_water1" 
           value="Rainwater Harvesting" 
           <?php echo in_array("Rainwater Harvesting", $wordis) ? 'checked' : ''; ?>> 
    <label class="cursor-pointer" for="source_of_water1">Rainwater Harvesting</label> 
</div>
<div class="col-md-4 col-xl px-2 text-nowrap"> 
    <input type="checkbox" 
           class="form-check-input"  disabled
           name="source_of_water" 
           id="source_of_water2" 
           value="River or Stream" 
           <?php echo in_array("River or Stream", $wordis) ? 'checked' : ''; ?>> 
    <label class="cursor-pointer" for="source_of_water2">River or Stream</label> 
</div>
<div class="col-md-4 col-xl px-2 text-nowrap"> 
    <input type="checkbox" 
           class="form-check-input"  disabled
           name="source_of_water" 
           id="source_of_water3" 
           value="Nearby Well" 
           <?php echo in_array("Nearby Well", $wordis) ? 'checked' : ''; ?>> 
    <label class="cursor-pointer" for="source_of_water3">Nearby Well</label> 
</div>
<div class="col-md-4 col-xl px-2 text-nowrap"> 
    <input type="checkbox" 
           class="form-check-input"  disabled
           name="source_of_water" 
           id="source_of_water4" 
           value="Nearby Spring" 
           <?php echo in_array("Nearby Spring", $wordis) ? 'checked' : ''; ?>> 
    <label class="cursor-pointer" for="source_of_water4">Nearby Spring</label> 
</div>
<div class="col-md-4 col-xl px-2 text-nowrap"> 
    <input type="checkbox" 
           class="form-check-input"  disabled
           name="source_of_water" 
           id="source_of_water5" 
           value="Reservoir" 
           <?php echo in_array("Reservoir", $wordis) ? 'checked' : ''; ?>> 
    <label class="cursor-pointer" for="source_of_water5">Reservoir</label> 
</div>
<div class="col-md-4 col-xl px-2 text-nowrap"> 

    <div class="form-floating">
    <input type="text" class="form-control" readonly name="contactNo" id="contactNo" placeholder="House Hold Contact No." value="<?php if (empty($wordis)) echo $ghr['waterSources']; ?>">
    <label for="contactNo">Other</label>
</div>
</div>
                            </div>
                            <div class="p-0 m-0 d-none slide_in" id="source_of_water_others_in_cont">
                                <small>(separate with comma)</small>
                                <input type="text" class="form-control" name="source_of_water_others_in" id="source_of_water_others_in" placeholder="Other Sources of Water">
                            </div>

                        </div>

                        <!-- Sanitary Toilet -->
                        <div class="py-2">
                            <b>Sanitary Toilet</b>
                            <small>Does the household currently have a sanitary toilet on the premises?</small>
                            <br>
                            <input disabled type="radio" class="form-check-input" <?php echo ($ghr['sanitaryToilet']==1)? 'checked':'' ?> name="sanitary_toilet" id="sanitary_toilet-yes" value="1"> <label class="cursor-pointer" for="sanitary_toilet-yes">Yes</label> 
                             
                            <input disabled type="radio" <?php echo ($ghr['sanitaryToilet']==2)? 'checked':'' ?> class="form-check-input" name="sanitary_toilet"  id="sanitary_toilet-no" value="2"> <label class="cursor-pointer" for="sanitary_toilet-no">No</label> 
                        </div>

                        
                        <hr>

                        <!-- Contact Info -->
                        <div class="row m-0 p-0 on_new_only">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input onkeyup="updatedata('households','contactNo',this.value,'id','<?php echo $hid ?>')" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"   type="text" class="form-control" name="contactNo" id="contactNo" placeholder="House Hold Contact No." value="<?php echo $ghr['contactNo'] ?>">
                                    <label for="contactNo">House Hold Contact No.</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input onkeyup="updatedata('households','email',this.value,'id','<?php echo $hid ?>')" type="text" class="form-control" name="email" id="email" placeholder="House Hold Email" value="<?php echo $ghr['email'] ?>">
                                    <label for="email">House Hold Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input onkeyup="updatedata('households','monthLyIncome',this.value,'id','<?php echo $hid ?>')" type="text" name="monthLyIncome" id="monthLyIncome"  placeholder="Household Monthly Income" class="form-control" value="<?php echo $ghr['monthLyIncome'] ?>">
                                    <label for="monthLyIncome">Household Monthly Income</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-2">
                            <div class="d-flex justify-content-end">
                            </div>

                            <div class="table-responsive py-2">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-nowrap">No.</th>
                                            <th class="text-center text-nowrap">Last Name</th>
                                            <th class="text-center text-nowrap">First Name</th>
                                            <th class="text-center text-nowrap">Middle Name</th>
                                            <th class="text-center text-nowrap">Ext. of Name</th>
                                            <th class="text-center text-nowrap">Sex</th>
                                            <th class="text-center">Birth Date</th>
                                            <th class="text-center text-nowrap">Age</th>
                                            <th class="text-center text-nowrap">Birth Place</th>
                                            <th class="text-center">Highest School Attended</th>
                                            <th class="text-center text-nowrap">Occupation</th>
                                            <th class="text-center">Role in Family</th>
                                            <th class="text-center">Civil Status</th>
                                            <th class="text-center text-nowrap">Religion</th>
                                            <th class="text-center">PWD</th>
                                            <th class="text-center">Solo Parent</th>
                                        </tr>
                                    </thead>
                                    <tbody id="familyMembersList">
                                       <?php 
                                       $i=0;
                                       $ghmems = "SELECT * FROM `citizens` WHERE `houseHoldId`='$hid' ORDER BY `ishead` DESC";
                                            $ghmem = $conx->query($ghmems);
                                            while ($ghr  = $ghmem->fetch_array()) {
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $ghr['lastName'] ?></td>
                                            <td><?php echo $ghr['firstName'] ?></td>
                                            <td><?php echo $ghr['middleName'] ?></td>
                                            <td><?php echo $ghr['extName'] ?></td>
                                            <td><?php echo $ghr['sex'] ?></td>
                                            <td><?php echo $ghr['birthDate'] ?></td>
                                            <td><?php echo date('Y', strtotime($ghr['birthDate'])) - date('Y') ?></td>
                                            <td><?php echo $ghr['birthPlace'] ?></td>
                                            <td><?php echo $ghr['educationalAttainment'] ?></td>
                                            <td><?php echo $ghr['occupation'] ?></td>
                                            <td><?php echo $ghr['role'] ?></td>
                                            <td><?php echo $ghr['civilStatus'] ?></td>
                                            <td><?php echo $ghr['religion'] ?></td>
                                            <td><?php echo ($ghr['pwdId'] == 0) ? 'N/A' :$ghr['pwdId']  ?></td>
                                            <td><?php echo ($ghr['soloParent']==0)? 'No' : 'Yes' ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                        <hr>
                    </div>
                </div>
                <?php endif ?>
            </section>


                
            
        </main>
		
        <?php 
            require_once 'footer.php';
        ?>
<script type="text/javascript">
function updatedata(Table,Column,Value,Condition,Identifier){
    $.ajax({
        type:'GET',
        url:'queries.php',
        data:{
            table:Table,
            column:Column,
            value:Value,
            condition:Condition,
            identifier:Identifier,
            updatedata:'true'
        },
        dataType:'html'
    }).done(function(data){
        console.log(data);
    })
}</script>
    </body>
</html>