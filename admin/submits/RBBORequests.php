<?php 

require_once "../Controllers/RBBOController.php";


$action = $_GET['action'];


if ($action == "saveRBBO") 
{
    RBBOController::saveRBBO($_POST);
}
else if ($action == "getRBBOByKey") 
{
    RBBOController::getRBBOByKey($_POST);
}
else if ($action == "getRBBO")
{
    RBBOController::getRBBO($_GET);
}
else if ($action == "generateBusNo")
{
    RBBOController::generateBusNo();
}
else if ($action == "approveRBBO")
{
    RBBOController::approveRBBO($_POST);
}
else if ($action == "declineRBBO")
{
    RBBOController::declineRBBO($_POST);
}
else if ($action == "deleteRBBO")
{
    RBBOController::deleteRBBO($_POST['id']);
}