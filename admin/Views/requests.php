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
        
            <h3 class="py-3 pop_in_on_scroll">
                <span class="fas fa-clipboard-list"></span> Requests
            </h3>
            

            <div class="card pop_in_on_scroll">
                <div class="card-header p-0">
                    <div class="row p-0 m-0">
                        <div class="col-md p-0 m-0 w-100">
                            <label for="statusFilter0" class="btn btn-lg btn-primary w-100 requests_status_btn active" value="0">
                                Pending
                            </label>
                        </div>
                        <div class="col-md p-0 m-0 w-100">
                            <label for="statusFilter1" class="btn btn-lg btn-primary w-100 requests_status_btn" value="1">
                                Approved
                            </label>
                        </div>
                        <div class="col-md p-0 m-0 w-100">
                            <label for="statusFilter2" class="btn btn-lg btn-primary w-100 requests_status_btn" value="2">
                                Declined
                            </label>
                        </div>
                    </div>
                    <div class="d-none">
                        <input type="radio" name="statusFilter" id="statusFilter0" value="0" checked>
                        <input type="radio" name="statusFilter" id="statusFilter1" value="1">
                        <input type="radio" name="statusFilter" id="statusFilter2" value="2">
                    </div>

                    <div class="p-2">
                        <form id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                                <button class="btn btn-primary input-group-text" type="submit">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">

                    <idv class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Contact Info</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="requestsList">

                            </tbody>
                        </table>
                    </idv>

                </div>
                <div class="card-footer">
                    <div id="requestsLinks" class="d-flex justify-content-end"></div>
                </div>
            </div>
        </div>

       
    </div>


    <div class="modal fade" id="previewRequestModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="reqPreviewTable">
                            <tr><td>Name</td><td>:</td><td id="namePreview"></td></tr>
                            <tr><td>Address</td><td>:</td><td id="addressPreview"></td></tr>
                            <tr><td>Contact No.</td><td>:</td><td id="contactNumberPreview"></td></tr>
                            <tr><td>Email</td><td>:</td><td id="emailPreview"></td></tr>
                            <tr><td>Certificate</td><td>:</td><td id="certificatePreview"></td></tr>
                            <tr><td>Date Requested</td><td>:</td><td id="dateTimeRequestedPreview"></td></tr>   
                        </table>
                        <div id="descriptionPreview" class="p-1">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveRequestModal" data-bs-backdrop="static">
        <div class="modal modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" onclick="approveRequestModalBS.hide()"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to approve this request?

                   <div class="">
                        <label for="dateTimeAppointed"><small>Set date and time of appointment</small></label>
                        <input type="datetime-local" class="form-control pt-3" name="dateTimeAppointed" id="dateTimeAppointed">
                   </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" id="updateReqStatusBtn">Approve</button>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="button" onclick="approveRequestModalBS.hide()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rescheduleRequestModal" data-bs-backdrop="static">
        <div class="modal modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" onclick="rescheduleRequestModalBS.hide()"></button>
                </div>
                <div class="modal-body">
                   <div class="">
                        <label for="dateTimeReAppointed"><small>Reschedule date and time of appointment</small></label>
                        <input type="datetime-local" class="form-control pt-3" name="dateTimeReAppointed" id="dateTimeReAppointed">
                   </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" id="rescheduleReqStatusBtn">Reschedule</button>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="button" onclick="rescheduleRequestModalBS.hide()">Close</button>
                </div>
            </div>
        </div>
    </div>


    

    


    <?php 
        include_once 'Views/templates/foot.php';
    ?>

    <script src="Views/js/requests.js<?php echo("?v=" . time() . uniqid()); ?>"></script>

</body>
</html>