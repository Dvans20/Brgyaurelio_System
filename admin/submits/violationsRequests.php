<?php 

require_once '../Controllers/ViolationsController.php';

$action = $_GET['action'];

if ($action === "saveViolation")
{
    if (empty($_POST['id'])) {
        ViolationsController::saveViolation($_POST);
    } else { 
        ViolationsController::updateViolation($_POST);
    }
    
}
else if ($action === "getViolations")
{
    ViolationsController::getViolations();
}
else if ($action === "getViolation")
{
    ViolationsController::getViolation($_GET['id']);
}
else if ($action == "deleteViolation") 
{
    ViolationsController::deleteViolation($_POST['id']);
}