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
              
            <?php include_once 'header_nav.php' ;
            extract($_GET);
            ?>
            
            

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
              <?php 
             if (isset($busNo)) {
                // $conx = new mysqli("localhost", "root", "", "brgyaurelio");
                $conx = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
                $conx->set_charset("utf8mb4");
                extract($_GET);
                $passKey = str_replace(" ", "+", $passKey);
                $sql  = "SELECT * FROM `rbbo` WHERE `busNo`='$busNo' AND `passKey`='$passKey'";
                $queryx = $conx->query($sql);
                $rowx = $queryx->fetch_assoc();
                $tid = $rowx['id'];
             }
             ?>
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
               <?php if (isset($busNo)): ?>
                    <div class="container mt-5">
                    <div class="custom-block bg-white shadow-lg custom-form">

                        <div class="row">
                            <div class="col-md-4">
                                <!-- <div class="h4 text-uppercase py-2 m-0">purok: purok 0</div> -->
                                 <div class="form-floating">
                                    <select name="purok" id="purok" class="form-select" onchange="updatedata('rbbo','purok',this.value,'id','<?php echo $tid ?>')">
                                        <option disabled value="">Select a Purok</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 1' ) ? 'selected' : '' ?> value="Purok 1">Purok 1</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 2' ) ? 'selected' : '' ?> value="Purok 2">Purok 2</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 3' ) ? 'selected' : '' ?> value="Purok 3">Purok 3</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 4' ) ? 'selected' : '' ?> value="Purok 4">Purok 4</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 5' ) ? 'selected' : '' ?> value="Purok 5">Purok 5</option>
                                            <option <?php echo ($rowx['purok'] == 'Purok 6' ) ? 'selected' : '' ?> value="Purok 6">Purok 6</option>
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
                                    <input value="<?php echo $rowx['onwnersName'] ?>" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" onkeyup="updatedata('rbbo','onwnersName',this.value,'id','<?php echo $tid ?>')">
                                    <label for="name">Enter Name</label>
                                </div>
                            </div>
                            <div class="col-md-8 p-2 m-0">
                                <div class="form-floating">
                                    <input value="<?php echo $rowx['residenceAddress'] ?>" type="text" class="form-control" name="residenceAddress" id="residenceAddress" placeholder="Residence Address" onkeyup="updatedata('rbbo','residenceAddress',this.value,'id','<?php echo $tid ?>')">
                                    <label for="residenceAddress">Residence Address</label>
                                </div>
                            </div>

                            <div class="col-md-12 m-0 p-2">
                                <div class="form-floating">
                                    <input value="<?php echo $rowx['businessName'] ?>" type="text" class="form-control" name="businessName" id="businessName" placeholder="Business Name" onkeyup="updatedata('rbbo','businessName',this.value,'id','<?php echo $tid ?>')">
                                    <label for="businessName">Business Name</label>
                                </div>
                            </div>

                            <div class="col-md-6 p-0 m-0">
                                <div class="p-2">
                                    <div class="my-1 form-floating">
                                        <select name="businessCategory" id="businessCategory" class="form-select" onchange="updatedata('rbbo','category',this.value,'id','<?php echo $tid ?>')">
                                            <option value="">Business Category</option>
                                            <option <?php echo ($rowx['category'] == 'Retail & Consumer Goods' ) ? 'selected' : '' ?>  value="Retail &amp; Consumer Goods">Retail &amp; Consumer Goods</option>
                                            <option <?php echo ($rowx['category'] == 'Service-Oriented Businesses' ) ? 'selected' : '' ?> value="Service-Oriented Businesses">Service-Oriented Businesses</option>
                                            <option <?php echo ($rowx['category'] == 'Manufacturing & Industrial' ) ? 'selected' : '' ?> value="Manufacturing &amp; Industrial">Manufacturing &amp; Industrial</option>
                                            <option <?php echo ($rowx['category'] == 'Healthcare & Wellness' ) ? 'selected' : '' ?> value="Healthcare &amp; Wellness">Healthcare &amp; Wellness</option>
                                            <option <?php echo ($rowx['category'] == 'Agriculture & Farming' ) ? 'selected' : '' ?> value="Agriculture &amp; Farming">Agriculture &amp; Farming</option>
                                            <option <?php echo ($rowx['category'] == 'Franchise Business' ) ? 'selected' : '' ?> value="Franchise Business">Franchise Business</option>
                                            <option <?php echo ($rowx['category'] == 'Real Estate' ) ? 'selected' : '' ?> value="Real Estate &amp; Property">Real Estate &amp; Property</option>
                                            <option <?php echo ($rowx['category'] == 'Transportation & Logistics' ) ? 'selected' : '' ?> value="Transportation &amp; Logistics">Transportation &amp; Logistics</option>
                                            <option <?php echo ($rowx['category'] == 'Education & Training' ) ? 'selected' : '' ?> value="Education &amp; Training">Education &amp; Training</option>
                                        </select>
                                        <!-- <label for="businessType">Business Type</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-0 m-0">
                                <div class="p-2">
                                    <div class="my-1 form-floating">
                                        <select name="businessType" id="businessType" class="form-select" disabled="" onchange="updatedata('rbbo','type',this.value,'id','<?php echo $tid ?>')">
                                            <option value=""><?php echo $rowx['type'] ?></option>
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
                                    <input type="text" class="form-control" name="contactNo" id="contactNo" placeholder="Business Contact No." value="<?php echo $rowx['contactNo'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);" onkeyup="updatedata('rbbo','contactNo',this.value,'id','<?php echo $tid ?>')">
                                    <label for="contactNo">Business Contact No.</label>
                                </div>
                            </div>
                            <div class="col-md p-2">
                                <div class="form-floating">
                                    <input value="<?php echo $rowx['email'] ?>" type="text" class="form-control" name="email" id="email" placeholder="Business Email" onkeyup="updatedata('rbbo','email',this.value,'id','<?php echo $tid ?>')">
                                    <label for="email">Business Email</label>
                                </div>
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
    });
}
            const BusinessesCategories = [
    "Retail & Consumer Goods",
    "Service-Oriented Businesses",
    "Manufacturing & Industrial",
    "Healthcare & Wellness",
    "Agriculture & Farming",
    "Franchise Business",
    "Real Estate & Property",
    "Transportation & Logistics",
    "Education & Training"
];

$.each(BusinessesCategories, function (index, val) { 
     $('#businessCategory').append('<option value="'+val+'">'+val+'</option>');
});

const RetailAndConsumerGoods = [
    "Sari-Sari",
    "General Merchandise",
    "Hardware",
    "Grocery",
    "Convenience Store",
    "Electronics and Appliances",
    "Department",
    "Clothing and Apparel",
    "Bakery",
    "Pharmacy/Drugstore",
    "Restaurant",
    "Carinderia",
    "Fast Food Chain",
    "Food Stall/ Food Cart",
    "Catering Services",
    "Coffee Shop/Café",
    "Beverage Stand/Shake Shop"
];

const ServiceOrientedBusinesses = [
    "Salon/Barbershop",
    "Laundry",
    "Printing",
    "Event Planning and Coordination",
    "Travel Agency",
    "Courier/Delivery Services",
    "Tech Support & Services",
];

const ManufacturingAndIndustrial = [
    "Furniture Manufacturing",
    "Garment Manufacturing",
    "Construction and Building Supplies",
    "Packaging Services",
    "Food Processing"
];

const HealthcareAndWellness = [
    "Medical Clinic",
    "Dental Clinic",
    "Fitness Center/Gym",
    "Spa and Wellness Center",
];

const AgricultureAndFarming = [
    "Farm-to-Market Business",
    "Livestock Farming",
    "Aquaculture/Fish Farming",
    "Agri-Tourism",
    "Organic Farming",
];

const FranchiseBusiness = [
    "Food Franchises",
    "Retail Franchises",
    "Service Franchises",
];

const RealEstateAndProperty = [
    "Real Estate Agency",
    "Property Management",
    "Construction and Development"
];

const TransportationAndLogistics = [
    "Transportation Services (e.g., Jeepney, Tricycle)",
    "Car Rental Services",
    "Shipping and Freight Services",
    "Trucking and Hauling Services"
];

const EducationAndTraining = [
    "Tutorial Center",
    "Vocational Training Center",
    "School",
];





$('#businessCategory').change(function (e) { 

    $('#businessType').html('<option value="">Business Type</option>');
    $('#businessType').prop('disabled', false);

    e.preventDefault();
    
    switch ($(this).val()) {

        case "Retail & Consumer Goods" :
            $.each(RetailAndConsumerGoods, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Service-Oriented Businesses" :
            $.each(ServiceOrientedBusinesses, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Manufacturing & Industrial" :
            $.each(ManufacturingAndIndustrial, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Healthcare & Wellness" :
            $.each(HealthcareAndWellness, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Agriculture & Farming" :
            $.each(AgricultureAndFarming, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Franchise Business" :
            $.each(FranchiseBusiness, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Real Estate & Property" :
            $.each(RealEstateAndProperty, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Transportation & Logistics" :
            $.each(TransportationAndLogistics, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        case "Education & Training" :
            $.each(EducationAndTraining, function (index, val) { 
                 $('#businessType').append('<option value="'+val+'">'+val+'</option>');
            });
            break;
        default:
            $('#businessType').prop('disabled', true);
            break;
    }
});
        </script>
    </body>
</html>