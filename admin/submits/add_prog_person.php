 <?php 
$con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");

extract($_POST);
extract($_GET); 
  ?>

                    <div class="modal-header">
                        <h4 class="modal-title">Add Program Beneficiary</h4>
                        <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <table id="example1" class="table table-responsive table-striped table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Birthdate</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql1 = "SELECT * 
                                        FROM `citizens` c
                                        WHERE NOT EXISTS (
                                        SELECT 1
                                        FROM `program_mem` pm
                                        WHERE pm.`ct_id` = c.`id`
                                        AND pm.`program_id` = '$program_id'
                                        )";
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

                                 </tr>

                             <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>