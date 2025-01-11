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

        <div class="container py-5 w-100">
            <div class="card pop_in_on_scroll">
                <div class="card-header p-0 m-0">
                    <div class="btn-group w-100 table-responsive">
                        <label class="btn btn-lg btn-primary rbbo_list_btn" id="pendingRbboListBtn" for="pendingRbboListRadio">
                            Pendings
                        </label>
                        <label class="btn btn-lg btn-primary rbbo_list_btn active" id="approvedRbboListBtn" for="approvedRbboListRadio">
                            RBBO
                        </label>
                        <label class="btn btn-lg btn-primary rbbo_list_btn" id="declinedRbboListBtn" for="declinedRbboListRadio">
                            Declined
                        </label>
                    </div>
                    <input type="radio" class="d-none" name="RbboListRadio" id="pendingRbboListRadio" value="0">
                    <input type="radio" class="d-none" name="RbboListRadio" id="approvedRbboListRadio" value="1" checked>
                    <input type="radio" class="d-none" name="RbboListRadio" id="declinedRbboListRadio" value="2">

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
                        
                        <div class="col-sm-4 p-2">
                            <label for="purok">Purok:</label>
                            <select name="purok" id="purok" class="form-select filter_change">
                                <option value="">All</option>
                                <?php foreach ($web->puroks as $purok) { ?>
                                    <option value="<?php echo($purok); ?>"><?php echo($purok); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4 p-2">
                            <label for="year">Year:</label>
                            <select name="year" id="year" class="form-select filter_change">
                                <?php for ($i = date('Y'); $i >= date('Y') - 10; $i--) { ?>
                                    <option value="<?php echo($i); ?>"><?php echo($i); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4 p-2">
                            <label for="qtr">Quarter:</label>
                            <select name="qtr" id="qtr" class="form-select filter_change">
                                <?php if ((date('m') / 1) <= 6) { ?>
                                    <option value="2" selected>1st & 2nd Quarter</option>
                                    <option value="4">3rd & 4th Quarter</option>
                                <?php } else { ?>
                                    <option value="2">1st & 2nd Quarter</option>
                                    <option value="4" selected>3rd & 4th Quarter</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-sm-6 p-2">
                            <label for="category">Business Category:</label>
                            <select name="category" id="category" class="form-select filter_change">
                                <option value="">All</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-sm-6 p-2">
                            <label for="type">Business Type:</label>
                            <select name="type" id="type" class="form-select filter_change" disabled>
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example"class="table table-hover table-striped table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Purok</th>
                                    <th class="text-center">Bus. No.</th>
                                    <th class="text-center">Owner's Name</th>
                                    <th class="text-center">Residence Address</th>
                                    <th class="text-center">Business Name</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="rbboList">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button id="printBtn" class="btn btn-primary btn-md"><i class="fa fa-print"></i> print</button>
                    <div id="rbboLinks" class="d-flex justify-content-end">
                    </div>
                </div>
            </div>

        </div>

    </div>


    <div class="modal fade" id="busNoModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_to_approve" id="id_to_approve">
                    <div class="form-floating">
                        <input type="text" name="bus_no" id="bus_no" class="form-control" placeholder="Bus. No.">
                        <label for="bus_no">Bus. No.</label>
                    </div>

                    <div class="p-1 d-flex justify-content-end">
                        <button class="btn-sm btn-primary btn" id="generateBusNoBtn" type="button">
                            Generate Business No.
                        </button>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" type="submit" onclick="approveRBBOUpdate(document.getElementById('id_to_approve').value, document.getElementById('bus_no').value)">
                        <span class="fas fa-thumbs-up"></span> Approve
                    </button>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="button">
                        <span class="fas fa-ban"></span> Cancel 
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="declineRBBOUpdateModal" data-bs-backdrop="modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="declineRBBOUpdateForm">
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
    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>
    <script src="Views/js/rbbo.js"></script>
<script>
    $(document).ready(function() {
        $('#printBtn').click(function() {
            var printContent = $('#rbboList').html(); // Get only the content inside tbody
            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print Table Body</title>');
            printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {padding: 10px; text-align: left; border: 1px solid #ddd;}.text-center{text-align:center;} </style>');
            printWindow.document.write('</head><body><h2 style="text-align:center;margin-bottom:30px;">Registry of Barangay Business Owners<br><small>P-2 Aurelio, San Jose, Dinagat Islands</small></h2><h5>RBBO LIST</h5>');
            printWindow.document.write('<table border="1"><thead style="text-align:center;"><tr><th class="text-center">No.</th><th class="text-center">Purok</th><th class="text-center">Bus. No.</th><th class="text-center">Owners Name</th><th class="text-center">Residence Address</th><th class="text-center">Business Name</th><th class="text-center">Category</th><th class="text-center">Type</th><th class="text-center">Contact No.</th><th class="text-center">Email</th><th></th></tr></thead><tbody>' + printContent + '</tbody></table>'); // Insert table with the tbody content
            printWindow.document.write('<div style="width:100%;display:flex;flex-direction:row"><div style="width:33.3%;padding:20px;"><h4 style="text-align:center;border-bottom:2px solid black;margin-bottom:5px;padding-bottom:10px;font-size:22px;">Rossana Y. Taray</h4><h6 style="text-align:center;margin-top:5px;font-size:15px;">Barangay Secretary</h6></div><div style="width:33.3%;padding:20px;"><h4 style="text-align:center;border-bottom:2px solid black;margin-bottom:5px;padding-bottom:10px;font-size:22px;">Hon. Lovely Fe B. Bacolod</h4><h6 style="text-align:center;margin-top:5px;font-size:15px;">Punong Barangay</h6></div></div></body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    });
</script>
</body>
</html>