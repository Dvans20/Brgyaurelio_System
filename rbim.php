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

                                    <li class="breadcrumb-item active" aria-current="page">RBIM</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Registry of Barangay Inhabitant - Migrants</h2>
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
                            <input type="radio" class="form-check-input" name="status_of_house_ownership" id="status_of_house_ownership-owned" value="1"> <label class="cursor-pointer" for="status_of_house_ownership-owned">Yes/Owned</label> 
                            &emsp;
                            <input type="radio" class="form-check-input" name="status_of_house_ownership" id="status_of_house_ownership-rent" value="2"> <label class="cursor-pointer" for="status_of_house_ownership-rent">Rent Only</label> 
                        </div>

                        <!-- Electricity -->
                        <div class="py-2">
                            <b>Electricity</b>
                            <small>Does the household currently have an installed electricity on their premises?</small>
                            <br>
                            <input type="radio" class="form-check-input" name="electricity" id="electricity-yes" value="1"> <label class="cursor-pointer" for="electricity-yes">Yes</label> 
                            &emsp;
                            <input type="radio" class="form-check-input" name="electricity" id="electricity-no" value="2"> <label class="cursor-pointer" for="electricity-no">No</label> 
                        </div>

                        <!-- Water Source -->
                        <div class="py-2">
                            <b>Water Source</b>
                            <small>Select any sources of water that your household uses.</small>
                            <br>
                            <div class="row p-0 m-0">
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water" id="source_of_water1" value="Rainwater Harvesting"> <label class="cursor-pointer" for="source_of_water1">Rainwater Harvesting</label> 
                                </div>
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water" id="source_of_water2" value="River or Stream"> <label class="cursor-pointer" for="source_of_water2">River or Stream</label> 
                                </div>
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water" id="source_of_water3" value="Nearby Well"> <label class="cursor-pointer" for="source_of_water3">Nearby Well</label> 
                                </div>
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water" id="source_of_water4" value="Nearby Spring"> <label class="cursor-pointer" for="source_of_water4">Nearby Spring</label> 
                                </div>
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water" id="source_of_water5" value="Reservoir"> <label class="cursor-pointer" for="source_of_water5">Reservoir</label> 
                                </div>
                               
                                <div class="col-md-4 col-xl px-2 text-nowrap"> 
                                    <input type="checkbox" class="form-check-input" name="source_of_water_others" id="source_of_water_others" value="others"> <label class="cursor-pointer" for="source_of_water_others">Others <small>(Please Specify...)</small></label> 
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
                            <input type="radio" class="form-check-input" name="sanitary_toilet" id="sanitary_toilet-yes" value="1"> <label class="cursor-pointer" for="sanitary_toilet-yes">Yes</label> 
                            &emsp;
                            <input type="radio" class="form-check-input" name="sanitary_toilet" id="sanitary_toilet-no" value="2"> <label class="cursor-pointer" for="sanitary_toilet-no">No</label> 
                        </div>

                        
                        <hr>

                        <!-- Contact Info -->
                        <div class="row m-0 p-0 on_new_only">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="contactNo" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);" id="contactNo" placeholder="House Hold Contact No.">
                                    <label for="contactNo">House Hold Contact No.</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="numFamily" id="numFamily" placeholder="Number of Families" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <label for="numFamily">Number of Families</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="House Hold Email">
                                    <label for="email">House Hold Email</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" name="monthLyIncome" id="monthLyIncome" placeholder="Household Monthly Income" class="form-control">
                                    <label for="monthLyIncome">Household Monthly Income</label>
                                    <!-- <select name="monthLyIncome" id="monthLyIncome" class="form-select">
                                        <option value="">Household Monthly Income</option>
                                        <option value="60000">₱ 60,000.00 and above</option>
                                        <option value="50000">₱ 50,000.00 to ₱ 60,000.00</option>
                                        <option value="40000">₱ 40,000.00 to ₱ 50,000.00</option>
                                        <option value="30000">₱ 30,000.00 to ₱ 40,000.00</option>
                                        <option value="20000">₱ 20,000.00 to ₱ 30,000.00</option>
                                        <option value="10000">₱ 10,000.00 to ₱ 20,000.00</option>
                                        <option value="5000">₱ 5,000.00 to ₱ 10,000.00</option>
                                        <option value="4999">below ₱ 5,000.00</option>
                                    </select> -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-2">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary custom-btn" data-bs-toggle="modal" data-bs-target="#familyMemberFormModal">
                                    <span class="fas fa-plus"></span> Add Family Member
                                </button>
                            </div>

                            <div class="table-responsive py-2">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Select Head of the Household</th>
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
                                            <th class="text-center">Currently <br> Attending School</th>
                                            <th class="text-center" colspan="2">PWD</th>
                                            <th class="text-center">Solo Parent</th>
                                            <th class="text-center text-nowrap"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="familyMembersList">
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row p-0 m-0 on_new_only" id="generatePassKeyCont">
                            <div class="col-sm m-0 p-0 position-relative">
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
                            <button class="btn custom-btn btn-primary btn-lg w-100 text-center my-2 mx-1" id="saveRBIMBtn">
                                <span class="fas fa-save"></span> Save
                            </button>
                            <a href="<?php echo($web->siteUrl); ?>" class="btn custom-btn btn-secondary bg-secondary w-100 text-center my-2 mx-1" id="cancelForm">
                                <span class="fas fa-ban"></span> Cancel
                            </a>
                        </div>
                    </div>
                </div>


                

            </section>


                
            
        </main>

        <div class="modal fade" data-bs-backdrop="static" id="familyMemberFormModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="" id="familyMemberForm" class="custom-form" autocomplete="off">
                        <div class="modal-header">
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row m-0 p-0">
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="lastName" id="lastName" oninput="this.value=this.value.replace(/[0-9]/g, '')" placeholder="Last Name" class="form-control">
                                        <label for="lastName">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="firstName" id="firstName" oninput="this.value=this.value.replace(/[0-9]/g, '')" placeholder="First Name" class="form-control">
                                        <label for="firstName">First Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="middleName" id="middleName" oninput="this.value=this.value.replace(/[0-9]/g, '')" placeholder="Middle Name" class="form-control">
                                        <label for="middleName">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="extName" id="extName" oninput="this.value=this.value.replace(/[0-9]/g, '')" placeholder="Ext. Name" class="form-control">
                                        <label for="extName">Ext. Name</label>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 py-2">
                                    <div class="form-floating">
                                        <select name="sex" id="sex" class="form-select">
                                            <option value="">Sex</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                        <!-- <label for="sex">Sex</label> -->
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <select name="civilStatus" id="civilStatus" class="form-select">
                                            <option value="">Civil Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Annulled">Annulled</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Live-In Partner">Live-In Partner</option>
                                        </select>
                                        <!-- <label for="civilStatus">Civil Status</label> -->
                                    </div>
                                </div>
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <select name="religion" id="religion" class="form-select">
                                            <option value="">Religion</option>
                                            <option value="Buddhism">Buddhism</option>
                                            <option value="Christianity">Christianity</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Hinduism">Hinduism</option>
                                            <option value="Philippine Independent Church">Philippine Independent Church</option>
                                            <option value="Baháʼí Faith">Baháʼí Faith</option>
                                            <option value="Catholic Church">Catholic Church</option>
                                            <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                                            <option value="Baptist religion">Baptist religion</option>
                                            <option value="Seventh-day Adventist Church">Seventh-day Adventist Church</option>
                                            <option value="Eastern Orthodox Church">Eastern Orthodox Church</option>
                                            <option value="Jehovah's Witnesses">Jehovah's Witnesses</option>
                                            <option value="Indigenous Philippine folk religions">Indigenous Philippine folk religions</option>
                                            <option value="Catholic Apostolic Church">Catholic Apostolic Church</option>
                                        </select>
                                        <!-- <label for="religion">Religion</label> -->
                                    </div>
                                </div>
                                <div class="col-lg-4 py-2">
                                    <div class="form-floating">
                                        <select name="educationalAttainment" id="educationalAttainment" class="form-select">
                                            <option value="">Educational Attainment</option>
                                            <option value="Not Attended">Not Attended</option>
                                            <option value="Pre School">Pre School</option>
                                            <option value="Kinder-Garten">Kinder-Garten</option>
                                            <option value="Elementary Level">Elementary Level</option>
                                            <option value="Elementary Graduate">Elementary Graduate</option>
                                            <option value="High School Level">High School Level</option>
                                            <option value="High School Graduate">High School Graduate</option>
                                            <option value="College Level">College Level</option>
                                            <option value="College Graduate">College Graduate</option>
                                            <option value="Post Graduate">Post Graduate</option>
                                            <option value="Vocational">Vocational</option>
                                        </select>
                                        <!-- <label for="educationalAttainment">Educational Attainment</label> -->
                                    </div>
                                </div>
                                <div class="col-lg-3 py-2">
                                    <div class="form-floating">
                                        <input type="date" name="birthDate" id="birthDate" placeholder="Birth Date" class="form-control">
                                        <label for="birthDate">Birth Date</label>
                                    </div>
                                </div>
                                <div class="col-lg-9 py-2">
                                    <div class="form-floating">
                                        <input type="text" name="birthPlace" id="birthPlace" placeholder="Birth Place" class="form-control">
                                        <label for="birthPlace">Birth Place</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 py-2">
                                    <div class="form-floating">
                                        <input 
                                            type="text" 
                                            name="occupation" 
                                            id="occupation" 
                                            placeholder="Occupation" 
                                            class="form-control" 
                                            list="occupationList"
                                            oninput="this.value=this.value.replace(/[0-9]/g, '')"
                                        >
                                        <label for="occupation">Occupation</label>
                                        <datalist id="occupationList">
                                            <option value="Unemployed"></option>
                                            <option value="Self-Employed"></option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-lg-4 py-2">
                                    <div class="form-floating">
                                        <select name="role" id="role" class="form-select">
                                            <option value="">Role</option>
                                            <option value="Father">Father</option>
                                            <option value="Mother">Mother</option>
                                            <option value="Son/Daughter">Son/Daughter</option>
                                            <option value="Grand Children">Grand Children</option>
                                            <option value="Grand Parent">Grand Parent</option>
                                            <option value="Sibling">Sibling</option>
                                            <option value="others">Others Plsease Specify...</option>
                                        </select>
                                        <!-- <label for="role">Role</label> -->
                                    </div>
                                    
                                </div>
                                <div class="col-lg-4 py-2 d-none slide_in" id="role_in_cont">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-underline" id="role_in" name="role_in" placeholder="Specify Role here.">
                                        <label for="role_in" class="text-muted">Specify Role here.</label>
                                    </div>
                                </div>

                                




                            </div>

                            <hr>

                            <div class="row m-0 p-0">
                                <div class="col-lg-12 px-2 m-0">
                                    <small><i>Check if Applicable.</i></small>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="isSchooling" class="cursor-pointer">
                                        <input type="checkbox" name="isSchooling" id="isSchooling" class="" value="1"> 
                                        Currently Attending School.
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="isPwd" class="cursor-pointer">
                                        <input type="checkbox" name="isPwd" id="isPwd" class="" value="1"> 
                                        PWD
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="soloParent" class="cursor-pointer">
                                        <input type="checkbox" name="soloParent" id="soloParent" class="" value="1"> 
                                        Solo Parent
                                    </label>
                                </div>
                            </div>

                            
                            <div class="row m-0 p-0 fade_in d-none" id="disabilityTypesContainer">
                                <div class="col-lg-12 p-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="pwdId" id="pwdId" placeholder="PWD Id No.">
                                        <label for="pwdId">PWD Id No.</label>
                                    </div>
                                   
                                    
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType1" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType1" class="form-check-input" value="Speech Impairment"> 
                                        Speech Impairment
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType2" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType2" class="form-check-input" value="Orthopedic"> 
                                        Orthopedic
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType3" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType3" class="form-check-input" value="Learning"> 
                                        Learning
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType4" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType4" class="form-check-input" value="Intellectual"> 
                                        Intellectual
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType5" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType5" class="form-check-input" value="Mental"> 
                                        Mental
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType6" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType6" class="form-check-input" value="Visual"> 
                                        Visual
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType7" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType7" class="form-check-input" value="Psychosocial"> 
                                        Psychosocial
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType8" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType8" class="form-check-input" value="Physical"> 
                                        Physical
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType9" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType9" class="form-check-input" value="Hearing Impairment"> 
                                        Hearing Impairment
                                    </label>
                                </div>
                                <div class="col-lg-4 p-2">
                                    <label for="disabilityType10" class="cursor-pointer">
                                        <input type="checkbox" name="disabilityType" id="disabilityType10" class="form-check-input" value="Chronic Illness"> 
                                        Chronic Illness
                                    </label>
                                </div>
                            </div>


                            <input type="hidden" id="index" name="index">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">
                                <span class="fas fa-save"></span> Save Family Memberz
                            </button>
                            <button class="btn bg-secondary custom-btn" type="button" data-bs-dismiss="modal">
                                <span class="fas fa-ban"></span> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" data-bs-backdrop="static" id="askStatusModal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="alert alert-info small text-muted p-2">
                            If this is your first time registering in this portal then click New.
                        </div>
                        <div class="p-1">
                            <button class="btn custom-btn" data-bs-dismiss="modal" type="button">
                                New Inhabitant/Migrants
                            </button>
                        </div>
                        <div class="p-1">
                            <button class="btn custom-btn" id="existingIMBtn">
                                Existing Inhabitant/Migrants
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="existingHouseHoldFormModal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <form class="custom-form" id="existingHouseHoldForm">
                        <div class="modal-header">
                            <button class="btn-close" data-bs-dismiss="modal" type="button" id="xExistingHouseHoldFormModal"></button>
                        </div>
                        <div class="modal-body py-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="existingHouseholdNo" id="existingHouseholdNo" placeholder="Enter your Household No.">
                                <label for="existingHouseholdNo">Enter your Household No.</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" name="existingHouseholdKey" id="existingHouseholdKey" placeholder="Enter your Household Key">
                                <label for="existingHouseholdKey">Enter your Household Key</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex w-100">
                                <button class="btn btn-sm btn-secondary custom-btn fs-6 m-1 w-100" id="cancelExistingHouseHoldFormModal" data-bs-dismiss="modal" type="button">
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
        <script src="js/rbim.js<?php echo("?v=" . time().uniqid()); ?>"></script>

    </body>
</html>