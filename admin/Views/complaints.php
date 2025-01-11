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

            <h5 class="display-6 text-uppercase py-3">
                <span class="fas fa-exclamation-circle"></span> Complaints
            </h5>
        
            <div class="card pop_in_scroll my-3">
                <div class="card-header">

                    <div class="row p-0 m-0">

                        <div class="col-md-5 col-lg-5 col-sm-4 p-1">
                            <form id="searchForm">
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                                    <button class="btn btn-primary input-group-text">
                                        <span class="fas fa-search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-lg-5 col-sm-4 p-1">
                           <select name="statusFilter" id="statusFilter" class="form-select">
                                <option value="">Select Status</option>
                                <option value="Case Pending">Case Pending</option>
                                <option value="Settled">Settled</option>
                                <option value="Under Intervention Program">Under Intervention Program</option>
                                <option value="Filed in the Court">Filed in the Court</option>
                                <option value="Under Investigation">Under Investigation</option>
                                <option value="Referred to Other Agencies">Referred to Other Agencies</option>
                           </select>
                        </div>

                        <div class="col-md-3 col-lg-2 col-sm-4 p-1">
                            <button class="btn btn-primary w-100 text-nowrap" data-bs-target="#complaintsFormModal" data-bs-toggle="modal">
                                New Complaint
                            </button>
                        </div>
                    </div>
                        
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Complaint</th>
                                    <th class="text-center">Date Filed</th>
                                    <th class="text-center">Hearing Schedule</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="complaintsList">

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end" id="complaintsLinks"></div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="complaintsFormModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="complaintsForm">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <b>Complainants</b>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th class="text-end">
                                            <button type="button" class="btn btn-sm btn-success" id="addComplainantBtn">
                                                <span class="fas fa-user-plus"></span>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="complainantsList">
                                    
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <b>Defendants</b>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th class="text-end">
                                            <button type="button" class="btn btn-sm btn-danger" id="addDefendantBtn">
                                                <span class="fas fa-user-plus"></span>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="defendantsList">

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="p-1">
                            <label for="complaints"><b>Complaints</b></label> <small><i>Explain the details of your complaint.</i></small>
                            <textarea name="complaints" id="complaints" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="row p-0 m-0">
                            <div class="col-md-5 p-1">
                                <label for="dateFiled">Date Filed</label>
                                <input type="date" name="dateFiled" id="dateFiled" class="form-control">
                            </div>
                            <div class="col-md-7 p-1">
                                <label for="hearingSchedule">Hearing Schedule</label>
                                <input  type="datetime-local" name="hearingSchedule" id="hearingSchedule" class="form-control date-input">
                            </div>
                        </div>

                        <input type="text" class="d-none" name="id" id="id">
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            <span class="fas fa-save"></span> Save New Complaint
                        </button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="complaintsPreviewModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
    
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <b>Complainants</b>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="complainantsListPreview">
                                
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <b>Defendants</b>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="defendantsListPreview">

                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="p-1">
                        <label for="complaintsPreview"><b>Complaints</b></label> <small><i>Details of complaint.</i></small>
                        <div id="complaintsPreview"></div>
                    </div>
                    <br>
                    <div class="row p-0 m-0">
                        <div class="col-md-5 p-1">
                            <label for="dateFiledPreview"><b>Date Filed</b></label>
                            <div id="dateFiledPreview"></div>
                        </div>
                        <div class="col-md-7 p-1">
                            <label for="hearingSchedulePreview"><b>Hearing Schedule</b></label>
                            <div id="hearingSchedulePreview"></div>
                        </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
           
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="selectCitizenModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5">
                        Select a Citizen
                    </h5>
                    <button class="btn btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-block w-100">
                        <form id="searchCitizenForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchCitizen" id="searchCitizen" placeholder="Search">
                                <button class="btn btn-primary input-group-text" type="submit" id="searchCitizenBtn">
                                    <span class="fas fa-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <!-- <th class="text-nowrap">Year</th> -->
                                    <!-- <th class="text-nowrap">Qtr</th> -->
                                    <th class="text-nowrap">Purok</th>
                                    <th class="text-nowrap">Last Name</th>
                                    <th class="text-nowrap">First Name</th>
                                    <th class="text-nowrap">Middle Name</th>
                                    <th>Name Extension</th>
                                    <th>Birt Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                </tr>
                            </thead>
                            <tbody id="citizensList"></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end" id="citizensLinks"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="selectCitizenBtn">
                        Select
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setScheduleFormModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="setScheduleForm">
                    <div class="modal-header">
                        <h5>Set Schedule</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-2">
                            <div class="form-floating">
                                <input type="datetime-local" name="schedule_in" id="schedule_in" class="form-control" placeholder="Schedule">
                                <label for="schedule">Schedule</label>
                            </div>
                        </div>
                        <input type="hidden" id="idToUpdate" name="idToUpdate">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">
                            <span class="fas fa-ban"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setStatusFormModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form id="setStatusForm">
                    <div class="modal-header">
                        <h5>Set Status</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-2">
                            <div class="form-floating">
                                <select name="status" id="status" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="Case Pending">Case Pending</option>
                                    <option value="Settled">Settled</option>
                                    <option value="Under Intervention Program">Under Intervention Program</option>
                                    <option value="Filed in the Court">Filed in the Court</option>
                                    <option value="Under Investigation">Under Investigation</option>
                                    <option value="Referred to Other Agencies">Referred to Other Agencies</option>
                                </select>
                                <label for="schedule">Status</label>
                            </div>
                        </div>
                        <input type="hidden" id="idToUpdateStatus" name="idToUpdateStatus">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <span class="fas fa-save"></span> Save
                        </button>
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">
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
    <script src="Views/js/complaints.js<?php echo("?v=" . time() . uniqid()); ?>"></script>
    <script>

$(document).ready(function() {
    // Get today's date
    let currentDate = new Date();
    
    // Calculate the minimum and maximum allowed dates (1 week before and after current date)
    let minDate = new Date(currentDate);
    minDate.setDate(currentDate.getDate() - 0); // Subtract 7 days for minDate
    
    let maxDate = new Date(currentDate);
    maxDate.setDate(currentDate.getDate() + 365); // Add 7 days for maxDate
    
    // Format dates as 'YYYY-MM-DD'
    let minDateFormatted = minDate.toISOString().split('T')[0];
    let maxDateFormatted = maxDate.toISOString().split('T')[0];
    
    // Apply min and max date to all inputs with the class 'date-input'
    $('.date-input').each(function() {
        $(this).attr('min', minDateFormatted);
        $(this).attr('max', maxDateFormatted);
    });

    // Change event to alert if the selected date is outside the range
    $('.date-input').on('change', function() {
        let selectedDate = $(this).val();
        
        // Check if the selected date is within the min/max range
        if (selectedDate < minDateFormatted || selectedDate > maxDateFormatted) {
            alert("The Date Must Be Greater Than Current Date.");
            $(this).val(''); // Clear the input if the date is out of range
        }
    });
});
    </script>
</body>
</html>