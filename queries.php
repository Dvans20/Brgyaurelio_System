<?php 
$conx = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");
$conx -> set_charset("utf8"); 
extract($_GET);
if (isset($updatedata)) {
   echo $sql = "UPDATE `$table` SET `$column`='$value' WHERE `$condition`='$identifier'";
    $query = $conx->query($sql);
}
 ?>