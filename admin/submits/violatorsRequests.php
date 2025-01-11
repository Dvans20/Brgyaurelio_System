<?php 


require_once "../Controllers/ViolatorsController.php";


$action = $_GET['action'];

if ($action === "saveViolator") {
    ViolatorsController::saveViolator($_POST);
}
else if ($action === "getViolators")
{
    ViolatorsController::getViolators($_GET);
}
else if ($action === "getViolator")
{
    ViolatorsController::getViolator($_GET['id']);
}
else if ($action === "updateStatusViolator") 
{
    ViolatorsController::updateStatusViolator($_POST);
}
else if ($action === "getViolatorsWithpay")
{
    ViolatorsController::getViolatorsWithpay($_GET);
}
