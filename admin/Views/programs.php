<!DOCTYPE html>
<html lang="en">
<head>
    
<?php 
    require_once 'templates/head.php';
    ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
</head>
<body class="d-flex w-100">

    <?php 
        include_once 'Views/templates/sidebar.php';
    ?>

    <div class="container-fluid p-0 body_container">

        <?php include_once "Views/templates/header.php" ?>

        
        <div class="container w-100 py-5">
        
            <h3 class="w-100">
                <span class="fas fa-uset-times"></span> Programs
            </h3>

            <div class="row p-0 m-0">
                <div class="col-lg-8 m-0 p-2">

                    <div class="card pop_in_on_scroll">

                        <div class="card-header p-2">
                            <h4 class="card-title">
                                List of Programs Table
                            </h4>
                        </div>

                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table id="example" class="table table-responsive table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Program Name</th>
                                            <th class="text-center">Program Description</th>
                                            <th class="text-center">Members</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php   $con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
                                                $sql = "";
                                                $query = $con->query("SELECT * FROM `programs` ");
                                                $i=0;
                                                while ($row = $query->fetch_array()) {
                                                    $i++;
                                                
                                                
                                                                    $count = $con->query("SELECT *
                                              FROM `citizens` c
                                              INNER JOIN `households` h ON c.houseHoldId = h.id
                                              INNER JOIN `program_mem` pm ON pm.ct_id = c.id
                                              WHERE pm.program_id = '$row[0]'");
                                                $cnrow = $count->num_rows;
                                                
                                         ?>
                                         <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row['program_name'] ?></td>
                                            <td><?php echo $row['program_desc'] ?></td>
                                            <td><?php echo $cnrow ?></td>
                                            <td><?php echo ($row['program_status'] <1)? 'Active':'Inactive' ?></td>
                                            <td style="display: flex;">
                                                <button class="btn btn-sm text-info editProgrambtn"
                                                    data-program_id="<?php echo $row[0] ?>"
                                                    data-program_name="<?php echo $row['program_name'] ?>"
                                                    data-program_desc="<?php echo $row['program_desc'] ?>"
                                                    data-program_status="<?php echo $row['program_status'] ?>"
                                                 ><span class="fas fa-eye"></span></button>
                                                 <button class="btn btn-sm text-info add_prog_personbtn"
                                                    data-program_id="<?php echo $row[0] ?>"
                                                 ><span class="fas fa-user-plus"></span></button>
                                                 <button class="btn btn-sm text-info delete_program"
                                                    data-program_id="<?php echo $row[0] ?>"
                                                 ><span class="fas fa-trash"></span></button>
                                            </td>
                                         </tr>
                                     <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end" id="violatorsLinks"></div>
                        </div>

                    </div>

                </div>




                <div class="col-lg-4 m-0 p-2">
                    <form id="new_program">
                        <div class="card pop_in_on_scroll">
                        <div class="card-header">
                            <strong>New Program</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <small>Program Title:</small>
                                <input type="text" required class="form-control" name="program_title" placeholder="Ex. TUPAD" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <small>Program Description:</small>
                                <textarea required name="program_desc" class="form-control" placeholder="Ex. TUPAD is a bla bla bla" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary bnt-md float-right">Add New</button>
                        </div>
                        
                    </div>
                    </form>
                    
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Program Beneficiary</h4>
                        </div>
                        <div class="card-body" id="the_table">
                            <table id="example2" class="table table-responsive table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Beneficiary Name</th>  
                                        <th>Birth Date</th>
                                        <th>Age</th>
                                        <th>Purok</th>
                                        <th></th>  
                                    </tr>
                                </thead>
                                <tbody id="program_member_list">
                                      <?php 
                                      if (isset($_GET['program_id'])) {
                                      extract($_GET);
                                    $sql1 = "SELECT * 
                                     FROM `citizens` c
                                     INNER JOIN `households` h ON c.houseHoldId = h.id
                                     INNER JOIN `program_mem` pm ON pm.ct_id = c.id
                                     WHERE pm.program_id = '$program_id'";
                                    $query1 = $con->query($sql1);
                                    $i=0;
                                    while ($row1 = $query1->fetch_array()) {
                                        $i++;
                                 ?>
                                  <tr>
                                    <td>
                                        <button class="btn btn-sm text-info addThisPerson"
                                                    data-program_id="<?php echo $program_id ?>"
                                                     data-ct_id="<?php echo $row1[0] ?>"
                                                 ><span class="fas fa-user-plus"></span></button>
                                    </td>
                                     <td><?php echo $i++; ?></td>
                                     <td><?php echo $row1['lastName'].' '.$row1['firstName'].' '.$row1['middleName'] ?></td>
                                     <td><?php echo date("F d, Y", strtotime($row1['birthDate'])) ?></td>
                                     <td><?php echo date('Y') - date("Y", strtotime($row1['birthDate'])); ?> y/o</td>
                                     <td><?php echo $row1['purok']?></td>
                                     <td>
                                         <button class="btn btn-sm text-info delete_progmem"
                                                    data-program_id="<?php echo $row1['progmem_id'] ?>"
                                                 ><span class="fas fa-trash"></span></button>
                                     </td>

                                 </tr>

                             <?php  } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <form method="GET" action="#">
                        <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Table Filter
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <small>Program Id:</small>
                                <select name="program_id" class="form-select">
                                    <option value="" disabled selected>Select Program</option>
                                    <?php 
                                    $query = $con->query("SELECT * FROM `programs` ");
                                    while ($row2 = $query->fetch_assoc()) { ?>
                                        <option value="<?php echo $row2['program_id'] ?>"><?php echo $row2['program_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-md"> Generate</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>


    </div>



    <div class="modal fade" id="editProgram">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editProgramform">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Program</h4>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="program_id" id="program_id">
                          <div class="form-group mt-2">
                                <small class="mb-1">Program Title:</small>
                                <input type="text" required class="form-control" name="program_title" id="program_title" placeholder="Ex. TUPAD" autocomplete="off">
                            </div>
                            <div class="form-group mt-2">
                                <small class="mb-1">Program Description:</small>
                                <textarea required name="program_desc" id="program_desc" class="form-control" placeholder="Ex. TUPAD is a bla bla bla" autocomplete="off"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <small class="mb-1">Status: </small>
                                <select name="program_status" id="program_status" class="form-select">
                                    <option value="" disabled selected>Program Status</option>
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            Update
                        </button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>
                    </form>
            </div>
        </div>
    </div>


<div class="modal fade" id="add_prog_person">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="thecontenthere">
            </div>
        </div>
    </div>
    



<div class="modal fade" id="msgModal">
    <div class="modal-dialog modal-sm modal-dialog-centered" id="msgModalDialog">
        <div class="modal-content" id="msgModalContent">
            
            <div class="modal-body">
                <div id="msgModalMsg" class=""></div>
                <hr>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm text-white" id="okMsgBtn" type="button" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentDate = new Date('<?php echo(date('Y-m-d')); ?>')
</script>

<script src="<?php echo($extLink); ?>Views/js/style.js<?php echo "?v=" .time() . uniqid(); ?>"></script>





<!-- Ensure jQuery is loaded before DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 Integration JS (optional) -->
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 CSS -->
<!-- jQuery -->


      <script>
    $(document).ready(function() {
      // Initialize DataTable with search and filtering options
      $('#example').DataTable({
        "paging": true,           // Enables pagination
        "searching": true,        // Enables search bar
        "ordering": true,         // Enables column ordering
        "info": true,             // Displays information about the table
        "lengthChange": true,     // Allows changing the number of rows per page
        "columnDefs": [{
          "targets": [ 0, 1, 2 ], // Apply filters to specific columns (optional)
          "searchable": true
        }]
      });
      $('#example1').DataTable({
        "paging": true,           // Enables pagination
        "searching": true,        // Enables search bar
        "ordering": true,         // Enables column ordering
        "info": true,             // Displays information about the table
        "lengthChange": true,     // Allows changing the number of rows per page
        "columnDefs": [{
          "targets": [ 0, 1, 2 ], // Apply filters to specific columns (optional)
          "searchable": true
        }]
      });
      $('#example2').DataTable({
        "paging": true,           // Enables pagination
        "searching": true,        // Enables search bar
        "ordering": true,         // Enables column ordering
        "info": true,             // Displays information about the table
        "lengthChange": true,     // Allows changing the number of rows per page
        "columnDefs": [{
          "targets": [ 0, 1, 2 ], // Apply filters to specific columns (optional)
          "searchable": true
        }]
      });
    });


    $('#new_program').submit(function(e){
        e.preventDefault();
         const form_data = new FormData(this);
                     form_data.append('new_program', 'true');
                      $.ajax({  url:'submits/queries.php',
                                type: "POST",
                                data: form_data,
                                contentType: false,
                                cache: false,
                                processData:false,
                                success: function(data){
                                    console.log(data);
                                    alert("New Program Added");
                                    $('#new_program')[0].reset();
                                    setInterval(function() {
                                        window.location.reload();
                                    }, 2000);

                                }
                             });
    })
    $('.editProgrambtn').click(function() {
        $('#editProgramform')[0].reset();
        $('#program_id').val($(this).attr('data-program_id'));
        $('#program_title').val($(this).attr('data-program_name'));
        $('#program_desc').val($(this).attr('data-program_desc'));
        $('#program_status').val($(this).attr('data-program_status'));
        $('#editProgram').modal('show');  // Correct way to show the modal in Bootstrap

    });

$('.add_prog_personbtn').click(function() { 
    var Program_id = $(this).attr('data-program_id');
    
    $.ajax({
        type: 'GET',
        url: 'submits/add_prog_person.php',
        data: {
            program_id: Program_id
        },
        dataType: 'html'
    }).done(function(data) {
        $('#thecontenthere').html("");
        $('#thecontenthere').html(data);
        $('#add_prog_person').modal('show');
        
        // Click handler for the "Add This Person" button
        $('.addThisPerson').click(function() {
            var ProgId = $(this).attr('data-program_id');
            var Ct_id = $(this).attr('data-ct_id');
            var $row = $(this).closest('tr'); // Store the reference to the parent <tr>
            
            $.ajax({
                type: 'GET',
                url: 'submits/add_prog_mem.php',
                data: {
                    prog_id: ProgId,
                    ct_id: Ct_id
                },
                dataType: 'html'
            }).done(function(data) {
                // Remove the table row after successful Ajax request
                $row.remove();
            });
        });
    });
});


    $('#editProgramform').submit(function(e){
         e.preventDefault();
         const form_data = new FormData(this);
         form_data.append('editProgramform', 'true');
          $.ajax({  url:'submits/queries.php',
                    type: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        console.log(data);
                        alert("Program Updated");
                        setInterval(function() {
                            window.location.reload();
                        }, 2000);
                    }
                 });
    })
    
    
      $('.delete_program').click(function(){
       Program_id = $(this).attr('data-program_id');
       if (confirm("Delete this program?")) {
             $.ajax({
                type: 'GET',
                url: 'submits/queries.php',
                data: {
                    program_id: Program_id,
                    delete_program:'true'
                },
                dataType: 'html'
            }).done(function(data) {
            });
             window.location.reload();
        } else {

        }
        })
        $('.delete_progmem').click(function(){
       Program_id = $(this).attr('data-program_id');
       if (confirm("Delete this Beneficiary?")) {
             $.ajax({
                type: 'GET',
                url: 'submits/queries.php',
                data: {
                    progmem_id: Program_id,
                    delete_progmem:'true'
                },
                dataType: 'html'
            }).done(function(data) {
            });
             window.location.reload();
        } else {

        }
        })
  </script>

</body>
</html>