<?php 
include '../Utilities/Database.php';
extract($_GET);
 $sql1 = "SELECT * 
 FROM `citizens` c
 INNER JOIN `households` h ON c.houseHoldId = h.id
 INNER JOIN `program_mem` pm ON pm.ct_id = c.id
 WHERE pm.program_id = '$program_id'";
$query1 = $con->query($sql1);
$i=0;
?>
<div class="modal-content">
        <div class="modal-header">
            <h5>Program beneficiary</h5>
            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Beneficiary Name</th>  
                        <th>Birth Date</th>
                        <th>Age</th>
                        <th>Purok</th>
                    </tr>
                </thead>
            <?php while ($row1 = $query1->fetch_array()) {$i++;?>
            <tr>
                                     <td><?php echo $i++; ?></td>
                                     <td><?php echo $row1['lastName'].' '.$row1['firstName'].' '.$row1['middleName'] ?></td>
                                     <td><?php echo date("F d, Y", strtotime($row1['birthDate'])) ?></td>
                                     <td><?php echo date('Y') - date("Y", strtotime($row1['birthDate'])); ?> y/o</td>
                                     <td><?php echo $row1['purok']?></td>

                                 </tr>
            <?php } ?>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary custom-btn" data-bs-dismiss="modal" type="button">
                Close
            </button>
        </div>
</div>