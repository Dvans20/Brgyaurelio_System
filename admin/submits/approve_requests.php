<?php
$con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
extract($_GET);

$sql = "UPDATE `requests` SET `status`='1' WHERE `id`='$request_id'";
$query = $con->query($sql);
?>