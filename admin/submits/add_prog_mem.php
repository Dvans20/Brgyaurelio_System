<?php 
$con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
extract($_POST);
extract($_GET); // Fixed typo from "extrat" to "extract"

$sql  = "INSERT INTO `program_mem`(`ct_id`, `program_id`, `program_mem_status`) VALUES ('$ct_id','$prog_id','0')";
$query = $con->query($sql);

$check = $con->query("SELECT * FROM `programs` WHERE `program_id`='$prog_id'");
$crow = $check->fetch_array();
$mem = $crow['program_members'] + 1;

$sql1 = "UPDATE `programs` SET `program_members`='$mem' WHERE `program_id`='$prog_id'";
$query1 = $con->query($sql1);

if ($query) {
	echo "1";
}else{
	echo "0";

}


 ?>